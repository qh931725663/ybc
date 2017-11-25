<?php


$item_boss_bianhao=$_REQUEST["var_boss_bianhao"];
$item_factory_bianhao=0;

$p_factory=cselect("factory_bianhao","ydf_factory",array("factory_boss_m_bianhao=? and factory_name=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"],$_REQUEST["var_factory"]));
if ($rowfactory=$p_factory[0]->fetch())
{
    $item_factory_bianhao=$rowfactory["factory_bianhao"];
}

$item_huohao=$_REQUEST["var_p_huohao"];
$item_price=0;
?>
<div style="float:left; width:100%; overflow:hidden; display:block">
    <div style="float:left; width:100%; margin:10px 0; font-size:18px; font-weight:bold; overflow:hidden; display:block"><?php echo $item_huohao ?></div>    
    <div style="float:left; width:100%; overflow:hidden; display:block">
        <div class="choosebox">
            <ul>
            <?php
            $i=1;
            
            $p_product=cselect("p_bianhao","ydf_products",array("p_huohao=? and p_boss_m_bianhao=?",$item_huohao,$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]));
            $rowproduct=$p_product[0]->fetch();
            
            $p_product_type_color=cselect("p_type_color","ydf_products_type",array("p_type_p_bianhao=?",$rowproduct["p_bianhao"]),"p_type_color","p_type_bianhao asc");
            while ($rowproducttypecolor=$p_product_type_color[0]->fetch())
            {
            ?>
                    <li>
                        <span class="<?php echo $_REQUEST["var_order_type"]?>_factory_color_radioToggle <?php if ($i==1) {?>current<?php } ?>" onclick="SelectFactoryProductColor($(this))"><?php echo $rowproducttypecolor["p_type_color"]?></span>
                    </li>
            <?php    
                $i++;
            }
            ?>
            </ul>
        </div>
    </div>
    <div id="parent_select_factory_product_size" style="float:left; width:100%; overflow:hidden; display:block">
        <?php
        $i=1;
        $p_product_type_color=cselect("p_type_color","ydf_products_type",array("p_type_p_bianhao=?",$rowproduct["p_bianhao"]),"p_type_color","p_type_bianhao asc");
        while ($rowproducttypecolor=$p_product_type_color[0]->fetch())
        {
        ?>
        <div class="select_factory_product_size" style="float:left; width:100%; overflow:hidden; display:<?php if ($i==1) { echo "block"; } else { echo "none"; } ?>">
            <div class="chooseguigebbox">
                <ul>
                <?php
                $p_product_type_size=cselect("*","ydf_products_type",array("p_type_p_bianhao=? and p_type_color=?",$rowproduct["p_bianhao"],$rowproducttypecolor["p_type_color"]),"","p_type_bianhao asc");
                while ($rowproducttypesize=$p_product_type_size[0]->fetch())
                {
                    $p_barcode_size=cselect("*","ydf_products_barcode",array("p_barcode_p_type_bianhao=? and p_barcode_factory_bianhao=?",$rowproducttypesize["p_type_bianhao"],$item_factory_bianhao));
                    $rowbarcodesize=$p_barcode_size[0]->fetch();
                    
                    if ($i==1)
                    {
                        $item_price=$rowbarcodesize["p_barcode_valueprice"];
                    }
                ?>
                    <li style="float:left; width:100%; padding:2px 0; border-bottom:1px dotted #cccccc; overflow:hidden; display:block">
                        <span style="float:left; width:30%; padding:10px 0; color:#999999"><?php echo $rowproducttypecolor["p_type_color"]?></span>
                        <span style="float:left; width:30%; padding:10px 0; color:#999999"><?php echo $rowproducttypesize["p_type_size"]?></span>
                        <span style="float:left; width:40%;">
                            <span class="select_add_chose">
                                <span class="reduce" onClick="setSelect<?php echo $_REQUEST["var_order_type"]?>ListAmountReduce($(this).parent().children(':eq(1)'))">-</span>
                                <input type="text" id="select_<?php echo $_REQUEST["var_order_type"]?>_order_num_<?php echo $rowbarcodesize["p_barcode_bianhao"]?>" class="select_<?php echo $_REQUEST["var_order_type"]?>_order_num" onKeyUp="setSelect<?php echo $_REQUEST["var_order_type"]?>ListAmountModify($(this))" value="0"/>
                                <input type="hidden" id="select_<?php echo $_REQUEST["var_order_type"]?>_order_barcode_<?php echo $rowbarcodesize["p_barcode_bianhao"]?>" value="<?php echo $rowbarcodesize["p_barcode_bianhao"]?>">
                                <span class="add" onClick="setSelect<?php echo $_REQUEST["var_order_type"]?>ListAmountAdd($(this).parent().children(':eq(1)'))">+</span>
                            </span>
                        </span>
                    </li>
                <?php                        
                }
                ?>
                </ul>
            </div>
        </div>
        <?php            
            $i++;
        }
        ?>
    </div>

    <div style="float:left; width:100%">
        <div style="float:left; width:100%; margin-top:15px; color:#999999"><span id="select_<?php echo $_REQUEST["var_order_type"]?>_order_num" style="margin:0 5px; font-size:18px; font-weight:bold; color:#ee583d; display:inline-block">0</span>件<span style="margin:0 5px; color:#999999; display:inline-block">×</span><span id="select_<?php echo $_REQUEST["var_order_type"]?>_order_price" style="margin:0 5px; font-size:18px; font-weight:bold; color:#ee583d; display:inline-block"><?php echo $item_price?></span>元 / 件<span style="margin:0 5px; color:#999999; display:inline-block">=</span><span id="select_<?php echo $_REQUEST["var_order_type"]?>_order_sum" style="margin:0 5px; font-size:18px; font-weight:bold; color:#ee583d; display:inline-block">0</span>元</div>
    </div>    
    <div style="float:left; width:100%">
        <div id="btn_<?php echo $_REQUEST["var_order_type"]?>_putintoorderlist" class="btn_putintoorderlist">加入入库明细</div>
    </div>    
