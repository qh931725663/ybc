<?php $new_pid="pid_view_get_deal_finance_detail__".$_REQUEST["var_factory_id"] ?>
<?php $new_page="view_get_deal_finance_detail__".$_REQUEST["var_factory_id"] ?>

<form id="form_jxdzmx">
<input id="page_idx2" name="page_idx" type="hidden" />
<input name="var_factory_id" value="<?php echo $_REQUEST["var_factory_id"] ?>" type="hidden"/>
</form>
<!-- refresh_begin -->
<div class="title_stalls" style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
    <div style="width:13%; height:15px"></div>
    <div style="width:13%; color:#999999; text-align:center">最近交易时间</div>
    <div style="width:13%; color:#999999; text-align:center">类型</div>
    <div style="width:12%; color:#999999; text-align:center">单号</div>
    <div style="width:12%; color:#999999; text-align:center">数量</div>
    <div style="width:12%; color:#999999; text-align:center">金额</div>
    <div style="width:13%; color:#999999; text-align:center">结余</div>
</div>
<?php
include_once "{$root_path}/model/model_bi.php";
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize;
$factory_array= get_stream_jxdz(@$_REQUEST["var_factory_id"]);
debug($factory_array);
$rowcount=count($factory_array);
$page_count=ceil($rowcount/$pagesize);
for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
{

    $idx=$rowcount-1-$i;
    $ro=$factory_array[$idx];
    if($ro["bill_type"]=="gcys"){
        $ro["bill_type"]="退货";
    }
    if($ro["bill_type"]=="gcsf"){
        $ro["bill_type"]="付款";
    }
    if($ro["bill_type"]=="gcyf"){
        $ro["bill_type"]="发货";
    }
    $p_order=rselect("*","ydf_order",array("order_bianhao=?",$ro['bill_source_id']));
    debug($p_order);
    $danhao="";
    if($ro_a=$p_order->fetch())
    {
        $danhao = $ro_a["order_express_bianhao"];
    }
    $p_order_d=rselect("sum(detail_order_num)","ydf_order_detail",array("detail_order_bianhao=? and detail_factory_mode=2",$ro_a['order_bianhao']));
    if($ro_b=$p_order_d->fetch())
    {
        $num=$ro_b["sum(detail_order_num)"];
    }
?>


<div class="report_table_body" style="border-bottom:1px dashed #cccccc">
          <div style="width:13%; height:15px"></div>
          <div style="width:13%; text-align:center"><?php if($ro["bill_add_time"]>1){echo date("Y-m-d H:i:s",$ro["bill_add_time"]);}else{echo "初始化";}?></div>
          <div style="width:13%; text-align:center; <?php if($ro["bill_type"]=="发货"){echo "color:#333;";}else{echo "color:red;";} ?> "><?php echo $ro["bill_type"] ?></div>
          <div style="width:12%; text-align:center"><?php echo $danhao ?></div>
          <div style="width:12%; text-align:center"><?php echo $num ?></div>
          <div style="width:12%; text-align:center; <?php if($ro["bill_type"]=="发货"){echo "color:#333;";}else{echo "color:red;";} ?> "><?php if($ro["bill_type"]=="发货"){echo $ro["bill_fund"];}else{if($ro["bill_fund"]=="0"){echo $ro["bill_fund"];}else{echo "-".$ro["bill_fund"];}} ?></div>
          <div style="width:12%; text-align:center; <?php if($ro["bill_type"]=="发货"){echo "color:#333;";}else{echo "color:red;";} ?>"> <?php echo $ro["pool"]; ?></div>
      </div>
<?php
}
?>
<div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>

<script>/*n*//*n*/
    $("#<?php echo $new_pid ?> #pages_get_deal_finance_detail").set_page_count("<?php echo $new_page ?>","pages_get_deal_finance_detail",<?php echo $page_count;?>);
</script>
<!-- refresh_end -->
<div class="ipages" input_idx_id="#<?php echo $new_pid ?>  #page_idx2" id="pages_get_deal_finance_detail" page="<?php echo $new_page ?>" form="form_jxdzmx" count="<?php echo $page_count; ?>"/>

