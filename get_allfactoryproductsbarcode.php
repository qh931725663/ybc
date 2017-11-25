<?php

include_once("check_dangkou_user.php");
include_once "{$root_path}/model/model_barcode.php";

$factory=empty($_REQUEST["var_factory_bianhao"])?0:$_REQUEST["var_factory_bianhao"];
echo json_encode(get_all_factoryproductsbarcode_info($factory));
?>
