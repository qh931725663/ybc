<?php
include_once("check_dangkou_user.php");

mysql_query("update ydf_products_barcode set del_state='1' where factory_bianhao='".$_REQUEST["var_factory_bianhao"]."'", $dbconn);
mysql_query("update ydf_factory set del_state='1' where factory_bianhao='".$_REQUEST["var_factory_bianhao"]."'", $dbconn);
?>