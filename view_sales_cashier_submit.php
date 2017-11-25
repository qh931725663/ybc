<?php

include_once("check_dangkou_user.php");
?>
<div style="float:left; width:100%; overflow:hidden; display:block;">
    <div id="chuku_step_main" style="width:100%; display:block">
		<div style="float:left; width:100%; margin:10px 0; overflow:hidden; display:block" class="jianrongxing">
            <div style="float:left; width:30%; overflow:hidden; display:block">
                <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                    <div style="float:left; margin-left:35px; margin-bottom:19px">
                        当前卖家：<span id="chukuorderlist_seller_name" style="font-size:16px; font-weight:bold; color:#ee583d"></span><span id="chuku_note_seller_cycle" style="margin-left:10px; font-size:16px; font-weight:bold; color:#ee583d"></span>
                    </div>
                </div>
                <div style="float:left; width:100%; overflow:hidden; display:block">
                    <div style="float:left; margin-left:35px">
                        出货：<span id="chukuorderlist_store_name" style="font-size:16px; font-weight:bold"></span>
                    </div>
                    <div id="layer_chukuorderlist_sales_store_name" style="float:left; margin-left:35px; display:none">
                        销售：<span id="chukuorderlist_sales_store_name" style="font-size:16px; font-weight:bold"></span>
                    </div>
                </div>
            </div>
            <div style="float:left; width:55%; overflow:hidden; display:block">
                <div style="float:right">
                    <span style="float:left; margin-left:10px"><input tabindex="0" class="ibarcode" id="saoma_chuku_barcode"  name="saoma_chuku_barcode" type="text" size="30" maxlength="100" style="width:300px; padding:5px; font-size:24px;height:58px;" placeholder="扫码出货" onclick="VVIP_INPUT='#saoma_chuku_barcode'" onblur="$(VVIP_INPUT).focus();"></span>
                    <span id="chuku_notice_count" class="inoticecount" style="float:left; margin-left:10px; padding:12px 20px; font-size:48px; font-weight:bold; color:#ffffff; background:#d64126">0</span>
                </div>
            </div>
            <div style="float:left; width:15%; overflow:hidden; display:block">
                <div style="float:right; width:100px; margin-right:35px;">
                    <span id="btn_temp_chuku_putintoorderlist" class="btn_normal_green" style="background-color:#37424F">暂时挂起</span>
                    <span style="margin-top:15px" class="btn_normal_blue" onclick="/**/mount_to_frame('view_sales_cashier',1,'frame_sales_cashier')">放弃返回</span>
                </div>
            </div>
		</div>
        <div style="width:98%; margin:-26px auto 0; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
            <div id="chukuorderlist_left" style="float:left;width:53%; min-height:350px;padding:0 1%; border-right:1px solid #cccccc; overflow:hidden; display:block">
                <div style="float:left; width:98%; padding:10px 1%">
                    <span style="float:left">已选择商品列表</span>
                    <span style="float:right">
                        <span style="font-size:18px; colorsc:#999999">数量总计：<span id="chuku_total_num" class="itotalnum" style=" font-size:24px; color:#ee583d">0</span>, 金额总计：<span id="chuku_total_money" class="itotalmoney" style="font-size:24px; color:#ee583d">0</span></span>
                    </span>
                </div>
                <form method="post" id="chuku_order_form">
                <div  style="overflow-y:auto;float:left; max-height:370px;width:98%; padding:5px 1%; display:block">
                    <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
                        <div style="float:left; width:25%; font-size:12px; color:#999999">货号</div>
                        <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">颜色</div>
                        <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">尺码</div>
                        <div class="iprices" style="float:left; width:15%; font-size:12px; color:#999999; text-align:center">单价</div>
                        <div style="float:left; width:30%; font-size:12px; color:#999999; text-align:center">拿货数量</div>
                        <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">删除</div>
                    </div>
                    <div id="chuku_list_barcode" style="width:100%; overflow:hidden; display:block;"></div>
                </div>
                <div id="chuku_seller_nocycle_status" style="width:98%; margin:2px auto 0 auto; overflow:hidden; display:none">
                    <div style="float:right; overflow:hidden; display:block">
                        <input id="select_chuku_order_nocycle_is_pay" type="checkbox" style="width:20px; height:20px" value="0"> <span style="font-size:16px; font-weight:bold; color:#ee583d">未付款</span>
                    </div>
                </div>
                <div style="width:98%; margin:5px auto; overflow:hidden; display:block">
                    <div style="float:right; width:150px; overflow:hidden; display:block">
                        <div id="btn_chuku_putintoorderlist" class="btn_putintoorderlist" style="margin:3px 0;">确认提交出库</div>
                    </div>
                </div>
                <input type="hidden" id="chuku_order_seller_bianhao" name="order_seller_bianhao">
                <input type="hidden" id="chuku_order_seller_name" name="order_seller_name">
                <input type="hidden" id="chuku_order_seller_cycle" name="order_seller_cycle">
                <input type="hidden" id="chuku_order_is_pay" name="order_is_pay" value="0">
                <input type="hidden" id="chuku_order_type" name="order_type">
                <input type="hidden" id="chuku_order_temp_bianhao" name="order_temp_bianhao" value="0">
                <input type="hidden" id="chuku_order_master_bianhao" name="order_master_bianhao">
                <input type="hidden" id="chuku_order_master_name" name="order_master_name">
                <input type="hidden" id="chuku_order_to_dangkou_bianhao" name="order_slave_bianhao">
                <input type="hidden" id="chuku_order_to_dangkou_name" name="order_slave_name">
                <input type="hidden" name="order_is_pickup" value="0">
                </form>
            </div>
            <div id="chukuorderlist_right" style="float:left; width:42%; padding:0 1%; display:block">

                <div style="float:left; width:98%; padding:10px 1%">
                    <span style="float:left">快速选择商品</span>
                </div>
                <div style="float:left; width:98%; padding:5px 1%">
                    <div style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc;  display:block">
                        <div class="ikeyboard" onclick_before="view_sales_cashier_submit.click_keyboard"></div>
                        <div class="iadditem">
                            <ul class="additem_list">
                                <li class="additem_btn">+</li>
                            </ul>
                        </div>
                    </div>
                    <div id="select_chuku_huohao" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none"/>
                    <div id="select_chuku_factory" style="position: relative; width:100%; margin:5px 0; padding:5px 0;border-bottom:1px dashed #cccccc;overflow:hidden; display:none"/>
                    <div id="select_chuku_color" style="position: relative; width:100%; margin:5px 0; padding:5px 0;border-bottom:1px dashed #cccccc; overflow:hidden; display:none"/>
                    <div id="select_chuku_size" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none" />
                </div>

            </div>

        </div>

    </div>

    <div id="chuku_step_saving" style="width:100%; overflow:hidden; display:none">
        <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; overflow:hidden; display:block">
            <div style="width:100%; height:100px; margin:0 auto; background:url(/pc/images/loading.gif) center center no-repeat; display:block">
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
$ ("#fram_search_tab").css("display","none");
$ ("#frame_tab_panel").css("display","none");
var order_chuku_idx=0;
function get_chuku_barcode_str(info)
{
    var price_input_html;
    if (parseInt(chuku_order_seller_bianhao)>1)
    {
        price_input_html="<input name='table["+order_chuku_idx+"][order_price]' type='text' maxlength='100' style='width:50px; padding:2px; text-align:center; background:#dddddd; border:0; color:#ee583d' value='" +info["price"]+ "' class='order_price iedit_price' onKeyUp='/**/setChukuListPriceModify($(this))'>";
    }
    else
    {
        price_input_html="<input name='table["+order_chuku_idx+"][order_price]' type='text' maxlength='100' style='width:50px; padding:2px; text-align:center; background:#ffffff; border:0; color:#ee583d' value='" +info["price"]+ "' class='order_price iedit_price' onKeyUp='/**/setChukuListPriceModify($(this))' readonly>";
    }


    var barcode_str = "" +
        "<div class='iedit' style='width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;'>" +
        "    <div style='float:left; width:25%; height:20px; font-size:12px; color:#999999'>"+info["huohao"]+" / "+info["factory_name"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#999999; text-align:center'>"+info["color"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#999999; text-align:center'>"+info["size"]+"</div>" +
        "    <div style='float:left; width:15%; height:20px; text-align:center'>"+ price_input_html +
        "       <input name='table["+order_chuku_idx+"][order_barcode]' type='hidden' value='" +info["barcode"]+ "'>"+
        "       <input name='table["+order_chuku_idx+"][order_p_bianhao]' type='hidden' class='chuku_order_p_bianhao' value='" +info["p_bianhao"]+ "'>"+
        "       <input name='table["+order_chuku_idx+"][order_p_type_bianhao]' type='hidden' value='" +info["p_type_bianhao"]+ "'>"+
        "       <input name='table["+order_chuku_idx+"][order_factory_bianhao]' type='hidden' value='" +info["factory_bianhao"]+ "'>"+
        "       <input name='table["+order_chuku_idx+"][order_huohao]' type='hidden' value='" +info["huohao"]+ "'>"+
        "       <input name='table["+order_chuku_idx+"][order_color]' type='hidden' value='" +info["color"]+ "'>"+
        "       <input name='table["+order_chuku_idx+"][order_size]' type='hidden' value='" +info["size"]+ "'>"+
        "       <input name='table["+order_chuku_idx+"][order_valueprice]' type='hidden' value='" +info["valueprice"]+ "'>"+
        "       <input name='table["+order_chuku_idx+"][order_factory_mode]' type='hidden' value='" +info["factory_mode"]+ "'>"+
        "       <input name='table["+order_chuku_idx+"][order_factory_cycle]' type='hidden' value='" +info["factory_cycle"]+ "'>"+
        "   </div>" +
        "    <div style='float:left; width:30%; height:20px; font-size:12px; color:#999999; text-align:center'>" +
        "        <span class='add_chose'>" +
        "            <span class='reduce' onclick='/**/setChukuListAmountReduce($(this).parent().children(\":eq(1)\"))'/>" +
        "                <input name='table["+order_chuku_idx+"][order_num]' class='chuku_order_num text12 iedit_num' value='" +info["num"]+ "' errmsg='iedit_num' type='text' onKeyUp='/**/setChukuListAmountModify($(this))'>" +
        "            <span class='add' onclick='/**/setChukuListAmountAdd($(this).parent().children(\":eq(1)\"))'/>" +
        "        </span>" +
        "    </div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#3366FF; text-align:center; cursor:pointer' onclick='/**/DeleteChukuSelectProduct($(this))'>删除</div>" +
        "</div>";
    order_chuku_idx++;
    return barcode_str;
}

var chuku_product_system_barcode;
var chuku_product_customize_barcode;
var chuku_gethuohaobyfirstchar;
var chuku_getproductdetailbyhuohao;

$(function(){
    if (chuku_select_storewarehouse_bianhao!="")
    {
        $("#chuku_order_master_bianhao").val(chuku_select_storewarehouse_bianhao);
        $("#chuku_order_master_name").val(chuku_select_storewarehouse_name);
        $("#chukuorderlist_store_name").html(chuku_select_storewarehouse_name);
    }

    if (chuku_order_seller_name!="")
    {
        $("#chukuorderlist_seller_name").html(chuku_order_seller_name);
    }
    else
    {
        $("#chukuorderlist_seller_name").html("匿名卖家");
    }

    if (parseInt(chuku_order_seller_cycle)>0)
    {
        $("#chuku_order_is_pay").val(0);
        $("#chuku_seller_nocycle_status").hide();
        $("#chuku_note_seller_cycle").html("[账期卖家]");
    }
    else
    {
        $("#chuku_order_is_pay").val(1);
        $("#chuku_seller_nocycle_status").show();
        $("#chuku_note_seller_cycle").html("");
    }

    if (chuku_order_to_dangkou_bianhao!="")
    {
        chuku_order_type="ckph";
        $("#chuku_order_is_pay").val(0);
        $("#chuku_order_to_dangkou_bianhao").val(chuku_order_to_dangkou_bianhao);
        $("#chuku_order_to_dangkou_name").val(chuku_order_to_dangkou_name);
        $("#chukuorderlist_sales_store_name").html(chuku_order_to_dangkou_name);
        $("#layer_chukuorderlist_sales_store_name").show();
    }

    $("#chuku_order_seller_bianhao").val(chuku_order_seller_bianhao);
    $("#chuku_order_seller_name").val(chuku_order_seller_name);
    $("#chuku_order_seller_cycle").val(chuku_order_seller_cycle);

    $("#chuku_order_type").val(chuku_order_type);

    $.ajax({
        url:"get-allproductsbarcode",
        async: false,
        type: "POST",
        data:{var_dangkou_bianhao:chuku_select_storewarehouse_bianhao,var_seller_bianhao:chuku_order_seller_bianhao},
        dataType:"json",
        success: function(html){
            chuku_gethuohaobyfirstchar=html["char_idx"];
            chuku_getproductdetailbyhuohao=html["product_idx"];
            chuku_product_system_barcode = html["product_system_barcode"];
            chuku_product_customize_barcode = html["product_customize_barcode"];
        }
    });

    <?php
    if (!empty($_REQUEST["var_order_temp_bianhao"]))
    {
    ?>
    $("#chuku_order_temp_bianhao").val("<?php echo $_REQUEST["var_order_temp_bianhao"] ?>")
    var chuku_order_temp_detail_barcode;
    $.ajax({
        url:"get-ordertempdetailbarcode",
        async: false,
        type: "POST",
        data:{var_order_temp_bianhao:"<?php echo $_REQUEST["var_order_temp_bianhao"] ?>"},
        dataType:"json",
        success: function(html){
            chuku_order_temp_detail_barcode=html;
        }
    });

    for (key in chuku_order_temp_detail_barcode)
    {
        var info={
            "huohao":chuku_product_system_barcode[key]["p_barcode_huohao"],
            "color":chuku_product_system_barcode[key]["p_barcode_color"],
            "size":chuku_product_system_barcode[key]["p_barcode_size"],
            "price": chuku_product_system_barcode[key]["p_seller_price"],
            "barcode":key,
            "p_bianhao":chuku_product_system_barcode[key]["p_barcode_p_bianhao"],
            "p_type_bianhao":chuku_product_system_barcode[key]["p_barcode_p_type_bianhao"],
            "factory_bianhao":chuku_product_system_barcode[key]["p_barcode_factory_bianhao"],
            "factory_name":chuku_product_system_barcode[key]["p_barcode_factory_name"],
            "valueprice":chuku_product_system_barcode[key]["p_barcode_valueprice"],
            "factory_mode":chuku_product_system_barcode[key]["p_barcode_factory_mode"],
            "factory_cycle":chuku_product_system_barcode[key]["p_barcode_factory_cycle"],
            "num":chuku_order_temp_detail_barcode[key]["detail_order_num"]
        }
        $("#chuku_list_barcode").prepend(get_chuku_barcode_str(info));
    }

    var order_sum=0;
    var order_total_money=0;
    $(".chuku_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#chuku_total_num').html(order_sum);
    $('#chuku_total_money').html(parseFloat(order_total_money.toFixed(2)));
    $('#chuku_notice_count').html(order_sum);
    <?php
    }
    ?>

    //setTimeout("$('#saoma_chuku_barcode').focus()",0);

    $("#saoma_chuku_barcode").keyup(function(e){

        if (chuku_product_system_barcode[$(this).val()] || chuku_product_customize_barcode[$(this).val()])
        {
            if (chuku_product_system_barcode[$(this).val()])
            {
                var info={
                    "huohao":chuku_product_system_barcode[$(this).val()]["p_barcode_huohao"],
                    "color":chuku_product_system_barcode[$(this).val()]["p_barcode_color"],
                    "size":chuku_product_system_barcode[$(this).val()]["p_barcode_size"],
                    "price": chuku_product_system_barcode[$(this).val()]["p_seller_price"],
                    "barcode":chuku_product_system_barcode[$(this).val()]["p_barcode_bianhao"],
                    "p_bianhao":chuku_product_system_barcode[$(this).val()]["p_barcode_p_bianhao"],
                    "p_type_bianhao":chuku_product_system_barcode[$(this).val()]["p_barcode_p_type_bianhao"],
                    "factory_bianhao":chuku_product_system_barcode[$(this).val()]["p_barcode_factory_bianhao"],
                    "factory_name":chuku_product_system_barcode[$(this).val()]["p_barcode_factory_name"],
                    "valueprice":chuku_product_system_barcode[$(this).val()]["p_barcode_valueprice"],
                    "factory_mode":chuku_product_system_barcode[$(this).val()]["p_barcode_factory_mode"],
                    "factory_cycle":chuku_product_system_barcode[$(this).val()]["p_barcode_factory_cycle"],
                    "num":1
                }
            }
            else if (chuku_product_customize_barcode[$(this).val()])
            {
                var info={
                    "huohao":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_huohao"],
                    "color":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_color"],
                    "size":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_size"],
                    "price": chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_seller_price"],
                    "barcode":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_bianhao"],
                    "p_bianhao":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_p_bianhao"],
                    "p_type_bianhao":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_p_type_bianhao"],
                    "factory_bianhao":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_factory_bianhao"],
                    "factory_name":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_factory_name"],
                    "valueprice":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_valueprice"],
                    "factory_mode":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_factory_mode"],
                    "factory_cycle":chuku_product_system_barcode[chuku_product_customize_barcode[$(this).val()]]["p_barcode_factory_cycle"],
                    "num":1
                }
            }


            $("#chuku_list_barcode").prepend(get_chuku_barcode_str(info));
            var order_sum=0;
            var order_total_money=0;
            $(".chuku_order_num").each(function(){
               order_sum += parseInt($(this).val());
               order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
            })

            $('#chuku_total_num').html(order_sum);
            $('#chuku_total_money').html(parseFloat(order_total_money.toFixed(2)));
            $('#chuku_notice_count').html(order_sum);
            $(this).val("");
            num_sound.play_sound(parseInt(order_sum));
        }
        if(e.keyCode==13){
            //if($(this).val()==""){
            //    $("#btn_chuku_putintoorderlist").click();
            //}
            //$(this).val("");
        }
    });

    $('#select_chuku_order_nocycle_is_pay').click(function(){
        if ($(this).is(":checked"))
        {
            $("#chuku_order_is_pay").val(0);
        }
        else
        {
            $("#chuku_order_is_pay").val(1);
        }
    });
    
    $('#select_chuku_order_cycle_is_pay').click(function(){
        if ($(this).is(":checked"))
        {
            $("#chuku_order_is_pay").val(1);
        }
        else
        {
            $("#chuku_order_is_pay").val(0);
        }
    });
        
    $('#btn_chuku_putintoorderlist').click(function(){
        if($(".chuku_order_num").length==0)
        {
            alert("暂无商品");
            return false;
        }
        
                
        $.ajax({
            url:"model-order-post", 
            async: false,
            type: "POST",
            dataType:"json",
            data:$('#chuku_order_form').serialize(),
            success: function(html){
                if (html.state!="ok"){
                        layer.msg("提交订单失败！", {time: 2000, icon:2});
                        return false;
                }
                
                chuku_order_seller_bianhao="";
                chuku_order_seller_name="";
                chuku_order_seller_cycle="";
                
                $('#chuku_step_main').hide();    
                $('#chuku_step_saving').show();
                
                mount_to_frame("view_sales_cashier",1,"frame_sales_cashier");
            }
        });        
    });
    $("#btn_temp_chuku_putintoorderlist").mouseover(function(){
        $(this).css("background","#555C6F");
    }).mouseout(function(){
        $(this).css("background","#37424F");
    });
    $('#btn_temp_chuku_putintoorderlist').click(function(){
        if($(".chuku_order_num").length==0)
        {
            alert("暂无商品");
            return false;
        }
        
        $("#chuku_order_type").val("xsckgq");
                
        $.ajax({
            url:"model-order-post", 
            async: false,
            type: "POST",
            dataType:"json",
            data:$('#chuku_order_form').serialize(),
            success: function(html){
                if (html.state!="ok"){
                    layer.msg("提交订单失败！", {time: 2000, icon:2});
                    return false;
                }
                
                chuku_order_seller_bianhao="";
                chuku_order_seller_name="";
                chuku_order_seller_cycle="";
                
                $('#chuku_step_main').hide();    
                $('#chuku_step_saving').show();
                
                mount_to_frame("view_sales_cashier",1,"frame_sales_cashier");
            }
        });        
    });
});

function setChukuListPriceModify(obj)
{
    $(".chuku_order_p_bianhao").each(function(){
        if ( $(this).val()==obj.next().next().val() )
        {
            $(this).prev().prev().val(obj.val());
        }
    })
    
    var order_total_money=0;
    $(".chuku_order_num").each(function(){
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#chuku_total_money').html(parseFloat(order_total_money.toFixed(2)));
    
    for (key in chuku_product_system_barcode)
    {
        if ( chuku_product_system_barcode[key]["p_barcode_p_bianhao"]==obj.next().next().val() )
        {
            chuku_product_system_barcode[key]["p_seller_price"]=obj.val();
        }
    }

    $.ajax({
        url:"set-sellerpricemodify", 
        async: false,
        type: "POST",
        data:{var_seller_bianhao:chuku_order_seller_bianhao,var_seller_name:chuku_order_seller_name,var_product_huohao:obj.next().next().next().next().next().val(),var_modify_value:obj.val()},
        success: function(html){
        }
    });
}

function setChukuListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
    
    var order_sum=0;
    var order_total_money=0;
    $(".chuku_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#chuku_total_num').html(order_sum);
    $('#chuku_total_money').html(parseFloat(order_total_money.toFixed(2)));
    $('#chuku_notice_count').html(order_sum);
    $(this).val("");
    num_sound.play_sound(parseInt(order_sum));
}

function setChukuListAmountReduce(obj)
{
    if ((parseInt(obj.val())-1)<1)
    {
        alert("拿货数量不能小于1！");
        obj.val("1");
    }
    else
    {
        obj.val(parseInt(obj.val())-1);    
    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".chuku_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#chuku_total_num').html(order_sum);
    $('#chuku_total_money').html(parseFloat(order_total_money.toFixed(2)));
    $('#chuku_notice_count').html(order_sum);
    $(this).val("");
    num_sound.play_sound(parseInt(order_sum));
}

function setChukuListAmountModify(obj)
{
    if (parseInt(obj.val())<1)
    {
        alert("拿货数量不能小于1！");
        obj.val("1");
    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".chuku_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#chuku_total_num').html(order_sum);
    $('#chuku_total_money').html(parseFloat(order_total_money.toFixed(2)));
    $('#chuku_notice_count').html(order_sum);
    $(this).val("");
    num_sound.play_sound(parseInt(order_sum));
}

function DeleteChukuSelectProduct(obj)
{
    obj.parent().remove();

    var order_sum=0;
    var order_total_money=0;
    $(".chuku_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#chuku_total_num').html(order_sum);
    $('#chuku_total_money').html(parseFloat(order_total_money.toFixed(2)));
    $('#chuku_notice_count').html(order_sum);
    $(this).val("");
    num_sound.play_sound(parseInt(order_sum));
}

function GetChukuHuohaoByFirstchar(obj, select_chuku_firstchar)
{
    $('.select_chuku_char_radioToggle').removeClass('current');
    obj.addClass('current');


    var var_huohao_html="";                              
    var_huohao_html+="<div style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>货号：</div>";
    var_huohao_html+="<div class='choosebox'>";
    var_huohao_html+="    <ul>";
    if (chuku_gethuohaobyfirstchar[select_chuku_firstchar])
    {
        for (key in chuku_gethuohaobyfirstchar[select_chuku_firstchar])
        {
            var_huohao_html+="        <li>";
            var_huohao_html+="            <span class='select_chuku_huohao_radioToggle' onclick='/**/GetChukuFactoryByHuohao($(this), \"" + chuku_gethuohaobyfirstchar[select_chuku_firstchar][key] + "\")'>" + chuku_gethuohaobyfirstchar[select_chuku_firstchar][key] + "</span>";
            var_huohao_html+="        </li>";
        }
    }
    
    var_huohao_html+="    </ul>";
    var_huohao_html+="</div>";



    $("#select_chuku_huohao").html(var_huohao_html);
    $("#select_chuku_huohao").hide();
    
    $("#select_chuku_factory").html("");
    $("#select_chuku_factory").hide();

    $("#select_chuku_color").html("");
    $("#select_chuku_color").hide();
    
    $("#select_chuku_size").html("");
    $("#select_chuku_size").hide();
    
    $("#select_chuku_order").hide();    
}

function GetChukuFactoryByHuohao(select_chuku_huohao)
{
	var count_getfactorybyhuohao=0;
	var firstvalue_getfactorybyhuohao="";
	//alert(select_chuku_huohao);

	for (key in chuku_getproductdetailbyhuohao[select_chuku_huohao])
	{
		if (count_getfactorybyhuohao==0)
		{
			firstvalue_getfactorybyhuohao=key;
		}
		
		count_getfactorybyhuohao++;
	}
    
    if (count_getfactorybyhuohao==1)
    {
        $("#select_chuku_factory").html("");
        $("#select_chuku_factory").hide();
        
        $("#select_chuku_color").html("");
        $("#select_chuku_color").hide();
        
        $("#select_chuku_size").html("");
        $("#select_chuku_size").hide();
        
        $("#select_chuku_order").hide();
        
        GetChukuColorByHuohaoFactory(null,select_chuku_huohao, firstvalue_getfactorybyhuohao);
    }
    else
    {    
        var var_factory_html="";                          
        var_factory_html+="<div class='ifactory'  style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:none;'>工厂：</div>";
        var_factory_html+="<div class='choosebox'>";
        var_factory_html+="    <ul>";
        for (key in chuku_getproductdetailbyhuohao[select_chuku_huohao])
        {
            var_factory_html+="        <li>";
            var_factory_html+="            <span class='select_chuku_factory_radioToggle' onclick='/**/GetChukuColorByHuohaoFactory($(this), \"" + select_chuku_huohao + "\", \"" + key + "\")'>" + key + "</span>";
            var_factory_html+="        </li>";
        }
        var_factory_html+="    </ul>";
        var_factory_html+="</div>";

        $("#select_chuku_factory").html(var_factory_html);

        $("#select_chuku_factory").show();
        if($(".select_chuku_factory_radioToggle").css("display")=="block"){
            $(".ifactory").show();
        }

        $("#select_chuku_color").html("");
        $("#select_chuku_color").hide();
        
        $("#select_chuku_size").html("");
        $("#select_chuku_size").hide();
        
        $("#select_chuku_order").hide();
    }
}
var has_click=0;
function GetChukuColorByHuohaoFactory(obj, select_chuku_huohao, select_chuku_factory)
{
    $('.select_chuku_factory_radioToggle').removeClass('current');
    if (obj!=null){
        obj.addClass('current');
        has_click=1;
    }

    var var_factorycolor_html="";                              
    var_factorycolor_html+="<div style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>颜色：</div>";
    var_factorycolor_html+="<div class='choosebox'>";
    var_factorycolor_html+="    <ul>";
    for (key in chuku_getproductdetailbyhuohao[select_chuku_huohao][select_chuku_factory])
    {
        var_factorycolor_html+="        <li>";
        var_factorycolor_html+="            <span class='select_chuku_color_radioToggle' onclick='/**/GetChukuSizeByHuohaoFactoryColor($(this), \"" + select_chuku_huohao + "\", \"" + select_chuku_factory + "\", \"" + key + "\")'>" + key + "</span>";
        var_factorycolor_html+="        </li>";
    }
    var_factorycolor_html+="    </ul>";
    var_factorycolor_html+="</div>";

    $("#select_chuku_color").html(var_factorycolor_html);
    $("#select_chuku_color").show();
    
    $("#select_chuku_size").html("");
    $("#select_chuku_size").hide();
    
    $("#select_chuku_order").hide();
}

function GetChukuSizeByHuohaoFactoryColor(obj, select_chuku_huohao, select_chuku_factory, select_chuku_color)
{
    $('.select_chuku_color_radioToggle').removeClass('current');
        obj.addClass('current');

    var var_colorsize_html="";                              
    var_colorsize_html+="<div style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>尺码：</div>";
    var_colorsize_html+="<div class='addchoosebox'>";
    var_colorsize_html+="    <ul>";
    for (key in chuku_getproductdetailbyhuohao[select_chuku_huohao][select_chuku_factory][select_chuku_color])
    {
        var_colorsize_html+="        <li>";
        var_colorsize_html+="            <span class='select_chuku_size_radioToggle canaddcurrent' onclick='/**/GetChukuBarcodeByHuohaoFactoryColorSize($(this), \"" + select_chuku_huohao + "\", \"" + select_chuku_factory + "\", \"" + select_chuku_color + "\", \"" + key + "\")'>" + key + "</span>";
        var_colorsize_html+="        </li>";
    }
    var_colorsize_html+="    </ul>";
    var_colorsize_html+="</div>";
            
    $("#select_chuku_size").html(var_colorsize_html);
    $("#select_chuku_size").show();
    
    $("#select_chuku_order").hide();    
}

function GetChukuBarcodeByHuohaoFactoryColorSize(obj, select_chuku_huohao, select_chuku_factory, select_chuku_color, select_chuku_size)
{
    $('.select_chuku_size_radioToggle').removeClass('current');
    $('.select_chuku_size_radioToggle').addClass('canaddcurrent');
    obj.removeClass('canaddcurrent');
    obj.addClass('currentclick');
    
    setTimeout(function(){
        obj.removeClass('currentclick');
        obj.addClass('current');
    },100);
    
    var select_chuku_price_input_html;
    if (parseInt(chuku_order_seller_bianhao)>1)
    {    
        select_chuku_price_input_html="<input id='select_chuku_order_price' type='text' maxlength='100' style='width:50px; padding:5px; background:#dddddd; border:0; font-size:14px; font-weight:bold; color:#ee583d' onKeyUp='/**/setSelectChukuListPriceModify($(this))'>";
    }
    else
    {
        select_chuku_price_input_html="<input id='select_chuku_order_price' type='text' maxlength='100' style='width:50px; padding:5px; background:#ffffff; border:0; font-size:14px; font-weight:bold; color:#ee583d' onKeyUp='/**/setSelectChukuListPriceModify($(this))' readonly>";
    }
    
    if ($("#chuku_list_barcode").html()!="" && $("#chuku_list_barcode").children(":eq(0)").children(":eq(3)").children(":eq(1)").val()==chuku_getproductdetailbyhuohao[select_chuku_huohao][select_chuku_factory][select_chuku_color][select_chuku_size])
    {
        $("#chuku_list_barcode").children(":eq(0)").children(":eq(4)").children(":eq(0)").children(":eq(1)").val(parseInt($("#chuku_list_barcode").children(":eq(0)").children(":eq(4)").children(":eq(0)").children(":eq(1)").val())+1)
    }
    else
    {
        var key=chuku_getproductdetailbyhuohao[select_chuku_huohao][select_chuku_factory][select_chuku_color][select_chuku_size];
        var info={
            "huohao":chuku_product_system_barcode[key]["p_barcode_huohao"],
            "color":chuku_product_system_barcode[key]["p_barcode_color"],
            "size":chuku_product_system_barcode[key]["p_barcode_size"],
            "price": chuku_product_system_barcode[key]["p_seller_price"], 
            "barcode":key, 
            "p_bianhao":chuku_product_system_barcode[key]["p_barcode_p_bianhao"], 
            "p_type_bianhao":chuku_product_system_barcode[key]["p_barcode_p_type_bianhao"], 
            "factory_bianhao":chuku_product_system_barcode[key]["p_barcode_factory_bianhao"], 
            "factory_name":chuku_product_system_barcode[key]["p_barcode_factory_name"], 
            "valueprice":chuku_product_system_barcode[key]["p_barcode_valueprice"], 
            "factory_mode":chuku_product_system_barcode[key]["p_barcode_factory_mode"], 
            "factory_cycle":chuku_product_system_barcode[key]["p_barcode_factory_cycle"], 
            "num":1
        }
        $("#chuku_list_barcode").prepend(get_chuku_barcode_str(info));

    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".chuku_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#chuku_total_num').html(order_sum);
    $('#chuku_total_money').html(parseFloat(order_total_money.toFixed(2)));
    $('#chuku_notice_count').html(order_sum);
    num_sound.play_sound(parseInt(order_sum));
}
setTimeout("$('#saoma_chuku_barcode').focus()",0);

var letters="";
for(var key in chuku_gethuohaobyfirstchar ){
    letters+=key;
}


$(".ikeyboard").init_ikeyboard(letters);//初始化键盘

function click_keyboard(pid)
{
    if (has_click==1){
        $(".ikeyboard").clear_ikeyboard();
        has_click=0;
    }
    //console.log(pid);
    /**/GetChukuFactoryByHuohao(pid);
}
$(".iadditem").init_iadditem(chuku_select_storewarehouse_bianhao);//添加自定义货号
</script>

