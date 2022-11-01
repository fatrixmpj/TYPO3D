.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt
.. include:: Images.txt


Configuration
-------------

To setup the fancybox, go to the template-view and select the fancybox-settings:

|img-9|

Reference
=========

TypoScript options for fancybox 2:

.. ### BEGIN~OF~TABLE ###


.. container:: table-row

   Property
         **nextEffect**
   
   Data type
         int+
   
   Description
         Padding: Space inside fancyBox around content
   
   Default


.. container:: table-row

   Property
         **prevEffect**
   
   Data type
         int+
   
   Description
         Margin: Minimum space between viewport and fancyBox. Can be set as
         array - [top, right, bottom, left]. Right and bottom margins are
         ignored if content dimensions exceeds viewport
   
   Default


.. container:: table-row

   Property
         width
   
   Data type
         int+
   
   Description
         Default width for 'iframe' and 'swf' content. Also for 'inline',
         'ajax' and 'html' if 'autoSize' is set to 'false'
   
   Default


.. container:: table-row

   Property
         **height**
   
   Data type
         string
   
   Description
         Default height for 'iframe' and 'swf' content. Also for 'inline',
         'ajax' and 'html' if 'autoSize' is set to 'false'
   
   Default


.. container:: table-row

   Property
         **minWidth**
   
   Data type
         int+
   
   Description
         minWidth:Minimum width fancyBox should be allowed to resize to
   
   Default


.. container:: table-row

   Property
         **minHeight**
   
   Data type
         int+
   
   Description
         Minimum height fancyBox should be allowed to resize to
   
   Default


.. container:: table-row

   Property
         **maxWidth**
   
   Data type
         int+
   
   Description
         Maximum width fancyBox should be allowed to resize to
   
   Default


.. container:: table-row

   Property
         **maxHeight**
   
   Data type
         int+
   
   Description
         Maximum height fancyBox should be allowed to resize to
   
   Default


.. container:: table-row

   Property
         **autoSize**
   
   Data type
         options[true,false]
   
   Description
         If set to true, for 'inline', 'ajax' and 'html' type content
         width/height is auto determined. If no dimensions set this may give
         unexpected results
   
   Default


.. container:: table-row

   Property
         **fitToView**
   
   Data type
         options[true,false]
   
   Description
         If set to true, fancyBox is resized to fit inside viewport
   
   Default


.. container:: table-row

   Property
         **aspectRatio**
   
   Data type
         options[true,false]
   
   Description
         If set to true, resizing is constrained by the original aspect ratio
         (images always keep ratio)
   
   Default


.. container:: table-row

   Property
         **topRatio**
   
   Data type
         string
   
   Description
         Top space ratio for vertical centering. If set to 0.5 than vertical
         and bottom spece will be equal. If 0 - fancyBox will be at the
         viewport top
   
   Default


.. container:: table-row

   Property
         **fixed**
   
   Data type
         options[true,false]
   
   Description
         If set to true, fancyBox position will be changed to 'fixed' if it
         fits inside viewport
   
   Default


.. container:: table-row

   Property
         **scrolling**
   
   Data type
         options[auto, yes, no]
   
   Description
         Set the overflow CSS property to create or hide scrollbars. Can be set
         to 'auto', 'yes' or 'no'
   
   Default


.. container:: table-row

   Property
         **wrapCSS**
   
   Data type
         string
   
   Description
         Customizable CSS class for wrapping element (great for custom styling)
   
   Default


.. container:: table-row

   Property
         **arrows**
   
   Data type
         options[true,false]
   
   Description
         If set to true, navigation arrows will be displayed
   
   Default


.. container:: table-row

   Property
         **closeBtn**
   
   Data type
         options[true,false]
   
   Description
         If set to true, close button will be displayed
   
   Default


.. container:: table-row

   Property
         **closeClick**
   
   Data type
         options[true,false]
   
   Description
         If set to true, fancyBox will be closed when user clicks the content
   
   Default


.. container:: table-row

   Property
         **nextClick**
   
   Data type
         options[true,false]
   
   Description
         If set to true, will navigate to next gallery item when user clicks
         the content
   
   Default


.. container:: table-row

   Property
         **mouseWheel**
   
   Data type
         options[true,false]
   
   Description
         If set to true, you will be able to navigate gallery using the mouse
         wheel
   
   Default


.. container:: table-row

   Property
         **loop**
   
   Data type
         options[true,false]
   
   Description
         If set to true, enables cyclic navigation. This means, if you click
         "next" after you reach the last element, first element will be
         displayed (and vice versa).
   
   Default


.. container:: table-row

   Property
         **modal**
   
   Data type
         options[true,false]
   
   Description
         If set to true, will disable navigation and closing
   
   Default


