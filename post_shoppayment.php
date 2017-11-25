<?php

include_once("check_dangkou_user.php");

$nowtime=strtotime(date("Y-m-d H:i:s"));

$rsdangkou=mysql_query("select * from ydf_dangkou where dangkou_type='1' and dangkou_bianhao='".$_REQUEST["shoppayment_dangkou_bianhao"]."'", $dbconn);
$rowdangkou=mysql_fetch_array($rsdangkou);

$service_money=0;
if ($_REQUEST["shoppayment_dangkou_years"]=="1")
{
    $service_money=12000;
}
elseif ($_REQUEST["shoppayment_dangkou_years"]=="2")
{
    $service_money=24000;
}

mysql_query("insert into ydf_dangkou_service_money set service_money_type='2', service_money_dangkou_bianhao='".$rowdangkou["dangkou_bianhao"]."', service_money_buy_years='".$_REQUEST["shoppayment_dangkou_years"]."', service_money='$service_money', service_money_addtime='$nowtime'", $dbconn);
?>