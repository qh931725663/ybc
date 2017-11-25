<?php

include_once("check_dangkou_user.php");
?>

<script type="text/javascript">    
function list_mjth()
{
    //重置value
    $('#pickup_from_day').attr("value","");
    $('#pickup_to_day').attr("value","");
    
    $("#pid_view_sales_pickup #pages_mjth").set_page_num("view_sales_pickup","pages_mjth",1);
    refresh_inner("view_sales_pickup?"+$("#form_mjth").serialize() );
}

function search_mjth()
{
    $("#btn_pickuporder_search").parent().prev().find(".listtypevalue").removeClass('listtypeselect');
    
    $("#pid_view_sales_pickup #pages_mjth").set_page_num("view_sales_pickup","pages_mjth",1);
    refresh_inner("view_sales_pickup?"+$("#form_mjth").serialize() );
}

function click_me_mjth(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");
    
    //重置value
    $('#pickup_order_pickup_mjth').attr("value","");
    $('#pickup_order_pay_mjth').attr("value","");
    $('#pickup_order_credit_min_mjth').attr("value","");
    $('#pickup_order_credit_max_mjth').attr("value","");

    if (state=="waitpickup")//暂时未付款订单
    {
        $('#pickup_order_pickup_mjth').attr("value","0");
    }
    if (state=="havepickup")//暂时未付款订单
    {
        $('#pickup_order_pickup_mjth').attr("value","1");
    }
    if (state=="cancelpickup")//暂时未付款订单
    {
        $('#pickup_order_pickup_mjth').attr("value","2");
    }
    if (state=="waitpay")//暂时未付款订单
    {
        $('#pickup_order_pay_mjth').attr("value","0");
        $('#pickup_order_credit_min_mjth').attr("value","0");
        $('#pickup_order_credit_max_mjth').attr("value","0");
    }
    if (state=="havepay")//已未付款订单
    {
        $('#pickup_order_pay_mjth').attr("value","1");
        $('#pickup_order_credit_min_mjth').attr("value","0");
        $('#pickup_order_credit_max_mjth').attr("value","0");
    }
    if (state=="credit")
    {
        $('#pickup_order_credit_min_mjth').attr("value","1");
        $('#pickup_order_credit_max_mjth').attr("value","");
    }

    list_mjth();
}
</script>
<form id="form_mjth">
<div class="sdsy_setup">
    <div class="sdsy_setup_h">
        <div class="sdsy_setup_b">
            <span class="chuku_seller_s"><input class="iinput name_iime" id="pickup_seller_name" name="pickup_seller_name" type="text" placeholder="卖家昵称" autofocus="autofocus" autocomplete="off"/></span>
            <span class="btn_type_blue" onclick="/**/PostSelectPickupSeller()">开始配货</span>
            <span class="btn_type_red" onclick="/**/ShowPickupAddSeller()">新增卖家</span>
        </div>
    </div>
    <div class="sdsy_nave">
        <div class="sdsy_nave_a">
            <input type="hidden" id="pickup_order_pickup_mjth" name="order_is_pickup" value=""/>
            <input type="hidden" id="pickup_order_pay_mjth" name="order_is_pay" value=""/>
            <input type="hidden" id="pickup_order_credit_min_mjth" name="order_seller_cycle_min" value=""/>
            <input type="hidden" id="pickup_order_credit_max_mjth" name="order_seller_cycle_max" value=""/>
            <span class="listtypevalue listtypeselect" onclick='/**/click_me_mjth($(this),"")'>全部</span>
            <span class="listtypevalue" onclick='/**/click_me_mjth($(this),"waitpickup")'>待提货</span>
            <span class="listtypevalue" onclick='/**/click_me_mjth($(this),"havepickup")'>已提货</span>
            <span class="listtypevalue" onclick='/**/click_me_mjth($(this),"cancelpickup")'>放弃提货</span>
            <span class="listtypevalue" onclick='/**/click_me_mjth($(this),"havepay")'>已付款</span>
            <span class="listtypevalue" onclick='/**/click_me_mjth($(this),"waitpay")'>未付款</span>
            <span class="listtypevalue" onclick='/**/click_me_mjth($(this),"credit")'>账期</span>
        </div>
        <div class="sdsy_nave_b">
            <span class="sdsy_date">
                <span class="sdsy_date_d">日期 <input type="text" class="datepicker" name="pickup_from_day"  size="10" maxlength="50" readonly="readonly"> 至 <input type="text" class="datepicker" name="pickup_to_day"  size="10" maxlength="50" readonly="readonly">
                </span>
            </span>
            <span class="sdsy_search"><input class="iinput name_iime" id="pickup_searchwords" name="pickup_searchwords" type="text" placeholder="请输入卖家昵称" autocomplete="off"/></span>
            <span id="btn_pickuporder_search" onclick="/**/search_mjth()" class="btn_normal_green">搜索</span>
        </div>
    </div>                        
