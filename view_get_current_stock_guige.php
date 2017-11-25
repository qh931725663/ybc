                        <div style="float:left;width:100%;padding:10px 0;background:#f1f1f1">
                            <ul class="lf" style="width:100%">
                                <li class="lf" style="width:14%; height:15px;text-align:center;text-align:center;margin-left:3%">颜色</li>
                                <li class="lf" style="width:14%; height:15px;text-align:center;">尺码</li>
                                <li class="lf" style="width:11%; font-size:13px;text-align:center;margin-left:1.5%">总库存</li>
                                <li class="lf" style="width:11%; height:15px;text-align:center;margin-left:3%">七日总销</li>
                                <li class="lf" style="width:6%;text-align:center;margin-left:7%">档口库存</li>
                                <li class="lf" style="width:12%; height:15px;text-align:center;margin-left:7%">仓库库存</li>
                            </ul>
                        </div>
<?php
include_once "{$root_path}/model/model_bi.php";

$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];

$ymd=empty($_REQUEST["bi_time"])?"day":$_REQUEST["bi_time"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id="";

$group=array("detail_order_{$ymd}","detail_p_color");
$types=array('thdj',  'kccsh','jhrk','thsj','ckrk','dbrk', 'phth','xsck','qcfc','ckck','dbck');
$where=array(
    "detail_boss_m_bianhao=? and detail_master_bianhao=? and detail_master_bianhao!=0 and detail_p_huohao=? and detail_p_color!=''",
    $boss_id,$order_master_id,$_REQUEST["get_stock_guige_huohao"]
);
$sums=array();
foreach($types as $type)
    $sums[]="sum(CASE WHEN detail_order_type='{$type}' THEN detail_order_num ELSE 0 END ) as {$type}";
$historys=bi_select($sums,"ydf_order_detail",$where,$group,"pool_stocks");
$sorts=sort_rows($historys,$group,1);
$rowcount=count($historys);

$value_date=$_REQUEST["get_stock_guige_time"];
for ($i=0;$i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
    $row_main=$historys[$sorts[$idx][0] ];
    
    if (date("Y-m-d",$row_main["detail_order_{$ymd}"])<=$_REQUEST["get_stock_guige_time"] and $row_main["sum"]["pool"])
    {
        $value_date=date("Y-m-d",$row_main["detail_order_{$ymd}"]);
        break;
    }
}
for ($i=0;$i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
    $row_main=$historys[$sorts[$idx][0] ];
    
    if (date("Y-m-d",$row_main["detail_order_{$ymd}"])==$value_date)
    {

?>
                        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
                            <div style="float:left; width:14%; font-size:14px; text-align:center;margin-left:3%"><?php echo $row_main["detail_p_color"] ?></div>
                            <div style="float:left; width:8%; font-size:14px; text-align:center;margin-left:17%;"><?php echo round($row_main["sum"]["pool"]) ?></div>
                            <div style="float:left; width:7%; height:15px;text-align:center;margin-left:6%">?</div>
                            <div style="float:left; width:7%; height:15px;text-align:center;margin-left:9%">?</div>
                            <div style="float:left; width:7%; height:15px;text-align:center;margin-left:9%;">?</div>
                            <div style="float:left; width:12%; text-align:center"><span style="font-size:14px; color:#0099FF; cursor:pointer" onclick="/**/ShowStockProductSize('<?php echo $_REQUEST["get_stock_guige_huohao"] ?>','<?php echo $row_main["detail_p_color"] ?>','<?php echo $_REQUEST["get_stock_guige_time"] ?>')">详细</span></div>
                        </div>
                        <div id="layer_stock_product_guige_<?php echo $_REQUEST["get_stock_guige_huohao"] ?>_<?php echo $row_main["detail_p_color"] ?>_<?php echo $_REQUEST["get_stock_guige_time"] ?>" style="width:100%; margin:0 auto; overflow:hidden; display:none">
                        </div>
<?php
    }
}
?>
<script type="text/javascript">    
function ShowStockProductSize(p_huohao,p_color,time)
{
    if ($("#layer_stock_product_guige_"+p_huohao+"_"+p_color+"_"+time).is(":visible")==false)
    {
        $('#get_stock_guige_huohao').attr("value",p_huohao);
        $('#get_stock_guige_color').attr("value",p_color);
        $('#get_stock_guige_time').attr("value",time);
        $.ajax({
            url:"view-get-current-stock-size",
            async: false,
            type: "POST",
            data:$("#form_stock_bi").serialize(),
            success: function(html){
                $("#layer_stock_product_guige_"+p_huohao+"_"+p_color+"_"+time).html(html);
                $("#layer_stock_product_guige_"+p_huohao+"_"+p_color+"_"+time).show();
            }
        });
    }
    else
    {
        $("#layer_stock_product_guige_"+p_huohao+"_"+p_color+"_"+time).hide();
    }
}
</script>