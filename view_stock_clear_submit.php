<?php

include_once("check_dangkou_user.php");

$order_master_bianhao=!empty($_REQUEST["var_master_bianhao"])?$_REQUEST["var_master_bianhao"]:"";
$order_master_name=!empty($_REQUEST["var_master_name"])?$_REQUEST["var_master_name"]:"";
$order_master_type=!empty($_REQUEST["var_master_type"])?$_REQUEST["var_master_type"]:"";

$order_factory_bianhao="";
$order_factory_name="";
if (!empty($_REQUEST["var_factory_bianhao"]))
{    
    $rsfactory=mysql_query("SELECT * FROM ydf_factory WHERE factory_bianhao = '".$_REQUEST["var_factory_bianhao"]."'" , $dbconn);
    if($rowfactory=mysql_fetch_array($rsfactory))
    {
        $order_factory_bianhao=$rowfactory["factory_bianhao"];
        $order_factory_name=$rowfactory["factory_name"];
    }
}
?>
<div style="float:left; width:100%; margin-top:20px; overflow:hidden; display:block;">
    <span style="float:left; margin-left:35px; margin-top:15px">返厂：<span style="font-size:16px; font-weight:bold; color:#ee583d"><?php echo $order_factory_name?></span></span>
    <span id="stockclear_storewarehouse_name" style="float:left; margin-left:35px; margin-top:15px">
    <?php
    if ($order_master_type=="1")
    {
        echo "当前档口：<span style='font-size:16px; font-weight:bold'>".$order_master_name."</span>";
    }
    elseif ($order_master_type=="2")
    {
        echo "当前仓库：<span style='font-size:16px; font-weight:bold'>".$order_master_name."</span>";
    }
    ?>
    </span>
    <span style="float:right">
        <span class="btn_normal_blue" onclick="/**/mount_to_frame('view_stock_clear',1,'frame_stock_clear')">放弃返回</span>
    </span>
