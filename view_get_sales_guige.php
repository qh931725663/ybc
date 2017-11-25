<?php
include_once "{$root_path}/model/model_bi.php";

$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];

$ymd=empty($_REQUEST["bi_time"])?"day":$_REQUEST["bi_time"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id="";

$group=array("detail_order_{$ymd}","detail_p_color");
$types=array('phth','xsck');
$where=array(
    "detail_boss_m_bianhao=? and detail_master_bianhao=? and detail_p_huohao=? and detail_p_color!='' and detail_order_type in ('". join("','",$types) ."')",
    $boss_id,$order_master_id,$_REQUEST["get_sales_guige_huohao"]
);
function pool_sales($row){
    return $row["phth"]+$row["xsck"];
}
$sums=array();
foreach($types as $type)
    $sums[]="sum(CASE WHEN detail_order_type='{$type}' THEN detail_order_num ELSE 0 END ) as {$type}";
$historys=bi_select($sums,"ydf_order_detail",$where,$group,"pool_sales");
$sorts=sort_rows($historys,$group);
$rowcount=count($historys);

$value_date=$_REQUEST["get_sales_guige_time"];
for ($i=0;$i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
    $row_main=$historys[$sorts[$idx][0] ];
    
    if (date("Y-m-d",$row_main["detail_order_{$ymd}"])<=$_REQUEST["get_sales_guige_time"] and $row_main["sum"]["pool"])
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
                        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block; background:rgb(242, 242, 242);">
                            <div style="float:left; width:12%; height:15px"></div>
                            <div style="float:left; width:11%; height:15px"></div>
                            <div style="float:left; width:11%; text-align:center"><?php echo $row_main["detail_p_color"] ?></div>
                            <div style="float:left; width:11%; height:15px"></div>
                            <div style="float:left; width:11%; text-align:center"><?php echo $row_main["pool"] ?></div>
                            <div style="float:left; width:11%; height:15px"></div>
                            <div style="float:left; width:11%; height:15px"></div>
                            <div style="float:left; width:11%; height:15px"></div>

                            <div style="float:left; width:11%; text-align:center"><span style="color:#0099FF; cursor:pointer" onclick="/**/ShowSalesProductSize('<?php echo $_REQUEST["get_sales_guige_huohao"] ?>','<?php echo $row_main["detail_p_color"] ?>','<?php echo date("Y-m-d",$row_main["detail_order_{$ymd}"]) ?>')">详细</span></div>
                        </div>
                        <div id="layer_sales_product_guige_<?php echo $_REQUEST["get_sales_guige_huohao"] ?>_<?php echo $row_main["detail_p_color"] ?>_<?php echo date("Y-m-d",$row_main["detail_order_{$ymd}"]) ?>" style="width:100%; margin:0 auto; overflow:hidden; display:none">
                        </div>
<?php
    }
}
?>
<script type="text/javascript">    
function ShowSalesProductSize(p_huohao,p_color,time)
{
    if ($("#layer_sales_product_guige_"+p_huohao+"_"+p_color+"_"+time).is(":visible")==false)
    {
        $('#get_sales_guige_huohao').attr("value",p_huohao);
        $('#get_sales_guige_color').attr("value",p_color);
        $('#get_sales_guige_time').attr("value",time);
        $.ajax({
            url:"view-get-sales-size", 
            async: false,
            type: "POST",
            data:$("#form_sbi").serialize(),
            success: function(html){
                $("#layer_sales_product_guige_"+p_huohao+"_"+p_color+"_"+time).html(html);
                $("#layer_sales_product_guige_"+p_huohao+"_"+p_color+"_"+time).show();
            }
        });
    }
    else
    {
        $("#layer_sales_product_guige_"+p_huohao+"_"+p_color+"_"+time).hide();
    }
}
</script>