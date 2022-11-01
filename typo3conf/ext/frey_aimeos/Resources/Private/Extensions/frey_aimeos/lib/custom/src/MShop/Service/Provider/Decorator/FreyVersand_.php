<?php

namespace Aimeos\MShop\Service\Provider\Decorator;


/**
 * Frey delivery address decorator for service providers
 *
 * @package MShop
 * @subpackage Service
 */
class FreyVersand
	extends \Aimeos\MShop\Service\Provider\Decorator\Base
	implements \Aimeos\MShop\Service\Provider\Decorator\Iface
{
	private $feConfig = array(
		'freyversand.datum' => array(
			'code' => 'freyversand.datum',
			'internalcode' => 'freyversand.datum',
			'label' => 'Lieferdatum',
			'type' => 'date',
			'internaltype' => 'string',
			'default' => null,
			'required' => false
		),
		'freyversand.drittperson' => array(
			'code' => 'freyversand.drittperson',
			'internalcode' => 'freyversand.drittperson',
			'label' => 'Darf bei einer Drittperson abgegeben werden',
			'type' => 'boolean',
			'internaltype' => 'boolean',
			'default' => 1,
			'required' => false
		),
		'freyversand.tuer' => array(
			'code' => 'freyversand.tuer',
			'internalcode' => 'freyversand.tuer',
			'label' => 'Darf vor die Tür gelegt werden',
			'type' => 'boolean',
			'internaltype' => 'boolean',
			'default' => 1,
			'required' => false
		),
		'freyversand.abholung' => array(
			'code' => 'freyversand.abholung',
			'internalcode' => 'freyversand.abholung',
			'label' => 'Abholung im Partnergeschäft',
			'type' => 'boolean',
			'internaltype' => 'boolean',
			'default' => 1,
			'required' => false
		),
	);


	/**
	 * Checks the frontend configuration attributes for validity.
	 *
	 * @param array $attributes Attributes entered by the customer during the checkout process
	 * @return array An array with the attribute keys as key and an error message as values for all attributes that are
	 * 	known by the provider but aren't valid resp. null for attributes whose values are OK
	 */
	public function checkConfigFE( array $attributes )
	{
		$result = $this->getProvider()->checkConfigFE( $attributes );

		return array_merge( $result, $this->checkConfig( $this->feConfig, $attributes ) );
	}


	/**
	 * Returns the configuration attribute definitions of the provider to generate a list of available fields and
	 * rules for the value of each field in the frontend.
	 *
	 * @param \Aimeos\MShop\Order\Item\Base\Iface $basket Basket object
	 * @return array List of attribute definitions implementing \Aimeos\MW\Common\Critera\Attribute\Iface
	 */
	public function getConfigFE( \Aimeos\MShop\Order\Item\Base\Iface $basket )
	{
		$feconfig = $this->feConfig;

		try
		{
			$type = \Aimeos\MShop\Order\Item\Base\Service\Base::TYPE_DELIVERY;
			$service = $basket->getService( $type, $this->getServiceItem()->getCode() );

			$feconfig['freyversand.datum']['default'] = $service->getAttribute( 'freyversand.datum', 'delivery' );
			/*$feconfig['reyversand.datum']['default'] = date( 'd-m-Y', time() + 86400 * $days );*/
			$feconfig['freyversand.drittperson']['default'] = $service->getAttribute( 'freyversand.drittperson', 'delivery' );
			$feconfig['freyversand.abholung']['default'] = $service->getAttribute( 'freyversand.abholung', 'delivery' );
			$feconfig['freyversand.tuer']['default'] = $service->getAttribute( 'freyversand.tuer', 'delivery' );
		}
		catch( \Aimeos\MShop\Order\Exception $e ) {} // If service isn't available

		return array_merge( $this->getProvider()->getConfigFE( $basket ), $this->getConfigItems( $feconfig ) );
	}
}
