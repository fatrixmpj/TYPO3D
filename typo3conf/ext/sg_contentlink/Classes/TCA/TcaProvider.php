<?php

namespace SGalinski\SgContentlink\TCA;

/***************************************************************
 *  Copyright notice
 *
 *  (c) sgalinski Internet Services (https://www.sgalinski.de)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\SingletonInterface;

/**
 * This class contains methods for usage within the TCA forms.
 */
class TcaProvider implements SingletonInterface{
	/**
	 * This are the values of the column CType of the table tt_content
	 *
	 * @var array
	 */
	protected static $allowedTypesForContentLink = array(
		// New CTypes in 7.6
		'textmedia' => 'textmedia',

		// CTypes in 6.2
		'header' => 'header',
		'text' => 'text',
		'textpic' => 'textpic',
		'image' => 'image',

		'bullets' => 'bullets',
		'table' => 'table',
		'uploads' => 'uploads',

		'media' => 'media',
		'menu' => 'menu',
		'shortcut' => 'shortcut',
		'list' => 'list',
		'fluidcontent_content' => 'fluidcontent_content',
		'gridelements_pi1' => 'gridelements_pi1',
	);

	/**
	 * Returns the display condition for the TCA.
	 *
	 * @return array
	 */
	public static function getAllowedTypesForTcaDisplayCond() {
		$conditions = array();
		foreach (self::$allowedTypesForContentLink as $allowedTypeForContentLink) {
			$conditions[] = 'FIELD:CType:=:' . $allowedTypeForContentLink;
		}

		return array(
			'OR' => $conditions,
		);
	}

	/**
	 * @return array
	 */
	public static function getAllowedTypesForContentLink() {
		return self::$allowedTypesForContentLink;
	}

	/**
	 * @param array $allowedTypesForContentLink
	 */
	public static function setAllowedTypesForContentLink($allowedTypesForContentLink) {
		self::$allowedTypesForContentLink = $allowedTypesForContentLink;
	}

	/**
	 * @param string $allowedTypeForContentLink
	 */
	public static function addAllowedTypeForContentLink($allowedTypeForContentLink) {
		self::$allowedTypesForContentLink[$allowedTypeForContentLink] = $allowedTypeForContentLink;
	}

	/**
	 * @param string $allowedTypeForContentLink
	 */
	public static function removeAllowedTypeForContentLink($allowedTypeForContentLink) {
		unset(self::$allowedTypesForContentLink[$allowedTypeForContentLink]);
	}
}
