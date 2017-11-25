<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_order.php");
?>
<script type="text/javascript">    
function click_page_num_dkbh(obj)
{
    set_page_list_dkbh(obj);
    refresh_inner("view_stock_storepurchase?"+$("#form_dkbh").serialize() );
}

function set_page_list_dkbh(obj)
{
    if (obj.attr("id")=="last"||obj.attr("id")=="next")
    {
        mobj=$("#pages_dkbh").find("#m");
        if (obj.attr("id")=="last" && Number(mobj.html())-1>=1){
            var bingo=Number(mobj.html())-1;
            mobj.html(bingo);
            set_page_list_dkbh(mobj);
        }
        if (obj.attr("id")=="next" && Number(mobj.html())+1<=page_count_dkbh){
            var bingo=Number(mobj.html())+1;
            mobj.html(bingo);
            set_page_list_dkbh(mobj);
        }
        return;
    }

    $("#pages_dkbh").find("#ll").html("1");
    $("#pages_dkbh").find("#rr").html(page_count_dkbh);

    var bingo=Number(obj.html());

    $("#page_idx_dkbh").attr("value",bingo);

    $("#pages_dkbh").find("#m").html(bingo);//中间页码
    $("#pages_dkbh").find("#l1").html(bingo-1);//左1页码
    $("#pages_dkbh").find("#l2").html(bingo-2);//左2页码
    $("#pages_dkbh").find("#r1").html(bingo+1);//右1页码
    $("#pages_dkbh").find("#r2").html(bingo+2);//右2页码

    $("#pages_dkbh").find(".pagelink").each(function(){
        var num=Number($(this).html())
        if (num<=0||num>page_count_dkbh){
            $(this).css("display","none");
        }else{
            $(this).css("display","inline");
        }
    });
    

}

function list_dkbh()
{
    //重置value
    $('#search_store_dangkoubuhuo_from_date').attr("value","");
    $('#search_store_dangkoubuhuo_to_date').attr("value","");
    
    mobj=$("#pages_dkbh").find("#m");
    mobj.html(1);
    set_page_list_dkbh(mobj);//模拟点击第一页

    refresh_inner("view_stock_storepurchase?"+$("#form_dkbh").serialize() );
}

function search_dkbh()
{
    $("#btn_stock_storepurchase_search").parent().prev().find(".listtypevalue").removeClass('listtypeselect');
    
    mobj=$("#pages_dkbh").find("#m");
    mobj.html(1);
    set_page_list_dkbh(mobj);//模拟点击第一页

    refresh_inner("view_sales_cashier?"+$("#form_dkbh").serialize() );
}

function click_me_dkbh(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");

    list_dkbh();
}
</script>
<form id="form_dkbh">
<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block;">
    <div style="float:right">
        <span class="btn_normal_green" onclick="/**/StorepurchaseClick('znbh')">智能补货</span>
        <span class="btn_normal_red" onclick="/**/StorepurchaseClick('zjrk')">直接入库</span>
    </div>
</div>
<div  style="float:left; width:100%; margin:10px 0; padding:5px; overflow:hidden; display:block">
    <div style="float:left; overflow:hidden; display:block">
        <input type="hidden" id="order_type" name="order_type"/>
        <span class="listtypevalue listtypeselect" onclick="/**/click_me_dkbh($(this),'')">全部</span>
        <span class="listtypevalue" onclick="/**/click_me_dkbh($(this),'dkbh')">待发货</span>
        <span class="listtypevalue" onclick="/**/click_me_dkbh($(this),'dkbhgcfh')">已发货</span>
        <span class="listtypevalue" onclick="/**/click_me_dkbh($(this),'dkbhgcfhckqs')">已入库</span>
    </div>
    <div style="float:right; overflow:hidden; display:block">
        <span style="float:left; overflow:hidden; display:block">
            <span style="padding:5px 0">日期 <input type="text" class="datepicker" name="search_store_dangkoubuhuo_from_date"  size="12" maxlength="50" readonly="readonly" style="padding:5px"> 至 <input type="text" class="datepicker" name="search_sotre_dangkoubuhuo_to_date"  size="12" maxlength="50" readonly="readonly" style="padding:5px">
            </span>
        </span>
        <span id="btn_stock_storepurchase_search" class="btn_normal_green">搜索</span>
    </div>
