                        <div style="float:left;width:100%;padding:10px 0;background:#f2f2f2">
                            <ul class="lf" style="width:100%;border-bottom:1px dashed #cccccc;padding:3px 0 9px 0;">
                                <li class="lf" style="width:8%; height:15px;text-align:center;text-align:center;margin-left:8%">颜色</li>
                                <li class="lf" style="width:8%; height:15px;text-align:center;">尺码</li>
                                <li class="lf" style="width:8%;text-align:center;">总库存</li>
                                <li class="lf" style="width:8%;text-align:center;margin-left:9%;"></li>
                                <li class="lf" style="width:10%; height:15px;text-align:center;margin-left:12%">七日均销</li>
                                <li class="lf" style="width:12%; height:15px;text-align:center;margin-left:10%">七日总销</li>
                            </ul>
                        </div>
<?php
include_once "{$root_path}/model/model_bi.php";
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id="";

$product_id=$_REQUEST['get_stock_guige_huohao'];
@$factory_id=$_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"];
$group=array("detail_p_huohao","detail_p_color","detail_master_bianhao");
list($historys,$detail_addup)=get_history_stock_num($ymd="day",$group,$factory_id,$product_id,$order_master_id,null,null,null);
debug($detail_addup);

//得到每个货号的公司总库存，不区分档口
$group=array("detail_p_huohao","detail_p_color");
list($historys2,$addup)=get_history_stock_num($ymd="day",$group,$factory_id,$product_id,$order_master_id,null,null,null);
debug($addup);

//七日总销和均销
$group=array("detail_p_huohao","detail_p_color");
$where=array("detail_p_huohao=?",$product_id);
$event_inventory=predict(7,7,7,$group,$where);
debug($event_inventory);
//得到档口列表
$dangkou_arr=get_dangkou_list();//档口仓库和编号数组
debug($dangkou_arr);

$rowcount=count($addup);
$add_ar=[];
$ret=[];
foreach ($addup as $key=>$value)
{
    $add_ar[]=$key;
    $ret[]=$value;
}
debug($ret);
debug($add_ar);
for ($i=0;$i<$rowcount;$i++)
{
    $pool=$ret[$i]["pool"];
    list($huohao,$color) = split('#', $add_ar[$i]);
    debug($color);
    if(array_key_exists($huohao.'#'.$color, $event_inventory)==false){
        $avg_num=0;
        $total_num=0;
    }else{
        $avg_num=round($event_inventory[$huohao.'#'.$color]["avg_num"]);
        $total_num=round($event_inventory[$huohao.'#'.$color]["total_num"]);
    }
?>
                        <div style="width:100%; margin:0 auto;background:#f2f2f2; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
                            <div style="float:left; width:8%;height:17px;text-align:center;margin-left:8%"><?php echo $color ?></div>
                            <div style="float:left; width:8%;text-align:center;">-</div>
                            <div style="float:left; width:6%; height:15px;text-align:center;margin-left:1%"><?php echo floatval($pool) ?></div>
                            <div class="kucun_sp" style="float:left; width:26%;text-align:center;margin-left:3%"></div>
                            <div style="float:left; width:8%;text-align:center;margin-left:14%;"><?php echo $avg_num ?></div>
                            <div style="float:left; width:6%;text-align:center;margin-left:14%;"><?php echo $total_num ?></div>
                            <div style="float:left; width:7%; text-align:center;margin-left:5%;"><span style="color:#0099FF; cursor:pointer" onclick="/**/ShowStockProductSize('<?php echo $_REQUEST["get_stock_guige_huohao"] ?>','<?php echo $factory_id ?>','<?php echo $color ?>')">详细</span></div>
                        </div>
                        <div id="layer_stock_product_guige_size_<?php echo $_REQUEST["get_stock_guige_huohao"] ?>_<?php echo $color ?>" style="width:100%; margin:0 auto; overflow:hidden; display:none">
                        </div>
<?php
}
?>
<script type="text/javascript">    
function ShowStockProductSize(p_huohao,factory_id,p_color)
{
    if ($("#layer_stock_product_guige_size_"+p_huohao+"_"+p_color).is(":visible")==false)
    {

        $.ajax({
            url:"view-factory-get-stock-size",
            async: false,
            type: "POST",
            data:{get_stock_guige_huohao:p_huohao,factory_id:factory_id,kucun_color:p_color},
            success: function(html){
                $("#layer_stock_product_guige_size_"+p_huohao+"_"+p_color).show();
                $("#layer_stock_product_guige_size_"+p_huohao+"_"+p_color).html(html);
            }
        });
    }
    else
    {
        $("#layer_stock_product_guige_size_"+p_huohao+"_"+p_color).hide();
    }
}
</script>