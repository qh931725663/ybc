<?php

include_once("check_factory_user.php");
include_once("{$root_path}/model/model_order.php");
?>
<script type="text/javascript">    
function search_gcfh()
{
    $("#pid_view_factory_send_list #pages_gcfh").set_page_num("view_factory_send_list","pages_gcfh",1);

    refresh_inner("view_factory_send_list?"+$("#form_gcfh").serialize() );
}

function click_me_gcfh(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");
		$("#stock_warehousepurchase_order_is_verify").attr("value","");
		if (state!="")
        $('#stock_warehousepurchase_order_is_verify').attr("value",state);

    search_gcfh();
}
</script>
<form id="form_gcfh">
<div class="sdsy_setup">
    <div class="sdsy_nave" style="margin-top:20px;">
        <div class="sdsy_nave_a">
            <input type="hidden" id="stock_warehousepurchase_order_is_verify" name="order_is_verify"/>
            <span class="listtypevalue listtypeselect" onclick="/**/click_me_gcfh($(this),'')">全部</span>
            <span class="listtypevalue" onclick="/**/click_me_gcfh($(this),'1')">待发货</span>
            <span class="listtypevalue" onclick="/**/click_me_gcfh($(this),'2')">已发货</span>
            <span class="listtypevalue" onclick="/**/click_me_gcfh($(this),'3')">已入库</span>
        </div>
        <div class="sdsy_nave_b">
            <span class="sdsy_date">
                <span class="sdsy_date_d">日期 <input type="text" class="datepicker" name="factory_send_from_day" size="12" maxlength="50" readonly="readonly"> 至 <input type="text" class="datepicker" name="factory_send_to_day"  size="12" maxlength="50" readonly="readonly">
                </span>
            </span>
            <span onclick="/**/search_gcfh()" class="btn_normal_blue public_search">搜索</span>
            <span class="clear_search" onclick="mount_to_frame('view_factory_send_list',1,'frame_factory_send_list')">清空<br>条件</span>
        </div>
    </div>                        
</div>

<!-- refresh_begin -->
<?php                    
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
@$from_day=$_REQUEST["factory_send_from_day"]?get_ymd($_REQUEST["factory_send_from_day"])["d"]:null;
@$to_day=$_REQUEST["factory_send_to_day"]?get_ymd($_REQUEST["factory_send_to_day"])["d"]+24*3600:null;
@$factory_bianhao=$_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"];

@$order_is_verify=$_REQUEST["order_is_verify"]?$_REQUEST["order_is_verify"]:null;
if($order_is_verify=="1"){
	$order_is_verify="0";
}
elseif($order_is_verify=="2"){
	$order_is_verify="1";
}
elseif($order_is_verify=="3"){
	$order_is_verify="2";
}


