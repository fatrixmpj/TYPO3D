<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MShop\Service\Provider\Payment;


class StripeTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp()
	{
		if( !class_exists( 'Omnipay\Omnipay' ) ) {
			$this->markTestSkipped( 'Omnipay library not available' );
		}

		$context = \TestHelper::getContext();

		$serviceManager = \Aimeos\MShop\Service\Manager\Factory::createManager( $context );
		$item = $serviceManager->createItem();
		$item->setConfig( array( 'stripe.testmode' => true ) );

		$this->object = new StripePublic( $context, $item );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testGetConfigBE()
	{
		$result = $this->object->getConfigBE();

		$this->assertInternalType( 'array', $result );
		$this->assertArrayHasKey( 'stripe.address', $result );
		$this->assertArrayHasKey( 'stripe.authorize', $result );
		$this->assertArrayHasKey( 'stripe.testmode', $result );
		$this->assertArrayNotHasKey( 'stripe.type', $result );
		$this->assertArrayNotHasKey( 'omnipay.type', $result );
	}


	public function testCheckConfigBE()
	{
		$attributes = array(
			'stripe.address' => '0',
			'stripe.authorize' => '1',
			'stripe.testmode' => '1',
		);

		$result = $this->object->checkConfigBE( $attributes );

		$this->assertEquals( 3, count( $result ) );
		$this->assertEquals( null, $result['stripe.address'] );
		$this->assertEquals( null, $result['stripe.authorize'] );
		$this->assertEquals( null, $result['stripe.testmode'] );
		$this->assertArrayNotHasKey( 'stripe.type', $result );
		$this->assertArrayNotHasKey( 'omnipay.type', $result );
	}

	public function testGetValueTestmode()
	{
		$this->assertTrue( $this->object->getValuePublic( 'testmode' ) );
	}
}


class StripePublic extends \Aimeos\MShop\Service\Provider\Payment\Stripe
{
	public function getValuePublic( $name, $default = null )
	{
		return $this->getValue( $name, $default );
	}
}