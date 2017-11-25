<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_order.php");
?>
<script type="text/javascript">

function list_qcfc()
{
    $('#search_factory_bill_from_date').attr("value","");
    $('#search_factory_bill_to_date').attr("value","");
        
    $("#pid_view_stock_clear #pages_qcfc").set_page_num("view_stock_clear","pages_qcfc",1);

    refresh_inner("view_stock_clear?"+$("#form_qcfc").serialize() );
}

function search_qcfc()
{
    $("#pid_view_stock_clear #pages_qcfc").set_page_num("view_stock_clear","pages_qcfc",1);

    refresh_inner("view_stock_clear?"+$("#form_qcfc").serialize() );
}

function click_me_qcfc(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");

    list_qcfc();
}
</script>
<form id="form_qcfc">
<div class="thfc_setup">
    <div class="thfc_setup_h">
        <div style="float:left; overflow:hidden; display:block">
            <span style="float:left; overflow:hidden; display:block">
                <span style="padding:5px 0">日期 <input type="text" class="datepicker" name="from_day"  size="12" maxlength="50" readonly="readonly" style="padding:5px"> 至 <input type="text" class="datepicker" name="to_day"  size="12" maxlength="50" readonly="readonly" style="padding:5px">
                </span>
            </span>
            <div class="lf" style="margin-left:5px;">
                <select  name="factory_id" style="padding: 5px;">
                    <option value="">请选择工厂</option><?php get_factory_option(); ?>
                </select>
            </div>

            <span id="btn_arrange_factory_search" onclick="search('view_stock_clear','form_qcfc')" class="btn_normal_blue public_search_sm">搜索</span>
            <span class="clear_search" onclick="mount_to_frame('view_stock_clear',1,'frame_stock_clear')">清空<br>条件</span>
        </div>
        <div class="thfc_setup_b">
            <span class="btn_normal_blue" onclick="/**/StockclearClick()">开始返厂</span>
        </div>
    </div>
</div>


<!-- refresh_begin -->
<?php
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;
@$factory_bianhao=$_REQUEST["factory_id"]==""?null:$_REQUEST["factory_id"];

$where=@array("order_boss_m_bianhao=? and order_addtime>=? and order_addtime<=? and order_type='qcfc' and order_factory_bianhao=?",
$boss_id,$from_day,$to_day,$factory_bianhao);
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
<div class="stock" style="width:99%; margin:0 auto 20px auto;">
    <div class="stock_inner">
        <div class="stock_table_header">
            <div style=" padding:5px 0;"><span style="color:#999999">返厂：</span><span style="color:#0099FF"><?php echo $roworder["order_factory_name"];?></span></div>
            <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">清仓：</span><span style="color:#0099FF"><?php echo $roworder["order_master_name"];?></span></div>
            <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">编号：</span><?php echo $roworder["order_bianhao"];?></div>
            <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">时间：</span><?php echo date("Y-m-d H:i:s",$roworder["order_addtime"]); ?></div>
            <div style="margin-left:10px; padding:5px 0;"><span style="color:#999999">操作用户：</span><?php echo $roworder["order_user_name"];?></div>
            
            <div style="float:right; text-align:right">
                <span class="btn_order_red" onclick="/**/PrintOrder(<?php echo $roworder["order_bianhao"]?>)">打印</span>
            </div>
        </div>
        <div class="stock_table_tbody3">
            <div style="width:25%;">货号</div>
            <div style="width:20%; text-align:center">颜色</div>
            <div style="width:20%; text-align:center">尺码</div>
            <div style="width:20%; text-align:center">成本价</div>
            <div style="width:15%; text-align:center">清仓数量</div>
        </div>
        <?php
        $shop_totalnum=0;
        $shop_totalprice=0;
        $rsitem = mysql_query("select * from ydf_order_detail where detail_order_bianhao='".$roworder["order_bianhao"]."' order by detail_p_bianhao, detail_p_color, detail_p_size", $dbconn); 
        while ($rowitem=mysql_fetch_array($rsitem))
        {
            $shop_totalnum+=$rowitem["detail_order_num"];
            $shop_totalprice+=$rowitem["detail_order_num"]*$rowitem["detail_valueprice"];
        ?>        
        <div class="stock_table_row3">
            <div style="width:25%; height:20px;"><?php echo $rowitem["detail_p_huohao"]?></div>
            <div style="width:20%; height:20px; text-align:center"><?php echo $rowitem["detail_p_color"]?></div>
            <div style="width:20%; height:20px; text-align:center"><?php echo $rowitem["detail_p_size"]?></div>
            <div style="width:20%; height:20px; text-align:center"><?php echo $rowitem["detail_valueprice"]?></div>
            <div style="width:15%; height:20px; text-align:center"><?php echo $rowitem["detail_order_num"] ?></div>        </div>
        <?php
        }
        ?>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span style="font-size:12px"><span style="color:#999999">数量总计：</span><span style=" font-size:12px; color:#ee583d"><?php echo $shop_totalnum?></span> <span style="color:#999999">成本总计：</span><span style="font-size:12px; color:#ee583d"><?php echo $shop_totalprice?></span></span>
        </div>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span class="btn_order_red" onclick="/**/DeleteOrder(<?php echo $roworder["order_bianhao"]?>,'view_stock_clear','form_qcfc')">删除</span>
        </div>
    </div>
