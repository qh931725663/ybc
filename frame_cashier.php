<?php

include_once("check_dangkou_user.php");
?>
<div class="frame_main_div">
    <div class="fram_search_tab" id="fram_search_tab" style="width:100%">
        <div style="float:left;width:32%; height:70px; background:#f2f2f2; overflow:hidden; display:block"><input style="width:100%; font-size:18px;" id="chuku_seller_nickname" class="chuku_seller_name iinput name_iime ino_ime_input iseller_name" name="chuku_seller_name" type="text" placeholder="请输入卖家拼音首字母" autocomplete="off"/></div>
        <div style="float:left;width:33%;height:70px; margin-left:1%"><span class="chuhuo_register">出货收银</span></div>
        <div style="float:left;;width:33%;height:70px;margin-left:1%"><span class="return_goods">退货登记</span></div>
    </div>
    <div class="frame_tab_panel" id="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select chuhuo_btn" onclick="mount_to_frame('frame_sales_cashier',0,'frame_cashier')">出货记录</span>
            <span class="frame_tab_item tuihuo_btn"    onclick="mount_to_frame('frame_return_list',0,'frame_cashier')">退货记录</span>
        </div>
    </div>    
    <div id="frame_cashier"/>
</div>

<script>
mount_to_frame('frame_sales_cashier',0,'frame_cashier');

num_sound = new NumSound();
$(".chuhuo_register").click(function(){
    $ ("#chuku_seller_name").val($("#chuku_seller_nickname").val());
    $(".chuhuo_btn").trigger("click");
    $('#link_start_cashier').trigger('click');
    setTimeout("$('.layui-layer-close').click(function(){layer.close(index_layer_sales_cashier_select_storewarehouse);})",500);
});
$(".return_goods").click(function(){
    ASYNC=false;
    $("#tuihuo_seller_name").val($ ("#chuku_seller_nickname").val());
    $(".tuihuo_btn").trigger("click");
    $('#btn_selecttuihuo').trigger('click');
    setTimeout("$('.layui-layer-close').click(function(){layer.close(index_layer_return_select_storewarehouse);})",500);
    ASYNC=true;
});

$(window).resize(function(){
    var pa_l = parseInt($("#chuku_seller_nickname").css("padding-left"));
    var pa_r = parseInt($("#chuku_seller_nickname").css("padding-right"));
    var w = $("#chuku_seller_nickname").width()+pa_l+pa_r;
    $("#chuku_seller_nickname").nextAll(".ino_ime_proxy").width(w);
});
</script>
