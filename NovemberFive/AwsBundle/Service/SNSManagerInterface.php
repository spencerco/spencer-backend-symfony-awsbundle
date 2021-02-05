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
 * Every SNS Manager MUST implement this interface
 *
 * Interface SNSManagerInterface
 * @package NovemberFive\SnsBundle\Service
 */
interface SNSManagerInterface
{

    /**
     * @param string $applicationArn
     * @param string $token
     * @param string $customerUserData
     *
     * @return mixed|null
     */
    public function createPlatformEndpoint($applicationArn, $token, $customerUserData);

    /**
     * @param string $applicationEndpointArn
     * @param string $token
     * @param string $customerUserData
     *
     * @return mixed|null
     */
    public function updatePlatformEndpoint($applicationEndpointArn, $token, $customerUserData);

    /**
     * @param string $applicationEndpointArn
     * @param string $topicArn
     *
     * @return mixed|null
     */
    public function createSubscription($applicationEndpointArn, $topicArn);

    /**
     * @param string $message
     *
     * @return bool
     */
    public function publish($message);

    /**
     * @param string $applicationEndpointArn
     *
     * @return array
     */
    public function getPlatformEndpointAttributes($applicationEndpointArn);

}
