<?php 

$GLOBALS["dirs"] = "";
$GLOBALS["relativeToRoot"] = "../../../../";

// Get a small random image
if ($_GET["path"] != '') {
  define('TYPO3_MOD_PATH', '../typo3conf/ext/maag_randomimage/pi1/');
  define('TYPO3_PROCEED_IF_NO_USER', true);

  if ($_GET['httpsBackend'] == 1)	{
	define('HTTPS_BACKEND', true);
	require_once('init.php');
  } else {
	require_once($GLOBALS["relativeToRoot"].'typo3/'.'init.php');
  }
  
  $version = class_exists('t3lib_utility_VersionNumber') ? t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) : t3lib_div::int_from_ver(TYPO3_version);
  if ($version < 6000000)	{
	require_once($GLOBALS["relativeToRoot"].'t3lib/'.'config_default.php');
  }
  require_once($GLOBALS["relativeToRoot"].'t3lib/'.'class.t3lib_stdgraphic.php');

  $conf["uniqueKey"] = $_GET["uniqueKey"];
  $conf["path"] = $_GET["path"];
  $conf["bigImagePath"] = $_GET["bigImagePath"];
  $conf["count"] = $_GET["count"];
  $conf["dynamic"] = $_GET["dynamic"];
  $conf["recursive"] = $_GET["recursive"];
  $conf["ignore"] = $_GET["ignore"];
  $conf["ignorefolder"] = $_GET["ignorefolder"];
  $conf["ignorefile"] = $_GET["ignorefile"];
  $conf["sort"] = $_GET["sort"];
  $conf["sortorder"] = $_GET["sortorder"];
  $conf["sortOnDynamicChange"] = $_GET["sortOnDynamicChange"];
  $conf["currentImageIndex"] = $_GET["curindex"];
  $conf["maxwidth"] = $_GET["imw"];
  $conf["maxheight"] = $_GET["imh"];
  $conf["bigimagemaxwidth"] = $_GET["bmw"];
  $conf["bigimagemaxheight"] = $_GET["bmh"];
  $conf["useImagemagick"] = $_GET["im"];
  $conf["caption"] = $_GET["caption"];
  $conf["link"] = $_GET["link"];
  $conf["alttext"] = $_GET["alt"];
  $conf["titleText"] = $_GET["title"];
  $conf["imparams"] = $_GET["imparams"];
  $conf["bigimageimparams"] = $_GET["biimparams"];  
  $conf["imcommand"] = str_replace('\"', '"', $_GET["imcommand"]);
  $conf["imcommandparams"] = str_replace('\"', '"', $_GET["imcommandparams"]);
  $conf["bigimageimcommand"] = str_replace('\"', '"', $_GET["biimcommand"]);  
  $conf["bigimageimcommandparams"] = str_replace('\"', '"', $_GET["biimcommandparams"]);
  $conf["internal"] = 0;

  echo(user_randomimage::main_randomimage('', $conf));
}


class user_randomimage {

