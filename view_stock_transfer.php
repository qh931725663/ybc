<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_order.php");
?>
<script type="text/javascript">    
function search_kcdb()
{
    $("#pid_view_stock_transfer #pages_kcdb").set_page_num("view_stock_transfer","pages_kcdb",1);

    refresh_inner("view_stock_transfer?"+$("#form_kcdb").serialize() );
}
function click_me_kcdb(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");
    
    //重置value
    $('#stocktransfer_order_is_verify').attr("value","");

    if (state!="")
        $('#stocktransfer_order_is_verify').attr("value",state);

    search_kcdb();
}
</script>
<form id="form_kcdb">
<div style="float:left; width:100%; overflow:hidden; display:block">
    <div style="float:left; width:100%; margin:20px 0; overflow:hidden; display:block">
        <div style="float:left; overflow:hidden; display:block">
            <span style="float:left; overflow:hidden; display:block">
                <span style="padding:5px 0">日期 <input type="text" class="datepicker" name="from_day"  size="12" maxlength="50" readonly="readonly" style="padding:5px"> 至 <input type="text" class="datepicker" name="to_day"  size="12" maxlength="50" readonly="readonly" style="padding:5px">
                </span>
            </span>
            <span id="btn_arrange_factory_search" onclick="search('view_stock_transfer','form_kcdb')" class="btn_normal_blue public_search_sm">搜索</span>
            <span class="clear_search" onclick="mount_to_frame('view_stock_transfer',1,'frame_stock_transfer')">清空<br>条件</span>
        </div>
        <div style="float:right">
            <span class="btn_normal_blue" onclick="/**/StocktransferClick()">开始调拨</span>
        </div>
    </div>
    <div style="float:left; width:100%; margin-bottom:20px; overflow:hidden; display:block">
        <div style="float:left; overflow:hidden; display:block">
            <input type="hidden" id="stocktransfer_order_is_verify" name="order_is_verify"/>
            <span class="listtypevalue listtypeselect" onclick="/**/click_me_kcdb($(this),'')">全部</span>
            <span class="listtypevalue" onclick="/**/click_me_kcdb($(this),'1')">待签收</span>
            <span class="listtypevalue" onclick="/**/click_me_kcdb($(this),'2')">已签收</span>
        </div>
    </div>

<!-- refresh_begin -->
<?php                    
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;
@$order_is_verify=$_REQUEST["order_is_verify"]?($_REQUEST["order_is_verify"]=="1"?"0":$_REQUEST["order_is_verify"]):null;

