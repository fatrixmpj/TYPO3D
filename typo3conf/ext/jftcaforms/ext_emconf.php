<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "jftcaforms".
 *
 * Auto generated 23-06-2016 14:58
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Additional TCA Forms',
	'description' => 'Provides additional TCA Forms for the backend. At this moment these forms are supported: Slider',
	'category' => 'be',
	'version' => '0.2.6',
	'state' => 'beta',
	'uploadfolder' => true,
	'createDirs' => '',
	'clearcacheonload' => true,
	'author' => 'Juergen Furrer',
	'author_email' => 'juergen.furrer@gmail.com',
	'author_company' => '',
	'constraints' => 
	array (
		'depends' => 
		array (
			'cms' => '',
			'php' => '5.0.0-0.0.0',
			'typo3' => '4.3.0-6.2.99',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
);

