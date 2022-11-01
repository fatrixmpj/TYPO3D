<?php
$TYPO3_CONF_VARS['SYS']['sitename'] = 'New TYPO3 site';

// Default password is 'joh316':
$TYPO3_CONF_VARS['BE']['installToolPassword'] = '2044aeb7bc26024a55286652f0f102a5';

$TYPO3_CONF_VARS['EXT']['extList'] = 'tsconfig_help,context_help,extra_page_cm_options,impexp,sys_note,tstemplate,tstemplate_ceditor,tstemplate_info,tstemplate_objbrowser,tstemplate_analyzer,func_wizards,wizard_crpages,wizard_sortpages,lowlevel,install,belog,beuser,aboutmodules,setup,taskcenter,info_pagetsconfig,viewpage,rtehtmlarea,css_styled_content,t3skin,t3editor,reports,felogin,indexed_search,introduction,realurl,tt_news,automaketemplate';

$typo_db_extTableDef_script = 'extTables.php';

## INSTALL SCRIPT EDIT POINT TOKEN - all lines after this points may be changed by the install script!

$TYPO3_CONF_VARS['EXT']['extList'] = 'extbase,css_styled_content,tsconfig_help,context_help,extra_page_cm_options,impexp,sys_note,tstemplate,tstemplate_ceditor,tstemplate_info,tstemplate_objbrowser,tstemplate_analyzer,func_wizards,wizard_crpages,wizard_sortpages,lowlevel,install,belog,beuser,aboutmodules,setup,taskcenter,info_pagetsconfig,viewpage,rtehtmlarea,t3skin,t3editor,reports,felogin,indexed_search,introduction,automaketemplate,realurl,wt_spamshield,info,perm,func,filelist,pit_googlemaps,perfectlightbox,maag_randomimage,fluid,version,workspaces';	// Modified or inserted by TYPO3 Extension Manager. Modified or inserted by TYPO3 Core Update Manager.
// Updated by TYPO3 Core Update Manager 12-08-10 09:44:26
$TYPO3_CONF_VARS['SYS']['encryptionKey'] = 'c9fe887beed5c9eb3eaeea5a7f7b6fe4';
$TYPO3_CONF_VARS['SYS']['compat_version'] = '4.7';	// Modified or inserted by TYPO3 Install Tool. 
$typo_db_username = 'usr_hpftypo3';
$typo_db_password = '0t4PiNUnSzcsfT7hXK8G';
$typo_db_host = 'localhost';
$typo_db = 'freytpdreidb';
//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['BE']['forceCharset'] = 'utf-8';
$TYPO3_CONF_VARS['SYS']['setDBinit'] = 'SET NAMES utf8;';
$TYPO3_CONF_VARS['BE']['fileCreateMask'] = '0664';
$TYPO3_CONF_VARS['BE']['folderCreateMask'] = '2775';
$TYPO3_CONF_VARS['GFX']['jpg_quality'] = '80';  //  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['EXT']['extConf']['indexed_search'] = 'a:17:{s:8:"pdftools";s:9:"/usr/bin/";s:8:"pdf_mode";s:2:"20";s:5:"unzip";s:9:"/usr/bin/";s:6:"catdoc";s:9:"/usr/bin/";s:6:"xlhtml";s:9:"/usr/bin/";s:7:"ppthtml";s:9:"/usr/bin/";s:5:"unrtf";s:9:"/usr/bin/";s:9:"debugMode";s:1:"0";s:18:"fullTextDataLength";s:1:"0";s:23:"disableFrontendIndexing";s:1:"0";s:6:"minAge";s:2:"24";s:6:"maxAge";s:1:"0";s:16:"maxExternalFiles";s:1:"5";s:26:"useCrawlerForExternalFiles";s:1:"0";s:11:"flagBitMask";s:3:"192";s:16:"ignoreExtensions";s:0:"";s:17:"indexExternalURLs";s:1:"0";}';     //  Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['realurl'] = 'a:4:{s:10:"configFile";s:26:"typo3conf/realurl_conf.php";s:14:"enableAutoConf";s:1:"1";s:14:"autoConfFormat";s:1:"1";s:12:"enableDevLog";s:1:"0";}';   // Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['tt_news'] = 'a:15:{s:13:"useStoragePid";s:1:"0";s:13:"noTabDividers";s:1:"0";s:25:"l10n_mode_prefixLangTitle";s:1:"1";s:22:"l10n_mode_imageExclude";s:1:"1";s:20:"hideNewLocalizations";s:1:"0";s:13:"prependAtCopy";s:1:"1";s:17:"requireCategories";s:1:"0";s:5:"label";s:5:"title";s:9:"label_alt";s:8:"datetime";s:10:"label_alt2";s:5:"short";s:15:"label_alt_force";s:1:"0";s:11:"treeOrderBy";s:5:"title";s:21:"categorySelectedWidth";s:1:"0";s:17:"categoryTreeWidth";s:1:"0";s:18:"categoryTreeHeigth";s:1:"5";}';        // Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['EXT']['extConf']['wt_spamshield'] = 'a:10:{s:12:"useNameCheck";s:1:"0";s:12:"usehttpCheck";s:1:"3";s:9:"notUnique";s:0:"";s:13:"honeypodCheck";s:1:"1";s:15:"useSessionCheck";s:1:"1";s:16:"SessionStartTime";s:2:"10";s:14:"SessionEndTime";s:3:"600";s:10:"AkismetKey";s:0:"";s:12:"email_notify";s:0:"";s:3:"pid";s:2:"-1";}';     //  Modified or inserted by TYPO3 Extension Manager.
$TYPO3_CONF_VARS['BE']['disable_exec_function'] = '0';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['im_combine_filename'] = 'composite';	// Modified or inserted by TYPO3 Install Tool. 
$TYPO3_CONF_VARS['GFX']['gdlib_png'] = '1';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['im'] = '1';	// Modified or inserted by TYPO3 Install Tool. 
$TYPO3_CONF_VARS['GFX']['im_path'] = '/usr/local/bin/';	// Modified or inserted by TYPO3 Install Tool. 
$TYPO3_CONF_VARS['GFX']['im_path_lzw'] = '/usr/local/bin/';	// Modified or inserted by TYPO3 Install Tool. 
$TYPO3_CONF_VARS['GFX']['TTFdpi'] = '96';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['im_imvMaskState'] = '1';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['im_negate_mask'] = '0';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 12-08-10 09:44:41
$TYPO3_CONF_VARS['EXT']['extList_FE'] = 'extbase,css_styled_content,install,rtehtmlarea,t3skin,felogin,indexed_search,introduction,automaketemplate,realurl,wt_spamshield,pit_googlemaps,perfectlightbox,maag_randomimage,fluid,version,workspaces';	// Modified or inserted by TYPO3 Extension Manager.

