<?php
$tp=cselect("*","ydf_products_barcode",array("p_barcode_p_bianhao=? and p_barcode_factory_bianhao=?",$_REQUEST["var_p_bianhao"],$_REQUEST["var_factory_bianhao"]));
$rowfactoryguige=$tp[0]->fetch();
?>
<form method="post" id="modify_productfactory_form">
    <div class="mopf_box">
        <p>
            <span class="sp_a"><span>*</span> 供货价：</span>
            <span class="lf">
            <input id="productmodifyfactory_valueprice" name="productmodifyfactory_valueprice" type="text" maxlength="50" value="<?php echo $rowfactoryguige["p_barcode_valueprice"] ?>"/>
            </span>
        </p>
        <p>
            <span class="sp_a"><span>*</span> 合作方式：</span>
            <span class="lf">
                <select id="productmodifyfactory_mode" name="productmodifyfactory_mode">
                  <option value="" selected>请选择</option>
                  <option value="1" <?php if ($rowfactoryguige["p_barcode_factory_mode"]=="1") { echo "selected"; }?>>代销</option>
                  <option value="2" <?php if ($rowfactoryguige["p_barcode_factory_mode"]=="2") { echo "selected"; }?>>经销</option>
                </select>
            </span>
        </p>
        <p>
            <span class="sp_a">工厂货号：</span>
            <span class="lf">
            <input name="productmodifyfactory_huohao" id="productmodifyfactory_huohao" type="text" maxlength="50" value="<?php echo $rowfactoryguige["p_barcode_factory_huohao"] ?>"/>
            </span>
        </p>
        <p>
            <span class="sp_a">商品条码：</span>
            <span class="sp_b">
                <span>
                    <span class="sp_1">颜色，尺码</span>
                    <span class="sp_1">系统编码</span>
                    <span class="sp_1">自定义编码</span>
                </span>
                <?php
                $tp=cselect("*","ydf_products_barcode",array("p_barcode_p_bianhao=? and p_barcode_factory_bianhao=?",$_REQUEST["var_p_bianhao"],$_REQUEST["var_factory_bianhao"] ),"","p_barcode_bianhao asc");
                while ($rowguige=$tp[0]->fetch())
                {
                    $p_product_type=cselect("*","ydf_products_type",array("p_type_bianhao=?",$rowguige["p_barcode_p_type_bianhao"] ));
                    $rowproducttype=$p_product_type[0]->fetch();
                ?>
                <span>
                    <span><?php echo $rowproducttype["p_type_color"].(!empty($rowproducttype["p_type_size"])?"，".$rowproducttype["p_type_size"]:"")?></span>
                    <span class="sp_2"><?php echo $rowguige["p_barcode_bianhao"]?></span>
                    <span><input name="customize_bianhao_<?php echo $rowguige["p_barcode_p_type_bianhao"]?>" type="text" maxlength="50" value="<?php echo $rowguige["p_barcode_customize_bianhao"] ?>"/></span>
                </span>
                <?php
                }
                ?>
            </span>
        </p>
    </div>
    <div class="mopf_btn">
        <input type="hidden" name="p_bianhao" value="<?php echo $_REQUEST["var_p_bianhao"] ?>">
        <input type="hidden" name="factory_bianhao" value="<?php echo $_REQUEST["var_factory_bianhao"] ?>">
        <span id="mopf_affirm_btn" onclick="PostModifyPorductFactory(<?php echo $_REQUEST["var_p_bianhao"] ?>,<?php echo $_REQUEST["var_factory_bianhao"] ?>)">确认修改</span>
    </div>
</form>
<script type="text/javascript">
    $('#layer_modify_productfactory').on('keydown',function(e){
        if(e.keyCode == 13){
            //模拟点击登陆按钮，触发上面的 Click 事件
            $("#layer_modify_productfactory input,select").blur();
            $("#mopf_affirm_btn").click();
        }
    });
</script>
