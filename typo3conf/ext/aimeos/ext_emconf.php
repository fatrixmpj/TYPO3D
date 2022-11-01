<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "aimeos".
 *
 * Auto generated 13-12-2019 23:35
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Aimeos web shop',
  'description' => 'Professional, full-featured and ultra-fast TYPO3 e-commerce extension for online shops, complex B2B applications and #gigacommerce. Turns TYPO3 into the best platform for content commerce and your e-commerce requirements (also available as TYPO3 distribution)',
  'category' => 'plugin',
  'version' => '18.10.11',
  'state' => 'stable',
  'uploadfolder' => true,
  'createDirs' => '',
  'clearcacheonload' => true,
  'author' => 'Aimeos',
  'author_email' => 'aimeos@aimeos.org',
  'author_company' => '',
  'constraints' => 
  array (
    'depends' => 
    array (
      'php' => '5.6.0-7.99.99',
      'typo3' => '7.6.0-9.99.99',
      'scheduler' => '7.6.0-9.99.99',
      'static_info_tables' => '6.0.0-6.99.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
      'realurl' => '1.12.8-2.99.99',
    ),
  ),
  'autoload' => 
  array (
    'psr-4' => 
    array (
      'Aimeos\\Aimeos\\' => 'Classes',
    ),
  ),
);

