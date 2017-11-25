<?php

include_once("check_factory_user.php");
include_once("{$root_path}/model/model_order.php");
?>
<script type="text/javascript">    
function search_gcdz()
{
    $("#pid_view_factory_bill_agent #pages_gcdz").set_page_num("view_factory_bill_agent","pages_gcdz",1);

    refresh_inner("view_factory_bill_agent?"+$("#form_gcdz").serialize() );
}

function click_me_gcdz(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");
		$("#stock_warehousepurchase_order_is_verify").attr("value","");
		if (state!="")
        $('#stock_warehousepurchase_order_is_verify').attr("value",state);

    search_gcdz();
}
</script>
<form id="form_gcdz">
    <div class="report_table_header" style="margin-top:10px; background:#f2f2f2">
        <div style="width:17%; color:#999999; text-align:center">最近交易时间</div>
        <div style="width:17%; color:#999999; text-align:center">类型</div>
        <div style="width:16%; color:#999999; text-align:center">单号</div>
        <div style="width:16%; color:#999999; text-align:center">数量</div>
        <div style="width:16%; color:#999999; text-align:center">金额</div>
        <div style="width:17%; color:#999999; text-align:center">结余资产</div>
    </div>

<!-- refresh_begin -->
<?php
include_once "{$root_path}/model/model_bi.php";
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize;
@$factory_bianhao=$_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"];
$factory_array= get_stream_dxdz(@$factory_bianhao);
$rowcount=count($factory_array);
$page_count=ceil($rowcount/$pagesize);
for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;
    $ro=$factory_array[$idx];
    debug($ro);
    if($ro["bill_type"]=="sqyf"&&$ro["bill_source_id"]==0){
        $ro["bill_type"]="主动付款";
    }
    if($ro["bill_type"]=="sqyf"&&$ro["bill_source_id"]!=0){
        $ro["bill_type"]="提现";
    }
    if($ro["bill_type"]=="gcyf_dx"){
        $ro["bill_type"]="发货";

    }
    if($ro["bill_type"]=="gcys_dx"&&$ro["bill_small_type"]=="qcfc"){
        $ro["bill_type"]="退货";
    }
    if($ro["bill_type"]=="gcys_dx"&&$ro["bill_small_type"]=="thfc"){
        $ro["bill_type"]="退货";
    }
    $p_order=rselect("*","ydf_order",array("order_bianhao=?",$ro['bill_source_id']));
    debug($p_order);
    $danhao="";
    if($ro_a=$p_order->fetch())
    {
        $danhao = $ro_a["order_express_bianhao"];
    }
    $p_order_d=rselect("sum(detail_order_num)","ydf_order_detail",array("detail_order_bianhao=?",$ro_a['order_bianhao']));
    if($ro_b=$p_order_d->fetch())
    {
        $num=$ro_b["sum(detail_order_num)"];
    }
?>
<div class="report_table_body" style="border-bottom:1px dashed #cccccc">
    <div style="width:17%; text-align:center"><?php echo date("Y-m-d H:i:s",$ro["bill_add_time"])?></div>
    <div style="width:17%; text-align:center;  <?php if($ro["bill_type"]=="发货"){echo "color:#333;";}else{echo "color:red;";}?> "><?php echo $ro["bill_type"] ?></div>
    <div style="width:16%; text-align:center"><?php echo $danhao ?></div>
    <div style="width:16%; text-align:center"><?php echo $num ?></div>
    <div style="width:16%; text-align:center; <?php if($ro["bill_type"]=="发货"){echo "color:#333;";}else{echo "color:red;";}?> "><?php if($ro["bill_type"]=="发货"){echo $ro["bill_fund"];}else{echo "-".$ro["bill_fund"];} ?></div>
    <div style="width:17%; text-align:center; <?php if($ro["bill_type"]=="发货"){echo "color:#333;";}else{echo "color:red;";}?> "><?php echo $ro["pool"] ?></div>
</div>
<?php
}
?>

<div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个记录</div>

<script>/*n*/    
$("#pid_view_factory_bill_agent #pages_gcdz").set_page_count("view_factory_bill_agent","pages_gcdz",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
<div class="ipages" id="pages_gcdz" page="view_factory_bill_agent" form="form_gcdz" count="<?php echo $page_count; ?>"></div>
</form> <!-- 页码也作为表单项统一处理  -->
<script type="text/javascript">
function FactoryOrderSendClick(factorysend_order_master_bianhao, factorysend_order_master_name, factorysend_last_order_bianhao, factorysend_order_factory_bianhao)
{
    mount_to_frame("view_factory_send_submit?var_master_bianhao="+factorysend_order_master_bianhao+"&var_master_name="+factorysend_order_master_name+"&var_last_order_bianhao="+factorysend_last_order_bianhao+"&var_factory_bianhao="+factorysend_order_factory_bianhao,1,"frame_factory_send_list");
}
</script>
