<?php

include_once("check_dangkou_user.php");

$btn_warehousepurchase_name="";
$last_order_bianhao=!empty($_REQUEST["var_last_order_bianhao"])?$_REQUEST["var_last_order_bianhao"]:"0";
$order_type="";
$order_slave_bianhao="";
$order_slave_name="";

$order_master_bianhao=!empty($_REQUEST["var_master_bianhao"])?$_REQUEST["var_master_bianhao"]:"";
$order_master_name=!empty($_REQUEST["var_master_name"])?$_REQUEST["var_master_name"]:""; 


if (!empty($_REQUEST["var_order_type"]))
{
    if ($_REQUEST["var_order_type"]=="dbck")
    {
        $btn_warehousepurchase_name="确认出库";    
    }
    elseif ($_REQUEST["var_order_type"]=="dbrk")
    {
        $btn_warehousepurchase_name="确认入库";    
    }
    
    $order_type=$_REQUEST["var_order_type"];
    $rsslave=mysql_query("SELECT * FROM ydf_dangkou WHERE dangkou_bianhao='".$_REQUEST["var_slave_bianhao"]."'" , $dbconn);
    if($rowslave=mysql_fetch_array($rsslave))
    {
        $order_slave_bianhao=$rowslave["dangkou_bianhao"];
        $order_slave_name=$rowslave["dangkou_name"];
    }
}
?>
<div style="float:left; width:100%; margin:10px 0; overflow:hidden; display:block">
    <div style="float:left; width:30%; overflow:hidden; display:block">
        <span style="float:left; margin-left:35px; margin-top:30px">调拨到：<span style="font-size:16px; font-weight:bold"><?php echo $_REQUEST["var_order_type"]=="dbrk"?$order_master_name:$order_slave_name?></span></span>
    </div>
    <div style="float:left; width:55%; overflow:hidden; display:block">
        <div style="float:right">
            <span style="float:left; margin-left:10px"><input id="saoma_stocktransfer_barcode" class="ibarcode"  name="saoma_stocktransfer_barcode" type="text" size="30" maxlength="100" style="width:300px; padding:5px; font-size:24px; height:35px;margin-top: 2px;" placeholder="扫码调拨" onclick="VVIP_INPUT='#saoma_stocktransfer_barcode'" onblur="$(VVIP_INPUT).focus();"></span>
            <span id="stocktransfer_notice_count" class="inoticecount" style="float:left; margin-left:10px; padding:8px 10px; font-size:35px; font-weight:bold; color:#ffffff; background:#d64126; overflow:hidden; display:block">0</span>
        </div>
    </div>
    <div style="float:left; width:15%; overflow:hidden; display:block">
        <div style="float:right; width:100px; margin-right:35px; margin-top:20px">
            <span class="btn_normal_blue" onclick="/**/mount_to_frame('view_stock_transfer',1,'frame_stock_transfer')">放弃返回</span>
        </div>
    </div>
</div>
<div id="stocktransfer_step_main" style="width:100%; overflow:hidden; display:block">
    <div style="width:98%; margin:0 auto 0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
        <div id="stocktransferlist_left" style="float:left; width:53%; min-height:350px; padding:0 1%; border-right:1px solid #cccccc; overflow:hidden; display:block">

            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">已选择商品列表</span>
                <span style="float:right">
                    <span style="font-size:18px; color:#999999">数量总计：<span id="stocktransfer_total_num" class="itotalnum" style=" font-size:24px; color:#ee583d">0</span></span>
                </span>
            </div>
            <form method="post" id="stocktransfer_order_form">
            <div style="float:left; overflow-y:auto; width:98%; padding:5px 1%; display:block;max-height:360px">
                <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
                    <div style="float:left; width:30%; font-size:12px; color:#999999">货号</div>
                    <div style="float:left; width:15%; font-size:12px; color:#999999; text-align:center">颜色</div>
                    <div style="float:left; width:15%; font-size:12px; color:#999999; text-align:center">尺码</div>
                    <div style="float:left; width:30%; font-size:12px; color:#999999; text-align:center">数量</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">删除</div>
                </div>
                <div id="stocktransfer_list_barcode" style="width:100%; overflow:hidden; display:block;"></div>
            </div>
            <div style="width:98%; margin:0px auto; overflow:hidden; display:block">
                <div style="float:right; width:150px; overflow:hidden; display:block">
                    <div id="btn_stocktransfer_putintoorder" class="btn_putintoorderlist"><?php echo $btn_warehousepurchase_name ?></div>
                </div>
            </div>
            <input type="hidden" name="order_type" value="<?php echo $order_type ?>">
            <input type="hidden" name="order_slave_bianhao" value="<?php echo $order_slave_bianhao ?>">
            <input type="hidden" name="order_slave_name" value="<?php echo $order_slave_name ?>">
            <input type="hidden" name="order_source_bianhao" value="<?php echo $last_order_bianhao ?>">
            <input type="hidden" id="stocktransfer_order_master_bianhao" name="order_master_bianhao" value="<?php echo $order_master_bianhao ?>">
            <input type="hidden" id="stocktransfer_order_master_name" name="order_master_name" value="<?php echo $order_master_name ?>">
            </form>                            
        </div>
        <div id="stocktransferlist_right" style="float:left; width:42%; padding:0 1%; overflow:hidden; display:block">
        
            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">快速选择商品</span>
            </div>
            <div style="float:left; width:98%; padding:5px 1%">
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
                <div id="select_stocktransfer_huohao" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none">

                </div>
                <div id="select_stocktransfer_factory" style="position: relative; width:100%; margin:5px 0; padding:5px 0; overflow:hidden; display:none">

                    
                </div>
            </div>
        
        </div>
    
    </div>

    <div id="layer_stocktransfer_productorder" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
    
    </div>

