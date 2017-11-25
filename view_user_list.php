<?php

include_once("check_dangkou_user.php");
?>
                <div class="search_box">
                    <div class="search_box_inner" style="margin:10px 0 0; padding:0">
                        <div class="rt">
                            <span class="btn_normal_blue" onclick="/**/ShowAddUserLayer()">添加员工</span>
                        </div>
                    </div>    
                    <div class="report_table_header" style="margin-top:20px; background:#f2f2f2">
                        <div style="width:15%">子账号</div>
                        <div style="width:10%">姓名</div>
                        <div style="width:15%">手机号码</div>
                        <div style="width:15%">用户类型</div>
                        <div style="width:15%">档口 / 仓库</div>
                        <div style="width:15%">添加时间</div>
                        <div style="width:15%;">操作</div>
                    </div>
                    <div id="pagelist">
                    
                    
<?php
$sqllistdata="select * from ydf_user where user_boss_m_bianhao = '".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."' order by user_addtime desc";
$rspagedata=mysql_query($sqllistdata , $dbconn);    
while ($rowpagedata=mysql_fetch_array($rspagedata))
{
?>
                        <div class="report_table_body" style="border-bottom:1px dashed #cccccc">
                            <div style="width:15%"><?php echo $rowpagedata["user_account"];?></div>
                            <div style="width:10%"><?php echo $rowpagedata["user_name"] ?></div>
                            <div style="width:15%"><?php echo $rowpagedata["user_mobile"] ?></div>
                            <div style="width:15%">
                                <?php
                                if ($rowpagedata["user_type"]=="1")
                                {
                                ?>
                                <span style="color:#0099FF">超级用户</span>
                                <?php
                                }
                                elseif ($rowpagedata["user_type"]=="2")
                                {
                                ?>
                                <span style="color:#FF9900">档口用户</span>
                                <?php
                                }
                                elseif ($rowpagedata["user_type"]=="3")
                                {
                                ?>
                                <span style="color:#d64126">仓库用户</span>
                                <?php
                                }
                                ?>
                            </div>
                            <div style="width:15%"><?php echo !empty($rowpagedata["user_dangkou_name"])?$rowpagedata["user_dangkou_name"]:"-" ?></div>
                            <div style="width:15%"><?php echo date("Y-m-d H:i:s",$rowpagedata["user_addtime"]); ?></div>
                            <div style="width:15%"><span style="color:#0099FF; cursor:pointer" onclick="/**/ShowModifyUserLayer(<?php echo $rowpagedata["user_bianhao"]?>)">修改</span> |
                            <?php
                            if ($rowpagedata["user_boss_m_bianhao"]==$rowpagedata["user_self_m_bianhao"])
                            {
                            ?>
                            <span style="color:#999999">删除</span>
                            <?php
                            }
                            else
                            {
                            ?>
                            <span style="color:#0099FF; cursor:pointer" onclick="/**/DeleteUser(<?php echo $rowpagedata["user_bianhao"]?>)">删除</span>
                            <?php
                            }
                            ?>
                            </div>
                        </div>
<?php
}
?>
                    
                    
                    </div>


                    <div id="layer_adduser">
                        <form id="form_add_user">
                        <div style="line-height:1.8">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right">子账号：</span>
                                <span id="show_user_account" style="float:left; color:#ee583d; margin:5px 0"></span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 登录密码：</span>
                                <span class="lf">
                                <input class="iinput" name="user_pwd" id="user_pwd" type="password" maxlength="50" style="width:150px; padding:5px"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 姓名：</span>
                                <span class="lf">
                                <input class="iinput" name="user_name" id="user_name" type="text" maxlength="50" style="width:100px; padding:5px"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 手机号码：</span>
                                <span class="lf">
                                <input class="iinput" name="user_mobile" id="user_mobile" type="text" maxlength="50" style="width:200px; padding:5px"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 用户类型：</span>
                                <span class="lf">
                                    <select id="user_type" name="user_type" style="padding:5px">
                                      <option value="" selected>请选择</option>
                                      <option value="1">超级用户</option>
                                      <option value="2">档口用户</option>
                                      <option value="3">仓库用户</option>
                                    </select>
                                </span>
                            </p>
                            <p id="layer_dangkou_select" style="float:left; width:100%; padding:5px 0; display:none">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 管理档口：</span>
                                <span style="float:left;">
                                    <select id="user_dangkou" name="user_dangkou" style="padding:5px">
                                      <option value="" selected>请选择</option>
                                    <?php
                                    $rsdangkou=mysql_query("select * from ydf_dangkou where dangkou_type='1' and dangkou_boss_m_bianhao = '".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."'", $dbconn);
                                    while($rowdangkou=mysql_fetch_array($rsdangkou))
                                    {
                                    ?>
                                      <option value="<?php echo $rowdangkou["dangkou_bianhao"] ?>"><?php echo $rowdangkou["dangkou_name"] ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </span>
                            </p>
                            <p id="layer_store_select" style="float:left; width:100%; padding:5px 0; display:none">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 管理仓库：</span>
                                <span class="lf">
                                    <select id="user_store" name="user_store" style="padding:5px">
                                      <option value="" selected>请选择</option>
                                    <?php
                                    $rsstore=mysql_query("select * from ydf_dangkou where dangkou_type='2' and dangkou_boss_m_bianhao = '".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."'", $dbconn);
                                    while($rowstore=mysql_fetch_array($rsstore))
                                    {
                                    ?>
                                      <option value="<?php echo $rowstore["dangkou_bianhao"] ?>"><?php echo $rowstore["dangkou_name"] ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </span>
                            </p>
                        </div>
                        <div style="float:left; margin:20px 0 0 80px">
                            <span id="tip_add_user" style="float:left"></span>
                        </div>
                        <div style="float:left; margin:20px 0 0 80px">
                            <span class="btn_normal" onclick="/**/PostAddUser()" id="add_user_affirm_btn"> 确认添加 </span>
                        </div>  
                        <input type="hidden" id="user_account" name="user_account">
                        </form>            
                    </div>
                    
                    <div id="layer_modifyuser" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
                    </div>

                </div>
                
<script type="text/javascript">    
$(function(){    
    $("#user_type").change(function(){
        if ($(this).val()=="2")
        {                            
            $("#layer_dangkou_select").show();
            $("#layer_store_select").hide();
        }
        else if ($(this).val()=="3")
        {                            
            $("#layer_dangkou_select").hide();
            $("#layer_store_select").show();
        }
        else
        {                            
            $("#layer_dangkou_select").hide();
            $("#layer_store_select").hide();
        }
    });
});

function SetModifyChangeUserType(obj){
    if (obj.val()=="2")
    {                            
        obj.parent().parent().next().show();
        obj.parent().parent().next().next().hide();
    }
    else if (obj.val()=="3")
    {                            
        obj.parent().parent().next().hide();
        obj.parent().parent().next().next().show();
    }
    else
    {                            
        obj.parent().parent().next().hide();
        obj.parent().parent().next().next().hide();
    }
}

function ShowAddUserLayer(){
    $.ajax({
        url:"model-get-user-account", 
        async: false,
        type: "POST",
        data:"",
        success: function(html){
            $("#show_user_account").html(html);
            $("#user_account").val(html);
        }
    });
    
    index_layer_adduser=layer.open({
        type: 1,
        area: ['470px', '400px'],
        title: false,
        content:$('#layer_adduser')
    });
}

function PostAddUser(){ 
    if(!$("#user_pwd").val())
    {
        $("#tip_add_user").html("<span style='font-size:14px; color:red'>亲，登录密码不能为空哦！</span>");
        return false;
    }
    
    if(!$("#user_name").val())
    {
        $("#tip_add_user").html("<span style='font-size:14px; color:red'>亲，姓名不能为空哦！</span>");
        return false;
    }
    
    if(!$("#user_name").val())
    {
        $("#tip_add_user").html("<span style='font-size:14px; color:red'>亲，手机号码不能为空哦！</span>");
        return false;
    }
    
    if(!$("#user_type").val())
    {
        $("#tip_add_user").html("<span style='font-size:14px; color:red'>亲，请选择用户类型哦！</span>");
        return false;
    }
    
    if($("#user_type").val()=="2" && !$("#user_dangkou").val())
    {
        $("#tip_add_user").html("<span style='font-size:14px; color:red'>亲，请选择管理档口空哦！</span>");
        return false;
    }
    
    if($("#user_type").val()=="3" && !$("#user_store").val())
    {
        $("#tip_add_user").html("<span style='font-size:14px; color:red'>亲，请选择管理仓库哦！</span>");
        return false;
    }
        
    $.ajax({
        url:"model-post-adduser", 
        async: false,
        type: "POST",
        data:{var_user_account:$("#user_account").val(),var_user_pwd:$("#user_pwd").val(),var_user_name:$("#user_name").val(),var_user_mobile:$("#user_mobile").val(),var_user_type:$("#user_type").val(),var_user_dangkou:$("#user_dangkou").val(),var_user_store:$("#user_store").val()},
        success: function(html){
            if (parseInt(html)==1001)
            {
                alert("姓名已存在！");
                return false;            
            }
            else
            {
                layer.close(index_layer_adduser);
                layer.msg("添加成功！", {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_user_list',1,'frame_user');
                },2000);
            }
        }
    });    
}

$('#layer_adduser').on('keydown',function(e){

            if(e.keyCode == 13){
                //模拟点击登陆按钮，触发上面的 Click 事件
                $('#layer_adduser input,select').blur();
                $("#add_user_affirm_btn").click(
                );
            }
        });

function ShowModifyUserLayer(user_bianhao){
    $.ajax({
        url:"view-get-modifyuser", 
        async: false,
        type: "POST",
        data:{var_user_bianhao:user_bianhao},
        success: function(html){
            $("#layer_modifyuser").html(html);
        }
    });
    
    index_layer_modifyuser=layer.open({
        type: 1,
        area: ['420px', '400px'],
        title: false,
        content:$('#layer_modifyuser')
    });
}

function PostModifyUser(user_bianhao){ 
    if(!$("#user_name_"+user_bianhao).val())
    {
        $("#tip_modify_user").html("<span style='font-size:12px; color:red'>亲，姓名不能为空哦！</span>");
        return false;
    }
    
    if(!$("#user_mobile_"+user_bianhao).val())
    {
        $("#tip_modify_user").html("<span style='font-size:12px; color:red'>亲，手机号码不能为空哦！</span>");
        return false;
    }
    
    if(!$("#user_type_"+user_bianhao).val())
    {
        $("#tip_modify_user").html("<span style='font-size:12px; color:red'>亲，请选择用户类型哦！</span>");
        return false;
    }
    
    if($("#user_type_"+user_bianhao).val()=="2" && !$("#user_dangkou_"+user_bianhao).val())
    {
        $("#tip_modify_user").html("<span style='font-size:12px; color:red'>亲，请选择管理档口空哦！</span>");
        return false;
    }
    
    if($("#user_type_"+user_bianhao).val()=="3" && !$("#user_store_"+user_bianhao).val())
    {
        $("#tip_modify_user").html("<span style='font-size:12px; color:red'>亲，请选择管理仓库哦！</span>");
        return false;
    }
        
    $.ajax({
        url:"post-modifyuser", 
        async: false,
        type: "POST",
        data:{var_user_bianhao:user_bianhao,var_user_pwd:$("#user_pwd_"+user_bianhao).val(),var_user_name:$("#user_name_"+user_bianhao).val(),var_user_mobile:$("#user_mobile_"+user_bianhao).val(),var_user_type:$("#user_type_"+user_bianhao).val(),var_user_dangkou:$("#user_dangkou_"+user_bianhao).val(),var_user_store:$("#user_store_"+user_bianhao).val()},
        success: function(html){
            if (parseInt(html)==1001)
            {
                alert("姓名已存在！");
                return false;            
            }
            else
            {
                layer.close(index_layer_modifyuser);
                layer.msg("修改成功！", {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_user_list',1,'frame_user');
                },2000);
            }
        }
    });    
}

function DeleteUser(user_bianhao){
    if(confirm("确定要删除当前的信息吗？"))
    {
    
        $.ajax({
            url:"delete-user", 
            async: false,
            type: "POST",
            data:{var_user_bianhao:user_bianhao},
            success: function(html){
                layer.msg('删除成功！', {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_user_list',1,'frame_user');
                },2000);
            }
        });
    }    
}
</script>
