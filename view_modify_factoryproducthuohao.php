<?php
$tp=cselect("*","ydf_products_barcode",array("p_barcode_p_bianhao=? and p_barcode_factory_bianhao=?",$_REQUEST["var_p_bianhao"],$_REQUEST["var_factory_bianhao"]));
$rowfactoryguige=$tp[0]->fetch();
?>
<form method="post" id="modify_productfactory_form">
    <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
        <p style="float:left; width:100%; padding:5px 0; display:block">
            <span style="float:left; width:100px;font-size:12px; margin:5px 0; text-align:right">工厂货号：</span>
            <span style="float:left;">
            <input name="productmodifyfactory_huohao" id="productmodifyfactory_huohao" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowfactoryguige["p_barcode_factory_huohao"] ?>"/>
            </span>
        </p>
    </div>
    <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
        <input type="hidden" name="p_bianhao" value="<?php echo $_REQUEST["var_p_bianhao"] ?>">
        <input type="hidden" name="factory_bianhao" value="<?php echo $_REQUEST["var_factory_bianhao"] ?>">
        <span onclick="PostModifyFactoryPorductHuohao(<?php echo $_REQUEST["var_p_bianhao"] ?>,<?php echo $_REQUEST["var_factory_bianhao"] ?>)" style="float:left; margin-left:100px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认修改</span>
    </div>
</form>