</div>

<div id="stocktransfer_step_saving" style="width:100%; overflow:hidden; display:none">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; overflow:hidden; display:block">
        <div style="width:100%; height:100px; margin:0 auto; background:url(/pc/images/loading.gif) center center no-repeat; display:block">
        </div>    
    </div>
</div>
            
<script type="text/javascript">    
var order_idx=0;
function get_stocktransfer_barcode_str(info)
{
    var barcode_str = "" +
        "<div style='width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;'>" +
        "    <div style='float:left; width:30%; height:20px; font-size:12px; color:#999999'><span>"+info["huohao"]+" / "+info["factory_name"] + "</span>" +
        "       <input name='table["+order_idx+"][order_barcode]' type='hidden' value='" +info["barcode"]+ "'>"+
        "       <input name='table["+order_idx+"][order_p_bianhao]' type='hidden' class='stocktransfer_order_p_bianhao' value='" +info["p_bianhao"]+ "'>"+
        "       <input name='table["+order_idx+"][order_p_type_bianhao]' type='hidden' value='" +info["p_type_bianhao"]+ "'>"+
        "       <input name='table["+order_idx+"][order_factory_bianhao]' type='hidden' value='" +info["factory_bianhao"]+ "'>"+
        "       <input name='table["+order_idx+"][order_huohao]' type='hidden' value='" +info["huohao"]+ "'>"+
        "       <input name='table["+order_idx+"][order_color]' type='hidden' value='" +info["color"]+ "'>"+
        "       <input name='table["+order_idx+"][order_size]' type='hidden' value='" +info["size"]+ "'>"+
        "       <input name='table["+order_idx+"][order_valueprice]' type='hidden' value='" +info["valueprice"]+ "'>"+
        "       <input name='table["+order_idx+"][order_factory_mode]' type='hidden' value='" +info["factory_mode"]+ "'>"+
        "       <input name='table["+order_idx+"][order_factory_cycle]' type='hidden' value='" +info["factory_cycle"]+ "'>"+
        "   </div>" +
        "    <div style='float:left; width:15%; height:20px; font-size:12px; color:#999999; text-align:center'>"+info["color"]+"</div>" +
        "    <div style='float:left; width:15%; height:20px; font-size:12px; color:#999999; text-align:center'>"+info["size"]+"</div>" +
        "    <div style='float:left; width:30%; height:20px; font-size:12px; color:#999999; text-align:center'>" +
        "        <span class='add_chose'>" +
        "            <span class='reduce' onclick='/**/setstocktransferListAmountReduce($(this).parent().children(\":eq(1)\"))'/>" +
        "                <input name='table["+order_idx+"][order_num]' class='stocktransfer_order_num text12 iedit_num' value='" +info["num"]+ "' errmsg='iedit_num' type='text' onKeyUp='/**/setstocktransferListAmountModify($(this))'>" +
        "            <span class='add' onclick='/**/setstocktransferListAmountAdd($(this).parent().children(\":eq(1)\"))'/>" +
        "        </span>" +
        "    </div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#3366FF; text-align:center; cursor:pointer' onclick='/**/DeleteStocktransferSelectProduct($(this))'>删除</div>" +
        "</div>";                        
    order_idx++;
    return barcode_str;
}

