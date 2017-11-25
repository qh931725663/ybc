<?php

include_once("check_dangkou_user.php");

$p_order=cselect("*","ydf_order",array("order_bianhao=?",$_REQUEST["var_order_bianhao"]) );
$roworder=$p_order[0]->fetch();

$opt_is_dangkou="1";
?>
<form id="form_order_set_paystatus">
<div class="order_paystatus_box">
    <p class="order_paystatus_box_p1">
        <span class="order_paystatus_box_p1_1"> 当前状态：</span>
        <span class="order_paystatus_box_p1_2"><?php echo $roworder["order_is_pay"]=="0"?"<span style='color:#FF3300'>未付款</span>":"<span style='color:#009900'>已付款</span>" ?></span>
    </p>
    <p class="order_paystatus_box_p1">
        <span class="order_paystatus_box_p1_1"> 修改状态：</span>
        <span class="order_paystatus_box_p1_2"><?php echo $roworder["order_is_pay"]=="0"?"<span style='color:#009900'>已付款</span>":"<span style='color:#FF3300'>未付款</span>" ?></span>
    </p>
    <?php
    if (empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) or (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]<>"1"))
    {
        $opt_is_dangkou="0";
        
        if ($roworder["order_is_pay"]=="0")
        {
    ?>
    <p class="order_paystatus_box_p1">
        <span class="order_paystatus_box_p1_1"> 收款资金账户：</span>
        <span class="order_paystatus_box_p1_2">
            <select id="order_bill_bank" name="bill_bank" style="padding:5px">
              <option value="" selected>请选择</option>
            <?php
            if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4" and ($_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1" or $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="3")))
            {
                $p=cselect("*","ydf_bank",array("bank_type<>'4' and bank_type<>'1' and bank_type<>'5' and bank_isstaff='0' and bank_boss_id=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","bank_id desc");
                while ($rowbank=$p[0]->fetch())
                {
                ?>
                    <option value="<?php echo $rowbank["bank_id"]?>"><?php echo $rowbank["bank_type"]=="3"?"支付宝：".$rowbank["bank_user_account"]:$rowbank["bank_name"]." ".$rowbank["bank_user_account"]." ".$rowbank["bank_user_name"]?></option>
            <?php
                }
            }
            elseif (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1")
            {
                $p_dangkou_bank=cselect("*","ydf_dangkou_bank",array("dangkou_bank_type='3' and dangkou_bank_dangkou_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]) );
                if ($rowdangkoubank=$p_dangkou_bank[0]->fetch())
                {
                    $p_bank=cselect("*","ydf_bank",array("bank_id=?",$rowdangkoubank["dangkou_bank_bank_bianhao"]) );
                    $rowbank=$p_bank[0]->fetch();
                ?>
                    <option value="<?php echo $rowbank["bank_id"]?>"><?php echo "支付宝 ".$rowbank["bank_user_account"] ?></option>
            <?php
                }
            }
            ?>
            </select>
        </span>
    </p>
    <?php
        }
    }
    ?>
</div>
<div class="chuku_order_paystatus_tip_notice_box">
    <span id="chuku_order_paystatus_tip_notice"></span>
</div>
<div class="order_paystatus_submit">
    <input type="hidden" name="var_order_bianhao" value="<?php echo $_REQUEST["var_order_bianhao"] ?>">
    <input type="hidden" name="var_order_is_pickup" value="<?php echo $roworder["order_is_pickup"] ?>">
    <input type="hidden" name="var_order_is_pay" value="<?php echo $roworder["order_is_pay"]=="0"?1:0 ?>">
    <input type="hidden" name="var_order_seller" value="<?php echo $roworder["order_seller_bianhao"] ?>">
    <span onclick="view_sales_cashier.PostSetChukuOrderPayStatus(<?php echo $opt_is_dangkou?>,<?php echo $roworder["order_is_pay"]?>)">确认修改</span>
</div>  
</form>