<?php
include_once("check_dangkou_user.php");

if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4" and (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1")))
{
    $rsdangkou=mysql_query("SELECT * FROM ydf_dangkou WHERE dangkou_boss_m_bianhao='".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."'" , $dbconn);
    $countdangkou=mysql_num_rows($rsdangkou);    
    $rowdangkou=mysql_fetch_array($rsdangkou);
    if ($countdangkou==1)
    {
        $havewarehouse_type="no";
    
        $rsdangkou=mysql_query("SELECT * FROM ydf_dangkou_warehouse WHERE dangkou_warehouse_dangkou_bianhao='".$rowdangkou["dangkou_bianhao"]."'" , $dbconn);
        if ($rowdangkou=mysql_fetch_array($rsdangkou))
        {
            $havewarehouse_type="yes";
        }
    
        echo json_encode(array("error"=>"1001","current_master_bianhao"=>$rowdangkou["dangkou_bianhao"],"current_master_name"=>$rowdangkou["dangkou_name"],"current_havewarehouse_type"=>$havewarehouse_type));
    }
    else
    {
        echo json_encode(array("error"=>"1002"));
    }
}
else
{
    if ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1")
    {
        $havewarehouse_type="no";
    
        $rsdangkou=mysql_query("SELECT * FROM ydf_dangkou_warehouse WHERE dangkou_warehouse_dangkou_bianhao='".$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]."'" , $dbconn);
        if ($rowdangkou=mysql_fetch_array($rsdangkou))
        {
            $havewarehouse_type="yes";
        }
            
        echo json_encode(array("error"=>"1003","current_master_bianhao"=>$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"],"current_master_name"=>$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"],"current_havewarehouse_type"=>$havewarehouse_type));    
    }
    elseif ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="2")
    {    
        echo json_encode(array("error"=>"1004","current_master_bianhao"=>$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"],"current_master_name"=>$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"]));    
    }
}
?>