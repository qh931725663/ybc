<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_order.php");

$arr_data=get_replenish_plan($_REQUEST["var_master_bianhao"],"gcfh");
?>
<div style="float:left; width:100%; margin:20px auto 0 auto; overflow:hidden; display:block;">
    <span style="float:right">
        <span class="btn_normal_red" onclick="/**/mount_to_frame('view_stock_storepurchase',0,'frame_stock_storepurchase')">返回</span>
    </span>
</div>
<?php
foreach ($arr_data as $key => $value) 
{
    $order_totalnum=0;
    $order_totalprice=0;
?>
<div style="width:99%; margin:20px auto 0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
    <div style="float:left; width:98%; padding:10px 1%; overflow:hidden; display:block">
        <div style="width:100%; margin:0 auto; padding:10px 0; overflow:hidden; display:block;">
            <div style="float:left; padding:5px 0; font-size:12px">
            <span style="color:#999999">工厂：</span>
            <?php
            $p=cselect("factory_name","ydf_factory",array("factory_bianhao=? ",$key))[0];
            if ($row=$p->fetch())
            {
                echo $row["factory_name"];
            }
            ?>
            </div>
            <div style="float:right; text-align:right">
                <span class="btn_order_red" onclick="/**/mount_to_frame('view_stock_nowarehouse_storepurchase_submit?var_factory_bianhao=<?php echo $key ?>&var_order_type=dkbhgc',1,'frame_stock_storepurchase')">确认补货</span>
            </div>
        </div>
        <?php
        if (count($value)>"0")
        {
        ?>
        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
            <div style="float:left; width:30%; font-size:12px; color:#999999">货号</div>
            <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">颜色</div>
            <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">尺码</div>
            <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">成本价</div>
            <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">数量</div>
        </div>  
        <?php
        foreach ($value["barcodes"] as $barcode) 
        { 
            $order_totalnum+=$barcode["detail_order_num"];
            $order_totalprice+=$barcode["detail_order_num"]*$barcode["detail_valueprice"];
        ?>    
        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
            <div style="float:left; width:30%; height:20px; font-size:12px"><?php echo $barcode["detail_p_huohao"]?></div>
            <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $barcode["detail_p_color"]?></div>
            <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $barcode["detail_p_size"]?></div>
            <div style="float:left; width:10%; height:20px; font-size:12px; text-align:center"><?php echo $barcode["detail_valueprice"]?></div>
            <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $barcode["detail_order_num"]?></div>
        </div>
        <?php
        }
        ?>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span style="font-size:12px; color:#333333">数量总计：<span style=" font-size:12px; color:#ee583d"><?php echo $order_totalnum?></span>, 金额总计：<span style="font-size:12px; color:#ee583d"><?php echo $order_totalprice?></span></span>
        </div>
        <?php
        }
        else
        {
        ?>
        <div style="width:100%; margin:0 auto; padding:10px 0; border-top:1px solid #cccccc; overflow:hidden; display:block;">暂无补货建议！</div>
        <?php
        }
        ?>
    </div>
</div>
<?php
}
?>