  function main_randomimage($content, $conf) {
    // Constants
    if ($conf["internal"] != 1)
    {
      $relativeToRoot = $GLOBALS["relativeToRoot"];
    }

    // Initialize
    $fpath = $relativeToRoot.$conf["path"];
    $bigImagePath = $relativeToRoot.$conf["bigImagePath"];
    $count = is_numeric($conf["count"]) ? $conf["count"] : 1;
    $recursive = $conf["recursive"];
    $sort = $conf["sort"];
    $sortorder = $conf["sortorder"];

    $rimage = array();
    $rimageIndex = array();
    $ignorePath = explode(',', $conf["ignore"]);
    $ignoreFolder = explode(',', $conf["ignorefolder"]);
    if (trim($conf["ignorefile"]) != '') {$conf["ignorefile"].=',';}
    $conf["ignorefile"].='^.+[\.txt|\.cap|\.wat|\.alt|\.tit]$';
    $ignoreFile = explode(',', $conf["ignorefile"]);

    // check path (do not let it over apache's document root!)
	if (!user_randomimage::validatePath($fpath, $relativeToRoot))	{
   	  $content = 'Exception in RandomImage-Plugin:<br/><span style="color: red">Invalid path: &laquo;'.htmlentities(trim($fpath)).'&raquo; is going to another path than &laquo;fileadmin/...&raquo; or &laquo;user_upload/...&raquo;!</span>'."\n";
   	  return $content;
    }

    // check bigImagePath (do not let it over apache's document root!)
	if (!user_randomimage::validatePath($bigImagePath, $relativeToRoot))	{
   	  $content = 'Exception in RandomImage-Plugin:<br/><span style="color: red">Invalid big image path: &laquo;'.htmlentities(trim($bigImagePath)).'&raquo; is going to another path than &laquo;fileadmin/...&raquo; or &laquo;user_upload/...&raquo;!</span>'."\n";
   	  return $content;
    }

    // Formatting the ignore path
    $newIgnorePath = '';
    foreach($ignorePath as $ip)
    {
      $p = trim($ip);
      if (substr($p, strLen($p)-1, 1) == '/' or substr($p, strLen($p)-1, 1) == '\\') {$p = substr($p, 0, strLen($p)-1);}
      if (strLen($newIgnorePath) != 0) {$newIgnorePath = $newIgnorePath.',';}
      $newIgnorePath = $newIgnorePath.$relativeToRoot.trim($p);
    }
    $ignorePath = explode(',', $newIgnorePath);

    // Add slash (/) to the end of the directory, if not exists (image-path)
    if (substr($fpath, strLen($fpath)-1, 1) != '/')
    {
      $fpath.='/';
    }

    // Add slash (/) to the end of the directory, if not exists (big-image-path)
    if (substr($bigImagePath, strLen($bigImagePath)-1, 1) != '/')
    {
      $bigImagePath.='/';
    }

    // Loop Directory
    $GLOBALS["dirs"] = '';
    loopDirectory($fpath, $recursive, $ignorePath, $ignoreFolder);

    // Add random image to array
    $dirsArray = explode(";", $GLOBALS["dirs"]);
    foreach($dirsArray as $dir)
    {
      if (is_dir("$dir"))
      {
        $dh = opendir($dir);
        while (false !== ($filename = readdir($dh)))
        {
          // Add File to array, only if it's not a directory
          if ($filename != "." && $filename != ".." && !is_dir($dir."/".$filename))
          {
            // Compare with ignoreFiles expression
            $ignore = false;
            foreach ($ignoreFile as $if)
            {
              if (trim($if) != '')
              {
                if (preg_match("/^{.+}/", trim($if)) > 0)
                {
                  if (@preg_match(trim($if), $dir."/".$filename) > 0)
                  {
                    $ignore = true; break;
                  }
                  if (@preg_match(trim($if), $dir."/".$filename) === false)
                  {
                    $content = 'Exception in RandomImage-Plugin:<br/><span style="color: red">no valid expression in ignoreFiles: &laquo;'.htmlentities(trim($if)).'&raquo;</span>'."\n";
                    return $content;
                  }
                }
                else
                {
                  if (@preg_match("{".trim($if)."}", $dir."/".$filename) > 0)
                  {
                    $ignore = true; break;
                  }
                  if (@preg_match("{".trim($if)."}", $dir."/".$filename) === false)
                  {
                    $content = 'Exception in RandomImage-Plugin:<br/><span style="color: red">no valid expression in ignoreFiles: &laquo;'.htmlentities(trim($if)).'&raquo;</span>'."\n";
                    return $content;
                  }
                }
              }
            }

            // Add file to array, only if it's not in ignoreFiles expression
            if (!$ignore)
            {
              if (substr($dir, strLen($dir)-1, 1) != '/')	{
            	$rimage[] = $dir."/".$filename;
              } else {
              	$rimage[] = $dir.$filename;
              }
            }
          }
        }
        closedir($dh);
      }
      else
      {
        if ($dir != '')
        {
          $content = 'Exception in RandomImage-Plugin:<br/><span style="color: red">Path &laquo;'.htmlentities($dir).'&raquo; not found!</span>'."\n";
          return $content;
        }
      }
    }

    // Add Images without current images on client
    $x = 0;
    for ($j=0; $j<count($rimage); $j++)
    {
      $kickOut = false;

      // Getting weight and time of image
      $weightAndTime = user_randomimage::getWeightAndTime($rimage[$j], "")." ";
      $weightAndTimeArray[0] = substr($weightAndTime, 0, strpos($weightAndTime, ' '));
      $weightAndTimeArray[1] = substr($weightAndTime, strpos($weightAndTime, ' ') + 1);
      $weight = trim($weightAndTimeArray[0]);
      if (!is_numeric($weight)) {$weight = 1;}
      $timeArray = explode('-', trim($weightAndTimeArray[1]));
      $timeFrom = trim($timeArray[0]);
      if ($timeFrom == '') {$timeFrom = '00:00:00';}
      if (strtotime($timeFrom) == '' || strtotime($timeFrom) == -1) {$timeFrom = '00:00:00';}
      $timeTo = trim($timeArray[1]);
      if ($timeTo == '') {$timeTo = '23:59:59';}
      if (strtotime($timeTo) == '' || strtotime($timeTo) == -1) {$timeTo = '23:59:59';}

      // if image not in range of time --> set flag to kick it out
      if (!(time() >= strtotime($timeFrom) && time() <= strtotime($timeTo)))
      {
        $kickOut = true;
      }

      // Kick out shown images on client
      if ($sort == 1 || !$conf["sortOnDynamicChange"])
      {
        foreach($_GET as $value)
        {
          if ($value == str_replace($relativeToRoot, '', $rimage[$j]))
          {
            if ($weight == 1)
            {
              $kickOut = true;
              break;
            }
            else
            {
              $weight--;
            }
          }
        }
      }

      // If not shown on client --> add it to the image array
      if (!$kickOut)
      {
        $rim[$x] = $rimage[$j];

        // Add Index of Image based on its weight
        for ($w=0; $w<$weight; $w++)
        {
          $rimageIndex[] = $x;
        }

        $x++;
      }
    }

    // Setting sort to 1 (unsorted), when dynamic random change is running and sorting for dynamic change is disabled
    if (!$conf["internal"] && !$conf["sortOnDynamicChange"])
    {
      $sort = 1;
    }

    // Sort Images by filedate
    if ($sort == 2)
    {
      $x = 0;
      if ($rim != '')
      {
        foreach($rim as $file)
        {
          $filenames[$x][0] = filemtime($file);
          $filenames[$x][1] = $file;
          $x++;
        }
        if ($sortorder == 2) {rsort($filenames);} else {sort($filenames);}
        for ($i=0; $i<$x; $i++)
        {
          $rim[$i] = $filenames[$i][1];
        }
      }
    }

    // Sort Images by filename (without path)
    if ($sort == 3)
    {
      $x = 0;
      foreach($rim as $file)
      {
        if (!strrpos($file, '\\'))
        {
          $filenames[$x][0] = substr($file, strrpos($file, '/') + 1);
          $filenames[$x][1] = $file;
        }
        else
        {
          $filenames[$x][0] = substr($file, strrpos($file, '\\') + 1);
          $filenames[$x][1] = $file;
        }
        $x++;
      }
      if ($sortorder == 2) {rsort($filenames);} else {sort($filenames);}
      for ($i=0; $i<$x; $i++)
      {
        $rim[$i] = $filenames[$i][1];
      }
    }

    // Sort Images by filename (within path)
    if ($sort == 4)
    {
      if ($sortorder == 2) {rsort($rim);} else {sort($rim);}
    }

    // Instantiate imagemagick for scaling images
    if ($conf["useImagemagick"] == 1)
    {
      $g = t3lib_div::makeInstance('t3lib_stdGraphic');
      $g->init();
      if ($conf["internal"] != 1) {$g->absPrefix = $relativeToRoot;}
      $optionsImage["maxW"] = $conf["maxwidth"]; $optionsImage["maxH"] = $conf["maxheight"];
      $optionsBigImage["maxW"] = $conf["bigimagemaxwidth"]; $optionsBigImage["maxH"] = $conf["bigimagemaxheight"];
    }

    // Create Images
    for ($i=0; $i<$count; $i++)
    {
      if(count($rim)>0)
      { 
        // Sorted Images
        if ($sort == 2 || $sort == 3 || $sort == 4)
        {
          // get next image index
          if ($conf["currentImageIndex"] == '' || !is_numeric($conf["currentImageIndex"]))
          {
            $nextImageIndex = 0;
          }
          else
          {
            $nextImageIndex = $conf["currentImageIndex"] + 1;
          }

          if ($nextImageIndex >= count($rim)) {$nextImageIndex = 0;}
          if ($conf['internal']) {$nextImageIndex = $i;}

          if ($conf["useImagemagick"] == 1)
          {
            $newFile = $g->imageMagickConvert($rim[$nextImageIndex],'WEB','','',$conf['imparams'],'',$optionsImage);
            $bigFile = $g->imageMagickConvert($rim[$nextImageIndex],'WEB','','',$conf['bigimageimparams'],'',$optionsBigImage);
            $newFile[3] = user_randomimage::execImCommand($newFile[3], $conf['imcommand'], $conf['imcommandparams'], $relativeToRoot, false, $conf['uniqueKey']);
            $bigFile[3] = user_randomimage::execImCommand($bigFile[3], $conf['bigimageimcommand'], $conf['bigimageimcommandparams'], $relativeToRoot, true, $conf['uniqueKey']);
		  }
          else
          {
            $newFile[3] = $rim[$nextImageIndex];
            $bigFile[3] = str_replace($fpath, $bigImagePath, $rim[$nextImageIndex]);
            $newFile[3] = user_randomimage::execImCommand($newFile[3], $conf['imcommand'], $conf['imcommandparams'], $relativeToRoot, false, $conf['uniqueKey']);
            $bigFile[3] = user_randomimage::execImCommand($bigFile[3], $conf['bigimageimcommand'], $conf['bigimageimcommandparams'], $relativeToRoot, true, $conf['uniqueKey']);
          }
          
          // Get Link of image
          $fileContent = user_randomimage::getLink($rim[$nextImageIndex], $conf['link']);

          // Get Caption of image
          $captionContent = user_randomimage::getCaption($rim[$nextImageIndex], $conf['caption']);

          // Get Alttext of image
          $altContent = user_randomimage::getAlt($rim[$nextImageIndex], $conf['alttext']);
		  
		  // Get Titletext of image
          $titleContent = user_randomimage::getTitle($rim[$nextImageIndex], $conf['titleText']);

          // Setting $content variable
          $content .= str_replace($relativeToRoot, '', $rim[$nextImageIndex]).'x;x'.str_replace($relativeToRoot, '', $newFile[3]).'x;x'.str_replace($relativeToRoot, '', $bigFile[3]).'x;x'.$fileContent.'x;x'.$captionContent.'x;x'.$altContent.'x;x'.$titleContent.'x;x'.$nextImageIndex."\n";
        }
        // Unsorted Images
        else
        {
          shuffle($rimageIndex);
          $imageIndex = $rimageIndex[0];
          if ($conf["useImagemagick"] == 1)
          {
            $newFile = $g->imageMagickConvert($rim[$imageIndex],'WEB','','',$conf['imparams'],'',$optionsImage);
            $bigFile = $g->imageMagickConvert($rim[$imageIndex],'WEB','','',$conf['bigimageimparams'],'',$optionsBigImage);
            $newFile[3] = user_randomimage::execImCommand($newFile[3], $conf['imcommand'], $conf['imcommandparams'], $relativeToRoot, false, $conf['uniqueKey']);
            $bigFile[3] = user_randomimage::execImCommand($bigFile[3], $conf['bigimageimcommand'], $conf['bigimageimcommandparams'], $relativeToRoot, true, $conf['uniqueKey']);
		  }
          else
          {
            $newFile[3] = $rim[$imageIndex];
            $bigFile[3] = str_replace($fpath, $bigImagePath, $rim[$imageIndex]);
            $newFile[3] = user_randomimage::execImCommand($newFile[3], $conf['imcommand'], $conf['imcommandparams'], $relativeToRoot, false, $conf['uniqueKey']);
            $bigFile[3] = user_randomimage::execImCommand($bigFile[3], $conf['bigimageimcommand'], $conf['bigimageimcommandparams'], $relativeToRoot, true, $conf['uniqueKey']);
          }

          // Get Link of image
          $fileContent = user_randomimage::getLink($rim[$imageIndex], $conf['link']);

          // Get Caption of image
          $captionContent = user_randomimage::getCaption($rim[$imageIndex], $conf['caption']);

          // Get Alttext of image
          $altContent = user_randomimage::getAlt($rim[$imageIndex], $conf['alttext']);
		  
		  // Get Titletext of image
          $titleContent = user_randomimage::getTitle($rim[$imageIndex], $conf['titleText']);

          // Setting $content variable
          $content .= str_replace($relativeToRoot, '', $rim[$imageIndex]).'x;x'.str_replace($relativeToRoot, '', $newFile[3]).'x;x'.str_replace($relativeToRoot, '', $bigFile[3]).'x;x'.$fileContent.'x;x'.$captionContent.'x;x'.$altContent.'x;x'.$titleContent.'x;x'.'-1'."\n";

          // Kickout the used index
          unset($rimageIndex[0]);
          if (!in_array($imageIndex, $rimageIndex))
          {
            unset($rim[$imageIndex]);
          }
        }
      }
    }

	// Get exceptions from imcommand
	if (substr($newFile[3], 0, 9) == 'Exception')
	{
		return $newFile[3];
	}
          
	// Get exceptions from bigimageimcommand
	if (substr($bifFile[3], 0, 9) == 'Exception')
	{
		return $newFile[3];
	}

    return $content;
  }

