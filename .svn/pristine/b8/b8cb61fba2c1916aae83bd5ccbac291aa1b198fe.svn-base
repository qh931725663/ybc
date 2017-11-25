<div style="float:left; width:96%; padding:5px 0; overflow:hidden; display:block">
    <div style="float:left; width:30%; color:#999999">卖家</div>
    <div style="float:left; width:20%; color:#999999; text-align:center">销售额</div>
    <div style="float:left; width:20%; color:#999999; text-align:center">欠款</div>
    <div style="float:left; width:20%; color:#999999; text-align:center">退货</div>
    <div style="float:left; width:10%; color:#999999; text-align:center">走势</div>
</div>
<div style="float:left; width:100%; max-height:250px; overflow:auto; display:block;">
<?php
$case_day="";
if ($_REQUEST["var_date_type"]=="today")
    $case_day=strtotime(date("Y-m-d"));
$case_month="";
if ($_REQUEST["var_date_type"]=="thismonth")
    $case_month=strtotime(date("Y-m"));
$where=array("bill_seller_id>'0' and bill_boss_id=? and bill_day=? and bill_month=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"], $case_day, $case_month );
$where=clean_where($where);
$p=cselect("bill_seller_id, bill_source_type, bill_source_id, 
sum(if(bill_type='mjys',bill_fund,0)) as sales_fund,
sum(CASE WHEN bill_type='mjys' AND bill_is_credit_seller=0 AND bill_is_credit=1 THEN bill_fund ELSE 0 END ) as skqk,
sum(CASE WHEN bill_type='mjys' AND bill_is_credit_seller=1 THEN bill_fund ELSE 0 END ) as zqqk,
sum(if(bill_type='thzc',bill_fund,0)) as thzc
",
"ydf_finance_bill",$where,"bill_seller_id","sales_fund desc");
while($row=$p[0]->fetch())
{
    $seller_name="";
    if ($row["bill_seller_id"]>1)
    {
        $p_seller=cselect("*","ydf_seller",array("seller_bianhao=?",$row["bill_seller_id"]) );
        $rowseller=$p_seller[0]->fetch();
        $seller_name=$rowseller["seller_name"];
    }
    else
    {
       $seller_name="匿名"; 
    }   
?>
<div style="float:left; width:100%; padding:3px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
    <div style="float:left; width:30%; padding:5px 0"><?php echo $seller_name ?></div>
    <div style="float:left; width:20%; padding:5px 0; text-align:center"><?php echo round($row["sales_fund"]) ?></div>
    <div style="float:left; width:20%; padding:5px 0; text-align:center"><?php echo round($row["skqk"]+$row["zqqk"]) ?></div>
    <div style="float:left; width:20%; padding:5px 0; text-align:center"><?php echo round($row["thzc"]) ?></div>
    <div style="float:left; width:10%"><span onclick="click_charts_type('sales','<?php echo $row["bill_seller_id"] ?>','<?php echo $seller_name ?>')" style="width:15px; height:15px; margin:0 auto; padding:5px; background:url(/pc/images/icon_addup.jpg) center center no-repeat; display:block; cursor:pointer"/></div>
</div>
<?php
}
?>
</div>