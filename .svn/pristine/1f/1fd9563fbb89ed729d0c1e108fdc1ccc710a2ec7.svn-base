<?php
$t=get_ymd();
$utime=$t["u"];

$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
try
{
	$pdo->beginTransaction();
	
	if (!empty($_REQUEST['bd_modify_sms']) &&  $bd_modify_sms["r_sms"] != $_SESSION["ERP_SMS_MOBILEBD_CODE"])
		throw new PDOException("短信验证码输入不正确！");
	
    if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4")
    {
        update("ydf_member",array("m_bd_mobile"=>$_REQUEST["var_mobile"]),array("m_bianhao=?",$_SESSION["ERP_ACCOUNT_LOGIN_BIANHAO"]) );
    }
    else
    {
        update("ydf_member",array("m_mobile"=>$_REQUEST["var_mobile"]),array("m_bianhao=?",$_SESSION["ERP_ACCOUNT_LOGIN_BIANHAO"]) );
    }
	
	$pdo->commit();
	echo json_encode(array("state"=>"ok"));
}
catch(PDOException $e)
{  
    $pdo->rollback();
    $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
    die(json_encode(array("state"=>$e->getCode(),"desc"=>$e->getMessage(),"trace"=>$e->getTraceAsString() )));
}
?>