  // ==========================================================================================================
  // Get Alt text of an image
  // ==========================================================================================================
  function getAlt ($imageFile, $alt)
  {
    // read file for alt text
    $altContent = $alt;
    $altFile = substr($imageFile, 0, strrpos($imageFile, '.')).'.alt';
    if (file_exists($altFile)) {$altContent = file_get_contents($altFile);}
    $altContent = trim($altContent);
    $altContent = user_randomimage::replaceString($imageFile, $altContent);

    return ($altContent);
  }
  
  // ==========================================================================================================
  // Get Title text of an image
  // ==========================================================================================================
  function getTitle ($imageFile, $title)
  {
    // read file for title text
    $titleContent = $title;
    $titleFile = substr($imageFile, 0, strrpos($imageFile, '.')).'.tit';
    if (file_exists($titleFile)) {$titleContent = file_get_contents($titleFile);}
    $titleContent = trim($titleContent);
    $titleContent = user_randomimage::replaceString($imageFile, $titleContent);

    return ($titleContent);
  }

  // ==========================================================================================================
  // Get Caption of a image
  // ==========================================================================================================
  function getCaption ($imageFile, $caption)
  {
    // read file for caption
    $captionContent = $caption;
    $captionFile = substr($imageFile, 0, strrpos($imageFile, '.')).'.cap';
    if (file_exists($captionFile)) { $captionContent = file_get_contents($captionFile); }
    $captionContent = trim($captionContent);
    $captionContent = user_randomimage::replaceString($imageFile, $captionContent);

    return ($captionContent);
  }

