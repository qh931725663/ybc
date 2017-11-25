<?php

include_once("check_dangkou_user.php");

$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
try
{
    $pdo->beginTransaction();

    $lastid=0;
    $p=cselect("*","ydf_dangkou",array("dangkou_name=? and dangkou_boss_m_bianhao=?",$_REQUEST["warehouse_add_warehouse_name"],$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]));
    if ($rowdangkou=$p[0]->fetch())
    {
        if ($rowdangkou["dangkou_type"]=="1")
        {
            throw new PDOException("1001");
        }
        elseif ($rowdangkou["dangkou_type"]=="2")
        {
            throw new PDOException("1002");
        }
    }
    else
    {
        $nowtime=strtotime(date("Y-m-d H:i:s"));
        $sets=array(
            "dangkou_boss_m_bianhao"=>$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"], 
            "dangkou_type"=>2, 
            "dangkou_name"=>$_REQUEST["warehouse_add_warehouse_name"], 
            "dangkou_manager"=>$_REQUEST["warehouse_add_warehouse_manager"], 
            "dangkou_mobile"=>$_REQUEST["warehouse_add_warehouse_mobile"], 
            "dangkou_address"=>$_REQUEST["warehouse_add_warehouse_address"], 
            "dangkou_addtime"=>$nowtime
        );
        insert("ydf_dangkou",$sets);
        $lastid=$pdo->lastInsertId();
    }

    $pdo->commit();
    echo json_encode(array("state"=>"ok","desc"=>array("sid"=>$lastid)));
}
catch(PDOException $e)
{  
    $pdo->rollback();
    $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
    die(json_encode(array("state"=>$e->getCode(),"desc"=>$e->getMessage(),"trace"=>$e->getTraceAsString() )));
}
?>
