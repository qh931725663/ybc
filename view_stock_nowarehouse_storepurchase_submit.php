<?php

include_once("check_dangkou_user.php");

$btn_nowarehouse_storepurchase_name="";
$last_order_bianhao=!empty($_REQUEST["var_last_order_bianhao"])?$_REQUEST["var_last_order_bianhao"]:"0";
$order_type="";
$order_factory_bianhao="";
$order_factory_name="";

$order_master_bianhao=!empty($_REQUEST["var_master_bianhao"])?$_REQUEST["var_master_bianhao"]:"";
$order_master_name=!empty($_REQUEST["var_master_name"])?$_REQUEST["var_master_name"]:"";

if (!empty($_REQUEST["var_order_type"]))
{
    if ($_REQUEST["var_order_type"]=="dkbhgc")
    {
        $btn_nowarehouse_storepurchase_name="确认补货";    
    }
    elseif ($_REQUEST["var_order_type"]=="gcfh")
    {
        $btn_nowarehouse_storepurchase_name="确认发货";    
    }
    elseif ($_REQUEST["var_order_type"]=="jhrk")
    {
        $btn_nowarehouse_storepurchase_name="确认入库";    
    }
    
    $order_type=$_REQUEST["var_order_type"];
    $rsfactory=mysql_query("SELECT * FROM ydf_factory WHERE factory_bianhao = '".$_REQUEST["var_factory_bianhao"]."'" , $dbconn);
    if($rowfactory=mysql_fetch_array($rsfactory))
    {
        $order_factory_bianhao=$rowfactory["factory_bianhao"];
        $order_factory_name=$rowfactory["factory_name"];
    }
}
?>
<div style="float:left; width:100%; margin-top:20px; overflow:hidden; display:block;">
    <span style="float:left; margin-left:35px">当前工厂：<span style="font-size:24px; font-weight:bold; color:#ee583d"><?php echo $order_factory_name?></span></span>
    <span style="float:right">
        <span class="btn_normal_red" onclick="/**/mount_to_frame('view_stock_storepurchase',1,'frame_stock_storepurchase')">返回</span>
    </span>
</div>
<div id="nowarehouse_storepurchase_step_main" style="width:100%; overflow:hidden; display:block">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
        <div id="nowarehouse_storepurchaselist_left" style="float:left; width:56%; min-height:800px; padding:0 2%; border-right:1px solid #cccccc; overflow:hidden; display:block">

            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">已选择商品列表</span>
                <span style="float:right">
                    <span style="font-size:18px; color:#999999">数量总计：<span id="nowarehouse_storepurchase_total_num" style=" font-size:24px; color:#ee583d">0</span></span>
                </span>
            </div>
            <form method="post" id="nowarehouse_storepurchase_order_form">
            <div style="float:left; width:98%; padding:5px 1%; display:block">
                <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
                    <div style="float:left; width:30%; font-size:12px; color:#999999">货号 / 工厂</div>
                    <div style="float:left; width:15%; font-size:12px; color:#999999; text-align:center">颜色</div>
                    <div style="float:left; width:15%; font-size:12px; color:#999999; text-align:center">尺码</div>
                    <div style="float:left; width:30%; font-size:12px; color:#999999; text-align:center">数量</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">删除</div>
                </div>
                <div id="nowarehouse_storepurchase_list_barcode" style="width:100%; overflow:hidden; display:block;"></div>
            </div>
            <div style="width:98%; margin:20px auto; overflow:hidden; display:block">
                <div style="float:right; width:150px; overflow:hidden; display:block">
                    <div id="btn_nowarehouse_storepurchase_putintoorder" class="btn_putintoorderlist"><?php echo $btn_nowarehouse_storepurchase_name ?></div>
                </div>
            </div>
            <input type="hidden" name="order_type" value="<?php echo $order_type ?>">
            <input type="hidden" name="order_factory_bianhao" value="<?php echo $order_factory_bianhao ?>">
            <input type="hidden" name="order_factory_name" value="<?php echo $order_factory_name ?>">
            <input type="hidden" name="order_source_bianhao" value="<?php echo $last_order_bianhao ?>">
            <?php
            if ($order_type=="gcfh")
            {
            ?>
            <input type="hidden" name="order_slave_bianhao" value="<?php echo $order_master_bianhao ?>">
            <input type="hidden" name="order_slave_name" value="<?php echo $order_master_name ?>">
            <?php
            }
            else
            {
            ?>
            <input type="hidden" id="nowarehouse_storepurchase_order_master_bianhao" name="order_master_bianhao" value="<?php echo $order_master_bianhao ?>">
            <input type="hidden" id="nowarehouse_storepurchase_order_master_name" name="order_master_name" value="<?php echo $order_master_name ?>">
            <?php
            }
            ?>
            </form>                            
        </div>
        <div id="nowarehouse_storepurchaselist_right" style="float:left; width:35%; padding:0 2%; overflow:hidden; display:block">
        
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
                                    <span class="select_nowarehouse_storepurchase_factory_huohao_radioToggle" onclick="/**/ShowNowarehouseStorepurchaseFactoryProductOrderLayer($(this), '<?php echo $order_factory_name ?>', '<?php echo $rowfactoryhuohao["p_huohao"] ?>')"><?php echo $rowfactoryhuohao["p_huohao"] ?></span>
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
    <div id="layer_nowarehouse_storepurchase_productorder" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
    
    </div>

