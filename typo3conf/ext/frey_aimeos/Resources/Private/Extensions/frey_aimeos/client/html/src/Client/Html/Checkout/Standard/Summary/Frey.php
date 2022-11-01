<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2015-2017
 * @package Client
 * @subpackage Html
 */


namespace Aimeos\Client\Html\Checkout\Standard\Summary;


// Strings for translation
sprintf( 'summary' );


/**
 * Default implementation of checkout summary HTML client.
 *
 * @package Client
 * @subpackage Html
 */
class Frey
	extends \Aimeos\Client\Html\Checkout\Standard\Summary\Standard
	implements \Aimeos\Client\Html\Common\Client\Factory\Iface
{

	/**
	 * Processes the input, e.g. store given values.
	 * A view must be available and this method doesn't generate any output
	 * besides setting view variables.
	 */
	public function process()
	{
		$view = $this->getView();

		try
		{
			if( $view->param( 'cs_order', null ) === null ) {
				return;
			}


			$controller = \Aimeos\Controller\Frontend\Factory::createController( $this->getContext(), 'basket' );

			if( ( $comment = $view->param( 'cs_comment' ) ) !== null )
			{
				$controller->get()->setComment( $comment );
				$controller->save();
			}


			// only start if there's something to do
			if( $view->param( 'cs_option_terms', null ) !== null
				&& ( $option = $view->param( 'cs_option_terms_value', 0 ) ) != 1
			) {
				$error = $view->translate( 'client', 'Please accept the terms and conditions' );
				$errors = $view->get( 'summaryErrorCodes', [] );
				$errors['option']['terms'] = $error;

				$view->summaryErrorCodes = $errors;
				$view->standardStepActive = 'summary';
				$view->standardErrorList = array( $error ) + $view->get( 'standardErrorList', [] );
			}

			if( $view->param( 'cs_option_alcohol', null ) !== null
				&& ( $option = $view->param( 'cs_option_alcohol_value', 0 ) ) != 1
			) {
				$error = $view->translate( 'client', 'Bitte bestätigen Sie, dass Sie volljährig sind' );
				$errors = $view->get( 'summaryErrorCodes', [] );
				$errors['option']['alcohol'] = $error;

				$view->summaryErrorCodes = $errors;
				$view->standardStepActive = 'summary';
				$view->standardErrorList = array( $error ) + $view->get( 'standardErrorList', [] );
			}


			parent::process();

			$controller->get()->check( \Aimeos\MShop\Order\Item\Base\Base::PARTS_ALL );
		}
		catch( \Exception $e )
		{
			$view->standardStepActive = 'summary';
			throw $e;
		}
	}
}
 
