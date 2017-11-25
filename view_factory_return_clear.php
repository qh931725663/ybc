<?php

include_once("check_factory_user.php");
include_once("{$root_path}/model/model_order.php");
?>
<script type="text/javascript">    
function click_page_num_qcfc(obj)
{
    set_page_list_qcfc(obj);
    refresh_inner("view_stock_storepurchase?"+$("#form_qcfc").serialize() );
}
function set_page_list_qcfc(obj)
{
    if (obj.attr("id")=="last"||obj.attr("id")=="next")
    {
        mobj=$("#pages_qcfc").find("#m");
        if (obj.attr("id")=="last" && Number(mobj.html())-1>=1){
            var bingo=Number(mobj.html())-1;
            mobj.html(bingo);
            click_page_num_qcfc(mobj);
        }
        if (obj.attr("id")=="next" && Number(mobj.html())+1<=page_count_qcfc){
            var bingo=Number(mobj.html())+1;
            mobj.html(bingo);
            click_page_num_qcfc(mobj);
        }
        return;
    }

    $("#pages_qcfc").find("#ll").html("1");
    $("#pages_qcfc").find("#rr").html(page_count_qcfc);

    var bingo=Number(obj.html());

    $("#page_idx_qcfc").attr("value",bingo);

    $("#pages_qcfc").find("#m").html(bingo);//中间页码
    $("#pages_qcfc").find("#l1").html(bingo-1);//左1页码
    $("#pages_qcfc").find("#l2").html(bingo-2);//左2页码
    $("#pages_qcfc").find("#r1").html(bingo+1);//右1页码
    $("#pages_qcfc").find("#r2").html(bingo+2);//右2页码

    $("#pages_qcfc").find(".pagelink").each(function(){
        var num=Number($(this).html())
        if (num<=0||num>page_count_qcfc){
            $(this).css("display","none");
        }else{
            $(this).css("display","inline");
        }
    });
}

function search_qcfc()
{
    mobj=$("#pages_qcfc").find("#m");
    mobj.html(1);
    set_page_list_qcfc(mobj);//模拟点击第一页

    refresh_inner("view_stock_storepurchase?"+$("#form_qcfc").serialize() );
}
function click_me_qcfc(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");
    
    //重置value
    $('#order_type').attr("value","");

    if (state!="")
        $('#order_type').attr("value",state);

    search_qcfc();
}
</script>
<form id="form_qcfc">
<div class="sdsy_setup">
    <div class="sdsy_nave" style="margin-top:20px;">
        <div class="sdsy_nave_b">
            <span class="sdsy_date">
                <span class="sdsy_date_d">日期 <input type="text" class="datepicker" name="factory_clear_from_day" size="12" maxlength="50" readonly="readonly"> 至 <input type="text" class="datepicker" name="factory_clear_to_day"  size="12" maxlength="50" readonly="readonly">
                </span>
            </span>
            <span onclick="/**/search_gcfh()" class="btn_normal_blue public_search">搜索</span>
            <span class="clear_search" onclick="mount_to_frame('view_factory_return_clear',1,'frame_factory_return_clear')">清空<br>条件</span>
        </div>
    </div>                        
</div>

<!-- refresh_begin -->
<?php                    
@$from_day=$_REQUEST["factory_clear_from_day"]?get_ymd($_REQUEST["factory_clear_from_day"])["d"]:null;
@$to_day=$_REQUEST["factory_clear_to_day"]?get_ymd($_REQUEST["factory_clear_to_day"])["d"]+24*3600:null;

$order_type="";
@$str_order_type=$_REQUEST["order_type"]?$_REQUEST["order_type"]:"dkbhgc,dkbhck,dkbhgcfh,dkbhckfh,dkbhgcfhdkqs,dkbhckfhdkqs";
@$arr_order_type=explode(",",$str_order_type);
for ($i=0; $i<count($arr_order_type); $i++)
{
    if ($i==0)
    {
        $order_type="'".$arr_order_type[0]."'";
    }
    else
    {
        $order_type.=",'".$arr_order_type[$i]."'";
    }
}

