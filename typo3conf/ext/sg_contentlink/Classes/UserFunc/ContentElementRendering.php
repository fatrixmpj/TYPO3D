<?php

namespace SGalinski\SgContentlink\UserFunc;

/***************************************************************
 *  Copyright notice
 *
 *  (c) sgalinski Internet Services (https://www.sgalinski.de)
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Class for user functions that modifies the content element rendering.
 */
class ContentElementRendering {
	/**
	 * @var ContentObjectRenderer
	 */
	public $cObj;

	/**
	 * Adds parameters to the current content element.
	 *
	 * @param string $content
	 * @return string
	 */
	public function wrapContentLinkAroundContent($content) {
		if (!$this->cObj->data || !$this->cObj->data['tx_sgcontentlink_contentlink']) {
			return $content;
		}

		// Removal of all links
		$content = preg_replace('/<a.+?>/is', '', $content);
		$content = str_replace('</a>', '', $content);

		return $this->cObj->getTypoLink($content, implode(' ', $this->getParameters()));
	}

	/**
	 * Returns the parameters for the typolink.
	 *
	 * @return array
	 */
	protected function getParameters() {
		$overwrites = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_sgcontentlink.']['settings.']['link.']['overwrite.'];
		$additions = $GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_sgcontentlink.']['settings.']['link.']['add.'];

		$parameters = str_getcsv($this->cObj->data['tx_sgcontentlink_contentlink'], ' ', '"');
		$defaultTarget = $overwrites['defaultTarget'];
		if ($defaultTarget) {
			$parameters[1] = $defaultTarget;
		} elseif (!isset($parameters[1])) {
			$parameters[1] = '-';
		}

		$defaultClass = $overwrites['defaultClass'];
		$addClass = $additions['class'];
		$classIsSet = isset($parameters[2]);
		if ($defaultClass) {
			$parameters[2] = $defaultClass;
		} elseif ($classIsSet && $addClass) {
			$parameters[2] .= ' ' . $addClass;
		} elseif (!$classIsSet && $addClass) {
			$parameters[2] = $addClass;
		} elseif (!$classIsSet) {
			$parameters[2] = '-';
		}

		$defaultTitle = $overwrites['defaultTitle'];
		$addTitle = $additions['title'];
		$titleIsSet = isset($parameters[3]);
		if ($defaultTitle) {
			$parameters[3] = $defaultTitle;
		} elseif ($titleIsSet && $addTitle) {
			$parameters[3] .= ' ' . $addTitle;
		} elseif (!$titleIsSet && $addTitle) {
			$parameters[3] = $addTitle;
		}

		foreach ($parameters as &$parameter) {
			if ($parameter === '-' || strpos($parameter, ' ') === FALSE) {
				continue;
			}

			$parameter = '"' . $parameter . '"';
		}

		return $parameters;
	}
}
