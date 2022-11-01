<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005 Urs Maag (urs@maag-matzingen.ch)
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
/**
 * Plugin 'Random Images' for the 'maag_randomimage' extension.
 *
 * @author	Urs Maag <urs@maag-matzingen.ch>
 */


//require_once(PATH_tslib.'class.tslib_pibase.php');
ini_set("include_path", "./");

class tx_maagrandomimage_pi1 extends tslib_pibase {
	var $prefixId = 'tx_maagrandomimage_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_maagrandomimage_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey = 'maag_randomimage';	// The extension key.
	
	/**
	 * [Put your description here]
	 */
	function main($content,$conf)	{
		$this->local_cObj = t3lib_div::makeInstance('tslib_cObj'); // Local cObj.
		$this->conf=$conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

    // Getting values from flexform
    $this->init();
    $this->conf["path"] = $this->lConf["path"];
    $this->conf["bigImagePath"] = $this->lConf["bigImagePath"];
    $this->conf["ignore"] = $this->lConf["ignore"];
    $this->conf["ignorefolder"] = $this->lConf["ignorefolder"];
    $this->conf["ignorefile"] = $this->lConf["ignorefile"];
    $this->conf["useImagemagick"] = $this->lConf["useImagemagick"];
    $this->conf["imparams"] = $this->lConf["imparams"];
    $this->conf["bigimageimparams"] = $this->lConf["bigimageimparams"];
    $this->conf["imcommand"] = $this->lConf["imcommand"];
    $this->conf["imcommandparams"] = $this->lConf["imcommandparams"];
    $this->conf["bigimageimcommand"] = $this->lConf["bigimageimcommand"];
    $this->conf["bigimageimcommandparams"] = $this->lConf["bigimageimcommandparams"];
    $this->conf["count"] = $this->lConf["count"];
    $this->conf["interval"] = $this->lConf["interval"];
    $this->conf["dynamic"] = $this->lConf["dynamic"];
    $this->conf["recursive"] = $this->lConf["recursive"];
    $this->conf["wrap"] = $this->lConf["wrap"];
    $this->conf["link"] = $this->lConf["link"];
    $this->conf["caption"] = $this->lConf["caption"];
    $this->conf["altText"] = $this->lConf["altText"];
	$this->conf["titleText"] = $this->lConf["titleText"];
    $this->conf["showBigImageOnHover"] = $this->lConf["showBigImageOnHover"];
    $this->conf["hideBigImageOnOut"] = $this->lConf["hideBigImageOnOut"];
    $this->conf["marginLeft"] = $this->lConf["marginLeft"];
    $this->conf["marginTop"] = $this->lConf["marginTop"];
    $this->conf["positionLeft"] = $this->lConf["positionLeft"];
    $this->conf["positionTop"] = $this->lConf["positionTop"];
    $this->conf["loadingImageText"] = $this->lConf["loadingImageText"];
    $this->conf["loadingImageStyle"] = $this->lConf["loadingImageStyle"];
    $this->conf["bigImageWrap"] = $this->lConf["bigImageWrap"];
    $this->conf["sort"] = $this->lConf["sort"];
    $this->conf["sortorder"] = $this->lConf["sortorder"];
    $this->conf["sortOnDynamicChange"] = $this->lConf["sortOnDynamicChange"];
    $this->conf["displayonload"] = $this->lConf["displayonload"];
    $this->conf["imagenumber"] = $this->lConf["imagenumber"];
    $this->conf["imagename"] = $this->lConf["imagename"];
    $this->conf["maxwidth"] = $this->lConf["maxwidth"];
    $this->conf["maxheight"] = $this->lConf["maxheight"];
    $this->conf["bigimagemaxwidth"] = $this->lConf["bigimagemaxwidth"];
    $this->conf["bigimagemaxheight"] = $this->lConf["bigimagemaxheight"];
    $this->conf["showDebugInfo"] = $this->lConf["showDebugInfo"];
    $this->conf["changeBigImage"] = $this->lConf["changeBigImage"];
    $this->conf["stdWrap."]["wrap"] = $this->lConf["stdWrap"];
    $this->conf["imageFading"] = $this->lConf["imageFading"];
    $this->conf["imageFadingStyle"] = $this->lConf["imageFadingStyle"];
    $this->conf["imageCaptionStyle"] = $this->lConf["imageCaptionStyle"];
    $this->conf["uniqueKey"] = $this->lConf["uniqueKey"];
	$this->conf["httpsBackend"] = $this->lConf["httpsBackend"];

    // Initialize Conf-Variables
    if (strLen($this->conf["path"]) == 0) {$this->conf["path"] = strLen($conf["path"]) > 0 ? $conf["path"] : 'fileadmin/pict/';}
    if (strLen($this->conf["bigImagePath"]) == 0) {$this->conf["bigImagePath"] = strLen($conf["bigImagePath"]) > 0 ? $conf["bigImagePath"] : 'fileadmin/pict/big/';}
    if (strLen($this->conf["ignore"]) == 0) {$this->conf["ignore"] = strLen($conf["ignore"]) > 0 ? $conf["ignore"] : '';}
    if (strLen($this->conf["ignorefolder"]) == 0) {$this->conf["ignorefolder"] = strLen($conf["ignorefolder"]) > 0 ? $conf["ignorefolder"] : '';}
    if (strLen($this->conf["ignorefile"]) == 0) {$this->conf["ignorefile"] = strLen($conf["ignorefile"]) > 0 ? $conf["ignorefile"] : '';}
    if (strLen($this->conf["useImagemagick"]) == 0) {$this->conf["useImagemagick"] = strLen($conf["useImagemagick"]) > 0 ? $conf["useImagemagick"] : 1;}
    if (strLen($this->conf["imparams"]) == 0) {$this->conf["imparams"] = strLen($conf["imparams"]) > 0 ? $conf["imparams"] : '';}
    if (strLen($this->conf["bigimageimparams"]) == 0) {$this->conf["bigimageimparams"] = strLen($conf["bigimageimparams"]) > 0 ? $conf["bigimageimparams"] : '';}
    if (strLen($this->conf["imcommand"]) == 0) {$this->conf["imcommand"] = strLen($conf["imcommand"]) > 0 ? $conf["imcommand"] : '';}
	if (strLen($this->conf["imcommandparams"]) == 0) {$this->conf["imcommandparams"] = strLen($conf["imcommandparams"]) > 0 ? $conf["imcommandparams"] : '';}
    if (strLen($this->conf["bigimageimcommand"]) == 0) {$this->conf["bigimageimcommand"] = strLen($conf["bigimageimcommand"]) > 0 ? $conf["bigimageimcomamnd"] : '';}
	if (strLen($this->conf["bigimageimcommandparams"]) == 0) {$this->conf["bigimageimcommandparams"] = strLen($conf["bigimageimcommandparams"]) > 0 ? $conf["bigimageimcomamndparams"] : '';}
    if (strLen($this->conf["count"]) == 0) {$this->conf["count"] = is_numeric($conf["count"]) ? $conf["count"] : 1;}
    if (strLen($this->conf["interval"]) == 0) {$this->conf["interval"] = is_numeric($conf["interval"]) ? $conf["interval"] : 5000;}
    if (strLen($this->conf["dynamic"]) == 0) {$this->conf["dynamic"] = is_numeric($conf["dynamic"]) ? $conf["dynamic"] : 1;}
    if (strLen($this->conf["recursive"]) == 0) {$this->conf["recursive"] = strLen($conf["recursive"]) > 0 ? $conf["recursive"] : 0;}
    if (strLen($this->conf["link"]) == 0) {$this->conf["link"] = strLen($conf["link"]) > 0 ? $conf["link"] : '';}
    if (strLen($this->conf["caption"]) == 0) {$this->conf["caption"] = strLen($conf["caption"]) > 0 ? $conf["caption"] : '';}
    if (strLen($this->conf["showBigImageOnHover"]) == 0) {$this->conf["showBigImageOnHover"] = strLen($conf["showBigImageOnHover"]) > 0 ? $conf["showBigImageOnHover"] : 0;}
    if (strLen($this->conf["hideBigImageOnOut"]) == 0) {$this->conf["hideBigImageOnOut"] = strLen($conf["hideBigImageOnOut"]) > 0 ? $conf["hideBigImageOnOut"] : 1;}
    if (strLen($this->conf["marginLeft"]) == 0) {$this->conf["marginLeft"] = is_numeric($conf["marginLeft"]) ? $conf["marginLeft"] : 0;}
    if (strLen($this->conf["marginTop"]) == 0) {$this->conf["marginTop"] = is_numeric($conf["marginTop"]) ? $conf["marginTop"] : 0;}
    if (strLen($this->conf["positionLeft"]) == 0) {$this->conf["positionLeft"] = strLen($conf["positionLeft"]) > 0 ? $conf["positionLeft"] : 'relative';}
    if (strLen($this->conf["positionTop"]) == 0) {$this->conf["positionTop"] = strLen($conf["positionTop"]) > 0 ? $conf["positionTop"] : 'relative';}
    if (strLen($this->conf["loadingImageText"]) == 0) {$this->conf["loadingImageText"] = strLen($conf["loadingImageText"]) > 0 ? $conf["loadingImageText"] : 'Loading&nbsp;Image&nbsp;...';}
    if (strLen($this->conf["loadingImageStyle"]) == 0) {$this->conf["loadingImageStyle"] = strLen($conf["loadingImageStyle"]) > 0 ? $conf["loadingImageStyle"] : 'padding: 10px; background-color: white; color: silver; border: 2px solid silver; font-weight: bold;';}
    if (strLen($this->conf["bigImageWrap"]) == 0) {$this->conf["bigImageWrap"] = strLen($conf["bigImageWrap"]) > 0 ? $conf["bigImageWrap"] : '';}
    if (strLen($this->conf["sort"]) == 0) {$this->conf["sort"] = strLen($conf["sort"]) > 0 ? $conf["sort"] : 1;}
    if (strLen($this->conf["sortorder"]) == 0) {$this->conf["sortorder"] = strLen($conf["sortorder"]) > 0 ? $conf["sortorder"] : 1;}
    if (strLen($this->conf["sortOnDynamicChange"]) == 0) {$this->conf["sortOnDynamicChange"] = is_numeric($conf["sortOnDynamicChange"]) ? $conf["sortOnDynamicChange"] : 0;}
    if (strLen($this->conf["displayonload"]) == 0) {$this->conf["displayonload"] = strLen($conf["displayonload"]) > 0 ? $conf["displayonload"] : 0;}
    if (strLen($this->conf["imagenumber"]) == 0) {$this->conf["imagenumber"] = is_numeric($conf["imagenumber"]) ? $conf["imagenumber"] : 0;}
    if ($this->conf["imagenumber"] < 0) {$this->conf["imagenumber"] = 0;}
    if ($this->conf["imagenumber"] > $this->conf["count"]) {$this->conf["imagenumber"] = 0;}
    if (strLen($this->conf["imagename"]) == 0) {$this->conf["imagename"] = strLen($conf["imagename"]) > 0 ? $conf["imagename"] : '';}
    if (strLen($this->conf["maxwidth"]) == 0) {$this->conf["maxwidth"] = is_numeric($conf["maxwidth"]) ? $conf["maxwidth"] : '';}
    if (strLen($this->conf["maxheight"]) == 0) {$this->conf["maxheight"] = is_numeric($conf["maxheight"]) ? $conf["maxheight"] : '';}
    if (strLen($this->conf["bigimagemaxwidth"]) == 0) {$this->conf["bigimagemaxwidth"] = is_numeric($conf["bigimagemaxwidth"]) ? $conf["bigimagemaxwidth"] : '';}
    if (strLen($this->conf["bigimagemaxheight"]) == 0) {$this->conf["bigimagemaxheight"] = is_numeric($conf["bigimagemaxheight"]) ? $conf["bigimagemaxheight"] : '';}
    if (strLen($this->conf["showDebugInfo"]) == 0) {$this->conf["showDebugInfo"] = strLen($conf["showDebugInfo"]) > 0 ? $conf["showDebugInfo"] : 0;}
    if (strLen($this->conf["changeBigImage"]) == 0) {$this->conf["changeBigImage"] = strLen($conf["changeBigImage"]) > 0 ? $conf["changeBigImage"] : 0;}
    if (strLen($this->conf["stdWrap."]["wrap"]) == 0) {$this->conf["stdWrap."]["wrap"] = strLen($conf["stdWrap."]["wrap"]) > 0 ? $conf["stdWrap."]["wrap"] : '';}
    if (strLen($this->conf["imageFading"]) == 0) {$this->conf["imageFading"] = strLen($conf["imageFading"]) > 0 ? $conf["imageFading"] : 0;}
    if (strLen($this->conf["imageFadingStyle"]) == 0) {$this->conf["imageFadingStyle"] = strLen($conf["imageFadingStyle"]) > 0 ? $conf["imageFadingStyle"] : '';}
    if (strLen($this->conf["imageCaptionStyle"]) == 0) {$this->conf["imageCaptionStyle"] = strLen($conf["imageCaptionStyle"]) > 0 ? $conf["imageCaptionStyle"] : '';}
    if (strLen($this->conf["uniqueKey"]) == 0) {$this->conf["uniqueKey"] = strLen($conf["uniqueKey"]) > 0 ? $conf["uniqueKey"] : $GLOBALS['TSFE']->id;}
	if (strLen($this->conf["httpsBackend"]) == 0) {$this->conf["httpsBackend"] = strLen($conf["httpsBackend"]) > 0 ? $conf["httpsBackend"] : 0;}

    // Unique Prefix for ID of Image-Tags
    $imgName = 'di'.md5(uniqid(rand(), true));
    $bigImageId = 'di'.md5(uniqid(rand(), true));
    $bigImageImageId = 'di'.md5(uniqid(rand(), true));
    $bigImageMessageId = 'di'.md5(uniqid(rand(), true));

    // Select Images
    $imgArray = '';
    $this->conf['internal'] = 1;
    require_once('randomimage.php');
    $images = user_randomimage::main_randomimage('', $this->conf);
    $imgArray = explode("\n", $images);

    // Setting Big Image On Load
    if ($this->conf["displayonload"] == 1)
    {
      if ($this->conf["imagename"] != '')
      {
        $loadingImage = $this->conf["imagename"];
      }
      else
      {
        if ($this->conf["imagenumber"] > 0) {$imagenumber = $this->conf["imagenumber"]-1;} else {srand(microtime()*1000000); $imagenumber = rand(1, $this->conf["count"]);}
        $tempArray = explode("x;x", $imgArray[$imagenumber]);
        $loadingImage = $tempArray[2];
      }

      $g = t3lib_div::makeInstance('t3lib_stdGraphic');
      $g->init();
      $optionsBigImage["maxW"] = $this->conf["bigimagemaxwidth"];$optionsBigImage["maxH"] = $this->conf["bigimagemaxheight"];
      $bigFile = $g->imageMagickConvert($loadingImage,'WEB','','',$this->conf['bigimageimparams'],'',$optionsBigImage);
      $bigImageTag = '<img id="'.$bigImageImageId.'" src="'.$bigFile[3].'" alt="" border="0" style="display: none;" />';
    }

    // Setting Big Image DIV to no source, when not "show big image on load" is selected
    if ($this->conf["showBigImageOnHover"] == 1 && $this->conf["displayonload"] == 0)
    {
      $bigImageTag = '<img id="'.$bigImageImageId.'" src="clear.gif" alt="" border="0" style="display: none;" />';
    }

    // Add DIV for displaying the big image
    if ($this->conf["showBigImageOnHover"] == 1 || $this->conf["displayonload"] == 1)
    {
      $bigImage = $bigImageTag;
      $bigImage.= '<span id="'.$bigImageMessageId.'" style="'.$this->conf["loadingImageStyle"].'; display: none;">';
      $bigImage.= $this->conf["loadingImageText"];
      $bigImage.= '</span>';
      if (strLen($this->conf["bigImageWrap"]) > 0) { $bigImage = str_replace('|', $bigImage, $this->conf['bigImageWrap']); }
      $content.= '<div id="'.$bigImageId.'" style="display: none;">'.$bigImage.'</div>';
    }

    // Render Images
    if (substr($images, 0, 32) != 'Exception in RandomImage-Plugin:')
    {
      for ($i=1; $i<=$this->conf["count"]; $i++)
      {
        // Copy Properties from IMAGE-Object
        if (is_array($conf['image.']))
        {
          foreach ($conf['image.'] as $imageConfigKey => $imageConfigValue)
          {
            if (!is_numeric(str_replace('.', '', $imageConfigKey)))
            {
              if (trim($conf['image.'][($i).'.'][$imageConfigKey]) == '')
              {
                $conf['image.'][($i).'.'][$imageConfigKey] = $imageConfigValue;
              }
            }
          }
        }

        // Add "link" property to specific image
        if ($conf['image.'][($i).'.']['link'] == '')
        {
          $conf['image.'][($i).'.']['link'] = $this->conf["link"];
        }

        // Add "altText" property to specific image
        if ($this->isNewerThan449())	{
			if ($conf['image.'][($i).'.']['altText'] == '')
			{
			$conf['image.'][($i).'.']['altText'] = $this->conf["altText"];
			}
		}	else	{
			if ($conf['image.'][($i).'.']['alttext'] == '')
			{
			$conf['image.'][($i).'.']['alttext'] = $this->conf["altText"];
			}
		}
		
		// Add "titleText" property to specific image
        if ($conf['image.'][($i).'.']['titleText'] == '')
		{
			$conf['image.'][($i).'.']['titleText'] = $this->conf["titleText"];
		}

        // Add "caption" property to specific image
        if ($conf['image.'][($i).'.']['caption'] == '')
        {
          $conf['image.'][($i).'.']['caption'] = $this->conf["caption"];
        }

        // Add "imageCaptionStyle" property to specific image
        if ($conf['image.'][($i).'.']['caption.']['style'] == '')
        {
          $conf['image.'][($i).'.']['caption.']['style'] = $this->conf["imageCaptionStyle"];
        }

        // Add "imageFading" property to specific image
        if ($conf['image.'][($i).'.']['fading'] == '')
        {
          $conf['image.'][($i).'.']['fading'] = $this->conf["imageFading"];
        }

        // Add "imageFadingStyle" property to specific image
        if ($conf['image.'][($i).'.']['fading.']['style'] == '')
        {
          $conf['image.'][($i).'.']['fading.']['style'] = $this->conf["imageFadingStyle"];
        }

        // Setting params of IMAGE-Object
        $conf['image.'][($i).'.']['params'].= ' id="'.$imgName.$i.'"';
        if ($this->conf["showBigImageOnHover"] == 1)
        {
          $conf['image.'][($i).'.']['params'].= ' onmouseover="new RandomImage_MouseOver(\''.$bigImageId.'\', \''.$bigImageImageId.'\', \''.$bigImageMessageId.'\', this, \''.$imgName.'\', '.$this->conf["marginLeft"].', '.$this->conf["marginTop"].', '.'\''.$this->conf["positionLeft"].'\''.', '.'\''.$this->conf["positionTop"].'\''.', '.$i.').Main();"';
        }
        if ($this->conf["hideBigImageOnOut"] == 1 && $this->conf["showBigImageOnHover"] == 1)
        {
          $conf['image.'][($i).'.']['params'].= ' onmouseout="RandomImage_MouseOut(\''.$bigImageId.'\', \''.$bigImageImageId.'\', \''.$bigImageMessageId.'\');"';
        }
        if ($this->conf["changeBigImage"] == 1 && $this->conf["showBigImageOnHover"] == 1)
        {
          $conf['image.'][($i).'.']['params'].= ' onmousemove="RandomImage_MouseMove(\''.$bigImageId.'\', \''.$bigImageImageId.'\', \''.$bigImageMessageId.'\', document.getElementById(\''.$imgName.$i.'\'), \''.$imgName.'\', '.$this->conf["marginLeft"].', '.$this->conf["marginTop"].', '.'\''.$this->conf["positionLeft"].'\''.', '.'\''.$this->conf["positionTop"].'\''.', '.$i.');"';
        }

        // Make temporary Array with Image-Informations from randomimage.php
        $tempArray = explode("x;x", $imgArray[$i-1]);

        // Set wrap property from general wrap property
        if (strLen($this->conf["wrap"]) > 0) { $conf['image.'][($i).'.']['wrap'] = $this->conf['wrap']; }

        // Wrap definitions, if user has no wrap-properties set
        if ($conf['image.'][($i).'.']['wrap'] == '')
        {
          // ... with imagefading ...
          if ($conf['image.'][($i).'.']['fading'] == 1)
          {
            $conf['image.'][($i).'.']['wrap'] = '<div ';
            if ($conf['image.'][($i).'.']['fading.']['style'] != '') { $conf['image.'][($i).'.']['wrap'] .= 'style="background-repeat: no-repeat; '.$conf['image.'][($i).'.']['fading.']['style'].'" '; } else { $conf['image.'][($i).'.']['wrap'] .= 'style="background-repeat: no-repeat;" '; }
            $conf['image.'][($i).'.']['wrap'] .= 'id="fd_'.$imgName.'_'.$i.'">|';
            if (strLen($conf['image.'][($i).'.']['caption']) > 0)
            {
              $caption = user_randomimage::getCaption($tempArray[0], $conf['image.'][($i).'.']['caption']);
              $conf['image.'][($i).'.']['wrap'] .= '<div ';
              if ($conf['image.'][($i).'.']['caption.']['style'] != '') { $conf['image.'][($i).'.']['wrap'] .= 'style="'.$conf['image.'][($i).'.']['caption.']['style'].'" '; }
              $conf['image.'][($i).'.']['wrap'] .= 'id="cap_'.$imgName.$i.'">'.$caption.'</div>';
            }
            $conf['image.'][($i).'.']['wrap'] .= '</div>';
          }
          // ... without imagefading ...
          else
          {
            if (strLen($conf['image.'][($i).'.']['caption']) > 0)
            {
              $caption = user_randomimage::getCaption($tempArray[0], $conf['image.'][($i).'.']['caption']);
              $conf['image.'][($i).'.']['wrap'] = '|<div ';
              if ($conf['image.'][($i).'.']['caption.']['style'] != '') { $conf['image.'][($i).'.']['wrap'] .= 'style="'.$conf['image.'][($i).'.']['caption.']['style'].'" '; }
              $conf['image.'][($i).'.']['wrap'] .= 'id="cap_'.$imgName.$i.'">'.$caption.'</div>';
            }
          }
        }
        // Wrap definitions, if user has set wrap-properties
        else
        {
          $pos = strpos($conf['image.'][($i).'.']['wrap'], '|');
          $left = substr($conf['image.'][($i).'.']['wrap'], 0, $pos);
          $right = substr($conf['image.'][($i).'.']['wrap'], $pos + 1);
          $tempImageWrap = $conf['image.'][($i).'.']['wrap'];

          // ... with imagefading
          if ($conf['image.'][($i).'.']['fading'] == 1)
          {
            $conf['image.'][($i).'.']['wrap'] = $left.'<div ';
            if ($conf['image.'][($i).'.']['fading.']['style'] != '') { $conf['image.'][($i).'.']['wrap'] .= 'style="background-repeat: no-repeat; '.$conf['image.'][($i).'.']['fading.']['style'].'" '; } else { $conf['image.'][($i).'.']['wrap'] .= 'style="background-repeat: no-repeat;" '; }
            $conf['image.'][($i).'.']['wrap'] .= 'id="fd_'.$imgName.'_'.$i.'">|';
            if (strLen($conf['image.'][($i).'.']['caption']) > 0)
            {
              $caption = user_randomimage::getCaption($tempArray[0], $conf['image.'][($i).'.']['caption']);
              $conf['image.'][($i).'.']['wrap'] .= '<div ';
              if ($conf['image.'][($i).'.']['caption.']['style'] != '') { $conf['image.'][($i).'.']['wrap'] .= 'style="'.$conf['image.'][($i).'.']['caption.']['style'].'" '; }
              $conf['image.'][($i).'.']['wrap'] .= 'id="cap_'.$imgName.$i.'">'.$caption.'</div>'.$right;
              $conf['image.'][($i).'.']['wrap'] .= '</div>';
            }
            else
            {
              $conf['image.'][($i).'.']['wrap'] .= '</div>';
              $conf['image.'][($i).'.']['wrap'] .= $right;
            }
          }
          // ... without imagefading
          else
          {
            if (strLen($conf['image.'][($i).'.']['caption']) > 0)
            {
              $conf['image.'][($i).'.']['wrap'] = $left;
              $caption = user_randomimage::getCaption($tempArray[0], $conf['image.'][($i).'.']['caption']);
              $conf['image.'][($i).'.']['wrap'] .= '|<div ';
              if ($conf['image.'][($i).'.']['caption.']['style'] != '') { $conf['image.'][($i).'.']['wrap'] .= 'style="'.$conf['image.'][($i).'.']['caption.']['style'].'" '; }
              $conf['image.'][($i).'.']['wrap'] .= 'id="cap_'.$imgName.$i.'">'.$caption.'</div>';
              $conf['image.'][($i).'.']['wrap'] .= $right;
            }
          }
        }

        // Setting Alt-Text of images with patterns
        $alttext[$i] = $conf['image.'][($i).'.']['alttext'];
        $conf['image.'][($i).'.']['alttext'] = user_randomimage::getAlt($tempArray[0], $conf['image.'][($i).'.'] ['alttext']);

        // Setting Title-Text of images with patterns
        $titletext[$i] = $conf['image.'][($i).'.']['titleText'];
        $conf['image.'][($i).'.']['titleText'] = user_randomimage::getTitle($tempArray[0], $conf['image.'][($i).'.'] ['titleText']);

		// Setting link of IMAGE-Object
        if (strLen($conf['image.'][($i).'.']['link']) > 0)
        {
		  if (trim(strtolower($conf['image.'][($i).'.']['link'])) == 'none')
          {
            $conf['image.'][($i).'.']['imageLinkWrap'] = 0;
            $conf['image.'][($i).'.']['imageLinkWrap.']['enable'] = 0;
            $conf['image.'][($i).'.']['imageLinkWrap.']['typolink.']['parameter'] = '';
          }
          else
          {
            $conf['image.'][($i).'.']['imageLinkWrap'] = 1;
            $conf['image.'][($i).'.']['imageLinkWrap.']['enable'] = 1;
            $link = user_randomimage::getLink($tempArray[0], $conf['image.'][($i).'.']['link']);
            $conf['image.'][($i).'.']['imageLinkWrap.']['typolink.']['parameter'] = $link;
          }
        }

        // If a imageLinkWrap with typolink or a txt-file with link is there -> add the id to the typolink
        // 04.04.2012 - bug fix add the id to the typolink (thanks to Ewout de Boer)
		if ($conf['image.'][($i).'.']['imageLinkWrap.']['enable'] == 1 || trim($tempArray[3]) != '')
        {
          $conf['image.'][($i).'.']['imageLinkWrap.']['typolink.']['ATagParams'] .= ' id="lnk_'.$imgName.$i.'" ';
        }
		// 04.04.2012 - end bug fix add the id to the typolink (thanks to Ewout de Boer)

        // If a txt-file with link is there -> take this infos for link
        if (trim($tempArray[3]) != '')
        {
		  // 14.03.2012 - bug fix, setting conf variables to suerly enable imageLinkWrap (thanks to Stefan Froemken)
		  $conf['image.'][($i).'.']['imageLinkWrap'] = 1;
          $conf['image.'][($i).'.']['imageLinkWrap.']['enable'] = 1;
		  // 14.03.2012 - end bug fix, setting conf variables to suerly enable imageLinkWrap (thanks to Stefan Froemken)
		  $conf['image.'][($i).'.']['imageLinkWrap.']['typolink.']['parameter'] = user_randomimage::getLink('xxx', trim($tempArray[3]));
        }

        //Render IMAGE-Object
        $contentImage = $this->cObj->cImage($tempArray[1], $conf['image.'][($i).'.']);

        // Setting back the Wrap-Property
        $conf['image.'][($i).'.']['wrap'] = $tempImageWrap;

        // Wrap DIV's around the IMAGE-Object
        if ($this->conf['dynamic'] == 1) {$contentImage.='<div id="fi_'.$imgName.'_'.$i.'" style="display:none;">'.$tempArray[0].'</div>';}
        if ($this->conf["showBigImageOnHover"] == 1) {$contentImage.='<div id="bi_'.$imgName.'_'.$i.'" style="display:none;">../../../../'.$tempArray[2].'</div>';}

        // Copy rendered IMAGE-Object to content
        $content.=$contentImage;
      }

      // DIV for Debug-Informations of Javascript
      if ($this->conf["showDebugInfo"] == 1 && $this->conf['dynamic'] == 1)
      {
        $content .= '<div id="randomimages_debug" style="color: black;"><strong>Random Images Debug-Information:</strong><br />';
        $content .= '<input type="button" id="randomimages_interval" onclick="RandomImage_StartStopInterval()" value="stop interval" /><br /><br />';
        $content .= '</div>'."\n";
      }
    }
    else
    {
      $content = '<span style="font-weight: bold;">'.$images.'</span>';
    }

    // Insert Javascript-File
    if ($this->conf["dynamic"] == 1 || $this->conf["displayonload"] == 1 || $this->conf["showBigImageOnHover"] == 1)
    {
      $jsDynamicImage = t3lib_extMgm::siteRelPath('maag_randomimage').'pi1/DynamicImage.js';
      if (!$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_js'])
      {
        $GLOBALS['TSFE']->additionalHeaderData['dynamicImage_js'] = '<script type="text/javascript" language="Javascript" src="'.$jsDynamicImage.'"></script>';
      }
    }

    // Add Functions for load event
    if ($this->conf["dynamic"] == 1 || $this->conf["displayonload"] == 1 || ($this->conf["showBigImageOnHover"] == 1 && $this->conf["hideBigImageOnOut"] != 1))
    {
      // Add dynamic call for dynamic change image
      if ($this->conf["dynamic"] == 1)
      {
        // Set imageFading for dynamic calls
        $fadings = '';
        for ($i=1; $i<=$this->conf["count"]; $i++)
        {
          if ($fadings != '') { $fadings .= 'x;x'; }
          $fadings .= $conf['image.'][($i).'.']['fading'];
        }

        // Set altText for dynamic calls
        $alts = '';
        for ($i=1; $i<=$this->conf["count"]; $i++)
        {
          if ($alts != '') { $alts .= 'x;x'; }
          $alts .= $alttext[$i];
        }
		
		// Set titleText for dynamic calls
        $titles = '';
        for ($i=1; $i<=$this->conf["count"]; $i++)
        {
          if ($titles != '') { $titles .= 'x;x'; }
          $titles .= $titletext[$i];
        }

        // Set captions for dynamic calls
        $captions = '';
        for ($i=1; $i<=$this->conf["count"]; $i++)
        {
          if ($captions != '') { $captions .= 'x;x'; }
          $captions .= $conf['image.'][($i).'.']['caption'];
        }

        // Set links for dynamic calls
        $links = '';
        for ($i=1; $i<=$this->conf["count"]; $i++)
        {
          if ($links != '') { $links .= 'x;x'; }
          $links .= $conf['image.'][($i).'.']['link'];
        }

        // Set onload event for dynamic change
        $phpDynamicImage = t3lib_extMgm::siteRelPath('maag_randomimage').'pi1/randomimage.php';
        $onload = 'new DynamicRandomImage("'.$this->conf["uniqueKey"].'", "'.$phpDynamicImage.'", "'.$imgName.'", '.$this->conf["interval"].', "'.$this->conf["path"].'", "'.$this->conf["bigImagePath"].'", '.$this->conf["count"].', '.$this->conf["dynamic"].', '.$this->conf["recursive"].', "'.$this->conf["ignore"].'", "'.$this->conf["ignorefolder"].'", "'.$this->conf["ignorefile"].'", '.$this->conf["sort"].', '.$this->conf["sortorder"].', '.$this->conf["sortOnDynamicChange"].', \''.$this->conf["maxwidth"].'\', \''.$this->conf["maxheight"].'\', \''.$this->conf["bigimagemaxwidth"].'\', \''.$this->conf["bigimagemaxheight"].'\', \''.$fadings.'\', '.$this->conf["useImagemagick"].', '.$this->conf["showDebugInfo"].', \''.$captions.'\', \''.$links.'\', \''.$alts.'\', \''.$titles.'\', \''.$this->conf['imparams'].'\', \''.$this->conf['bigimageimparams'].'\', \''.$this->conf['imcommand'].'\', \''.$this->conf['imcommandparams'].'\', \''.$this->conf['bigimageimcommand'].'\', \''.$this->conf['bigimageimcommandparams'].'\', '.($this->conf["count"]-1).', '.$this->conf["httpsBackend"].').randomize();';
      }

      // Add event for displaying the big image on page load
      if ($this->conf["displayonload"] == 1)
      {
        if ($this->conf["imagename"] == '')
        {
          if ($this->conf["imagenumber"] > 0) {$imagenumber = $this->conf["imagenumber"];} else {srand(microtime()*1000000); $imagenumber = rand(1, $this->conf["count"]);}
          $displayonload = 'RandomImage_ShowOnLoad(\''.$bigImageId.'\', '.'\''.$this->conf["positionLeft"].'\''.', '.$this->conf["marginLeft"].', '.'\''.$this->conf["positionTop"].'\''.', '.$this->conf["marginTop"].', document.getElementById("'.$imgName.$imagenumber.'"), "'.$bigImageImageId.'", "'.$imgName.'");';
        }
        else
        {
          $displayonload = 'RandomImage_ShowOnLoad(\''.$bigImageId.'\', '.'\''.$this->conf["positionLeft"].'\''.', '.$this->conf["marginLeft"].', '.'\''.$this->conf["positionTop"].'\''.', '.$this->conf["marginTop"].', document.getElementById("'.$imgName.'1"), "'.$bigImageImageId.'", "'.$imgName.'");';
        }
      }

      // Resize event for repositioning big image on browser resize
      if ($this->conf["displayonload"] == 1 || ($this->conf["showBigImageOnHover"] == 1 && $this->conf["hideBigImageOnOut"] != 1))
      {
        $resize .= 'if (objLastPosition["'.$bigImageId.'"]) {RandomImage_SetPosition("", "", "", "", "", "", "", objLastPosition["'.$bigImageId.'"]);};';
      }

      // Setting flags for rendering the javascript-code
      if ($this->conf["dynamic"] == 1 || $onload != '' || $displayonload != '') {$loadJS = true;} else {$loadJS = false;}
      if ($resize != '') {$resizeJS = true;} else {$resizeJS = false;}

      // Add Javascript-Code for load and resize event
      if ($loadJS || $resizeJS)
      {
        if (!$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_script_begin'])
        {
          $GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_script_begin'] = '<script type="text/javascript" language="Javascript">';

          if ($loadJS)	{
			$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_event_load'] = 'if (window.addEventListener) {window.addEventListener(\'load\', funDynamicImagesLoad, false);} else if (window.attachEvent) {window.attachEvent (\'onload\', funDynamicImagesLoad);}';
		  }
		  if ($resizeJS)	{
			$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_event_resize'] = 'if (window.addEventListener) {window.addEventListener(\'resize\', funDynamicImagesResize, false);} else if (window.attachEvent) {window.attachEvent (\'onresize\', funDynamicImagesResize);}';
		  }

          if ($loadJS)	{
			$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_load_begin'] = 'function funDynamicImagesLoad() {';
			$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_load_content'] = '// execute load events of randomimages'."\n";
			if ($onload != '') {$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_load_content'] .= $onload."\n";}
			if ($onload != '' && $displayonload != '') {$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_load_content'] .= "\n";}
			if ($displayonload != '') {$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_load_content'] .=  $displayonload."\n";}
			$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_load_content'] .= '}';
		  }

          if ($resizeJS)	{
			$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_resize_begin'] = 'function funDynamicImagesResize() {';
			$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_resize_content'] .= '// repositioning big image on resize'."\n";
			if ($resize != '') {$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_resize_content'] .= $resize."\n";}
			$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_resize_content'] .= '}';
		  }

          $GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_script_end'] = '</script>';
        }
        else
        {
          if ($loadJS)	{
			if ($onload != '') {$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_load_content'] .= $onload."\n";}
			if ($displayonload != '') {$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_load_content'] .=  $displayonload."\n";}
		  }
		  if ($resizeJS)	{
			if ($resize != '') {$GLOBALS['TSFE']->additionalHeaderData['dynamicImage_call_function_resize_content'] .= $resize."\n";}
		  }
        }
      }
    }

		return ($this->local_cObj->stdWrap($content, $this->conf['stdWrap.']));
	}


  // Initializes the flexform and all config options
  function init()
  {
	$this->pi_initPIflexForm();
    $this->lConf = array();
    $piFlexForm = $this->cObj->data['pi_flexform'];

    if (is_array($piFlexForm['data']))
    {
      foreach ($piFlexForm['data'] as $sheet => $data)
      foreach ($data as $lang => $value)
      foreach ($value as $key => $val)
      $this->lConf[$key] = $this->pi_getFFvalue($piFlexForm, $key, $sheet);
    }
  }
  
  // checks the typo3 version, if it is newer than version 4.4.9
  function isNewerThan449()	{
	$version = class_exists('t3lib_utility_VersionNumber') ? t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) : t3lib_div::int_from_ver(TYPO3_version);
	if ($version >= 4005000)	{
		return true;
	}	else	{
		return false;
	}
  }
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/maag_randomimage/pi1/class.tx_maagrandomimage_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/maag_randomimage/pi1/class.tx_maagrandomimage_pi1.php']);
}
?>