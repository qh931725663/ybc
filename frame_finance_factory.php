<?php
include_once("check_dangkou_user.php");
?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select"        onclick="click_tab_finance_factory($(this));mount_to_frame('frame_stock_warehousepurchase',0,'frame_finance_factory')">采购入库</span>
            <?php
            if ( ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1"  or (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1") ) and empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) )
            {
            ?>
            <span class="frame_tab_item" id="consignment_payment_factory" onclick="click_tab_finance_factory($(this));mount_to_frame('frame_finance_reg_cash',0,'frame_finance_factory')">代销提现</span>
            <span class="frame_tab_item" onclick="click_tab_finance_factory($(this));mount_to_frame('frame_agent_finance_addup',0,'frame_finance_factory')">代销对账</span>
            <span class="frame_tab_item" onclick="click_tab_finance_factory($(this));mount_to_frame('frame_finance_bi_pool_summary',0,'frame_finance_factory')">代销统计</span>
            <span class="frame_tab_item" onclick="click_tab_finance_factory($(this));mount_to_frame('frame_finance_reg_payable_summary',0,'frame_finance_factory')">经销付款</span>
            <span class="frame_tab_item" onclick="click_tab_finance_factory($(this));mount_to_frame('frame_deal_finance_addup',0,'frame_finance_factory')" style="display:none;">经销对账</span>
            <span class="frame_tab_item" onclick="click_tab_finance_factory($(this));mount_to_frame('frame_finance_bi_out_summary',0,'frame_finance_factory')">经销统计</span>
            <?php
            }
            ?>
        </div>
    </div>    
    <div id="frame_finance_factory" />
</div>
<script>
mount_to_frame('frame_stock_warehousepurchase',0,'frame_finance_factory');

function click_tab_finance_factory(obj)
{
    obj.parent().find(".frame_tab_item_select").removeClass('frame_tab_item_select').addClass("frame_tab_item");
    obj.addClass("frame_tab_item_select");
}
</script>
                
