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

/**
 * Every SQSManager MUST implement this interface
 *
 * Class SQSManagerInterface
 * @package NovemberFive\AwsBundle\Service
 */
interface SQSManagerInterface
{

    /**
     * Get queue url from SQS Service
     *
     * @param string $queue
     * @param array  $options
     *
     * @return mixed|null
     */
    public function getQueueUrl($queue, array $options = array());

    /**
     * Send message to SQS
     *
     * @param string $message
     * @param string $queue
     * @param array  $options
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function sendMessage($message, $queue, array $options = array());

    /**
     * Send message to SQS
     *
     * @param string $message
     * @param string $queue
     * @param array  $options
     *
     * @return \Guzzle\Service\Resource\Model
     */
    public function sendEncryptedMessage($message, $queue, array $options = array());

}
