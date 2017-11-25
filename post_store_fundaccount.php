<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_bill.php");

function update_dangkou_bank_info($dangkou_id,$bank_id,$bank_type)
{
    $p=cselect("*","ydf_bank",array("bank_type=? and bank_id=?",$bank_type,$bank_id));
    if ($p[1]!=1)
        throw new PDOException("bank_id_with_this_type_not_exist");
        
    $where=array("dangkou_bank_dangkou_bianhao=? and dangkou_bank_type=?",$dangkou_id,$bank_type);
    $p=cselect("*","ydf_dangkou_bank",$where);
    if ($p[1]>1)
        throw new PDOException("bank_to_more");
    if ($p[1]==1){
        update("ydf_dangkou_bank",array("dangkou_bank_bank_bianhao"=>$bank_id),$where);
    }
    if ($p[1]==0){
        $sets=array(
            "dangkou_bank_bank_bianhao"=>$bank_id,
            "dangkou_bank_type"=>$bank_type,
            "dangkou_bank_dangkou_bianhao"=>$dangkou_id
        );
        insert("ydf_dangkou_bank",$sets);
    }
}

$resp=array();
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
try{
$pdo->beginTransaction();

$resp=update_init_fund_bill("jrylcsh",$_REQUEST["var_dangkou_bianhao"],$_REQUEST["store_cash_init"]);
if (!empty($_REQUEST["store_bank_bianhao"]))
    update_dangkou_bank_info($_REQUEST["var_dangkou_bianhao"],$_REQUEST["store_bank_bianhao"],2);
if (!empty($_REQUEST["store_alipay_bianhao"]))
    update_dangkou_bank_info($_REQUEST["var_dangkou_bianhao"],$_REQUEST["store_alipay_bianhao"],3);
echo json_encode(array("state"=>"ok","desc"=>$resp));

$pdo->commit(); 
}catch(PDOException $e){  
    $pdo->rollback();  
    $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
    die(json_encode(array("state"=>$e->getCode(),"desc"=>$e->getMessage(),"trace"=>$e->getTraceAsString() )));
}    


?>
