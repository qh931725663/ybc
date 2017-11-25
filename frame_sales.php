<?php

include_once("check_dangkou_user.php");
?>
<div class="frame_main_div">
    <div class="frame_tab_panel">
        <div class="frame_tab_line">
            <span class="frame_tab_item_select" onclick="mount_to_frame('frame_arrange_up',0,'frame_sales')">退货上架</span>
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_arrange_factory',0,'frame_sales')">退货返厂</span>
            <?php
            if ( ( ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1"  or (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1") ) and empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) ) or (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1") )
            {
            ?>
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_finance_reg_receivable',0,'frame_sales')">卖家应收</span>
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_sales_bi_seller_time',0,'frame_sales')">卖家统计</span>
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_finance_bi_sales_time',0,'frame_sales')">销售统计</span>
            <span class="frame_tab_item"        onclick="mount_to_frame('frame_sales_bi_sales_time',0,'frame_sales')">商品统计</span>
            <?php
            }
            ?>
        </div>
    </div>    
    <div id="frame_sales"/>
</div>

<script>
mount_to_frame('frame_arrange_up',0,'frame_sales');
</script>