</div>

<!-- refresh_begin -->
<?php                    
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;

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

$where=@array("order_boss_m_bianhao=? and order_bianhao=? and order_temp=? and order_is_pay=? and order_is_pickup=? and order_seller_cycle>=? and order_seller_cycle<=? and order_add_time>=? and order_add_time<=? and order_master_type='1' and (order_type='dkbhgc' or order_type='dkbhck' or ((order_type='jhrk' or order_type='ckrk') and order_source_bianhao='0' and order_master_type='1'))",
$boss_id,$_REQUEST["order_bianhao"],$_REQUEST["order_temp"],$_REQUEST["order_is_pay"],$_REQUEST["order_is_pickup"],$_REQUEST["order_seller_cycle_min"],$_REQUEST["order_seller_cycle_max"],$from_day,$to_day);
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
    $order_send_state="0";
    $order_send_date="";
    $rssendorder = mysql_query("SELECT * FROM ydf_order where (order_type='gcfh' or order_type='ckck') and order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
    if ($rowsendorder=mysql_fetch_array($rssendorder))
    {
        $order_send_state="1";
        $order_send_date=date("Y-m-d H:i:s",$rowsendorder["order_addtime"]);
    }
?>
<div class="stock" style="width:99%; margin:0 auto 20px auto;">
    <div class="stock_inner">
        <div class="stock_table_header">
            <div style="padding:5px 0;"><span style="color:#999999">编号：</span><?php echo $roworder["order_bianhao"];?></div>
            <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">补货：</span><span style="color:#0099FF"><?php echo $roworder["order_master_name"];?></span></div>
            <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">发货：</span><span style="color:#0099FF"><?php echo $roworder["order_slave_name"].$roworder["order_factory_name"];?></span></div>
            <?php
            $order_status_des="";
            if (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="dkbhck") and $roworder["order_is_verify"]=="0")
            {
                $order_status_des="待发货";
            ?>
            <div style="margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#d64126">待发货</span></div>
            <?php
            }
            elseif (($roworder["order_type"]=="gcck" or $roworder["order_type"]=="ckck") and $roworder["order_is_verify"]=="1")
            {
                $order_status_des="已发货";
            ?>
            <div style="margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#0099FF">已发货</span></div>
            <?php
            }
            elseif ((($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="dkbhck") and $roworder["order_is_verify"]=="2") or (($roworder["order_type"]=="jhrk" or $roworder["order_type"]=="ckrk") and $roworder["order_source_bianhao"]=="0"))
            {
                $order_status_des="已入库";
            ?>
            <div style="margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#009900">已入库</span></div>
            <?php
            }
            ?>
            
            <div style="float:right; text-align:right">
                <?php
                if ($roworder["order_type"]=="dkbhgc" and $roworder["order_is_verify"]=="0")
                {
                ?>
                <span class="btn_order_red" onclick="/**/NowarehouseStorepurchaseOrderVerifyClick('<?php echo $roworder["order_master_bianhao"]?>','<?php echo $roworder["order_master_name"]?>','<?php echo $roworder["order_bianhao"]?>','<?php echo $roworder["order_factory_bianhao"]?>','gcfh')">工厂发货</span>
                <?php
                }
                
                if ($roworder["order_type"]=="dkbhck" and $roworder["order_is_verify"]=="0")
                {
                ?>
                <span class="btn_order_red" onclick="/**/HavewarehouseStorepurchaseOrderVerifyClick('<?php echo $roworder["order_master_bianhao"]?>','<?php echo $roworder["order_master_name"]?>','<?php echo $roworder["order_bianhao"]?>','ckck')">仓库发货</span>
                <?php
                }
                
                if ($roworder["order_type"]=="dkbhgc" and $roworder["order_is_verify"]=="0")
                {
                ?>
                <span class="btn_order_red" onclick="/**/NowarehouseStorepurchaseOrderVerifyClick('<?php echo $roworder["order_master_bianhao"]?>','<?php echo $roworder["order_master_name"]?>','<?php echo $roworder["order_bianhao"]?>','<?php echo $roworder["order_factory_bianhao"]?>','jhrk')">档口签收</span>
                <?php
                }
                elseif ($roworder["order_type"]=="dkbhgc" and $roworder["order_is_verify"]=="1")
                {
                    $rslastorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rowlastorder=mysql_fetch_array($rslastorder);
                ?>
                <span class="btn_order_red" onclick="/**/NowarehouseStorepurchaseOrderVerifyClick('<?php echo $roworder["order_master_bianhao"]?>','<?php echo $roworder["order_master_name"]?>','<?php echo $rowlastorder["order_bianhao"]?>','<?php echo $rowlastorder["order_factory_bianhao"]?>','jhrk')">档口签收</span>
                <?php
                }
                
                if ($roworder["order_type"]=="dkbhck" and $roworder["order_is_verify"]=="1")
                {
                    $rslastorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rowlastorder=mysql_fetch_array($rslastorder);
                ?>
                <span class="btn_order_red" onclick="/**/HavewarehouseStorepurchaseOrderVerifyClick('<?php echo $roworder["order_master_bianhao"]?>','<?php echo $roworder["order_master_name"]?>','<?php echo $rowlastorder["order_bianhao"]?>','<?php echo $rowlastorder["order_factory_bianhao"]?>','jhrk')">档口签收</span>
                <?php
                }
                ?>
                <span class="btn_order_red" onclick="/**/PrintOrder(<?php echo $roworder["order_bianhao"]?>)">打印</span>
            </div>
        </div>
        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
            <?php
            if ($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="dkbhck")
            {
            ?>
            <div style="float:left; padding:5px 0; font-size:12px"><span style="color:#999999">补货时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">操作用户：</span><?php echo $roworder["order_user_name"];?></div>
            <?php
                if ($order_send_state=="1")
                {
            ?>
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">发货时间：</span><?php echo $order_send_date; ?></div>
            <?php
                }
                if ($order_send_state=="0" and $roworder["order_is_verify"]=="2")
                {
                    $rsreciveorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rowreciveorder=mysql_fetch_array($rsreciveorder);
            ?>
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">签收时间：</span><?php echo date("Y-m-d H:i:s",$rowreciveorder["order_addtime"]); ?></div>
            <?php
                }
                if ($order_send_state=="1" and $roworder["order_is_verify"]=="2")
                {
                    $rsreciveorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao=(SELECT order_bianhao FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."')", $dbconn); 
                    $rowreciveorder=mysql_fetch_array($rsreciveorder);
            ?>
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">签收时间：</span><?php echo date("Y-m-d H:i:s",$rowreciveorder["order_addtime"]); ?></div>
            <?php
                }
            }
            elseif ($roworder["order_type"]=="jhrk" or $roworder["order_type"]=="ckrk")
            {
            ?>
            <div style="float:left; padding:5px 0; font-size:12px"><span style="color:#999999">入库时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">操作用户：</span><?php echo $roworder["order_user_name"];?></div>
            <?php
            }
            ?>
        </div>
        <div class="stock_table_tbody3">
            <div style="width:25%;">货号</div>
            <div style="width:15%; text-align:center">颜色</div>
            <div style="width:15%; text-align:center">尺码</div>
            <div style="width:15%; text-align:center">成本价</div>
            <div style="width:10%; text-align:center">补货数量</div>
            <div style="width:10%; text-align:center">发货数量</div>
            <div style="width:10%; text-align:center">签收数量</div>
        </div>
        <?php
        $shop_totalnum=0;
        $shop_totalprice=0;
        $arr_order_detail=get_application_order_detail($roworder["order_bianhao"]);
        foreach ($arr_order_detail as $order_detail_barcode) 
        { 
            if (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="dkbhck") and $roworder["order_is_verify"]=="0")
            {
                $shop_totalnum+=$order_detail_barcode["detail_apply_num"]=="-1"?"0":$order_detail_barcode["detail_apply_num"];
                $shop_totalprice+=($order_detail_barcode["detail_apply_num"]=="-1"?"0":$order_detail_barcode["detail_apply_num"])*$order_detail_barcode["detail_valueprice"];
            }
            elseif (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="dkbhck") and $roworder["order_is_verify"]=="1")
            {
                $shop_totalnum+=$order_detail_barcode["detail_send_num"]=="-1"?"0":$order_detail_barcode["detail_send_num"];
                $shop_totalprice+=($order_detail_barcode["detail_send_num"]=="-1"?"0":$order_detail_barcode["detail_send_num"])*$order_detail_barcode["detail_valueprice"];
            }
            elseif ((($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="dkbhck") and $roworder["order_is_verify"]=="2") or (($roworder["order_type"]=="dkbhgcfhdkqs" or $roworder["order_type"]=="dkbhckfhdkqs") and $roworder["order_source_bianhao"]=="0"))
            {
                $shop_totalnum+=$order_detail_barcode["detail_inbound_num"]=="-1"?"0":$order_detail_barcode["detail_inbound_num"];
                $shop_totalprice+=($order_detail_barcode["detail_inbound_num"]=="-1"?"0":$order_detail_barcode["detail_inbound_num"])*$order_detail_barcode["detail_valueprice"];
            }
        ?>        
        <div class="stock_table_row3">
            <div style="width:25%;"><?php echo $order_detail_barcode["detail_p_huohao"]?></div>
            <div style="width:15%; "><?php echo $order_detail_barcode["detail_p_color"]?></div>
            <div style="width:15%;"><?php echo $order_detail_barcode["detail_p_size"]?></div>
            <div style="width:15%;"><?php echo $order_detail_barcode["detail_valueprice"]?></div>
            <div style="width:10%;"><?php echo $order_detail_barcode["detail_apply_num"]=="-1"?"-":$order_detail_barcode["detail_apply_num"] ?></div>
            <div style="width:10%;"><?php echo $order_detail_barcode["detail_send_num"]=="-1"?"-":$order_detail_barcode["detail_send_num"] ?></div>
            <div style="width:10%;"><?php echo $order_detail_barcode["detail_inbound_num"]=="-1"?"-":$order_detail_barcode["detail_inbound_num"] ?></div>
        </div>
        <?php
        }
        ?>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span style="font-size:12px"><span style="color:#999999"><?php echo $order_status_des ?>数量总计：</span><span style=" font-size:12px; color:#ee583d"><?php echo $shop_totalnum?></span> <span style="color:#999999"><?php echo $order_status_des ?>成本总计：</span><span style="font-size:12px; color:#ee583d"><?php echo $shop_totalprice?></span></span>
        </div>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span class="btn_order_red" onclick="/**/DeleteOrder(<?php echo $roworder["order_bianhao"]?>,'view_stock_storepurchase','form_dkbh')">删除</span>
        </div>
    </div>