</div>

<div id="nowarehouse_storepurchase_step_saving" style="width:100%; overflow:hidden; display:none">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; overflow:hidden; display:block">
        <div style="width:100%; height:100px; margin:0 auto; background:url(/pc/images/loading.gif) center center no-repeat; display:block">
        </div>    
    </div>
</div>
            
<script type="text/javascript">    
var order_nowarehouse_storepurchase_idx=0;
function get_nowarehouse_storepurchase_barcode_str(info)
{
    var storepurchase_barcode_str = "" +
        "<div style='width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;'>" +
        "    <div style='float:left; width:15%; height:20px; font-size:12px; color:#999999'>"+info["huohao"]+" / " + info["factory_name"]+
        "       <input name='table["+order_nowarehouse_storepurchase_idx+"][order_barcode]' type='hidden' value='" +info["barcode"]+ "'>"+
        "       <input name='table["+order_nowarehouse_storepurchase_idx+"][order_p_bianhao]' type='hidden' class='nowarehouse_storepurchase_order_p_bianhao' value='" +info["p_bianhao"]+ "'>"+
        "       <input name='table["+order_nowarehouse_storepurchase_idx+"][order_p_type_bianhao]' type='hidden' value='" +info["p_type_bianhao"]+ "'>"+
        "       <input name='table["+order_nowarehouse_storepurchase_idx+"][order_factory_bianhao]' type='hidden' value='" +info["factory_bianhao"]+ "'>"+
        "       <input name='table["+order_nowarehouse_storepurchase_idx+"][order_huohao]' type='hidden' value='" +info["huohao"]+ "'>"+
        "       <input name='table["+order_nowarehouse_storepurchase_idx+"][order_color]' type='hidden' value='" +info["color"]+ "'>"+
        "       <input name='table["+order_nowarehouse_storepurchase_idx+"][order_size]' type='hidden' value='" +info["size"]+ "'>"+
        "       <input name='table["+order_nowarehouse_storepurchase_idx+"][order_valueprice]' type='hidden' value='" +info["valueprice"]+ "'>"+
        "       <input name='table["+order_nowarehouse_storepurchase_idx+"][order_factory_mode]' type='hidden' value='" +info["factory_mode"]+ "'>"+
        "       <input name='table["+order_nowarehouse_storepurchase_idx+"][order_factory_cycle]' type='hidden' value='" +info["factory_cycle"]+ "'>"+
        "   </div>" +
        "    <div style='float:left; width:15%; height:20px; font-size:12px; color:#999999; text-align:center'>"+info["color"]+"</div>" +
        "    <div style='float:left; width:15%; height:20px; font-size:12px; color:#999999; text-align:center'>"+info["size"]+"</div>" +
        "    <div style='float:left; width:30%; height:20px; font-size:12px; color:#999999; text-align:center'>" +
        "        <span class='add_chose'>" +
        "            <span class='reduce' onclick='/**/setnowarehouse_storepurchaseListAmountReduce($(this).parent().children(\":eq(1)\"))'/>" +
        "                <input name='table["+order_nowarehouse_storepurchase_idx+"][order_num]' class='nowarehouse_storepurchase_order_num text12' value='" +info["num"]+ "' type='text' onKeyUp='/**/setnowarehouse_storepurchaseListAmountModify($(this))'>" +
        "            <span class='add' onclick='/**/setnowarehouse_storepurchaseListAmountAdd($(this).parent().children(\":eq(1)\"))'/>" +
        "        </span>" +
        "    </div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#3366FF; text-align:center; cursor:pointer' onclick='/**/DeleteNowarehouseStorepurchaseSelectProduct($(this))'>删除</div>" +
        "</div>";                        
    order_nowarehouse_storepurchase_idx++;
    return storepurchase_barcode_str;
}

