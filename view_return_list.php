<?php

include_once("check_dangkou_user.php");
?>

<script type="text/javascript">    
function search_thdj()
{    
    mobj=$("#pages_thdj").find("#m");
    mobj.html(1);
    $("#pid_view_return_list #pages").set_page_num("view_return_list","pages",1);

    refresh_inner("view_return_list?"+$("#form_thdj").serialize() );
}

function click_me_thdj(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");
    
    //重置value
    $('#tuihuo_order_pay_thdj').attr("value","");
    $('#tuihuo_order_is_cashier').attr("value","");
    $('#tuihuo_order_credit_min_thdj').attr("value","");
    $('#tuihuo_order_credit_max_thdj').attr("value","");

    if (state=="havepay")//已未付款订单
    {
        $('#tuihuo_order_pay_thdj').attr("value","1");
        $('#tuihuo_order_is_cashier').attr("value","1");
        $('#tuihuo_order_credit_min_thdj').attr("value","");
        $('#tuihuo_order_credit_max_thdj').attr("value","");
    }
    if (state=="pay")//未付款订单
    {
        $('#tuihuo_order_pay_thdj').attr("value","0");
        $('#tuihuo_order_is_cashier').attr("value","1");
        $('#tuihuo_order_credit_min_thdj').attr("value","");
        $('#tuihuo_order_credit_max_thdj').attr("value","");
    }
    
    if (state=="credit")
    {
        $('#tuihuo_order_is_cashier').attr("value","");
        $('#tuihuo_order_credit_min_thdj').attr("value","1");
        $('#tuihuo_order_credit_max_thdj').attr("value","");
    }

    search_thdj();
}

$("#thdj_update_time").click(function(){
    $(this).hide();
    $("#thdj_creation_time").show();
    $("#thdj_order_by").val("2");
    search_thdj();
});
$("#thdj_creation_time").click(function(){
    $(this).hide();
    $("#thdj_update_time").show();
    $("#thdj_order_by").val("1");
    search_thdj();
});
</script>
<form id="form_thdj">
<div class="sdsy_setup">
    <div class="sdsy_setup_h" style="display:none;">
        <div class="sdsy_setup_b">
            <span class="chuku_seller_s"><input class="iinput name_iime ino_ime_input iseller_name" id="tuihuo_seller_name" name="tuihuo_seller_name" type="text"  placeholder="请输入卖家拼音首字母"  autocomplete="off" style="width:200px;font-size:16px"/></span>
            <span id="btn_selecttuihuo" onclick="/**/PostSelectTuihuoSeller()">开始登记</span>
        </div>
    </div>    
    <div class="sdsy_nave">
        <div class="sdsy_nave_a">
            <input type="hidden" id="tuihuo_order_pay_thdj" name="order_pay_thdj" value=""/>
            <input type="hidden" id="tuihuo_order_is_cashier" name="tuihuo_order_is_cashier" value=""/>
            <input type="hidden" id="tuihuo_order_credit_min_thdj" name="order_seller_cycle_min" value=""/>
            <input type="hidden" id="tuihuo_order_credit_max_thdj" name="order_seller_cycle_max" value=""/>
            <span class="listtypevalue listtypeselect" onclick='/**/click_me_thdj($(this),"")'>全部</span>
            <span class="listtypevalue" onclick='/**/click_me_thdj($(this),"havepay")'>已付款</span>
            <span class="listtypevalue" onclick='/**/click_me_thdj($(this),"pay")'>未付款</span>
            <span class="listtypevalue" onclick='/**/click_me_thdj($(this),"credit")'>账期订单 | </span>
            <span style="float:left; margin-top:4px;"> <img src="/pc/images/39-Clock.png"></span>
            <span id="thdj_update_time" style="float:left; margin-left:5px; width:90px; text-align:left; margin-top:6px;" class="clear_search">按更新时间</span>
            <span id="thdj_creation_time" style="float:left; margin-left:5px; width:90px; display:none; text-align:left; margin-top:6px;" class="clear_search" >按创建时间</span>
        </div>
        <div class="sdsy_nave_b">
            <span class="sdsy_date">
                <span class="sdsy_date_d">日期 <input type="text" class="datepicker"  name="tuihuo_from_day"  size="12" maxlength="50" readonly="readonly"> 至 <input type="text" class="datepicker" name="tuihuo_to_day"  size="12" maxlength="50" readonly="readonly">
                </span>
            </span>
            <span class="sdsy_search"><input class="iinput name_iime ino_ime_input iseller_name" id="tuihuo_searchwords" name="tuihuo_searchwords" type="text" placeholder="请输入卖家拼音首字母" autocomplete="off" style="width:168px;"/></span>
            <span id="btn_tuihuoorder_search" onclick="/**/search_thdj()" class="btn_normal_blue public_search">搜索</span>
            <span class="clear_search" onclick="mount_to_frame('view_return_list',1,'frame_return_list')">清空<br>条件</span>

            <input id="thdj_order_by" type="hidden" value="1" name="order_by">
        </div>
    </div>                     
