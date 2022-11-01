<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "static_info_tables".
 *
 * Auto generated 10-04-2018 18:34
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Static Info Tables',
  'description' => 'Data and API for countries, languages and currencies.',
  'category' => 'misc',
  'version' => '6.5.1',
  'state' => 'stable',
  'uploadfolder' => false,
  'createDirs' => '',
  'clearCacheOnLoad' => 0,
  'author' => 'Stanislas Rolland/René Fritz',
  'author_email' => 'typo3@sjbr.ca',
  'author_company' => 'SJBR',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '7.6.0-8.7.99',
    ),
    'conflicts' => 
    array (
      'sr_static_info' => '0.0.0-99.99.99',
      'cc_infotablesmgm' => '0.0.0-99.99.99',
      'uncache' => '0.0.0-99.99.99',
    ),
    'suggests' => 
    array (
    ),
  ),
  'clearcacheonload' => false,
);

