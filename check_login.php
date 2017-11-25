<?php
if (empty($_SESSION["ERP_ACCOUNT_LOGIN_BIANHAO"]))
{
    echo "<script language=javascript>alert('对不起，您尚未登录或者上次登录已过期！');</script>";
    echo "<script language=javascript>document.location.href='/';</script>";
    exit;
}
?>