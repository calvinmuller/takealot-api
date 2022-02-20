<?php

namespace TakealotApi;

/**
 * Base API class, contains all code shared by the web API classes.
 */

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class Api extends Client
{
    /**
     * The last API response executed.
     */
    public $client;

    /**
     * @var \GuzzleHttp\Cookie\CookieJar
     */
    private $jar;

    public function __construct(array $config = [])
    {
        $this->jar = new \GuzzleHttp\Cookie\CookieJar;

        $config = [
            'base_uri' => 'https://api.takealot.com/rest/v-1-10-0/',
            'headers' => $this->_getCommonHeaders(),
            'referer' => true,
            'cookies' => $this->jar
        ];

        parent::__construct($config);
    }

    /**
     * Get and returns an array of common/shared headers.
     */
    public static function _getCommonHeaders()
    {
        return array(
            'Content-Type' => 'application/json',
            'User-Agent' => 'TAL-iOS/2.15.0 (com.takealot.iphone; build:202112211521; 15.1.0; iPhone12,1; Phone)',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
            'Accept-Encoding' => 'gzip, deflate, br',
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


    /**
     * @param $email
     * @param $password
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login($email, $password): ResponseInterface
    {
        $parameters = [
            'email' => $email,
            'password' => $password
        ];

        return $this->request('POST', 'login', [
            'form_params' => $parameters
        ]);
    }

    /**
     * from=2021-11-01&page_number=0&page_size=10&to=2022-02-21
     * @param $customerId
     * @param $token
     * @param \DateTime $from
     * @param \DateTime $to
     * @param int $pageNumber
     * @param int $pageSize
     * @return \Psr\Http\Message\ResponseInterface
     *
     * {"result": "ok", "status_code": 200, "response": {"order_count": 0, "page_summary": {"page_number": 0, "page_size": 10, "page_count": 0}, "orders": []}}
     */
    public function orders($customerId, $token, string $from, string $to, int $pageNumber = 0, int $pageSize = 20): \Psr\Http\Message\ResponseInterface
    {
        $params = [
            'from' => $from,
            'to' => $to,
            'page_number' => $pageNumber,
            'page_size' => $pageSize
        ];

        return $this->get("customer/${customerId}/orders", [
            'cookies' => $this->jar,
            'params' => $params,
            'headers' => [
                'x-csrf-token' => $this->jar->getCookieByName('tal_csrf')->getValue(),
                'Authorization' => "Bearer ${token}"
            ]
        ]);
    }

}
