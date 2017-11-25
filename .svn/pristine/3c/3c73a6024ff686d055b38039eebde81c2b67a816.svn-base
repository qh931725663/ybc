<?php
include_once("check_dangkou_user.php");

mysql_query("delete from ydf_member where m_bianhao = (select user_self_m_bianhao from ydf_user where user_bianhao='".$_REQUEST["var_user_bianhao"]."')", $dbconn);
mysql_query("delete from ydf_user where user_bianhao='".$_REQUEST["var_user_bianhao"]."'", $dbconn);
?>