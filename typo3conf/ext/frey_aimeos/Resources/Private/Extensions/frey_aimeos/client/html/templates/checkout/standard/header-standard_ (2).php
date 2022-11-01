<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2015-2017
 */

?>
<?= $this->get( 'standardHeader' ); ?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">

if(typeof Modernizr != 'undefined') {
        if(!Modernizr.inputtypes['date']) {
                $("input[type='date']").each(function() {
                        $(delivery-freyversand.datum).datepicker();
                });


        }
}

</script>