</div>

<!-- refresh_begin -->
<?php                    
$order_type="('dkph','ckph')";
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
@$from_day=$_REQUEST["pickup_from_day"]?get_ymd($_REQUEST["pickup_from_day"])["d"]:null;
@$to_day=$_REQUEST["pickup_to_day"]?get_ymd($_REQUEST["pickup_to_day"])["d"]+24*3600:null;
@$pickup_searchwords=$_REQUEST["pickup_searchwords"]=="请输入卖家昵称"?null:$_REQUEST["pickup_searchwords"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id="";

$where=@array("order_boss_m_bianhao=? and (order_master_bianhao=? or order_slave_bianhao=?) and order_is_pay=? and order_is_pickup=? and order_seller_cycle>=? and order_seller_cycle<=? and order_addtime>=? and order_addtime<=? and order_type in ${order_type} and order_seller_name=?",
        $boss_id,$order_master_id,$order_master_id,$_REQUEST["order_is_pay"],$_REQUEST["order_is_pickup"],$_REQUEST["order_seller_cycle_min"],$_REQUEST["order_seller_cycle_max"],$from_day,$to_day,$pickup_searchwords);
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
<div class="order">
    <div class="order_inner">
        <div class="order_table_header">
            <div style="padding:5px 0; font-size:12px;"><span>编号：</span><?php echo $roworder["order_bianhao"];?></div>
            <div style="margin-left:10px; padding:5px 0;"><span>时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
            <div style="margin-left:10px; padding:5px 0;"><span><?php if ($roworder["order_master_type"]=="1") { echo "配货档口："; } elseif ($roworder["order_master_type"]=="2") { echo "配货仓库："; } ?></span><span style="color:#0099FF"><?php echo $roworder["order_master_name"]; ?></span></div>
            <?php if ($roworder["order_master_type"]=="2") 
            {
            ?>
            <div style="margin-left:10px; padding:5px 0;"><span>销售档口：</span><span><?php echo $roworder["order_slave_name"]; ?></span></div>
            <?php
            }
            ?>
            <div style="margin-left:10px; padding:5px 0;"><span>操作用户：</span><?php echo $roworder["order_user_name"]; ?></div>

            <?php
            if ($roworder["order_seller_cycle"]=="0")
            {
            ?>
            <div style="margin-left:10px; padding:5px 0; color:#009900;">现结</div>
            <?php
            }
            elseif ($roworder["order_seller_cycle"]>"0")
            {
            ?>
            <div style="margin-left:10px; padding:5px 0; color:#FF3300;">账期</div>
            <?php
            }
            ?>
            
            <?php
            if (($roworder["order_type"]=="dkph" or $roworder["order_type"]=="ckph") and $roworder["order_is_pickup"]=="0")
            {
            ?>
            <div class="pending_delivery">待提货</div>
            <?php
            }
            elseif (($roworder["order_type"]=="dkph" or $roworder["order_type"]=="ckph") and $roworder["order_is_pickup"]=="1")
            {
            ?>
            <div class="take_delivery">已提货</div>
            <?php
            }
            elseif (($roworder["order_type"]=="dkph" or $roworder["order_type"]=="ckph") and $roworder["order_is_pickup"]=="2")
            {
            ?>
            <div class="push_delivery">放弃提货</div>
            <?php
            }
            ?>
                                                    
            <?php
            if ($roworder["order_seller_cycle"]=="0" and $roworder["order_is_pay"]=="0")
            {
            ?>
            <div style="margin-left:10px; padding:5px 0; color:#FF3300;">未付款</div><input type="hidden" id="pickup_order_is_pay_modify_<?php echo $roworder["order_bianhao"]?>" value="1">
            <?php
            }
            elseif ($roworder["order_seller_cycle"]=="0" and $roworder["order_is_pay"]=="1")
            {
            ?>
            <div style="margin-left:10px; padding:5px 0; color:#009900;">已付款</div><input type="hidden" id="pickup_order_is_pay_modify_<?php echo $roworder["order_bianhao"]?>" value="0">
            <?php
            }
            ?>

            <div style="float:right; text-align:right">
                <span class="btn_order_red" style="color:#fff;" onclick="/**/SetPickupState(<?php echo $roworder["order_bianhao"]?>)">设置提货状态</span>
                
                <?php
                if (($roworder["order_type"]=="dkph" or $roworder["order_type"]=="ckph") and $roworder["order_is_pickup"]=="1" and $roworder["order_seller_cycle"]=="0" and ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4" and ($_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1" or $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="2"))))
                {
                ?>
                <span class="btn_order_red" style="color:#fff;" onclick="/**/SetPickupOrderPayStatus(<?php echo $roworder["order_bianhao"]?>)">修改付款状态</span>
                <?php
                }
                ?>
                
                <span class="btn_order_red" style="color:#fff;" onclick="/**/PrintOrder(<?php echo $roworder["order_bianhao"]?>)">打印</span>

            </div>
        </div>
        <div class="seller">
            <?php
            if ($roworder["order_seller_bianhao"]>"1")
            {
            ?>
            <span class="seller_h1">
                卖家：<span class="seller_b1"><?php echo $roworder["order_seller_name"];?></span>
            </span>
            <?php
            }
            else
            {
            ?>
            <span class="seller_h2">匿名卖家</span>
            <?php
            }
            ?>
        </div>
        <div class="order_table_tbody">
            <div style="width:30%;">货号 / 工厂</div>
            <div class="order_table_tbody_item" style="width:20%;">颜色</div>
            <div class="order_table_tbody_item" style="width:20%;">尺码</div>
            <div class="order_table_tbody_item" style="width:10%;">单价</div>
            <div class="order_table_tbody_item" style="width:20%;">数量</div>
        </div>
        <?php
        $shop_totalnum=0;
        $shop_totalprice=0;
        $rsitem = mysql_query("select * from ydf_order_detail where detail_order_bianhao='".$roworder["order_bianhao"]."' order by detail_p_bianhao, detail_p_color, detail_p_size", $dbconn); 
        while ($rowitem=mysql_fetch_array($rsitem))
        {
            $shop_totalnum+=$rowitem["detail_order_num"];
            $shop_totalprice+=$rowitem["detail_order_num"]*$rowitem["detail_price"];
            
            $p_factory=cselect("*","ydf_factory",array("factory_bianhao=?",$rowitem["detail_factory_bianhao"]));
            $rowfactory=$p_factory[0]->fetch();
        ?>        
        <div class="order_table_row">
            <div class="order_table_row_item" style="width:30%;"><?php echo $rowitem["detail_p_huohao"]?> / <?php echo $rowfactory["factory_name"]?></div>
            <div class="order_table_row_item" style="width:20%;text-align:center;"><?php echo $rowitem["detail_p_color"]?></div>
            <div class="order_table_row_item" style="width:20%;text-align:center;"><?php echo $rowitem["detail_p_size"]?></div>
            <div class="order_table_row_item" style="width:10%;color:#ee583d; text-align:center;"><?php echo $rowitem["detail_price"]?></div>
            <div class="order_table_row_item" style="width:20%;text-align:center;"><?php echo $rowitem["detail_order_num"]?></div>
        </div>
        <?php
        }
        ?>
        <div class="sdsy_total">
            <span class="total_title">数量总计：<span class="total_sum"><?php echo $shop_totalnum?></span>, 金额总计：<span class="total_money"><?php echo $shop_totalprice?></span></span>
        </div>
        <div class="sdsy_del">
            <span class="btn_order_red" onclick="/**/DeleteOrder(<?php echo $roworder["order_bianhao"]?>,'view_sales_pickup','form_sales_pickup')">删除</span>
        </div>
    </div>
