<?php

namespace PersistIQ\Resource;

use PersistIQ\Exception\JsonDecodeException;
use PersistIQ\Exception\RateLimitException;
use PersistIQ\PersistIQ;

abstract class AbstractResource implements ResourceInterface
{
    /** @var PersistIQ */
    protected $persistIQ;

    /** {@inheritdoc} */
    public function __construct(PersistIQ $persistIQ)
    {
        $this->persistIQ = $persistIQ;
    }

    /**
     * @param string $url
     * @param array $data
     * @param bool $fullUrl - Defaults to false, use true when using the next_url returned on paginated results
     * @return array
     * @throws JsonDecodeException
     * @throws RateLimitException
     */
    public function get($url, $data = [], $fullUrl = false)
    {
        if (!$fullUrl) {
            $url = $this->persistIQ->getUrl($url);
        }

        return $this->parseResponse($this->persistIQ->getCurl()->get($url, $data));
    }

    /**
     * @param string $url
     * @param array $data
     * @return array
     * @throws JsonDecodeException
     * @throws RateLimitException
     */
    public function post($url, $data = [])
    {
        $url = $this->persistIQ->getUrl($url);
        $response = $this->persistIQ->getCurl()->post($url, $data);

        return $this->parseResponse($response);
    }

    /**
     * @param string $response
     * @return array
     * @throws JsonDecodeException
     * @throws RateLimitException
     */
    protected function parseResponse($response)
    {
        $curl = $this->persistIQ->getCurl();

        if ($curl->error) {
            switch ($curl->errorCode) {
                case 429:
                    throw new RateLimitException($curl->errorMessage);

                //TODO: 500?

                default:
                    // ignore these
            }
        }

        $result = json_decode($response, true);

        if (is_null($result)) {
            throw new JsonDecodeException();
        }

        return $result;
    }
}
