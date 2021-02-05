<?php


namespace NovemberFive\AwsBundle\Service;


use NovemberFive\AwsBundle\Service\Traits\ClientAwareTrait;

class LambdaManager implements ClientAwareInterface, LambdaManagerInterface
{
    use ClientAwareTrait;

    /**
     * @var AWSManagerInterface
     */
    protected $awsManager;

    /**
     * KmsManager constructor.
     *
     * @param AWSManagerInterface $awsManager
     */
    public function __construct(AWSManagerInterface $awsManager)
    {
        $this->awsManager = $awsManager;
    }
}