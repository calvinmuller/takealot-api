<?php

namespace TakealotApi;

/**
 * Base API class, contains all code shared by the web API classes.
 */
use GuzzleHttp\Client;

class Api extends Client
{
    /**
     * The last API response executed.
     */
    public $client;

    public function __construct(array $config = [])
    {
        $config = [
            'base_uri' => getenv('TAKEALOT_API_URL', 'https://api.takealot.com/rest/v-1-5-2/'),
        ];

        parent::__construct($config);
    }

    /**
     * Get and returns an array of common/shared headers.
     */
    public static function _getCommonHeaders()
    {
        return array(
            'Accept' => '*/*',
            'Content-Type' => 'application/json',
        );
    }


    /**
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getDepartments()
    {

        return $this->get('types', [
                'query' => ['nav' => 1]
            ]
        );
    }
}
