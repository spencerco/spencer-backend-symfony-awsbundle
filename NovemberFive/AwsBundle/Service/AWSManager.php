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
 * Class AWSManager
 * @package NovemberFive\AwsBundle\Service
 */
class AWSManager implements AWSManagerInterface
{
    /**
     * @var string
     */
    protected $region;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $proxy;

    /**
     * @var string
     */
    protected $version;

    /**
     * AWSManager constructor.
     *
     * @param null $key
     * @param null $secret
     * @param null $region
     * @param null $proxy
     */
    public function __construct($key = null, $secret = null, $region = null, $proxy = null)
    {
        $this->key    = $key;
        $this->secret = $secret;
        $this->region = $region;
        $this->proxy  = $proxy;
    }

    /**
     * @param string $class
     *
     * @return mixed
     */
    public function create($class, $version = null)
    {
        $this->version = $version;

        $options = array();
        // set region
        $options = $this->configureRegion($options);
        // set credentials
        $options = $this->configureCredentials($options);
        // configure proxy
        $options = $this->configureProxy($options);
        // configure version
        $options = $this->configureVersion($options);

        return $class::factory($options);
    }

    /**
     * @param $options
     *
     * @return mixed
     */
    private function configureCredentials($options)
    {
        // only add credentials if given in the config
        if ($this->hasCredentials()) {
            $options['credentials']           = array();
            $options['credentials']['key']    = $this->key;
            $options['credentials']['secret'] = $this->secret;
        }

        return $options;
    }

    /**
     * @param $options
     *
     * @return mixed
     */
    private function configureProxy($options)
    {
        // add proxy if given in configuration
        if ($this->proxy !== null) {
            $options['request.options'] = array('proxy' => $this->proxy);
        }

        return $options;
    }

    /**
     * @param $options
     *
     * @return mixed
     */
    private function configureVersion($options)
    {
        // add proxy if given in configuration
        if ($this->version !== null) {
            $options['version'] = $this->version;
        }

        return $options;
    }

    /**
     * @param $options
     *
     * @return mixed
     */
    private function configureRegion($options)
    {
        $options['region'] = $this->region;

        return $options;
    }

    /**
     * @return bool
     */
    private function hasCredentials()
    {
        return $this->key !== null && $this->secret !== null;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param string $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

}
