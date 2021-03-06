<?php

include_once("check_factory_user.php");

$p_factory=cselect("*","ydf_factory",array("factory_boss_m_bianhao=? and factory_mobile=?" ,$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"],$_SESSION["ERP_ACCOUNT_LOGIN_MOBILE"]));
$rowfactory=$p_factory[0]->fetch();
$factory_id=$rowfactory["factory_bianhao"];
$order_factory_name=$rowfactory["factory_name"];
?>
<div id="step_main" style="width:100%; overflow:hidden; display:block">
    <div style="float:left; width:100%; margin:20px 0; overflow:hidden; display:block;">
        <div style="float:left; margin-left:30px; padding:5px 0; color:#ee583d">热敏标签规格：4cm(宽) x 5cm(高)</div>
        <div style="float:right">
            <span class="btn_normal_blue" onclick="/**/mount_to_frame('view_factory_products_barcodeprint',1,'frame_factory_products')">清空已选商品</span>
        </div>
    </div>
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
        <div id="barcodeprintlist_left" style="float:left; width:56%; min-height:800px; padding:0 2%; border-right:1px solid #cccccc; overflow:hidden; display:block">

            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">已选择商品列表</span>
            </div>
            <form method="post" id="barcodeprint_order_form" action="print-barcode" target="_blank">
            <div style="float:left; width:98%; padding:5px 1%; display:block">
                <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
                    <div style="float:left; width:25%; font-size:12px; color:#999999">货号 / 工厂</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">颜色</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">尺码</div>
                    <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">条码</div>
                    <div style="float:left; width:25%; font-size:12px; color:#999999; text-align:center">打印数量</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">删除</div>
                </div>
                <div id="barcodeprint_list_barcode" style="width:100%; overflow:hidden; display:block;"></div>
            </div>
            <div style="width:98%; margin:0 auto; overflow:hidden; display:block">
                <div style="float:right; margin-top:50px; overflow:hidden; display:block">
                    <input id="barcode_type" name="barcode_type" type="radio" value="1"/> 合格证<span style="color:#999999">（贴吊牌）</span> <input id="barcode_type" name="barcode_type" type="radio" value="2"/> 简易标签<span style="color:#999999">（贴包装袋外）</span>
                </div>
            </div>
            <div style="width:98%; margin:20px auto; overflow:hidden; display:block">
                <div style="float:right; width:150px; overflow:hidden; display:block">
                    <div id="btn_barcodeprint_putintoorder" class="btn_putintoorderlist">生成标签</div>
                </div>
            </div>
            </form>                            
        </div>
        <div id="barcodeprintlist_right" style="float:left; width:35%; padding:0 2%; overflow:hidden; display:block">
        
            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">快速选择商品</span>
            </div>
            <div style="float:left; width:98%; padding:5px 1%">
                <div style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                    <div style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block">货号：</div>
                    <div class="choosebox">
                        <ul>
                                <?php
                                $p=cselect("p_barcode_p_bianhao","ydf_products_barcode",array("p_barcode_factory_bianhao=?",$_REQUEST["var_factory_bianhao"]),"p_barcode_p_bianhao","p_barcode_bianhao desc");
                                while ($rowfactory=$p[0]->fetch())
                                {                                    
                                    $p_factoryhuohao=cselect("p_huohao","ydf_products",array("p_bianhao=?",$rowfactory["p_barcode_p_bianhao"]) );
                                    $rowfactoryhuohao=$p_factoryhuohao[0]->fetch();
                                ?>
                                <li>
                                    <span class="select_barcodeprint_factory_huohao_radioToggle" onclick="/**/ShowFactoryProductBarcodePrintOrderLayer($(this), '<?php echo $order_factory_name ?>', '<?php echo $rowfactoryhuohao["p_huohao"] ?>')"><?php echo $rowfactoryhuohao["p_huohao"] ?></span>
                                </li>
                                <?php
                                }
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
        
        </div>
    
    </div>

    <div id="layer_barcodeprint_productorder" style="float:left; width:350px; min-height:450px; padding:25px; overflow:hidden; display:none">
    
    </div>

</div>
            
<script type="text/javascript">    
var order_barcodeprint_idx=0;
function get_barcodeprint_barcode_str(info)
{
    var barcode_str = "" +
        "<div style='width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;'>" +
        "    <div style='float:left; width:25%; height:20px; font-size:12px'>"+info["huohao"]+" / "+info["factory_name"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; text-align:center'>"+info["color"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; text-align:center'>"+info["size"]+"</div>" +
        "    <div style='float:left; width:20%; height:20px; font-size:12px; text-align:center'>"+info["barcode"]+
        "       <input name='table["+order_barcodeprint_idx+"][order_barcode]' type='hidden' value='" +info["barcode"]+ "'>"+
        "       <input name='table["+order_barcodeprint_idx+"][order_p_bianhao]' type='hidden' value='" +info["p_bianhao"]+ "'>"+
        "       <input name='table["+order_barcodeprint_idx+"][order_huohao]' type='hidden' value='" +info["huohao"]+ "'>"+
        "       <input name='table["+order_barcodeprint_idx+"][order_color]' type='hidden' value='" +info["color"]+ "'>"+
        "       <input name='table["+order_barcodeprint_idx+"][order_size]' type='hidden' value='" +info["size"]+ "'>"+
        "   </div>" +
        "    <div style='float:left; width:25%; height:20px; font-size:12px; color:#999999; text-align:center'>" +
        "        <span class='add_chose'>" +
        "            <span class='reduce' onclick='/**/setbarcodeprintListAmountReduce($(this).parent().children(\":eq(1)\"))'/>" +
        "                <input name='table["+order_barcodeprint_idx+"][order_num]' class='barcodeprint_order_num text12' value='" +info["num"]+ "' type='text' onKeyUp='/**/setbarcodeprintListAmountModify($(this))'>" +
        "            <span class='add' onclick='/**/setbarcodeprintListAmountAdd($(this).parent().children(\":eq(1)\"))'/>" +
        "        </span>" +
        "    </div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#3366FF; text-align:center; cursor:pointer' onclick='/**/DeleteBarcodeprintSelectProduct($(this))'>删除</div>" +
        "</div>";                        
    order_barcodeprint_idx++;
    return barcode_str;
}

var barcodeprint_select_factory_barcode;

$(function(){
    //获取所有商品编码及属性
    $.ajax({
        url:"model-get-allfactoryproductsbarcode", 
        async: false,
        type: "POST",
        data:{var_factory_bianhao:<?php echo $factory_id?>},
        dataType:"json",
        success: function(html){
            barcodeprint_select_factory_barcode=html;
        }
    });

    $('#btn_barcodeprint_putintoorder').click(function(){
        if($('input:radio[name="barcode_type"]:checked').val()==null)
        {
                alert("请选择要打印的标签类型！");
                return false;
        }
                
        if($(".barcodeprint_order_num").length==0)
        {
            alert("暂无商品");
            return false;
        }
        
        $("#barcodeprint_order_form").submit();
    });
});

function ShowFactoryProductBarcodePrintOrderLayer(obj, factory_name, p_huohao){
    $.ajax({
        url:"view-get-selectfactoryproductorder", 
        async: false,
        type: "POST",
        data:{var_order_type:"barcodeprint",var_factory:factory_name,var_p_huohao:p_huohao},
        success: function(html){
            $("#layer_barcodeprint_productorder").html(html);
        }
    });
    
    index_barcodeprint_showfactoryproductorder=layer.open({
        type: 1,
        area: ['420px', 'auto'],
        title: false,
        content:$('#layer_barcodeprint_productorder')
    });
}

function setbarcodeprintListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
}

function setbarcodeprintListAmountReduce(obj)
{
    if ((parseInt(obj.val())-1)<1)
    {
        alert("打印数量不能小于1！");
        obj.val("1");
    }
    else
    {
        obj.val(parseInt(obj.val())-1);    
    }
}

function setbarcodeprintListAmountModify(obj)
{
    if (parseInt(obj.val())<1)
    {
        alert("打印数量不能小于1！");
        obj.val("1");
    }
}

function DeleteBarcodeprintSelectProduct(obj)
{
    obj.parent().remove();
}
</script>