</div>
<?php
}
?>

<div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个订单</div>

<script>/*n*/    
var page_count_dkbh=<?php echo $page_count; ?>;
/**/set_page_list_dkbh($("#pages_dkbh").find("#m"));
</script>

<!-- refresh_end -->
<div class="showpage" id="pages_dkbh">
    <input id="page_idx_dkbh" name="page_idx" style="display:none" value="1"/>
    <span style="display:block">
        <span class="pagelink" id="last" onclick="/**/click_page_num_dkbh($(this))" >上一页</span>
        <span class="pagelink" id="ll" onclick="/**/click_page_num_dkbh($(this))" />
        <span class="pageblank"  id="lb">...</span>
        <span class="pagelink" id="l2" onclick="/**/click_page_num_dkbh($(this))" />
        <span class="pagelink" id="l1" onclick="/**/click_page_num_dkbh($(this))" />
        <span class="pageselect" id="m"  onclick="/**/click_page_num_dkbh($(this))"  >1</span>
        <span class="pagelink" id="r1" onclick="/**/click_page_num_dkbh($(this))" />
        <span class="pagelink" id="r2" onclick="/**/click_page_num_dkbh($(this))" />
        <span class="pageblank"  id="rb">...</span>
        <span class="pagelink" id="rr" onclick="/**/click_page_num_dkbh($(this))" />
        <span class="pagelink" id="next" onclick="/**/click_page_num_dkbh($(this))" >下一页</span>
    </span>
