<?php
if (!empty($_REQUEST['var_code']) and  $_REQUEST["var_code"] <> $_SESSION["ERP_SMS_MOBILEBD_CODE"])
{
    echo "1002"; //验证码不一致
}
else
{
    echo "1001"; //验证码一致
}
?>