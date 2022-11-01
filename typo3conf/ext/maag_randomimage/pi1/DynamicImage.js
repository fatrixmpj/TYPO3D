// **********************************************************************************************
// Random-Image-Function
// **********************************************************************************************
// Global Variables
var objLastPosition = new Array();
var gIntervalState = 0;
var objMouseOnImage = null;

// Dynamic Change of random images
function DynamicRandomImage(pUniqueKey, pUrl, pImgName, pInterval, pImagePath, pBigImagePath, pImageCount, pDynamic, pRecursive, pIgnore, pIgnoreFolder, pIgnoreFile, pSort, pSortOrder, pSortOnDynamicChange, pImageMaxW, pImageMaxH, pBigImageMaxW, pBigImageMaxH, pImageFading, pImagemagick, pDebug, pCaption, pLink, pAlttext, pTitletext, pImParams, pBigImageImParams, pImCommand, pImCommandParams, pBigImageImCommand, pBigImageImCommandParams, pCurrentImageIndex, pHttpsBackend)
{
  this.uniqueKey = pUniqueKey;
  this.url = pUrl;
  this.imgName = pImgName;
  this.interval = pInterval;
  this.imagePath = pImagePath;
  this.bigImagePath = pBigImagePath;
  this.imageCount = pImageCount;
  this.dynamic = pDynamic;
  this.recursive = pRecursive;
  this.ignore = pIgnore;
  this.ignoreFolder = pIgnoreFolder;
  this.ignoreFile = pIgnoreFile;
  this.sort = pSort;
  this.sortorder = pSortOrder;
  this.sortOnDynamicChange = pSortOnDynamicChange;
  this.imageMaxW = pImageMaxW;
  this.imageMaxH = pImageMaxH;
  this.bigImageMaxW = pBigImageMaxW;
  this.bigImageMaxH = pBigImageMaxH;
  this.imageFading = pImageFading;
  this.imagemagick = pImagemagick;
  this.debug = pDebug;
  this.caption = pCaption;
  this.alttext = pAlttext;
  this.titletext = pTitletext;
  this.link = pLink;
  this.imParams = pImParams;
  this.bigImageImParams = pBigImageImParams;
  this.imCommand = pImCommand;
  this.imCommandParams = pImCommandParams;
  this.bigImageImCommand = pBigImageImCommand;
  this.bigImageImCommandParams = pBigImageImCommandParams;
  this.currentImageIndex = pCurrentImageIndex;
  this.httpsBackend = pHttpsBackend;
  this.tempImage = null;
  this.newCaption = null;
  this.a = -1;

  this.arrImg = new Array(pImageCount);
  this.arrLinks = new Array(pImageCount);
  this.arrCaptions = new Array(pImageCount);
  this.arrFadings = new Array(pImageCount);
  this.arrAlts = new Array(pImageCount);
  this.arrTitles = new Array(pImageCount);
  this.imgNumber = 0;
  this.zufallsZahl = 0;
  this.xmlhttp = GetXMLObject();

  DynamicRandomImage.prototype.randomize = function()
  {
    var thisObject = this;

    // get random image number to replace
    var a = Math.random();
    a *= thisObject.imageCount;
    a = Math.ceil(a);
    if (a == thisObject.zufallsZahl) {if (a+1 > thisObject.imageCount) {a = 1;} else {a++;}};

    if (gIntervalState == 0)
    {
      thisObject.writeDebugInfo('Change Image-Number: ' + a);

      if (this.imgNumber != 0) {if (this.imgNumber > this.imageCount) {this.imgNumber = 1;}}
      if (this.imgNumber == 0)
      {
        var urlArgs = this.url + "?uniqueKey=" + this.uniqueKey + "&path=" + this.imagePath + "&bigImagePath=" + this.bigImagePath + "&count=" + this.imageCount + "&dynamic=" + this.dynamic + "&recursive=" + this.recursive + "&ignore=" + this.ignore + "&ignorefolder=" + this.ignoreFolder + "&ignorefile=" + this.ignoreFile + "&sort=" + this.sort + "&sortorder=" + this.sortorder + "&sortOnDynamicChange=" + this.sortOnDynamicChange + "&imw=" & this.imageMaxW + "&imh=" + this.imageMaxH + "&bmw=" + this.bigImageMaxW + "&bmh=" + this.bigImageMaxH + "&im=" + this.imagemagick + "&caption=" + escape(this.arrCaptions[a-1]) + "&link=" + escape(this.arrLinks[a-1]) + "&alt=" + escape(this.arrAlts[a-1]) + "&title=" + escape(this.arrTitles[a-1]) + "&imparams=" + escape(this.imParams).replace(/\+/g,"%2B") + "&biimparams=" + escape(this.bigImageImParams).replace(/\+/g,"%2B") + "&imcommand=" + escape(this.imCommand).replace(/\+/g,"%2B") + "&imcommandparams=" + escape(this.imCommandParams).replace(/\+/g,"%2B") + "&biimcommand=" + escape(this.bigImageImCommand).replace(/\+/g,"%2B") + "&biimcommandparams=" + escape(this.bigImageImCommandParams).replace(/\+/g,"%2B") + "&curindex=" + this.currentImageIndex + "&httpsBackend=" + this.httpsBackend + "&t=" + new Date().getTime();
      }
      else
      {
        var urlArgs = this.url + "?uniqueKey=" + this.uniqueKey + "&path=" + this.imagePath + "&bigImagePath=" + this.bigImagePath + "&count=1" +                  "&dynamic=" + this.dynamic + "&recursive=" + this.recursive + "&ignore=" + this.ignore + "&ignorefolder=" + this.ignoreFolder + "&ignorefile=" + this.ignoreFile + "&sort=" + this.sort + "&sortorder=" + this.sortorder + "&sortOnDynamicChange=" + this.sortOnDynamicChange + "&imw=" + this.imageMaxW + "&imh=" + this.imageMaxH + "&bmw=" + this.bigImageMaxW + "&bmh=" + this.bigImageMaxH + "&im=" + this.imagemagick + "&caption=" + escape(this.arrCaptions[a-1]) + "&link=" + escape(this.arrLinks[a-1]) + "&alt=" + escape(this.arrAlts[a-1]) + "&title=" + escape(this.arrTitles[a-1]) + "&imparams=" + escape(this.imParams).replace(/\+/g,"%2B") + "&biimparams=" + escape(this.bigImageImParams).replace(/\+/g,"%2B") + "&imcommand=" + escape(this.imCommand).replace(/\+/g,"%2B") + "&imcommandparams=" + escape(this.imCommandParams).replace(/\+/g,"%2B") + "&biimcommand=" + escape(this.bigImageImCommand).replace(/\+/g,"%2B") + "&biimcommandparams=" + escape(this.bigImageImCommandParams).replace(/\+/g,"%2B") + "&curindex=" + this.currentImageIndex + "&httpsBackend=" + this.httpsBackend + "&t=" + new Date().getTime();
      }
      for (var i = 1; i <= this.imageCount; i++) {urlArgs = urlArgs + "&img" + i + "=" + this.arrImg[i-1];}
      thisObject.writeDebugInfo('Call URL &laquo;' + urlArgs + '&raquo;');

      try
      {
		  if (this.imgNumber != 0)
          {
            // get one new random image
            this.xmlhttp.open("GET", urlArgs, true);
            this.xmlhttp.onreadystatechange = function()
            {
              thisObject.writeDebugInfo('XMLHttp-Request readystate changed to &laquo;' + thisObject.xmlhttp.readyState.toString() + '&raquo;');
              if (thisObject.xmlhttp.readyState == 4)
              {
                var xmlResponse = thisObject.xmlhttp.responseText;
                
                thisObject.writeDebugInfo('XML-Response: ' + xmlResponse);
                if (xmlResponse != '')
                {
                  // take image informations in variables
                  var arrTemp = xmlResponse.split("x;x");
                  thisObject.a = a;
                  thisObject.tempImage = new Image();
                  thisObject.tempImage.src = arrTemp[1];

                  // Setting new Caption of the image in object variable
                  if (document.getElementById('cap_'.concat(thisObject.imgName).concat(thisObject.a)) != null)
                  {
                    var strCaption = arrTemp[4].toString().replace('\n', '').replace('\r', '');
                    if (strCaption != '')
                    {
                      thisObject.newCaption = strCaption;
                    }
                    else
                    {
                      thisObject.newCaption = thisObject.arrCaptions[thisObject.a-1];
                    }
                  }
                  
                  // replace image source of current image
                  thisObject.tempImage.load = thisObject.loadCompleted();
                  
                  // Write filename of bigimage to div
                  if (document.getElementById('bi_'.concat(thisObject.imgName).concat('_').concat(a)) != null)
                  {
                    document.getElementById('bi_'.concat(thisObject.imgName).concat('_').concat(a)).innerHTML = arrTemp[2];
                  }
                  
                  // Write new href in link around the image
                  if (document.getElementById('lnk_'.concat(thisObject.imgName).concat(a)) != null)
                  {
                    strLink = arrTemp[3].toString().replace('\n', '').replace('\r', '');
                    strTarget = '';
                    var arrLink = strLink.split(' ');
                    if (arrLink.length > 1) {strLink = arrLink[0]; strTarget = arrLink[1];} else {strLink = arrLink[0]; strTarget = '';}
                    thisObject.writeDebugInfo('Old Link: ' + document.getElementById('lnk_'.concat(thisObject.imgName).concat(a)).href + ' ' + document.getElementById('lnk_'.concat(thisObject.imgName).concat(a)).target);
                    thisObject.writeDebugInfo('New Link: ' + strLink + ' ' + strTarget);
                    if (strLink != '')
                    {
                      document.getElementById('lnk_'.concat(thisObject.imgName).concat(a)).href = strLink;
                      document.getElementById('lnk_'.concat(thisObject.imgName).concat(a)).target = strTarget;
                    }
                    else
                    {
                      var arrLink = thisObject.arrLinks[a-1].split(" ");
                      if (arrLink.length > 1) {strLink = arrLink[0]; strTarget = arrLink[1];} else {strLink = arrLink[0]; strTarget = '';}
                      document.getElementById('lnk_'.concat(thisObject.imgName).concat(a)).href = strLink;
                      document.getElementById('lnk_'.concat(thisObject.imgName).concat(a)).target = strTarget;
                    }
                  }
                  
                  // Write new Alttext of the image
                  thisObject.writeDebugInfo('Old alt-text: ' + document.getElementById(thisObject.imgName.concat(a)).alt);
                  thisObject.writeDebugInfo('New alt-text: ' + arrTemp[5]);
                  document.getElementById(thisObject.imgName.concat(a)).alt = arrTemp[5];
				  
				  // Write new Titletext of the image
                  thisObject.writeDebugInfo('Old title-text: ' + document.getElementById(thisObject.imgName.concat(a)).title);
                  thisObject.writeDebugInfo('New title-text: ' + arrTemp[6]);
                  document.getElementById(thisObject.imgName.concat(a)).title = arrTemp[6];
                  
                  // set new current image index
                  thisObject.writeDebugInfo('Current Image Index: ' + arrTemp[7]);
                  thisObject.currentImageIndex = arrTemp[7];

                  // update current image array
                  thisObject.arrImg[a-1] = arrTemp[0];
                  thisObject.imgNumber = a;
                  thisObject.zufallsZahl = a;
                }
              }
            }
            this.writeDebugInfo('XMLHttp-Request to &laquo;' + urlArgs + '&raquo;');
            this.xmlhttp.send(null)
          }
          else
          {
            // first time -> save current images, captions and links in array
            var arrCap = this.caption.split('x;x');
            var arrLnk = this.link.split('x;x');
            var arrFad = this.imageFading.split('x;x');
            var arrAlt = this.alttext.split('x;x');
			var arrTitle = this.titletext.split('x;x');

            for (var i=0; i < this.imageCount; i++)
            {
              // Images
              var img = document.getElementById("fi_".concat(this.imgName).concat("_").concat(i+1)).innerHTML.toString();
              this.arrImg[i] = img;

              // Fadings
              if (arrFad[i] == null) {arrFad[i] = 0;}
              this.arrFadings[i] = arrFad[i];

              // Links
              if (arrLnk[i] == null) {arrLnk[i] = '';}
              this.arrLinks[i] = arrLnk[i];
              
              // Captions
              if (arrCap[i] == null) {arrCap[i] = '';}
              this.arrCaptions[i] = arrCap[i];

              // Alttext
              if (arrAlt[i] == null) {arrAlt[i] = '';}
              this.arrAlts[i] = arrAlt[i];
			  
			  // Titletext
              if (arrTitle[i] == null) {arrTitle[i] = '';}
              this.arrTitles[i] = arrTitle[i];
            }

            this.imgNumber++;
          }
      }
      catch(e)
      {
        this.writeDebugInfo('Exception: ' + e);
      }
    }
    window.setTimeout( function () { thisObject.randomize(); }, this.interval);
  }
  
  // Write Debug-Information
  DynamicRandomImage.prototype.writeDebugInfo = function(strMessage)
  {
    if (this.debug == 1)
    {
      var objDebug = document.getElementById('randomimages_debug');
      if (objDebug != null)
      {
        var dtmDate = new Date();
        var hour = dtmDate.getHours(); if (hour < 10) {hour = '0' + hour};
        var minute = dtmDate.getMinutes(); if (minute < 10) {minute = '0' + minute};
        var second = dtmDate.getSeconds(); if (second < 10) {second = '0' + second};
        var strTime = hour + ':' + minute + ':' + second;
        objDebug.innerHTML = objDebug.innerHTML.toString() + strTime + '<br />' + strMessage + '<br /><br />';
      }
    }  
  }
  
  // Image Loading Completed function
  DynamicRandomImage.prototype.loadCompleted = function()
  {
    if (this.tempImage.complete == false)
    {
      var thisObject = this;
      setTimeout(function() { thisObject.loadCompleted() }, 50);
      return (false);
    }
    if (document.getElementById(this.imgName.concat(this.a)))
    {
      if (document.getElementById('cap_' + this.imgName.concat(this.a)) != null)
      {
		RandomImage_ChangeOpac(0, 'cap_' + this.imgName.concat(this.a)); 
		document.getElementById('cap_' + this.imgName.concat(this.a)).innerHTML = this.newCaption;
      }

      if (this.arrFadings[this.a-1] == 0)
      {
        document.getElementById(this.imgName.concat(this.a)).src = this.tempImage.src;
      }

      document.getElementById(this.imgName.concat(this.a)).width = this.tempImage.width;
      document.getElementById(this.imgName.concat(this.a)).height = this.tempImage.height;

      // Set position of div and start fading
      if (this.arrFadings[this.a-1] == 1)
      {
        // Get caption width and height, if caption exists
        var captionHeight = 0;
        var captionWidth = 0;
        if (document.getElementById('cap_' + this.imgName.concat(this.a)) != null)
        {
          captionHeight = RandomImage_GetCurrentStyle(document.getElementById('cap_' + this.imgName.concat(this.a)), 'height').replace('px', '').replace('auto', '');
          captionWidth = RandomImage_GetCurrentStyle(document.getElementById('cap_' + this.imgName.concat(this.a)), 'width').replace('px', '').replace('auto', '');
        }
        if (captionHeight == '') {captionHeight = 0;}
        if (captionWidth == '') {captionWidth = 0;}

        // Calculate width and height of fading div
        var fadingWidth = this.tempImage.width;
        var fadingHeight = this.tempImage.height;
        if (eval(captionWidth) > eval(fadingWidth)) {fadingWidth = captionWidth;}
        fadingHeight = eval(fadingHeight) + eval(captionHeight);

        // Set position and width and height of fading div
        document.getElementById('fd_' + this.imgName + '_' + this.a).style.width = fadingWidth + 'px';
        document.getElementById('fd_' + this.imgName + '_' + this.a).style.height = fadingHeight + 'px';
        document.getElementById('fd_' + this.imgName + '_' + this.a).left = document.getElementById(this.imgName.concat(this.a)).offsetLeft + 'px';
        document.getElementById('fd_' + this.imgName + '_' + this.a).top = document.getElementById(this.imgName.concat(this.a)).offsetTop + 'px';

        this.milliSec = 1000;
        this.fade();
      }
      
      // Call MouseMove to change the big image source
      var thisObject = this;
      setTimeout(function() { thisObject.changeBigImage() }, 50);
    }
  }
  
  // initialization of fading in new image
  DynamicRandomImage.prototype.fade = function()
  { 
    this.writeDebugInfo('Old Image Source: ' + document.getElementById(this.imgName.concat(this.a)).src);
    this.writeDebugInfo('New Image Source: ' + this.tempImage.src);

    if (document.getElementById('cap_' + this.imgName.concat(this.a)) != null)
    {
      this.writeDebugInfo('Old Caption: ' + document.getElementById('cap_' + this.imgName.concat(this.a)).innerHTML);
      this.writeDebugInfo('New Caption: ' + this.newCaption);
    }

    //set the current image as background 
    document.getElementById('fd_' + this.imgName + '_' + this.a).style.backgroundImage = 'url(' + document.getElementById(this.imgName.concat(this.a)).src + ')'; 

    //start fading
    var thisObject = this;
    setTimeout(function() { thisObject.fadeChange() }, 50);
  } 
  
  // fading in new image
  DynamicRandomImage.prototype.fadeChange = function()
  {
    //make image and caption transparent 
    RandomImage_ChangeOpac(0, this.imgName.concat(this.a)); 
    if (document.getElementById('cap_' + this.imgName.concat(this.a)) != null)
    {
		RandomImage_ChangeOpac(0, 'cap_' + this.imgName.concat(this.a)); 
    }

    var thisObject = this;
    setTimeout(function() { thisObject.fadeIt() }, 50);
  }
  
  DynamicRandomImage.prototype.fadeIt = function()
  {
    var speed = Math.round(this.milliSec / 100); 
    var timer = 0; 

    //make new image
    document.getElementById(this.imgName.concat(this.a)).src = this.tempImage.src; 
    
    //make new caption
    if (document.getElementById('cap_'.concat(this.imgName.concat(this.a))) != null)
    {
		document.getElementById('cap_' + this.imgName.concat(this.a)).innerHTML = this.newCaption;
    }

    //fade in image and caption
    for(i = 0; i <= 100; i++)
    { 
      setTimeout("RandomImage_ChangeOpac(" + i + ",'" + this.imgName.concat(this.a) + "','" + 'cap_' + this.imgName.concat(this.a) + "')",(timer * speed)); 
      timer++;
    }
  }
    
  // change big image source, when small image source has changed (call mousemove event with reflection)
  DynamicRandomImage.prototype.changeBigImage = function()
  {
      if (document.getElementById(this.imgName.concat(this.a)).onmousemove != null)
      {
        var beginPos = document.getElementById(this.imgName.concat(this.a)).onmousemove.toString().indexOf("{") + 1;
        var endPos = document.getElementById(this.imgName.concat(this.a)).onmousemove.toString().indexOf("}");
        var method = document.getElementById(this.imgName.concat(this.a)).onmousemove.toString().substring(beginPos, endPos);
        eval(method);
      }
  }

  // Get xml object (crossbrowser valid)
  function GetXMLObject()
  {
    var xmlhttp=false;
    try {
      xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (E) {
        xmlhttp = false;
      }
    }
    if (!xmlhttp && typeof XMLHttpRequest!="undefined") {
      try {
        xmlhttp = new XMLHttpRequest();
      } catch (e) {
        xmlhttp=false;
      }
    }
    if (!xmlhttp && window.createRequest) {
      try {
        xmlhttp = window.createRequest();
      } catch (e) {
        xmlhttp=false;
      }
    }
    return xmlhttp;
  }  
}

