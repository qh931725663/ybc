<?php 
include_once "{$root_path}/model/model_bi.php";
?>
                    <form id="form_stock_addup">
                        <input  type="hidden" name="bi_time" id="verify_state_stock_bi" value=""/>
                        <input  type="hidden" name="get_stock_guige_huohao" id="get_stock_guige_huohao" value=""/>
                        <input  type="hidden" name="get_stock_guige_color" id="get_stock_guige_color" value=""/>
                        <input  type="hidden" name="get_stock_guige_time" id="get_stock_guige_time" value=""/>
                        <div class="search_box">
                            <div class="search_box_inner">
                                <div class="kcfx_b">
                                    <span class="lf">
                                        <select name="dangkou_id" style="height:30px;width:120px;margin-right:10px;">
                                            <option value="">请选择档口</option>
                                            <?php get_dangkou_option();?>
                                        </select>
                                    </span>
                                    <span class="lf">
                                        <select name="kucun_select_factory" style="height:30px;width:120px;margin-right:10px;">
                                            <option value="">请选择工厂</option>
                                            <?php get_factory_option();?>
                                        </select>
                                    </span>
                                    <span class="lf"><input class="iinput name_iime ino_ime_input iproduct_name"  style="padding-right:20px; width:142px" id="search_stock_bi_huohao" name="search_stock_bi_huohao" type="text" placeholder="请输入商品货号" autocomplete="off " required/></span>
                                    <input id="page_idx" name="page_idx" type="hidden" value="1" />
                                    <span  onclick="/**/search_kucun()" class="btn_normal_blue">搜索</span>
                                </div>
                            </div>
                        </div>
                    </form>
<div class="report">
    <div class="report_table_header">
        <div style="width:8%; font-size:14px; color:#999999;">货号</div>
        <div style="width:8%; font-size:14px; color:#999999;margin-left:10%;">总库存</div>
        <div style="width:8%; font-size:14px; color:#999999;margin-left:13%;">分库存</div>
        <div style="width:8%; font-size:14px; color:#999999;margin-left:10%;">七日均销</div>
        <div style="width:8%; font-size:14px; color:#999999;margin-left:6%;">七日总销</div>
        <div style="width:7%; font-size:14px; color:#999999;margin-left:8%;">操作</div>
    </div>
<!-- refresh_begin -->
<?php
include_once("{$root_path}/model/model_bi.php");
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
$ymd=empty($_REQUEST["bi_time"])?"day":$_REQUEST["bi_time"];
@$product_id=$_REQUEST["search_stock_bi_huohao"]==""?null:$_REQUEST["search_stock_bi_huohao"];
@$factory_id=$_REQUEST["kucun_select_factory"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id=@$_REQUEST["dangkou_id"];
$group=array("detail_p_huohao","detail_master_bianhao");
list($historys,$detail_addup)=get_history_stock_num($ymd="day",$group,$factory_id,$product_id,null,null,null,null);
debug($detail_addup);
$dangkou_arr=get_dangkou_list();//档口仓库和编号数组
debug($dangkou_arr);
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize;
$group=array("detail_p_huohao");
list($historys2,$addup)=get_history_stock_num($ymd="day",$group,$factory_id,$product_id,$order_master_id,null,null,null);
debug($historys2);
debug($product_id);

//七日总销和均销
$group=array("detail_p_huohao");
$where=array("detail_p_huohao=? and detail_master_bianhao=?",null,$order_master_id);
$event_inventory=predict(7,7,7,$group,$where);
debug($event_inventory);

$rowcount=count($addup);$page_count=ceil($rowcount/$pagesize);
$ret=[];
foreach ($addup as $key=>$value)
{
    $ret[]=$value;
}
//排序
$keys=array("pool"=>"");
$sret=ysort($ret,$keys);
debug($sret);
for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
{
    //$idx=$rowcount-1-$i;
    $idx=$sret[$i]["idx"];
    $ro=$historys2[$ret[$idx]["now"]];
    debug($ro);
    if(array_key_exists($ro["detail_p_huohao"],$event_inventory)==false){
        $avg_num=0;
        $total_num=0;
    }else{
        $avg_num=round($event_inventory[$ro["detail_p_huohao"]]["avg_num"],2);
        $total_num=round($event_inventory[$ro["detail_p_huohao"]]["total_num"],2);
    }

    $kucun="";
    for($j=0;$j<count($dangkou_arr);$j++){

        $huo_dang=$dangkou_arr[$j][0];
        $dangkou_name=$dangkou_arr[$j][1];
        debug($huo_dang);
        if(array_key_exists($ro["detail_p_huohao"].'#'.$huo_dang, $detail_addup)==false){
            $kucun.="<span class='lf' style='margin-top:4px;margin-right:5px;'>".$dangkou_name.":0"."</span>";
        }else{
            $kucun.="<span class='lf' style='margin-top:4px;margin-right:5px;'>".$dangkou_name.":".floatval($detail_addup[$ro["detail_p_huohao"].'#'.$huo_dang]['pool'])."</span>";
        }
    }
?>
                        <div class="report_table_body" style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
                            <div style="font-size:14px; width:8%;"><?php echo $ro["detail_p_huohao"] ?></div>
                            <div style="font-size:14px; width:7%;margin-left:10%">
                                <span style="float:left; width:100%; text-align:center"><?php echo floatval($ro["sum"]["pool"])?></span>
                            </div>
                            <div class="kucun_sp" style="font-size:14px; width:28%;margin-left:4%"><?php echo $kucun ?></div>
                            <div style="font-size:14px; width:6%;margin-left:1%"><?php echo $avg_num ?></div>
                            <div style="font-size:14px; width:8%;margin-left:7%"><?php echo $total_num ?></div>
                            <div style="width:7%;margin-left:8%"><span onclick="/**/ShowStockProductGuige('<?php echo $ro["detail_p_huohao"] ?>','<?php echo $product_id ?>','<?php $factory_id ?>')" style="font-size:14px; color:#0099FF; cursor:pointer">详细</span></div>
                            <div id="layer_stock_product_guige_<?php echo $ro["detail_p_huohao"] ?>" style="display:none;width:100%; display:none"></div>
                        </div>
<?php

}
?>
    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>
<script>/*n*/
    $("#pid_view_stock_bi_addup #pages_stock_addup").set_page_count("view_stock_bi_addup","pages_stock_addup",<?php echo $page_count;?>);
</script>
<!-- refresh_end -->
    <div class="ipages" input_idx_id="#pid_view_stock_bi_addup #page_idx" id="pages_stock_addup" page="view_stock_bi_addup" form="form_stock_addup" count="<?php echo $page_count; ?>"/>
</div>
<script type="text/javascript">
function ShowStockProductGuige(detail_p_huohao,product_id,factory_id)
{
    if($("#layer_stock_product_guige_"+detail_p_huohao).is(":visible")==false)
    {
     $("#layer_stock_product_guige_"+detail_p_huohao).show();
        $.ajax({
            url:"view-get-stock-guige",
            async: false,
            type: "POST",
            data:{get_stock_guige_huohao:detail_p_huohao,product_id:product_id,factory_id:factory_id},
            success: function(html){
                $("#layer_stock_product_guige_"+detail_p_huohao).html(html);
            }
        });
    }
    else
    {
        $("#layer_stock_product_guige_"+detail_p_huohao).hide();
    }
}
function search_kucun()
{

    $("#pid_view_stock_bi_addup #pages_stock_addup").set_page_num("","",1);

    refresh_inner("view_stock_bi_addup?"+$("#form_stock_addup").serialize() );
}
</script>

