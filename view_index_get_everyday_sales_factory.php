<div style="float:left; width:100%; padding:5px 0; overflow:hidden; display:block">
    <div style="float:left; width:60%; color:#999999">日期</div>
    <div style="float:left; width:40%; color:#999999; text-align:center">销售额</div>
</div>
<div style="float:left; width:100%; max-height:250px; overflow:auto; display:block;">
<?php
$where=array("bill_boss_id=? and bill_day>=? and bill_factory_id=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"], strtotime(date("Y-m-d",strtotime("-29 day"))),$_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"] );
$where=clean_where($where);
$p=cselect("bill_day, 
sum(if(bill_type='dxsr',bill_fund,0)) as sales_fund
",
"ydf_finance_bill",$where,"bill_day","bill_day desc",0,14);
while($row=$p[0]->fetch())
{   
?>
<div style="float:left; width:100%; padding:3px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
    <div style="float:left; width:60%; padding:5px 0"><?php echo date("Y-m-d",$row["bill_day"]) ?></div>
    <div style="float:left; width:40%; padding:5px 0; text-align:center"><?php echo round($row["sales_fund"]) ?></div>
</div>
<?php
}
?>
</div>