$where=@array("order_boss_m_bianhao=? and order_is_verify=? and order_addtime>=? and order_addtime<=? and ( order_type='dkbhgc' or order_type='ckbh' or (order_type='gcfh' and order_source_bianhao=0) or (order_type='jhrk' and order_source_bianhao=0)) and order_factory_bianhao=?",
$boss_id,$order_is_verify,$from_day,$to_day,$factory_bianhao);
$where=clean_where($where);
//print_r($where);
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;
$offset=($page-1)*$pagesize; 
$p=cselect("*","ydf_order",$where,"","order_addtime desc",$offset,$pagesize);
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
<div class="stock">
    <div class="stock_inner">
        <div class="stock_table_header">

            <div style="margin-left:10px;padding:5px 0; "><span>采购：</span><span style="color:#0099FF"><?php echo $roworder["order_master_name"];?></span></div>
            <div style="margin-left:10px; padding:5px 0;"><span>发货：</span><span style="color:#0099FF"><?php echo $roworder["order_factory_name"];?></span></div>
            <?php
            $order_status_des="";
            if (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="0")
            {
                $order_status_des="待发货";
            ?>
            <div style="float:left; margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#d64126">待发货</span></div>
            <?php
            }
            elseif (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="1")
            {
                $order_status_des="已发货";
            ?>
            <div style="float:left; margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#0099FF">已发货</span></div>
            <?php
            }
            elseif ((($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="2") or ($roworder["order_type"]=="gcfhgcfhckqs" and $roworder["order_source_bianhao"]=="0"))
            {
                $order_status_des="已入库";
            ?>
            <div style="float:left; margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#009900">已入库</span></div>
            <?php
            }
            ?>
            
            <div style="float:right; text-align:right">
                <?php
                if (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="0")
                {
                ?>
                <span class="btn_order_red" onclick="/**/WarehousepurchaseOrderVerifyClick('<?php echo $roworder["order_master_bianhao"]?>','<?php echo $roworder["order_master_name"]?>','<?php echo $roworder["order_bianhao"]?>','<?php echo $roworder["order_factory_bianhao"]?>','jhrk')">签收</span>
                <?php
                }
                elseif (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="1")
                {
                    $rslastorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rowlastorder=mysql_fetch_array($rslastorder);
                ?>
                <span class="btn_order_red" onclick="/**/WarehousepurchaseOrderVerifyClick('<?php echo $roworder["order_master_bianhao"]?>','<?php echo $roworder["order_master_name"]?>','<?php echo $rowlastorder["order_bianhao"]?>','<?php echo $rowlastorder["order_factory_bianhao"]?>','jhrk')">签收</span>
                <?php
                }
                ?>
                <span class="btn_order_red" onclick="/**/PrintOrder(<?php echo $roworder["order_bianhao"]?>)">打印</span>
            </div>
        </div>
        <div class="warehouse_nave" style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
            <div style="padding:5px 0; "><span style="color:#999999;">编号：</span><?php echo $roworder["order_bianhao"];?></div>
            <?php
            if ($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="gcfh")
            {
            ?>
            <div style=" padding:5px 0; "><span>采购下单时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
            <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">操作用户：</span><?php echo $roworder["order_user_name"];?></div>
            <?php
                if ($order_send_state=="1")
                {
            ?>
            <div style="margin-left:10px; padding:5px 0;"><span>发货时间：</span><?php echo $order_send_date; ?></div>
            <?php
                }
                if ($order_send_state=="0" and $roworder["order_is_verify"]=="2")
                {
                    $rsreciveorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rowreciveorder=mysql_fetch_array($rsreciveorder);
            ?>
            <div style="margin-left:10px; padding:5px 0;"><span>签收时间：</span><?php echo date("Y-m-d H:i:s",$rowreciveorder["order_addtime"]); ?></div>
            <?php
                }
                if ($order_send_state=="1" and $roworder["order_is_verify"]=="2")
                {
                    $rsreciveorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao=(SELECT order_bianhao FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."')", $dbconn); 
                    $rowreciveorder=mysql_fetch_array($rsreciveorder);
            ?>
            <div style="margin-left:10px; padding:5px 0;"><span>签收时间：</span><?php echo date("Y-m-d H:i:s",$rowreciveorder["order_addtime"]); ?></div>
            <?php
                }
            }
            elseif ($roworder["order_type"]=="jhrk")
            {
            ?>
            <div style="padding:5px 0;"><span>入库时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
            <div style="margin-left:10px; padding:5px 0;"><span>操作用户：</span><?php echo $roworder["order_user_name"];?></div>
            <?php
            }
            ?>
        </div>
        <div class="stock_table_tbody3">
            <div style="width:25%;" >货号</div>
            <div style="width:15%;text-align:center">颜色</div>
            <div style="width:15%;text-align:center">尺码</div>
            <div style="width:15%;text-align:center">成本价</div>
            <div style="width:10%;text-align:center">采购数量</div>
            <div style="width:10%;text-align:center">发货数量</div>
            <div style="width:10%;text-align:center">签收数量</div>
        </div>
        <?php
        $shop_totalnum=0;
        $shop_totalprice=0;
        $arr_order_detail=get_application_order_detail($roworder["order_bianhao"]);
        foreach ($arr_order_detail as $order_detail_barcode) 
        { 
            if (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="0")
            {
                $shop_totalnum+=$order_detail_barcode["detail_apply_num"]=="-1"?"0":$order_detail_barcode["detail_apply_num"];
                $shop_totalprice+=($order_detail_barcode["detail_apply_num"]=="-1"?"0":$order_detail_barcode["detail_apply_num"])*$order_detail_barcode["detail_valueprice"];
            }
            elseif (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="1")
            {
                $shop_totalnum+=$order_detail_barcode["detail_send_num"]=="-1"?"0":$order_detail_barcode["detail_send_num"];
                $shop_totalprice+=($order_detail_barcode["detail_send_num"]=="-1"?"0":$order_detail_barcode["detail_send_num"])*$order_detail_barcode["detail_valueprice"];
            }
            elseif ((($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="2") or ($roworder["order_type"]=="gcfhgcfhckqs" and $roworder["order_source_bianhao"]=="0"))
            {
                $shop_totalnum+=$order_detail_barcode["detail_inbound_num"]=="-1"?"0":$order_detail_barcode["detail_inbound_num"];
                $shop_totalprice+=($order_detail_barcode["detail_inbound_num"]=="-1"?"0":$order_detail_barcode["detail_inbound_num"])*$order_detail_barcode["detail_valueprice"];
            }
        ?>        
        <div class="stock_table_row3">
            <div style="width:25%;"><?php echo $order_detail_barcode["detail_p_huohao"]?></div>
            <div style="width:15%;text-align:center"><?php echo $order_detail_barcode["detail_p_color"]?></div>
            <div style="width:15%;text-align:center"><?php echo $order_detail_barcode["detail_p_size"]?></div>
            <div style="width:15%;text-align:center"><?php echo $order_detail_barcode["detail_valueprice"]?></div>
            <div style="width:10%;text-align:center"><?php echo $order_detail_barcode["detail_apply_num"]=="-1"?"-":$order_detail_barcode["detail_apply_num"] ?></div>
            <div style="width:10%;text-align:center"><?php echo $order_detail_barcode["detail_send_num"]=="-1"?"-":$order_detail_barcode["detail_send_num"] ?></div>
            <div style="width:10%;text-align:center"><?php echo $order_detail_barcode["detail_inbound_num"]=="-1"?"-":$order_detail_barcode["detail_inbound_num"] ?></div>
        </div>
        <?php
        }
        ?>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span style="font-size:12px"><span style="color:#999999"><?php echo $order_status_des ?>数量总计：</span><span style=" font-size:12px; color:#ee583d"><?php echo $shop_totalnum?></span> <span style="color:#999999"><?php echo $order_status_des ?>成本总计：</span><span style="font-size:12px; color:#ee583d"><?php echo $shop_totalprice?></span></span>
        </div>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span class="btn_order_red" onclick="/**/DeleteOrder(<?php echo $roworder["order_bianhao"]?>,'view_factory_send_list','form_factory_send_list')">删除</span>
        </div>
    </div>
</div>
<?php
}
?>

<div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个订单</div>

<script>/*n*/    
$("#pid_view_factory_send_list #pages_gcfh").set_page_count("view_factory_send_list","pages_gcfh",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
<div class="ipages" id="pages_gcfh" page="view_factory_send_list" form="form_gcfh" count="<?php echo $page_count; ?>"></div>
</form> <!-- 页码也作为表单项统一处理  -->
<script type="text/javascript">
function FactoryOrderSendClick(factorysend_order_master_bianhao, factorysend_order_master_name, factorysend_last_order_bianhao, factorysend_order_factory_bianhao)
{
    mount_to_frame("view_factory_send_submit?var_master_bianhao="+factorysend_order_master_bianhao+"&var_master_name="+factorysend_order_master_name+"&var_last_order_bianhao="+factorysend_last_order_bianhao+"&var_factory_bianhao="+factorysend_order_factory_bianhao,1,"frame_factory_send_list");
}
</script>
