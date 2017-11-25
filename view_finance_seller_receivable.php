<?php

include_once("check_dangkou_user.php");
?>
<form id="form_mjysdz">
<div  style="float:left; width:100%; margin:10px 0; padding:5px; overflow:hidden; display:block">
    <div style="float:right; overflow:hidden; display:block">
        <span style="float:left; overflow:hidden; display:block">
            <input class="iinput name_iime ino_ime_input iseller_name" id="mjysdz_searchwords" name="seller_id" type="text" placeholder="请输入卖家拼音首字母" autocomplete="off" style="width:168px;"/></span>
        </span>
        <span id="btn_chukuorder_search" onclick="search('view_finance_seller_receivable','form_mjysdz')" class="btn_normal_blue">搜索</span>
        <span class="clear_search">清空<br>条件</span>
    </div>
</div>
<input id="page_idx" name="page_idx" type="hidden" value="1" />
</form>
<div class="report">
    <div class="report_table_tbody">
        <div style="width:15%">卖家</div>
        <div style="width:15%">最近交易时间</div>
        <div style="width:15%">类型</div>
        <div style="width:15%">数量</div>
        <div style="width:15%">金额</div>
        <div style="width:15%">应收</div>
        <div style="width:10%">对账</div>
    </div>

<!-- refresh_begin -->
<?php
include_once("{$root_path}/model/model_bi.php");
$ymd=empty($_REQUEST["bi_time"])?"day":$_REQUEST["bi_time"];
$ymd="week";
@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600-1:null;
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize;
$p_seller=rselect("seller_bianhao","ydf_seller",array("seller_name=?",@$_REQUEST["seller_id"]));
if ($r_seller=$p_seller->fetch())
    $seller_bianhao=$r_seller["seller_bianhao"];
list($historys,$addup) = get_history_sellers("day",@$seller_bianhao);
$rowcount=count($addup);
debug($addup);
$page_count=ceil($rowcount/$pagesize);
$ret=[];
foreach ($addup as $key=>$value)
{
    //$ret[]=$value;
    $ret[]=$historys[$value["now"] ];
}
$sorts=sort_rows($ret,array("bill_day","bill_seller_id"),1);
debug($ret);
for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;
    $row=$ret[$sorts[$idx][0]];
    debug($row);
    $p=rselect("seller_name","ydf_seller",array("seller_bianhao=?",$row["bill_seller_id"]));
    if($ro=$p->fetch()){
        $nam=$ro["seller_name"];
    }
    $last_idx=$row["last"];
    $last_pool=0;
    if ($last_idx>=0)
        $row_last=$historys[$last_idx];

    $last_pool=$row_last["sum"]["pool"];
?>
    <div class="report_table_row">

        <div style="width:15%;text-align:center"><?php echo $nam?></div>
        <div style="width:15%;text-align:center">-</div>
        <div style="width:15%;text-align:center">-</div>
        <div style="width:15%;text-align:center">-</div>
        <div style="width:15%;text-align:center">-</div>
        <div style="width:15%;text-align:center"><?php echo $row["sum"]["pool"]?></div>
        <div style="width:10%;text-align:center">
            <span style="color:#0099FF; cursor:pointer" onclick="/**/ClickSellerFinanceDetail(<?php echo $row["bill_seller_id"]?>)">对账</span>
            <span style="color:#0099FF; cursor:pointer" onclick="/**/ShowReceivableSeller(<?php echo $row["bill_seller_id"]?>,<?php echo $last_pool ?>)">收款记账</span>
        </div>
    </div>
    <div id="layer_seller_finance_detail_<?php echo $row["bill_seller_id"]?>" style="float:left; width:100%; background:#f2f2f2; overflow:hidden; display:none">
    </div>
 <?php
 }
 ?>
    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>
    <script>/*n*//*n*/
    $("#pid_view_finance_seller_receivable #pages_seller_receivable").set_page_count("view_finance_seller_receivable","pages_seller_receivable",<?php echo $page_count;?>);
    </script>
<!-- refresh_end -->
    <div class="ipages" input_idx_id="#pid_view_finance_seller_receivable #page_idx" id="pages_seller_receivable" page="view_finance_seller_receivable" form="form_mjysdz" count="<?php echo $page_count; ?>"/>

</div>
<div id="layer_receivable_fund" style="float:left; width:400px; padding:25px; overflow:visible; display:none">

<script type="text/javascript">
function ClickSellerFinanceDetail(seller_id){
if ($("#layer_seller_finance_detail_"+seller_id).is(":visible")==false)
{
    $("#layer_seller_finance_detail_"+seller_id).show();
    mount_to_frame('view_get_seller_finance_detail__'+seller_id+'?var_seller_id='+seller_id,0,'layer_seller_finance_detail_'+seller_id);
}else{
    $("#layer_seller_finance_detail_"+seller_id).hide();}
}

function ShowReceivableSeller(seller_id,receivable_fund){
    $.ajax({
        url:"view-get-receivable-seller",
        async: false,
        type: "POST",
        data:{var_seller_id:seller_id,var_receivable_fund:receivable_fund},
        success: function(html){
            $("#layer_receivable_fund").html(html);
        }
    });

    index_layer_receivable_fund=layer.open({
        type: 1,
        area: ['450px', '350px'],
        title: false,
        content:$('#layer_receivable_fund')
    });
}

function PostFactoryPay(){
    if(!$("#bill_bank").val())
    {
        $("#tip_notice_receivable_seller").html("<span style='font-size:12px; color:red'>亲，请选择收款资金账户哦！</span>");
        return false;
    }

    if(!$("#bill_fund").val())
    {
        $("#tip_notice_receivable_seller").html("<span style='font-size:12px; color:red'>亲，请填写实收金额哦！</span>");
        return false;
    }

    $.ajax({
        url:"model-bill-insert",
        async: false,
        type: "POST",
        dataType:"json",
        data:$("#vform_receivable_fund").serialize(),
        error:function(){
            layer.close(index_layer_receivable_fund);
            layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
        },
        success: function(html){
            layer.close(index_layer_receivable_fund);
            if (html.state!="ok"){
                layer.msg('提交失败！', {time: 2000, icon:2});
                return;
            }
            layer.msg('提交成功！', {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_finance_reg_receivable',1,'frame_finance_reg_receivable');
            },0);
        }
    });
}
</script>