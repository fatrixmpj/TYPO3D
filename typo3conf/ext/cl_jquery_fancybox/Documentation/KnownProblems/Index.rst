.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


Known problems
--------------

Problems with version 4.6.x were reported. The lightbox script was
activated although the option “open in lightbox” was deactivated. This
problem and the following solution was reported by Ulfried Herrmann
(Die Netzmacher):

Add this script to your setup section of your template:

::

   tt_content.image.20.1.imageLinkWrap {
       # New typolink wrapping:
       typolink {
           parameter >
           parameter {
               cObject = IMG_RESOURCE
               cObject {
                   file {
                       import.data = TSFE:lastImageInfo|origFile
                       maxW = {$styles.content.imgtext.linkWrap.width}
                   }
               }
               override {
                   field = image_link
                   listNum.stdWrap.data = register : IMAGE_NUM_CURRENT
                   if.isTrue.field = image_link
               }
           }
           ATagParams < tt_content.image.20.1.imageLinkWrap.linkParams.ATagParams
           ATagParams {
               if.isTrue.field = image_zoom
           }
       }
       linkParams >
   }


