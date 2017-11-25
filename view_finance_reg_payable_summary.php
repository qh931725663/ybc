<form id="form_jxdz">
    <div class="search_box">
        <div class="search_box_inner" style="margin-bottom:5px;">
            <div class="gcjx_a">
                <div class="lf">
                    <select  name="factory_id" style="padding:5px;">
                        <option value="">全部工厂</option><?php get_factory_option(); ?>
                    </select>
                </div>
                <span  id="btn_copy_search" class="btn_normal_blue public_search_sm" onclick="search('view_finance_reg_payable_summary','form_jxdz')" style="margin-right:7px;">搜索</span>
                <span class="clear_search" onclick="mount_to_frame('view_finance_reg_payable_summary',1,'frame_finance_reg_payable_summary')">清空<br>条件</span>
            </div>
            <div class="gcjx_b" style="margin-right:10px;"><span style="color:#333; font-size:20px">总欠款：</span>
                <span style="color:#ee583d; font-size:20px; font-weight:bold;" id="jxdz_zongqiankuan">
                <?php
                include_once "{$root_path}/model/model_bi.php";
                    $ymd="day";

                    @$factory_bianhao=$_REQUEST["factory_id"];
                    list($historys,$addup)=get_history_dealer_gcyf($ymd,@$factory_bianhao);
                    echo sum_addup($addup);
                ?>
                </span>
            </div>
        </div>
    </div>
    <input id="page_idx" name="page_idx" type="hidden" value="1">
</form>

<div class="report">
    <div class="title_stalls" style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
        <div style="width:17%;">工厂</div>
        <div style="width:16%;">总进货</div>
        <div style="width:16%;">总退货</div>
        <div style="width:16%;">已付</div>
        <div style="width:17%;">总结余</div>
        <div style="width:17%;">记账</div>
    </div>
