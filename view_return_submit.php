<?php

include_once("check_dangkou_user.php");
?>
<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block;">
    <div style="float:left; margin-left:35px; margin-top:5px">
        当前卖家：<span id="tuihuoorderlist_seller_name" style="font-size:16px; font-weight:bold; color:#ee583d"></span><span id="tuihuo_note_seller_cycle" style="margin-left:10px; font-size:16px; font-weight:bold; color:#ee583d"></span>
    </div>
    <div style="float:left; margin-left:35px; margin-top:5px">
        退货销售档口：<span id="tuihuoorderlist_store_name" style="font-size:16px; font-weight:bold"></span>
    </div>
    <div style="float:right; margin-right:35px">
        <span class="btn_normal_blue" onclick="/**/mount_to_frame('view_return_list',1,'frame_return_list')">放弃返回</span>
    </div>
</div>
<div id="return_step_main" style="width:100%; overflow:hidden; display:block">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
        <div id="tuihuoorderlist_left" style="float:left; width:56%; min-height:350px; padding:0 2%; border-right:1px solid #cccccc; overflow:hidden; display:block">

            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">已选择商品列表</span>
                <span style="float:right">
                    <span style="font-size:18px; color:#999999">数量总计：<span id="tuihuo_total_num" style=" font-size:24px; color:#ee583d">0</span>, 金额总计：<span id="tuihuo_total_money" style="font-size:24px; color:#ee583d">0</span></span>
                </span>
            </div>
            <form method="post" id="tuihuo_order_form">
            <div style="overflow-y:auto; max-height:380px; float:left; width:98%; padding:5px 1%; display:block">
                <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
                    <div style="float:left; width:20%; font-size:12px; color:#999999">货号</div>
                    <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">单价</div>
                    <div style="float:left; width:40%; font-size:12px; color:#999999; text-align:center">退货数量</div>
                    <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">删除</div>
                </div>
                <div id="tuihuo_list_barcode" style="width:100%; overflow:hidden; display:block;">        
                </div>
            </div>
            <div id="tuihuo_seller_nocycle_status" style="width:98%; margin:20px auto 0 auto; overflow:hidden; display:none">
                <div style="float:right; overflow:hidden; display:block">
                    <input id="select_tuihuo_order_is_pay" type="checkbox" style="width:20px; height:20px" value="0"> <span style="font-size:24px; color:#ee583d">未付款</span>
                </div>
            </div>
            <div style="width:98%; margin:20px auto; overflow:hidden; display:block">
                <div style="float:right; width:150px; overflow:hidden; display:block">
                    <div id="btn_tuihuo_putintoorderlist" class="btn_putintoorderlist">确认提交退货</div>
                </div>
            </div>
            <input type="hidden" id="tuihuo_order_seller_bianhao" name="order_seller_bianhao">
            <input type="hidden" id="tuihuo_order_seller_name" name="order_seller_name">
            <input type="hidden" id="tuihuo_order_seller_cycle" name="order_seller_cycle">
            <input type="hidden" id="tuihuo_order_is_pay" name="order_is_pay" value="0">
            <input type="hidden" name="order_type" value="thdj">
            <input type="hidden" id="tuihuo_order_master_bianhao" name="order_master_bianhao">
            <input type="hidden" id="tuihuo_order_master_name" name="order_master_name">
            </form>
        </div>
        <div id="tuihuoorderlist_right" style="float:left; width:35%; padding:0 2%; display:block">
        
            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">快速选择商品</span>
            </div>
            <div style="float:left; width:98%; padding:5px 1%">
                <div style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc;  display:block">
                    <div class="ikeyboard ikeyboard_tuihuo" onclick_before="/**/click_keyboard" style="width:118%">
                        <span id="sure_add_huohao" class="btn_normal_red sure_add_huohao" style="float:right;margin-right:38%;height:11px;">确认</span>
                    </div>
                        <div id="iadditem" class="iadditem">
                            <ul class="additem_list">
                                <li class="additem_btn">+</li>
                            </ul>
                        </div>
                    <div style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:none;">货号首字符：</div>
                    <div class="choosebox" style="display:none;">
                        <ul>
                                <li>
                                    <span id='select_tuihuo_char_hot_huohao' class="select_tuihuo_char_radioToggle" onclick="/**/GetTuihuoHuohaoByFirstchar($(this),'HOT')">热销货号</span>
                                </li>
                                <?php
                                $p_firstchar=cselect("p_huohao_firstchar","ydf_products",array("p_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"p_huohao_firstchar","p_huohao_firstchar asc");
                                while ($rowfirstchar=$p_firstchar[0]->fetch())
                                {
                                ?>
                                <li>
                                    <span class="select_tuihuo_char_radioToggle" onclick="/**/GetTuihuoHuohaoByFirstchar($(this),'<?php echo $rowfirstchar["p_huohao_firstchar"] ?>')"><?php echo $rowfirstchar["p_huohao_firstchar"] ?></span>
                                </li>
                                <?php
                                }
                                ?>
                        </ul>
                    </div>
                </div>
                <div id="select_tuihuo_huohao" style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:none">

                </div>
                <div id="select_tuihuo_factory" style="position: relative; width:100%; margin:5px 0; padding:5px 0;border-bottom:1px dashed #cccccc; overflow:hidden; display:none">

                    
                </div>
            </div>
        
        </div>
    
    </div>

</div>

<div id="return_step_saving" style="width:100%; overflow:hidden; display:none">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; overflow:hidden; display:block">
        <div style="width:100%; height:100px; margin:0 auto; background:url(/pc/images/loading.gif) center center no-repeat; display:block">
        </div>    
    </div>
</div>
            
<script type="text/javascript">
$ ("#chuku_seller_nickname").val("");
$ (".ino_ime_proxy").val("");
$ ("#fram_search_tab").css("display","none");
$ ("#frame_tab_panel").css("display","none");
var order_return_idx=0;
function get_tuihuolist_str(info)
{
    var huohao_str = "" +
        "<div style='width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;'>" +
        "    <div style='float:left; width:20%; height:20px; font-size:12px; color:#999999'>"+info["huohao"]+" / "+info["factory_name"]+"</div>" +
        "    <div style='float:left; width:20%; height:20px; text-align:center'><span style='font-size:14px; font-weight:bold; color:#ee583d'>" +info["price"]+ "</span>"+
        "       <input name='table["+order_return_idx+"][order_price]' type='hidden' value='" +info["price"]+ "'>"+
        "       <input name='table["+order_return_idx+"][order_p_bianhao]' type='hidden' value='" +info["p_bianhao"]+ "'>"+
        "       <input name='table["+order_return_idx+"][order_huohao]' type='hidden' value='" +info["huohao"]+ "'>"+
        "       <input name='table["+order_return_idx+"][order_factory_bianhao]' type='hidden' value='" +info["factory_bianhao"]+ "'>"+
        "       <input name='table["+order_return_idx+"][order_valueprice]' type='hidden' value='" +info["valueprice"]+ "'>"+
        "       <input name='table["+order_return_idx+"][order_factory_mode]' type='hidden' value='" +info["factory_mode"]+ "'>"+
        "       <input name='table["+order_return_idx+"][order_factory_cycle]' type='hidden' value='" +info["factory_cycle"]+ "'>"+
        "   </div>" +
        "    <div style='float:left; width:40%; height:20px; font-size:12px; color:#999999; text-align:center'>" +
        "        <span class='add_chose'>" +
        "            <span class='reduce' onclick='/**/setTuihuoListAmountReduce($(this).parent().children(\":eq(1)\"))'/>" +
        "                <input name='table["+order_return_idx+"][order_num]' class='tuihuo_order_num text12' value='" +info["num"]+ "' type='text' onKeyUp='/**/setTuihuoListAmountModify($(this))'>" +
        "            <span class='add' onclick='/**/setTuihuoListAmountAdd($(this).parent().children(\":eq(1)\"))'/>" +
        "        </span>" +
        "    </div>" +
        "    <div style='float:left; width:20%; height:20px; font-size:12px; color:#3366FF; text-align:center; cursor:pointer' onclick='/**/DeleteTuihuoSelectProduct($(this))'>删除</div>" +
        "</div>";                        
    order_return_idx++;
    return huohao_str;
}

var tuihuo_gethuohaobyfirstchar;
var tuihuo_getproductdetailbyhuohao;

$(function(){
    if (tuihuo_select_storewarehouse_bianhao!="")
    {
        $("#tuihuo_order_master_bianhao").val(tuihuo_select_storewarehouse_bianhao);
        $("#tuihuo_order_master_name").val(tuihuo_select_storewarehouse_name);
        $("#tuihuoorderlist_store_name").html(tuihuo_select_storewarehouse_name);
    }
    
    if (tuihuo_order_seller_name!="")
    {
        $("#tuihuoorderlist_seller_name").html(tuihuo_order_seller_name);
    }
    else
    {
        $("#tuihuoorderlist_seller_name").html("匿名卖家");
    }
    
    if (parseInt(tuihuo_order_seller_cycle)>0)
    {
        $("#tuihuo_order_is_pay").val(0);
        $("#tuihuo_seller_nocycle_status").hide();
        $("#tuihuo_note_seller_cycle").html("[账期卖家]");
    }
    else
    {
        $("#tuihuo_order_is_pay").val(1);
        $("#tuihuo_seller_nocycle_status").show();
        $("#tuihuo_note_seller_cycle").html("");
    }
        
    $("#tuihuo_order_seller_bianhao").val(tuihuo_order_seller_bianhao);
    $("#tuihuo_order_seller_name").val(tuihuo_order_seller_name);
    $("#tuihuo_order_seller_cycle").val(tuihuo_order_seller_cycle);
    
                
    //获取点选商品列表信息
    $.ajax({
        url:"get-allproductsfactory", 
        async: false,
        type: "POST",
        data:{var_seller_bianhao:tuihuo_order_seller_bianhao},
        dataType:"json",
        success: function(html){
            tuihuo_gethuohaobyfirstchar=html["char_idx"];
            tuihuo_getproductdetailbyhuohao=html["product_idx"];
        }
    });
    
    $('#select_tuihuo_order_is_pay').click(function(){
        if ($(this).is(":checked"))
        {
            $("#tuihuo_order_is_pay").val(0);
        }
        else
        {
            $("#tuihuo_order_is_pay").val(1);
        }
    });
    
    $('#btn_tuihuo_putintoorderlist').click(function(){
        if($(".tuihuo_order_num").length==0)
        {
            alert("暂无商品");
            return false;
        }
                
        $.ajax({
            url:"model-order-post",
            async: false,
            type: "POST",
            dataType:"json",
            data:$('#tuihuo_order_form').serialize(),
            success: function(html){
                if (html.state!="ok"){
                    layer.msg("提交订单失败！", {time: 2000, icon:2});
                    return false;
                }
                
                tuihuo_order_seller_bianhao="";
                tuihuo_order_seller_name="";
                tuihuo_order_seller_cycle="";
                
                $('#return_step_main').hide();    
                $('#return_step_saving').show();
                
                mount_to_frame('view_return_list',1,'frame_return_list');
            }
        });        
    });
});

function GetTuihuoHuohaoByFirstchar(obj, select_tuihuo_firstchar)
{
    $('.select_tuihuo_char_radioToggle').removeClass('current');
    obj.addClass('current');


    var var_huohao_html="";                              
    var_huohao_html+="<div style='float:left; width:8%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>货号：</div>";
    var_huohao_html+="<div class='choosebox'>";
    var_huohao_html+="    <ul>";
    for (key in tuihuo_gethuohaobyfirstchar[select_tuihuo_firstchar])
    {
        var count_getfactorybyhuohao=0;
        for (key_huohao in tuihuo_getproductdetailbyhuohao[tuihuo_gethuohaobyfirstchar[select_tuihuo_firstchar][key]])
        {
            count_getfactorybyhuohao++;
        }
        
        if (count_getfactorybyhuohao==1)
        {
            var_huohao_html+="        <li>";
            var_huohao_html+="            <span class='select_tuihuo_huohao_radioToggle canaddcurrent' onclick='/**/GetTuihuoFactoryByHuohao($(this), \"" + tuihuo_gethuohaobyfirstchar[select_tuihuo_firstchar][key] + "\")'>" + tuihuo_gethuohaobyfirstchar[select_tuihuo_firstchar][key] + "</span>";
            var_huohao_html+="        </li>";
        }
        else
        {
            var_huohao_html+="        <li>";
            var_huohao_html+="            <span class='select_tuihuo_huohao_radioToggle' onclick='/**/GetTuihuoFactoryByHuohao($(this), \"" + tuihuo_gethuohaobyfirstchar[select_tuihuo_firstchar][key] + "\")'>" + tuihuo_gethuohaobyfirstchar[select_tuihuo_firstchar][key] + "</span>";
            var_huohao_html+="        </li>";
        }
    }
    
    var_huohao_html+="    </ul>";
    var_huohao_html+="</div>";

    $("#select_tuihuo_huohao").html(var_huohao_html);
    $("#select_tuihuo_huohao").hide();
    
    $("#select_tuihuo_factory").html("");
    $("#select_tuihuo_factory").hide();
    
    $("#select_tuihuo_order").hide();    
}

function GetTuihuoFactoryByHuohao(obj, select_tuihuo_huohao)
{
    var count_getfactorybyhuohao=0;
    var firstvalue_getfactorybyhuohao="";
    
    for (key in tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao])
    {
        if (count_getfactorybyhuohao==0)
        {
            firstvalue_getfactorybyhuohao=key;
        }

        count_getfactorybyhuohao++;
    }

    if (count_getfactorybyhuohao==1)
    {
        $('.select_tuihuo_huohao_radioToggle').removeClass('current');
        $('.select_tuihuo_huohao_radioToggle').removeClass('addcurrent');
        if(obj!=null){
            obj.addClass('addcurrentclick');
            has_isclick=1;


            setTimeout(function(){
                obj.removeClass('addcurrentclick');
                obj.addClass('addcurrent');
            },100);
        }
        $("#select_tuihuo_factory").html("");
        $("#select_tuihuo_factory").hide();
        
        if ($("#tuihuo_list_barcode").html()!="" && $("#tuihuo_list_barcode").children(":eq(0)").children(":eq(1)").children(":eq(2)").val()==tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][firstvalue_getfactorybyhuohao]["p_barcode_p_bianhao"] && $("#tuihuo_list_barcode").html()!="" && $("#tuihuo_list_barcode").children(":eq(0)").children(":eq(1)").children(":eq(4)").val()==tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][firstvalue_getfactorybyhuohao]["p_barcode_factory_bianhao"])
        {
            $("#tuihuo_list_barcode").children(":eq(0)").children(":eq(2)").children(":eq(0)").children(":eq(1)").val(parseInt($("#tuihuo_list_barcode").children(":eq(0)").children(":eq(2)").children(":eq(0)").children(":eq(1)").val())+1)
        }
        else
        {
            var info={
                "huohao":select_tuihuo_huohao,
                "price":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][firstvalue_getfactorybyhuohao]["p_seller_price"], 
                "p_bianhao":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][firstvalue_getfactorybyhuohao]["p_barcode_p_bianhao"], 
                "valueprice":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][firstvalue_getfactorybyhuohao]["p_barcode_valueprice"], 
                "factory_bianhao":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][firstvalue_getfactorybyhuohao]["p_barcode_factory_bianhao"],
                "factory_name":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][firstvalue_getfactorybyhuohao]["p_barcode_factory_name"],
                "factory_mode":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][firstvalue_getfactorybyhuohao]["p_barcode_factory_mode"],
                "factory_cycle":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][firstvalue_getfactorybyhuohao]["p_barcode_factory_cycle"],
                "num":1
            }
            $("#tuihuo_list_barcode").prepend(get_tuihuolist_str(info));
    
        }
        
        var order_sum=0;
        var order_total_money=0;
        $(".tuihuo_order_num").each(function(){
           order_sum += parseInt($(this).val());
           order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children(":eq(1)").val());
        })
    
        $('#tuihuo_total_num').html(order_sum);
        $('#tuihuo_total_money').html(parseFloat(order_total_money.toFixed(2)));
    }
    else
    {    
        $('.select_tuihuo_huohao_radioToggle').removeClass('current');
        $('.select_tuihuo_huohao_radioToggle').removeClass('addcurrent');
        //obj.addClass('current');
    
        var var_factory_html="";                          
        var_factory_html+="<div class='ifactory' style='float:left; width:18%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:none;'>工厂：</div>";
        var_factory_html+="<div class='addchoosebox'>";
        var_factory_html+="    <ul>";
        for (key in tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao])
        {
            var_factory_html+="        <li>";
            var_factory_html+="            <span class='select_tuihuo_factory_radioToggle canaddcurrent' onclick='/**/GetTuihuoDetailByHuohaoFactory($(this), \"" + select_tuihuo_huohao + "\", \"" + key + "\")'>" + key + "</span>";
            var_factory_html+="        </li>";
        }
        var_factory_html+="    </ul>";
        var_factory_html+="</div>";
            
        $("#select_tuihuo_factory").html(var_factory_html);
        $("#select_tuihuo_factory").show();

        if($(".select_tuihuo_factory_radioToggle").css("display")=="block"){//同步厂家显示
            $(".ifactory").show();
        }
        $("#select_tuihuo_order").hide();
    }
}

