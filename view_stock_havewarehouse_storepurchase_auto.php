<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_order.php");

$arr_data=get_replenish_plan($_REQUEST["var_master_bianhao"],"ckfh");
echo json_encode($arr_data);

$rswarehouse=mysql_query("SELECT * FROM ydf_dangkou WHERE dangkou_bianhao = (select dangkou_warehouse_warehouse_bianhao from ydf_dangkou_warehouse where dangkou_warehouse_dangkou_bianhao='".$_REQUEST["var_master_bianhao"]."')" , $dbconn);
$rowwarehouse=mysql_fetch_array($rswarehouse);
?>
<div style="float:left; width:100%; margin:20px auto 0 auto; overflow:hidden; display:block;">
    <span style="float:right">
        <span class="btn_normal_red" onclick="/**/mount_to_frame('view_stock_storepurchase',0,'frame_stock_storepurchase')">返回</span>
    </span>
</div>
<div style="width:99%; margin:20px auto 0 auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
    <div style="float:left; width:98%; padding:10px 1%; overflow:hidden; display:block">
        <div style="width:100%; margin:0 auto; padding:10px 0; overflow:hidden; display:block;">
            <div style="float:left; padding:5px 0; font-size:12px"><span style="color:#999999">仓库：<span><?php echo $rowwarehouse["dangkou_name"] ?></div>
            <div style="float:right; text-align:right">
                <span class="btn_order_red" onclick="/**/mount_to_frame('view_stock_havewarehouse_storepurchase_submit?var_storepurchase_auto=yes&var_master_bianhao=<?php echo $_REQUEST["var_master_bianhao"] ?>&var_order_type=dkbhck',1,'frame_stock_storepurchase')">确认补货</span>
            </div>
        </div>
        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
            <div style="float:left; width:16%; font-size:12px; color:#999999">货号</div>
            <div style="float:left; width:16%; font-size:12px; color:#999999; text-align:center">颜色</div>
            <div style="float:left; width:16%; font-size:12px; color:#999999; text-align:center">尺码</div>
            <div style="float:left; width:16%; font-size:12px; color:#999999; text-align:center">历史7日销量</div>
            <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">日均量|日增量</div>
            <div style="float:left; width:16%; font-size:12px; color:#999999; text-align:center">明日销量预估</div>
            <div style="float:left; width:16%; font-size:12px; color:#999999; text-align:center">建议补货数量</div>
        </div>  
        <?php
        $order_totalnum=0;
        $order_totalprice=0;
        foreach ($arr_data as $key => $value) 
        {
            if ($value)
            {
                foreach ($value["barcodes"] as $barcode) 
                { 
                    $order_totalnum+=$barcode["detail_order_num"];
                    $order_totalprice+=$barcode["detail_order_num"]*$barcode["detail_valueprice"];
                    $detail_avg_num=round($barcode["detail_avg_num"],2);
                    $detail_avg_k=round($barcode["detail_avg_k"],2);
                    $historys=json_encode($barcode["history"]);
        ?>    
        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
            <div style="float:left; width:16%; height:20px; font-size:12px"><?php echo $barcode["detail_p_huohao"]?></div>
            <div style="float:left; width:16%; height:20px; font-size:12px; text-align:center"><?php echo $barcode["detail_p_color"]?></div>
            <div style="float:left; width:16%; height:20px; font-size:12px; text-align:center"><?php echo $barcode["detail_p_size"]?></div>
            <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $historys?></div>
            <div style="float:left; width:16%; height:20px; font-size:12px; text-align:center"><?php echo $detail_avg_num."|".$detail_avg_k?></div>
            <div style="float:left; width:16%; height:20px; font-size:12px; text-align:center"><?php echo $barcode["detail_predict_num"]?></div>
        </div>
        <?php
                }
            }
        }
        ?>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span style="font-size:12px; color:#333333">数量总计：<span style=" font-size:12px; color:#ee583d"><?php echo $order_totalnum?></span>, 金额总计：<span style="font-size:12px; color:#ee583d"><?php echo $order_totalprice?></span></span>
        </div>
    </div>
</div>

