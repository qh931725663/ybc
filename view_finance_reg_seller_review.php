
<form class="form_seller_review">
    <div class="report_table_header" style="margin-top:12px; background:#f2f2f2">
        <div style="color:#999999; width:15%">卖家</div>
        <div style="color:#999999; width:30%">当前欠款订单总额</div>
        <div style="color:#999999; width:30%">- 当前退货未付款订单总额</div>
        <div style="color:#999999; width:25%">= 当前结余欠款</div>
    </div>

<!-- refresh_begin -->
<?php
include_once("{$root_path}/model/model_bi.php");
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize;
list($historys,$addup)=get_history_iseller_mjys($ymd="day",@$_REQUEST["seller_id"]);
debug($historys);
$rowcount=count($addup);
$page_count=ceil($rowcount/$pagesize);
$ret=[];
foreach ($addup as $key=>$value)
{
    $ret[]=$value;
}
for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;
    $row=$historys[$ret[$idx]["now"]];
    debug($row);
    $p=rselect("seller_name","ydf_seller",array("seller_bianhao=?",$row["bill_seller_id"]));
    if($ro=$p->fetch()){
        $nam=$ro["seller_name"];
    }
?>
    <div class="report_table_body" style="border-bottom:1px dashed #cccccc">
        <div style="width:15%"><span><?php echo $nam ?></span></div>
        <div style="width:30%"><span><?php echo padd(array($row["sum"]["mjys"]),array($row["sum"]["mjss"]))?></span></div>
        <div style="width:30%"><span><?php echo padd(array($row["sum"]["mjyf"]),array($row["sum"]["mjsf"]))?></span></div>
        <div style="width:25%"><span><?php echo $row["sum"]["pool"]?></span></div>
    </div>
<?php
}
?>
    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>
    <script>/*n*//*n*/
    $("#pid_view_finance_reg_seller_review #pages_seller_review").set_page_count("view_finance_reg_seller_review","pages_seller_review",<?php echo $page_count;?>);
    </script>
<!-- refresh_end -->
    <div class="ipages" id="pages_seller_review" page="view_finance_reg_seller_review" form="form_seller_review" count="<?php echo $page_count; ?>"/>
</form>