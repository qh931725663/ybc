<?php

include_once("check_dangkou_user.php");
include_once "{$root_path}/model/model_bill.php";

$rsdangkou=mysql_query("select * from ydf_dangkou where dangkou_bianhao='".$_REQUEST["var_dangkou_bianhao"]."'", $dbconn);
$rowdangkou=mysql_fetch_array($rsdangkou);

$bank_id="0";
$rsbank=mysql_query("select * from ydf_bank where bank_type='2' and bank_id in (select dangkou_bank_bank_bianhao from ydf_dangkou_bank where dangkou_bank_dangkou_bianhao='".$rowdangkou["dangkou_bianhao"]."')", $dbconn);
if($rowbank=mysql_fetch_array($rsbank))
{
    $bank_id=$rowbank["bank_id"];
}
    
$alipay_account_id="0";
$rsalipay=mysql_query("select * from ydf_bank where bank_type='3' and bank_id in (select dangkou_bank_bank_bianhao from ydf_dangkou_bank where dangkou_bank_dangkou_bianhao='".$rowdangkou["dangkou_bianhao"]."')", $dbconn);
if($rowalipay=mysql_fetch_array($rsalipay))
{
    $alipay_account_id=$rowalipay["bank_id"];
}
?>
<form method="post" id="fundaccountmodifyform">
<div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
    <span style="float:left; width:20%; padding:5px 0; color:#999999; text-align:right">初始预留现金：</span>
    <span style="float:left; width:80%;">
         <input class="iinput" id="store_cash_init" name="store_cash_init" type="text" maxlength="50" style="width:100px; padding:5px" value="<?php echo get_init_fund_bill("jrylcsh",$_REQUEST["var_dangkou_bianhao"]) ?>">
    </span>
</div>
<div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
    <span style="float:left; width:20%; padding:5px 0; color:#999999; text-align:right">银行账号：</span>
    <span style="float:left; width:80%;">
         <select id="store_bank_bianhao" name="store_bank_bianhao" style="padding:5px">    
            <option value="">选择</option>
            <?php
            $rsbank=mysql_query("select * from ydf_bank where bank_type='2' and bank_boss_id='".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."'", $dbconn);
            while($rowbank=mysql_fetch_array($rsbank))
            {
            ?>
            <option value="<?php echo $rowbank["bank_id"] ?>" <?php if ($bank_id==$rowbank["bank_id"]) { echo "selected"; } ?>><?php echo $rowbank["bank_user_account"] ?> | <?php echo $rowbank["bank_name"] ?> | <?php echo $rowbank["bank_user_name"] ?></option>
            <?php
            }
            ?>
        </select>
    </span>
</div>
<div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
    <span style="float:left; width:20%; padding:5px 0; color:#999999; text-align:right">支付宝账号：</span>
    <span style="float:left; width:80%;">
         <select id="store_alipay_bianhao" name="store_alipay_bianhao" style="padding:5px">    
            <option value="">选择</option>
            <?php
            $rsalipay=mysql_query("select * from ydf_bank where bank_type='3' and bank_boss_id='".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."'", $dbconn);
            while($rowalipay=mysql_fetch_array($rsalipay))
            {
            ?>
            <option value="<?php echo $rowalipay["bank_id"] ?>" <?php if ($alipay_account_id==$rowalipay["bank_id"]) { echo "selected"; } ?>><?php echo $rowalipay["bank_user_account"] ?></option>
            <?php
            }
            ?>
        </select>
    </span>
</div>
<div style="float:left; width:80%; margin:30px 0 0 20%; overflow:hidden; display:block">
    <span id="store_fundaccount_tip_notice" style="float:left"></span>
</div>
<div style="float:left; width:80%; margin:20px 0 0 20%; overflow:hidden; display:block">
    <span id="store_fundaccount_affirm_btn" class="btn_normal" onclick="PostStoreFundaccount()"> 确认提交 </span>
</div>    
<input  type="hidden" name="var_dangkou_bianhao" value="<?php echo $rowdangkou["dangkou_bianhao"] ?>">
</form>

<script type="text/javascript">
    $('#layer_store_fundaccount').on('keydown',function(e){
        if(e.keyCode == 13){
        //模拟点击登陆按钮，触发上面的 Click 事件
        $('#layer_store_fundaccount input,select').blur();
        $("#store_fundaccount_affirm_btn").click();
        }
    });
</script>