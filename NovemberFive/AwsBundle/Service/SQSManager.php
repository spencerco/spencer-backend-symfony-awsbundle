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

/**
 * SQS Manager for easier handling SQS messages
 *
 * Class SQSManager
 * @package NovemberFive\AwsBundle\Service
 */
class SQSManager implements ClientAwareInterface, SQSManagerInterface
{
    const SQS_QUEUEURL = 'QueueUrl';

    use ClientAwareTrait;

    /**
     * @var AWSManagerInterface
     */
    protected $awsManager;

    /**
     * @var KmsManager
     */
    protected $kmsManager;

    /**
     * @param AWSManagerInterface $awsManager
     * @param KmsManager          $kmsManager
     */
    public function __construct(AWSManagerInterface $awsManager, KmsManager $kmsManager)
    {
        $this->awsManager = $awsManager;
        $this->kmsManager = $kmsManager;
    }

    /**
     * Get queue url from SQS Service
     *
     * @param string $queue
     * @param array  $options - optional arguments for the SQS client
     *
     * @return mixed|null
     */
    public function getQueueUrl($queue, array $options = array())
    {
        // merge arguments
        $arguments = array_merge(array('QueueName' => $queue), $options);

        // get sqs url
        $queueUrl = $this->client->getQueueUrl($arguments);

        // return sqs queue url
        return $queueUrl->get(SqsManager::SQS_QUEUEURL);
    }

    /**
     * Prepare message for SQS
     *
     * @param string $message
     * @param string $queue
     * @param array  $options - optional arguments for the SQS client
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function sendMessage($message, $queue, array $options = array())
    {
        return $this->send($this->getQueueUrl($queue), base64_encode($message), $options);
    }

    /**
     * Prepare encrypted message for SQS
     *
     * @param string $message
     * @param string $queue
     * @param array  $options - optional arguments for the SQS client
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function sendEncryptedMessage($message, $queue, array $options = array())
    {
        return $this->send($this->getQueueUrl($queue), base64_encode($this->kmsManager->encrypt($message)), $options);
    }

    /**
     * Send message to SQS
     *
     * @param string $queueUrl
     * @param string $message
     * @param array  $options - optional arguments for the SQS client
     *
     * @return mixed
     */
    private function send($queueUrl, $message, array $options = array())
    {
        $arguments = array_merge(
            array(
                'QueueUrl'    => $queueUrl,
                'MessageBody' => $message, // encrypt message if needed
            ),
            $options
        );

        // send message
        return $this->client->sendMessage($arguments);
    }

}
