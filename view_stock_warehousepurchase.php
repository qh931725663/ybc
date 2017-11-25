<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_order.php");
?>
<script type="text/javascript">
function search_ckbh()
{
    $("#pid_view_stock_warehousepurchase #pages_ckbh").set_page_num("view_stock_warehousepurchase","pages_ckbh",1);

    refresh_inner("view_stock_warehousepurchase?"+$("#form_ckbh").serialize() );
}

function click_me_ckbh(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");
		$("#stock_warehousepurchase_order_is_verify").attr("value","");
		if (state!="")
        $('#stock_warehousepurchase_order_is_verify').attr("value",state);

    search_ckbh();
}
</script>
<form id="form_ckbh">
<div class="ckbh_container">
    <div class="ckbh_setup">
        <span class="btn_normal_blue" onclick="/**/WarehousepurchaseClick('zjbh')">开始采购</span>

    </div>
    <div class="sdsy_nave_b">
        <select class="lf" name="ckbh_select_factory" style="margin-left:15px; padding: 5px;">
            <option value="">请选择工厂</option>
            <?php
            $p=cselect("*","ydf_factory",array("factory_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","factory_bianhao");
            while ($rowdata=$p[0]->fetch())
            {
            ?>
            <option value="<?php echo $rowdata["factory_bianhao"]?>"><?php echo $rowdata["factory_name"]?></option>
            <?php
            }
            ?>
        </select>
        <span class="sdsy_date" style="margin-left:15px;">
            <span class="sdsy_date_d">日期 <input type="text" class="datepicker" name="from_day"  size="12" maxlength="50" readonly="readonly"> 至 <input type="text" class="datepicker" name="to_day"  size="12" maxlength="50" readonly="readonly">
            </span>
        </span>
        <span class="lf" style="margin-left:15px;"><input class="iinput"  style="padding-right:20px" id="" name="operation_user_name" name="operation_user_name" type="text" placeholder="请输入操作用户姓名首字母" autocomplete="off " required/></span>
        <span id="btn_chukuorder_search" class="btn_normal_blue public_search_sm" style="margin-left:15px;" onclick="search('view_stock_warehousepurchase','form_ckbh')">搜索</span>
        <span class="clear_search">清空<br>条件</span>
    </div>
</div>
<div class="sdsy_nave">
    <div class="sdsy_nave_a">
        <input type="hidden" id="stock_warehousepurchase_order_is_verify" name="order_is_verify"/>
        <span class="listtypevalue listtypeselect" onclick="/**/click_me_ckbh($(this),'')">全部</span>
        <span class="listtypevalue" onclick="/**/click_me_ckbh($(this),'1')">待发货</span>
        <span class="listtypevalue" onclick="/**/click_me_ckbh($(this),'2')">已发货</span>
        <span class="listtypevalue" onclick="/**/click_me_ckbh($(this),'3')">已入库</span>
    </div>

</div>

<!-- refresh_begin -->
<?php                    
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;
@$factory_bianhao=$_REQUEST["ckbh_select_factory"]==""?null:$_REQUEST["ckbh_select_factory"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id="";

@$order_is_verify=$_REQUEST["order_is_verify"]?$_REQUEST["order_is_verify"]:null;
if($order_is_verify=="1"){
	$order_is_verify="0";
}
elseif($order_is_verify=="2"){
	$order_is_verify="1";
}
elseif($order_is_verify=="3"){
	$order_is_verify="2";
}


$where=@array("order_boss_m_bianhao=? and order_master_bianhao=? and order_is_verify=? and order_addtime>=? and order_addtime<=? and ( (order_type='gcfh' and order_source_bianhao=0) or order_type='ckbh' or order_type='dkbhgc' or (order_type='jhrk' and order_source_bianhao=0)) and order_factory_bianhao=?",
$boss_id,$order_master_id,$order_is_verify,$from_day,$to_day,$factory_bianhao);
$where=clean_where($where);
//print_r($where);
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;
$offset=($page-1)*$pagesize;
debug($where);
$p=cselect("*","ydf_order",$where,"","order_addtime desc",$offset,$pagesize);
//if ($p[0]->errorCode()!="00000")
//print_r($p[0]->errorInfo());
$rowcount=$p[1];
$page_count=ceil($rowcount/$pagesize);  
while ($roworder=$p[0]->fetch())
{
?>
<div class="stock">
    <div class="stock_inner">
        <div class="stock_table_header">
            <?php
            if ($roworder["order_type"]=="gcfh")
            {
            ?>
            <div style="padding:5px 0;"><span>发货：</span><span style="color:#0099FF"><?php echo $roworder["order_factory_name"];?></span></div>
                <?php
                if ($roworder["order_is_verify"]=="2")
                {
                    $rsnextorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rownextorder=mysql_fetch_array($rsnextorder);
                ?>
            <div style="margin-left:10px; padding:5px 0; "><span>签收：</span><span style="color:#0099FF"><?php echo $rownextorder["order_master_name"];?></span></div>
            <?php
                }
            }
            else
            {
            ?>
            <div style="padding:5px 0; "><span>采购：</span><span style="color:#0099FF"><?php echo $roworder["order_master_name"];?></span></div>
            <div style="margin-left:10px; padding:5px 0;"><span>发货：</span><span style="color:#0099FF"><?php echo $roworder["order_factory_name"];?></span></div>
            <?php
            }
            ?>
            <?php
            $order_status_des="";
            if (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh") and $roworder["order_is_verify"]=="0")
            {
                $order_status_des="待发货";
            ?>
            <div style="float:left; margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#d64126">待发货</span></div>
            <?php
            }
            elseif ((($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh") and $roworder["order_is_verify"]=="1") or ($roworder["order_type"]=="gcfh" or $roworder["order_is_verify"]=="0"))
            {
                $order_status_des="待签收";
            ?>
            <div style="float:left; margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#0099FF">待签收</span></div>
            <?php
            }
            elseif ((($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="2") or ($roworder["order_type"]=="jhrk" and $roworder["order_source_bianhao"]=="0"))
            {
                $order_status_des="已签收";
            ?>
            <div style="float:left; margin-left:10px; padding:5px 0"><span style="color:#999999">状态：</span><span style="color:#009900">已签收</span></div>
            <?php
            }
            ?>
            
            <div style="float:right; text-align:right">
                <?php
                if ((($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="0") or !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
                {
                ?>
                <span class="btn_order_red" onclick="/**/WarehousepurchaseOrderVerifyClick('<?php echo $roworder["order_master_bianhao"]?>','<?php echo $roworder["order_master_name"]?>','<?php echo $roworder["order_bianhao"]?>','<?php echo $roworder["order_factory_bianhao"]?>','jhrk')">签收</span>
                <?php
                }
                elseif (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh") and $roworder["order_is_verify"]=="1")
                {
                    $rslastorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rowlastorder=mysql_fetch_array($rslastorder);
                ?>
                <span class="btn_order_red" onclick="/**/WarehousepurchaseOrderVerifyClick('<?php echo $roworder["order_master_bianhao"]?>','<?php echo $roworder["order_master_name"]?>','<?php echo $rowlastorder["order_bianhao"]?>','<?php echo $rowlastorder["order_factory_bianhao"]?>','jhrk')">签收</span>
                <?php
                }
                ?>
                <span class="btn_order_red" onclick="/**/PrintOrder(<?php echo $roworder["order_bianhao"]?>)">打印</span>
            </div>
        </div>
        <div class="warehouse_nave" style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
            <div style="padding:5px 0; "><span style="color:#999999;">编号：</span><?php echo $roworder["order_bianhao"];?></div>
            <?php
            if ($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh" or $roworder["order_type"]=="gcfh")
            {
            ?>
            <div style=" padding:5px 0; "><span>创建时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
            <?php
            if ($roworder["order_user_name"])
            {
            ?>
            <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">操作用户：</span><?php echo $roworder["order_user_name"];?></div>
            <?php
            }
            ?>
            <?php
                if (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh") and $roworder["order_is_verify"]=="1")
                {
                    $rsnextorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rownextorder=mysql_fetch_array($rsnextorder);
            ?>
            <div style="margin-left:10px; padding:5px 0;"><span>发货时间：</span><?php echo date("Y-m-d H:i:s",$rownextorder["order_addtime"]); ?></div>
            <?php
                }
                
                if (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh") and $roworder["order_is_verify"]=="2")
                {
                    $rsnextorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rownextorder=mysql_fetch_array($rsnextorder);
                    
                    $rslastorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rowlastorder=mysql_fetch_array($rslastorder);
            ?>
            <div style="margin-left:10px; padding:5px 0;"><span>发货时间：</span><?php echo date("Y-m-d H:i:s",$rownextorder["order_addtime"]); ?></div>
            <div style="margin-left:10px; padding:5px 0;"><span>签收时间：</span><?php echo date("Y-m-d H:i:s",$rowlastorder["order_addtime"]); ?></div>
            <?php
                }
                elseif ($roworder["order_type"]=="gcfh" and $roworder["order_is_verify"]=="2")
                {
                    $rsnextorder = mysql_query("SELECT * FROM ydf_order where order_source_bianhao='".$roworder["order_bianhao"]."'", $dbconn); 
                    $rownextorder=mysql_fetch_array($rsnextorder);
            ?>
            <div style="margin-left:10px; padding:5px 0;"><span>签收时间：</span><?php echo date("Y-m-d H:i:s",$rownextorder["order_addtime"]); ?></div>
            <?php
                }
            }
            elseif ($roworder["order_type"]=="jhrk")
            {
            ?>
            <div style="padding:5px 0;"><span>入库时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
            <div style="margin-left:10px; padding:5px 0;"><span>操作用户：</span><?php echo $roworder["order_user_name"];?></div>
            <?php
            }
            ?>
        </div>
        <div class="stock_table_tbody3">
            <div style="width:25%;" >货号</div>
            <div style="width:15%;text-align:center">颜色</div>
            <div style="width:15%;text-align:center">尺码</div>
            <div style="width:15%;text-align:center">成本价</div>
            <div style="width:10%;text-align:center">采购数量</div>
            <div style="width:10%;text-align:center">发货数量</div>
            <div style="width:10%;text-align:center">签收数量</div>
        </div>
        <?php
        $shop_totalnum=0;
        $shop_totalprice=0;
        $arr_order_detail=get_application_order_detail($roworder["order_bianhao"]);
        foreach ($arr_order_detail as $order_detail_barcode) 
        { 
            if (($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh") and $roworder["order_is_verify"]=="0")
            {
                $shop_totalnum+=$order_detail_barcode["detail_apply_num"]=="-1"?"0":$order_detail_barcode["detail_apply_num"];
                $shop_totalprice+=($order_detail_barcode["detail_apply_num"]=="-1"?"0":$order_detail_barcode["detail_apply_num"])*$order_detail_barcode["detail_valueprice"];
            }
            elseif ((($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh") and $roworder["order_is_verify"]=="1") or ($roworder["order_type"]=="gcfh" and $roworder["order_is_verify"]=="0"))
            {
                $shop_totalnum+=$order_detail_barcode["detail_send_num"]=="-1"?"0":$order_detail_barcode["detail_send_num"];
                $shop_totalprice+=($order_detail_barcode["detail_send_num"]=="-1"?"0":$order_detail_barcode["detail_send_num"])*$order_detail_barcode["detail_valueprice"];
            }
            elseif ((($roworder["order_type"]=="dkbhgc" or $roworder["order_type"]=="ckbh" or $roworder["order_type"]=="gcfh") and $roworder["order_is_verify"]=="2") or ($roworder["order_type"]=="jhrk" and $roworder["order_source_bianhao"]=="0"))
            {
                $shop_totalnum+=$order_detail_barcode["detail_inbound_num"]=="-1"?"0":$order_detail_barcode["detail_inbound_num"];
                $shop_totalprice+=($order_detail_barcode["detail_inbound_num"]=="-1"?"0":$order_detail_barcode["detail_inbound_num"])*$order_detail_barcode["detail_valueprice"];
            }
        ?>        
        <div class="stock_table_row3">
            <div style="width:25%;"><?php echo $order_detail_barcode["detail_p_huohao"]?></div>
            <div style="width:15%;text-align:center"><?php echo $order_detail_barcode["detail_p_color"]?></div>
            <div style="width:15%;text-align:center"><?php echo $order_detail_barcode["detail_p_size"]?></div>
            <div style="width:15%;text-align:center"><?php echo $order_detail_barcode["detail_valueprice"]?></div>
            <div style="width:10%;text-align:center"><?php echo $order_detail_barcode["detail_apply_num"]=="-1"?"-":$order_detail_barcode["detail_apply_num"] ?></div>
            <div style="width:10%;text-align:center"><?php echo $order_detail_barcode["detail_send_num"]=="-1"?"-":$order_detail_barcode["detail_send_num"] ?></div>
            <div style="width:10%;text-align:center"><?php echo $order_detail_barcode["detail_inbound_num"]=="-1"?"-":$order_detail_barcode["detail_inbound_num"] ?></div>
        </div>
        <?php
        }
        ?>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span style="font-size:12px"><span style="color:#999999"><?php echo $order_status_des ?>数量总计：</span><span style=" font-size:12px; color:#ee583d"><?php echo $shop_totalnum?></span> <span style="color:#999999"><?php echo $order_status_des ?>成本总计：</span><span style="font-size:12px; color:#ee583d"><?php echo $shop_totalprice?></span></span>
        </div>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span class="btn_order_red" onclick="/**/DeleteOrder(<?php echo $roworder["order_bianhao"]?>,'view_stock_warehousepurchase','form_ckbh')">删除</span>
        </div>
    </div>
</div>
<?php
}
?>

<div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个订单</div>

<script>/*n*/    
$("#pid_view_stock_warehousepurchase #pages_ckbh").set_page_count("view_stock_warehousepurchase","pages_ckbh",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
    <div class="ipages" id="pages_ckbh" page="view_stock_warehousepurchase" form="form_ckbh" count="<?php echo $page_count; ?>"></div>
</form> <!-- 页码也作为表单项统一处理  -->

<div id="layer_warehousepurchase_select_storewarehouse" style="float:left; width:650px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; margin:10px 0; padding:10px 0; font-size:14px; color:#ee583d; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">请先选择采购档口或仓库！</div>
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
            <div class="listclassvalue" onclick="/**/SuperManagerWarehousepurchaseSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>','<?php echo $rowdangkou["dangkou_type"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
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
            <div class="listclassvalue" onclick="/**/SuperManagerWarehousepurchaseSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>','<?php echo $rowdangkou["dangkou_type"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<div id="layer_verify_select_storewarehouse" style="float:left; width:650px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; margin:10px 0; padding:10px 0; font-size:14px; color:#ee583d; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">请先选择签收的档口或仓库！</div>
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
            <div class="listclassvalue" onclick="/**/SuperManagerBossVerifySelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
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
            <div class="listclassvalue" onclick="/**/SuperManagerBossVerifySelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<div id="layer_warehousepurchase_select_factory" style="float:left; width:400px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
        <span style="float:left; width:120px; padding-top:8px; text-align:right"><span style="color:red">*</span> 工厂：</span>
        <span style="float:left;margin-left:10px">
            <select id="warehousepurchase_select_factory" name="warehousepurchase_select_factory" style="padding:5px">    
                <option value="">选择</option>    
                <?php
                $p=cselect("*","ydf_factory",array("factory_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","factory_bianhao");
                while ($rowdata=$p[0]->fetch())
                {
                ?>
                <option value="<?php echo $rowdata["factory_bianhao"]?>"><?php echo $rowdata["factory_name"]?></option>    
                <?php
                }
                ?>            
            </select>
        </span>
    </div>
    <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
        <span style="float:left; margin-left:130px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer" onclick="/**/PostWarehousepurchaseSelectFactory()">下一步</span>
    </div>
</div>
<script type="text/javascript">
var warehousepurchase_current_opt_type;

var warehousepurchase_order_type; var warehousepurchase_select_factory;

var warehousepurchase_select_storewarehouse_bianhao="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]:"" ?>"; 
var warehousepurchase_select_storewarehouse_name="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"]:"" ?>";
var warehousepurchase_select_storewarehouse_type="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]:"" ?>";

var boss_verify_last_order_bianhao; var boss_verify_order_factory_bianhao; var boss_verify_order_type;

function WarehousepurchaseClick(opt_type)
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
                warehousepurchase_select_storewarehouse_bianhao=html["current_master_bianhao"]; 
                warehousepurchase_select_storewarehouse_name=html["current_master_name"];
                warehousepurchase_select_storewarehouse_type=html["current_master_type"];
            }
            else if (parseInt(html["state"])==1002)
            {
                warehousepurchase_current_opt_type=opt_type;
                
                index_layer_warehousepurchase_select_storewarehouse=layer.open({
                    type: 1,
                    area: ['720px', '300px'],
                    title: false,
                    content:$('#layer_warehousepurchase_select_storewarehouse')
                });
                
                status_userpurview=false;
            }
        }
    });
    
    if(status_userpurview==true)
    {
        if (opt_type=="znbh")
        {
            mount_to_frame('view_stock_warehousepurchase_auto',1,'frame_stock_warehousepurchase');
        }
        else if (opt_type=="zjbh")
        {
            warehousepurchase_order_type="ckbh";
            warehousepurchase_zjbh=1;
            
            index_layer_warehousepurchase_select_factory=layer.open({
                type: 1,
                area: ['470px', '300px'],
                title: false,
                content:$('#layer_warehousepurchase_select_factory')
            });
        }
    }
}

function SuperManagerWarehousepurchaseSelectDangkouStore(dangkou_bianhao,dangkou_name,dangkou_type){
    warehousepurchase_select_storewarehouse_bianhao=dangkou_bianhao;
    warehousepurchase_select_storewarehouse_name=dangkou_name;
    warehousepurchase_select_storewarehouse_type=dangkou_type;
    
    layer.close(index_layer_warehousepurchase_select_storewarehouse);    

    if (warehousepurchase_current_opt_type=="znbh")
    {    
        mount_to_frame('view_stock_warehousepurchase_auto?var_master_bianhao='+dangkou_bianhao,1,'frame_stock_warehousepurchase');
    }
    else if (warehousepurchase_current_opt_type=="zjbh")
    {
        if (warehousepurchase_select_storewarehouse_type==1)
        {
            warehousepurchase_order_type="dkbhgc";
        }
        else
        {
            warehousepurchase_order_type="ckbh";
            warehousepurchase_zjbh=1;
        }
        
        index_layer_warehousepurchase_select_factory=layer.open({
            type: 1,
            area: ['470px', '300px'],
            title: false,
            content:$('#layer_warehousepurchase_select_factory')
        });
    }
}

function PostWarehousepurchaseSelectFactory()
{
    if  ($("#warehousepurchase_select_factory").val()=="")
    {
        alert("请先选择工厂！");
        return false;
    }
    
    warehousepurchase_select_factory=$("#warehousepurchase_select_factory").val();

    layer.close(index_layer_warehousepurchase_select_factory);
     
    mount_to_frame("view_stock_warehousepurchase_submit?var_factory_bianhao="+$("#warehousepurchase_select_factory").val()+"&var_order_type="+warehousepurchase_order_type,1,"frame_stock_warehousepurchase");
}

function WarehousepurchaseOrderVerifyClick(warehousepurchase_order_master_bianhao, warehousepurchase_order_master_name, warehousepurchase_last_order_bianhao, warehousepurchase_order_factory_bianhao, warehousepurchase_order_type)
{
    if (warehousepurchase_order_master_bianhao==0)
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
                    mount_to_frame("view_stock_warehousepurchase_submit?var_master_bianhao="+html["current_master_bianhao"]+"&var_master_name="+html["current_master_name"]+"&var_last_order_bianhao="+warehousepurchase_last_order_bianhao+"&var_factory_bianhao="+warehousepurchase_order_factory_bianhao+"&var_order_type="+warehousepurchase_order_type,1,"frame_stock_warehousepurchase");
                }
                else if (parseInt(html["state"])==1002)
                {    
                    boss_verify_last_order_bianhao=warehousepurchase_last_order_bianhao;
                    boss_verify_order_factory_bianhao=warehousepurchase_order_factory_bianhao;
                    boss_verify_order_type=warehousepurchase_order_type;           
                    
                    index_layer_boss_verify_select_storewarehouse=layer.open({
                        type: 1,
                        area: ['720px', '300px'],
                        title: false,
                        content:$('#layer_verify_select_storewarehouse')
                    });
                }
            }
        });
    }
    else
    {
        mount_to_frame("view_stock_warehousepurchase_submit?var_master_bianhao="+warehousepurchase_order_master_bianhao+"&var_master_name="+warehousepurchase_order_master_name+"&var_last_order_bianhao="+warehousepurchase_last_order_bianhao+"&var_factory_bianhao="+warehousepurchase_order_factory_bianhao+"&var_order_type="+warehousepurchase_order_type,1,"frame_stock_warehousepurchase");
    }
}

function SuperManagerBossVerifySelectDangkouStore(dangkou_bianhao,dangkou_name){
    layer.close(index_layer_boss_verify_select_storewarehouse);
    mount_to_frame("view_stock_warehousepurchase_submit?var_master_bianhao="+dangkou_bianhao+"&var_master_name="+dangkou_name+"&var_last_order_bianhao="+boss_verify_last_order_bianhao+"&var_factory_bianhao="+boss_verify_order_factory_bianhao+"&var_order_type="+boss_verify_order_type,1,"frame_stock_warehousepurchase");
}

</script>


