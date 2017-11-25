<?php
$p=cselect("dangkou_hot_products","ydf_dangkou",array("dangkou_bianhao=?",$_REQUEST["dangkou_bianhao"]));
$row=$p[0]->fetch();
echo json_encode($row["dangkou_hot_products"]);
?>