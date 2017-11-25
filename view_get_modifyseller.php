<?php

include_once("check_dangkou_user.php");

$p_seller=cselect("*","ydf_seller",array("seller_bianhao=?",$_REQUEST["var_seller_bianhao"]));
$rowseller=$p_seller[0]->fetch();
?>
<form method="post" id="modifysellerform">
<div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
    <p style="float:left; width:100%; padding:5px 0; display:block">
        <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 手机号：</span>
        <span style="float:left;">
        <input class="iinput" name="modifyseller_seller_mobile" id="modifyseller_seller_mobile" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowseller["seller_mobile"]?>"/>
        </span>
    </p>
    <p style="float:left; width:100%; padding:5px 0; display:block">
        <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 卖家昵称：</span>
        <span style="float:left;">
        <input class="iinput" name="modifyseller_seller_name" id="modifyseller_seller_name" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowseller["seller_name"]?>"/>
        </span>
    </p>
    <p style="float:left; width:100%; padding:5px 0; display:block">
        <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 结算类型：</span>
        <span style="float:left;">
            <select id="modifyseller_seller_cycle" name="modifyseller_seller_cycle" style="padding:5px">
              <option value="">请选择</option>
              <option value="0" <?php echo $rowseller["seller_cycle"]=="0"?"selected":""; ?>>现结</option>
              <option value="7" <?php echo $rowseller["seller_cycle"]=="7"?"selected":""; ?>>账期</option>
            </select>
        </span>
    </p>
</div>
<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
    <span id="modify_seller_tip_notice" style="float:left;margin-left:80px"></span>
</div>
<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
    <span id="modifyfactoryfund_affirm_btn"  onclick="PostModifySeller()" style="float:left; margin-left:80px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认修改</span>
</div>    
<input id="modify_seller_affirm_btn" type="hidden" name="modifyseller_seller_bianhao" value="<?php echo $rowseller["seller_bianhao"]?>">
</form>

<script type="text/javascript">
    $("#layer_modifyseller").on('keydown',function(e){
        if(e.keyCode == 13){
            //模拟点击登陆按钮，触发上面的 Click 事件
            $('#layer_modifyseller input,select').blur();
            $("#modifyfactoryfund_affirm_btn").click(
            );
        }
    });
</script>