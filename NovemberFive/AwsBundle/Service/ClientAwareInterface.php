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
 * All AWS related managers MUST implement this interface
 *
 * Interface ClientAwareInterface
 * @package NovemberFive\AwsBundle\Service
 */
interface ClientAwareInterface
{

    /**
     * @param string $client
     *
     * @return mixed
     */
    public function setClient($client);

}
