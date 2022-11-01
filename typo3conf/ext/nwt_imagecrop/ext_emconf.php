<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "nwt_imagecrop".
 *
 * Auto generated 03-04-2018 17:11
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Imagecrop for tt_content (responsive)',
  'description' => 'You can enable cropscaling in tt_content image elements with an extra checkbox. Only TypoScript - no XCLASS',
  'category' => 'fe',
  'version' => '2.0.0',
  'state' => 'stable',
  'uploadfolder' => true,
  'createDirs' => '',
  'clearcacheonload' => true,
  'author' => 'Christian Lange - networkteam',
  'author_email' => 'info@networkteam.com',
  'author_company' => 'networkteam GmbH',
  'constraints' => 
  array (
    'depends' => 
    array (
      'cms' => '',
      'typo3' => '7.6.0-8.7.99',
    ),
    'conflicts' => 
    array (
      'imagecycle' => '',
    ),
    'suggests' => 
    array (
    ),
  ),
);

