<?php

include_once("check_dangkou_user.php");

$p_order=cselect("*","ydf_order",array("order_bianhao=?",$_REQUEST["var_order_bianhao"]) );
$roworder=$p_order[0]->fetch();
?>
<form id="form_order_set_pickupstatus">
<div class="order_paystatus_box">
    <p class="order_paystatus_box_p1">
        <span class="order_paystatus_box_p1_1"> 当前状态：</span>
        <span class="order_paystatus_box_p1_2"><span style='color:#009900'>未提货</span></span>
    </p>
    <p class="order_paystatus_box_p1">
        <span class="order_paystatus_box_p1_1"> 修改状态：</span>
        <span class="order_paystatus_box_p1_2"><span style='color:#FF3300'>已提货</span></span>
    </p>
</div>
<div class="chuku_order_paystatus_tip_notice_box">
    <span id="chuku_order_paystatus_tip_notice"></span>
</div>
<div class="order_paystatus_submit">
    <input type="hidden" name="var_order_bianhao" value="<?php echo $_REQUEST["var_order_bianhao"] ?>">
    <input type="hidden" name="var_order_is_pickup" value="<?php echo $roworder["order_is_pickup"] ?>">
    <input type="hidden" name="var_order_is_pay" value="0">
    <input type="hidden" name="var_order_seller" value="<?php echo $roworder["order_seller_bianhao"] ?>">
    <span onclick="view_sales_cashier.PostSetChukuOrderPickupStatus()">确认修改</span>
</div>  
</form>
