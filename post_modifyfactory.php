<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_bill.php");

$sqlfactory="select * from ydf_factory where del_state='0' and (factory_name='".$_REQUEST["var_factory_name"]."' or factory_mobile='".$_REQUEST["var_factory_mobile"]."') and factory_boss_m_bianhao = '".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."' and factory_bianhao <> '".$_REQUEST["var_factory_bianhao"]."'";
$rsfactory=mysql_query($sqlfactory , $dbconn);    
if ($rowfactory=mysql_fetch_array($rsfactory))
{
    if ($rowfactory["factory_name"]==$_REQUEST["var_factory_name"])
    {
        echo "1001";
    }
    elseif ($rowfactory["factory_mobile"]==$_REQUEST["var_factory_mobile"])
    {
        echo "1002";
    }
}
else
{
    mysql_query("update ydf_factory set factory_name='".$_REQUEST["var_factory_name"]."', factory_mobile='".$_REQUEST["var_factory_mobile"]."', factory_manage='".$_REQUEST["var_factory_manage"]."' where factory_bianhao='".$_REQUEST["var_factory_bianhao"]."'", $dbconn);
    
$resp=array();
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
try{
$pdo->beginTransaction();
    $resp=update_factory_fund_init_bill($_REQUEST["var_factory_bianhao"],$_REQUEST["var_factory_fund_active"],$_REQUEST["var_factory_fund_freeze"],$_REQUEST["var_factory_fund_payable"]);
$pdo->commit(); 
}catch(PDOException $e){  
    $pdo->rollback();  
    $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
    die(json_encode(array("state"=>$e->getCode(),"desc"=>$e->getMessage(),"trace"=>$e->getTraceAsString() )));
}    
echo json_encode(array("state"=>"ok","desc"=>$resp));

}
?>
