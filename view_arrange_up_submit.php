<?php

include_once("check_dangkou_user.php");
?>
                <div style=" float:left; width:98%; margin-top:0px; padding:15px 1%; background:#ffffff; overflow:hidden; display:block">
                    <div id="step_arrange_up_main" style="width:100%; display:block">
                        <div style="float:left; width:100%; margin:10px 0; overflow:hidden; display:block">
                            <div style="float:left; width:30%; overflow:hidden; display:block">
                                <div id="arrangeup_storewarehouse_name" style="float:left; margin-left:35px; margin-top:30px"></div>
                            </div>
                            <div style="float:left; width:55%; overflow:hidden; display:block">
                                <div style="float:right">
                                    <span style="float:left; margin-left:10px"><input id="saoma_arrange_up_barcode" class="ibarcode"  name="saoma_arrange_up_barcode" type="text" size="30" maxlength="100" style="width:300px; padding:5px; font-size:24px; height:35px;margin-top: 2px;" placeholder="扫码上架" onclick="VVIP_INPUT='#saoma_arrange_up_barcode'" onblur="$(VVIP_INPUT).focus();"></span>
                                    <span id="arrange_up_notice_count" class="inoticecount" style="float:left; margin-left:10px; padding:8px 10px; font-size:35px; font-weight:bold; color:#ffffff; background:#d64126; overflow:hidden; display:block">0</span>
                                </div>
                            </div>
                            <div style="float:left; width:15%; overflow:hidden; display:block">
                                <div style="float:right; width:100px; margin-right:35px; margin-top:20px">
                                    <span class="btn_normal_blue" onclick="/**/mount_to_frame('view_arrange_up',1,'frame_arrange_up')">放弃返回</span>
                                </div>
                            </div>
                        </div>
                        <div style="width:98%; margin:0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
                            <div id="arrange_uporderlist_left" style="float:left; width:53%; min-height:420px; padding:0 1%; border-right:1px solid #cccccc; overflow:hidden; display:block">

                                <div style="float:left; width:98%; padding:10px 1%">
                                    <span style="float:left">已选择商品列表</span>
                                    <span style="float:right">
                                        <span style="font-size:18px; color:#999999">数量总计：<span id="arrange_up_total_num" class="itotalnum" style="font-size:24px; color:#ee583d">0</span></span>
                                    </span>
                                </div>
                                <form method="post" id="arrange_up_order_form">
                                <div style="overflow-y:auto; overflow-x:hidden; max-height:380px;float:left; width:98%; padding:5px 1%; display:block">
                                    <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
                                        <div style="float:left; width:40%; font-size:12px; color:#999999">货号</div>
                                        <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">颜色</div>
                                        <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">尺码</div>
                                        <div style="float:left; width:30%; font-size:12px; color:#999999; text-align:center">数量</div>
                                        <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">删除</div>
                                    </div>
                                    <div id="arrange_up_list_barcode"  style="width:100%; overflow:hidden; display:block;"></div>
                                </div>
                                <div id="arrange_up_seller_nocycle_status" style="width:98%; margin:20px auto; overflow:hidden; display:none">
                                    <div style="float:right; overflow:hidden; display:block">
                                        <input id="select_arrange_up_order_is_pay" name="select_arrange_up_order_is_pay" type="checkbox" style="margin:5px" value="0" onchange="SetOrderispay($(this))"/> 未付款
                                    </div>
                                </div>
                                <div style="width:98%; margin:2px auto 0; overflow:hidden; display:block">
                                    <div style="float:right; width:150px; overflow:hidden; display:block">
                                        <div id="btn_arrange_up_putintoorderlist" class="btn_putintoorderlist">确认提交上架</div>
                                    </div>
                                </div>
                                <input type="hidden" name="order_type" value="thsj">
                                <input type="hidden" id="arrange_up_order_master_bianhao" name="order_master_bianhao">
                                <input type="hidden" id="arrange_up_order_master_name" name="order_master_name">
                                </form>                            
                            </div>
                            <div id="arrange_uporderlist_right" style="float:left; width:42%; padding:0 1%;display:block">
                            
                                <div style="float:left; width:98%; padding:10px 1%">
                                    <span style="float:left">快速选择商品</span>
                                </div>
                                <div style="float:left; width:98%; padding:5px 1%">
                                    <div style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; display:block">
                                        <div class="ikeyboard" onclick_before="/**/click_keyboard"></div>
                                        <div class="iadditem">
                                            <ul class="additem_list">
                                                <li class="additem_btn">+</li>
                                            </ul>
                                        </div>
                                        <div style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:none;">货号首字符：</div>
                                        <div class="choosebox" style="display:none;">
                                            <ul>
                                                    <li>
                                                        <span id='select_arrange_up_char_hot_huohao' class="select_arrange_up_char_radioToggle" onclick="/**/GetArrangeupHuohaoByFirstchar($(this),'HOT')">热销货号</span>
                                                    </li>
                                                    <?php
                                                    $p_firstchar=cselect("p_huohao_firstchar","ydf_products",array("p_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"p_huohao_firstchar","p_huohao_firstchar asc");
                                                    while ($rowfirstchar=$p_firstchar[0]->fetch())
                                                    {
                                                    ?>
                                                    <li>
                                                        <span class="select_arrange_up_char_radioToggle" onclick="/**/GetArrangeupHuohaoByFirstchar($(this),'<?php echo $rowfirstchar["p_huohao_firstchar"] ?>')"><?php echo $rowfirstchar["p_huohao_firstchar"] ?></span>
                                                    </li>
                                                    <?php
                                                    }
                                                    ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="select_arrange_up_huohao" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none"/>
                                    <div id="select_arrange_up_factory" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none"/>
                                    <div id="select_arrange_up_color" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none"/>
                                    <div id="select_arrange_up_size" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none" />
                                </div>
                            
                            </div>
                        
                        </div>

                    </div>
                    
                    <div id="step_arrange_up_saving" style="width:100%; overflow:hidden; display:none">
                        <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; overflow:hidden; display:block">
                            <div style="width:100%; height:100px; margin:0 auto; background:url(/pc/images/loading.gif) center center no-repeat; display:block">
                            </div>    
                        </div>
                    </div>

                </div>
            
<script type="text/javascript">    

var order_arrange_up_idx=0;
function get_arrange_up_barcode_str(info)
{
    var barcode_str = "" +
        "<div class='iedit' style='width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;'>" +
        "    <div style='float:left; width:40%; height:20px; font-size:12px; color:#999999'>"+info["huohao"]+" / "+info["factory_name"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#999999; text-align:center'>"+info["color"]+"</div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#999999; text-align:center'>"+info["size"]+"</div>" +
        "    <div style='float:left; text-align:center; display:none'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_price]' type='hidden'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_barcode]' type='hidden' value='" +info["barcode"]+ "'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_p_bianhao]' type='hidden' class='chuku_order_p_bianhao' value='" +info["p_bianhao"]+ "'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_p_type_bianhao]' type='hidden' value='" +info["p_type_bianhao"]+ "'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_factory_bianhao]' type='hidden' value='" +info["factory_bianhao"]+ "'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_huohao]' type='hidden' value='" +info["huohao"]+ "'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_color]' type='hidden' value='" +info["color"]+ "'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_size]' type='hidden' value='" +info["size"]+ "'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_valueprice]' type='hidden' value='" +info["valueprice"]+ "'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_factory_mode]' type='hidden' value='" +info["factory_mode"]+ "'>"+
        "       <input name='table["+order_arrange_up_idx+"][order_factory_cycle]' type='hidden' value='" +info["factory_cycle"]+ "'>"+
        "   </div>" +
        "    <div style='float:left; width:30%; height:20px; font-size:12px; color:#999999; text-align:center'>" +
        "        <span class='add_chose'>" +
        "            <span class='reduce' onclick='/**/setArrangeupListAmountReduce($(this).parent().children(\":eq(1)\"))'/>" +
        "                <input name='table["+order_arrange_up_idx+"][order_num]' class='arrange_up_order_num text12 iedit_num' value='" +info["num"]+ "' errmsg='iedit_num' type='text' onKeyUp='/**/setArrangeupListAmountModify($(this))'>" +
        "            <span class='add' onclick='/**/setArrangeupListAmountAdd($(this).parent().children(\":eq(1)\"))'/>" +
        "        </span>" +
        "    </div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#3366FF; text-align:center; cursor:pointer' onclick='/**/DeleteArrangeupSelectProduct($(this))'>删除</div>" +
        "</div>";                        
    order_arrange_up_idx++;
    return barcode_str;
}

var arrange_up_product_system_barcode;
var arrange_up_product_customize_barcode;
var arrange_up_gethuohaobyfirstchar;
var arrange_up_getproductdetailbyhuohao;
    
$(function(){
    if (arrange_up_select_storewarehouse_bianhao!="")
    {
        $("#arrange_up_order_master_bianhao").val(arrange_up_select_storewarehouse_bianhao);
        $("#arrange_up_order_master_name").val(arrange_up_select_storewarehouse_name);
    }
    
    if (parseInt(arrange_up_select_storewarehouse_type)==1)
    {
        $("#arrangeup_storewarehouse_name").html("上架档口：<span style='font-size:16px; font-weight:bold'>"+arrange_up_select_storewarehouse_name+"</span>");
    }
    else if (parseInt(arrange_up_select_storewarehouse_type)==2)
    {
        $("#arrangeup_storewarehouse_name").html("上架仓库：<span style='font-size:16px; font-weight:bold'>"+arrange_up_select_storewarehouse_name+"</span>");
    }

    $.ajax({
        url:"get-allproductsbarcode", 
        async: false,
        type: "POST",
        data:"",
        dataType:"json",
        success: function(html){
            arrange_up_gethuohaobyfirstchar=html["char_idx"];
            arrange_up_getproductdetailbyhuohao=html["product_idx"];
            arrange_up_product_system_barcode = html["product_system_barcode"];
            arrange_up_product_customize_barcode = html["product_customize_barcode"];
        }
    });
                    
    GetArrangeupHuohaoByFirstchar($("#select_arrange_up_char_hot_huohao"), "HOT")

    setTimeout("$('#saoma_arrange_up_barcode').focus()",0);
    
    $("#saoma_arrange_up_barcode").keyup(function(e){
        if (arrange_up_product_system_barcode[$(this).val()] || arrange_up_product_customize_barcode[$(this).val()])
        {
            if (arrange_up_product_system_barcode[$(this).val()])
            {
                var info={
                    "huohao":arrange_up_product_system_barcode[$(this).val()]["p_barcode_huohao"],
                    "color":arrange_up_product_system_barcode[$(this).val()]["p_barcode_color"],
                    "size":arrange_up_product_system_barcode[$(this).val()]["p_barcode_size"],
                    "price": arrange_up_product_system_barcode[$(this).val()]["p_seller_price"], 
                    "barcode":arrange_up_product_system_barcode[$(this).val()]["p_barcode_bianhao"],
                    "p_bianhao":arrange_up_product_system_barcode[$(this).val()]["p_barcode_p_bianhao"], 
                    "p_type_bianhao":arrange_up_product_system_barcode[$(this).val()]["p_barcode_p_type_bianhao"], 
                    "factory_bianhao":arrange_up_product_system_barcode[$(this).val()]["p_barcode_factory_bianhao"], 
                    "factory_name":arrange_up_product_system_barcode[$(this).val()]["p_barcode_factory_name"], 
                    "valueprice":arrange_up_product_system_barcode[$(this).val()]["p_barcode_valueprice"], 
                    "factory_mode":arrange_up_product_system_barcode[$(this).val()]["p_barcode_factory_mode"], 
                    "factory_cycle":arrange_up_product_system_barcode[$(this).val()]["p_barcode_factory_cycle"], 
                    "num":1
                }
            }
            else if (arrange_up_product_customize_barcode[$(this).val()])
            {
                var info={
                    "huohao":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_huohao"],
                    "color":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_color"],
                    "size":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_size"],
                    "price": arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_seller_price"], 
                    "barcode":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_bianhao"],
                    "p_bianhao":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_p_bianhao"], 
                    "p_type_bianhao":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_p_type_bianhao"], 
                    "factory_bianhao":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_factory_bianhao"], 
                    "factory_name":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_factory_name"], 
                    "valueprice":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_valueprice"], 
                    "factory_mode":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_factory_mode"], 
                    "factory_cycle":arrange_up_product_system_barcode[arrange_up_product_customize_barcode[$(this).val()]]["p_barcode_factory_cycle"], 
                    "num":1
                }
            }
            
            $("#arrange_up_list_barcode").prepend(get_arrange_up_barcode_str(info));
            var order_sum=0;
            var order_total_money=0;
            $(".arrange_up_order_num").each(function(){
               order_sum += parseInt($(this).val());
               order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
            })
    
            $('#arrange_up_total_num').html(order_sum);
            $('#arrange_up_notice_count').html(order_sum);
            $(this).val("");
        }
        if(e.keyCode==13){
            //if($(this).val()==""){
            //    $("#btn_arrange_up_putintoorderlist").click();
            //}
            //$(this).val("");
        }
    });
    
    $('#btn_arrange_up_putintoorderlist').click(function(){
        if($(".arrange_up_order_num").length==0)
        {
            alert("暂无商品");
            return false;
        }
        
                
        $.ajax({
            url:"model-order-post", 
            async: false,
            type: "POST",
            dataType:"json",
            data:$('#arrange_up_order_form').serialize(),
            success: function(html){
                if (html.state!="ok"){
                    layer.msg('提交订单失败！', {time: 2000, icon:2});
                    return false;
                }
                
                arrange_up_order_opt_type="";
                arrange_up_order_seller_bianhao="";
                arrange_up_order_seller_name="";
                arrange_up_order_seller_cycle="";
                
                $('#step_arrange_up_main').hide();    
                $('#step_arrange_up_saving').show();
                
                layer.msg('订单提交成功！', {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame("view_arrange_up",1,"frame_arrange_up");
                },2000);
            }
        });        
    });
});

function SetOrderispay(obj)
{
    if (obj.is(":checked"))
    {
        $("#arrange_up_order_is_pay").val(obj.val());
    }
    else
    {
        if (parseInt(arrange_up_order_seller_cycle)>0)
        {
            $("#arrange_up_order_is_pay").val(0);
        }
        else
        {
            $("#arrange_up_order_is_pay").val(1);
        }
    }
}

function setArrangeupListPriceModify(obj)
{
    $(".arrange_up_order_p_bianhao").each(function(){
        if ( $(this).val()==obj.next().next().val() )
        {
            $(this).prev().prev().val(obj.val());
        }
    })
    
    if ( $("#select_arrange_up_order_price") && obj.next().next().val()==$("#select_arrange_up_order_p_bianhao").val() )
    {
        $("#select_arrange_up_order_price").val(obj.val());
    }
    
    var order_total_money=0;
    $(".arrange_up_order_num").each(function(){
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#arrange_up_total_money').html(parseFloat(order_total_money.toFixed(2)));
    
    for (key in arrange_up_product_system_barcode)
    {
        if ( arrange_up_product_system_barcode[key]["p_barcode_p_bianhao"]==obj.next().next().val() )
        {
            arrange_up_product_system_barcode[key]["p_seller_price"]=obj.val();
        }
    }
    
    $.ajax({
        url:"set-arrange_upsellerpricemodify", 
        async: false,
        type: "POST",
        data:{var_product_bianhao:obj.next().next().val(),var_product_huohao:obj.next().next().next().next().next().val(),var_modify_value:obj.val()},
        success: function(html){
        }
    });
}

function setSelectArrangeupListPriceModify(obj)
{
    $(".arrange_up_order_p_bianhao").each(function(){
        if ( $(this).val()==$("#select_arrange_up_order_p_bianhao").val() )
        {
            $(this).prev().prev().val(obj.val());
        }
    })
    
    var order_total_money=0;
    $(".arrange_up_order_num").each(function(){
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#arrange_up_total_money').html(parseFloat(order_total_money.toFixed(2)));
    
    for (key in arrange_up_product_system_barcode)
    {
        if ( arrange_up_product_system_barcode[key]["p_barcode_p_bianhao"]==$("#select_arrange_up_order_p_bianhao").val() )
        {
            arrange_up_product_system_barcode[key]["p_seller_price"]=obj.val();
        }
    }
    
    $.ajax({
        url:"set-arrange_upsellerpricemodify", 
        async: false,
        type: "POST",
        data:{var_product_bianhao:$("#select_arrange_up_order_p_bianhao").val(),var_product_huohao:$("#select_arrange_up_order_huohao").val(),var_modify_value:obj.val()},
        success: function(html){
        }
    });
}

function setArrangeupListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
    
    var order_sum=0;
    var order_total_money=0;
    $(".arrange_up_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#arrange_up_total_num').html(order_sum);
    $('#arrange_up_notice_count').html(order_sum);
    $(this).val("");
}

function setArrangeupListAmountReduce(obj)
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
    $(".arrange_up_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#arrange_up_total_num').html(order_sum);
    $('#arrange_up_notice_count').html(order_sum);
    $(this).val("");
}

function setArrangeupListAmountModify(obj)
{
    if (parseInt(obj.val())<1)
    {
        alert("拿货数量不能小于1！");
        obj.val("1");
    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".arrange_up_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#arrange_up_total_num').html(order_sum);
    $('#arrange_up_notice_count').html(order_sum);
    $(this).val("");
}

function DeleteArrangeupSelectProduct(obj)
{
    obj.parent().remove();

    var order_sum=0;
    var order_total_money=0;
    $(".arrange_up_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().val());
    })

    $('#arrange_up_total_num').html(order_sum);
    $('#arrange_up_notice_count').html(order_sum);
    $(this).val("");
}

function GetArrangeupHuohaoByFirstchar(obj, select_arrange_up_firstchar)
{
    $('.select_arrange_up_char_radioToggle').removeClass('current');
    obj.addClass('current');


    var var_huohao_html="";                              
    var_huohao_html+="<div style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>货号：</div>";
    var_huohao_html+="<div class='choosebox'>";
    var_huohao_html+="    <ul>";
    if (arrange_up_gethuohaobyfirstchar[select_arrange_up_firstchar])
    {
        for (key in arrange_up_gethuohaobyfirstchar[select_arrange_up_firstchar])
        {
            var_huohao_html+="        <li>";
            var_huohao_html+="            <span class='select_arrange_up_huohao_radioToggle' onclick='/**/GetArrangeupFactoryByHuohao($(this), \"" + arrange_up_gethuohaobyfirstchar[select_arrange_up_firstchar][key] + "\")'>" + arrange_up_gethuohaobyfirstchar[select_arrange_up_firstchar][key] + "</span>";
            var_huohao_html+="        </li>";
        }
    }
    
    var_huohao_html+="    </ul>";
    var_huohao_html+="</div>";

    $("#select_arrange_up_huohao").html(var_huohao_html);
    $("#select_arrange_up_huohao").hide();//暂时隐藏，需要删除的
    
    $("#select_arrange_up_factory").html("");
    $("#select_arrange_up_factory").hide();

    $("#select_arrange_up_color").html("");
    $("#select_arrange_up_color").hide();
    
    $("#select_arrange_up_size").html("");
    $("#select_arrange_up_size").hide();
    
    $("#select_arrange_up_order").hide();    
}

function GetArrangeupFactoryByHuohao(obj, select_arrange_up_huohao)
{
    $('.select_arrange_up_huohao_radioToggle').removeClass('current');
    //obj.addClass('current');
    
    var count_getfactorybyhuohao=0;
    var firstvalue_getfactorybyhuohao="";
    
    for (key in arrange_up_getproductdetailbyhuohao[select_arrange_up_huohao])
    {
        if (count_getfactorybyhuohao==0)
        {
            firstvalue_getfactorybyhuohao=key;
        }
        
        count_getfactorybyhuohao++;
    }
    
    if (count_getfactorybyhuohao==1)
    {
        $("#select_arrange_up_factory").html("");
        $("#select_arrange_up_factory").hide();
        
        $("#select_arrange_up_color").html("");
        $("#select_arrange_up_color").hide();
        
        $("#select_arrange_up_size").html("");
        $("#select_arrange_up_size").hide();
        
        $("#select_arrange_up_order").hide();
        
        GetArrangeupColorByHuohaoFactory(obj, select_arrange_up_huohao, firstvalue_getfactorybyhuohao);
    }
    else
    {    
        var var_factory_html="";                          
        var_factory_html+="<div class='ifactory' style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:none;'>工厂：</div>";
        var_factory_html+="<div class='choosebox'>";
        var_factory_html+="    <ul>";
        for (key in arrange_up_getproductdetailbyhuohao[select_arrange_up_huohao])
        {
            var_factory_html+="        <li>";
            var_factory_html+="            <span class='select_arrange_up_factory_radioToggle' onclick='/**/GetArrangeupColorByHuohaoFactory($(this), \"" + select_arrange_up_huohao + "\", \"" + key + "\")'>" + key + "</span>";
            var_factory_html+="        </li>";
        }
        var_factory_html+="    </ul>";
        var_factory_html+="</div>";
            
        $("#select_arrange_up_factory").html(var_factory_html);
        $("#select_arrange_up_factory").show();

        if($(".select_arrange_up_factory_radioToggle").css("display")=="block"){//同步厂家显示
            $(".ifactory").show();
        }
        
        $("#select_arrange_up_color").html("");
        $("#select_arrange_up_color").hide();
        
        $("#select_arrange_up_size").html("");
        $("#select_arrange_up_size").hide();
        
        $("#select_arrange_up_order").hide();
    }
}

var has_isclick=0;
function GetArrangeupColorByHuohaoFactory(obj, select_arrange_up_huohao, select_arrange_up_factory)
{
    $('.select_arrange_up_factory_radioToggle').removeClass('current');
    if(obj!=null){
        obj.addClass('current');
        has_isclick=1;
    }
    var var_factorycolor_html="";                              
    var_factorycolor_html+="<div style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>颜色：</div>";
    var_factorycolor_html+="<div class='choosebox'>";
    var_factorycolor_html+="    <ul>";
    for (key in arrange_up_getproductdetailbyhuohao[select_arrange_up_huohao][select_arrange_up_factory])
    {
        var_factorycolor_html+="        <li>";
        var_factorycolor_html+="            <span class='select_arrange_up_color_radioToggle' onclick='/**/GetArrangeupSizeByHuohaoFactoryColor($(this), \"" + select_arrange_up_huohao + "\", \"" + select_arrange_up_factory + "\", \"" + key + "\")'>" + key + "</span>";
        var_factorycolor_html+="        </li>";
    }
    var_factorycolor_html+="    </ul>";
    var_factorycolor_html+="</div>";
                
    $("#select_arrange_up_color").html(var_factorycolor_html);
    $("#select_arrange_up_color").show();
    
    $("#select_arrange_up_size").html("");
    $("#select_arrange_up_size").hide();
    
    $("#select_arrange_up_order").hide();
}

function GetArrangeupSizeByHuohaoFactoryColor(obj, select_arrange_up_huohao, select_arrange_up_factory, select_arrange_up_color)
{
    $('.select_arrange_up_color_radioToggle').removeClass('current');
    obj.addClass('current');

    var var_colorsize_html="";                              
    var_colorsize_html+="<div style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>尺码：</div>";
    var_colorsize_html+="<div class='addchoosebox'>";
    var_colorsize_html+="    <ul>";
    for (key in arrange_up_getproductdetailbyhuohao[select_arrange_up_huohao][select_arrange_up_factory][select_arrange_up_color])
    {
        var_colorsize_html+="        <li>";
        var_colorsize_html+="            <span class='select_arrange_up_size_radioToggle canaddcurrent' onclick='/**/GetArrangeupBarcodeByHuohaoFactoryColorSize($(this), \"" + select_arrange_up_huohao + "\", \"" + select_arrange_up_factory + "\", \"" + select_arrange_up_color + "\", \"" + key + "\")'>" + key + "</span>";
        var_colorsize_html+="        </li>";
    }
    var_colorsize_html+="    </ul>";
    var_colorsize_html+="</div>";
            
    $("#select_arrange_up_size").html(var_colorsize_html);
    $("#select_arrange_up_size").show();
    
    $("#select_arrange_up_order").hide();    
}

function GetArrangeupBarcodeByHuohaoFactoryColorSize(obj, select_arrange_up_huohao, select_arrange_up_factory, select_arrange_up_color, select_arrange_up_size)
{
    $('.select_arrange_up_size_radioToggle').removeClass('current');
    $('.select_arrange_up_size_radioToggle').addClass('canaddcurrent');
    obj.removeClass('canaddcurrent');
    obj.addClass('currentclick');
    
    setTimeout(function(){
        obj.removeClass('currentclick');
        obj.addClass('current');
    },100);
    
    if ($("#arrange_up_list_barcode").html()!="" && $("#arrange_up_list_barcode").children(":eq(0)").children(":eq(3)").children(":eq(1)").val()==arrange_up_getproductdetailbyhuohao[select_arrange_up_huohao][select_arrange_up_factory][select_arrange_up_color][select_arrange_up_size])
    {
        $("#arrange_up_list_barcode").children(":eq(0)").children(":eq(4)").children(":eq(0)").children(":eq(1)").val(parseInt($("#arrange_up_list_barcode").children(":eq(0)").children(":eq(4)").children(":eq(0)").children(":eq(1)").val())+1)
    }
    else
    {
        var key=arrange_up_getproductdetailbyhuohao[select_arrange_up_huohao][select_arrange_up_factory][select_arrange_up_color][select_arrange_up_size];
        var info={
            "huohao":arrange_up_product_system_barcode[key]["p_barcode_huohao"],
            "color":arrange_up_product_system_barcode[key]["p_barcode_color"],
            "size":arrange_up_product_system_barcode[key]["p_barcode_size"],
            "barcode":key, 
            "p_bianhao":arrange_up_product_system_barcode[key]["p_barcode_p_bianhao"], 
            "p_type_bianhao":arrange_up_product_system_barcode[key]["p_barcode_p_type_bianhao"], 
            "factory_bianhao":arrange_up_product_system_barcode[key]["p_barcode_factory_bianhao"], 
            "factory_name":arrange_up_product_system_barcode[key]["p_barcode_factory_name"], 
            "valueprice":arrange_up_product_system_barcode[key]["p_barcode_valueprice"], 
            "factory_mode":arrange_up_product_system_barcode[key]["p_barcode_factory_mode"],
            "factory_cycle":arrange_up_product_system_barcode[key]["p_barcode_factory_cycle"],
            "num":1
        }
        $("#arrange_up_list_barcode").prepend(get_arrange_up_barcode_str(info));

    }
    
    var order_sum=0;
    $(".arrange_up_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#arrange_up_total_num').html(order_sum);
    $('#arrange_up_notice_count').html(order_sum);
}

var letters="";
for(var keys in arrange_up_gethuohaobyfirstchar){
    letters+=keys;
}
$(".ikeyboard").init_ikeyboard(letters);//初始化键盘
function click_keyboard(pid)
{
    if (has_isclick==1){
        $(".ikeyboard").clear_ikeyboard();
        has_isclick=0;
    }
    /**/GetArrangeupFactoryByHuohao(null, pid);
}
var chuku_select_storewarehouse_bianhao=arrange_up_select_storewarehouse_bianhao;
$(".iadditem").init_iadditem(chuku_select_storewarehouse_bianhao);//添加自定义货号
</script>
