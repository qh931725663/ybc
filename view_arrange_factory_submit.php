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
    <div style="float:left; margin-left:35px; margin-top:15px">
        返厂：<span id="show_arrange_factory_name" style="font-size:16px; font-weight:bold; color:#ee583d"><?php echo $order_factory_name ?></span>
    </div>
    <div id="arrangefactory_storewarehouse_name" style="float:left; margin-left:35px; margin-top:15px"></div>
    <div style="float:right">
        <span class="btn_normal_blue" onclick="/**/mount_to_frame('view_arrange_factory',1,'frame_arrange_factory')">放弃返回</span>
    </div>
</div>
<div id="arrange_factory_step_main" style="width:100%; overflow:hidden; display:block">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
        <div id="arrange_factory_left" style="float:left; width:56%; min-height:800px; padding:0 2%; border-right:1px solid #cccccc; overflow:hidden; display:block">

            <div style="float:left; width:98%; padding:10px 1%">
                <span style="float:left">已选择商品列表</span>
                <span style="float:right">
                    <span style="font-size:18px; color:#999999">数量总计：<span id="arrange_factory_total_num" style=" font-size:24px; color:#ee583d">0</span></span>
                </span>
            </div>
            <form method="post" id="arrange_factory_order_form">
            <div style="float:left; width:98%; padding:5px 1%; display:block">
                <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
                    <div style="float:left; width:40%; font-size:12px; color:#999999">货号</div>
                    <div style="float:left; width:40%; font-size:12px; color:#999999; text-align:center">退货数量</div>
                    <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">删除</div>
                </div>
                <div id="arrange_factory_list_barcode" style="width:100%; overflow:hidden; display:block;">        
                </div>
            </div>
            <div style="width:98%; margin:20px auto; overflow:hidden; display:block">
                <div style="float:right; width:150px; overflow:hidden; display:block">
                    <div id="btn_arrange_factory_putintoorderlist" class="btn_putintoorderlist">确认提交返厂</div>
                </div>
            </div>
            <input type="hidden" name="order_type" value="thfc">
            <input type="hidden" name="order_factory_bianhao" value="<?php echo $order_factory_bianhao ?>">
            <input type="hidden" name="order_factory_name" value="<?php echo $order_factory_name ?>">
            <input type="hidden" name="order_master_bianhao" value="<?php echo $order_master_bianhao ?>">
            <input type="hidden" name="order_master_name" value="<?php echo $order_master_name ?>">
            </form>
        </div>
        <div id="arrange_factory_right" style="float:left; width:35%; padding:0 2%; overflow:hidden; display:block">
        
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
                    <div class="addchoosebox">
                        <ul>
                    <?php
                        while ($rowfactory=$p[0]->fetch())  
                        {
                            $rsfactoryhuohao = mysql_query("SELECT p_huohao FROM ydf_products where p_bianhao='".$rowfactory["p_barcode_p_bianhao"]."'", $dbconn); 
                            $rowfactoryhuohao=mysql_fetch_array($rsfactoryhuohao);
                        ?>
                        <li>
                            <span class="arrange_factory_huohao_radioToggle canaddcurrent" onclick="/**/GetArrangefactoryProductdetailByHuohao($(this), '<?php echo $rowfactoryhuohao["p_huohao"] ?>')"><?php echo $rowfactoryhuohao["p_huohao"] ?></span>
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

</div>

<div id="arrange_factory_step_saving" style="width:100%; overflow:hidden; display:none">
    <div style="width:98%; margin:20px auto 0 auto; background:#ffffff; overflow:hidden; display:block">
        <div style="width:100%; height:100px; margin:0 auto; background:url(/pc/images/loading.gif) center center no-repeat; display:block">
        </div>    
    </div>
</div>
            
<script type="text/javascript">    
var order_arrange_factory_idx=0;
function get_arrange_factory_huohao_str(info)
{
    var arrange_factory_huohao_str = "" +
        "<div style='width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;'>" +
        "    <div style='float:left; width:40%; height:20px'><span style='font-size:12px; color:#999999'>" +info["huohao"]+ "</span>"+
        "       <input name='table["+order_arrange_factory_idx+"][order_p_bianhao]' type='hidden' value='" +info["p_bianhao"]+ "'>"+
        "       <input name='table["+order_arrange_factory_idx+"][order_valueprice]' type='hidden' value='" +info["valueprice"]+ "'>"+
        "       <input name='table["+order_arrange_factory_idx+"][order_huohao]' type='hidden' value='" +info["huohao"]+ "'>"+
        "       <input name='table["+order_arrange_factory_idx+"][order_factory_bianhao]' type='hidden' value='" +info["factory_bianhao"]+ "'>"+
        "       <input name='table["+order_arrange_factory_idx+"][order_factory_mode]' type='hidden' value='" +info["factory_mode"]+ "'>"+
        "       <input name='table["+order_arrange_factory_idx+"][order_factory_cycle]' type='hidden' value='" +info["factory_cycle"]+ "'>"+
        "   </div>" +
        "    <div style='float:left; width:40%; height:20px; font-size:12px; color:#999999; text-align:center'>" +
        "        <span class='add_chose'>" +
        "            <span class='reduce' onclick='/**/setArrangefactoryListAmountReduce($(this).parent().children(\":eq(1)\"))'/>" +
        "            <input name='table["+order_arrange_factory_idx+"][order_num]' class='arrange_factory_order_num text12' value='" +info["num"]+ "' type='text' onKeyUp='/**/setArrangefactoryListAmountModify($(this))'>" +
        "            <span class='add' onclick='/**/setArrangefactoryListAmountAdd($(this).parent().children(\":eq(1)\"))'/>" +
        "        </span>" +
        "    </div>" +
        "    <div style='float:left; width:20%; height:20px; font-size:12px; color:#3366FF; text-align:center; cursor:pointer' onclick='/**/DeleteArrangefactorySelectProduct($(this))'>删除</div>" +
        "</div>";                        
    order_arrange_factory_idx++;
    return arrange_factory_huohao_str;
}

var getarrangefactoryhuohao;
var getarrangefactoryproductdetailbyhuohao;
    
$(function(){    
    if (parseInt(arrange_factory_select_storewarehouse_type)==1)
    {
        $("#arrangefactory_storewarehouse_name").html("当前档口：<span style='font-size:16px; font-weight:bold'>"+arrange_factory_select_storewarehouse_name+"</span>");
    }
    else if (parseInt(arrange_factory_select_storewarehouse_type)==2)
    {
        $("#arrangefactory_storewarehouse_name").html("当前仓库：<span style='font-size:16px; font-weight:bold'>"+arrange_factory_select_storewarehouse_name+"</span>");
    }
                
    //获取点选商品列表信息
    $.ajax({
        url:"model-get-allfactoryproducts",
        async: false,
        type: "POST",
        data:{var_factory_bianhao:<?php echo $order_factory_bianhao?>},
        dataType:"json",
        success: function(html){
            getarrangefactoryhuohao=html["factory_huohao_idx"];
            getarrangefactoryproductdetailbyhuohao=html["factory_product_idx"];
        }
    });
    
    $('#btn_arrange_factory_putintoorderlist').click(function(){
        if($(".arrange_factory_order_num").length==0)
        {
            alert("暂无商品");
            return false;
        }
        
                
        $.ajax({
            url:"model-order-post", 
            async: false,
            type: "POST",
            dataType:"json",
            data:$('#arrange_factory_order_form').serialize(),
            success: function(html){
                if (html.state!="ok"){
                    layer.msg('提交订单失败！', {time: 2000, icon:2});
                    return false;
                }
                
                $('#arrange_factory_step_main').hide();    
                $('#arrange_factory_step_saving').show();
                
                layer.msg('订单提交成功！', {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_arrange_factory',1,'frame_arrange_factory')
                },2000);
            }
        });        
    });
});

function GetArrangefactoryProductdetailByHuohao(obj, select_arrange_factory_huohao)
{
    $('.arrange_factory_huohao_radioToggle').removeClass('current');
    $('.arrange_factory_huohao_radioToggle').addClass('canaddcurrent');
    obj.removeClass('canaddcurrent');
    obj.addClass('currentclick');
    
    setTimeout(function(){
        obj.removeClass('currentclick');
        obj.addClass('current');
    },100);
    

    if ($("#arrange_factory_list_barcode").html()!="" && $("#arrange_factory_list_barcode").children(":eq(0)").children(":eq(0)").children(":eq(1)").val()==getarrangefactoryproductdetailbyhuohao[select_arrange_factory_huohao]["p_barcode_p_bianhao"])
    {
        $("#arrange_factory_list_barcode").children(":eq(0)").children(":eq(1)").children(":eq(0)").children(":eq(1)").val(parseInt($("#arrange_factory_list_barcode").children(":eq(0)").children(":eq(1)").children(":eq(0)").children(":eq(1)").val())+1);
    }
    else
    {
        var info={
            "huohao":select_arrange_factory_huohao,
            "valueprice":getarrangefactoryproductdetailbyhuohao[select_arrange_factory_huohao]["p_barcode_valueprice"],
            "p_bianhao":getarrangefactoryproductdetailbyhuohao[select_arrange_factory_huohao]["p_barcode_p_bianhao"], 
            "factory_bianhao":getarrangefactoryproductdetailbyhuohao[select_arrange_factory_huohao]["p_barcode_factory_bianhao"],
            "factory_mode":getarrangefactoryproductdetailbyhuohao[select_arrange_factory_huohao]["p_barcode_factory_mode"],
            "factory_cycle":getarrangefactoryproductdetailbyhuohao[select_arrange_factory_huohao]["p_barcode_factory_cycle"],
            "num":1
        }
        $("#arrange_factory_list_barcode").prepend(get_arrange_factory_huohao_str(info));

    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".arrange_factory_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#arrange_factory_total_num').html(order_sum);
}

function setArrangefactoryListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
    
    var order_sum=0;
    var order_total_money=0;
    $(".arrange_factory_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#arrange_factory_total_num').html(order_sum);
    $(this).val("");
}

function setArrangefactoryListAmountReduce(obj)
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
    $(".arrange_factory_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#arrange_factory_total_num').html(order_sum);
    $(this).val("");
}

function setArrangefactoryListAmountModify(obj)
{
    if (parseInt(obj.val())<1)
    {
        alert("拿货数量不能小于1！");
        obj.val("1");
    }
    
    var order_sum=0;
    var order_total_money=0;
    $(".arrange_factory_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#arrange_factory_total_num').html(order_sum);
    $(this).val("");
}

function DeleteArrangefactorySelectProduct(obj)
{
    obj.parent().remove();

    var order_sum=0;
    var order_total_money=0;
    $(".arrange_factory_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $('#arrange_factory_total_num').html(order_sum);
    $(this).val("");
}
</script>
