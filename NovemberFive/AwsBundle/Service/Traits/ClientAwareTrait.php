<?php
/**
 * This file is part of lib_serverside_awsbundle.
 *
 * (c) 2016 November Five BVBA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NovemberFive\AwsBundle\Service\Traits;

/**
 * Class ClientAwareTrait
 * @package NovemberFive\AwsBundle\Service\Traits
 */
trait ClientAwareTrait
{

    /**
     * @var string
     */
    protected $client;

    /**
     * Create Client
     *
     * @param string $client
     * @param string $version
     *
     * @return SqsClient|mixed
     */
    public function setClient($client, $version = null)
    {
        $this->client = $this->awsManager->create($client, $version);

        return $this->client;
    }

    /**
     * @return AwsClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

}