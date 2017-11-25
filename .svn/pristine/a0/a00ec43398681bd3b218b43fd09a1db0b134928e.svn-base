<?php
if (update("ydf_member",array("m_password"=>md5($_REQUEST["var_password"])),array("m_mobile=? or m_bd_mobile=?",$_REQUEST["var_mobile"],$_REQUEST["var_mobile"]) ))
{
	echo "1001";	
}
else
{
	echo "1002";
}
?>
