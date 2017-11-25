<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户注册-优百仓档口管家</title>
<style type="text/css">
<!--
body{
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
    font-size:12px;
    color:#333333;
    background:#f2f2f2;
    
}
html, body{height:100%;}
img {border:0 none;}
ul,li{ list-style-type:none;}
a{color:#333333;text-decoration:none}a:hover{color:#d64126}
a.linkred{color:#ee583d;text-decoration:none}a.linkred:hover{color:#d64126}
a.linkblue{color:blue;text-decoration:none}a.linkblue:hover{color:#d64126}
#btn_reg{float:left;width:287px; margin:0 10px 10px 10px; padding:10px 0; background:#30c0db; font-size:14px; font-weight:bold; color:#ffffff; text-align:center; overflow:hidden; display:block; cursor:pointer}
#btn_reg:hover{background:#2796aa;}
#btn_sms{float:left; width:125px; height:32px; font-size:12px; color:#ffffff; text-align:center; background:#ee583d; border:0; overflow:hidden; display:block; cursor:pointer}
-->
</style>
<script type="text/javascript" src="/pc/js/jquery-min.js"></script> 
<script type="text/javascript" src="/pc/layer/layer.js"></script> 
</head>

<body>
<div style="position:relative; width:100%; height:18%; overflow:hidden; display:block">
    <div style="position:relative; width:1200px; margin:2% auto; overflow:hidden; display:block">
        <div style="float:left; width:186px; overflow:hidden; display:block">
			<a href="/"><span style="width:186px; height:35px; background:url(/pc/images/logo.png); display:block; cursor:pointer"></span></a>
        </div>
        <div style=" float:left; width:180px; overflow:hidden; display:block">
            <span style="float:left; width:100%; margin-top:13px; margin-left:10%; padding-left:10%; border-left:1px solid #cccccc; font-family:Microsoft YaHei; font-size:18px; font-weight:bold; color:#30c0db; overflow:hidden; display:block">用 户 注 册</span>
        </div>
    </div>
</div>
<div style="width:100%; overflow:hidden; display:block">
    <div style="width:1200px; margin:0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
        <div style="float:left; width:68.5%; margin:3%; border-right:1px solid #cccccc; overflow:hidden; display:block">
            <p style="float:left; width:100%; overflow:hidden; display:block">
                <div style="position:relative; float:left; width:300px; margin-left:10px; overflow:hidden; display:block">
                    <input id="user_type" name="user_type" type="radio" value="1"/> 档口 <input id="user_type" name="user_type" type="radio" value="2"/> 工厂
                </div>
                <div id="tip_usertype" style="float:left; padding:8px 0; overflow:hidden; display:block"><span style="color:#999999">请选择用户类型</span></div>        
            </p>
            <p style="float:left; width:100%; overflow:hidden; display:block">
                <div style="position:relative; float:left; overflow:hidden; display:block">
                    <div style="position:relative; width:277px; height:20px; margin:0 10px 5px 10px; padding:5px; background:#fafafa; border:1px solid #cccccc; display:block">
                        <span style="float:left; width:30px; height:20px; background:url(/pc/reg/images/pic_mob.jpg) center center no-repeat; display:block"></span>
                        <span style="float:left; width:150px; display:block">
                            <input id="r_mob" name="r_mob" type="text" value="手机号码" maxlength="11" style="width:250px; padding-top:3px; height:13px; color:#cccccc; background:#fafafa; border:0;" />
                        </span>
                    </div>                
                </div>
                <div id="tip_mob" style="float:left; padding:8px 0; overflow:hidden; display:block"><span style="color:#999999">11位数字手机号码</span></div>        
            </p>
            <p style="float:left; width:100%; overflow:hidden; display:block">
                <div style="float:left;width:140px; height:20px; margin:0 10px 5px 10px; padding:5px; background:#fafafa; border:1px solid #cccccc; overflow:hidden; display:block">
                    <span style="float:left; width:30px; height:20px; background:url(/pc/reg/images/pic_password.jpg) center center no-repeat; display:block"></span>
                    <span style="float:left; width:80px; display:block"><input id="r_sms" name="r_sms" type="text" value="短信验证码" maxlength="6" style="width:100px; padding-top:3px; height:13px; color:#cccccc; background:#fafafa; border:0;"></span>
                </div>    
                <input type="button" id="btn_sms" value="获取验证码"/> 
				<div id="tip_sms" style="float:left; margin-left:12px; padding:8px 0; overflow:hidden; display:block"><span style="color:#999999">6位数字短信验证码</span></div>   
            </p>
            <p style="float:left; width:100%; overflow:hidden; display:block">
                <div style="float:left;width:277px; height:20px; margin:0 10px 5px 10px; padding:5px; background:#fafafa; border:1px solid #cccccc; overflow:hidden; display:block">
                    <span style="float:left; width:30px; height:20px; background:url(/pc/reg/images/pic_password.jpg) center center no-repeat; display:block"></span>
                    <span style="float:left; width:150px; display:block">
                    <input type="text" id="pwdPrompt" name="pwdPrompt" value="请输入密码" style="width:250px; padding-top:3px; height:13px; color:#cccccc; background:#fafafa; border:0;"/>
                    <input type="password" id="r_pwd" name="r_pwd" style="width:250px; padding-top:3px; height:13px; color:#cccccc; background:#fafafa; border:0; display:none"/> 
                    </span>
                </div>    
                <div id="tip_pwd" style="float:left; padding:8px 0; overflow:hidden; display:block"><span style="color:#999999">必须是6-16位数字、字母、符号的组合</span></div>    
            </p>
            <p style="float:left; width:100%; overflow:hidden; display:block">
                <div style="float:left;width:277px; height:20px; margin:0 10px 5px 10px; padding:5px; background:#fafafa; border:1px solid #cccccc; overflow:hidden; display:block">
                    <span style="float:left; width:30px; height:20px; background:url(/pc/reg/images/pic_password.jpg) center center no-repeat; display:block"></span>
                    <span style="float:left; width:150px; display:block">
                    <input type="text" id="confirmpwdPrompt" name="confirmpwdPrompt" value="确认密码" style="width:250px; padding-top:3px; height:13px; color:#cccccc; background:#fafafa; border:0;"/>
                    <input type="password" id="r_confirmpwd" name="r_confirmpwd" style="width:250px; padding-top:3px; height:13px; color:#cccccc; background:#fafafa; border:0; display:none"/> 
                    </span>
                </div>    
                <div id="tip_confirmpwd" style="float:left; padding:8px 0; overflow:hidden; display:block"><span style="color:#999999">再输入一次密码</span></div>    
            </p>
            <p style="float:left; width:100%; overflow:hidden; display:block">
                <div style="position:relative; float:left; overflow:hidden; display:block">
                    <div style="position:relative; width:277px; height:20px; margin:0 10px 5px 10px; padding:5px; background:#fafafa; border:1px solid #cccccc; display:block">
                        <span style="float:left; width:30px; height:20px; background:url(/pc/reg/images/pic_person.jpg) center center no-repeat; display:block"></span>
                        <span style="float:left; width:150px; display:block">
                            <input id="r_realname" name="r_realname" type="text" value="用户真实姓名" maxlength="11" style="width:250px; padding-top:3px; height:13px; color:#cccccc; background:#fafafa; border:0;" />
                        </span>
                    </div>                
                </div>
                <div id="tip_realname" style="float:left; padding:8px 0; overflow:hidden; display:block"><span style="color:#999999">必须是用户真实姓名</span></div>        
            </p>
            <p style="float:left; width:100%; overflow:hidden; display:block">
                <div style="position:relative; float:left; margin-left:10px; padding:3px 0; overflow:hidden; display:block"><input type="checkbox" id="r_fuwu" name="r_fuwu" value="1"> 同意 <span style="color:#0099FF; cursor:pointer" onclick="ShowAgreement()">《优百仓档口专用系统用户服务条款》</span></div>      
            </p>
            <p style="float:left; width:100%; overflow:hidden; display:block">
                <div id="btn_reg">确认注册</div>
            </p>        
        </div>
        <div style="position:relative; float:left; width:22%; margin:3% 3% 3% 0; overflow:hidden; display:block">
            <p style="float:left; width:85%; margin-left:15%; overflow:hidden; display:block">已有账户？ <a href="/" class="linkred">马上登陆</a></p>
        </div>
    </div>
</div>
<div style="width:100%; height:10%; overflow:hidden; display:block">
    <div style="width:1200px;  margin:2% auto; text-align:center; overflow:hidden; display:block">版权所有：优百仓(Youbaicang.com)</div>
</div>

<div id="layer_reg_agreement" style="float:left; width:600px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; margin:10px 0; text-align:center; font-size:14px; font-weight:bold; overflow-x:hidden; overflow-y:auto; display:block">《优百仓档口管家用户服务条款》</div>
    <div style="float:left; width:100%; margin-top:10px; text-align:left; line-height:1.8; overflow:hidden; display:block" id="reg_agreement_content"></div>
</div>

<script type="text/javascript">

function p_send_reg_resp(msg)
{
    if (!msg){
        alert("err::"+msg);
        return;
    }
    if (msg.state == "new")
    {
        if (msg.sms_state == "0")
			layer.msg("验证码已发送,请查收短信！", {time: 2000, icon:1});
        else
            alert("发送验证码失败!");
    }
    else
    {
        alert("err:"+ JSON.stringify(msg));
    }
}

function send_reg_code()
{
    mob_num = $("#r_mob").val();
    $.ajax({
        url:"sendcode",
        type:"POST",
        dataType:"json",
        data:{var_type:"reg",var_mobile:mob_num},
        success: function(msg){p_send_reg_resp(msg);},
        fail:function(){alert("ajax fail");}
    });
}

var countdown = 60;
function settime() 
{ 
    val = $("#btn_sms");
    if (countdown == 0) { 
        val.attr("disabled",false);    
        val.attr("value","获取验证码"); 
        countdown = 60; 
    } else { 
        val.attr("disabled", true); 
        val.attr("value","" + countdown + "秒后重新获取"); 
        countdown--; 
        setTimeout(function() { settime(); },1000)

    } 
}

$(function () {    
    $("#r_mob").focus(function(){
        if(this.value=="手机号码"){this.value=""}
        $(this).css("color","#333333");
    });    
    $("#r_mob").blur(function(){
        if(this.value==""){this.value="手机号码"; $(this).css("color","#cccccc")}
        if(/\D/.test(this.value) || this.value.length != 11)
        {
            $("#tip_mob").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入正确格式的手机号码！</span>");
        }
        else
        {
            $.ajax({
                url:"reg/mobcheck",
                async: false,
                type: "POST",
                data: {var_mob:$(this).val()},
                success: function(html){
                    var current_status=parseInt(html);
                    if (current_status==1001)
                    {
                        $("#tip_mob").html("<img src=/pc/reg/images/right.png>");
                        $("#btn_sms").attr("disabled",false);
                    }
                    else if (current_status==1002)
                    {
                        $("#tip_mob").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>此手机号码已注册！请直接 <a href='/'>登录</a></span>");
                        $("#btn_sms").attr("disabled",true);
                    }
                }
            });        
        }
    });

    $("#btn_sms").click(function(){
        if(/\D/.test($("#r_mob").val()) || $("#r_mob").val().length != 11)
        {
            $("#tip_mob").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入正确格式的手机号码！</span>");
			return false;
        }
		
		settime();
		send_reg_code();
	});
	
    $("#r_sms").focus(function(){
        if(this.value=="短信验证码"){this.value=""}
        $(this).css("color","#333333");
    });    
    $("#r_sms").blur(function(){
        if(this.value==""){this.value="短信验证码"; $(this).css("color","#cccccc")}
        if(/\D/.test(this.value) || this.value.length != 6)
        {
            $("#tip_sms").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入正确格式的短信验证码！</span>");
        }
        else
        {
            $.ajax({
                url:"reg/codecheck",
                async: false,
                type: "POST",
                data: {var_code:$(this).val()},
                success: function(html){
                    var current_status=parseInt(html);
                    if (current_status==1001)
                    {
                        $("#tip_sms").html("<img src=/pc/reg/images/right.png>");
                    }
                    else if (current_status==1002)
                    {
                        $("#tip_sms").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>短信验证码不正确！</span>");
                    }
                }
            }); 
        }
    });
	    
    $("input[name=pwdPrompt]").focus(function () { 
        $("input[name=pwdPrompt]").hide(); 
        $("input[name=r_pwd]").show().focus(); 
        $("input[name=r_pwd]").css("color","#333333");
    }); 
    
    $("input[name=r_pwd]").blur(function () { 
        if ($(this).val() == "") { 
            $("input[name=pwdPrompt]").show(); 
            $("input[name=r_pwd]").hide(); 
        }
        if(!$("#r_pwd").val() || !$("#r_pwd").val().match(/^[\w]{6,20}$/))
        {
            $("#tip_pwd").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入正确格式的密码！</span>");
        }
        else
        {
            $("#tip_pwd").html("<img src=/pc/reg/images/right.png>");
        }
    }) 
    
    $("input[name=confirmpwdPrompt]").focus(function () { 
        $("input[name=confirmpwdPrompt]").hide(); 
        $("input[name=r_confirmpwd]").show().focus(); 
        $("input[name=r_confirmpwd]").css("color","#333333");
    }); 
    
    $("input[name=r_confirmpwd]").blur(function () { 
        if ($(this).val() == "") { 
            $("input[name=confirmpwdPrompt]").show(); 
            $("input[name=r_confirmpwd]").hide(); 
        }
        if(!$("#r_confirmpwd").val() || !$("#r_confirmpwd").val().match(/^[\w]{6,20}$/))
        {
            $("#tip_confirmpwd").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入正确格式的密码！</span>");
        }
        else
        {
            if ($("#r_confirmpwd").val()!=$("#r_pwd").val())
            {
                $("#tip_confirmpwd").html("<img src=/pc/reg//images/error.png> <span style='color:#ee583d'>两次输入的密码不一致！</span>");
            }
            else
            {
                $("#tip_confirmpwd").html("<img src=/pc/reg/images/right.png>");
            }
        }
    });
	
    $("#r_realname").focus(function(){
        if(this.value=="用户真实姓名"){this.value=""}
        $(this).css("color","#333333");
    });    
    $("#r_realname").blur(function(){
        if(this.value==""){this.value="用户真实姓名"; $(this).css("color","#cccccc")}
        if(this.value=="" || this.value=="用户真实姓名")
        {
            $("#tip_realname").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入用户真实姓名！</span>");
        }
        else
        {
            $("#tip_realname").html("<img src=/pc/reg/images/right.png>");
        }
    }); 
    
    $("#btn_reg").click(function () { 
        if($('input:radio[name="user_type"]:checked').val()==null)
        {
            $("#tip_usertype").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请选择用户类型！</span>");
            return false;
        }
        else
        {
            $("#tip_usertype").html("");
        }
            
        if(/\D/.test($("#r_mob").val()) || $("#r_mob").val().length != 11)
        {
            $("#tip_mob").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入正确格式的手机号码！</span>");
            return false;
        }
        else
        {
            var current_status;
            $.ajax({
                url:"reg/mobcheck", 
                async: false,
                type: "POST",
                data: {var_mob:$("#r_mob").val()},
                success: function(html){
                    current_status=parseInt(html);
                }
            });    
            
            if (current_status==1001)
            {
                $("#tip_mob").html("<img src=/pc/reg/images/right.png>");
            }
            else if (current_status==1002)
            {
                $("#tip_mob").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>此手机号码已注册！请直接 <a href='/'>登录</a></span>");
                return false;
            }    
        }
		
        if(/\D/.test($("#r_sms").val()) || $("#r_sms").val().length != 6)
        {
            $("#tip_sms").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入正确格式的短信验证码！</span>");
            return false;
        }
        else
        {
            var current_status;
            $.ajax({
                url:"reg/codecheck", 
                async: false,
                type: "POST",
                data: {var_code:$("#r_sms").val()},
                success: function(html){
                    current_status=parseInt(html);
                }
            });    
            
            if (current_status==1001)
            {
                $("#tip_sms").html("<img src=/pc/reg/images/right.png>");
            }
            else if (current_status==1002)
            {
                $("#tip_sms").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>短信验证码不正确！</span>");
                return false;
            }    
        }

        if(!$("#r_pwd").val() || !$("#r_pwd").val().match(/^[\w]{6,20}$/))
        {
            $("#tip_pwd").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入正确格式的密码！</span>");
            return false;
        }
        else
        {
            $("#tip_pwd").html("<img src=/pc/reg/images/right.png>");
        }

        if(!$("#r_confirmpwd").val() || !$("#r_confirmpwd").val().match(/^[\w]{6,20}$/))
        {
            $("#tip_confirmpwd").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入正确格式的密码！</span>");
            return false;
        }
        else
        {
            if ($("#r_confirmpwd").val()!=$("#r_pwd").val())
            {
                $("#tip_confirmpwd").html("<img src=/pc/reg//images/error.png> <span style='color:#ee583d'>两次输入的密码不一致！</span>");
                return false;
            }
            else
            {
                $("#tip_confirmpwd").html("<img src=/pc/reg/images/right.png>");
            }
        }
		
        if(!$("#r_realname").val() || $("#r_realname").val()=="用户真实姓名")
        {
            $("#tip_realname").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>请输入您的用户真实姓名！</span>");
            return false;
        }
        else
        {
            $("#tip_realname").html("<img src=/pc/reg/images/right.png>");
        }
        
        if($('input:checkbox[name="r_fuwu"]:checked').val()==null)
        {
            $("#tip_fuwu").html("<img src=/pc/reg/images/error.png> <span style='color:#ee583d'>只有仔细阅读并同意《优百仓用户服务条款》才能注册！</span>");
            return false;
        }
        else
        {
            $("#tip_fuwu").html("<img src=/pc/reg/images/right.png>");
        }
        
        $.ajax({
            url:"reg/post-reg", 
            async: false,
            type: "POST",
            data:{var_usertype:$('input:radio[name="user_type"]:checked').val(),var_mobile:$("#r_mob").val(),var_password:$("#r_pwd").val(),var_realname:$("#r_realname").val() },
			dataType:"json",
            success: function(html){
				if (html["state"]=="ok")
				{
					layer.msg("注册成功！", {time: 2000, icon:1});
					setTimeout(function(){
						window.location.href="/myaccount";
					},2000);
				}
				else
				{
					layer.msg(html["desc"], {time: 2000, icon:2});
				}
            }
        });        
    });
});

function ShowAgreement(){
    $.ajax({
        url:"reg/agreement", 
        async: false,
        type: "GET",
        data:"",
        success: function(html){
            $("#reg_agreement_content").html(html.replace(/[\r\n]/g,"<br>"));
        }
    });    
    
    index_layerstatus=layer.open({
		type: 1,
		area: ['670px', '550px'],
		title: false,
		content:$('#layer_reg_agreement')
    });
}
</script>
</body>
</html>
