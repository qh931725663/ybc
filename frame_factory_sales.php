<?php

include_once("check_factory_user.php");
?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select">销量统计</span>
        </div>
    </div>    
    <div id="frame_factory_sales" />
</div>
<script>
mount_to_frame('frame_factory_sales_agent',0,'frame_factory_sales');
</script>