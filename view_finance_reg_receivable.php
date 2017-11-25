<?php

include_once("check_dangkou_user.php");
?>
<form id="form_mjys">
<div  style="float:left; width:100%; margin:10px 0; padding:5px; overflow:hidden; display:block">
    <div style="float:left; overflow:hidden; display:block; margin-bottom:12px;">
        <span style="float:left; overflow:hidden; display:block">
            <input class="iinput name_iime ino_ime_input iseller_name" id="mjys_searchwords" name="seller_id" type="text" placeholder="请输入卖家拼音首字母" autocomplete="off" style="width:168px;"/></span>
        </span>
        <span id="btn_chukuorder_search" onclick="/**/search_mjys()" class="btn_normal_blue public_search">搜索</span>
        <span class="clear_search" onclick="mount_to_frame('view_finance_reg_receivable',1,'frame_finance_reg_receivable')">清空<br>条件</span>
    </div>
    <div class="txhz_b" style="margin-right:10px;"><span style="color:#333; font-size:20px">总欠款：</span>
        <span style="color:#ee583d; font-size:20px; font-weight:bold;" id="txhz_zongqiankuan">
            <?php
            include_once("{$root_path}/model/model_bi.php");
            include_once("{$root_path}/model/model_bill.php");
            $ymd="week";

            $p_seller=rselect("seller_bianhao","ydf_seller",array("seller_name=? and seller_boss_m_bianhao=?",@$_REQUEST["seller_id"],$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]));
            if ($r_seller=$p_seller->fetch())
                $seller_bianhao=$r_seller["seller_bianhao"];
            list($historys,$addup) = get_history_sellers($ymd,@$seller_bianhao);
            echo sum_addup($addup);
            ?>
        </span>
    </div>

</div>
<input id="page_idx" name="page_idx" type="hidden" value="1" />
</form>

<div class="report" style="margin-top:0;">
    <div class="report_table_tbody">
        <div style="width:15%;">卖家</div>

        <div style="width:14%;">总拿货</div>
        <div style="width:14%;">总退货</div>
        <div style="width:14%;">总退款</div>
        <div style="width:14%;">总已付</div>
        <div style="width:14%;">总欠款</div>
        <div style="width:15%;">收款记账</div>
    </div>

<!-- refresh_begin -->
<span id="txhz_zqk" style="display:none;"><?php echo sum_addup($addup); ?></span>
<?php
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize;
$group=array("bill_{$ymd}","bill_seller_id");
$idx=get_idx($historys,$group);
$addup2=[];
foreach ($addup as $key=>$value)
    $addup2[]=$historys[$value["now"] ];
$sorts=sort_rows($addup2,array("bill_$ymd","bill_seller_id"),1);
$rowcount=count($addup2);
$page_count=ceil($rowcount/$pagesize);
for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;
    $row=$addup2[$sorts[$idx][0] ];

    $pseller=rselect("*","ydf_seller",array("seller_bianhao=?",$row["bill_seller_id"]));
    $seller_name="";
    $seller_cycle="";
    if ($rseller=$pseller->fetch()){
        $seller_name=$rseller["seller_name"];
        $seller_cycle=$rseller["seller_cycle"];
    }


    $last_idx=$row["last"];
    $last_pool=0;
    if ($last_idx>=0){
        $row_last=$historys[$last_idx];
        $last_pool=$row_last["sum"]["pool"];
    }else{$last_pool=0;}


?>
    <div class="report_table_row report_table_body">
        <div style="width:15%;text-align:center;"><?php if($seller_name==""){echo "匿名卖家"; }else{echo $seller_name;}?><span style="<?php if($seller_cycle>0){echo "color:#0099FF";}?>">(<?php if($seller_cycle>0){echo "账期";}else{echo "现结";}?>)</span></div>

        <div style="width:14%;text-align:center;"><?php echo $row["sum"]["mjys"]?></span></div>
        <div style="width:14%;text-align:center;"><?php echo $row["sum"]["mjyf"]?></span></div>
        <div style="width:14%;text-align:center;"><?php echo $row["sum"]["mjsf"]?></span></div>
        <div style="width:14%;text-align:center;"><?php echo $row["sum"]["mjss"]?></span></div>
        <div style="width:14%;text-align:center;"><?php echo $row["sum"]["pool"]?></div>
        <div style="width:15%;text-align:center;">
            <span style="<?php if($seller_cycle>0){echo "color:#0099FF; cursor:pointer";}else{echo "display:none;";} ?>" onclick="ShowReceivableSeller(<?php echo $row["bill_seller_id"]?>,<?php echo $row["sum"]["pool"] ?>)">收款记账</span>
            <span style="<?php if($seller_cycle>0){}else{echo "display:none;";} ?>">|</span>
            <span style="color:#0099FF; cursor:pointer" onclick="/**/ClickSellerFinanceDetail(<?php echo $row["bill_seller_id"]?>)">对账</span>
        </div>


        <?php
        $p_factory_bill=cselect("*","ydf_finance_bill",array("bill_type='mjss' and bill_seller_id=?",$row["bill_seller_id"]),"","bill_id desc");
        if ($row_factory_bill=$p_factory_bill[0]->fetch())
        {
        ?>
        <div style="width:100%; margin:0 auto; overflow:hidden; display:block;">
            <div style="float:right; padding:5px 0">
                <span style="float:left"><span style="color:#999999">最近一次收款日期：</span><?php echo date("Y-m-d H:i:s",$row_factory_bill["bill_add_time"]) ?></span>
                <span style="float:left; margin-left:10px"><span style="color:#999999">收款人：</span><?php echo $row_factory_bill["bill_add_user_id"] ?></span>
                <span style="float:left; margin-left:10px"><span style="color:#999999">收款金额：</span><?php echo $row_factory_bill["bill_fund"] ?></span>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <div id="layer_seller_finance_detail_<?php echo $row["bill_seller_id"]?>" style="float:left; width:100%; background:#f2f2f2; overflow:hidden; display:none">
    </div>
<?php
}
?>
    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>
    <script>/*n*//*n*/
    $("#txhz_zongqiankuan").html($("#txhz_zqk").html());
    $("#pid_view_finance_reg_receivable #pages_reg_receivable").set_page_count("view_finance_reg_receivable","pages_reg_receivable",<?php echo $page_count;?>);
    </script>
<!-- refresh_end -->
    <div class="ipages" input_idx_id="#pid_view_finance_reg_receivable #page_idx" id="pages_reg_receivable" page="view_finance_reg_receivable" form="form_mjys" count="<?php echo $page_count; ?>"/>

</div>


<div id="layer_receivable_fund" style="float:left; width:400px; padding:25px; overflow:visible; display:none">
</div>
<script type="text/javascript">
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


function ClickSellerFinanceDetail(seller_id){
if ($("#layer_seller_finance_detail_"+seller_id).is(":visible")==false)
{
    $("#layer_seller_finance_detail_"+seller_id).show();
    mount_to_frame('view_get_seller_finance_detail__'+seller_id+'?var_seller_id='+seller_id,0,'layer_seller_finance_detail_'+seller_id);
}else{
    $("#layer_seller_finance_detail_"+seller_id).hide();}
}

function search_mjys()
{

    $("#pid_view_finance_reg_receivable  #pages_reg_receivable").set_page_num("","",1);

    refresh_inner("view_finance_reg_receivable?"+$("#form_mjys").serialize() );
}
</script>
