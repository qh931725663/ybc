<?php

include_once("check_dangkou_user.php");
include_once "{$root_path}/model/model_bill.php";
?>
                <div class="search_box">
                    <div class="search_box_inner" style="margin:10px 0 0; padding:0">
                        <div style="float:right">
                            <span class="btn_normal_blue" onclick="/**/ShowAddBankLayer()">添加资金账户</span>
                        </div>
                    </div>
                    <div class="report_table_header" style="margin-top:20px; background:#f2f2f2">
                        <div style="width:30%;">账户类型</div>
                        <div style="width:60%;">账户信息</div>
                        <div style="width:10%;">操作</div>
                    </div>
                    <div id="pagelist" style="float:left; width:100%; overflow:hidden; display:block">


<?php
$p=cselect("*","ydf_bank",array("bank_isstaff='0' and (bank_type='2' or bank_type='3') and bank_boss_id=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","bank_id desc");
while ($rowbank=$p[0]->fetch())
{
?>
                        <div class="report_table_body" style="border-bottom:1px dashed #cccccc">
                            <div style="width:30%">
                            <?php
                            if ($rowbank["bank_type"]=="2")
                            {
                                echo "银行";
                            }
                            elseif ($rowbank["bank_type"]=="3")
                            {
                                echo "支付宝";
                            }
                            ?>
                            </div>
                            <div style="width:60%"><?php echo ($rowbank["bank_user_account"]?"<span style='color:#999999'>账号：</span>".$rowbank["bank_user_account"]:"").($rowbank["bank_name"]?" <span style='color:#999999'>开户行：</span>".$rowbank["bank_name"]:"").($rowbank["bank_user_name"]?" <span style='color:#999999'>开户人姓名：</span>".$rowbank["bank_user_name"]:"") ?></div>
                            <div style="width:10%">
                                <span style="color:#0099FF; cursor:pointer" onclick="/**/ShowModifyBankLayer(<?php echo $rowbank["bank_id"]?>)">修改</span>
                                <?php
                                if ($rowbank["bank_type"]=="4")
                                {
                                ?>
                                <span style="color:#999999; display:none;">删除</span>
                                <?php
                                }
                                else
                                {
                                ?>
                                <span style="color:#0099FF; cursor:pointer; display:none;" onclick="/**/delete_zjzh(<?php echo $rowbank["bank_id"] ?>)">删除</span>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
<?php
}
?>


                    </div>


                    <div id="layer_addbank" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
                        <form id="vform_zjzh">
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style=" width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 账户类型：</span>
                                <span>
                                    <select id="bank_type" name="bank_type" style="padding:5px">
                                      <option value="" selected>请选择</option>
                                      <option value="2">银行</option>
                                      <option value="3">支付宝</option>
                                    </select>
                                </span>
                            </p>
                            <div id="layer_account_info" style="float:left; width:100%; overflow:hidden; display:none">
                            <div id="layer_account_bank_info" style="float:left; width:100%; overflow:hidden; display:none">
                            <p>
                                <span style="width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 开户银行：</span>
                                <span>
                                <input id="bank_name" name="bank_name" type="text" maxlength="50" style="width:150px; padding:5px"/>
                                </span>
                            </p>
                            <p>
                                <span style="width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 开户人姓名：</span>
                                <span>
                                <input id="bank_user_name" name="bank_user_name" type="text" maxlength="50" style="width:150px; padding:5px"/>
                                </span>
                            </p>
                            </div>
                            <p>
                                <span style="width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 账号：</span>
                                <span>
                                <input id="bank_user_account" name="bank_user_account" type="text" maxlength="50" style="width:150px; padding:5px; margin-left:23px;"/>
                                </span>
                            </p>
                            <p style="display:none">
                                <span style="width:100px; color:#999999; margin:5px 0; text-align:right">初始资金：</span>
                                <span>
                                <input id="bank_user_account_init" name="bank_user_account_init" type="text" maxlength="50" style="width:100px; padding:5px; margin-top:5px; margin-left:8px;" value="0"/>
                                </span>
                            </p>
                            </div>
                        </div>
                        <div style="float:left; margin:20px 0 0 100px; overflow:hidden; display:block">
                            <span id="tip_add_user" style="float:left"></span>
                        </div>
                        <div style="float:left; margin:20px 0 0 100px">
                            <span class="btn_normal" onclick="/**/post_pay_zjzh()" id="add_bank_affirm_btn"> 确认添加 </span>
                        </div>
                        <input type="hidden" name="op" value="insert">
                        </form>            
                    </div>
                    
                    <div id="layer_modify_bank" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
            
                    </div>

                </div>
                
<script type="text/javascript">
$(function(){
    $("#bank_type").change(function(){
        if ($(this).val()=="2")
        {        
            $("#layer_account_bank_info").show();
            $("#layer_account_info").show();                    
        }
        else if ($(this).val()=="3")
        {
            $("#layer_account_bank_info").hide();
            $("#layer_account_info").show();                            
        }
        else
        {
            $("#layer_account_bank_info").hide();                    
            $("#layer_account_info").hide();
        }
    });
});

function ShowAddBankLayer(){
    index_layer_addbank=layer.open({
        type: 1,
        area: ['420px', '400px'],
        title: false,
        content:$('#layer_addbank')

    });
}

function post_pay_zjzh(){ 
    if(!$("#bank_type").val())
    {
        $("#tip_notice_addbank").html("<span style='font-size:12px; color:red'>亲，请先选择账户类型哦！</span>");
        return false;
    }

    if($("#bank_type").val()=="2" && !$("#bank_name").val())
    {
        $("#tip_notice_addbank").html("<span style='font-size:12px; color:red'>亲，开户银行不能为空哦！</span>");
        return false;
    }
    
    if($("#bank_type").val()=="2" && !$("#bank_user_name").val())
    {
        $("#tip_notice_addbank").html("<span style='font-size:12px; color:red'>亲，开户人姓名不能为空哦！</span>");
        return false;
    }
    
    if($("#bank_type").val()=="2" && !$("#bank_user_account").val())
    {
        $("#tip_notice_addbank").html("<span style='font-size:12px; color:red'>亲，银行账号不能为空哦！</span>");
        return false;
    }
        
    if($("#bank_type").val()=="3" && !$("#bank_user_account").val())
    {
        $("#tip_notice_addbank").html("<span style='font-size:12px; color:red'>亲，支付宝账号不能为空哦！</span>");
        return false;
    }
    
    $.ajax({
        url:"model-bank-api", 
        async: false,
        type: "POST",
        dataType:"json",
        data:$("#vform_zjzh").serialize(),
        error:function(){
            layer.close(index_layer_addbank);
            layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
        },
        success: function(html){
            layer.close(index_layer_addbank);
            if (html.state!="ok"){
                layer.msg('提交失败！', {time: 2000, icon:2});
                return;
            }
            layer.msg('提交成功！', {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_bank_account',1,'frame_bank');
            },0);
        }
    });    
}

$('#layer_addbank').on('keydown',function(e){

            if(e.keyCode == 13){
                //模拟点击登陆按钮，触发上面的 Click 事件
                $('#layer_addbank input,select').blur();
                $("#add_bank_affirm_btn").click(
                );
            }
        });

function ShowModifyBankLayer(bank_id)
{
    $.ajax({
        url:"get-modifybank", 
        async: false,
        type: "POST",
        data:{var_bank_id:bank_id},
        success: function(html){
            $("#layer_modify_bank").html(html);
        }
    });
    
    index_layer_modify_bank=layer.open({
        type: 1,
        area: ['420px', '200px'],
        title: false,
        content:$('#layer_modify_bank')
    });
}

function post_zjzh_modify(){ 
    if($("#modify_bank_type").val()=="2" && !$("#modify_bank_name").val())
    {
        $("#tip_notice_modifybank").html("<span style='font-size:12px; color:red'>亲，开户银行不能为空哦！</span>");
        return false;
    }
    
    if($("#modify_bank_type").val()=="2" && !$("#modify_bank_user_name").val())
    {
        $("#tip_notice_modifybank").html("<span style='font-size:12px; color:red'>亲，开户人姓名不能为空哦！</span>");
        return false;
    }
    
    if($("#modify_bank_type").val()=="2" && !$("#modify_bank_user_account").val())
    {
        $("#tip_notice_modifybank").html("<span style='font-size:12px; color:red'>亲，银行账号不能为空哦！</span>");
        return false;
    }
        
    if($("#modify_bank_type").val()=="3" && !$("#modify_bank_user_account").val())
    {
        $("#tip_notice_modifybank").html("<span style='font-size:12px; color:red'>亲，支付宝账号不能为空哦！</span>");
        return false;
    }
    
    $.ajax({
        url:"model-bank-api", 
        async: false,
        type: "POST",
        dataType:"json",
        data:$("#vform_zjzh_modify").serialize(),
        error:function(){
            layer.close(index_layer_modify_bank);
            layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
        },
        success: function(html){
            layer.close(index_layer_modify_bank);
            if (html.state!="ok"){
                layer.msg('提交失败！', {time: 2000, icon:2});
                return;
            }
            layer.msg('提交成功！', {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_bank_account',1,'frame_bank');
            },0);
        }
    });    
}

function delete_zjzh(bank_id){
    $.ajax({
        url:"model-bank-api", 
        async: false,
        type: "POST",
        dataType:"json",
        data:{op:"delete",bank_id:bank_id},
        error:function(){
            layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
        },
        success: function(html){
            if (html.state!="ok"){
                layer.msg('删除失败！', {time: 2000, icon:2});
                return;
            }
            layer.msg('删除成功！', {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_bank_account',1,'frame_bank');
            },0);
        }
    });    
}
</script>