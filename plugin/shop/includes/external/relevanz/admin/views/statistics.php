<?php
/* -----------------------------------------------------------
Copyright (c) 2020 Releva GmbH - https://www.releva.nz
Released under the MIT License (Expat)
[https://opensource.org/licenses/MIT]
--------------------------------------------------------------
*/
?>
<iframe style="border: 0px; width: 100%;" id="relevanz-stats" class="loading" src="<?php echo $data['stats-url'];?>"></iframe>
<script type="text/javascript">
    (function($) {
        var $iframe = $("#relevanz-stats"),
            containerOffset = 0,
            resizeTimer = null;

        function recalcIframeHeight() {
            var wrapheight = 0;

            // Reset iframe height to a minimum to make this calculation work.
            $iframe.attr('height', 10);
            wrapheight = Math.max($(document).height(), $(window).height()) - containerOffset;

            $iframe.attr('height', wrapheight);
        }
        $iframe.on('load', function () {
            setTimeout(function () {
                $iframe.removeClass('loading');
            }, 1000);
        });
        $(document).ready(function () {
            containerOffset = $('#rz-content').offset().top;
            containerOffset += Math.max($('#footer').outerHeight(true), $('#footer > *').outerHeight(true));
            containerOffset += 14; // pure magic!
            recalcIframeHeight();
        });
        $(window).resize(function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function(){
                recalcIframeHeight();
            }, 100);
        });
    })(jQuery);
</script>
