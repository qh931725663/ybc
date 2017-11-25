<?php
if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4")
{
    if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]=="2")
    {
        echo "<script language=javascript>alert('对不起，您使用的档口管理系统时间已到期！');</script>";
        echo "<script language=javascript>document.location.href='/myaccount';</script>";
        exit;
    }
}
elseif ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1") //老板登录时操作所需相关标识设置
{    
    if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]=="10")
    {
        echo "<script language=javascript>alert('对不起，请先申请使用档口管理系统！');</script>";
        echo "<script language=javascript>document.location.href='/myaccount';</script>";
        exit;
    }
    elseif (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_COUNT"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_COUNT"]=="1")
    {    
        if ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]=="11")
        {
            echo "<script language=javascript>alert('对不起，档口管理系统申请审核中！');</script>";
            echo "<script language=javascript>document.location.href='/myaccount';</script>";
            exit;
        }
        elseif ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]=="13")
        {
            echo "<script language=javascript>alert('对不起，您使用的档口管理系统时间已到期！');</script>";
            echo "<script language=javascript>document.location.href='/myaccount';</script>";
            exit;
        }
    }
}
?>