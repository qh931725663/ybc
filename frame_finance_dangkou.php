<?php

include_once("check_dangkou_user.php");
?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <?php
            if ( ( ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1"  or (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1") ) and empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) ) or (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1") )
            {
            ?>
            <span class="frame_tab_item_select" onclick="click_tab_finance_dangkou($(this));mount_to_frame('frame_finance_reg_pure_sales_fund',0,'frame_finance_dangkou')">档口日记账</span>
            <span id="daily_reimbursement" class="frame_tab_item" onclick="click_tab_finance_dangkou($(this));mount_to_frame('frame_finance_reg_expence',0,'frame_finance_dangkou')">日常报销</span>
            <?php
            }
            else
            {
            ?>
            <span id="daily_reimbursement" class="frame_tab_item_select" onclick="click_tab_finance_dangkou($(this));mount_to_frame('frame_finance_reg_expence',0,'frame_finance_dangkou')">日常报销</span>
            <?php   
            }
            ?>
            
            <?php
            if ( ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1"  or (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1") ) and empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) )
            {
            ?>
            <span class="frame_tab_item" onclick="click_tab_finance_dangkou($(this));mount_to_frame('frame_finance_reg_bankio',0,'frame_finance_dangkou')">利润提现</span>
            <span class="frame_tab_item" onclick="click_tab_finance_dangkou($(this));mount_to_frame('frame_finance_bi_fund',0,'frame_finance_dangkou')">资金统计</span>
            <?php
            }
            ?>
        </div>
    </div>    
    <div id="frame_finance_dangkou" />
</div>
<script>
<?php
if ( ( ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1"  or (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1") ) and empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) ) or (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1") )
{
?>
mount_to_frame('frame_finance_reg_pure_sales_fund',0,'frame_finance_dangkou');
<?php
}
else
{
?>
mount_to_frame('frame_finance_reg_expence',0,'frame_finance_dangkou');
<?php
}
?>
function click_tab_finance_dangkou(obj)
{
    obj.parent().find(".frame_tab_item_select").removeClass('frame_tab_item_select').addClass("frame_tab_item");
    obj.addClass("frame_tab_item_select");
}
</script>