<!-- refresh_begin -->
<span id="jxdz_zqk" style="display:none;"><?php echo sum_addup($addup); ?></span>
<?php 
include_once "{$root_path}/model/model_bi.php";
    $ymd="day";
    @$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize;
    @$factory_bianhao=$_REQUEST["factory_id"];
    list($historys,$addup)=get_history_dealer_gcyf($ymd,@$factory_bianhao);
    $rowcount=count($addup);
    $page_count=ceil($rowcount/$pagesize);
    $ret=[];
    foreach ($addup as $key=>$value)
    {
        //$ret[]=$value;
        $ret[]=$historys[$value["now"] ];
    }
    $sorts=sort_rows($ret,array("bill_day","bill_factory_id"),1);
    for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
    {
        $idx=$rowcount-1-$i;
        $row=$ret[$sorts[$idx][0]];
        debug($row);
        $p=rselect("factory_name","ydf_factory",array("factory_bianhao=?",$row["bill_factory_id"]));
        if($ro=$p->fetch()){
            $nam=$ro["factory_name"];
        }
    $last_row=$historys[$row["last"]];
?>

    <div class="list_stalls report_table_body" style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
        <div style="width:17%;"><span style="color:#333"><?php echo $nam?></span></div>
        <div style="width:16%;"><span style="color:#333"><?php echo $row["gcyf"]?></span></div>
        <div style="width:16%;"><span style="color:#333"><?php echo $row["gcys"]?></span></div>
        <div style="width:16%;"><span style="color:#333"><?php echo $row["gcsf"]?></span></div>
        <div style="width:17%;"><span style="color:#333"><?php echo $row["sum"]["pool"]?></span></div>
        <div style="width:17%; color:#999999">
            <span style="color:#0099FF; cursor:pointer" onclick="ShowFactoryPayFund(<?php echo $row["bill_factory_id"] ?>,<?php echo $row["sum"]["pool"]?>)">付款</span> |
            <span style="color:#0099FF; cursor:pointer; display:none;" onclick="ShowFactoryReceiveFund(<?php echo $row["bill_factory_id"] ?>,<?php echo $row["sum"]["pool"]?>)">收款</span>
            <span style="color:#0099FF; cursor:pointer" onclick="/**/ClickFactoryFinanceDetail(<?php echo $row["bill_factory_id"]?>)">对账</span>
        </div>

        <?php
        $p_factory_bill=cselect("*","ydf_finance_bill",array("bill_factory_id=? and bill_type='gcsf'",$row["bill_factory_id"]),"","bill_id desc");
        if($row_factory_bill=$p_factory_bill[0]->fetch())
        {
        ?>

        <div style="float:left;width:100%; margin:0 auto; padding:10px 0; overflow:hidden; display:block;">
            <div style="float:right; padding:5px 0">
                <span style="float:left"><span style="color:#999999">最近一次付款日期：</span><?php echo date("Y-m-d H:i:s",$row_factory_bill["bill_add_time"]) ?></span>
                <span style="float:left; margin-left:10px"><span style="color:#999999">付款人：</span><?php echo $row_factory_bill["bill_add_user_id"] ?></span>
                <span style="float:left; margin-left:10px"><span style="color:#999999">付款金额：</span><?php echo $row_factory_bill["bill_fund"] ?></span>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <div id="layer_deal_finance_detail_<?php echo $row["bill_factory_id"]?>" style="float:left; width:100%; background:#f2f2f2; overflow:hidden; display:none">
    </div>
<?php 
}
?>
    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>
    <script>/*n*/
        $("#jxdz_zongqiankuan").html($("#jxdz_zqk").html());
        $("#pid_view_finance_reg_payable_summary #pages_finance_reg_payable_summary").set_page_count("view_finance_reg_payable_summary","pages_finance_reg_payable_summary",<?php echo $page_count;?>);
    </script>
<!-- refresh_end -->
    <div class="ipages" input_idx_id="#pid_view_finance_reg_payable_summary #page_idx" id="pages_finance_reg_payable_summary" page="view_finance_reg_payable_summary" form="form_jxdz" count="<?php echo $page_count; ?>"/>

</div>

<div id="layer_factory_pay_fund" style="float:left; width:400px; padding:25px; overflow:visible; display:none">

</div> 

<div id="layer_factory_receive_fund" style="float:left; width:400px; padding:25px; overflow:visible; display:none">

</div>



<script type="text/javascript">                    
function ShowFactoryPayFund(factory_id,pay_fund){
    $.ajax({
        url:"view-get-factory-pay-fund", 
        async: false,
        type: "POST",
        data:{var_factory_id:factory_id,var_pay_fund:pay_fund},
        success: function(html){
            $("#layer_factory_pay_fund").html(html);
        }
    });

    
    index_layer_factory_pay_fund=layer.open({
        type: 1,
        area: ['450px', '350px'],
        title: false,
        content:$('#layer_factory_pay_fund')
    });
}

function ShowFactoryReceiveFund(factory_id,receive_fund){
    $.ajax({
        url:"view-get-factory-receive-fund", 
        async: false,
        type: "POST",
        data:{var_factory_id:factory_id,var_receive_fund:receive_fund},
        success: function(html){
            $("#layer_factory_receive_fund").html(html);
        }
    });
    
    index_layer_factory_receive_fund=layer.open({
        type: 1,
        area: ['450px', '350px'],
        title: false,
        content:$('#layer_factory_receive_fund')
    });
}



$("#pid_view_finance_reg_payable_summary .layui-layer-close").click(function(){
    layer.close(index_layer_factory_receive_fund);
});

function ClickFactoryFinanceDetail(factory_id){
    if ($("#layer_deal_finance_detail_"+factory_id).is(":visible")==false)
    {
        $("#layer_deal_finance_detail_"+factory_id).show();
        mount_to_frame('view_get_deal_finance_detail__'+factory_id+'?var_factory_id='+factory_id,0,'layer_deal_finance_detail_'+factory_id);
    }else{
        $("#layer_deal_finance_detail_"+factory_id).hide();
    }
}
</script>