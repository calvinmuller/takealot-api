<?php

namespace TakealotApi;


class Product extends Api
{

    /**
     * Get a product
     * @param null $productId
     * @param array $parameters
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function find($productId = null, $parameters = [])
    {

        $parameters = array_merge($parameters, [
            'idProduct' => $productId
        ]);

        return $this->get("productlines/lookup", [
            'query' => $parameters
        ]);

    }

}
