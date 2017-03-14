<?php
namespace Domatskiy\Tests;

class ICMLTest extends \PHPUnit_Framework_TestCase
{
    /*
     * @var \Domatskiy\ICML\Generator
     */
    private $generator = null;
    private $file_created = false;

    /**
     *
     */
    public function setUp()
    {
        $this->generator = new \Domatskiy\ICML\Generator('shop', 'comp');
    }

    public function tearDown()
    {
        $this->generator = null;
    }

    public function test()
    {
        $this->generator->addCategory(1, 'prod');
        $this->generator->addCategory(2, 'adap');

        $categories = $this->generator->getCategory();
        $this->assertEquals(count($categories), 2);

        $this->generator->addOffer(new \Domatskiy\ICML\Offer([
            'id' => 22,
            'productId' => 55,
            'quantity' => 1,
            'name' => 'товар'
            ]));

        $this->generator->addOffer(new \Domatskiy\ICML\Offer([
            'id' => 22,
            'productId' => 55,
            'quantity' => 1,
            'name' => 'товар'
            ]));

        $this->generator->createToFile(__DIR__.'/test_icml.xml', new \DateTime('now'));
        $this->file_created = true;
    }


}
