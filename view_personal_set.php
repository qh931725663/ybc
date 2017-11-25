<?php


$p_user=cselect("*","ydf_user",array("user_self_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_SELF_M_BIANHAO"]));
$row_user=$p_user[0]->fetch();

$alipay_user_account="";
$p_alipay=cselect("*","ydf_bank",array("bank_isstaff='1' and bank_type='3' and bank_boss_id=?",$_SESSION["ERP_ACCOUNT_USER_SELF_M_BIANHAO"]));
if ($row_alipay=$p_alipay[0]->fetch())
{
    $alipay_user_account=$row_alipay["bank_user_account"];
}

$bank_user_name="";
$bank_user_account="";
$bank_name="";
$p_bank=cselect("*","ydf_bank",array("bank_isstaff='1' and bank_type='2' and bank_boss_id=?",$_SESSION["ERP_ACCOUNT_USER_SELF_M_BIANHAO"]));
if ($row_bank=$p_bank[0]->fetch())
{
    $bank_user_name=$row_bank["bank_user_name"];
    $bank_user_account=$row_bank["bank_user_account"];
    $bank_name=$row_bank["bank_name"];
}
?>
                <div style="float:left; width:100%; overflow:hidden; display:block">
<form id="vfrom_personal_modify">    
                    <div style="position:relative; float:left; width:100%; margin-top:50px; padding:10px 0; display:block">
                        <span style="float:left; width:20%; padding:5px 0; text-align:right"><span style="color:red">*</span> 姓名：</span>
                        <span style="float:left"><input class="iinput" name="personal_user_name" id="personal_user_name" type="text" maxlength="50" style="width:100px; padding:5px" value="<?php echo $row_user["user_name"] ?>"/></span>
                        <span id="tip_user_name" style="float:left; margin-left:20px;"></span>
                    </div>
                    <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                        <span style="float:left; width:20%; padding:5px 0; text-align:right"><span style="color:red">*</span> 手机号码：</span>
                        <span style="float:left"><input class="iinput" name="personal_user_mobile" id="personal_user_mobile" type="text" maxlength="50" style="width:200px; padding:5px" value="<?php echo $row_user["user_mobile"] ?>"/></span>
                        <span id="tip_user_mobile" style="float:left; margin-left:20px;"></span>
                    </div>
                    <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                        <span style="float:left; width:20%; padding:5px 0; text-align:right">支付宝账号：</span>
                        <span style="float:left"><input class="iinput" id="alipay_user_account" name="alipay_user_account" type="text" maxlength="50" style="width:200px; padding:5px" value="<?php echo $alipay_user_account ?>"/></span>
                    </div>
                    <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                        <span style="float:left; width:20%; padding:5px 0; text-align:right">开户银行：</span>
                        <span style="float:left"><input class="iinput" id="bank_name" name="bank_name" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $bank_name ?>"/></span>
                    </div>
                    <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                        <span style="float:left; width:20%; padding:5px 0; text-align:right">开户人姓名：</span>
                        <span style="float:left"><input class="iinput" id="bank_user_name" name="bank_user_name" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $bank_user_name ?>"/></span>
                    </div>
                    <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                        <span style="float:left; width:20%; padding:5px 0; text-align:right">银行账号：</span>
                        <span style="float:left"><input class="iinput" id="bank_user_account" name="bank_user_account" type="text" maxlength="50" style="width:200px; padding:5px" value="<?php echo $bank_user_account ?>"/></span>
                    </div>            
                    <div style="float:left; width:80%; margin:30px 0 0 20%; overflow:hidden; display:block">
                        <span id="btn_personal_set_submit" class="btn_normal">确认修改</span>
                    </div>
</form>    
                </div>
                
<script type="text/javascript">    
$(function(){
    $('#btn_personal_set_submit').click(function(){
         if(!$("#personal_user_name").val())
        {
            $("#tip_user_name").html("<img src=/pc/images/error.png> <span style='color:red'>姓名不能为空！</span>");
            return false;
        }
        
         if(!$("#personal_user_mobile").val())
        {
            $("#tip_user_mobile").html("<img src=/pc/images/error.png> <span style='color:red'>手机号码不能为空！</span>");
            return false;
        }
                
        $.ajax({
            url:"model-bank-personal-api", 
            async: false,
            type: "POST",
            data:$('#vfrom_personal_modify').serialize(),
            dataType:"json",
            success: function(html){
                if (html["state"]=="ok")
                {
                    layer.msg("个人信息修改成功！", {time: 2000, icon:1});
                    setTimeout(function(){
                        mount_to_frame('view_personal_set',1,'frame_personal');
                    },2000);
                }
                else
                {
                    layer.msg(html["desc"], {time: 2000, icon:2});
                }
            }
        });        
    });

    $('#pid_view_personal_set').on('keydown',function(e){

                if(e.keyCode == 13){
                    //模拟点击登陆按钮，触发上面的 Click 事件
                    $('#pid_view_pensonal_set input,select').blur();
                    $("#btn_personal_set_submit").click(
                    );
                }
            });
});

</script>