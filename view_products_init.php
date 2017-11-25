<?php

include_once("check_dangkou_user.php");
?>
<script type="text/javascript">    
function click_page_num_kccsh(obj)
{
    set_page_list_kccsh(obj);
    refresh_inner("view_products_init?"+$("#form_kccsh").serialize() );
}

function set_page_list_kccsh(obj)
{
    if (obj.attr("id")=="last"||obj.attr("id")=="next")
    {
        mobj=$("#pages_kccsh").find("#m");
        if (obj.attr("id")=="last" && Number(mobj.html())-1>=1){
            var bingo=Number(mobj.html())-1;
            mobj.html(bingo);
            set_page_list_kccsh(mobj);
        }
        if (obj.attr("id")=="next" && Number(mobj.html())+1<=page_count_kccsh){
            var bingo=Number(mobj.html())+1;
            mobj.html(bingo);
            set_page_list_kccsh(mobj);
        }
        return;
    }

    $("#pages_kccsh").find("#ll").html("1");
    $("#pages_kccsh").find("#rr").html(page_count_kccsh);

    var bingo=Number(obj.html());

    $("#page_idx_kccsh").attr("value",bingo);

    $("#pages_kccsh").find("#m").html(bingo);//中间页码
    $("#pages_kccsh").find("#l1").html(bingo-1);//左1页码
    $("#pages_kccsh").find("#l2").html(bingo-2);//左2页码
    $("#pages_kccsh").find("#r1").html(bingo+1);//右1页码
    $("#pages_kccsh").find("#r2").html(bingo+2);//右2页码

    $("#pages_kccsh").find(".pagelink").each(function(){
        var num=Number($(this).html())
        if (num<=0||num>page_count_kccsh){
            $(this).css("display","none");
        }else{
            $(this).css("display","inline");
        }
    });
    

}

function list_kccsh()
{
    //重置value
    $('#productsinit_from_day').attr("value","");
    $('#productsinit_to_day').attr("value","");
    
    mobj=$("#pages_kccsh").find("#m");
    mobj.html(1);
    set_page_list_kccsh(mobj);//模拟点击第一页

    refresh_inner("view_products_init?"+$("#form_kccsh").serialize() );
}

function search_kccsh()
{
    $("#btn_productsinit_search").parent().prev().find(".listtypevalue").removeClass('listtypeselect');
    
    mobj=$("#pages_kccsh").find("#m");
    mobj.html(1);
    set_page_list_kccsh(mobj);//模拟点击第一页

    refresh_inner("view_products_init?"+$("#form_kccsh").serialize() );
}

function click_me_kccsh(obj,state)
{
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");

    list_kccsh();
}
</script>
<form id="form_kccsh">
<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block;">
    <div style="float:right">
        <span class="btn_normal_red" onclick="/**/ProductsInitClick()">开始初始化</span>
    </div>
</div>
<div  style="float:left; width:100%; margin:10px 0; padding:5px; overflow:hidden; display:block">
    <div style="float:left; overflow:hidden; display:block">
        <span class="listtypevalue listtypeselect" onclick='/**/click_me_sdsy($(this),"")'>全部</span>
    </div>
    <div style="float:right; overflow:hidden; display:block">
        <span style="float:left; overflow:hidden; display:block">
            <span style="padding:5px 0">日期 <input type="text" id="productsinit_from_day" name="productsinit_from_day" onclick="/**/WdatePicker({dateFmt:'yyyy-MM-dd'})" size="10" maxlength="50" readonly="readonly" style="padding:5px"> 至 <input type="text" id="productsinit_to_day" name="productsinit_to_day" onclick="/**/WdatePicker({dateFmt:'yyyy-MM-dd'})" size="10" maxlength="50" readonly="readonly" style="padding:5px">
            </span>
        </span>
        <span id="btn_productsinit_search" onclick="/**/search_kccsh()" class="btn_normal_green">搜索</span>
    </div>
</div>