$where=@array("order_boss_m_bianhao=? and order_addtime>=? and order_addtime<=? and order_is_verify=? and order_type='dbck'",
$boss_id,$from_day,$to_day,$order_is_verify);
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
                <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">出库：</span><span style="color:#0099FF"><?php echo $roworder["order_master_name"];?></span></div>
                <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">入库：</span><span style="color:#0099FF"><?php echo $roworder["order_slave_name"];?></span></div>
                <?php
                if ($roworder["order_type"]=="dbck" and $roworder["order_is_verify"]=="0")
                {
                ?>
                <div style="margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#d64126">待签收</span></div>
                <?php
                }
                elseif ($roworder["order_type"]=="dbck" and $roworder["order_is_verify"]=="2")
                {
                ?>
                <div style="margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#009900">已签收</span></div>
                <?php
                }
                ?>
                
                <div  style="float:right;text-align:right">
                    <?php
                    if ((!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]) and $roworder["order_slave_bianhao"]==$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]) and $roworder["order_type"]=="dbck" and $roworder["order_is_verify"]=="0")
                    {
                    ?>
                    <span class="btn_order_red" onclick="/**/StocktransferOrderVerifyClick('<?php echo $roworder["order_slave_bianhao"]?>','<?php echo $roworder["order_slave_name"]?>','<?php echo $roworder["order_master_bianhao"]?>','<?php echo $roworder["order_bianhao"]?>')">签收</span>
                    <?php
                    }
                    ?>
                    <span class="btn_order_red" onclick="/**/PrintOrder(<?php echo $roworder["order_bianhao"]?>)">打印</span>
                </div>
            </div>
            <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
                <?php
                if ($roworder["order_type"]=="dbck")
                {
                ?>
                <div style="float:left; padding:5px 0; font-size:12px"><span style="color:#999999">出库时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
                <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">操作用户：</span><?php echo $roworder["order_user_name"];?></div>
                <?php
                }
                if ($roworder["order_is_verify"]=="1")
                {
                    $rsreciveorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rowreciveorder=mysql_fetch_array($rsreciveorder);
                ?>
                <div style="float:left; padding:5px 0; font-size:12px"><span style="color:#999999">入库时间：</span><?php echo date("Y-m-d H:i:s",$rowreciveorder["order_addtime"]); ?></div>
                <?php
                }
                ?>
            </div>
            <div class="stock_table_tbody3">
                <div style="width:30%;">货号</div>
                <div style="width:20%; text-align:center">颜色</div>
                <div style="width:20%; text-align:center">尺码</div>
                <div style="width:15%; text-align:center">发货数量</div>
                <div style="width:15%; text-align:center">签收数量</div>
            </div>
            <?php
            $order_send_num=0;
            $order_inbound_num=0;
            $arr_order_detail=get_application_order_detail($roworder["order_bianhao"]);
            foreach ($arr_order_detail as $order_detail_barcode) 
            { 
                $order_send_num+=$order_detail_barcode["detail_send_num"]=="-1"?"0":$order_detail_barcode["detail_send_num"];
                $order_inbound_num+=$order_detail_barcode["detail_inbound_num"]=="-1"?"0":$order_detail_barcode["detail_inbound_num"];
                
                $p_factory=cselect("*","ydf_factory",array("factory_bianhao=?",$order_detail_barcode["detail_factory_bianhao"]));
                $rowfactory=$p_factory[0]->fetch();
            ?>        
            <div class="stock_table_row3">
                <div style="width:30%; height:20px;"><?php echo $order_detail_barcode["detail_p_huohao"]?> / <?php echo $rowfactory["factory_name"]?></div>
                <div style="width:20%; height:20px; text-align:center"><?php echo $order_detail_barcode["detail_p_color"]?></div>
                <div style="width:20%; height:20px; text-align:center"><?php echo $order_detail_barcode["detail_p_size"]?></div>
                <div style="width:15%; height:20px; text-align:center"><?php echo $order_detail_barcode["detail_send_num"]=="-1"?"-":$order_detail_barcode["detail_send_num"] ?></div>
                <div style="width:15%; height:20px; text-align:center"><?php echo $order_detail_barcode["detail_inbound_num"]=="-1"?"-":$order_detail_barcode["detail_inbound_num"] ?></div>
            </div>
            <?php
            }
            ?>
            <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
                <span style="font-size:12px"><span style="color:#999999">发货数量：</span><span style=" font-size:12px; color:#ee583d"><?php echo $order_send_num?></span><?php if ($roworder["order_type"]=="dbck" and $roworder["order_is_verify"]=="2") {?> <span style="color:#999999">签收数量：</span><span style="font-size:12px; color:#ee583d"><?php echo $order_inbound_num?></span><?php } ?></span>
            </div>
            <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
                <span class="btn_order_red" onclick="/**/DeleteOrder(<?php echo $roworder["order_bianhao"]?>,'view_stock_transfer','frame_stock_transfer')">删除</span>
            </div>
        </div>
    </div>
<?php
}
?>
    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个订单</div>

