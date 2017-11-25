<?php

include_once("check_dangkou_user.php");

$order_master_bianhao=!empty($_REQUEST["var_master_bianhao"])?$_REQUEST["var_master_bianhao"]:"";
$order_master_name=!empty($_REQUEST["var_master_name"])?$_REQUEST["var_master_name"]:""; 
?>
<div style="float:left; width:100%; margin-top:20px; overflow:hidden; display:block;">
    <span style="float:right">
        <span class="btn_normal_blue" onclick="/**/mount_to_frame('view_stock_adjust',0,'frame_stock_adjust')">返回</span>
    </span>
</div>
<div id="stockadjust_step_main" style="width:100%; overflow:hidden; display:block">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
        <div id="stockadjustlist_left" style="float:left; width:53%; min-height:350px; padding:0 1%; border-right:1px solid #cccccc; overflow:hidden; display:block">

            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">已选择商品列表</span>
            </div>
            <form method="post" id="stockadjust_order_form">
            <div style="overflow-y:auto; max-height:280px; float:left; width:98%; padding:5px 1%; display:block">
                <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
                    <div style="float:left; width:20%; font-size:12px; color:#999999">货号</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">颜色</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">尺码</div>
                    <div style="float:left; width:30%; font-size:12px; color:#999999; text-align:center">盘库数量</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">系统库存</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">库存调整</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">删除</div>
                </div>
                <div id="stockadjust_list_barcode" style="width:100%; overflow:hidden; display:block;"></div>
            </div>
            <div style="width:98%; margin:20px auto; overflow:hidden; display:block">
                <div style="float:right; width:150px; overflow:hidden; display:block">
                    <div id="btn_stockadjust_putintoorder" class="btn_putintoorderlist">确认盘点</div>
                </div>
            </div>
            <input type="hidden" name="order_type" value="kcpd">
            <input type="hidden" name="order_master_bianhao" value="<?php echo $order_master_bianhao ?>">
            <input type="hidden" name="order_master_name" value="<?php echo $order_master_name ?>">
            </form>                            
        </div>
        <div id="stockadjustlist_right" style="float:left; width:42%; padding:0 1%; overflow:hidden; display:block">
        
            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">快速选择商品</span>
            </div>
            <div style="float:left; width:98%; padding:14px 1%">
                <div style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc;  display:block">
                    <div class="ikeyboard ikeyboard_tuihuo" onclick_before="/**/click_keyboard">
                        <span id="sure_add_huohao" class="btn_normal_red sure_add_huohao" style="float:right;margin-right:38%;height:11px;">确认</span>
                    </div>

                    <div class="iadditem">
                        <ul class="additem_list">
                            <li class="additem_btn">+</li>
                        </ul>
                    </div>
                </div>
                <div id="select_stockadjust_huohao" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none"></div>
                <div id="select_stockadjust_factory" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none"></div>
            </div>
        
        </div>
    
    </div>

    <div id="layer_stockadjust_productorder" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
    
    </div>

</div>

<div id="stockadjust_step_saving" style="width:100%; overflow:hidden; display:none">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; overflow:hidden; display:block">
        <div style="width:100%; height:100px; margin:0 auto; background:url(/pc/images/loading.gif) center center no-repeat; display:block">
        </div>    
    </div>
</div>
            