// Show big image, when mouse over
function RandomImage_MouseOver(pId, pIdImage, pIdMessage, pImg, pImgName, pMarginLeft, pMarginTop, pPositionLeft, pPositionTop, pImgNumber)
{
  this.id = pId;
  this.idImage = pIdImage;
  this.idMessage = pIdMessage;
  this.img = pImg;
  this.imgName = pImgName;
  this.marginLeft = pMarginLeft;
  this.marginTop = pMarginTop;
  this.positionLeft = pPositionLeft;
  this.positionTop = pPositionTop;
  this.imageNumber = pImgNumber;

  this.bigImage = null;
  this.bigImage = new Image();
  
  RandomImage_MouseOver.prototype.Main = function()
  {
    // save mouse over object
    objMouseOnImage = this.img;

    // set position of div
    RandomImage_SetPosition(this.id, this.positionLeft, this.marginLeft, this.positionTop, this.marginTop, this.img, this.imgName);
  
    // Show "Loading-Image ..." message
    document.getElementById(this.idImage).style.display = "none";
    document.getElementById(this.id).style.display = "block";
    document.getElementById(this.idMessage).style.display = "block";

    // load big image
    this.bigImage.src = document.getElementById('bi_'.concat(this.imgName).concat('_').concat(this.imageNumber)).innerHTML;
    this.bigImage.load = this.loadCompleted();
  }
  
  // Loading Completed function
  RandomImage_MouseOver.prototype.loadCompleted = function()
  {
    if (this.bigImage.complete == false)
    {
      var thisObject = this;
      setTimeout(function() { thisObject.loadCompleted() }, 50);
      return (false);
    }
    document.getElementById(this.idMessage).style.display = "none";
    document.getElementById(this.idImage).src = this.bigImage.src.toString();
    document.getElementById(this.idImage).style.display = "block";  
  }
}

