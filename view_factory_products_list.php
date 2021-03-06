<?php

include_once("check_factory_user.php");

$p_factory=cselect("*","ydf_factory",array("factory_boss_m_bianhao=? and factory_mobile=?" ,$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"],$_SESSION["ERP_ACCOUNT_LOGIN_MOBILE"]));
$rowfactory=$p_factory[0]->fetch();
$factory_id=$rowfactory["factory_bianhao"];
?>
<script type="text/javascript">    
function click_page_num_products(obj)
{
    set_page_list_products(obj);
    refresh_inner("view_factory_products_list?"+$("#form_products").serialize() );
}

function set_page_list_products(obj)
{
    if (obj.attr("id")=="last"||obj.attr("id")=="next")
    {
        mobj=$("#pages_products").find("#m");
        if (obj.attr("id")=="last" && Number(mobj.html())-1>=1){
            var bingo=Number(mobj.html())-1;
            mobj.html(bingo);
            set_page_list_products(mobj);
        }
        if (obj.attr("id")=="next" && Number(mobj.html())+1<=page_count_products){
            var bingo=Number(mobj.html())+1;
            mobj.html(bingo);
            set_page_list_products(mobj);
        }
        return;
    }

    $("#pages_products").find("#ll").html("1");
    $("#pages_products").find("#rr").html(page_count_products);

    var bingo=Number(obj.html());

    $("#page_idx_products").attr("value",bingo);

    $("#pages_products").find("#m").html(bingo);//中间页码
    $("#pages_products").find("#l1").html(bingo-1);//左1页码
    $("#pages_products").find("#l2").html(bingo-2);//左2页码
    $("#pages_products").find("#r1").html(bingo+1);//右1页码
    $("#pages_products").find("#r2").html(bingo+2);//右2页码

    $("#pages_products").find(".pagelink").each(function(){
        var num=Number($(this).html())
        if (num<=0||num>page_count_products){
            $(this).css("display","none");
        }else{
            $(this).css("display","inline");
        }
    });
    

}

function list_products()
{
    //重置value
    $('#products_searchwords').attr("value","请输入商品货号");
    $('#products_searchwords').css("color","#cccccc")
    
    mobj=$("#pages_products").find("#m");
    mobj.html(1);
    set_page_list_products(mobj);//模拟点击第一页

    refresh_inner("view_factory_products_list?"+$("#form_products").serialize() );
}

function click_me_products(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");

    list_products();
}
</script>
<form id="form_products">
<div style="float:left; width:100%; overflow:hidden; display:block">
    <div style="position:relative; float:left; width:100%; margin-top:20px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
        <div style="float:left;width:15%; padding:10px 0; color:#999999; text-align:center;">图片</div>
        <div style="float:left;width:35%; padding:10px 0; color:#999999">货号 / 颜色 / 尺码 / 成分</div>
        <div style="float:left;width:35%; padding:10px 0; color:#999999; text-align:center">工厂 / <span style="color:#0099FF">货号</span> / <span style="color:#ee583d">供货价</span></div>
        <div style="float:left;width:15%; padding:10px 0; color:#999999; text-align:center;">操作</div>
    </div>

<!-- refresh_begin -->
<?php                
$where=@array("p_barcode_boss_m_bianhao=? and p_barcode_factory_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"],$factory_id);
$where=clean_where($where);

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;
$offset=($page-1)*$pagesize; 
$p=cselect("*","ydf_products_barcode",$where,"p_barcode_p_bianhao","p_barcode_p_bianhao desc",$offset,$pagesize);
$rowcount=$p[1];
$page_count=ceil($rowcount/$pagesize);  
while ($rowproductsbarcode=$p[0]->fetch())
{
    $p_product=cselect("*","ydf_products",array("p_bianhao=?",$rowproductsbarcode["p_barcode_p_bianhao"] ) );
    $rowpagedata=$p_product[0]->fetch();
    
    $rsfactory=mysql_query("SELECT factory_name FROM ydf_factory WHERE factory_bianhao='".$rowproductsbarcode["p_barcode_factory_bianhao"]."'" , $dbconn);
    $rowfactory=mysql_fetch_array($rsfactory);
    
    $all_color_str="";
    $i=1;
    $p_type_color=cselect("p_type_color","ydf_products_type",array("p_type_p_bianhao=?",$rowpagedata["p_bianhao"] ),"p_type_color","p_type_bianhao asc" );
    while ($rowproductcolor=$p_type_color[0]->fetch())
    {
    $all_color_str.=($i==1?"":",").$rowproductcolor["p_type_color"];
    $i++;
    }
    
    $all_size_str="";
    $i=1;
    $p_type_size=cselect("p_type_size","ydf_products_type",array("p_type_p_bianhao=?",$rowpagedata["p_bianhao"] ),"p_type_size","p_type_bianhao asc" );
    while ($rowproductsize=$p_type_size[0]->fetch())
    {
    $all_size_str.=($i==1?"":",").$rowproductsize["p_type_size"];
    $i++;
    }
?>
    <div style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">

        <div style="float:left;width:15%; padding:5px 0">
        <?php
            if(!empty($rowpagedata["p_pic"])){
                $url='https://ybc-image.oss-cn-hangzhou.aliyuncs.com/'.$rowpagedata["p_pic"].'?x-oss-process=style/list';
            }else{
                $url="/pc/images/nopic.jpg";
            }
        ?>
            <div style="width:100px; height:100px; border:1px solid #f2f2f2; background:url(<?php echo $url?>) center center no-repeat; background-size:contain; overflow:hidden; display:block"></div>
        </div>
        <div style="float:left;width:35%">
            <span style="float:left; width:100%; padding:5px 0; font-weight:bold"><?php echo $rowpagedata["p_huohao"]?></span>
            <span style="float:left; width:100%; padding:5px 0; color:#999999"><?php echo $all_color_str ?></span>
            <span style="float:left; width:100%; padding:5px 0; color:#999999"><?php echo $all_size_str ?></span>
            <span style="float:left; width:100%; padding:5px 0; color:#999999"><?php echo $rowpagedata["p_composition"]?></span>
        </div>
        <div style="float:left;width:35%; height:25px">
            <div style="float:left; width:100%; padding:5px 0; text-align:center">
                <?php echo $rowfactory["factory_name"] ?><?php echo !empty($rowproductsbarcode["p_barcode_factory_huohao"])?" / <span style='color:#0099ff'>".$rowproductsbarcode["p_barcode_factory_huohao"]."</span>":"" ?> / <span style="color:#ee583d"><?php echo $rowproductsbarcode["p_barcode_valueprice"] ?></span>
            </div>
        </div>
        <div style="float:left;width:15%; padding:5px 0; text-align:center">
            <span style="color:#0099FF; cursor:pointer" onclick="/**/ShowViewProductBarcodeLayer(<?php echo $rowpagedata["p_bianhao"]?>,<?php echo $rowproductsbarcode["p_barcode_factory_bianhao"]?>)">查看条码</span> | <span style="color:#0099FF; cursor:pointer" onclick="/**/ShowModifyFactoryProductHuohaoLayer(<?php echo $rowpagedata["p_bianhao"]?>,<?php echo $rowproductsbarcode["p_barcode_factory_bianhao"]?>)">修改货号</span>
        </div>
    </div>
<?php
}
?>
    
    <div style="float:right; margin-top:5px; font-size:14px"> 共 <span style="font-size:14px; color:#d51938; font-weight:bold;"><?php echo $rowcount?></span> 个商品</div>

<script>/*n*//*n*/
var page_count_products=<?php echo $page_count; ?>;
/**/set_page_list_products($("#pages_products").find("#m"));
</script>
<!-- refresh_end -->                    
    <div class="showpage" id="pages_products">
        <input id="page_idx_products" name="page_idx" style="display:none" value="1"/>
        <span style="display:block">
            <span class="pagelink" id="last" onclick="/**/click_page_num_products($(this))" >上一页</span>
            <span class="pagelink" id="ll" onclick="/**/click_page_num_products($(this))" />
            <span class="pageblank"  id="lb">...</span>
            <span class="pagelink" id="l2" onclick="/**/click_page_num_products($(this))" />
            <span class="pagelink" id="l1" onclick="/**/click_page_num_products($(this))" />
            <span class="pageselect" id="m"  onclick="/**/click_page_num_products($(this))"  >1</span>
            <span class="pagelink" id="r1" onclick="/**/click_page_num_products($(this))" />
            <span class="pagelink" id="r2" onclick="/**/click_page_num_products($(this))" />
            <span class="pageblank"  id="rb">...</span>
            <span class="pagelink" id="rr" onclick="/**/click_page_num_products($(this))" />
            <span class="pagelink" id="next" onclick="/**/click_page_num_products($(this))" >下一页</span>
        </span>
    </div>
</div>
</form> <!-- 页码也作为表单项统一处理  -->
    
<div id="layer_view_productbarcode" style="float:left; width:350px; padding:25px; overflow:visible; display:none">

</div>

<div id="layer_modify_productfactory" style="float:left; width:350px; padding:25px; overflow:visible; display:none">

</div>

<script type="text/javascript">    
function ShowViewProductBarcodeLayer(p_bianhao,factory_bianhao){
    $.ajax({
        url:"view-factory-productbarcode", 
        async: false,
        type: "POST",
        data:{var_p_bianhao:p_bianhao,var_factory_bianhao:factory_bianhao},
        success: function(html){
            $("#layer_view_productbarcode").html(html);
        }
    });
    
    index_layer_view_productbarcode=layer.open({
        type: 1,
        area: ['420px', '500px'],
        title: false,
        content:$('#layer_view_productbarcode')
    });
}

function ShowModifyFactoryProductHuohaoLayer(p_bianhao,factory_bianhao){
    $.ajax({
        url:"view-modify-factoryproducthuohao", 
        async: false,
        type: "POST",
        data:{var_p_bianhao:p_bianhao,var_factory_bianhao:factory_bianhao},
        success: function(html){
            $("#layer_modify_productfactory").html(html);
        }
    });
    
    index_layer_modify_productfactory=layer.open({
        type: 1,
        area: ['420px', '200px'],
        title: false,
        content:$('#layer_modify_productfactory')
    });
}

function PostModifyFactoryPorductHuohao(p_bianhao, factory_bianhao){
    $.ajax({
        url:"model-post-modify-factoryproducthuohao", 
        async: false,
        type: "POST",
        data:$('#modify_productfactory_form').serialize(),
        dataType:"json",
        success: function(html){
            layer.close(index_layer_modify_productfactory);
            
            if (html["state"]=="ok")
            {
                layer.msg("修改成功！", {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_factory_products_list',1,'frame_factory_products_list');
                },2000);
            }
            else
            {
                layer.msg(html["desc"], {time: 2000, icon:2});
            }
        }
    });    
}
</script>