</div>
<?php
}
?>

<div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个订单</div>

<script>/*n*/    
$("#pid_view_stock_clear #pages_qcfc").set_page_count("view_stock_clear","pages_qcfc",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
    <div class="ipages" id="pages_qcfc" page="view_stock_clear" form="form_qcfc" count="<?php echo $page_count; ?>"></div>
</form> <!-- 页码也作为表单项统一处理  -->

<div id="layer_stockclear_select_storewarehouse" style="float:left; width:650px; padding:26px; overflow:visible; display:none">
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
            <div class="listclassvalue" onclick="/**/SuperManagerStockclearSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>','<?php echo $rowdangkou["dangkou_type"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
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
            <div class="listclassvalue" onclick="/**/SuperManagerStockclearSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>','<?php echo $rowdangkou["dangkou_type"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<div id="layer_stockclear_select_factory" style="float:left; width:400px; padding:25px; overflow:visible; display:none">
    <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
        <span style="float:left; width:120px; padding-top:8px; text-align:right"><span style="color:red">*</span> 工厂：</span>
        <span style="float:left;margin-left:10px">
            <select id="stockclear_select_factory" name="stockclear_select_factory" style="padding:5px">    
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
        <span style="float:left; margin-left:130px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer" onclick="/**/PostStockclearSelectFactory()">下一步</span>
    </div>
</div>
<script type="text/javascript">
var stockclear_select_storewarehouse_bianhao=""; 
var stockclear_select_storewarehouse_name="";
var stockclear_select_storewarehouse_type="";

function StockclearClick()
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
                stockclear_select_storewarehouse_bianhao=html["current_master_bianhao"]; 
                stockclear_select_storewarehouse_name=html["current_master_name"];
                stockclear_select_storewarehouse_name=html["current_master_type"];
                
                index_layer_stockclear_select_factory=layer.open({
                    type: 1,
                    area: ['470px', '200px'],
                    title: false,
                    content:$('#layer_stockclear_select_factory')
                });
            }
            else if (parseInt(html["state"])==1002)
            {
                index_layer_stockclear_select_storewarehouse=layer.open({
                    type: 1,
                    area: ['720px', '300px'],
                    title: false,
                    content:$('#layer_stockclear_select_storewarehouse')
                });
            }
        }
    });
}

function SuperManagerStockclearSelectDangkouStore(master_dangkou_bianhao,master_dangkou_name,master_dangkou_type){
    stockclear_select_storewarehouse_bianhao=master_dangkou_bianhao; 
    stockclear_select_storewarehouse_name=master_dangkou_name;
    stockclear_select_storewarehouse_type=master_dangkou_type;
                
    layer.close(index_layer_stockclear_select_storewarehouse);
    
    index_layer_stockclear_select_factory=layer.open({
        type: 1,
        area: ['470px', '200px'],
        title: false,
        content:$('#layer_stockclear_select_factory')
    });
}

function PostStockclearSelectFactory()
{
    if  ($("#stockclear_select_factory").val()=="")
    {
        alert("请先选择工厂！");
        return false;
    }

    layer.close(index_layer_stockclear_select_factory);
     
    mount_to_frame("view_stock_clear_submit?var_master_bianhao="+stockclear_select_storewarehouse_bianhao+"&var_master_name="+stockclear_select_storewarehouse_name+"&var_master_type="+stockclear_select_storewarehouse_type+"&var_factory_bianhao="+$("#stockclear_select_factory").val(),1,"frame_stock_clear");
}

</script>
