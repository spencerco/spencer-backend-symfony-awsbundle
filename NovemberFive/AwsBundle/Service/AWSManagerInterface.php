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
 * Every AWS Manager MUST implement this interface
 *
 * Class AWSManagerInterface
 * @package NovemberFive\AwsBundle\Service
 */
interface AWSManagerInterface
{

    /**
     * @param string $class
     * @param null   $version
     *
     * @return mixed
     */
    public function create($class, $version = null);

}
