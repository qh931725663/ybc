<?php

include_once("check_dangkou_user.php");

$nowtime=strtotime(date("Y-m-d H:i:s"));

$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
try
{
    $pdo->beginTransaction();

    $sets=array(
        "dangkou_boss_m_bianhao"=>$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"], 
        "dangkou_type"=>"1", 
        "dangkou_market"=>$_REQUEST["store_add_store_market"], 
        "dangkou_layer"=>$_REQUEST["store_add_store_layer"], 
        "dangkou_place"=>$_REQUEST["store_add_store_place"], 
        "dangkou_name"=>$_REQUEST["store_add_store_market"].$_REQUEST["store_add_store_place"], 
        "dangkou_addtime"=>$nowtime
    );
    insert("ydf_dangkou",$sets);
    $laststoreid=$pdo->lastInsertId();
    
    if ($_REQUEST["store_add_store_have_warehouse"]=="1")
    {
        $sets=array(
            "dangkou_warehouse_dangkou_bianhao"=>$laststoreid, 
            "dangkou_warehouse_warehouse_bianhao"=>$_REQUEST["store_add_warehouse_bianhao"]
        );
        insert("ydf_dangkou_warehouse",$sets);
    }
    
    $service_money=6000;
    
    $sets=array(
        "service_money_type"=>"1",
        "service_money_dangkou_bianhao"=>$laststoreid, 
        "service_money_buy_years"=>"1", 
        "service_money"=>$service_money, 
        "service_money_addtime"=>$nowtime
    );
    insert("ydf_dangkou_service_money",$sets);

    $sets=array(
        "bank_boss_id"=>$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"],
        "bank_type"=>1,
        "bank_add_time"=>$nowtime
    );
    insert("ydf_bank",$sets);
    $lastbankid=$pdo->lastInsertId();
    $sets=array(
        "dangkou_bank_dangkou_bianhao"=>$laststoreid,
        "dangkou_bank_bank_bianhao"=>$lastbankid,
        "dangkou_bank_type"=>1
    );
    insert("ydf_dangkou_bank",$sets);

    $sets=array(
        "bank_boss_id"=>$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"],
        "bank_type"=>5,
        "bank_add_time"=>$nowtime
    );
    insert("ydf_bank",$sets);
    $lastbankid=$pdo->lastInsertId();
    $sets=array(
            "dangkou_bank_dangkou_bianhao"=>$laststoreid,
            "dangkou_bank_bank_bianhao"=>$lastbankid,
            "dangkou_bank_type"=>5
    );
    insert("ydf_dangkou_bank",$sets);
    
    $sets=array(
        "bank_boss_id"=>$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"],
        "bank_type"=>3,
        "bank_isstaff"=>"0",
        "bank_user_account"=>$_REQUEST["store_add_alipay_account"],
        "bank_add_time"=>$nowtime
    );
    insert("ydf_bank",$sets);
    $lastbankid=$pdo->lastInsertId();
    $sets=array(
            "dangkou_bank_dangkou_bianhao"=>$laststoreid,
            "dangkou_bank_bank_bianhao"=>$lastbankid,
            "dangkou_bank_type"=>3
    );
    insert("ydf_dangkou_bank",$sets);

    $pdo->commit();
    echo json_encode(array("state"=>"ok","desc"=>""));
}
catch(PDOException $e)
{  
    $pdo->rollback();
    $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
    die(json_encode(array("state"=>$e->getCode(),"desc"=>$e->getMessage(),"trace"=>$e->getTraceAsString() )));
}
?>
