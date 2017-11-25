<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_order.php");
?>
<script type="text/javascript">

function search_kcpd()
{
    $("#pid_view_stock_adjust #pages_kcpd").set_page_num("view_stock_adjust","pages_kcpd",1);

    refresh_inner("view_stock_adjust?"+$("#form_kcpd").serialize() );
}
function click_me_kcpd(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");
    
    //重置value
    $('#order_type').attr("value","");

    if (state!="")
        $('#order_type').attr("value",state);

    search_kcpd();
}
</script>
<form id="form_kcpd">

    <div style="float:left; width:100%; margin:20px 0; overflow:hidden; display:block">
        <div style="float:left; overflow:hidden; display:block">
            <span style="float:left; overflow:hidden; display:block">
                <span style="padding:5px 0">日期 <input type="text" class="datepicker" name="search_store_dangkoubuhuo_from_date"  size="12" maxlength="50" readonly="readonly" style="padding:5px"> 至 <input type="text" class="datepicker" name="search_sotre_dangkoubuhuo_to_date"  size="12" maxlength="50" readonly="readonly" style="padding:5px">
                </span>
            </span>
            <span id="btn_chukuorder_search" class="btn_normal_blue public_search_sm">搜索</span>
            <span class="clear_search" onclick="mount_to_frame('view_stock_adjust',1,'frame_stock_adjust')">清空<br>条件</span>
        </div>
        <div style="float:right">
            <span class="btn_normal_blue" onclick="/**/StockadjustClick()">开始盘点</span>
        </div>
    </div>

<!-- refresh_begin -->
<?php                    
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;

$order_type="";
@$str_order_type=$_REQUEST["order_type"]?$_REQUEST["order_type"]:"dkbhgc,dkbhck,dkbhgcfh,dkbhckfh,dkbhgcfhdkqs,dkbhckfhdkqs";
@$arr_order_type=explode(",",$str_order_type);
for ($i=0; $i<count($arr_order_type); $i++)
{
    if ($i==0)
    {
        $order_type="'".$arr_order_type[0]."'";
    }
    else
    {
        $order_type.=",'".$arr_order_type[$i]."'";
    }
}

