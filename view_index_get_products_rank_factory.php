<div style="float:left; width:100%; padding:5px 0; overflow:hidden; display:block">
    <div style="float:left; width:60%; color:#999999">货号</div>
    <div style="float:left; width:30%; color:#999999; text-align:center">销量</div>
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
$where=array("detail_boss_m_bianhao=? and detail_order_day=? and detail_order_month=? and detail_factory_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"], $case_day, $case_month, $_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"] );
$where=clean_where($where);
$p=cselect("detail_p_huohao, 
sum(CASE WHEN detail_order_type in ('xsck','phth') THEN detail_order_num ELSE 0 END ) as sales_num
",
"ydf_order_detail",$where,"detail_p_huohao","sales_num desc");
while($row=$p[0]->fetch())
{  
?>
<div style="float:left; width:100%; padding:3px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
    <div style="float:left; width:60%; padding:5px 0"><?php echo $row["detail_p_huohao"] ?></div>
    <div style="float:left; width:30%; padding:5px 0; text-align:center"><?php echo round($row["sales_num"]) ?></div>
    <div style="float:left; width:10%"><span onclick="click_charts_type('products','<?php echo $row["detail_p_huohao"] ?>')" style="width:15px; height:15px; margin:0 auto; padding:5px; background:url(/pc/images/icon_addup.jpg) center center no-repeat; display:block; cursor:pointer"/></div>
</div>
<?php
}
?>
</div>