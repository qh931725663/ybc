<?php

include_once("check_dangkou_user.php");

$order_diaobo_to_store_bianhao="";
$order_diaobo_to_store_name="";

$sqlstore="select * from ydf_dangkou where del_state='0' and dangkou_boss_m_bianhao='".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."' and dangkou_bianhao = '".$_REQUEST["var_diaobo_to_store"]."'";
$rsstore=mysql_query($sqlstore, $dbconn);
$rowstore=mysql_fetch_array($rsstore);

$order_diaobo_to_store_bianhao=$rowstore["dangkou_bianhao"];
$order_diaobo_to_store_name=$rowstore["dangkou_name"];

echo json_encode(array("order_diaobo_to_store_bianhao"=>$order_diaobo_to_store_bianhao,"order_diaobo_to_store_name"=>$order_diaobo_to_store_name));
?>