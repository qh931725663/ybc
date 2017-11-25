<?php

include_once("check_dangkou_user.php");
?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select" onclick="click_tab_finance_bi($(this));mount_to_frame('view_debug_bill', 0,'frame_debug')">账单</span>
            <span class="frame_tab_item"        onclick="click_tab_finance_bi($(this));mount_to_frame('view_debug_order',0,'frame_debug')">订单</span>
            <span class="frame_tab_item"        onclick="click_tab_finance_bi($(this));mount_to_frame('view_debug_order_detail',0,'frame_debug')">订单详情</span>
            <span class="frame_tab_item"        onclick="click_tab_finance_bi($(this));mount_to_frame('view_debug_barcode',0,'frame_debug')">条码</span>
            <span class="frame_tab_item"        onclick="click_tab_finance_bi($(this));mount_to_frame('view_debug',0,'frame_debug')">debug</span>
        </div>
    </div>    
    <div id="frame_debug" />
</div>
<script>
mount_to_frame('view_debug_bill',0,'frame_debug');

function click_tab_finance_bi(obj)
{
    obj.parent().find(".frame_tab_item_select").removeClass('frame_tab_item_select').addClass("frame_tab_item");
    obj.addClass("frame_tab_item_select");
}
</script>
                
