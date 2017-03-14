<?php

namespace Domatskiy\ICML;

class Offer
{

    private
        $id,
        $productId,
        $params = array();

    private $fields = array(
        'id',
        'productId',
        'categoryId',
        'quantity',
        'url',
        'price',
        'purchasePrice',
        'picture',
        'name',
        'xmlId',
        'productName'
        );

    function __construct(array $params)
    {

        if(isset($params['id']) && (int)$params['id'] < 1)
            throw new \Exception('not correct id');

        if(isset($params['productId']) && (int)$params['productId'] < 1)
            throw new \Exception('not correct productId');

        if(isset($params['categoryId']) && (int)$params['categoryId'] < 1)
            throw new \Exception('not correct categoryId');

        if(isset($params['quantity']) && (int)$params['quantity'] < 1)
            throw new \Exception('not correct quantity');

        if(isset($params['url']) && (!is_string($params['url']) || strpos($params['url'], 'http') === false))
            throw new \Exception('not correct url');

        if(isset($params['name']) && !is_string($params['name']))
            throw new \Exception('not correct name');

        if(isset($params['productName']) && !is_string($params['productName']))
            throw new \Exception('not correct productName');

        if(isset($params['xmlId']) && !is_string($params['xmlId']))
            throw new \Exception('not correct xmlId');

        if(isset($params['picture']) && !is_string($params['picture']))
            throw new \Exception('not correct picture');

        $this->params = $params;

    }

    public function isProduct()
    {
        return $this->id == $this->product_id;
    }

    /**
     * @param string $name
     * @return mixed|null
     * @throws \Exception
     */
    public function __get($name)
    {
        if(!is_string($name) || !in_array($name, $this->fields))
            throw new \Exception('not correct argument "'.$name.'"');

        if(array_key_exists($name, $this->params))
            return $this->params[$name];
        else
            return null;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws \Exception
     */
    function __set($name, $value)
    {
        if(!is_string($name) || !array_key_exists($name, $this->fields))
            throw new \Exception('not correct argument '.$name);

        $this->params[$name] = $value;
    }

    /**
     * @return int
     */
    public function getID()
    {
        return $this->params['id'];
    }

    /**
     * @return int
     */
    public function getProductID()
    {
        return $this->params['productId'];
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->params['quantity'];
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return is_array($this->params) ? $this->params : array();
    }

    /**
     * @return array
     */
    public function getFieldsName()
    {
        return $this->fields;
    }

}