<?php

include_once("check_dangkou_user.php");

$sqlsellercheck="select * from ydf_order where order_bianhao='".$_REQUEST["var_continue_order_bianhao"]."'";
$rssellercheck=mysql_query($sqlsellercheck, $dbconn);
$rowsellercheck=mysql_fetch_array($rssellercheck);

echo json_encode(array("order_seller_bianhao"=>$rowsellercheck["order_seller_bianhao"],"order_seller_name"=>$rowsellercheck["order_seller_name"],"order_seller_cycle"=>$rowsellercheck["order_seller_cycle"],"order_master_bianhao"=>$rowsellercheck["order_master_bianhao"],"order_master_name"=>$rowsellercheck["order_master_name"],"order_to_dangkou_bianhao"=>$rowsellercheck["order_slave_bianhao"],"order_to_dangkou_name"=>$rowsellercheck["order_slave_name"]));
?>