var has_isclick=0;
function GetTuihuoDetailByHuohaoFactory(obj, select_tuihuo_huohao, select_tuihuo_factory)
{
    $('.select_tuihuo_factory_radioToggle').removeClass('current');
    $('.select_tuihuo_factory_radioToggle').addClass('canaddcurrent');
    obj.removeClass('canaddcurrent');

    if(obj!=null){
    obj.addClass('currentclick');
        has_isclick=1;
    }
    setTimeout(function(){
        obj.removeClass('currentclick');
        obj.addClass('current');
    },100);
    
    if ($("#tuihuo_list_barcode").html()!="" && $("#tuihuo_list_barcode").children(":eq(0)").children(":eq(1)").children(":eq(2)").val()==tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][select_tuihuo_factory]["p_barcode_p_bianhao"] && $("#tuihuo_list_barcode").html()!="" && $("#tuihuo_list_barcode").children(":eq(0)").children(":eq(1)").children(":eq(4)").val()==tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][select_tuihuo_factory]["p_barcode_factory_bianhao"])
    {
        $("#tuihuo_list_barcode").children(":eq(0)").children(":eq(2)").children(":eq(0)").children(":eq(1)").val(parseInt($("#tuihuo_list_barcode").children(":eq(0)").children(":eq(2)").children(":eq(0)").children(":eq(1)").val())+1)
    }
    else
    {
        var info={
            "huohao":select_tuihuo_huohao,
            "price":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][select_tuihuo_factory]["p_seller_price"], 
            "p_bianhao":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][select_tuihuo_factory]["p_barcode_p_bianhao"], 
            "valueprice":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][select_tuihuo_factory]["p_barcode_valueprice"], 
            "factory_bianhao":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][select_tuihuo_factory]["p_barcode_factory_bianhao"],
            "factory_name":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][select_tuihuo_factory]["p_barcode_factory_name"],
            "factory_mode":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][select_tuihuo_factory]["p_barcode_factory_mode"],
            "factory_cycle":tuihuo_getproductdetailbyhuohao[select_tuihuo_huohao][select_tuihuo_factory]["p_barcode_factory_cycle"],
            "num":1
        }
        $("#tuihuo_list_barcode").prepend(get_tuihuolist_str(info));

    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".tuihuo_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children(":eq(1)").val());
    })

    $('#tuihuo_total_num').html(order_sum);
    $('#tuihuo_total_money').html(parseFloat(order_total_money.toFixed(2)));
}

function setTuihuoListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
    
    var order_sum=0;
    var order_total_money=0;
    $(".tuihuo_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children(":eq(1)").val());
    })

    $('#tuihuo_total_num').html(order_sum);
    $('#tuihuo_total_money').html(parseFloat(order_total_money.toFixed(2)));
    $(this).val("");
}

function setTuihuoListAmountReduce(obj)
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
    $(".tuihuo_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children(":eq(1)").val());
    })

    $('#tuihuo_total_num').html(order_sum);
    $('#tuihuo_total_money').html(parseFloat(order_total_money.toFixed(2)));
    $(this).val("");
}

function setTuihuoListAmountModify(obj)
{
    if (parseInt(obj.val())<1)
    {
        alert("拿货数量不能小于1！");
        obj.val("1");
    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".tuihuo_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children(":eq(1)").val());
    })

    $('#tuihuo_total_num').html(order_sum);
    $('#tuihuo_total_money').html(parseFloat(order_total_money.toFixed(2)));
    $(this).val("");
}

function DeleteTuihuoSelectProduct(obj)
{
    obj.parent().remove();

    var order_sum=0;
    var order_total_money=0;
    $(".tuihuo_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children(":eq(1)").val());
    })

    $('#tuihuo_total_num').html(order_sum);
    $('#tuihuo_total_money').html(parseFloat(order_total_money.toFixed(2)));
    $(this).val("");
}

var letters="";
for(var keys in tuihuo_gethuohaobyfirstchar){
    letters+=keys;
}
$(".ikeyboard").init_ikeyboard(letters);//初始化键盘
function click_keyboard(pid)
{
    if (has_isclick==1){
        $(".ikeyboard").clear_ikeyboard();
        has_isclick=0;
    }
    /**/GetTuihuoFactoryByHuohao(null, pid);
}
var chuku_select_storewarehouse_bianhao=tuihuo_select_storewarehouse_bianhao;
$("#iadditem").init_iadditem(chuku_select_storewarehouse_bianhao);//添加自定义货号
</script>