// Change Source of big image, when small image source changed
function RandomImage_MouseMove(pId, pIdImage, pIdMessage, pImg, pImgName, pMarginLeft, pMarginTop, pPositionLeft, pPositionTop, pImgNumber)
{
  if (objMouseOnImage != null)
  {
    if (pImg.id == objMouseOnImage.id)
    {
      new RandomImage_MouseOver(pId, pIdImage, pIdMessage, pImg, pImgName, pMarginLeft, pMarginTop, pPositionLeft, pPositionTop, pImgNumber).Main();
    }
  }
}

// Hide big image when mouse out
function RandomImage_MouseOut(pId, pIdImage, pIdMessage)
{
  RandomImage_ClearOverImage();
  document.getElementById(pId).style.display = "none";
  document.getElementById(pIdMessage).style.display = "none";
  document.getElementById(pIdImage).style.display = "none";
}

// Clear global variable on mouseout
function RandomImage_ClearOverImage()
{
  objMouseOnImage = null;
}

// Show big image on load
function RandomImage_ShowOnLoad(id, positionLeft, marginLeft, positionTop, marginTop, img, imgID, smallImageName)
{
  // set position of div and display the div
  RandomImage_SetPosition(id, positionLeft, marginLeft, positionTop, marginTop, img, smallImageName);
  document.getElementById(id).style.display = "block";
  document.getElementById(imgID).style.display = "block";  
}


