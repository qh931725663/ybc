<?php

include_once("check_dangkou_user.php");
?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select" onclick="mount_to_frame('frame_products_list',0,'frame_products')">商品设置</span>
            <span class="frame_tab_item"        onclick="mount_to_frame('view_products_barcodeprint',0,'frame_products')">条码打印</span>
            <!--<span class="frame_tab_item"        onclick="mount_to_frame('frame_products_init',0,'frame_products')">库存初始化</span>-->
        </div>
    </div>    
    <div id="frame_products" />
</div>
<script>
mount_to_frame('frame_products_list',0,'frame_products');

</script>