</div>


<!-- refresh_begin -->
<?php                    
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
@$to_day=$_REQUEST["tuihuo_to_day"]?get_ymd($_REQUEST["tuihuo_to_day"])["d"]+24*3600:null;
@$from_day=$_REQUEST["tuihuo_from_day"]?get_ymd($_REQUEST["tuihuo_from_day"])["d"]:null;
@$tuihuo_order_is_cashier=$_REQUEST["tuihuo_order_is_cashier"]?$_REQUEST["tuihuo_order_is_cashier"]:null;
@$tuihuo_searchwords=$_REQUEST["tuihuo_searchwords"]=="请输入卖家昵称"?null:$_REQUEST["tuihuo_searchwords"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1")
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id="";

if(@$tuihuo_searchwords=="匿名卖家"){
    $where=@array("order_boss_m_bianhao=? and order_master_bianhao=? and order_is_pay=? and order_seller_cycle<? and order_seller_cycle>=? and order_seller_cycle<=? and order_addtime>=? and order_addtime<=? and order_type='thdj' and order_seller_bianhao='1'",
    $boss_id,$order_master_id,$_REQUEST["order_pay_thdj"],$tuihuo_order_is_cashier,$_REQUEST["order_seller_cycle_min"],$_REQUEST["order_seller_cycle_max"],$from_day,$to_day,$tuihuo_searchwords);
}else{
    $where=@array("order_boss_m_bianhao=? and order_master_bianhao=? and order_is_pay=? and order_seller_cycle<? and order_seller_cycle>=? and order_seller_cycle<=? and order_addtime>=? and order_addtime<=? and order_type='thdj' and order_seller_name=?",
    $boss_id,$order_master_id,$_REQUEST["order_pay_thdj"],$tuihuo_order_is_cashier,$_REQUEST["order_seller_cycle_min"],$_REQUEST["order_seller_cycle_max"],$from_day,$to_day,$tuihuo_searchwords);
}

$where=clean_where($where);
//print_r($where);
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;
$offset=($page-1)*$pagesize;
@$sort_time=@$_REQUEST["order_by"];
$p=null;
if($sort_time=="2"){
    $p=cselect("*","ydf_order",$where,"","update_time desc",$offset,$pagesize);
}else{
    $p=cselect("*","ydf_order",$where,"","order_addtime desc",$offset,$pagesize);
}

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
			<?php
			if ($roworder["order_seller_bianhao"]>"1")
			{
			?>
			<div style="float:left"><span>卖家：</span><span style="font-size:16px; font-weight:bold; color:#3366FF"><?php echo $roworder["order_seller_name"];?></span></div>
			<?php
			}
			else
			{
			?>
			<div style="float:left"><span>卖家：</span><span style="font-size:16px; font-weight:bold; color:#ee583d">匿名卖家</span></div>
			<?php
			}
			?>
            
            <?php
            if ($roworder["order_seller_cycle"]=="0")
            {
            ?>
            <div style="float:left; margin-left:10px; padding:3px 0; color:#009900;">现结</div>
            <?php
            }
            elseif ($roworder["order_seller_cycle"]>"0")
            {
            ?>
            <div style="float:left; margin-left:10px; padding:3px 0; color:#FF3300;">账期</div>
            <?php
            }
            ?>
            
            <?php
            if ($roworder["order_seller_cycle"]=="0" and $roworder["order_is_pay"]=="0")
            {
            ?>
            <div style="float:left; margin-left:10px; padding:3px 0; color:#FF3300;">未付款</div><input type="hidden" id="tuihuo_order_is_pay_modify_<?php echo $roworder["order_bianhao"]?>" value="1">
            <?php
            }
            elseif ($roworder["order_seller_cycle"]=="0" and $roworder["order_is_pay"]=="1")
            {
            ?>
            <div style="float:left; margin-left:10px; padding:3px 0; color:#009900;">已付款</div><input type="hidden" id="tuihuo_order_is_pay_modify_<?php echo $roworder["order_bianhao"]?>" value="0">
            <?php
            }
            ?>
            <div style="float:right; text-align:right;">
                <?php
                if ( $roworder["order_seller_cycle"]=="0" and !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1")
                {
                ?>
                <span class="btn_order_red" style="color:#fff;" onclick="/**/SetTuihuoOrderPayStatus(<?php echo $roworder["order_bianhao"]?>)">修改付款状态</span>
                <?php
                }
                ?>
                
                <span class="btn_order_red" style="color:#fff;" onclick="/**/PrintOrder(<?php echo $roworder["order_bianhao"]?>)">打印</span>
            </div>
        </div>
        <div class="order_table_header">
            <div style="padding:5px 0; font-size:12px;"><span>编号：</span><?php echo $roworder["order_bianhao"];?></div>
            <div style="margin-left:10px; padding:5px 0;"><span>档口：</span><?php echo $roworder["order_master_name"]; ?></div>
            <div style="margin-left:10px; padding:5px 0;"><span>操作用户：</span><?php echo $roworder["order_user_name"]; ?></div>
            <div style="margin-left:10px; padding:5px 0;"><span>创建时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>            
            <div style="margin-left:10px; padding:5px 0;"><span>更新时间：</span><?php echo date("Y-m-d H:i:s",$roworder["update_time"]); ?></div>
        </div>
        <div class="order_table_tbody">
            <div style="width:30%;">货号</div>
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
            <div class="order_table_row_item" style="width:20%;text-align:center;">-</div>
            <div class="order_table_row_item" style="width:20%;text-align:center;">-</div>
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
            <span class="btn_order_red" onclick="/**/DeleteOrder(<?php echo $roworder["order_bianhao"]?>,'view_return_list','form_return_list')">删除</span>
        </div>
    </div>
</div>
<?php
}
?>

<div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个订单</div>

<script>/*n*/    
$("#pid_view_return_list #pages").set_page_count("view_return_list","pages",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
<div class="ipages" id="pages" page="view_return_list" form="form_thdj" count="<?php echo $page_count; ?>"/>
</form> <!-- 页码也作为表单项统一处理  -->

<div id="layer_return_select_storewarehouse">
    <div class="current_stall">请先选择退货的销售档口！</div>
    <div class="listclassblock">
        <div class="listclassdefault">档口：</div>
    </div>
    <div class="current_box">
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
            <div class="listclassvalue" onclick="/**/SuperManagerReturnSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
        </div>
        <?php
        }
        ?>
        
    </div>

</div>

<div id="layer_tuihuo_order_paystatus"/>
<script type="text/javascript">
$("#tuihuo_seller_name").val($ ("#chuku_seller_nickname").val());
$ ("#fram_search_tab").css("display","block");
$ ("#frame_tab_panel").css("display","block");
tuihuo_select_storewarehouse_bianhao=""; 
tuihuo_select_storewarehouse_name="";
<?php
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1")
{
?>
tuihuo_select_storewarehouse_bianhao="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]:"" ?>"; 
tuihuo_select_storewarehouse_name="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"]:"" ?>";
<?php
}
?>

