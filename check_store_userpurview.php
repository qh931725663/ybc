<?php

include_once("check_dangkou_user.php");

if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4" and (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]<>"2")))
{
    $p=cselect("*","ydf_dangkou",array("dangkou_type='1' and dangkou_endtime>? and dangkou_boss_m_bianhao=?",strtotime(date("Y-m-d H:i:s")),$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]) );
    $countdangkou=$p[1];    
    $rowdangkou=$p[0]->fetch();
    if ($countdangkou==1)
    {
        $havewarehouse_type="no";

        $p_dangkou_warehouse=cselect("*","ydf_dangkou_warehouse",array("dangkou_warehouse_dangkou_bianhao=?",$rowdangkou["dangkou_bianhao"]));
        if ($row_dangkou_warehouse=$p_dangkou_warehouse[0]->fetch())
        {
            $havewarehouse_type="yes";
        }
    
        echo json_encode(array("state"=>"1001","current_master_bianhao"=>$rowdangkou["dangkou_bianhao"],"current_master_name"=>$rowdangkou["dangkou_name"],"current_havewarehouse_type"=>$havewarehouse_type));
    }
    else
    {
        echo json_encode(array("state"=>"1002"));
    }
}
else
{
        $havewarehouse_type="no";

        $p_dangkou_warehouse=cselect("*","ydf_dangkou_warehouse",array("dangkou_warehouse_dangkou_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]));
        if ($row_dangkou_warehouse=$p_dangkou_warehouse[0]->fetch())
        {
            $havewarehouse_type="yes";
        }
            
        echo json_encode(array("state"=>"1003","current_master_bianhao"=>$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"],"current_master_name"=>$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"],"current_havewarehouse_type"=>$havewarehouse_type));    
}
?>