var nowarehouse_storepurchase_select_factory_barcode;

$(function(){
    if (storepurchase_select_storewarehouse_bianhao!="")
    {
        $("#nowarehouse_storepurchase_order_master_bianhao").val(storepurchase_select_storewarehouse_bianhao);
        $("#nowarehouse_storepurchase_order_master_name").val(storepurchase_select_storewarehouse_name);
    }
    
    <?php
    if(!empty($_REQUEST["var_factory_bianhao"]) and $_REQUEST["var_factory_bianhao"]>"0")
    {
    ?>
    storepurchase_select_factory="<?php echo $_REQUEST["var_factory_bianhao"] ?>";
    <?php
    }
    ?>
    
    //获取所有商品编码及属性
    $.ajax({
        url:"model-get-allfactoryproductsbarcode", 
        async: false,
        type: "POST",
        data:{var_factory_bianhao:storepurchase_select_factory},
        dataType:"json",
        success: function(html){
            nowarehouse_storepurchase_select_factory_barcode=html;
        }
    });

    <?php
    if(!empty($_REQUEST["var_last_order_bianhao"]))
    {
    ?>
    var dkbh_order_detail_barcode;
    $.ajax({
        url:"get-purchaseorderdetailbarcode", 
        async: false,
        type: "POST",
        data:{var_order_bianhao:"<?php echo $_REQUEST["var_last_order_bianhao"] ?>"},
        dataType:"json",
        success: function(html){
            dkbh_order_detail_barcode=html;
        }
    });
    
    for (key in dkbh_order_detail_barcode)
    {
        if (key>0)
        {
            var info={
                "huohao":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_huohao"],
                "color":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_color"],
                "size":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_size"],
                "price": nowarehouse_storepurchase_select_factory_barcode[key]["p_seller_price"], 
                "barcode":key, 
                "p_bianhao":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_p_bianhao"], 
                "p_type_bianhao":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_p_type_bianhao"], 
                "factory_bianhao":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_factory_bianhao"], 
                "factory_name":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_factory_name"], 
                "valueprice":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_valueprice"], 
                "factory_mode":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_factory_mode"], 
                "factory_cycle":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_factory_cycle"], 
                "num":dkbh_order_detail_barcode[key]["detail_order_num"]
            }
            $("#nowarehouse_storepurchase_list_barcode").prepend(get_nowarehouse_storepurchase_barcode_str(info));
        }
    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".nowarehouse_storepurchase_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().html());
    })

    $('#nowarehouse_storepurchase_total_num').html(order_sum);
    $('#nowarehouse_storepurchase_total_money').html(parseFloat(order_total_money.toFixed(2)));
    <?php
    }
    ?>
        
    <?php
    if(!empty($_REQUEST["var_factory_bianhao"]) and $_REQUEST["var_order_type"]=="dkbhgc")
    {
    ?>
    var dkbh_order_detail_barcode;
    $.ajax({
        url:"get-purchase-factory",
        async: false,
        type: "POST",
        data:{var_master_bianhao:storepurchase_select_storewarehouse_bianhao,var_factory_bianhao:"<?php echo $_REQUEST["var_factory_bianhao"] ?>"},
        dataType:"json",
        success: function(html){
            dkbh_order_detail_barcode=html;
        }
    });
    
    for (key in dkbh_order_detail_barcode)
    {
        if (key>0)
        {
            var info={
                "huohao":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_huohao"],
                "color":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_color"],
                "size":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_size"],
                "price": nowarehouse_storepurchase_select_factory_barcode[key]["p_seller_price"], 
                "barcode":key, 
                "p_bianhao":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_p_bianhao"], 
                "p_type_bianhao":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_p_type_bianhao"], 
                "factory_bianhao":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_factory_bianhao"], 
                "factory_name":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_factory_name"], 
                "valueprice":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_valueprice"], 
                "factory_mode":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_factory_mode"], 
                "factory_cycle":nowarehouse_storepurchase_select_factory_barcode[key]["p_barcode_factory_cycle"], 
                "num":dkbh_order_detail_barcode[key]["detail_order_num"]
            }
            $("#nowarehouse_storepurchase_list_barcode").prepend(get_nowarehouse_storepurchase_barcode_str(info));
        }
    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".nowarehouse_storepurchase_order_num").each(function(){
       order_sum += parseInt($(this).val());
       order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().html());
    })

    $('#nowarehouse_storepurchase_total_num').html(order_sum);
    $('#nowarehouse_storepurchase_total_money').html(parseFloat(order_total_money.toFixed(2)));
    <?php
    }
    ?>

    $('#btn_nowarehouse_storepurchase_putintoorder').click(function(){
        if($(".nowarehouse_storepurchase_order_num").length==0)
        {
            alert("暂无商品");
            return false;
        }
        
                
        $.ajax({
            url:"model-order-post", 
            async: false,
            type: "POST",
            dataType:"json",
            data:$('#nowarehouse_storepurchase_order_form').serialize(),
            success: function(html){
                if (html.state!="ok"){
                    layer.msg("补货失败！", {time: 2000, icon:2});
                    return false;
                }
                
                $('#nowarehouse_storepurchase_step_main').hide();    
                $('#nowarehouse_storepurchase_step_saving').show();
                
                mount_to_frame('view_stock_storepurchase',1,'frame_stock_storepurchase');
            }
        });        
    });
});

