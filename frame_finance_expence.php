<?php

include_once("check_dangkou_user.php");
?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select">日常报销</span>
        </div>
    </div>    
    <div id="frame_finance_expence" />
</div>
<script>
mount_to_frame('frame_finance_reg_expence',0,'frame_finance_expence');
</script>