<?php

include_once("check_dangkou_user.php");

$arr_product_system_barcode="";
$rsdetailbarcode = mysql_query("select * from ydf_order_detail where detail_order_bianhao='".$_REQUEST["var_order_temp_bianhao"]."' order by detail_p_barcode_bianhao asc", $dbconn); 
while ($rowdetailbarcode=mysql_fetch_array($rsdetailbarcode))
{
    $arr_product_system_barcode[$rowdetailbarcode["detail_p_barcode_bianhao"]]=array(                                
                                                                            "detail_order_num"=>$rowdetailbarcode["detail_order_num"]
                                                                        );
}

echo json_encode($arr_product_system_barcode);
?>