<?php

include_once("check_dangkou_user.php");
?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select" onclick="click_tab_finance_bi($(this));mount_to_frame('frame_finance_bi_fund',0,'frame_finance_bi')">资金统计</span>
        </div>
    </div>    
    <div id="frame_finance_bi" />
</div>
<script type="text/javascript" src="/pc/Date/jquery-ui.js"></script>
<script type="text/javascript" src="/pc/Date/dateinput-ch-ZN.js"></script>
<script>
mount_to_frame('frame_finance_bi_fund',0,'frame_finance_bi');

function click_tab_finance_bi(obj)
{
    obj.parent().find(".frame_tab_item_select").removeClass('frame_tab_item_select').addClass("frame_tab_item");
    obj.addClass("frame_tab_item_select");
}
</script>
                
