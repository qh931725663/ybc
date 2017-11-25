<?php
include_once("check_dangkou_user.php");

if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4" and (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1")))
{
    $p=cselect("*","ydf_dangkou",array("dangkou_bianhao='2' and dangkou_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]));
    $countdangkou=$p[1];    
    $rowdangkou=$p[0]->fetch();
        
    if ($countdangkou==1)
    {
        echo json_encode(array("state"=>"1001","current_master_bianhao"=>$rowdangkou["dangkou_bianhao"],"current_master_name"=>$rowdangkou["dangkou_name"]));
    }
    else
    {
        echo json_encode(array("state"=>"1002"));
    }
}
else
{
    if ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="2")
    {    
        echo json_encode(array("state"=>"1003","current_master_bianhao"=>$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"],"current_master_name"=>$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"]));    
    }
}
?>