</div>
<?php
}
?>

<div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个订单</div>

<script>/*n*//*n*/
$("#pid_view_sales_pickup #pages_mjth").set_page_count("view_sales_pickup","pages_mjth",<?php echo $page_count; ?>);
</script>
<!-- refresh_end -->
<div class="ipages" id="pages_mjth" page="view_sales_pickup" form="form_mjth" count="<?php echo $page_count; ?>"/>
</form> <!-- 页码也作为表单项统一处理  -->

<div id="layer_set_order_pickup_state">

</div>

<div id="layer_sales_pickup_select_storewarehouse" style="float:left; width:650px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; margin:10px 0; padding:10px 0; font-size:14px; color:#ee583d; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">请先选择当前处理业务归属的档口！</div>
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
            <div class="listclassvalue" onclick="/**/SuperManagerSalesPickupSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>','<?php echo $rowdangkou["dangkou_type"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
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
            <div class="listclassvalue" onclick="/**/SuperManagerSalesPickupSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>','<?php echo $rowdangkou["dangkou_type"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
        </div>
        <?php
        }
        ?>
    </div>

</div>
<div id="layer_warehousepickup_select_store" style="float:left; width:250px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; margin:10px 0; padding:10px 0; font-size:14px; color:#ee583d; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">请选择销售档口！</div>
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
        <div class="listtypevalue" onclick="/**/WarehousePickupSelectStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
    </div>
    <?php
    }
    ?>
