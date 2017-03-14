<?php

namespace Domatskiy\ICML;

use Domatskiy\ICML\Offer;

class Generator
{

    private $shop_name;
    private $shop_company;

    /**
     * @var Offer[]
     */
    private $offers = array();

    /**
     * @var array
     */
    private $categories = array();

    /**
     * Generator constructor.
     * @param $name
     * @param $company
     */
    function __construct($name, $company)
    {
        $this->shop_name = $name;
        $this->shop_company = $company;
    }

    /**
     * @param Offer $offer
     */
    public function addOffer(Offer $offer)
    {
        if(array_key_exists($offer->getID(), $this->offers))
            throw new \Exception('offer exits');

        $this->offers[] = $offer;
    }

    /**
     * @param $id
     * @param $name
     * @throws \Exception
     */
    public function addCategory($id, $name)
    {
        $id = (int)$id;

        if($id < 1)
            throw new \Exception('not correct category id');

        if(!is_string($name))
            throw new \Exception('not correct category name');

        $this->categories[$id] = $name;
    }

    /**
     * @return array
     */
    public function getCategory()
    {
        return $this->categories;
    }

    function create(\DateTime $date = null)
    {
        if(!$date)
            $date = new \DateTime(time());

        $yml_catalog = new \SimpleXMLElement("<yml_catalog></yml_catalog>");
        $yml_catalog->addAttribute('date', $date->format('Y-m-d H:i:s'));

        $shop = $yml_catalog->addChild('shop');
        $shop->addChild('name', $this->shop_name);
        $shop->addChild('company', $this->shop_company);

        $cat = $shop->addChild('categories');

        if(is_array($this->categories) && !empty($this->categories))
        {
            foreach ($this->categories as $id => $name)
            {
                $category = $cat->addChild('category', $name);
                $category->addAttribute('id', $id);
            }
        }


        $offers = $shop->addChild('offers');

        foreach($this->offers as $offer)
        {
            /**
             * @var $offer Offer
             */
            $xml_offer = $offers->addChild('offer');
            $xml_offer->addAttribute('id', $offer->getID());
            $xml_offer->addAttribute('productId', $offer->getProductID());
            $xml_offer->addAttribute('quantity', (int)$offer->quantity);

            foreach ($offer->getParams() as $code => $value)
                $xml_offer->addChild($code, $value);
        }


        //Header('Content-type: text/xml');
        echo $yml_catalog->asXML();
    }

    public function createToFile($file_name, \DateTime $date = null)
    {
        ob_start();
        $this->create($date);
        $data = ob_get_contents();
        ob_end_flush();

        file_put_contents($file_name, $data);
    }

}