<script>/*n*/    
$("#pid_view_stock_transfer #pages_kcdb").set_page_count("view_stock_transfer","pages_ckbh",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
    <div class="ipages" id="pages_kcdb" page="view_stock_transfer" form="form_kcdb" count="<?php echo $page_count; ?>"></div>
</div>
</form> <!-- 页码也作为表单项统一处理  -->

<div id="layer_stocktransfer_select_storewarehouse" style="float:left; width:650px; padding:25px; overflow:visible; display:none">
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
            <div class="listclassvalue" onclick="/**/SuperManagerStocktransferSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
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
            <div class="listclassvalue" onclick="/**/SuperManagerStocktransferSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<div id="layer_stocktransfer_select_store" style="float:left; width:300px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; margin:10px 0; padding:10px 0; font-size:14px; color:#ee583d; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">请先选择要调拨到的档口：</div>
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
    <div style="float:left; width:100%; padding:5px 0; display:block">
        <div class="listtypevalue" onclick="/**/StocktransferSelectToDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
    </div>
    <?php
    }
    ?>
    <div style="float:left; width:100%; margin:10px 0; padding:10px 0; font-size:14px; color:#ee583d; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">请先选择要调拨到的仓库：</div>
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
    <div style="float:left; width:100%; padding:5px 0; display:block">
        <div class="listtypevalue" onclick="/**/StocktransferSelectToDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
    </div>
    <?php
    }
    ?>
</div>
<script type="text/javascript">
var stocktransfer_select_storewarehouse_bianhao="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]:"" ?>"; 
var stocktransfer_select_storewarehouse_name="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"]:"" ?>";

function StocktransferClick()
{ 
    var status_userpurview=true;
    $.ajax({
        url:"check-storewarehouse-userpurview",
        async: false,
        type: "POST",
        data:"",
        dataType:"json",
        success: function(html){
            if (parseInt(html["state"])==1001 || parseInt(html["state"])==1003)
            {
                stocktransfer_select_storewarehouse_bianhao=html["current_master_bianhao"]; 
                stocktransfer_select_storewarehouse_name=html["current_master_name"];
                
                index_layer_stocktransfer_select_store=layer.open({
                    type: 1,
                    area: ['370px', '400px'],
                    title: false,
                    content:$('#layer_stocktransfer_select_store')
                });
            }
            else if (parseInt(html["state"])==1002)
            {
                index_layer_stocktransfer_select_storewarehouse=layer.open({
                    type: 1,
                    area: ['720px', '300px'],
                    title: false,
                    content:$('#layer_stocktransfer_select_storewarehouse')
                });
            }
        }
    });
}

function SuperManagerStocktransferSelectDangkouStore(master_dangkou_bianhao,master_dangkou_name){
    stocktransfer_select_storewarehouse_bianhao=master_dangkou_bianhao; 
    stocktransfer_select_storewarehouse_name=master_dangkou_name;
                
    layer.close(index_layer_stocktransfer_select_storewarehouse);
    
    index_layer_stocktransfer_select_store=layer.open({
        type: 1,
        area: ['370px', '400px'],
        title: false,
        content:$('#layer_stocktransfer_select_store')
    });
}

function StocktransferSelectToDangkouStore(slave_dangkou_bianhao)
{
    if  ($("#stocktransfer_select_store").val()=="")
    {
        alert("请先选择调拨到档口！");
        return false;
    }
    
    layer.close(index_layer_stocktransfer_select_store);

    mount_to_frame("view_stock_transfer_submit?var_master_bianhao="+stocktransfer_select_storewarehouse_bianhao+"&var_master_name="+stocktransfer_select_storewarehouse_name+"&var_slave_bianhao="+slave_dangkou_bianhao+"&var_order_type=dbck",1,"frame_stock_transfer");
}

function StocktransferOrderVerifyClick(order_master_bianhao, order_master_name, order_slave_bianhao, last_order_bianhao)
{
    mount_to_frame("view_stock_transfer_submit?var_master_bianhao="+order_master_bianhao+"&var_master_name="+order_master_name+"&var_slave_bianhao="+order_slave_bianhao+"&var_last_order_bianhao="+last_order_bianhao+"&var_order_type=dbrk",1,"frame_stock_transfer");
}

</script>
