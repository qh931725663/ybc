<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_order.php");

$arr_data=get_replenish_plan($_REQUEST["var_master_bianhao"],"gcfh");

$arr_product_system_barcode="";
foreach ($arr_data as $key => $value) 
{
    if($key==$_REQUEST["var_factory_bianhao"])
    {
        foreach ($value["barcodes"] as $barcode)
        {
            $arr_product_system_barcode[$barcode["detail_p_barcode_bianhao"]]=array(                                
                                                        "detail_order_num"=>$barcode["detail_order_num"]
                                                    );
        }
        
        echo json_encode($arr_product_system_barcode);
    }
}
?>