  // ==========================================================================================================
  // Get link of a image
  // ==========================================================================================================
  function getLink ($imageFile, $linkContent)
  {
    // read file for link
    $fileContent = trim($linkContent);
    $linkFile = substr($imageFile, 0, strrpos($imageFile, '.')).'.txt';
    if (file_exists($linkFile)) { $fileContent = file_get_contents($linkFile); }
    $fileContent = trim(strtr($fileContent, array("\\n" => '', "\\r" => '', "\\h" => '')));
    $fileContent = user_randomimage::replaceString($imageFile, $fileContent);

    return ($fileContent);
  }

// ==========================================================================================================
  // Get weight and time of a image
  // ==========================================================================================================
  function getWeightAndTime ($imageFile, $weightAndTime)
  {
    // read file for weight and time
    $weightContent = $weightAndTime;
    $weightFile = substr($imageFile, 0, strrpos($imageFile, '.')).'.wat';
    if (file_exists($weightFile)) { $weightContent = file_get_contents($weightFile); }
    $weightContent = trim(strtr($weightContent, array("\\n" => '', "\\r" => '', "\\h" => '')));
    $weightContent = trim($weightContent);

    return ($weightContent);
  }

  // ==========================================================================================================
  // Get Imagemagick command
  // ==========================================================================================================
  function getImCommand($image, $command, $commandParams, $outfile)
  {
  	if (trim($command) == '')
    {
      return '';
    }

    $validImCommands = array("animate", "compare", "composite", "conjure", "convert", "display", "identify", "import", "mogrify", "montage", "stream",
                             "animate.exe", "compare.exe", "composite.exe", "conjure.exe", "convert.exe", "display.exe", "identify.exe", "import.exe", "mogrify.exe", "montage.exe", "stream.exe");
    if (!in_array(strtolower($command), $validImCommands))
    {
    	return 'Exception in RandomImage-Plugin:<br/><span style="color: red">no valid imagemagick command: &laquo;'.htmlentities(trim($command)).'&raquo;</span>'."\n";
    }
    
    $invalidChars = array("&", "%", ";", ":", "<", ">", "|", "{", "}", "[", "]", "~", "^");
    $char = strposa($commandParams, $invalidChars);
    if ($char != '') 
    {
    	return 'Exception in RandomImage-Plugin:<br/><span style="color: red">invalid character &laquo;'.htmlentities($char).'&raquo; in imagemagick command: &laquo;'.htmlentities(trim($commandParams)).'&raquo;</span>'."\n";
    }
    
    $cmd = $command.' '.$commandParams;
    $cmd = str_replace('RANDOMIMAGE', realpath($image), $cmd);
    $cmd = str_replace('OUTIMAGE', $outfile, $cmd);
    $cmd = $GLOBALS['TYPO3_CONF_VARS']['GFX']['im_path'].$cmd;
    return $cmd;
  }

