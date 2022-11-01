<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "mw_shell".
 *
 * Auto generated 09-08-2016 17:53
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Web Shell',
  'description' => 'Provides web-based shell access to the web server. Requires TYPO3 Admin Account.',
  'category' => 'module',
  'version' => '1.0.6',
  'state' => 'stable',
  'uploadfolder' => 0,
  'createDirs' => '',
  'clearcacheonload' => 0,
  'author' => 'Andreas Beutel',
  'author_email' => 'typo3@mehrwert.de',
  'author_company' => 'mehrwert intermediale kommunikation GmbH',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '3.5.0-4.3.99',
      'php' => '4.0.0-5.3.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
);

