<?php
session_start();


$p_factory=cselect("*","ydf_factory",array("factory_mobile=? and factory_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_LOGIN_MOBILE"],$_REQUEST["var_boss_id"]));
$rowfactory=$p_factory[0]->fetch();

$p_boss=cselect("*","ydf_member",array("m_bianhao=?",$rowfactory["factory_boss_m_bianhao"]));
$rowboss=$p_boss[0]->fetch();
        
$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]=$rowfactory["factory_boss_m_bianhao"];
$_SESSION["ERP_ACCOUNT_USER_BOSS_NAME"]=$rowboss["m_realname"];
$_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"]=$rowfactory["factory_bianhao"];
$_SESSION["ERP_ACCOUNT_USER_SELF_M_BIANHAO"]="0";

echo $rowboss["m_realname"];
?>