  // ==========================================================================================================
  // Execute Imagemagick command
  // ==========================================================================================================
  function execImCommand($image, $imCommand, $imCommandParams, $relativeToRoot, $bigImage=false, $uniqueKey)
  {
  	// return, if no command is given
  	if (trim($imCommand) == '')
    {
      return $image;
    }

    // create temporary image name with md5 hash of image (for caching)
    $imageName = md5_file($image).'_'.$uniqueKey;
    $imCommandHash = md5($imCommand.' '.$imCommandParams);
    $imageName = md5($imageName.$imCommandHash);

    // create prefix of caching file name
    if ($bigImage)
    {
      $imageName = 'imbigpic_'.$imageName.'_'.substr($image, strrpos($image, '/') + 1);
    }
    else
    {
      $imageName = 'impic_'.$imageName.'_'.substr($image, strrpos($image, '/') + 1);
    }

    // take file from cache, if exists
    if (file_exists(realpath($relativeToRoot.'typo3temp/pics/').'/'.$imageName))
    {
      return $relativeToRoot.'typo3temp/pics/'.$imageName;
    }
    else
    {
      // create new temp file and execute imagemagick command
      $outfile = realpath($relativeToRoot.'typo3temp/pics/').'/'.$imageName;
      $commands = explode(';', $imCommand);
      $commandsParams = explode(';', $imCommandParams);
      $index = -1;
      foreach ($commands as $command)
      {
        $index++;
      	$cmd = user_randomimage::getImCommand($image, trim($command), trim($commandsParams[$index]), $outfile);
      	if (substr($cmd, 0, 9) == 'Exception') {
      		return $cmd;
      	}
      	if ($cmd != '')
        {
          exec($cmd);
          $image = $relativeToRoot.'typo3temp/pics/'.substr($outfile, strrpos($outfile, '/') + 1);
        }
      }
      return $image;
    }
  }
  