<!-- refresh_begin -->
<?php                    
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
@$from_day=$_REQUEST["productsinit_from_day"]?get_ymd($_REQUEST["productsinit_from_day"])["d"]:null;
@$to_day=$_REQUEST["productsinit_to_day"]?get_ymd($_REQUEST["productsinit_to_day"])["d"]+24*3600:null;

$where=@array("order_boss_m_bianhao=? and order_addtime>=? and order_addtime<=? and order_type='kccsh'",$boss_id,$from_day,$to_day);
$where=clean_where($where);
//print_r($where);
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;
$offset=($page-1)*$pagesize;
$p=cselect("*","ydf_order",$where,"","order_bianhao desc",$offset,$pagesize);
//if ($p[0]->errorCode()!="00000")
//print_r($p[0]->errorInfo());
$rowcount=$p[1];
$page_count=ceil($rowcount/$pagesize);  
while ($roworder=$p[0]->fetch())
{
    $p_orderdetail=cselect("*","ydf_order_detail",array("detail_order_bianhao=?" ,$roworder["order_bianhao"]));
    $roworderdetail=$p_orderdetail[0]->fetch();
    
    $p_factory=cselect("*","ydf_factory",array("factory_bianhao=?" ,$roworderdetail["detail_factory_bianhao"]));
    $rowfactory=$p_factory[0]->fetch();
    $order_init_date=date("Y-m-d",$rowfactory["factory_addtime"]);
?>
<div style="width:99%; margin:0 auto 20px auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
    <div style="float:left; width:98%; padding:10px 1%; overflow:hidden; display:block">
        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
            <div style="float:left; padding:5px 0; font-size:12px"><span style="color:#999999">编号：</span><?php echo $roworder["order_bianhao"];?></div>
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">初始化：</span><span style="color:#0099FF"><?php echo $roworder["order_master_name"];?></span></div>    
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">时间：</span><?php echo $order_init_date; ?></div>
            <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">操作用户：</span><?php echo $roworder["order_user_name"];?></div>    
            
            <div style="float:right; text-align:right">
                <span class="btn_order_red" onclick="/**/PrintOrder(<?php echo $roworder["order_bianhao"]?>)">打印</span>
            </div>
        </div>
        <div style="width:100%; margin:0 auto; padding:15px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block;">
            <div style="float:left; width:30%; font-size:12px; color:#999999">货号</div>
            <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">颜色</div>
            <div style="float:left; width:20%; font-size:12px; color:#999999; text-align:center">尺码</div>
            <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">盘库数量</div>
            <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">系统库存</div>
            <div style="float:left; width:10%; font-size:12px; color:#999999; text-align:center">初始数量</div>
        </div>
        <?php
        $p_orderdetail=cselect("*","ydf_order_detail",array("detail_order_bianhao=?" ,$roworder["order_bianhao"]));
        while($roworderdetail=$p_orderdetail[0]->fetch())
        { 
            $p_factory=cselect("*","ydf_factory",array("factory_bianhao=?",$roworderdetail["detail_factory_bianhao"]));
            $rowfactory=$p_factory[0]->fetch();
        ?>        
        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
            <div style="float:left; width:30%; height:20px; font-size:12px"><?php echo $roworderdetail["detail_p_huohao"]?> / <?php echo $rowfactory["factory_name"]?></div>
            <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $roworderdetail["detail_p_color"]?></div>
            <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $roworderdetail["detail_p_size"]?></div>
            <div style="float:left; width:10%; height:20px; font-size:12px; text-align:center"><?php echo $roworderdetail["detail_really_stock_num"] ?></div>
            <div style="float:left; width:10%; height:20px; font-size:12px; text-align:center"><?php echo $roworderdetail["detail_really_stock_num"]-$roworderdetail["detail_order_num"] ?></div>
            <div style="float:left; width:10%; height:20px; font-size:12px; text-align:center"><?php echo $roworderdetail["detail_order_num"] ?></div>
        </div>
        <?php
        }
        ?>
        <div style="width:100%; padding:10px 0; text-align:right; overflow:hidden; display:block;">
            <span class="btn_order_red" onclick="/**/DeleteOrder(<?php echo $roworder["order_bianhao"]?>,'view_products_init','form_products_init')">删除</span>
        </div>
    </div>
</div>
<?php
}
?>

