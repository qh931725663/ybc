<?php
$t=get_ymd();
$utime=$t["u"];
session_start();
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
try
{
	$pdo->beginTransaction();
	
	$sets=array(
		"m_mobile"=>$_REQUEST["var_mobile"], 
		"m_password"=>md5($_REQUEST["var_password"]), 
		"m_type"=>$_REQUEST["var_usertype"], 
		"m_realname"=>$_REQUEST["var_realname"],
		"m_regtime"=>$utime
	);
	insert("ydf_member",$sets);
	$lastid=$pdo->lastInsertId();
	
	if ($_REQUEST["var_usertype"]=="1")
	{	
		$sets=array(
			"user_account"=>$_REQUEST["var_mobile"], 
			"user_type"=>"1", 
			"user_dangkou_bianhao"=>"0",
			"user_dangkou_name"=>"", 
			"user_boss_m_bianhao"=>$lastid,
			"user_self_m_bianhao"=>$lastid,
			"user_mobile"=>$_REQUEST["var_mobile"],
			"user_name"=>$_REQUEST["var_realname"], 
			"user_addtime"=>$utime
		);
		insert("ydf_user",$sets);
			
		$sets=array(
			"bank_boss_id"=>$lastid, 
			"bank_type"=>"4", 
			"bank_isstaff"=>"0", 
			"bank_user_name"=>"", 
			"bank_user_account"=>"", 
			"bank_name"=>"", 
			"bank_desc"=>"", 
			"bank_add_time"=>$utime
		);
		insert("ydf_bank",$sets);
	}
	
	$_SESSION["ERP_ACCOUNT_LOGIN_MOBILE"]=$_REQUEST["var_mobile"];
	$_SESSION["ERP_ACCOUNT_LOGIN_REALNAME"]=$_REQUEST["var_realname"];
	$_SESSION["ERP_ACCOUNT_LOGIN_BIANHAO"]=$lastid;
	$_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=$_REQUEST["var_usertype"];
	if ($_REQUEST["var_usertype"]=="1")
	{
		$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]=$lastid;
		$_SESSION["ERP_ACCOUNT_USER_SELF_M_BIANHAO"]=$lastid;
		$_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]="10";
        $_SESSION["ERP_ACCOUNT_USER_DANGKOU_COUNT"]="0";
        $_SESSION["ERP_ACCOUNT_USER_WAREHOUSE_COUNT"]="0";
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
