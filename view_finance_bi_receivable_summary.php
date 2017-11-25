<div class="search_box">
    <div class="search_box_inner">
        <div class="zqdz_a">
            <input type="hidden" id="order_type" name="order_type"/>
            <span class="listtypevalue listtypeselect">全部</span>
        </div>
        <div class="zqdz_b">
            <span>
                <span>日期 <input type="text" class="datepicker" name="search_store_dangkoubuhuo_from_date"  size="12" maxlength="50" readonly="readonly"> 至 <input type="text" class="datepicker" name="search_sotre_dangkoubuhuo_to_date" size="12" maxlength="50" readonly="readonly">
                </span>
            </span>
            <span id="btn_chukuorder_search" class="btn_normal_red">搜索</span>
        </div>
    </div>
    <div class="report_table_header" style="background:#f2f2f2">
        <div style="color:#999999; width:30%">账期起止时间</div>
        <div style="color:#999999; width:20%">卖家</div>
        <div style="color:#999999; width:10%">上期欠款</div>
        <div style="color:#999999; width:10%">+ 本期拿货</div>
        <div style="color:#999999; width:10%">- 本期退货</div>
        <div style="color:#999999; width:10%">- 本期还款</div>
        <div style="color:#999999; width:10%">= 本期欠款</div>
    </div>
<!-- refresh_begin -->
<?php
include_once "{$root_path}/model/model_bi.php";
list($historys,$final_addup) = get_history_credit_seller_mjys(@$_REQUEST["seller_id"]);
foreach ($historys as $row)
{
    $pseller=rselect("*","ydf_seller",array("seller_bianhao=?",$row["bill_seller_id"]));
    $seller_name="";
    if ($rseller=$pseller->fetch())
        $seller_name=$rseller["seller_name"];
    list($stime,$etime)=explode("-",$row["bill_credit_range"]);
    $range_str=date("Y-m-d",$stime)."至".date("Y-m-d",$etime);
    
    $last_pool=0;
    if ($row["last"]!=-1)
        $last_pool=$historys[$row["last"]]["sum"]["pool"];

?>
    
    <div class="report_table_body" style="border-bottom:1px dashed #cccccc">
        <div style="width:30%"><?php echo $range_str ?></div>
        <div style="width:20%"><?php echo $seller_name?></div>
        <div style="width:10%"><?php echo $last_pool ?></div>
        <div style="width:10%"><?php echo $row["mjys"] ?></div>
        <div style="width:10%"><?php echo $row["mjyf"] ?></div>
        <div style="width:10%"><?php echo $row["mjssd"]?></span></div>
        <div style="width:10%"><?php echo $row["sum"]["pool"]?></div>
    </div>                    
<?php
}
?>
    <div class="record"> 共 <span class="record_num">4</span> 条记录</div>
<!-- refresh_end -->

</div>

<script>
    $(document).ready(function() {

        $(".datepicker").datepicker({duration:""});
        $(".datepicker").datepicker({duration:""});//绑定输入框

    });;
</script>