</div>
</form> <!-- 页码也作为表单项统一处理  -->

<div id="layer_storepurchase_select_storewarehouse" style="float:left; width:650px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; margin:10px 0; padding:10px 0; font-size:14px; color:#ee583d; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">请先选择当前处理业务归属的档口！</div>
    <div class="listclassblock">
        <div class="listclassdefault">档口：</div>
    </div>
    <div style="float:left; width:90%; display:block">
        <?php
        $p=cselect("*","ydf_dangkou",array("dangkou_type='1' and dangkou_endtime>? and dangkou_boss_m_bianhao=?",strtotime(date("Y-m-d H:i:s")),$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","dangkou_bianhao");
        while ($rowdangkou=$p[0]->fetch())
        {
            $havewarehouse_type="no";
        
            $rswarehouse=mysql_query("SELECT * FROM ydf_dangkou_warehouse WHERE dangkou_warehouse_dangkou_bianhao='".$rowdangkou["dangkou_bianhao"]."'" , $dbconn);
            if ($rowwarehouse=mysql_fetch_array($rswarehouse))
            {
                $havewarehouse_type="yes";
            }
        ?>
        <div class="listclassvalueblock">
            <div class="listclassvalue" onclick="/**/SuperManagerStorepurchaseSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>','<?php echo $havewarehouse_type ?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<div id="layer_storepurchase_select_factory" style="float:left; width:400px; padding:25px; overflow:hidden; display:none">
    <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
        <span style="float:left; width:120px; padding-top:8px; text-align:right"><span style="color:red">*</span> 工厂：</span>
        <span style="float:left;margin-left:10px">
            <select id="storepurchase_select_factory" name="storepurchase_select_factory" style="padding:5px">    
                <option value="">选择</option>    
                <?php
                $p=cselect("*","ydf_factory",array("factory_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","factory_bianhao");
                while ($rowdata=$p[0]->fetch())
                {
                ?>
                <option value="<?php echo $rowdata["factory_bianhao"]?>"><?php echo $rowdata["factory_name"]?></option>    
                <?php
                }
                ?>        
            </select>
        </span>
    </div>
    <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
        <span style="float:left; margin-left:130px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer" onclick="/**/PostStorepurchaseSelectFactory()">下一步</span>
    </div>
</div>

<script type="text/javascript">
var storepurchase_havewarehouse_type; var storepurchase_current_opt_type;

var storepurchase_order_type; var storepurchase_select_factory;

var storepurchase_select_storewarehouse_bianhao="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]:"" ?>"; 
var storepurchase_select_storewarehouse_name="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"]:"" ?>";

function StorepurchaseClick(opt_type)
{ 
    var status_userpurview=true;
    $.ajax({
        url:"check-store-userpurview", 
        async: false,
        type: "POST",
        data:"",
        dataType:"json",
        success: function(html){
            if (parseInt(html["state"])==1001)
            {
                storepurchase_select_storewarehouse_bianhao=html["current_master_bianhao"]; 
                storepurchase_select_storewarehouse_name=html["current_master_name"];
                storepurchase_havewarehouse_type=html["current_havewarehouse_type"];
            }
            else if (parseInt(html["state"])==1002)
            {
                storepurchase_current_opt_type=opt_type;
                
                index_layer_storepurchase_select_storewarehouse=layer.open({
                    type: 1,
                    area: ['720px', '300px'],
                    title: false,
                    content:$('#layer_storepurchase_select_storewarehouse')
                });
                
                status_userpurview=false;
            }
            else if (parseInt(html["state"])==1003)
            {
                storepurchase_select_storewarehouse_bianhao=html["current_master_bianhao"]; 
                storepurchase_select_storewarehouse_name=html["current_master_name"];
                storepurchase_havewarehouse_type=html["current_havewarehouse_type"];
            }
        }
    });
    
    if(status_userpurview==true)
    {
        if (opt_type=="znbh")
        {
            if (storepurchase_havewarehouse_type=="no")
            {
                mount_to_frame('view_stock_nowarehouse_storepurchase_auto',1,'frame_stock_storepurchase');
            }
            else if (storepurchase_havewarehouse_type=="yes")
            {
                mount_to_frame('view_stock_havewarehouse_storepurchase_auto',1,'frame_stock_storepurchase');
            }
        }
        else if (opt_type=="zjrk")
        {
            if (storepurchase_havewarehouse_type=="no")
            {
                storepurchase_order_type="jhrk";
                
                index_layer_storepurchase_select_factory=layer.open({
                    type: 1,
                    area: ['470px', '200px'],
                    title: false,
                    content:$('#layer_storepurchase_select_factory')
                });
            }
            else if (storepurchase_havewarehouse_type=="yes")
            {
                storepurchase_order_type="ckrk";
                
                mount_to_frame('view_stock_havewarehouse_storepurchase_submit?var_order_type='+storepurchase_order_type,1,'frame_stock_storepurchase')
            }
        }
    }
}

function SuperManagerStorepurchaseSelectDangkouStore(dangkou_bianhao,dangkou_name,havewarehouse_type){
    storepurchase_select_storewarehouse_bianhao=dangkou_bianhao;
    storepurchase_select_storewarehouse_name=dangkou_name;
    
    layer.close(index_layer_storepurchase_select_storewarehouse);    

    if (storepurchase_current_opt_type=="znbh")
    {    
        if (havewarehouse_type=="no")
        {
            mount_to_frame('view_stock_nowarehouse_storepurchase_auto?var_master_bianhao='+dangkou_bianhao,1,'frame_stock_storepurchase');
        }
        else if (havewarehouse_type=="yes")
        {
            mount_to_frame('view_stock_havewarehouse_storepurchase_auto?var_master_bianhao='+dangkou_bianhao,1,'frame_stock_storepurchase');
        }
    }
    else if (storepurchase_current_opt_type=="zjrk")
    {
        if (havewarehouse_type=="no")
        {
            storepurchase_order_type="jhrk";
            
            index_layer_storepurchase_select_factory=layer.open({
                type: 1,
                area: ['470px', '200px'],
                title: false,
                content:$('#layer_storepurchase_select_factory')
            });    
        }
        else if (havewarehouse_type=="yes")
        {
            storepurchase_order_type="ckrk";
            mount_to_frame("view_stock_havewarehouse_storepurchase_submit?var_master_bianhao="+dangkou_bianhao+"&var_order_type="+storepurchase_order_type,1,"frame_stock_storepurchase");
        }
    }
}

function PostStorepurchaseSelectFactory()
{
    if  ($("#storepurchase_select_factory").val()=="")
    {
        alert("请先选择工厂！");
        return false;
    }
    
    storepurchase_select_factory=$("#storepurchase_select_factory").val();

    layer.close(index_layer_storepurchase_select_factory);
     
    mount_to_frame("view_stock_nowarehouse_storepurchase_submit?var_factory_bianhao="+$("#storepurchase_select_factory").val()+"&var_order_type="+storepurchase_order_type,1,"frame_stock_storepurchase");
}

function NowarehouseStorepurchaseOrderVerifyClick(storepurchase_order_master_bianhao, storepurchase_order_master_name, storepurchase_last_order_bianhao, storepurchase_order_factory_bianhao, storepurchase_order_type)
{
    mount_to_frame("view_stock_nowarehouse_storepurchase_submit?var_master_bianhao="+storepurchase_order_master_bianhao+"&var_master_name="+storepurchase_order_master_name+"&var_last_order_bianhao="+storepurchase_last_order_bianhao+"&var_factory_bianhao="+storepurchase_order_factory_bianhao+"&var_order_type="+storepurchase_order_type,1,"frame_stock_storepurchase");
}

function HavewarehouseStorepurchaseOrderVerifyClick(storepurchase_order_master_bianhao, storepurchase_order_master_name, storepurchase_last_order_bianhao, storepurchase_order_type)
{
    mount_to_frame("view_stock_havewarehouse_storepurchase_submit?var_master_bianhao="+storepurchase_order_master_bianhao+"&var_master_name="+storepurchase_order_master_name+"&var_last_order_bianhao="+storepurchase_last_order_bianhao+"&var_order_type="+storepurchase_order_type,1,"frame_stock_storepurchase");
}


$(document).ready(function() {

        $(".datepicker").datepicker({duration:""});
        $(".datepicker").datepicker({duration:""});//绑定输入框

    });;
</script>

