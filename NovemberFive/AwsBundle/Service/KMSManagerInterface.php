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
 * Every KMS manager MUST implement this interface
 *
 * Class KMSManagerInterface
 * @package NovemberFive\AwsBundle\Service
 */
interface KMSManagerInterface
{

    /**
     * @param string $message
     * @param array  $options
     *
     * @return string
     */
    public function encrypt($message, array $options = array());

}
