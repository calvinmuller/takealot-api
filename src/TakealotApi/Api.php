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
            'base_uri' => env('TAKEALOT_API_URL',
                'https://api.takealot.com/rest/v-1-5-2/'),
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
     * Get Departments
     * @return mixed
     */
    public function getDepartments()
    {

        return json_decode(
            $this->get('types', [
                    'query' => ['nav' => 1]
                ]
            )->getBody()
        )->response;
    }


    /**
     * Get the daily deals
     * @param array $query_params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getDailyDeals($query_params = ['status' => 'active', 'type' => 'dailydeal'])
    {
        return $this->get('deals', [
            'query' => $query_params
        ]);
    }


    /**
     * Get product
     * https://api.takealot.com/rest/v-1-5-2/productlines/lookup?idProduct=35134206
     * @param $productId
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getProduct($productId, $params = [])
    {
        return $this->get('productlines/lookup', [
            'query' => array_merge($params, [
                'idProduct' => $productId
            ])
        ]);

    }
}
