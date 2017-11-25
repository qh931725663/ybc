<?php
include_once("check_dangkou_user.php");
?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select" onclick="click_tab_arrange($(this));mount_to_frame('frame_arrange_up',0,'frame_arrange')">退货上架</span>
            <span class="frame_tab_item"        onclick="click_tab_arrange($(this));mount_to_frame('frame_arrange_factory',0,'frame_arrange')">退货返厂</span>
        </div>
    </div>    
    <div id="frame_arrange" />
</div>
<script>
mount_to_frame('frame_arrange_up',0,'frame_arrange');

function click_tab_arrange(obj)
{
    obj.parent().find(".frame_tab_item_select").removeClass('frame_tab_item_select').addClass("frame_tab_item");
    obj.addClass("frame_tab_item_select");
}
</script>    