// Helper: set position of div for big image
function RandomImage_SetPosition(id, positionLeft, marginLeft, positionTop, marginTop, img, smallImageName, objLastPos)
{
  if (objLastPos)
  {
    id = objLastPos.id;
    positionLeft = objLastPos.positionLeft;
    marginLeft = objLastPos.marginLeft;
    positionTop = objLastPos.positionTop;
    marginTop = objLastPos.marginTop;
    img = objLastPos.img;
    smallImageName = objLastPos.smallImageName;
  }

  document.getElementById(id).style.position = "absolute";

  if (positionLeft == 'relative') {
    document.getElementById(id).style.left = marginLeft + findPosX(img) + img.width + "px";
  } else if (positionLeft == 'fixed') {
    document.getElementById(id).style.left = marginLeft + "px";
  } else if (positionLeft == 'relativefixed') {
    tempImage = document.getElementById(smallImageName + '1');
    document.getElementById(id).style.left =  marginLeft + findPosX(tempImage) + "px";
  }

  if (positionTop == 'relative') {
    document.getElementById(id).style.top = marginTop + findPosY(img) + "px";
  } else if (positionTop == 'fixed') {
    document.getElementById(id).style.top = marginTop + "px";  
  } else if (positionTop == 'relativefixed') {
    tempImage = document.getElementById(smallImageName + '1');
    document.getElementById(id).style.left =  marginTop + findPosY(tempImage) + "px";
  }

  if (!objLastPosition[id]) {objLastPosition[id] = new RandomImage_LastPosition();}
  objLastPosition[id].setValues(id, positionLeft, marginLeft, positionTop, marginTop, img, smallImageName);
}