function ShowNowarehouseStorepurchaseFactoryProductOrderLayer(obj, factory_name, p_huohao){
    $('.select_nowarehouse_storepurchase_factory_huohao_radioToggle').removeClass('current');
    obj.addClass('current');
    
    $.ajax({
        url:"view-get-selectfactoryproductorder", 
        async: false,
        type: "POST",
        data:{var_order_type:"nowarehouse_storepurchase",var_factory:factory_name,var_p_huohao:p_huohao},
        success: function(html){
            $("#layer_nowarehouse_storepurchase_productorder").html(html);
        }
    });
    
    index_nowarehouse_storepurchase_showfactoryproductorder=layer.open({
        type: 1,
        area: ['420px', '500px'],
        title: false,
        content:$('#layer_nowarehouse_storepurchase_productorder')
    });
}

function setnowarehouse_storepurchaseListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
    
    var order_sum=0;
    var order_total_money=0;
    $(".nowarehouse_storepurchase_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#nowarehouse_storepurchase_total_num').html(order_sum);
}

function setnowarehouse_storepurchaseListAmountReduce(obj)
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

    var order_sum=0;
    var order_total_money=0;
    $(".nowarehouse_storepurchase_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#nowarehouse_storepurchase_total_num').html(order_sum);
}

function setnowarehouse_storepurchaseListAmountModify(obj)
{
    if (parseInt(obj.val())<1)
    {
        alert("数量不能小于1！");
        obj.val("1");
    }

    var order_sum=0;
    var order_total_money=0;
    $(".nowarehouse_storepurchase_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#nowarehouse_storepurchase_total_num').html(order_sum);
}

function DeleteNowarehouseStorepurchaseSelectProduct(obj)
{
    obj.parent().remove();

    var order_sum=0;
    var order_total_money=0;
    $(".nowarehouse_storepurchase_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#nowarehouse_storepurchase_total_num').html(order_sum);
}
</script>
