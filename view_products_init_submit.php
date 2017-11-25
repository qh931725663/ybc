<?php

include_once("check_dangkou_user.php");

$order_master_bianhao=!empty($_REQUEST["var_master_bianhao"])?$_REQUEST["var_master_bianhao"]:"";
$order_master_name=!empty($_REQUEST["var_master_name"])?$_REQUEST["var_master_name"]:""; 
?>
<div style="float:left; width:100%; margin-top:20px; overflow:hidden; display:block;">
    <span style="float:right">
        <span class="btn_normal_red" onclick="/**/mount_to_frame('view_products_init',1,'frame_products_init')">返回</span>
    </span>
</div>
<div id="productsinit_step_main" style="width:100%; overflow:hidden; display:block">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
        <div id="productsinitlist_left" style="float:left; width:56%; min-height:800px; padding:0 2%; border-right:1px solid #cccccc; overflow:hidden; display:block">

            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">已选择商品列表</span>
            </div>
            <form method="post" id="productsinit_order_form">
            <div style="float:left; width:98%; padding:5px 1%; display:block">
                <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
                    <div style="float:left; width:20%; font-size:12px; color:#999999">货号 / 工厂</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">颜色</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">尺码</div>
                    <div style="float:left; width:30%; font-size:12px; color:#999999; text-align:center">盘库数量</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">系统库存</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">初始数量</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">删除</div>
                </div>
                <div id="productsinit_list_barcode" style="width:100%; overflow:hidden; display:block;"></div>
            </div>
            <div style="width:98%; margin:20px auto; overflow:hidden; display:block">
                <div style="float:right; width:150px; overflow:hidden; display:block">
                    <div id="btn_productsinit_putintoorder" class="btn_putintoorderlist">确认初始化</div>
                </div>
            </div>
            <input type="hidden" name="order_type" value="kccsh">
            <input type="hidden" name="order_master_bianhao" value="<?php echo $order_master_bianhao ?>">
            <input type="hidden" name="order_master_name" value="<?php echo $order_master_name ?>">
            </form>                            
        </div>
        <div id="productsinitlist_right" style="float:left; width:35%; padding:0 2%; overflow:hidden; display:block">
        
            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">快速选择商品</span>
            </div>
            <div style="float:left; width:98%; padding:5px 1%">
                <div style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                    <div style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block">货号首字符：</div>
                    <div class="choosebox">
                        <ul>
                                <li>
                                    <span id='select_productsinit_char_hot_huohao' class="select_productsinit_char_radioToggle" onclick="/**/GetProductsinitHuohaoByFirstchar($(this),'HOT')">热销货号</span>
                                </li>
                                <?php
                                $p_firstchar=cselect("p_huohao_firstchar","ydf_products",array("p_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"p_huohao_firstchar","p_huohao_firstchar asc");
                                while ($rowfirstchar=$p_firstchar[0]->fetch())
                                {
                                ?>
                                <li>
                                    <span class="select_productsinit_char_radioToggle" onclick="/**/GetProductsinitHuohaoByFirstchar($(this),'<?php echo $rowfirstchar["p_huohao_firstchar"] ?>')"><?php echo $rowfirstchar["p_huohao_firstchar"] ?></span>
                                </li>
                                <?php
                                }
                                ?>
                        </ul>
                    </div>
                </div>
                <div id="select_productsinit_huohao" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none">

                </div>
                <div id="select_productsinit_factory" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none">

                    
                </div>
            </div>
        
        </div>
    
    </div>

    <div id="layer_productsinit_productorder" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
    
    </div>

</div>

<div id="productsinit_step_saving" style="width:100%; overflow:hidden; display:none">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; overflow:hidden; display:block">
        <div style="width:100%; height:100px; margin:0 auto; background:url(/pc/images/loading.gif) center center no-repeat; display:block">
        </div>    
    </div>
</div>
            
<script type="text/javascript">    
var order_productsinit_idx=0;
function get_productsinit_barcode_str(info)
{
    var productsinit_barcode_str = "" +
        "<div style='width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;'>" +
        "    <div style='float:left; width:20%; height:20px; font-size:12px'>"+info["huohao"] + " / "+info["factory_name"] +
        "       <input name='table["+order_productsinit_idx+"][order_barcode]' type='hidden' value='" +info["barcode"]+ "'>"+
        "       <input name='table["+order_productsinit_idx+"][order_p_bianhao]' type='hidden' class='productsinit_order_p_bianhao' value='" +info["p_bianhao"]+ "'>"+
        "       <input name='table["+order_productsinit_idx+"][order_p_type_bianhao]' type='hidden' value='" +info["p_type_bianhao"]+ "'>"+
        "       <input name='table["+order_productsinit_idx+"][order_factory_bianhao]' type='hidden' value='" +info["factory_bianhao"]+ "'>"+
        "       <input name='table["+order_productsinit_idx+"][order_huohao]' type='hidden' value='" +info["huohao"]+ "'>"+
        "       <input name='table["+order_productsinit_idx+"][order_color]' type='hidden' value='" +info["color"]+ "'>"+
        "       <input name='table["+order_productsinit_idx+"][order_size]' type='hidden' value='" +info["size"]+ "'>"+
        "       <input name='table["+order_productsinit_idx+"][order_valueprice]' type='hidden' value='" +info["valueprice"]+ "'>"+
        "       <input name='table["+order_productsinit_idx+"][order_num]' type='hidden' value='" +info["num"]+ "'>"+
        "       <input name='table["+order_productsinit_idx+"][order_factory_mode]' type='hidden' value='" +info["factory_mode"]+ "'>"+
        "       <input name='table["+order_productsinit_idx+"][order_factory_cycle]' type='hidden' value='" +info["factory_cycle"]+ "'>"+
        "   </div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; text-align:center'>"+info["color"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; text-align:center'>"+info["size"]+"</div>" +
        "    <div style='float:left; width:30%; height:20px; font-size:12px; text-align:center'>" +
        "        <span class='add_chose'>" +
        "            <span class='reduce' onclick='/**/setproductsinitListAmountReduce($(this).parent().children(\":eq(1)\"))'/>" +
        "                <input name='table["+order_productsinit_idx+"][order_really_stock_num]' class='productsinit_order_num text12' value='" +info["really_stock_num"]+ "' type='text'>" +
        "            <span class='add' onclick='/**/setproductsinitListAmountAdd($(this).parent().children(\":eq(1)\"))'/>" +
        "        </span>" +
        "    </div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; text-align:center'>"+info["stock_num"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; text-align:center'>"+info["num"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#3366FF; text-align:center; cursor:pointer' onclick='/**/DeleteProductsinitSelectProduct($(this))'>删除</div>" +
        "</div>";                        
    order_productsinit_idx++;
    return productsinit_barcode_str;
}

var productsinit_select_factory_barcode;
var productsinit_gethuohaobyfirstchar;
var productsinit_getfactoryproductdetailbyhuohao;

$(function(){
    $.ajax({
        url:"get-allproductsbarcode", 
        async: false,
        type: "POST",
        data:{var_dangkou_bianhao:productsinit_select_storewarehouse_bianhao},
        dataType:"json",
        success: function(html){
            productsinit_gethuohaobyfirstchar=html["char_idx"];
            productsinit_getfactoryproductdetailbyhuohao=html["product_idx"];
            productsinit_select_factory_barcode = $.extend({}, html["product_system_barcode"],html["product_customize_barcode"]);
        }
    });
    
    GetProductsinitHuohaoByFirstchar($("#select_productsinit_char_hot_huohao"), "HOT");

    $('#btn_productsinit_putintoorder').click(function(){        
        $.ajax({
            url:"model-order-post", 
            async: false,
            type: "POST",
            dataType:"json",
            data:$('#productsinit_order_form').serialize(),
            success: function(html){
                if (html.state!="ok"){
                    layer.msg("商品初始化失败！", {time: 2000, icon:2});
                    return false;
                }
                
                $('#productsinit_step_main').hide();    
                $('#productsinit_step_saving').show();
                
                mount_to_frame('view_products_init',1,'frame_products_init');
            }
        });        
    });
});

function GetProductsinitHuohaoByFirstchar(obj, select_productsinit_firstchar)
{
    $('.select_productsinit_char_radioToggle').removeClass('current');
    obj.addClass('current');

    var var_huohao_html="";                              
    var_huohao_html+="<div style='float:left; width:25%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>货号：</div>";
    var_huohao_html+="<div class='choosebox'>";
    var_huohao_html+="    <ul>";
    for (key in productsinit_gethuohaobyfirstchar[select_productsinit_firstchar])
    {
        var_huohao_html+="        <li>";
        var_huohao_html+="            <span class='select_productsinit_huohao_radioToggle' onclick='/**/GetProductsinitFactoryByHuohao($(this), \"" + productsinit_gethuohaobyfirstchar[select_productsinit_firstchar][key] + "\")'>" + productsinit_gethuohaobyfirstchar[select_productsinit_firstchar][key] + "</span>";
        var_huohao_html+="        </li>";
    }
    
    var_huohao_html+="    </ul>";
    var_huohao_html+="</div>";

    $("#select_productsinit_huohao").html(var_huohao_html);
    $("#select_productsinit_huohao").show();
    
    $("#select_productsinit_factory").html("");
    $("#select_productsinit_factory").hide();
}

function GetProductsinitFactoryByHuohao(obj, productsinit_huohao)
{
    $('.select_productsinit_huohao_radioToggle').removeClass('current');
    obj.addClass('current');
    
    var count_getfactorybyhuohao=0;
    var firstvalue_getfactorybyhuohao="";
    
    for (key in productsinit_getfactoryproductdetailbyhuohao[productsinit_huohao])
    {
        if (count_getfactorybyhuohao==0)
        {
            firstvalue_getfactorybyhuohao=key;
        }
        
        count_getfactorybyhuohao++;
    }
    
    if (count_getfactorybyhuohao==1)
    {
        $("#select_productsinit_factory").html("");
        $("#select_productsinit_factory").hide();
        
        ShowProductsinitFactoryProductOrderLayer(obj, firstvalue_getfactorybyhuohao, productsinit_huohao, 1);
    }
    else
    {    
        var var_factory_html="";                          
        var_factory_html+="<div style='float:left; width:25%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>工厂：</div>";
        var_factory_html+="<div class='choosebox'>";
        var_factory_html+="    <ul>";
        for (key in productsinit_getfactoryproductdetailbyhuohao[productsinit_huohao])
        {
            var_factory_html+="        <li>";
            var_factory_html+="            <span class='select_productsinit_factory_radioToggle' onclick='/**/ShowProductsinitFactoryProductOrderLayer($(this), \"" + key + "\",\"" + productsinit_huohao + "\",2)'>" + key + "</span>";
            var_factory_html+="        </li>";
        }
        var_factory_html+="    </ul>";
        var_factory_html+="</div>";
            
        $("#select_productsinit_factory").html(var_factory_html);
        $("#select_productsinit_factory").show();
    }
}

function ShowProductsinitFactoryProductOrderLayer(obj, factory_name, p_huohao, factory_count){
    if (factory_count>1)
    {
        $('.select_productsinit_factory_radioToggle').removeClass('current');
        obj.addClass('current');
    }
    
    $.ajax({
        url:"view-get-selectfactoryproductinit", 
        async: false,
        type: "POST",
        data:{var_order_type:"productsinit",var_factory:factory_name,var_p_huohao:p_huohao},
        success: function(html){
            $("#layer_productsinit_productorder").html(html);
        }
    });
    
    index_productsinit_showfactoryproductorder=layer.open({
        type: 1,
        area: ['420px', '500px'],
        title: false,
        content:$('#layer_productsinit_productorder')
    });
}

function setproductsinitListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
}

function setproductsinitListAmountReduce(obj)
{
    obj.val(parseInt(obj.val())-1);    
}

function DeleteProductsinitSelectProduct(obj)
{
    obj.parent().remove();
}
</script>
