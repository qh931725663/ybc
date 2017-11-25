<?php

include_once("check_dangkou_user.php");

$sqlusercheck="select * from ydf_user where user_name='".$_REQUEST["var_user_name"]."' and user_boss_m_bianhao = '".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."' and user_bianhao <> '".$_REQUEST["var_user_bianhao"]."'";
$rsusercheck=mysql_query($sqlusercheck , $dbconn);    
if ($rowusercheck=mysql_fetch_array($rsusercheck))
{
    echo "1001";
}
else
{
    $user_dangkou_bianhao="0";
    if ($_REQUEST["var_user_type"]=="2")
    {
        $user_dangkou_bianhao=$_REQUEST["var_user_dangkou"];
    }
    elseif ($_REQUEST["var_user_type"]=="3")
    {
        $user_dangkou_bianhao=$_REQUEST["var_user_store"];
    }
    
    $user_dangkou_name="";
    $rsdangkou=mysql_query("select * from ydf_dangkou where dangkou_bianhao='$user_dangkou_bianhao'", $dbconn);
    if ($rowdangkou=mysql_fetch_array($rsdangkou))
    {
        $user_dangkou_name=$rowdangkou["dangkou_name"];    
    }
    
    mysql_query("update ydf_user set user_type='".$_REQUEST["var_user_type"]."', user_dangkou_bianhao='$user_dangkou_bianhao', user_dangkou_name='$user_dangkou_name', user_name='".$_REQUEST["var_user_name"]."', user_mobile='".$_REQUEST["var_user_mobile"]."' where user_bianhao='".$_REQUEST["var_user_bianhao"]."'", $dbconn);
    
    if (!empty($_REQUEST["var_user_pwd"]))
    {
        mysql_query("update ydf_member set m_password='".md5($_REQUEST["var_user_pwd"])."' where m_bianhao = (select user_self_m_bianhao from ydf_user where user_bianhao='".$_REQUEST["var_user_bianhao"]."')", $dbconn);
    }
}
?>