// Helper: object for last position of big image
function RandomImage_LastPosition()
{
  this.id = "";
  this.positionLeft = "";
  this.marginLeft = "";
  this.positionTop = "";
  this.marginTop = "";
  this.img = "";
  this.smallImageName = "";

  RandomImage_LastPosition.prototype.setValues = function(pId, pPositionLeft, pMarginLeft, pPositionTop, pMarginTop, pImg, pSmallImageName)
  {
    this.id = pId;
    this.positionLeft = pPositionLeft;
    this.marginLeft = pMarginLeft;
    this.positionTop = pPositionTop;
    this.marginTop = pMarginTop;
    this.img = pImg;
    this.smallImageName = pSmallImageName;
  }
}

// Helper: find x-position of a object
function findPosX(obj)
{
	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft;
}


// Helper: find y-position of a object
function findPosY(obj)
{
	var curtop = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
		curtop += obj.y;
	return curtop;
}

// Helper: start and stop Timer
function RandomImage_StartStopInterval()
{
  if (gIntervalState == 0)
  {
    document.getElementById('randomimages_interval').value = 'start interval';
    gIntervalState = 1;
  }
  else
  {
    document.getElementById('randomimages_interval').value = 'stop interval';
    gIntervalState = 0;
  }
}

// Helper: change the opacity for different browsers 
function RandomImage_ChangeOpac(opacity, id, id2)
{ 
    if ((opacity/100) > 0.99) {return (false);}
    var object = document.getElementById(id).style; 
    object.filter = "alpha(opacity=" + opacity + ")";
    object.KhtmlOpacity = (opacity / 100); 
    object.MozOpacity = (opacity / 100); 
    object.opacity = (opacity / 100); 
    
    if (id2 != null)
    {
      if (document.getElementById(id2) != null)
      {
        var object = document.getElementById(id2).style; 
        object.filter = "alpha(opacity=" + opacity + ")";
        object.KhtmlOpacity = (opacity / 100); 
        object.MozOpacity = (opacity / 100); 
        object.opacity = (opacity / 100); 
      }
    }
}

// Helper: get style of an element
function RandomImage_GetCurrentStyle (objElement, cssPropertyName)
{
  if (window.getComputedStyle)
  {
    return window.getComputedStyle(objElement, '').getPropertyValue(cssPropertyName.replace(/([A-Z])/g, "-$1").toLowerCase());
  }
  else if (objElement.currentStyle)
  {
    return objElement.currentStyle[cssPropertyName];
  }
  else
  {
    return '';
  }
}