<div style="float:right; margin-top:5px; font-size:14px"> 共 <span style="font-size:14px; color:#d51938; font-weight:bold;"><?php echo $rowcount?></span> 个订单</div>

<script>/*n*/    
var page_count_kccsh=<?php echo $page_count; ?>;
/**/set_page_list_kccsh($("#pages_kccsh").find("#m"));
</script>

<!-- refresh_end -->
<div class="showpage" id="pages_kccsh">
    <input id="page_idx_kccsh" name="page_idx" style="display:none" value="1"/>
    <span style="display:block">
        <span class="pagelink" id="last" onclick="/**/click_page_num_kccsh($(this))" >上一页</span>
        <span class="pagelink" id="ll" onclick="/**/click_page_num_kccsh($(this))" />
        <span class="pageblank"  id="lb">...</span>
        <span class="pagelink" id="l2" onclick="/**/click_page_num_kccsh($(this))" />
        <span class="pagelink" id="l1" onclick="/**/click_page_num_kccsh($(this))" />
        <span class="pageselect" id="m"  onclick="/**/click_page_num_kccsh($(this))"  >1</span>
        <span class="pagelink" id="r1" onclick="/**/click_page_num_kccsh($(this))" />
        <span class="pagelink" id="r2" onclick="/**/click_page_num_kccsh($(this))" />
        <span class="pageblank"  id="rb">...</span>
        <span class="pagelink" id="rr" onclick="/**/click_page_num_kccsh($(this))" />
        <span class="pagelink" id="next" onclick="/**/click_page_num_kccsh($(this))" >下一页</span>
    </span>
</div>
</form> <!-- 页码也作为表单项统一处理  -->

<div id="layer_productsinit_select_storewarehouse" style="float:left; width:650px; padding:25px; overflow:visible; display:none">
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
            <div class="listclassvalue" onclick="/**/SuperManagerProductsinitSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
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
            <div class="listclassvalue" onclick="/**/SuperManagerProductsinitSelectDangkouStore('<?php echo $rowdangkou["dangkou_bianhao"]?>','<?php echo $rowdangkou["dangkou_name"]?>')"><?php echo $rowdangkou["dangkou_name"] ?></div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
<script type="text/javascript">
var productsinit_select_storewarehouse_bianhao="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]:"" ?>"; 
var productsinit_select_storewarehouse_name="<?php echo !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"])?$_SESSION["ERP_ACCOUNT_USER_DANGKOU_NAME"]:"" ?>";

function ProductsInitClick()
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
                productsinit_select_storewarehouse_bianhao=html["current_master_bianhao"]; 
                productsinit_select_storewarehouse_name=html["current_master_name"];
                
                mount_to_frame("view_products_init_submit?var_master_bianhao="+productsinit_select_storewarehouse_bianhao+"&var_master_name="+productsinit_select_storewarehouse_name,1,"frame_products_init");
            }
            else if (parseInt(html["state"])==1002)
            {
                index_layer_productsinit_select_storewarehouse=layer.open({
                    type: 1,
                    area: ['720px', '300px'],
                    title: false,
                    content:$('#layer_productsinit_select_storewarehouse')
                });
            }
        }
    });
}

function SuperManagerProductsinitSelectDangkouStore(master_dangkou_bianhao,master_dangkou_name){
    productsinit_select_storewarehouse_bianhao=master_dangkou_bianhao; 
    productsinit_select_storewarehouse_name=master_dangkou_name;
                
    layer.close(index_layer_productsinit_select_storewarehouse);
    
    mount_to_frame("view_products_init_submit?var_master_bianhao="+productsinit_select_storewarehouse_bianhao+"&var_master_name="+productsinit_select_storewarehouse_name,1,"frame_products_init");
}
</script>
