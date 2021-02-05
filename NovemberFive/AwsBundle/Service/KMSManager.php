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
 * KMS Manager to encrypt messages with the Amazon KMS service
 *
 * Class KMSManager
 * @package NovemberFive\AwsBundle\Service
 */
class KMSManager implements ClientAwareInterface, KMSManagerInterface
{
    const KMS_CIPHERTEXTBLOB = 'CiphertextBlob';

    use ClientAwareTrait;

    /**
     * @var string
     */
    protected $kmsKey;

    /**
     * @var AWSManagerInterface
     */
    protected $awsManager;

    /**
     * KmsManager constructor.
     *
     * @param AWSManagerInterface $awsManager
     * @param string              $kmsKey
     */
    public function __construct(AWSManagerInterface $awsManager, $kmsKey = '')
    {
        $this->awsManager = $awsManager;
        $this->kmsKey     = $kmsKey;
    }

    /**
     * Encrypt a message with the KMS Service
     *
     * @param string $message
     * @param array  $options - optional options for the KMS client
     *
     * @return string
     */
    public function encrypt($message, array $options = array())
    {
        // no encryption key set, return base64 encoded message
        if ($this->kmsKey === null || $this->kmsKey === '') {
            return $message;
        }

        // merge arguments with optional options
        $arguments = array_merge(
            array(
                'KeyId'     => $this->kmsKey,
                'Plaintext' => $message,
            ),
            $options
        );

        // encrypt message with KMS
        $message = $this->client->encrypt($arguments);

        // return message
        return $message[KmsManager::KMS_CIPHERTEXTBLOB];
    }

}