</div>
<div id="stockclear_step_main" style="width:100%; overflow:hidden; display:block">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
        <div id="stockclearlist_left" style="float:left; width:56%; min-height:800px; padding:0 2%; border-right:1px solid #cccccc; overflow:hidden; display:block">

            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">已选择商品列表</span>
                <span style="float:right">
                    <span style="font-size:18px; color:#999999">数量总计：<span id="stockclear_total_num" style=" font-size:24px; color:#ee583d">0</span></span>
                </span>
            </div>
            <form method="post" id="stockclear_order_form">
            <div style="float:left; width:98%; padding:5px 1%; display:block">
                <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
                    <div style="float:left; width:30%; font-size:12px; color:#999999">货号 / 工厂</div>
                    <div style="float:left; width:15%; font-size:12px; color:#999999; text-align:center">颜色</div>
                    <div style="float:left; width:15%; font-size:12px; color:#999999; text-align:center">尺码</div>
                    <div style="float:left; width:30%; font-size:12px; color:#999999; text-align:center">数量</div>
                    <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">删除</div>
                </div>
                <div id="stockclear_list_barcode" style="width:100%; overflow:hidden; display:block;"></div>
            </div>
            <div style="width:98%; margin:20px auto; overflow:hidden; display:block">
                <div style="float:right; width:150px; overflow:hidden; display:block">
                    <div id="btn_stockclear_putintoorder" class="btn_putintoorderlist">确认返厂</div>
                </div>
            </div>
            <input type="hidden" name="order_type" value="qcfc">
            <input type="hidden" name="order_factory_bianhao" value="<?php echo $order_factory_bianhao ?>">
            <input type="hidden" name="order_factory_name" value="<?php echo $order_factory_name ?>">
            <input type="hidden" id="stockclear_order_master_bianhao" name="order_master_bianhao" value="<?php echo $order_master_bianhao ?>">
            <input type="hidden" id="stockclear_order_master_name" name="order_master_name" value="<?php echo $order_master_name ?>">
            </form>                            
        </div>
        <div id="stockclearlist_right" style="float:left; width:35%; padding:0 2%; overflow:hidden; display:block">
        
            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">快速选择商品</span>
            </div>
            <div style="float:left; width:98%; padding:5px 1%">
                <div style="position: relative; width:100%; margin:5px 0; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                    <div style="float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block">货号：</div>
                    <?php
                    $p=cselect("p_barcode_p_bianhao","ydf_products_barcode",array("p_barcode_factory_bianhao=?",$_REQUEST["var_factory_bianhao"]),"p_barcode_p_bianhao","p_barcode_bianhao desc");
                    if ($p[1])
                    {
                    ?>
                    <div class="choosebox">
                        <ul>
                    <?php
                        while ($rowfactory=$p[0]->fetch())  
                        {
                            $rsfactoryhuohao = mysql_query("SELECT p_huohao FROM ydf_products where p_bianhao='".$rowfactory["p_barcode_p_bianhao"]."'", $dbconn); 
                            $rowfactoryhuohao=mysql_fetch_array($rsfactoryhuohao);
                        ?>
                        <li>
                            <span class="select_stockclear_factory_huohao_radioToggle" onclick="/**/ShowWarehousepurchaseFactoryProductOrderLayer($(this), '<?php echo $order_factory_name ?>', '<?php echo $rowfactoryhuohao["p_huohao"] ?>')"><?php echo $rowfactoryhuohao["p_huohao"] ?></span>
                        </li>
                        <?php
                        }
                    ?>
                        </ul>
                    </div>
                    <?php
                    }
                    else
                    {
                    ?>
                    <div style="float:left; padding:5px 0; text-align:right; overflow:hidden; display:block">暂无商品！</div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        
        </div>
    
    </div>
    
    <div id="layer_stockclear_productorder" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
    
    </div>

</div>

<div id="stockclear_step_saving" style="width:100%; overflow:hidden; display:none">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; overflow:hidden; display:block">
        <div style="width:100%; height:100px; margin:0 auto; background:url(/pc/images/loading.gif) center center no-repeat; display:block">
        </div>    
    </div>
</div>
            
<script type="text/javascript">
var order_idx=0;
function get_stockclear_barcode_str(info)
{
    var barcode_str = "" +
        "<div style='width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;'>" +
        "    <div style='float:left; width:30%; height:20px; font-size:12px; color:#999999'><span>"+info["huohao"]+" / "+info["factory_name"] + "</span>" +
        "       <input name='table["+order_idx+"][order_barcode]' type='hidden' value='" +info["barcode"]+ "'>"+
        "       <input name='table["+order_idx+"][order_p_bianhao]' type='hidden' class='stockclear_order_p_bianhao' value='" +info["p_bianhao"]+ "'>"+
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
        "            <span class='reduce' onclick='/**/setstockclearListAmountReduce($(this).parent().children(\":eq(1)\"))'/>" +
        "                <input name='table["+order_idx+"][order_num]' class='stockclear_order_num text12' value='" +info["num"]+ "' type='text' onKeyUp='/**/setstockclearListAmountModify($(this))'>" +
        "            <span class='add' onclick='/**/setstockclearListAmountAdd($(this).parent().children(\":eq(1)\"))'/>" +
        "        </span>" +
        "    </div>" +
        "    <div style='float:left; width:10%; height:20px; font-size:12px; color:#3366FF; text-align:center; cursor:pointer' onclick='/**/DeletestockclearSelectProduct($(this))'>删除</div>" +
        "</div>";                        
    order_idx++;
    return barcode_str;
}

var stockclear_select_factory_barcode;

$(function(){
    <?php
    if(!empty($_REQUEST["var_factory_bianhao"]) and $_REQUEST["var_factory_bianhao"]>"0")
    {
    ?>
    stockclear_select_factory="<?php echo $_REQUEST["var_factory_bianhao"] ?>";
    <?php
    }
    ?>
    
    //获取所有商品编码及属性
    $.ajax({
        url:"model-get-allfactoryproductsbarcode", 
        async: false,
        type: "POST",
        data:{var_factory_bianhao:stockclear_select_factory},
        dataType:"json",
        success: function(html){
            stockclear_select_factory_barcode=html;
        }
    });

    $('#btn_stockclear_putintoorder').click(function(){
        if($(".stockclear_order_num").length==0)
        {
            alert("暂无商品");
            return false;
        }
        
                
        $.ajax({
            url:"model-order-post", 
            async: false,
            type: "POST",
            dataType:"json",
            data:$('#stockclear_order_form').serialize(),
            success: function(html){
                if (html.state!="ok"){
                    layer.msg("清仓返厂失败！", {time: 2000, icon:2});
                    return false;
                }
                
                $('#stockclear_step_main').hide();    
                $('#stockclear_step_saving').show();
                
                mount_to_frame('view_stock_clear',1,'frame_stock_clear');
            }
        });        
    });
});

function ShowWarehousepurchaseFactoryProductOrderLayer(obj, factory_name, p_huohao){
    $('.select_stockclear_factory_huohao_radioToggle').removeClass('current');
    obj.addClass('current');
    
    $.ajax({
        url:"view-get-selectfactoryproductorder", 
        async: false,
        type: "POST",
        data:{var_order_type:"stockclear",var_factory:factory_name,var_p_huohao:p_huohao},
        success: function(html){
            $("#layer_stockclear_productorder").html(html);
        }
    });
    
    index_stockclear_showfactoryproductorder=layer.open({
        type: 1,
        area: ['420px', '500px'],
        title: false,
        content:$('#layer_stockclear_productorder')
    });
}

function setstockclearListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
    
    var order_sum=0;
    var order_total_money=0;
    $(".stockclear_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#stockclear_total_num').html(order_sum);
}

function setstockclearListAmountReduce(obj)
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
    $(".stockclear_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#stockclear_total_num').html(order_sum);
}

function setstockclearListAmountModify(obj)
{
    if (parseInt(obj.val())<1)
    {
        alert("入库数量不能小于1！");
        obj.val("1");
    }

    var order_sum=0;
    var order_total_money=0;
    $(".stockclear_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#stockclear_total_num').html(order_sum);
}

function DeletestockclearSelectProduct(obj)
{
    obj.parent().remove();

    var order_sum=0;
    var order_total_money=0;
    $(".stockclear_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#stockclear_total_num').html(order_sum);
}
</script>