</div>
<script type="text/javascript">    
$(function (){
    $('#btn_<?php echo $_REQUEST["var_order_type"]?>_putintoorderlist').click(function(){
        if ($("#select_<?php echo $_REQUEST["var_order_type"]?>_order_num").html()=="0")
        {
            alert("数量必须大于 0 ！");
            return false;
        }    
        
        $(".select_<?php echo $_REQUEST["var_order_type"]?>_order_num").each(function(){
            if (parseInt($(this).val())>0)
            {
                var key=$(this).next().val();
                var info={
                    "huohao":<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_huohao"],
                    "color":<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_color"],
                    "size":<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_size"],
                    "barcode":key, 
                    "p_bianhao":<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_p_bianhao"], 
                    "p_type_bianhao":<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_p_type_bianhao"], 
                    "factory_bianhao":<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_factory_bianhao"], 
                    "valueprice":<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_valueprice"], 
                    "factory_mode":<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_factory_mode"], 
                    "factory_cycle":<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_factory_cycle"], 
                    <?php
                    if ($_REQUEST["var_order_type"]=="stockadjust" or $_REQUEST["var_order_type"]=="productsinit")
                    {
                    ?>
                    "stock_num":<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_stock_num"], 
                    "num":$(this).val()-<?php echo $_REQUEST["var_order_type"]?>_select_factory_barcode[key]["p_barcode_stock_num"], 
                    "really_stock_num":$(this).val()
                    <?php
                    }
                    else
                    {
                    ?>
                    "num":$(this).val()
                    <?php
                    }
                    ?>

                }
                $("#<?php echo $_REQUEST["var_order_type"]?>_list_barcode").prepend(get_<?php echo $_REQUEST["var_order_type"]?>_barcode_str(info));
            }
        })    
        
        layer.close(index_<?php echo $_REQUEST["var_order_type"]?>_showfactoryproductorder);

        var order_sum=0;
        var order_total_money=0;
        $(".<?php echo $_REQUEST["var_order_type"]?>_order_num").each(function(){
           order_sum += parseInt($(this).val());
           order_total_money+=$(this).val()*parseFloat($(this).parent().parent().prev().children().html());
        })
    
        $('#<?php echo $_REQUEST["var_order_type"]?>_total_num').html(order_sum);
        $('#<?php echo $_REQUEST["var_order_type"]?>_total_money').html(parseFloat(order_total_money.toFixed(2)));

    });
});    

function SelectFactoryProductColor(obj)
{
    $('.<?php echo $_REQUEST["var_order_type"]?>_factory_color_radioToggle').removeClass('current');
    obj.addClass('current');
    
    $('.select_factory_product_size').css("display","none");
    $('#parent_select_factory_product_size').children(":eq(" + obj.parent().index() + ")").css("display","block");
}

function setSelect<?php echo $_REQUEST["var_order_type"]?>ListAmountAdd(obj)
{
    obj.val(parseInt(obj.val())+1);
    
    var order_sum=0;
    $(".select_<?php echo $_REQUEST["var_order_type"]?>_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $("#select_<?php echo $_REQUEST["var_order_type"]?>_order_num").html(order_sum);
    order_price=<?php echo $item_price ?>;
    $("#select_<?php echo $_REQUEST["var_order_type"]?>_order_sum").html(order_sum*order_price);
}

function setSelect<?php echo $_REQUEST["var_order_type"]?>ListAmountReduce(obj)
{    
    if ((parseInt(obj.val())-1)<0)
    {
        alert("数量不能小于0！");
        obj.val("0");
    }
    else
    {
        obj.val(parseInt(obj.val())-1);
    }
    
    var order_sum=0;
    $(".select_<?php echo $_REQUEST["var_order_type"]?>_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $("#select_<?php echo $_REQUEST["var_order_type"]?>_order_num").html(order_sum);
    order_price=<?php echo $item_price ?>;
    $("#select_<?php echo $_REQUEST["var_order_type"]?>_order_sum").html(order_sum*order_price);
}

function setSelect<?php echo $_REQUEST["var_order_type"]?>ListAmountModify(obj)
{
    if (parseInt(obj.val())<0)
    {
        alert("数量不能小于1！");
        obj.val("0");
    }
    
    var order_sum=0;
    $(".select_<?php echo $_REQUEST["var_order_type"]?>_order_num").each(function(){
       order_sum += parseInt($(this).val());
    })

    $("#select_<?php echo $_REQUEST["var_order_type"]?>_order_num").html(order_sum);
    order_price=<?php echo $item_price ?>;
    $("#select_<?php echo $_REQUEST["var_order_type"]?>_order_sum").html(order_sum*order_price);
}
</script>