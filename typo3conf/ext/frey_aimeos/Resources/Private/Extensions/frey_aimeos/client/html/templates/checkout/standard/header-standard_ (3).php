<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2015-2017
 */

?>
<?= $this->get( 'standardHeader' ); ?>


<script
src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"
integrity="sha256-ffw+9zwShMev88XNrDgS0hLIuJkDfXhgyLogod77mn8="
crossorigin="anonymous"></script>

<script
src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
integrity="sha256-KM512VNnjElC30ehFwehXjx1YCHPiQkOPmqnrWtpccM="
crossorigin="anonymous"></script>

 <script>
if(typeof Modernizr != 'undefined') {
        if(!Modernizr.inputtypes['date']) {
                $("input[type='date']").each(function(idx, elem) {
                        $(elem).datepicker({
                                dateFormat: 'yy-mm-dd',
                                constrainInput: false
                        });
                });
 </script>