<?php
$current_mob=!empty($_REQUEST["var_mob"])?$_REQUEST["var_mob"]:"";

$p=cselect("m_bianhao","ydf_member",array("m_mobile=? or m_bd_mobile=?",$current_mob,$current_mob));
if (!$row=$p[0]->fetch())
{
	echo "1001";//此手机号码可以注册！
}
else
{
    echo "1002";//此手机号码已注册！请直接登陆或者找回密码。
}
?>