$where=@array("order_factory_bianhao='".$_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"]."' and  order_type='qcfc'");
$where=clean_where($where);
//print_r($where);
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;
$offset=($page-1)*$pagesize; 
$p=cselect("*","ydf_order",$where,"","order_addtime desc",$offset,$pagesize);
//if ($p[0]->errorCode()!="00000")
//print_r($p[0]->errorInfo());
$rowcount=$p[1];
$page_count=ceil($rowcount/$pagesize);  
while ($roworder=$p[0]->fetch())
{
?>
<div style="width:99%; margin:0 auto 20px auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
    <div style="float:left; width:98%; padding:10px 1%; overflow:hidden; display:block">
        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
            <div style="float:left; padding:5px 0; font-size:12px"><span style="color:#999999">编号：</span><?php echo $roworder["order_bianhao"];?></div>
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">清仓：</span><span style="color:#0099FF"><?php echo $roworder["order_master_name"];?></span></div>
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">返厂：</span><span style="color:#0099FF"><?php echo $roworder["order_factory_name"];?></span></div>    
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">操作用户：</span><?php echo $roworder["order_user_name"];?></div>
            
            <div style="float:right; text-align:right">
                <span class="btn_order_red" onclick="/**/PrintOrder(<?php echo $roworder["order_bianhao"]?>)">打印</span>
            </div>
        </div>
        <div style="width:100%; margin:0 auto; padding:15px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
            <div style="float:left; width:25%; font-size:12px; color:#999999">货号</div>
            <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">颜色</div>
            <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">尺码</div>
            <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">成本价</div>
            <div style="float:left; width:15%; font-size:12px; color:#999999; text-align:center">清仓数量</div>
        </div>
        <?php
        $shop_totalnum=0;
        $shop_totalprice=0;
        $rsitem = mysql_query("select * from ydf_order_detail where detail_order_bianhao='".$roworder["order_bianhao"]."' order by detail_p_bianhao, detail_p_color, detail_p_size", $dbconn); 
        while ($rowitem=mysql_fetch_array($rsitem))
        {
            $shop_totalnum+=$rowitem["detail_order_num"];
            $shop_totalprice+=$rowitem["detail_order_num"]*$rowitem["detail_valueprice"];
        ?>        
        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
            <div style="float:left; width:25%; height:20px; font-size:12px"><?php echo $rowitem["detail_p_huohao"]?></div>
            <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $rowitem["detail_p_color"]?></div>
            <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $rowitem["detail_p_size"]?></div>
            <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $rowitem["detail_valueprice"]?></div>
            <div style="float:left; width:15%; height:20px; font-size:12px; text-align:center"><?php echo $rowitem["detail_order_num"] ?></div>        </div>
        <?php
        }
        ?>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span style="font-size:12px"><span style="color:#999999">数量总计：</span><span style=" font-size:12px; color:#ee583d"><?php echo $shop_totalnum?></span> <span style="color:#999999">成本总计：</span><span style="font-size:12px; color:#ee583d"><?php echo $shop_totalprice?></span></span>
        </div>
    </div>
</div>
<?php
}
?>

<div style="float:right; margin-top:5px; font-size:14px"> 共 <span style="font-size:14px; color:#d51938; font-weight:bold;"><?php echo $rowcount?></span> 个订单</div>

<script>/*n*/    
var page_count_qcfc=<?php echo $page_count; ?>;
/**/set_page_list_qcfc($("#pages_qcfc").find("#m"));
</script>

<!-- refresh_end -->
<div class="showpage" id="pages_qcfc">
    <input id="page_idx_qcfc" name="page_idx" style="display:none" value="1"/>
    <span style="display:block">
        <span class="pagelink" id="last" onclick="/**/click_page_num_qcfc($(this))" >上一页</span>
        <span class="pagelink" id="ll" onclick="/**/click_page_num_qcfc($(this))" />
        <span class="pageblank"  id="lb">...</span>
        <span class="pagelink" id="l2" onclick="/**/click_page_num_qcfc($(this))" />
        <span class="pagelink" id="l1" onclick="/**/click_page_num_qcfc($(this))" />
        <span class="pageselect" id="m"  onclick="/**/click_page_num_qcfc($(this))"  >1</span>
        <span class="pagelink" id="r1" onclick="/**/click_page_num_qcfc($(this))" />
        <span class="pagelink" id="r2" onclick="/**/click_page_num_qcfc($(this))" />
        <span class="pageblank"  id="rb">...</span>
        <span class="pagelink" id="rr" onclick="/**/click_page_num_qcfc($(this))" />
        <span class="pagelink" id="next" onclick="/**/click_page_num_qcfc($(this))" >下一页</span>
    </span>
</div>
</form> <!-- 页码也作为表单项统一处理  -->
