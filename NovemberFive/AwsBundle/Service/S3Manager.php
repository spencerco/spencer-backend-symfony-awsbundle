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

use NovemberFive\AwsBundle\Service\Traits\ClientAwareTrait;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class S3Manager
 * @package NovemberFive\AwsBundle\Service
 */
class S3Manager implements ClientAwareInterface, S3ManagerInterface
{
    const FILE_UPDATE      = 'file_update';
    const FILE_CREATE_ONLY = 'file_create_only';

    const FILE_DELETE = 'file_delete';
    const FILE_KEEP   = 'file_keep';

    use ClientAwareTrait;

    /**
     * @var AWSManagerInterface
     */
    protected $awsManager;

    /**
     * S3Manager constructor.
     *
     * @param AWSManagerInterface $awsManager
     * @param string              $kmsKey
     */
    public function __construct(AWSManagerInterface $awsManager)
    {
        $this->awsManager = $awsManager;
    }

    /**
     * Get an object from a S3 Bucket
     *
     * @param string      $s3Bucket
     * @param string      $objectKey
     * @param null|string $localFilename
     * @param string      $flags
     * @param array       $extraOptions
     *
     * @return \Guzzle\Service\Resource\Model|null
     */
    public function getObject($s3Bucket, $objectKey, $saveAs = null, $flags = self::FILE_UPDATE, $extraOptions = array())
    {
        // Default options
        $options = array(
            'Bucket' => $s3Bucket, // bucket
            'Key'    => $objectKey, // objectKey
        );

        $options = array_merge($options, $extraOptions); // Merge options and extra options

        if ($saveAs !== null) { // if the file needs to be saved locally
            if (file_exists($saveAs)) { // remove the file if it exists
                if ($flags !== self::FILE_UPDATE) {
                    throw new FileException(sprintf('File: %s already exists on the filesystem', $saveAs));
                }
                unlink($saveAs); // removing the localfile
            }

            $options['SaveAs'] = $saveAs; // appending to the options
        }

        return $this->client->getObject($options);
    }

    /**
     * Upload a Object to s3
     *
     * @param string $s3Bucket
     * @param string $objectKey
     * @param string $file
     * @param array  $extraOptions
     *
     * @return mixed
     */
    public function putObject($s3Bucket, $objectKey, $file, $flags = self::FILE_KEEP, $extraOptions = array())
    {
        // Default options
        $options = array(
            'Bucket'     => $s3Bucket,
            'Key'        => $objectKey,
            'SourceFile' => $file,
        );

        $options = array_merge($options, $extraOptions); // merge the extra options

        $result = $this->client->putObject( // create the remote s3 object
            $options
        );

        if ($flags === self::FILE_DELETE) { // if flags == delete, remove local file
            unlink($file);
        }

        return $result;
    }
}