<?php

include_once("check_dangkou_user.php");

$p_order=cselect("*","ydf_order",array("order_bianhao=?",$_REQUEST["var_order_bianhao"]) );
$roworder=$p_order[0]->fetch();
?>
<div style="float:left; width:100%; margin:10px 0; padding:10px 0; font-size:14px; color:#ee583d; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">请先选择放弃提货商品返回的档口或仓库！</div>
<div class="listclassblock">
    <div class="listclassdefault">档口：</div>
</div>
<div style="float:left; width:90%; display:inline-block">
    <?php
    $p=cselect("*","ydf_dangkou",array("dangkou_type='1' and dangkou_endtime>? and dangkou_boss_m_bianhao=?",strtotime(date("Y-m-d H:i:s")),$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","dangkou_bianhao");
    while ($rowdangkou=$p[0]->fetch())
    {
        if ($rowdangkou["dangkou_endtime"]=="0")
        {
            $dangkou_status="0";
        }
        elseif ($rowdangkou["dangkou_endtime"]>strtotime(date("Y-m-d H:i:s")))
        {
            $dangkou_status="1";
        }
        else
        {
            $dangkou_status="2";
        }
    ?>
    <div class="listclassvalueblock">
        <div class="listclassvalue" onclick="view_sales_cashier.PostGiveupPickup(<?php echo $_REQUEST["var_order_bianhao"] ?>,<?php echo $roworder["order_seller_bianhao"] ?>,<?php echo $rowdangkou["dangkou_bianhao"] ?>)"><?php echo $rowdangkou["dangkou_name"] ?></div>
    </div>
    <?php
    }
    ?>
</div>
<div class="listclassblock">
    <div class="listclassdefault">仓库：</div>
</div>
<div style="float:left; width:90%; display:inline-block">
    <?php
    $p=cselect("*","ydf_dangkou",array("dangkou_type='2' and dangkou_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","dangkou_bianhao");
    while ($rowdangkou=$p[0]->fetch())
    {
        if ($rowdangkou["dangkou_endtime"]=="0")
        {
            $dangkou_status="0";
        }
        elseif ($rowdangkou["dangkou_endtime"]>strtotime(date("Y-m-d H:i:s")))
        {
            $dangkou_status="1";
        }
        else
        {
            $dangkou_status="2";
        }
    ?>
    <div class="listclassvalueblock">
        <div class="listclassvalue" onclick="view_sales_cashier.PostGiveupPickup(<?php echo $_REQUEST["var_order_bianhao"] ?>,<?php echo $roworder["order_seller_bianhao"] ?>,<?php echo $rowdangkou["dangkou_bianhao"] ?>)"><?php echo $rowdangkou["dangkou_name"] ?></div>
    </div>
    <?php
    }
    ?>
</div>
