<?php

include_once("check_factory_user.php");

$tp=cselect("*","ydf_products_barcode",array("p_barcode_p_bianhao=? and p_barcode_factory_bianhao=?",$_REQUEST["var_p_bianhao"],$_REQUEST["var_factory_bianhao"]));
$rowfactoryguige=$tp[0]->fetch();
?>
    <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
        <p style="float:left; width:100%; padding:5px 0; display:block">
            <span style="float:left; width:100%; font-size:12px; margin:5px 0">商品条码：</span>
            <span style="float:left; width:100%">
                <span style="float:left; width:100%; border-bottom:1px dashed #cccccc; padding:5px 0; overflow:hidden; display:block">
                    <span style="float:left; width:50%; color:#999999">颜色，尺码</span>
                    <span style="float:left; width:50%; color:#999999">系统编码</span>
                </span>
                <?php
                $tp=cselect("*","ydf_products_barcode",array("p_barcode_p_bianhao=? and p_barcode_factory_bianhao=?",$_REQUEST["var_p_bianhao"],$_REQUEST["var_factory_bianhao"] ),"","p_barcode_bianhao asc");
                while ($rowguige=$tp[0]->fetch())
                {
                    $p_product_type=cselect("*","ydf_products_type",array("p_type_bianhao=?",$rowguige["p_barcode_p_type_bianhao"] ));
                    $rowproducttype=$p_product_type[0]->fetch();
                ?>
                <span style="float:left; width:100%; border-bottom:1px dashed #cccccc; padding:5px 0; overflow:hidden; display:block">
                    <span style="float:left; width:50%"><?php echo $rowproducttype["p_type_color"].(!empty($rowproducttype["p_type_size"])?"，".$rowproducttype["p_type_size"]:"")?></span>
                    <span style="float:left; width:50%; height:25px"><?php echo $rowguige["p_barcode_checkcode"].$rowguige["p_barcode_bianhao"]?></span>
                </span>
                <?php
                }
                ?>
            </span>
        </p>
    </div>