var stocktransfer_select_factory_barcode;
var stocktransfer_product_system_barcode;
var stocktransfer_product_customize_barcode;
var stocktransfer_gethuohaobyfirstchar;
var stocktransfer_getfactoryproductdetailbyhuohao;

$(function(){
    if (stocktransfer_select_storewarehouse_bianhao!="")
    {
        $("#stocktransfer_order_master_bianhao").val(stocktransfer_select_storewarehouse_bianhao);
        $("#stocktransfer_order_master_name").val(stocktransfer_select_storewarehouse_name);
    }
    
    $.ajax({
        url:"get-allproductsbarcode", 
        async: false,
        type: "POST",
        data:{var_dangkou_bianhao:stocktransfer_select_storewarehouse_bianhao},
        dataType:"json",
        success: function(html){
            stocktransfer_gethuohaobyfirstchar=html["char_idx"];
            stocktransfer_getfactoryproductdetailbyhuohao=html["product_idx"];
            stocktransfer_select_factory_barcode = $.extend({}, html["product_system_barcode"],html["product_customize_barcode"]);
            stocktransfer_product_system_barcode = html["product_system_barcode"];
            stocktransfer_product_customize_barcode = html["product_customize_barcode"];
        }
    });


    
    
    GetStocktransferHuohaoByFirstchar($("#select_stocktransfer_char_hot_huohao"), "HOT");
    
    setTimeout("$('#saoma_stocktransfer_barcode').focus()",0);
    
    $("#saoma_stocktransfer_barcode").keyup(function(e){
        if (stocktransfer_product_system_barcode[$(this).val()] || stocktransfer_product_customize_barcode[$(this).val()])
        {
            if (stocktransfer_product_system_barcode[$(this).val()])
            {
                var info={
                    "huohao":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_huohao"],
                    "color":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_color"],
                    "size":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_size"],
                    "price": stocktransfer_product_system_barcode[$(this).val()]["p_seller_price"], 
                    "barcode":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_bianhao"],
                    "p_bianhao":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_p_bianhao"], 
                    "p_type_bianhao":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_p_type_bianhao"], 
                    "factory_bianhao":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_factory_bianhao"], 
                    "factory_name":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_factory_name"], 
                    "valueprice":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_valueprice"], 
                    "factory_mode":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_factory_mode"], 
                    "factory_cycle":stocktransfer_product_system_barcode[$(this).val()]["p_barcode_factory_cycle"], 
                    "num":1
                }
            }
            else if (stocktransfer_product_customize_barcode[$(this).val()])
            {
                var info={
                    "huohao":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_huohao"],
                    "color":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_color"],
                    "size":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_size"],
                    "price": stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_seller_price"], 
                    "barcode":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_bianhao"],
                    "p_bianhao":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_p_bianhao"], 
                    "p_type_bianhao":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_p_type_bianhao"], 
                    "factory_bianhao":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_factory_bianhao"], 
                    "factory_name":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_factory_name"], 
                    "valueprice":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_valueprice"], 
                    "factory_mode":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_factory_mode"], 
                    "factory_cycle":stocktransfer_product_system_barcode[stocktransfer_product_customize_barcode[$(this).val()]]["p_barcode_factory_cycle"], 
                    "num":1
                }
            }
            
            $("#stocktransfer_list_barcode").prepend(get_stocktransfer_barcode_str(info));
            var order_sum=0;
            var order_total_money=0;
            $(".stocktransfer_order_num").each(function(){
               order_sum += parseInt($(this).val());
               order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
            })

            $('#stocktransfer_total_num').html(order_sum);
            $('#stocktransfer_notice_count').html(order_sum);
            $(this).val("");
        }
        //if(e.keyCode==13){
        //    if($(this).val()==""){
        //        $("#btn_stocktransfer_putintoorderlist").click();
        //    }
        //    $(this).val("");
        //}
    });
    
    <?php
    if(!empty($_REQUEST["var_last_order_bianhao"]))
    {
    ?>
    var dkbhck_order_detail_barcode;
    $.ajax({
        url:"get-purchaseorderdetailbarcode", 
        async: false,
        type: "POST",
        data:{var_order_bianhao:"<?php echo $_REQUEST["var_last_order_bianhao"] ?>"},
        dataType:"json",
        success: function(html){
            dkbhck_order_detail_barcode=html;
        }
    });
    
    for (key in dkbhck_order_detail_barcode)
    {
        var info={
            "huohao":stocktransfer_select_factory_barcode[key]["p_barcode_huohao"],
            "color":stocktransfer_select_factory_barcode[key]["p_barcode_color"],
            "size":stocktransfer_select_factory_barcode[key]["p_barcode_size"],
            "price": stocktransfer_select_factory_barcode[key]["p_seller_price"], 
            "barcode":key, 
            "p_bianhao":stocktransfer_select_factory_barcode[key]["p_barcode_p_bianhao"], 
            "p_type_bianhao":stocktransfer_select_factory_barcode[key]["p_barcode_p_type_bianhao"], 
            "factory_bianhao":stocktransfer_select_factory_barcode[key]["p_barcode_factory_bianhao"], 
            "factory_name":stocktransfer_select_factory_barcode[key]["p_barcode_factory_name"], 
            "valueprice":stocktransfer_select_factory_barcode[key]["p_barcode_valueprice"], 
            "factory_mode":stocktransfer_select_factory_barcode[key]["p_barcode_factory_mode"], 
            "factory_cycle":stocktransfer_select_factory_barcode[key]["p_barcode_factory_cycle"], 
            "num":dkbhck_order_detail_barcode[key]["detail_order_num"]
        }
        $("#stocktransfer_list_barcode").prepend(get_stocktransfer_barcode_str(info));
    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".stocktransfer_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })
    $('#stocktransfer_total_num').html(order_sum);
    $('#stocktransfer_notice_count').html(order_sum);
    <?php
    }
    ?>

    $('#btn_stocktransfer_putintoorder').click(function(){
        if($(".stocktransfer_order_num").length==0)
        {
            alert("暂无商品");
            return false;
        }
        
                
        $.ajax({
            url:"model-order-post", 
            async: false,
            type: "POST",
            dataType:"json",
            data:$('#stocktransfer_order_form').serialize(),
            success: function(html){
                if (html.state!="ok"){
                    layer.msg("库存调拨失败！", {time: 2000, icon:2});
                    return false;
                }
                
                $('#stocktransfer_step_main').hide();    
                $('#stocktransfer_step_saving').show();
                
                mount_to_frame('view_stock_transfer',1,'frame_stock_transfer');
            }
        });        
    });
});

function GetStocktransferHuohaoByFirstchar(obj, select_stocktransfer_firstchar)
{
    $('.select_stocktransfer_char_radioToggle').removeClass('current');
    obj.addClass('current');


    var var_huohao_html="";                              
    var_huohao_html+="<div style='float:left; width:25%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:none;'>货号：</div>";
    var_huohao_html+="<div class='choosebox'>";
    var_huohao_html+="    <ul>";
    for (key in stocktransfer_gethuohaobyfirstchar[select_stocktransfer_firstchar])
    {
        var_huohao_html+="        <li>";
        var_huohao_html+="            <span class='select_stocktransfer_huohao_radioToggle' onclick='/**/GetStocktransferFactoryByHuohao($(this), \"" + stocktransfer_gethuohaobyfirstchar[select_stocktransfer_firstchar][key] + "\")'>" + stocktransfer_gethuohaobyfirstchar[select_stocktransfer_firstchar][key] + "</span>";
        var_huohao_html+="        </li>";
    }
    
    var_huohao_html+="    </ul>";
    var_huohao_html+="</div>";

    $("#select_stocktransfer_huohao").html(var_huohao_html);
    $("#select_stocktransfer_huohao").show();
    
    $("#select_stocktransfer_factory").html("");
    $("#select_stocktransfer_factory").hide();
}

var has_stocktransfer_click=0;
function GetStocktransferFactoryByHuohao(obj, stocktransfer_huohao)
{
    $('.select_stocktransfer_huohao_radioToggle').removeClass('current');
    if (obj!=null){
        obj.addClass('current');
        has_stocktransfer_click=1;
    }
    
    var count_getfactorybyhuohao=0;
    var firstvalue_getfactorybyhuohao="";
    
    for (key in stocktransfer_getfactoryproductdetailbyhuohao[stocktransfer_huohao])
    {
        if (count_getfactorybyhuohao==0)
        {
            firstvalue_getfactorybyhuohao=key;
        }
        
        count_getfactorybyhuohao++;
    }
    
    if (count_getfactorybyhuohao==1)
    {
        $("#select_stocktransfer_factory").html("");
        $("#select_stocktransfer_factory").hide();
        
        ShowStocktransferFactoryProductOrderLayer(obj, firstvalue_getfactorybyhuohao, stocktransfer_huohao, 1);
    }
    else
    {    
        var var_factory_html="";                          
        var_factory_html+="<div class='ifactory' style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>工厂：</div>";
        var_factory_html+="<div class='choosebox'>";
        var_factory_html+="    <ul>";
        for (key in stocktransfer_getfactoryproductdetailbyhuohao[stocktransfer_huohao])
        {
            var_factory_html+="        <li>";
            var_factory_html+="            <span class='select_stocktransfer_factory_radioToggle' onclick='/**/ShowStocktransferFactoryProductOrderLayer($(this), \"" + key + "\",\"" + stocktransfer_huohao + "\",2)'>" + key + "</span>";
            var_factory_html+="        </li>";
        }
        var_factory_html+="    </ul>";
        var_factory_html+="</div>";
            
        $("#select_stocktransfer_factory").html(var_factory_html);
        $("#select_stocktransfer_factory").show();
        if($(".select_stocktransfer_factory_radioToggle").css("display")=="block"){
            $(".ifactory").show();
        }else{
           $(".ifactory").hide();
        }
    }
}

function ShowStocktransferFactoryProductOrderLayer(obj, factory_name, p_huohao, factory_count){
    if (factory_count>1)
    {
        $('.select_stocktransfer_factory_radioToggle').removeClass('current');
        obj.addClass('current');
    }
    
    $.ajax({
        url:"view-get-selectfactoryproductorder", 
        async: false,
        type: "POST",
        data:{var_order_type:"stocktransfer",var_factory:factory_name,var_p_huohao:p_huohao},
        success: function(html){
            $("#layer_stocktransfer_productorder").html(html);
        }
    });
    
    index_stocktransfer_showfactoryproductorder=layer.open({
        type: 1,
        area: ['420px', '500px'],
        title: false,
        content:$('#layer_stocktransfer_productorder')
    });
}

function setstocktransferListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
    
    var order_sum=0;
    var order_total_money=0;
    $(".stocktransfer_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#stocktransfer_total_num').html(order_sum);

    $('#stocktransfer_notice_count').html(order_sum);
}

function setstocktransferListAmountReduce(obj)
{
    if ((parseInt(obj.val())-1)<1)
    {
        alert("入库数量不能小于1！");
        obj.val("1");
    }
    else
    {
        obj.val(parseInt(obj.val())-1);    
    }

    var order_sum=0;
    var order_total_money=0;
    $(".stocktransfer_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#stocktransfer_total_num').html(order_sum);
    $('#stocktransfer_notice_count').html(order_sum);
}

function setstocktransferListAmountModify(obj)
{
    if (parseInt(obj.val())<1)
    {
        alert("入库数量不能小于1！");
        obj.val("1");
    }

    var order_sum=0;
    var order_total_money=0;
    $(".stocktransfer_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })
    $('#stocktransfer_total_num').html(order_sum);
    $('#stocktransfer_notice_count').html(order_sum);
}

function DeleteStocktransferSelectProduct(obj)
{
    obj.parent().remove();

    var order_sum=0;
    var order_total_money=0;
    $(".stocktransfer_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#stocktransfer_total_num').html(order_sum);
    $("#stocktransfer_notice_count").html(order_sum);
}
var letters="";
for(var key in stocktransfer_gethuohaobyfirstchar ){
    letters+=key;
}
$(".ikeyboard").init_ikeyboard(letters);//初始化键盘

function click_keyboard(pid)
{
    if (has_stocktransfer_click==1){
        $(".ikeyboard").clear_ikeyboard();
        has_stockadjust_click=0;
    }
    //console.log(pid);
    /**/GetStocktransferFactoryByHuohao(null, pid);
}
var chuku_select_storewarehouse_bianhao=stocktransfer_select_storewarehouse_bianhao;
$(".iadditem").init_iadditem(chuku_select_storewarehouse_bianhao);//添加自定义货号
</script>