  // ==========================================================================================================
  // Validate given path of security issues and give back, if it's valid or not
  // ==========================================================================================================
  function validatePath ($path, $relativeToRoot)
  {
  	// initialize valid start pathes to compare
  	$path = strtolower(str_replace("\\", "/", $path));
  	$fileadmin = strtolower(str_replace("\\", "/", $relativeToRoot.'fileadmin'));
	$userUpload = strtolower(str_replace("\\", "/", $relativeToRoot.'user_upload'));

	// check path in case of fileadmin path (if fileadmin path is a virtual directory)
    if ($path && $fileadmin && substr($path, 0, strlen($fileadmin)) == $fileadmin)	{
    	return true;
    }

  	// check path in case of user_upload path (if fileadmin path is a virtual directory)
    if ($path && $userUpload && substr($path, 0, strlen($userUpload)) == $userUpload)	{
	  return true;
    }

    // give back false (no valid path is given)
    return false;
  }

  // ==========================================================================================================
  // Replace specific tags
  // ==========================================================================================================
  function replaceString ($imageFile, $string)
  {
    // replace #fn with filename
    if (strpos($string, "#fn#") !== false)
    {
      $string = str_replace('#fn#', substr($imageFile, strrpos($imageFile, '/')+1, strrpos($imageFile, '.') - strrpos($imageFile, '/') - 1), $string);
    }

    // replace #fe with fileextension
    if (strpos($string, "#fe#") !== false)
    {
      $string = str_replace('#fe#', substr($imageFile, strrpos($imageFile, '.') + 1), $string);
    }

    // replace #fp with filepath
    if (strpos($string, "#fp#") !== false)
    {
      $string = str_replace('#fp#', substr($imageFile, 0, strrpos($imageFile, '/') + 1), $string);
    }

    // replace #fd with filedate
    if (preg_match('/#fd!(.+)!#/', $string) > 0)
    {
      preg_match("/#fd!(.+)!#/", $string, $contents);
      $fileformat = $contents[1];
      $filedate = date($fileformat, filemtime($imageFile));
      $string = str_replace('#fd!'.$fileformat.'!#', $filedate, $string);
    }
    return ($string);
  }
}

