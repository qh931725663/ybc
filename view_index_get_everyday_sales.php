<div style="float:left; width:96%; padding:5px 0; overflow:hidden; display:block">
    <div style="float:left; width:25%; color:#999999">日期</div>
    <div style="float:left; width:25%; color:#999999; text-align:center">销售额</div>
    <div style="float:left; width:25%; color:#999999; text-align:center">欠款</div>
    <div style="float:left; width:25%; color:#999999; text-align:center">退货</div>
</div>
<div style="float:left; width:100%; max-height:250px; overflow:auto; display:block;">
<?php
$where=array("bill_boss_id=? and bill_day>=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"], strtotime(date("Y-m-d",strtotime("-29 day"))) );
$where=clean_where($where);
$p=cselect("bill_day, 
sum(if(bill_type='xssr',bill_fund,0)) as sales_fund,
sum(CASE WHEN bill_type='mjys' AND bill_is_credit_seller=0 AND bill_is_credit=1 THEN bill_fund ELSE 0 END ) as skqk,
sum(CASE WHEN bill_type='mjys' AND bill_is_credit_seller=1 THEN bill_fund ELSE 0 END ) as zqqk,
sum(if(bill_type='thzc',bill_fund,0)) as thzc
",
"ydf_finance_bill",$where,"bill_day","bill_day desc",0,14);
while($row=$p[0]->fetch())
{   
?>
<div style="float:left; width:100%; padding:3px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
    <div style="float:left; width:25%; padding:5px 0"><?php echo date("Y-m-d",$row["bill_day"]) ?></div>
    <div style="float:left; width:25%; padding:5px 0; text-align:center"><?php echo round($row["sales_fund"]) ?></div>
    <div style="float:left; width:25%; padding:5px 0; text-align:center"><?php echo round($row["skqk"]+$row["zqqk"]) ?></div>
    <div style="float:left; width:25%; padding:5px 0; text-align:center"><?php echo round($row["thzc"]) ?></div>
</div>
<?php
}
?>
</div>