<script type="text/javascript">    
var order_idx=0;
function get_stockadjust_barcode_str(info)
{
    var barcode_str = "" +
         "<div style='width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;'>" +
        "    <div style='float:left; width:20%; height:20px; font-size:12px'><span>"+info["huohao"] + "</span>" +
        "       <input name='table["+order_idx+"][order_barcode]' type='hidden' value='" +info["barcode"]+ "'>"+
        "       <input name='table["+order_idx+"][order_p_bianhao]' type='hidden' class='stockadjust_order_p_bianhao' value='" +info["p_bianhao"]+ "'>"+
        "       <input name='table["+order_idx+"][order_p_type_bianhao]' type='hidden' value='" +info["p_type_bianhao"]+ "'>"+
        "       <input name='table["+order_idx+"][order_factory_bianhao]' type='hidden' value='" +info["factory_bianhao"]+ "'>"+
        "       <input name='table["+order_idx+"][order_huohao]' type='hidden' value='" +info["huohao"]+ "'>"+
        "       <input name='table["+order_idx+"][order_color]' type='hidden' value='" +info["color"]+ "'>"+
        "       <input name='table["+order_idx+"][order_size]' type='hidden' value='" +info["size"]+ "'>"+
        "       <input name='table["+order_idx+"][order_valueprice]' type='hidden' value='" +info["valueprice"]+ "'>"+
        "       <input name='table["+order_idx+"][order_num]' type='hidden' value='" +info["num"]+ "'>"+
        "       <input name='table["+order_idx+"][order_factory_mode]' type='hidden' value='" +info["factory_mode"]+ "'>"+
        "       <input name='table["+order_idx+"][order_factory_cycle]' type='hidden' value='" +info["factory_cycle"]+ "'>"+
        "   </div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; text-align:center'>"+info["color"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; text-align:center'>"+info["size"]+"</div>" +
        "    <div style='float:left; width:30%; height:20px; font-size:12px; text-align:center'>" +
        "        <span class='add_chose'>" +
        "            <span class='reduce' onclick='/**/setstockadjustListAmountReduce($(this).parent().children(\":eq(1)\"))'/>" +
        "                <input name='table["+order_idx+"][order_really_stock_num]' class='stockadjust_order_num text12' value='" +info["really_stock_num"]+ "' type='text' onKeyUp='/**/setstockadjustListAmountModify($(this))'>" +
        "            <span class='add' onclick='/**/setstockadjustListAmountAdd($(this).parent().children(\":eq(1)\"))'/>" +
        "        </span>" +
        "    </div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; text-align:center'>"+parseInt(info["stock_num"])+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; text-align:center'>"+info["num"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#3366FF; text-align:center; cursor:pointer' onclick='/**/DeleteStockadjustSelectProduct($(this))'>删除</div>" +
        "</div>";                        
    order_idx++;
    return barcode_str;
}

var stockadjust_select_factory_barcode;
var stockadjust_gethuohaobyfirstchar;
var stockadjust_getfactoryproductdetailbyhuohao;

$(function(){
    $.ajax({
        url:"get-allproductsbarcode", 
        async: false,
        type: "POST",
        data:{var_dangkou_bianhao:stockadjust_select_storewarehouse_bianhao},
        dataType:"json",
        success: function(html){
            stockadjust_gethuohaobyfirstchar=html["char_idx"];
            stockadjust_getfactoryproductdetailbyhuohao=html["product_idx"];
            stockadjust_select_factory_barcode = $.extend({}, html["product_system_barcode"],html["product_customize_barcode"]);
        }
    });

    $('#btn_stockadjust_putintoorder').click(function(){
        if($(".stockadjust_order_num").length==0)
        {
            alert("暂无商品");
            return false;
        }
        
                
        $.ajax({
            url:"model-order-post", 
            async: false,
            type: "POST",
            dataType:"json",
            data:$('#stockadjust_order_form').serialize(),
            success: function(html){
                if (html.state!="ok"){
                    layer.msg("库存盘点失败！", {time: 2000, icon:2});
                    return false;
                }
                
                $('#stockadjust_step_main').hide();    
                $('#stockadjust_step_saving').show();
                
                mount_to_frame('view_stock_adjust',1,'frame_stock_adjust');
            }
        });        
    });
});

function GetStockadjustHuohaoByFirstchar(obj, select_stockadjust_firstchar)
{
    $('.select_stockadjust_char_radioToggle').removeClass('current');
    obj.addClass('current');


    var var_huohao_html="";                              
    var_huohao_html+="<div style='float:left; width:25%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>货号：</div>";
    var_huohao_html+="<div class='choosebox'>";
    var_huohao_html+="    <ul>";
    for (key in stockadjust_gethuohaobyfirstchar[select_stockadjust_firstchar])
    {
        var_huohao_html+="        <li>";
        var_huohao_html+="            <span class='select_stockadjust_huohao_radioToggle' onclick='/**/GetStockadjustFactoryByHuohao($(this), \"" + stockadjust_gethuohaobyfirstchar[select_stockadjust_firstchar][key] + "\")'>" + stockadjust_gethuohaobyfirstchar[select_stockadjust_firstchar][key] + "</span>";
        var_huohao_html+="        </li>";
    }
    
    var_huohao_html+="    </ul>";
    var_huohao_html+="</div>";

    $("#select_stockadjust_huohao").html(var_huohao_html);
    $("#select_stockadjust_huohao").show();
    
    $("#select_stockadjust_factory").html("");
    $("#select_stockadjust_factory").hide();
}

var has_stockadjust_click=0;
function GetStockadjustFactoryByHuohao(obj, stockadjust_huohao)
{
    $('.select_stockadjust_huohao_radioToggle').removeClass('current');
    if (obj!=null){
        obj.addClass('current');
        has_stockadjust_click=1;
    }
    
    var count_getfactorybyhuohao=0;
    var firstvalue_getfactorybyhuohao="";
    
    for (key in stockadjust_getfactoryproductdetailbyhuohao[stockadjust_huohao])
    {
        if (count_getfactorybyhuohao==0)
        {
            firstvalue_getfactorybyhuohao=key;
        }
        
        count_getfactorybyhuohao++;
    }
    
    if (count_getfactorybyhuohao==1)
    {
        $("#select_stockadjust_factory").html("");
        $("#select_stockadjust_factory").hide();
        
        ShowStockadjustFactoryProductOrderLayer(obj, firstvalue_getfactorybyhuohao, stockadjust_huohao, 1);
    }
    else
    {    
        var var_factory_html="";                          
        var_factory_html+="<div class='ifactory' style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>工厂：</div>";
        var_factory_html+="<div class='choosebox'>";
        var_factory_html+="    <ul>";
        for (key in stockadjust_getfactoryproductdetailbyhuohao[stockadjust_huohao])
        {
            var_factory_html+="        <li>";
            var_factory_html+="            <span class='select_stockadjust_factory_radioToggle' onclick='/**/ShowStockadjustFactoryProductOrderLayer($(this), \"" + key + "\",\"" + stockadjust_huohao + "\",2)'>" + key + "</span>";
            var_factory_html+="        </li>";
        }
        var_factory_html+="    </ul>";
        var_factory_html+="</div>";
            
        $("#select_stockadjust_factory").html(var_factory_html);
        $("#select_stockadjust_factory").show();
        if($(".select_stockadjust_factory_radioToggle").css("display")=="block"){
            $(".ifactory").show();
        }else{
            $(".ifactory").hide();
        }
    }
}

function ShowStockadjustFactoryProductOrderLayer(obj, factory_name, p_huohao, factory_count){
    if (factory_count>1)
    {
        $('.select_stockadjust_factory_radioToggle').removeClass('current');
        obj.addClass('current');
    }
    
    $.ajax({
        url:"view-get-selectfactoryproduct-stockadjust", 
        async: false,
        type: "POST",
        data:{var_order_type:"stockadjust",var_factory:factory_name,var_p_huohao:p_huohao},
        success: function(html){
            $("#layer_stockadjust_productorder").html(html);
        }
    });
    
    index_stockadjust_showfactoryproductorder=layer.open({
        type: 1,
        area: ['420px', '500px'],
        title: false,
        content:$('#layer_stockadjust_productorder')
    });
}

function setstockadjustListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
    
    obj.parent().parent().next().next().html(parseInt(obj.val())-parseInt(obj.parent().parent().next().html()));
    obj.parent().parent().parent().children(":eq(0)").children(":eq(9)").val(parseInt(obj.val())-parseInt(obj.parent().parent().next().html()));
}