// ==========================================================================================================
// Returns the string position of a array of needles
// ==========================================================================================================
function strposa($haystack, $needles=array(), $offset=0)
{
  $found = '';
  foreach($needles as $needle)
  {
    if (strpos($haystack, $needle, $offset) !== false)
    {
      $found = $needle;
      break;
    }
  }
  return $found;
}

// ==========================================================================================================
// Recursive loop through directory
// ==========================================================================================================
function loopDirectory ($directory, $recursive, $ignorePath, $ignoreFolder)
{
  $ignoreF = false;
  foreach ($ignoreFolder as $if)
  {
    if (trim($if) != '')
    {
      if (strpos($directory, trim($if)) > -1) {$ignoreF = true; break;}
    }
  }

  if (!in_array($directory, $ignorePath) && $ignoreF === false)
  {
    if ($GLOBALS["dirs"] != "") {$GLOBALS["dirs"].=';';}
    $GLOBALS["dirs"].= "$directory";
  }

  if ($recursive == 1)
  {
    $ignore = array('.', '..');
    $dh = @opendir($directory);
    while (false !== ($file = @readdir($dh)))
    {
      $ignoreF = false;
      foreach ($ignoreFolder as $if)
      {
        if ($if != '')
        {
          if (strpos($directory, trim($if)) > -1) {$ignoreF = true; break;}
        }
      }

      if (!in_array($file, $ignore) && $ignoreF === false)
      {
        if(is_dir("$directory/$file"))
        {
          if (strrchr($directory, '/') != '/')
          {
            loopDirectory("$directory/$file", $recursive, $ignorePath, $ignoreFolder);
          }
          else
          {
            loopDirectory("$directory$file", $recursive, $ignorePath, $ignoreFolder);
          }
        }
      }
    }
    @closedir($dh);
  }
}
?>