$(function(){
        $('#tuihuo_from_day').datepicker();
        $('#tuihuo_to_day').datepicker();//绑定输入框

});

function PostSelectTuihuoSeller(){
    var status_userpurview_return=true;
    $.ajax({
        url:"model-get-orderseller", 
        async: false,
        type: "POST",
        data:{var_order_seller_name:$("#tuihuo_seller_name").val()},
        dataType:"json",
        success: function(html){
            if (parseInt(html["state"])==1001)
            {
                alert("对不起，此昵称卖家不存在！");
                status_userpurview_return=false;
            }
            else
            {
                tuihuo_order_seller_bianhao=html["order_seller_bianhao"];
                tuihuo_order_seller_name=html["order_seller_name"];
                tuihuo_order_seller_cycle=html["order_seller_cycle"];
            }
        }
    });
    
    if (status_userpurview_return==true && tuihuo_select_storewarehouse_bianhao=="")
    {
        $.ajax({
            url:"check-store-userpurview", 
            async: false,
            type: "POST",
            data:"",
            dataType:"json",
            success: function(html){
                if (parseInt(html["state"])==1001 || parseInt(html["state"])==1003)
                {
                    tuihuo_select_storewarehouse_bianhao=html["current_master_bianhao"]; 
                    tuihuo_select_storewarehouse_name=html["current_master_name"];
                    mount_to_frame("view_return_submit",1,"frame_return_list");
                }
                else if (parseInt(html["state"])==1002)
                {
                    index_layer_return_select_storewarehouse=layer.open({
                        type: 1,
                        area: ['720px', '300px'],
                        title: false,
                        content:$('#layer_return_select_storewarehouse')
                    });
                }
            }
        });
    }
    else if (status_userpurview_return==true && tuihuo_select_storewarehouse_bianhao!="")
    {
        mount_to_frame("view_return_submit",1,"frame_return_list");
    }
}

function SuperManagerReturnSelectDangkouStore(dangkou_bianhao,dangkou_name){
    tuihuo_select_storewarehouse_bianhao=dangkou_bianhao;
    tuihuo_select_storewarehouse_name=dangkou_name;
    
    layer.close(index_layer_return_select_storewarehouse);    
    
    mount_to_frame("view_return_submit",1,"frame_return_list");
}

function SetTuihuoOrderPayStatus(order_bianhao){
    var order_is_pay=$("#tuihuo_order_is_pay_modify_" + order_bianhao).val();
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
            url:"model-set-tuihuoorderpaystatus", 
            async: false,
            type: "POST",
            data:{var_order_bianhao:order_bianhao, var_order_is_pay:order_is_pay},
            success: function(html){
                refresh_inner("view_return_list?"+$("#form_thdj").serialize() );
            }
        });    
    }

}
</script>
