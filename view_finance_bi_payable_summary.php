
<form id="form_gcyf_bi">
    <div class="search_box">
        <div class="search_box_inner">
            <div style="float:left" class="gcjx_a ismall_nav" names="bi_time" page="view_finance_bi_payable_summary">
                <span class="listtypevalue listtypeselect" values="bi_time:day">日报</span>
                <span class="listtypevalue" values="bi_time:week">周报</span>
                <span class="listtypevalue" values="bi_time:month">月报</span>
                <span class="listtypevalue" values="bi_time:year">年报</span>
            </div>
            <div class="gcjx_b">
                <div class="lf">
                    <select  name="factory_id">
                        <option value="">全部工厂</option><?php get_factory_option(); ?>
                    </select>
                </div>
                <span  id="btn_copy_search" class="btn_normal_blue public_search_sm" style="margin-top:1px; margin-right:7px;" onclick="search('view_finance_bi_payable_summary','form_gcyf_bi')" >搜索</span>
                <span class="clear_search" onclick="mount_to_frame('view_finance_bi_payable_summary',1,'frame_finance_bi_out_summary')">清空<br>条件</span>
            </div>
        </div>
    </div>
    <div class="report_table_header" style="margin-top:0px; background:#f2f2f2">
        <div style="color:#999999; width:10%">时间</div>
        <div style="color:#999999; width:15%">工厂</div>
        <div style="color:#999999; width:15%">上月结余应付</div>
        <div style="color:#999999; width:15%">+本期进货</div>
        <div style="color:#999999; width:15%">-本期退货</div>
        <div style="color:#999999; width:15%">-本期已付</div>
        <div style="color:#999999; width:15%">=本月结余应付</div>
    </div>

<!-- refresh_begin -->
<?php 
include_once "{$root_path}/model/model_bi.php";
$ymd=empty($_REQUEST["bi_time"])?"day":$_REQUEST["bi_time"];
@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600-1:null;
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize; 

list($historys,$addup)=get_history_dealer_gcyf($ymd,@$_REQUEST["factory_id"]);

$rowcount=count($historys);$page_count=ceil($rowcount/$pagesize);  
for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
    //$row=$historys[$sorts[$idx][0] ];
    $row=$historys[$idx];
    $p=rselect("factory_name","ydf_factory",array("factory_bianhao=?",$row["bill_factory_id"]));
    $nam="";
    if($ro=$p->fetch()){
        $nam=$ro["factory_name"];
    }
    $last_row=$row["last"]>=0?$historys[$row["last"]]:null;
    $last_pool=!is_null($last_row)?$last_row["sum"]["pool"]:0;
?>
    <div class="report_table_body" style="border-bottom:1px dashed #cccccc">
        <div style="width:10%"><?php echo show_report_date($ymd,$row["bill_{$ymd}"])?></div>
        <div style="width:15%"><span style="color:#333"><?php echo $nam?></span></div>
        <div style="width:15%"><span style="color:#333"><?php echo $last_pool?></span></div>
        <div style="width:15%"><span style="color:#333"><?php echo $row["gcyf"]?></span></div>
        <div style="width:15%"><span style="color:#333"><?php echo $row["gcys"]?></span></div>
        <div style="width:15%"><span style="color:#333"><?php echo $row["gcsf"]?></span></div>
        <div style="width:15%"><span style="color:#333"><?php echo $row["sum"]["pool"]?></span></div>
    </div>                    
<?php 
}
?>
    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>
    <script>    
    $("#pid_view_finance_bi_payable_summary #pages").set_page_count("view_finance_bi_payable_summary","pages",<?php echo $page_count;?>);
    </script>
<!-- refresh_end -->
    <div class="ipages" id="pages" page="view_finance_bi_payable_summary" form="form_gcyf_bi" count="<?php echo $page_count; ?>"/>
</form>

