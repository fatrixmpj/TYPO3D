<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "aimeos_pay".
 *
 * Auto generated 13-12-2019 23:40
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Aimeos payments',
  'description' => 'Aimeos TYPO3 payments extension for Aimeos project. It contains the Omnipay payment library (http://omnipay.thephpleague.com/) including all available payment drivers.',
  'category' => 'plugin',
  'author' => 'Aimeos GmbH',
  'author_email' => 'info@aimeos.com',
  'author_company' => 'Aimeos GmbH',
  'state' => 'beta',
  'clearCacheOnLoad' => 0,
  'createDirs' => '',
  'uploadfolder' => false,
  'version' => '18.10.0',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '7.6.0-9.99.99',
      'aimeos' => '18.4.0-18.99.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'clearcacheonload' => false,
);

