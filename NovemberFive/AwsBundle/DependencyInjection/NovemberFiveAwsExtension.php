<?php
/**
 * This file is part of lib_serverside_awsbundle.
 *
 * (c) 2016 November Five BVBA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NovemberFive\AwsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Yaml\Yaml;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NovemberFiveAwsExtension extends Extension implements PrependExtensionInterface
{
    const DEFAULT_REGION = 'eu-west-1';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');


        // set default region if aws is not configured at all
        $container->getDefinition('november_five_aws.aws_manager')->replaceArgument(2, self::DEFAULT_REGION);

        # AWS
        if (array_key_exists('aws', $config)) {
            $awsConfig = $config['aws'];
            $this->addAccessKey($container, $awsConfig);
            $this->addSecretKey($container, $awsConfig);
            $this->addRegion($container, $awsConfig);
            $this->addProxy($container, $awsConfig);
        }

        # KMS
        if (array_key_exists('kms', $config)) {
            $kmsConfig = $config['kms'];
            $container->getDefinition('november_five_aws.kms_manager')->replaceArgument(1, $kmsConfig['secret']);
        }

        $this->createVersionParameters($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param                  $awsConfig
     */
    protected function addRegion(ContainerBuilder $container, $awsConfig)
    {
        // set region if given
        if (array_key_exists('region', $awsConfig)) {
            $container->getDefinition('november_five_aws.aws_manager')->replaceArgument(2, $awsConfig['region']);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param                  $config
     */
    protected function createVersionParameters(ContainerBuilder $container, $config)
    {
        // set region if given
        if (array_key_exists('kms', $config) && array_key_exists('version', $config['kms'])) {
            $container->setParameter('november_five_aws.kms_version', $config['kms']['version']);
        }

        // set region if given
        if (array_key_exists('sqs', $config) && array_key_exists('version', $config['sqs'])) {
            $container->setParameter('november_five_aws.sqs_version', $config['sqs']['version']);
        }

        // set region if given
        if (array_key_exists('sns', $config) && array_key_exists('version', $config['sns'])) {
            $container->setParameter('november_five_aws.sns_version', $config['sns']['version']);
        }

        // set region if given
        if (array_key_exists('s3', $config) && array_key_exists('version', $config['s3'])) {
            $container->setParameter('november_five_aws.s3_version', $config['s3']['version']);
        }

        if (array_key_exists('dynamodb', $config) && array_key_exists('version', $config['dynamodb'])) {
            $container->setParameter('november_five_aws.dynamodb_version', $config['dynamodb']['version']);
        }

        if (array_key_exists('lambda', $config) && array_key_exists('version', $config['lambda'])) {
            $container->setParameter('november_five_aws.lambda_version', $config['lambda']['version']);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param                  $awsConfig
     */
    protected function addProxy(ContainerBuilder $container, $awsConfig)
    {
        // add proxy is proxy is set
        if (array_key_exists('proxy', $awsConfig)) {
            $container->getDefinition('november_five_aws.aws_manager')->replaceArgument(3, $awsConfig['proxy']);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param                  $awsConfig
     */
    protected function addAccessKey(ContainerBuilder $container, $awsConfig)
    {
        // set access key if given
        if (array_key_exists('access_key', $awsConfig)) {
            $container->getDefinition('november_five_aws.aws_manager')->replaceArgument(0, $awsConfig['access_key']);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param                  $awsConfig
     */
    protected function addSecretKey(ContainerBuilder $container, $awsConfig)
    {
        // set secret key if given
        if (array_key_exists('secret_key', $awsConfig)) {
            $container->getDefinition('november_five_aws.aws_manager')->replaceArgument(1, $awsConfig['secret_key']);
        }
    }

    /**
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = array();

        // check if the config file exists
        if (is_file($file = __DIR__.'/../Resources/config/config.yml')) {
            // parse the Yaml file
            $parser      = new Yaml();
            $parseMethod = 'parse';

            // BC change for symfony < 3
            if (method_exists($parser, 'parseFile')) {
                $parseMethod = 'parseFile';
            }

            // parse the Yaml file
            $config = $parser->$parseMethod(realpath($file));
        }

        // prepend default config for BC
        $container->prependExtensionConfig('november_five_aws', $config);
    }


}