$TYPO3_CONF_VARS['BE']['installToolPassword'] = 'edef9fb36f3679cc8b338900307c4ce4';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['SYS']['UTF8filesystem'] = '1';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['BE']['allowDonateWindow'] = '0';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 19-07-11 16:20:34
// Updated by TYPO3 Extension Manager 19-07-11 16:21:20
$TYPO3_CONF_VARS['INSTALL']['wizardDone']['tx_coreupdates_installsysexts'] = '1';	//  Modified or inserted by TYPO3 Upgrade Wizard.
$TYPO3_CONF_VARS['INSTALL']['wizardDone']['tx_coreupdates_installnewsysexts'] = '1';	//  Modified or inserted by TYPO3 Upgrade Wizard.
// Updated by TYPO3 Upgrade Wizard 19-07-11 16:21:28
$TYPO3_CONF_VARS['BE']['versionNumberInFilename'] = '0';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 19-07-11 16:22:39
$TYPO3_CONF_VARS['EXT']['extConf']['rtehtmlarea'] = 'a:13:{s:21:"noSpellCheckLanguages";s:23:"ja,km,ko,lo,th,zh,b5,gb";s:15:"AspellDirectory";s:15:"/usr/bin/aspell";s:17:"defaultDictionary";s:2:"en";s:14:"dictionaryList";s:2:"en";s:20:"defaultConfiguration";s:105:"Typical (Most commonly used features are enabled. Select this option if you are unsure which one to use.)";s:12:"enableImages";s:1:"1";s:20:"enableInlineElements";s:1:"0";s:19:"allowStyleAttribute";s:1:"1";s:24:"enableAccessibilityIcons";s:1:"0";s:16:"enableDAMBrowser";s:1:"0";s:16:"forceCommandMode";s:1:"0";s:15:"enableDebugMode";s:1:"0";s:23:"enableCompressedScripts";s:1:"1";}';	//  Modified or inserted by TYPO3 Extension Manager.
// Updated by TYPO3 Extension Manager 05-08-11 04:06:52
$TYPO3_CONF_VARS['GFX']['im_version_5'] = 'im6';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 05-08-11 04:15:43
$TYPO3_CONF_VARS['EXT']['extConf']['powermail'] = 'a:8:{s:10:"usePreview";s:1:"1";s:12:"cssSelection";s:1:"1";s:14:"feusersPrefill";s:70:"name, address, telephone, fax, email, zip, city, country, www, company";s:12:"disableIPlog";s:1:"0";s:20:"disableBackendModule";s:1:"0";s:16:"disableStartStop";s:1:"0";s:7:"useIRRE";s:1:"1";s:12:"fileToolPath";s:9:"/usr/bin/";}';	//  Modified or inserted by TYPO3 Extension Manager.
// Updated by TYPO3 Extension Manager 04-11-14 14:24:02
// Updated by TYPO3 Install Tool 04-11-14 14:30:45
// Updated by TYPO3 Extension Manager 04-11-14 14:30:54
$TYPO3_CONF_VARS['INSTALL']['wizardDone']['tx_rtehtmlarea_deprecatedRteProperties'] = '1';	//  Modified or inserted by TYPO3 Upgrade Wizard.
// Updated by TYPO3 Upgrade Wizard 04-11-14 14:31:01
$TYPO3_CONF_VARS['SYS']['curlUse'] = '1';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 04-11-14 14:31:42
$TYPO3_CONF_VARS['EXT']['extConf']['em'] = 'a:1:{s:17:"selectedLanguages";s:2:"de";}';	//  Modified or inserted by TYPO3 Extension Manager.
// Updated by TYPO3 Extension Manager 04-11-14 14:33:14
$TYPO3_CONF_VARS['GFX']['colorspace'] = 'sRGB';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 29-06-15 10:38:56
// Updated by TYPO3 Extension Manager 22-06-16 14:44:33
?>