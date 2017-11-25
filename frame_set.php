<?php

include_once("check_dangkou_user.php");
?>
<div class="frame_main_div" >
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <?php
            if ( ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1"  or (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1") ) and empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) )
            {
            ?>
            <span class="frame_tab_item_select" onclick="mount_to_frame('frame_store',0,'frame_set')">档口设置</span>
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_warehouse',0,'frame_set')">仓库设置</span>
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_user',0,'frame_set')">员工设置</span>
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_bank',0,'frame_set')">资金账户</span>
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_personal',0,'frame_set')">个人信息</span>
            <?php
            }
            else
            {
            ?>
            <span class="frame_tab_item_select"        onclick="mount_to_frame('frame_personal',0,'frame_set')">个人信息</span>
            <?php   
            }
            ?>
            
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_password',0,'frame_set')">密码修改</span>
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_mobile',0,'frame_set')">手机绑定</span>
        </div>
    </div>    
    <div id="frame_set" />
</div>
<script>
<?php
if ( ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1"  or (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1") ) and empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) )
{
?>
mount_to_frame('frame_store',0,'frame_set');
<?php
}
else
{
?>
mount_to_frame('frame_personal',0,'frame_set');
<?php
}
?>
</script>