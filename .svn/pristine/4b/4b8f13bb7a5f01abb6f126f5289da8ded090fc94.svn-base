<?php

include_once("check_dangkou_user.php");

$sqldangkou="select * from ydf_dangkou where del_state='0' and dangkou_name='".$_REQUEST["warehouse_modify_warehouse_name_".$_REQUEST["warehouse_modify_warehouse_bianhao"]]."' and dangkou_boss_m_bianhao = '".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."' and dangkou_bianhao<>'".$_REQUEST["warehouse_modify_warehouse_bianhao"]."'";
$rsdangkou=mysql_query($sqldangkou , $dbconn);    
if ($rowdangkou=mysql_fetch_array($rsdangkou))
{
    if ($rowdangkou["dangkou_type"]=="1")
    {
        echo "1001";
    }
    elseif ($rowdangkou["dangkou_type"]=="2")
    {
        echo "1002";
    }
}
else
{
    $nowtime=strtotime(date("Y-m-d H:i:s"));
    
    mysql_query("update ydf_dangkou set dangkou_name='".$_REQUEST["warehouse_modify_warehouse_name_".$_REQUEST["warehouse_modify_warehouse_bianhao"]]."', dangkou_manager='".$_REQUEST["warehouse_modify_warehouse_manager_".$_REQUEST["warehouse_modify_warehouse_bianhao"]]."', dangkou_mobile='".$_REQUEST["warehouse_modify_warehouse_mobile_".$_REQUEST["warehouse_modify_warehouse_bianhao"]]."', dangkou_address='".$_REQUEST["warehouse_modify_warehouse_address_".$_REQUEST["warehouse_modify_warehouse_bianhao"]]."' where dangkou_bianhao='".$_REQUEST["warehouse_modify_warehouse_bianhao"]."'", $dbconn);
}
?>