$where=@array("order_boss_m_bianhao=? and order_bianhao=? and order_temp=? and order_is_pay=? and order_is_pickup=? and order_seller_cycle>=? and order_seller_cycle<=? and order_add_time>=? and order_add_time<=? and order_type='kcpd'",
$boss_id,$_REQUEST["order_bianhao"],$_REQUEST["order_temp"],$_REQUEST["order_is_pay"],$_REQUEST["order_is_pickup"],$_REQUEST["order_seller_cycle_min"],$_REQUEST["order_seller_cycle_max"],$from_day,$to_day);
$where=clean_where($where);
//print_r($where);
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;
$offset=($page-1)*$pagesize; 
$p=cselect("*","ydf_order",$where,"","order_addtime desc",$offset,$pagesize);
//if ($p[0]->errorCode()!="00000")
//print_r($p[0]->errorInfo());
$rowcount=$p[1];
$page_count=ceil($rowcount/$pagesize);  
while ($roworder=$p[0]->fetch())
{
?>
    <div class="stock" style="width:99%; margin:0 auto 20px auto">
        <div class="stock_inner">
            <div class="stock_table_header">
                <div style="padding:5px 0;"><span style="color:#999999">编号：</span><?php echo $roworder["order_bianhao"];?></div>
                <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">盘点：</span><?php echo $roworder["order_master_name"];?></div>
                <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
                <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">操作用户：</span><?php echo $roworder["order_user_name"];?></div>
                
                <div style="float:right; text-align:right">
                    <span class="btn_order_red" onclick="/**/PrintOrder(<?php echo $roworder["order_bianhao"]?>)">打印</span>
                </div>
            </div>
            <div class="stock_table_tbody3">
                <div style="width:30%;">货号</div>
                <div style="width:20%; text-align:center">颜色</div>
                <div style="width:20%; text-align:center">尺码</div>
                <div style="width:10%; text-align:center">盘库数量</div>
                <div style="width:10%; text-align:center">系统库存</div>
                <div style="width:10%; text-align:center">库存调整</div>
            </div>
            <?php
            $rsorderdetail = mysql_query("SELECT * FROM ydf_order_detail where detail_order_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
            while($roworderdetail=mysql_fetch_array($rsorderdetail))
            { 
                $p_factory=cselect("*","ydf_factory",array("factory_bianhao=?",$roworderdetail["detail_factory_bianhao"]));
                $rowfactory=$p_factory[0]->fetch();
            ?>        
            <div class="stock_table_row3">
                <div style="width:30%;"><?php echo $roworderdetail["detail_p_huohao"]?> / <?php echo $rowfactory["factory_name"]?></div>
                <div style="width:20%; text-align:center"><?php echo $roworderdetail["detail_p_color"]?></div>
                <div style="width:20%; text-align:center"><?php echo $roworderdetail["detail_p_size"]?></div>
                <div style="width:10%; text-align:center"><?php echo $roworderdetail["detail_really_stock_num"] ?></div>
                <div style="width:10%; text-align:center"><?php echo $roworderdetail["detail_really_stock_num"]-$roworderdetail["detail_order_num"] ?></div>
                <div style="width:10%; text-align:center"><?php echo $roworderdetail["detail_order_num"] ?></div>
            </div>
            <?php
            }
            ?>
            <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
                <span class="btn_order_red" onclick="/**/DeleteOrder(<?php echo $roworder["order_bianhao"]?>,'view_stock_adjust','form_kcpd')">删除</span>
            </div>
        </div>
    </div>
<?php
}
?>
    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个订单</div>

<script>/*n*/    
$("#pid_view_stock_adjust #pages_kcpd").set_page_count("view_stock_adjust","pages_kcpd",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
    <div class="ipages" id="pages_kcpd" page="view_stock_adjust" form="form_kcpd" count="<?php echo $page_count; ?>"/>

</form> <!-- 页码也作为表单项统一处理  -->

<div id="layer_stockadjust_select_storewarehouse" style="float:left; width:650px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; margin:10px 0; padding:10px 0; font-size:14px; color:#ee583d; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">请先选择当前处理业务归属的档口或仓库！</div>
    <div class="listclassblock">
        <div class="listclassdefault">档口：</div>
    </div>
    <div style="float:left; width:90%; display:block">
        <?php
        $p=cselect("*","ydf_dangkou",array("dangkou_type='1' and dangkou_endtime>? and dangkou_boss_m_bianhao=?",strtotime(date("Y-m-d H:i:s")),$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","dangkou_bianhao");
        while ($rowdangkou=$p[0]->fetch())
        {
            $havewarehouse_type="no";
        
            $rswarehouse=mysql_query("SELECT * FROM ydf_dangkou_warehouse WHERE dangkou_warehouse_dangkou_bianhao='".$rowdangkou["dangkou_bianhao"]."'" , $dbconn);
            if ($rowwarehouse=mysql_fetch_array($rswarehouse))
            {
                $havewarehouse_type="yes";
            }
        ?>
        <div class="listclassvalueblock">
            <div class="listclassvalue" onclick="/**/SuperManagerStockadjustSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
        </div>
        <?php
        }
        ?>
    </div>
    <div class="listclassblock">
        <div class="listclassdefault">仓库：</div>
    </div>
    <div style="float:left; width:90%; display:block">
        <?php
        $p=cselect("*","ydf_dangkou",array("dangkou_type='2' and dangkou_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","dangkou_bianhao");
        while ($rowdangkou=$p[0]->fetch())
        {
            $havewarehouse_type="no";
        
            $rswarehouse=mysql_query("SELECT * FROM ydf_dangkou_warehouse WHERE dangkou_warehouse_dangkou_bianhao='".$rowdangkou["dangkou_bianhao"]."'" , $dbconn);
            if ($rowwarehouse=mysql_fetch_array($rswarehouse))
            {
                $havewarehouse_type="yes";
            }
        ?>
        <div class="listclassvalueblock">
            <div class="listclassvalue" onclick="/**/SuperManagerStockadjustSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
<script type="text/javascript">
var stockadjust_select_storewarehouse_bianhao="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]:"" ?>"; 
var stockadjust_select_storewarehouse_name="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"]:"" ?>";

function StockadjustClick()
{ 
    $.ajax({
        url:"check-storewarehouse-userpurview", 
        async: false,
        type: "POST",
        data:"",
        dataType:"json",
        success: function(html){
            if (parseInt(html["state"])==1001 || parseInt(html["state"])==1003)
            {
                stockadjust_select_storewarehouse_bianhao=html["current_master_bianhao"]; 
                stockadjust_select_storewarehouse_name=html["current_master_name"];
                
                mount_to_frame("view_stock_adjust_submit?var_master_bianhao="+stockadjust_select_storewarehouse_bianhao+"&var_master_name="+stockadjust_select_storewarehouse_name,1,"frame_stock_adjust");
            }
            else if (parseInt(html["state"])==1002)
            {
                index_layer_stockadjust_select_storewarehouse=layer.open({
                    type: 1,
                    area: ['720px', '300px'],
                    title: false,
                    content:$('#layer_stockadjust_select_storewarehouse')
                });
            }
        }
    });
}

function SuperManagerStockadjustSelectDangkouStore(master_dangkou_bianhao,master_dangkou_name){
    stockadjust_select_storewarehouse_bianhao=master_dangkou_bianhao; 
    stockadjust_select_storewarehouse_name=master_dangkou_name;
                
    layer.close(index_layer_stockadjust_select_storewarehouse);
    
    mount_to_frame("view_stock_adjust_submit?var_master_bianhao="+stockadjust_select_storewarehouse_bianhao+"&var_master_name="+stockadjust_select_storewarehouse_name,1,"frame_stock_adjust");
}
</script>
