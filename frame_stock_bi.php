<?php

include_once("check_dangkou_user.php");
?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select" onclick="mount_to_frame('frame_stock_bi_stock_time',0,'frame_stock_bi')">库存分析</span>
        </div>
    </div>    
    <div id="frame_stock_bi" />
</div>
<script>
mount_to_frame('frame_stock_bi_stock_time',0,'frame_stock_bi');


</script>
                
