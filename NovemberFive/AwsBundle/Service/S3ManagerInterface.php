<?php
/**
 * This file is part of lib_serverside_awsbundle.
 *
 * (c) 2017 November Five BVBA
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NovemberFive\AwsBundle\Service;

/**
 * Interface S3ManagerInterface
 * @package NovemberFive\AwsBundle\Service
 */
interface S3ManagerInterface
{
    /**
     * Get an object from a S3 Bucket
     *
     * @param string        $s3Bucket
     * @param string        $objectKey
     * @param null|string   $localFilename
     * @param string        $flags
     * @param array         $extraOptions
     *
     * @return \Guzzle\Service\Resource\Model|null
     */
    public function getObject($s3Bucket, $objectKey, $saveAs=null, $flags, $extraOptions=array());

    /**
     * Upload a Object to s3
     *
     * @param string $s3Bucket
     * @param string $objectKey
     * @param string $file
     * @param string $flags
     * @param array  $extraOptions
     *
     * @return mixed
     */
    public function putObject($s3Bucket, $objectKey, $file, $flags, $extraOptions=array());

}