</div>

<div id="layer_pickup_add_seller" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
        <p style="float:left; width:100%; padding:5px 0; display:block">
            <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 手机号：</span>
            <span style="float:left;">
            <input id="pickup_add_seller_mobile" name="pickup_add_seller_mobile" type="text" maxlength="50" style="width:150px; padding:5px" />
            </span>
        </p>
        <p style="float:left; width:100%; padding:5px 0; display:block">
            <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 卖家昵称：</span>
            <span style="float:left;">
            <input id="pickup_add_seller_name" name="pickup_add_seller_name" type="text" maxlength="50" style="width:150px; padding:5px"//>
            </span>
        </p>
        <p style="float:left; width:100%; padding:5px 0; display:block">
            <span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 账期：</span>
            <span tyle="float:left;" style="padding:5px">
                <select id="pickup_add_seller_cycle" name="pickup_add_seller_cycle">
                  <option value="" selected>请选择</option>
                  <option value="0">现结</option>
                  <option value="7">7天</option>
                  <option value="14">14天</option>
                  <option value="21">21天</option>
                  <option value="28">28天</option>
                </select>
            </span>
        </p>
    </div>
    <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
        <span id="pickup_add_seller_tip_notice" style="float:left;margin-left:80px"></span>
    </div>
    <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
        <span id="pickup_add_seller_affirm_btn" onclick="/**/PostPickupAddSeller()" style="float:left; margin-left:80px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认添加</span>
    </div>                
</div>
<script type="text/javascript">
pickup_order_type="dkph";
pickup_select_storewarehouse_bianhao="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]:"" ?>"; 
pickup_select_storewarehouse_name="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"]:"" ?>";
pickup_select_storewarehouse_type="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]:"" ?>";
pickup_order_to_dangkou_bianhao="";
pickup_order_to_dangkou_name="";
//$(function(){
//
//    $("#pickup_seller_name").focus(function(){
//        if(this.value=="卖家昵称"){this.value=""}
//        $(this).css("color","#333333");
//    });
//    $("#pickup_seller_name").blur(function(){
//        if(this.value==""){this.value="卖家昵称"; $(this).css("color","#cccccc")}
//    });
//
//    $("#pickup_searchwords").focus(function(){
//        if(this.value=="请输入卖家昵称"){this.value=""}
//        $(this).css("color","#333333");
//    });
//    $("#pickup_searchwords").blur(function(){
//        if(this.value==""){this.value="请输入卖家昵称"; $(this).css("color","#cccccc")}
//    });
//
//
//});

