<?php

?>
<?php
if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or $_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4")
{
    if (empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]))
    {
?>
    <div class="menu_link menu_link_select" onclick="set_menu_select($(this));mount_to_frame('view_index')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_play.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">销售直播</span>
    </div>
    <div id="shandianchuhuo" class="menu_link" id="trigger_salse_cashier" onclick="set_menu_select($(this));mount_to_frame('frame_cashier')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_cashier.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">闪电出货</span>
    </div>
<?php
    }
    else
    {
?>
    <div id="shandianchuhuo" class="menu_link menu_link_select" id="trigger_salse_cashier" onclick="set_menu_select($(this));mount_to_frame('frame_cashier')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_cashier.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">闪电出货</span>
    </div>
<?php  
    }
?>
    <div class="menu_link" onclick="set_menu_select($(this));mount_to_frame('frame_sales')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_sales.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">销售管理</span>
    </div>
    <div class="menu_link" onclick="set_menu_select($(this));mount_to_frame('frame_stock')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_warehouse.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">库存管理</span>
    </div>
    <div class="menu_link" id="factory_procurement" onclick="set_menu_select($(this));mount_to_frame('frame_finance_factory')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_purchase.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">工厂采购</span>
    </div>
    <div class="menu_link" onclick="set_menu_select($(this));mount_to_frame('frame_finance_dangkou')" id="financial_management">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_finance.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">财务管理</span>
    </div>
    <div class="menu_link_noline" style="margin-top:25px" onclick="set_menu_select($(this));mount_to_frame('frame_products')">
        <span style="float:left; width:100%; font-size:14px; color:#ffffff; text-align:center; display:block">商品设置</span>
    </div>
    <div class="menu_link_noline" onclick="set_menu_select($(this));mount_to_frame('frame_seller')">
        <span style="float:left; width:100%; font-size:14px; color:#ffffff; text-align:center; display:block">卖家设置</span>
    </div>
    <div class="menu_link_noline" onclick="set_menu_select($(this));mount_to_frame('frame_factory')">
        <span style="float:left; width:100%; font-size:14px; color:#ffffff; text-align:center; display:block">工厂设置</span>
    </div>
    <div class="menu_link_noline" onclick="set_menu_select($(this));mount_to_frame('frame_set')">
        <span style="float:left; width:100%; font-size:14px; color:#ffffff; text-align:center; display:block">基本设置</span>
    </div>
<?php
}
?>
<?php
if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="2")
{
?>
    <div class="menu_link menu_link_select" onclick="set_menu_select($(this));mount_to_frame('view_index')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_play.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">销售直播</span>
    </div>
    <div class="menu_link" onclick="set_menu_select($(this));mount_to_frame('frame_factory_send')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_purchase.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">发货管理</span>
    </div>
    <div class="menu_link" onclick="set_menu_select($(this));mount_to_frame('frame_factory_fund')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_finance.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">财务管理</span>
    </div>
    <div class="menu_link" onclick="set_menu_select($(this));mount_to_frame('frame_factory_sales')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_sales.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">销量统计</span>
    </div>
    <div class="menu_link" onclick="set_menu_select($(this));mount_to_frame('frame_factory_stock')">
        <span style="width:20px; height:20px; margin:0 auto; background:url(/pc/images/menu_icon_warehouse.png); display:block"></span>
        <span style="float:left; width:100%; padding-top:5px; font-size:14px; color:#ffffff; text-align:center; display:block">库存查询</span>
    </div>
    <div class="menu_link_noline" style="margin-top:25px" onclick="set_menu_select($(this));mount_to_frame('frame_factory_products')">
        <span style="float:left; width:100%; font-size:14px; color:#ffffff; text-align:center; display:block">商品设置</span>
    </div>
    <div class="menu_link_noline" onclick="set_menu_select($(this));mount_to_frame('frame_factory_set')">
        <span style="float:left; width:100%; font-size:14px; color:#ffffff; text-align:center; display:block">基本设置</span>
    </div>
<?php
}
?>
    <?php if($DEBUG){?>
    <div class="menu_link_noline" onclick="set_menu_select($(this));mount_to_frame('frame_debug')">
        <span style="float:left; width:100%; font-size:14px; color:#ffffff; text-align:center; display:block">系统调试</span>
    </div>
    <?php } ?>
<script type="text/javascript">
mount_to_frame('view_index');

function set_menu_select(obj)
{
    $(".menu_link").removeClass('menu_link_select');
    $(".menu_link_noline").removeClass('menu_link_select');
    obj.addClass('menu_link_select');
}
</script>