function setstockadjustListAmountReduce(obj)
{
    if ((parseInt(obj.val())-1)<1)
    {
        alert("数量不能小于1！");
        obj.val("1");
    }
    else
    {
        obj.val(parseInt(obj.val())-1);    
    }
    
    obj.parent().parent().next().next().html(parseInt(obj.val())-parseInt(obj.parent().parent().next().html()));
}

function setstockadjustListAmountModify(obj)
{
    if (parseInt(obj.val())<1)
    {
        alert("数量不能小于1！");
        obj.val("1");
    }
    
    obj.parent().parent().next().next().html(parseInt(obj.val())-parseInt(obj.parent().parent().next().html()));
}

function DeleteStockadjustSelectProduct(obj)
{
    obj.parent().remove();
}

var letters="";
for(var key in stockadjust_gethuohaobyfirstchar ){
    letters+=key;
}
$(".ikeyboard").init_ikeyboard(letters);//初始化键盘

function click_keyboard(pid)
{
    if (has_stockadjust_click==1){
        $(".ikeyboard").clear_ikeyboard();
        has_stockadjust_click=0;
    }
    //console.log(pid);
    /**/GetStockadjustFactoryByHuohao(null, pid);
}

$(".iadditem").init_iadditem(stockadjust_select_storewarehouse_bianhao);//添加自定义货号
</script>