function PostSelectPickupSeller(){
    var status_userpurview_sales_pickup=true;
    $.ajax({
        url:"model-get-orderseller", 
        async: false,
        type: "POST",
        data:{var_order_seller_name:$("#pickup_seller_name").val()},
        dataType:"json",
        success: function(html){
            if (parseInt(html["state"])==1001)
            {
                alert("对不起，此昵称卖家不存在！");
                status_userpurview_sales_pickup=false;
            }
            else
            {
                pickup_order_seller_bianhao=html["order_seller_bianhao"];
                pickup_order_seller_name=html["order_seller_name"];
                pickup_order_seller_cycle=html["order_seller_cycle"];
            }
        }
    });
    
    if (status_userpurview_sales_pickup==true && pickup_select_storewarehouse_bianhao=="")
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
                    pickup_select_storewarehouse_bianhao=html["current_master_bianhao"]; 
                    pickup_select_storewarehouse_name=html["current_master_name"];
                    pickup_select_storewarehouse_type=html["current_master_type"];
                    
                    if (pickup_select_storewarehouse_type=="2")
                    {
                        index_layer_warehousepickup_select_store=layer.open({
                            type: 1,
                            area: ['320px', '400px'],
                            title: false,
                            content:$('#layer_warehousepickup_select_store')
                        });
                    }
                    else
                    {
                        mount_to_frame("view_sales_pickup_submit",1,"frame_sales_pickup");
                    }
                }
                else if (parseInt(html["state"])==1002)
                {
                    index_layer_sales_pickup_select_storewarehouse=layer.open({
                        type: 1,
                        area: ['720px', '300px'],
                        title: false,
                        content:$('#layer_sales_pickup_select_storewarehouse')
                    });
                }
            }
        });
    }
    else if (status_userpurview_sales_pickup==true && pickup_select_storewarehouse_bianhao!="")
    {
        if (pickup_select_storewarehouse_type=="2")
        {
            index_layer_warehousepickup_select_store=layer.open({
                type: 1,
                area: ['320px', '400px'],
                title: false,
                content:$('#layer_warehousepickup_select_store')
            });
        }
        else
        {
            mount_to_frame("view_sales_pickup_submit",1,"frame_sales_pickup");
        }
    }
}

function SuperManagerSalesPickupSelectDangkouStore(dangkou_bianhao,dangkou_name,dangkou_type){
    pickup_select_storewarehouse_bianhao=dangkou_bianhao;
    pickup_select_storewarehouse_name=dangkou_name;
    pickup_select_storewarehouse_type=dangkou_type;
    
    layer.close(index_layer_sales_pickup_select_storewarehouse);    
    
    if (dangkou_type=="2")
    {
        index_layer_warehousepickup_select_store=layer.open({
            type: 1,
            area: ['320px', '400px'],
            title: false,
            content:$('#layer_warehousepickup_select_store')
        });
    }
    else
    {
        mount_to_frame("view_sales_pickup_submit",1,"frame_sales_pickup");
    }
}

function WarehousePickupSelectStore(dangkou_bianhao,dangkou_name)
{
    layer.close(index_layer_warehousepickup_select_store);
    
    pickup_order_to_dangkou_bianhao=dangkou_bianhao;
    pickup_order_to_dangkou_name=dangkou_name;

    mount_to_frame("view_sales_pickup_submit",1,"frame_sales_pickup");
}

function SetPickupOrderPayStatus(order_bianhao){
    var order_is_pay=$("#pickup_order_is_pay_modify_" + order_bianhao).val();
    var setorderpaystatus_notice_message="";
    if (parseInt(order_is_pay)==0)
    {
        setorderpaystatus_notice_message="确定要设置当前订单未付款吗？";
    }
    else
    {
        setorderpaystatus_notice_message="确定要设置当前订单已付款吗？";
    }
    
    if(confirm(setorderpaystatus_notice_message))
    {
        $.ajax({
            url:"model-set-chukuorderpaystatus", 
            async: false,
            type: "POST",
            data:{var_order_bianhao:order_bianhao, var_order_is_pay:order_is_pay},
            success: function(html){
                refresh_inner("view_sales_pickup?"+$("#form_mjth").serialize() );
            }
        });    
    }

}

function SetPickupState(order_bianhao){
    $.ajax({
        url:"get-orderpickup", 
        async: false,
        type: "POST",
        data:{var_order_bianhao:order_bianhao},
        success: function(html){
            $("#layer_set_order_pickup_state").html(html);
        }
    })
    
    index_layer_set_order_pickup_state=layer.open({
        type: 1,
        area: ['420px', '200px'],
        title: false,
        content:$('#layer_set_order_pickup_state')
    });
}

