<?php

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
	'tt_content', [
		'tx_sgcontentlink_contentlink' => [
			'displayCond' => \SGalinski\SgContentlink\TCA\TcaProvider::getAllowedTypesForTcaDisplayCond(),
			'exclude' => 1,
			'label' => 'LLL:EXT:sg_contentlink/Resources/Private/Language/locallang_db.xlf:tt_content.tx_sgcontentlink_contentlink',
			'config' => [
				'type' => 'input',
				'size' => 50,
				'eval' => 'trim',
				'wizards' => [
					'_PADDING' => 2,
					'link' => [
						'type' => 'popup',
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:header_link_formlabel',
						'icon' => 'link_popup.gif',
						'module' => [
							'name' => 'wizard_element_browser',
							'urlParameters' => [
								'mode' => 'wizard'
							],
						],
						'JSopenParams' => 'height=600,width=500,status=0,menubar=0,scrollbars=1'
					]
				],
			],
		],
	]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
	'tt_content', '--linebreak--LLL:EXT:sg_contentlink/Resources/Private/Language/locallang_db.xlf:tt_content.tx_sgcontentlink_contentlink,tx_sgcontentlink_contentlink', '', 'after:subheader'
);
