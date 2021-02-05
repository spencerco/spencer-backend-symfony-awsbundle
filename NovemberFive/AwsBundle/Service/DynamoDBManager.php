<?php

namespace NovemberFive\AwsBundle\Service;

use NovemberFive\AwsBundle\Service\Traits\ClientAwareTrait;

/**
 * Class DynamoDBManager
 * @package NovemberFive\AwsBundle\Service
 */
class DynamoDBManager implements ClientAwareInterface, DynamoDBManagerInterface
{
    use ClientAwareTrait;

    /** @var AWSManagerInterface  */
    protected $awsManager;

    public function __construct(AWSManagerInterface $awsManager)
    {
        $this->awsManager = $awsManager;
    }
}