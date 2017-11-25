<?php

?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select" onclick="click_tab_set($(this));mount_to_frame('frame_password',0,'frame_factory_set')">密码修改</span>
            <span class="frame_tab_item"        onclick="click_tab_set($(this));mount_to_frame('frame_mobile',0,'frame_factory_set')">手机绑定</span>
        </div>
    </div>    
    <div id="frame_factory_set" />
</div>
<script>
mount_to_frame('frame_password',0,'frame_factory_set');

function click_tab_set(obj)
{
    obj.parent().find(".frame_tab_item_select").removeClass('frame_tab_item_select').addClass("frame_tab_item");
    obj.addClass("frame_tab_item_select");
}
</script>