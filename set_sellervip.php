<?php

include_once("check_dangkou_user.php");

if ($_REQUEST["var_seller_vip"]=="0")
{
    $seller_isvip="0";
}
elseif ($_REQUEST["var_seller_vip"]=="1")
{
    $seller_isvip="1";
}

mysql_query("update ydf_seller set seller_isvip='$seller_isvip' where seller_bianhao='".$_REQUEST["var_seller_bianhao"]."'", $dbconn);
?>