function PostSetOrderPickup(order_bianhao,seller_bianhao){
    if(!$("#order_is_pickup_"+order_bianhao).val())
    {
        alert("请选择提货状态！");
        return false;
    }
    
    $.ajax({
        url:"model-order-post", 
        async: false,
        type: "POST",
        data:{order_type:"phth", order_bianhao:order_bianhao, order_seller_bianhao:seller_bianhao, order_is_pickup:$("#order_is_pickup_"+order_bianhao).val(),order_return_dangkou_bianhao:pickup_select_storewarehouse_bianhao,order_return_dangkou_name:pickup_select_storewarehouse_name},
        success: function(html){
            refresh_inner("view_sales_pickup?"+$("#form_mjth").serialize() );
            layer.close(index_layer_set_order_pickup_state);
        }
    });    
}

function ShowPickupAddSeller(){
    index_layer_pickup_add_seller=layer.open({
        type: 1,
        area: ['420px', '300px'],
        title: false,
        content:$('#layer_pickup_add_seller')
    });
}

function PostPickupAddSeller(){ 
    if(!$("#pickup_add_seller_mobile").val())
    {
        $("#pickup_add_seller_tip_notice").html("<span style='font-size:14px; color:red'>亲，卖家手机不能为空哦！</span>");
        return false;
    }
    
    if(!$("#pickup_add_seller_name").val())
    {
        $("#pickup_add_seller_tip_notice").html("<span style='font-size:14px; color:red'>亲，卖家昵称不能为空哦！</span>");
        return false;
    }
    
    if(!$("#pickup_add_seller_cycle").val())
    {
        $("#pickup_add_seller_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择卖家账期哦！</span>");
        return false;
    }

    var status_userpurview_sales_pickup=true;
            
    $.ajax({
        url:"model-post-addseller", 
        async: false,
        type: "POST",
        data:{var_seller_mobile:$("#pickup_add_seller_mobile").val(),var_seller_name:$("#pickup_add_seller_name").val(),var_seller_cycle:$("#pickup_add_seller_cycle").val()},
        dataType:"json",
        success: function(html){
            if (html["state"]=="ok")
            {
                layer.close(index_layer_pickup_add_seller);
                
                pickup_order_seller_bianhao=html["seller_id"];
                pickup_order_seller_name=$("#pickup_add_seller_name").val();
                pickup_order_seller_cycle=$("#pickup_add_seller_cycle").val();
            }
            else
            {
                $("#pickup_add_seller_tip_notice").html("<span style='font-size:14px; color:red'>"+html["desc"]+"</span>");
            }
        }
    });
    
    if (status_userpurview_sales_pickup==true && pickup_select_storewarehouse_bianhao=="")
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
                    pickup_select_storewarehouse_bianhao=html["current_master_bianhao"]; 
                    pickup_select_storewarehouse_name=html["current_master_name"];
                    
                    if (pickup_select_storewarehouse_type=="2")
                    {
                        index_layer_warehousepickup_select_store=layer.open({
                            type: 1,
                            area: ['320px', '400px'],
                            title: false,
                            content:$('#layer_warehousepickup_select_store')
                        });
                    }
                    else
                    {
                        mount_to_frame("view_sales_pickup_submit",1,"frame_sales_pickup");
                    }
                }
                else if (parseInt(html["state"])==1002)
                {
                    index_layer_sales_pickup_select_storewarehouse=layer.open({
                        type: 1,
                        area: ['720px', '300px'],
                        title: false,
                        content:$('#layer_sales_pickup_select_storewarehouse')
                    });
                }
            }
        });
    }
    else if (status_userpurview_sales_pickup==true && pickup_select_storewarehouse_bianhao!="")
    {
        if (pickup_select_storewarehouse_type=="2")
        {
            index_layer_warehousepickup_select_store=layer.open({
                type: 1,
                area: ['320px', '400px'],
                title: false,
                content:$('#layer_warehousepickup_select_store')
            });
        }
        else
        {
            mount_to_frame("view_sales_pickup_submit",1,"frame_sales_pickup");
        }
    } 
}

$('#layer_pickup_add_seller').on('keydown',function(e){

            if(e.keyCode == 13){
                //模拟点击登陆按钮，触发上面的 Click 事件
                $('#layer_pickup_add_seller input,select').blur();
                $("#pickup_add_seller_affirm_btn").click(
                );
            }
        });

$(document).ready(function() {

        $(".datepicker").datepicker({duration:""});
        $(".datepicker").datepicker({duration:""});//绑定输入框

    });
</script>
