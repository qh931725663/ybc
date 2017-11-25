<?php

include_once("check_dangkou_user.php");
include_once "{$root_path}/model/model_barcode.php";

$seller=empty($_REQUEST["var_seller_bianhao"])?0:$_REQUEST["var_seller_bianhao"];
$dangkou_id=empty($_REQUEST["var_dangkou_bianhao"])?0:$_REQUEST["var_dangkou_bianhao"];
echo json_encode(get_all_barcodes_info($seller,$dangkou_id));
?>
