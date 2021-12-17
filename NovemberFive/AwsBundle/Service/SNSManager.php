<?php
/**
 * This file is part of lib_serverside_awsbundle.
 *
 * (c) 2016 November Five BVBA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NovemberFive\AwsBundle\Service;

use NovemberFive\AwsBundle\Service\Traits\ClientAwareTrait;
use NovemberFive\AwsBundle\Model\Subscribe;
use Aws\Sns\Exception\SnsException;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * SNS Manager as helper for communication with the SNS Client
 *
 * Class SNSManager
 * @package NovemberFive\AwsBundle\Service
 */
class SNSManager implements ClientAwareInterface, SNSManagerInterface
{
    use ClientAwareTrait;
    use LoggerAwareTrait;

    /**
     * @var AWSManagerInterface
     */
    protected $awsManager;

    /**
     * SnsManager constructor.
     *
     * @param AWSManagerInterface $awsManager
     * @param LoggerInterface     $logger
     */
    public function __construct(AWSManagerInterface $awsManager, LoggerInterface $logger)
    {
        $this->awsManager = $awsManager;
        $this->logger     = new NullLogger();
    }

    /**
     * Create platform application endpoint
     *
     * @param string $applicationArn
     * @param string $token
     * @param array  $customerUserData
     * @param array  $options
     *
     * @return null
     */
    public function createPlatformEndpoint($applicationArn, $token, $customerUserData, array $options = array())
    {
        $arn = null;
        try {
            $arguments = array_merge(
                array(
                    'PlatformApplicationArn' => $applicationArn,
                    'Token'                  => $token,
                    'CustomUserData'         => $customerUserData,
                ),
                $options
            );

            // Create arn on AWS
            $response = $this->client->createPlatformEndpoint($arguments);

            $arn = $response->get('EndpointArn');
        } catch (SnsException $e) {
            // Exception during the creation
            $this->logger->addError($e->getMessage().' [PlatformApplicationArn: '.$applicationArn.' ; Token: '.$token.' ; CustomerUserData: '.$customerUserData.']');

            throw $e;
        }

        // No arn created on aws
        if (!$arn) {
            $this->logger->addError(sprintf('No Endpoint ARN could be created for application %s', $applicationArn));
            throw new SnsException('No endpoint ARN could be created');
        }

        return $arn;
    }

    /**
     * Update a platform application endpoint
     *
     * @param string $applicationEndpointArn
     * @param string $token
     * @param string $customerUserData
     * @param array  $options
     *
     * @return mixed|null
     */
    public function updatePlatformEndpoint($applicationEndpointArn, $token, $customerUserData, array $options = array())
    {
        try {
            $arguments = array_merge(
                array(
                    'EndpointArn' => $applicationEndpointArn,
                    'Attributes'  => array(
                        'Token'          => $token,
                        'CustomUserData' => $customerUserData,
                        'Enabled'        => 'True',
                    ),
                ),
                $options
            );

            // Update arn on AWS
            $this->client->setEndpointAttributes($arguments);

            return true;
        } catch (SnsException $e) {
            // Exception during the creation
            $this->logger->addError($e->getMessage().' [ApplicationEndpointArn: '.$applicationEndpointArn.'.; Token: '.$token.' ; CustomerUserData: '.$customerUserData.']');

            throw $e;
        }
    }

    /**
     * Create subscription on SNS for a given topic
     *
     * @param string $applicationEndpointArn
     * @param string $topicArn
     * @param array  $options
     *
     * @return mixed|null
     */
    public function createSubscription($applicationEndpointArn, $topicArn, array $options = array())
    {
        $arn = null;

        try {
            $arguments = array_merge(
                array(
                    'Protocol' => Subscribe::PROTOCOL_APPLICATION,
                    'TopicArn' => $topicArn,
                    'Endpoint' => $applicationEndpointArn,
                ),
                $options
            );

            // Create subscription on AWS
            $response = $this->client->subscribe($arguments);

            // get arn from response
            $arn = $response->get('SubscriptionArn');

        } catch (SnsException $e) {
            $this->logger->addCritical($e->getMessage().' SNS: [Subscription topic: '.$topicArn.']');

            throw $e;
        }

        // No arn created on aws
        if (!$arn) {
            $this->logger->addError(sprintf('No Subscription ARN could be created for topic arn %s', $topicArn));
            throw new SnsException('No subscription ARN could be created');
        }

        return $arn;
    }

    /**
     * Publish message
     *
     * @param string $message
     *
     * @return bool
     */
    public function publish($message)
    {
        try {
            $response = $this->client->publish($message);

            if ($response->get('MessageId')) {
                return true;
            }

            return false;
        } catch (SnsException $e) {
            $this->logger->notice((string) $e);

            throw $e;
        }
    }


    /**
     * Lookup platform application endpoint's attributes using arn.
     *
     * @param string $applicationEndpointArn
     *
     * @return array
     */
    public function getPlatformEndpointAttributes($applicationEndpointArn)
    {
        try {
            $attributes = $this->client->getEndpointAttributes([
                'EndpointArn' => $applicationEndpointArn,
            ]);

            return $attributes->get('Attributes');
        } catch (SnsException $e) {
            $this->logger->addError($e->getMessage().' SNS: [Failed to get endpoint attributes: '.$applicationEndpointArn.']');

            throw $e;
        }
    }
}