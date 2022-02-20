<?php

class TakealotTests extends \PHPUnit\Framework\TestCase
{
    public $api;

    public function __construct(string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->api = new \TakealotApi\Api();
    }

    public function testShouldLogin()
    {
        $response = $this->api->login('test@test.com', 'dead');

        $json = json_decode($response->getBody()->getContents());

        $this->assertThat($json->result, $this->equalTo('error'));
        $this->assertThat($json->status_code, $this->equalTo(401));
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException]
     */
    public function testShouldGetOrders()
    {
        $response = $this->api->login('calvin+takealot@istreet.co.za', 'admin123');
        $json = json_decode($response->getBody()->getContents());

        $this->assertTrue(true);

        $response = $this->api->orders($json->response->customer_id,
            $json->response->jwt,
            '2021-11-01',
            '2022-11-01'
        );

        $orders = json_decode($response->getBody()->getContents());

        $this->assertThat($orders->response->order_count, $this->equalTo(0));
    }
}
