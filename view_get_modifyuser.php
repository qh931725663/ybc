<?php

include_once("check_dangkou_user.php");

$sqluser="select * from ydf_user where user_bianhao = '".$_REQUEST["var_user_bianhao"]."'";
$rsuser=mysql_query($sqluser , $dbconn);    
$rowuser=mysql_fetch_array($rsuser);
?>
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"> 子账号：</span>
                                <span style="float:left; margin:5px 0"><?php echo $rowuser["user_account"] ?></span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"> 登录密码：</span>
                                <span style="float:left;">
                                <input class="iinput" name="user_pwd_<?php echo $rowuser["user_bianhao"] ?>" id="user_pwd_<?php echo $rowuser["user_bianhao"] ?>" type="password" maxlength="50" style="width:150px; padding:5px"/>
                                </span>
                                <span style="float:left; margin-left:10px; color:#999999; margin:5px 0"> （为空时不修改） </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 姓名：</span>
                                <span style="float:left;">
                                <input class="iinput" name="user_name_<?php echo $rowuser["user_bianhao"] ?>" id="user_name_<?php echo $rowuser["user_bianhao"] ?>" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowuser["user_name"] ?>"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 手机号码：</span>
                                <span style="float:left;">
                                <input class="iinput" name="user_mobile_<?php echo $rowuser["user_bianhao"] ?>" id="user_mobile_<?php echo $rowuser["user_bianhao"] ?>" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowuser["user_mobile"] ?>"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 用户类型：</span>
                                <span style="float:left;">
                                    <select id="user_type_<?php echo $rowuser["user_bianhao"] ?>" name="user_type_<?php echo $rowuser["user_bianhao"] ?>" style="padding:5px" onchange="SetModifyChangeUserType($(this))">
                                      <option value="">请选择</option>
                                      <option value="1" <?php echo $rowuser["user_type"]=="1"?"selected":""; ?>>超级用户</option>
                                      <option value="2" <?php echo $rowuser["user_type"]=="2"?"selected":""; ?>>档口用户</option>
                                      <option value="3" <?php echo $rowuser["user_type"]=="3"?"selected":""; ?>>仓库用户</option>
                                    </select>
                                </span>
                            </p>
                            <p id="layer_dangkou_select" style="float:left; width:100%; padding:5px 0; display:<?php echo $rowuser["user_type"]=="2"?"block":"none"; ?>">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 管理档口：</span>
                                <span style="float:left;">
                                    <select id="user_dangkou_<?php echo $rowuser["user_bianhao"] ?>" name="user_dangkou_<?php echo $rowuser["user_bianhao"] ?>" style="padding:5px">
                                      <option value="">请选择</option>
                                    <?php
                                    $rsdangkou=mysql_query("select * from ydf_dangkou where dangkou_type='1' and dangkou_boss_m_bianhao = '".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."'", $dbconn);
                                    while($rowdangkou=mysql_fetch_array($rsdangkou))
                                    {
                                    ?>
                                      <option value="<?php echo $rowdangkou["dangkou_bianhao"] ?>" <?php echo $rowuser["user_dangkou_bianhao"]==$rowdangkou["dangkou_bianhao"]?"selected":""; ?>><?php echo $rowdangkou["dangkou_name"] ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </span>
                            </p>
                            <p id="layer_store_select" style="float:left; width:100%; padding:5px 0; display:<?php echo $rowuser["user_type"]=="3"?"block":"none"; ?>">
                                <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 管理仓库：</span>
                                <span style="float:left;">
                                    <select id="user_store_<?php echo $rowuser["user_bianhao"] ?>" name="user_store_<?php echo $rowuser["user_bianhao"] ?>" style="padding:5px">
                                      <option value="">请选择</option>
                                    <?php
                                    $rsstore=mysql_query("select * from ydf_dangkou where dangkou_type='2' and dangkou_boss_m_bianhao = '".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."'", $dbconn);
                                    while($rowstore=mysql_fetch_array($rsstore))
                                    {
                                    ?>
                                      <option value="<?php echo $rowstore["dangkou_bianhao"] ?>" <?php echo $rowuser["user_dangkou_bianhao"]==$rowstore["dangkou_bianhao"]?"selected":""; ?>><?php echo $rowstore["dangkou_name"] ?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </span>
                            </p>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span id="tip_modify_user" style="float:left; margin-left:80px"></span>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span id="modify_user_affirm_btn" onclick="PostModifyUser(<?php echo $rowuser["user_bianhao"] ?>)" style="float:left; margin-left:80px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认修改</span>
                        </div>
<script text/javascript>
    $('#layer_modifyuser').on('keydown',function(e){
                            if(e.keyCode == 13){
                                //模拟点击登陆按钮，触发上面的 Click 事件
                                $('#layer_modifyuser input,select').blur();
                                $("#modify_user_affirm_btn").click(
                                );
                            }
                        });
</script>