<?php

include_once("check_dangkou_user.php");
?>
<form method="post" id="modifyfactoryfundform">
<input type="hidden" id="modifyfactoryfund_opt_type" name="opt_type" value="<?php echo $_REQUEST["var_opt"]?>">
<input type="hidden" name="factory_id" value="<?php echo $_REQUEST["var_factory_id"]?>">
<input type="hidden" name="bill_time" value="<?php echo $_REQUEST["var_bill_time"]?>">

<input type="hidden" id="modifyfactoryfund_fund_asset_old" name="fund_asset_old" value="<?php echo $_REQUEST["var_fund_asset"]?>">
<input type="hidden" id="modifyfactoryfund_fund_stock_old" name="fund_stock_old" value="<?php echo $_REQUEST["var_fund_stock"]?>">
<input type="hidden" name="fund_freeze_old" value="<?php echo $_REQUEST["var_fund_freeze"]?>">
<input type="hidden" name="fund_active_old" value="<?php echo $_REQUEST["var_fund_active"]?>">

<div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
    <?php
    if ( $_REQUEST["var_opt"]=="modify_asset")
    {
    ?>
    <p style="float:left; width:100%; padding:5px 0; display:block">
        <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right">本期结余资产：</span>
        <span style="float:left;">
        <input class="iinput" id="modifyfactoryfund_fund_asset" name="fund_asset" type="text" maxlength="50" style="width:100px; padding:5px" value="<?php echo $_REQUEST["var_fund_asset"]?>"/>
        </span>
    </p>
    <?php
    }
    else
    {
    ?>
    <p style="float:left; width:100%; padding:5px 0; display:block">
        <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right">本期结余资产：</span>
        <span style="float:left; margin:5px 0; text-align:left"><?php echo $_REQUEST["var_fund_asset"]?></span>
    </p>
    <p style="float:left; width:100%; padding:5px 0; display:block">
        <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">-</span> 本期结余库存：</span>
        <span style="float:left; margin:5px 0; text-align:left"><?php echo $_REQUEST["var_fund_stock"]?></span>
    </p>
    <p style="float:left; width:100%; padding:5px 0; display:block">
        <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">-</span> 本期交易中资金：</span>
        <span style="float:left;">
        <input class="iinput" id="modifyfactoryfund_fund_freeze" name="fund_freeze" type="text" maxlength="50" style="width:100px; padding:5px" value="<?php echo $_REQUEST["var_fund_freeze"]?>"/>
        </span>
    </p>
    <p style="float:left; width:100%; padding:5px 0; display:block;">
        <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">-</span> 本期结余可提现资金：</span>
        <span style="float:left;">
        <input class="iinput" id="modifyfactoryfund_fund_active" name="fund_active" type="text" maxlength="50" style="width:100px; padding:5px" value="<?php echo $_REQUEST["var_fund_active"]?>"/>
        </span>
    </p>
    <p style="float:left; width:100%; padding:5px 0; display:block">
        <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">=</span> 错差：</span>
        <span style="float:left; color:red; margin:5px 0; text-align:left" id="layer_fund_differ"><?php echo $_REQUEST["var_fund_asset"]-$_REQUEST["var_fund_stock"]-$_REQUEST["var_fund_freeze"]-$_REQUEST["var_fund_active"] ?></span>
    </p>
    <?php
    }
    ?>
</div>
<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
    <span id="modifyfactoryfund_tip_notice" style="float:left;margin-left:150px"></span>
</div>
<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
    <span id="modifyfactoryfund_affirm_btn" onclick="PostModifyFactoryFund()" style="float:left; margin-left:150px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认修改</span>
</div>    
</form>    

<script type="text/javascript">
$(function(){
    
    $("#modifyfactoryfund_fund_freeze,#modifyfactoryfund_fund_active").keyup(function(){
        $("#layer_fund_differ").html(parseFloat($("#modifyfactoryfund_fund_asset_old").val())-parseFloat($("#modifyfactoryfund_fund_stock_old").val())-parseFloat($("#modifyfactoryfund_fund_freeze").val())-parseFloat($("#modifyfactoryfund_fund_active").val()));
    });

});

$('#layer_modifyfund').on('keydown',function(e){

            if(e.keyCode == 13){
                //模拟点击登陆按钮，触发上面的 Click 事件
                $('#layer_modifyfund input,select').blur();
                $("#modifyfactoryfund_affirm_btn").click(
                );
            }
        });
</script>
