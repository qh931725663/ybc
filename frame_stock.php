<?php

include_once("check_dangkou_user.php");
?>
<div class="frame_main_div" style="min-height:400px;">
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select" onclick="mount_to_frame('frame_stock_bi_addup',0,'frame_stock')">当前库存</span>
            <span class="frame_tab_item" onclick="mount_to_frame('frame_stock_transfer',0,'frame_stock')">库存调拨</span>
            <span class="frame_tab_item" onclick="mount_to_frame('frame_stock_clear',0,'frame_stock')">清仓返厂</span>
            <span class="frame_tab_item" onclick="mount_to_frame('frame_stock_adjust',0,'frame_stock')">库存盘点</span>
        </div>
    </div>    
    <div id="frame_stock" />
</div>
<script>
mount_to_frame('frame_stock_bi_addup',0,'frame_stock');
</script>
