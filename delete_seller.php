<?php
include_once("check_dangkou_user.php");

mysql_query("delete from ydf_seller_price where seller_price_seller_bianhao='".$_REQUEST["var_seller_bianhao"]."'", $dbconn);
mysql_query("delete from ydf_seller where seller_bianhao='".$_REQUEST["var_seller_bianhao"]."'", $dbconn);
?>