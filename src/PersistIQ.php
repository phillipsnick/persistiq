<?php

namespace PersistIQ;

use Curl\Curl;
use PersistIQ\Resource\Campaigns;
use PersistIQ\Resource\Leads;
use PersistIQ\Resource\Users;

class PersistIQ
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $version;

    /** @var string */
    protected $host;

    /** @var Curl */
    protected $curl;

    /**
     * @param string $apiKey
     * @param string $version
     * @param string $host
     */
    public function __construct($apiKey, $version = 'v1', $host = 'https://api.persistiq.com')
    {
        $this->apiKey = $apiKey;
        $this->version = $version;
        $this->host = $host;

        $this->curl = new Curl($host . '/' . $version . '/');
        $this->curl->setHeader('x-api-key', $apiKey);
        $this->curl->setHeader('Content-Type', 'application/json');
    }

    /** @return Curl */
    public function getCurl()
    {
        return $this->curl;
    }

    /**
     * @param null|string $resource
     * @return string
     */
    public function getUrl($resource = null)
    {
        $url = $this->host . '/' . $this->version . '/';

        if ($resource) {
            $url .= $resource;
        }

        return $url;
    }

    /** @return Users */
    public function users()
    {
        return new Users($this);
    }

    /** @return Leads */
    public function leads()
    {
        return new Leads($this);
    }

    /** @return Campaigns */
    public function campaigns()
    {
        return new Campaigns($this);
    }
}