.. container:: table-row

   Property
         **autoPlay**
   
   Data type
         options[true,false]
   
   Description
         If set to true, slideshow will start after opening the first gallery
         item
   
   Default


.. container:: table-row

   Property
         **playSpeed**
   
   Data type
         int+
   
   Description
         Slideshow speed in milliseconds
   
   Default


.. container:: table-row

   Property
         **index**
   
   Data type
         int+
   
   Description
         Overrides group start index
   
   Default


.. container:: table-row

   Property
         **type**
   
   Data type
         string
   
   Description
         Overrides type for content. Supported types are 'image', 'inline',
         'ajax', 'iframe', 'swf' and 'html'
   
   Default


.. container:: table-row

   Property
         **href**
   
   Data type
         string
   
   Description
         Overrides content source link
   
   Default


.. container:: table-row

   Property
         **content**
   
   Data type
         string
   
   Description
         Overrides content to be displayed
   
   Default


.. container:: table-row

   Property
         **title**
   
   Data type
         string
   
   Description
         Overrides title content, accepts any HTML
   
   Default


.. container:: table-row

   Property
         **openEffect**
   
   Data type
         options[elastic,fade,none]
   
   Description
         Animation effect ('elastic', 'fade' or 'none') for each transition
         type
   
   Default


.. container:: table-row

   Property
         **closeEffect**
   
   Data type
         options[elastic,fade,none]
   
   Description
         Animation effect ('elastic', 'fade' or 'none') for each transition
         type
   
   Default


.. container:: table-row

   Property
         **nextEffect**
   
   Data type
         options[elastic,fade,none]
   
   Description
         Animation effect ('elastic', 'fade' or 'none') for each transition
         type
   
   Default


.. container:: table-row

   Property
         **prevEffect**
   
   Data type
         options[elastic,fade,none]
   
   Description
         Animation effect ('elastic', 'fade' or 'none') for each transition
         type
   
   Default


.. container:: table-row

   Property
         **openSpeed**
   
   Data type
         int+
   
   Description
         The time it takes (in ms, or "slow", "normal", "fast") to complete
         transition
   
   Default


.. container:: table-row

   Property
         **closeSpeed**
   
   Data type
         int+
   
   Description
         The time it takes (in ms, or "slow", "normal", "fast") to complete
         transition
   
   Default


.. container:: table-row

   Property
         **nextSpeed**
   
   Data type
         int+
   
   Description
         The time it takes (in ms, or "slow", "normal", "fast") to complete
         transition
   
   Default


.. container:: table-row

   Property
         **prevSpeed**
   
   Data type
         int+
   
   Description
         The time it takes (in ms, or "slow", "normal", "fast") to complete
         transition
   
   Default


.. container:: table-row

   Property
         **openEasing**
   
   Data type
         string
   
   Description
         Easing method for each transition type. You have numerous choices if
         easing plugin is included
   
   Default


.. container:: table-row

   Property
         **closeEasing**
   
   Data type
         string
   
   Description
         Easing method for each transition type. You have numerous choices if
         easing plugin is included
   
   Default


.. container:: table-row

   Property
         **nextEasing**
   
   Data type
         string
   
   Description
         Easing method for each transition type. You have numerous choices if
         easing plugin is included
   
   Default


.. container:: table-row

   Property
         **prevEasing**
   
   Data type
         string
   
   Description
         Easing method for each transition type. You have numerous choices if
         easing plugin is included
   
   Default


.. container:: table-row

   Property
         **openOpacity**
   
   Data type
         options[true,false]
   
   Description
         If set to true, transparency is changed for elastic transitions
   
   Default


.. container:: table-row

   Property
         **closeOpacity**
   
   Data type
         options[true,false]
   
   Description
         If set to true, transparency is changed for elastic transitions
   
   Default


.. container:: table-row

   Property
         **openMethod**
   
   Data type
         string
   
   Description
         Method from $.fancybox.transitions() that handles transition (you can
         add custom effects there)
   
   Default


.. container:: table-row

   Property
         **closeMethod**
   
   Data type
         string
   
   Description
         Method from $.fancybox.transitions() that handles transition (you can
         add custom effects there)
   
   Default


.. container:: table-row

   Property
         **nextMethod**
   
   Data type
         string
   
   Description
         Method from $.fancybox.transitions() that handles transition (you can
         add custom effects there)
   
   Default


.. container:: table-row

   Property
         **prevMethod**
   
   Data type
         string
   
   Description
         Method from $.fancybox.transitions() that handles transition (you can
         add custom effects there)
   
   Default


.. ###### END~OF~TABLE ######


