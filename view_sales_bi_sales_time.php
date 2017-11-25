<?php 
include_once "{$root_path}/model/model_bi.php";
?>
<script type="text/javascript">

function search_sbi()
{
    $("#pid_view_sales_bi_sales_time #pages_sbi").set_page_num("view_sales_bi_sales_time","pages_sbi",1);
    refresh_inner("view_sales_bi_sales_time?"+$("#form_sbi").serialize() );
}

function click_me_sbi(obj,state)
{
    $('#verify_state_sbi').attr('value',state);
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");
    search_sbi();
}

function clean_search_sbi()
{
    mount_to_frame('view_sales_bi_sales_time',1,'frame_sales_bi_sales_time');
}
</script>
                        <form id="form_sbi">        
                        <input  type="hidden" name="bi_time" id="verify_state_sbi" value=""/>
                        <input  type="hidden" name="get_sales_guige_huohao" id="get_sales_guige_huohao" value=""/>
                        <input  type="hidden" name="get_sales_guige_color" id="get_sales_guige_color" value=""/>
                        <input  type="hidden" name="get_sales_guige_time" id="get_sales_guige_time" value=""/>
                        <div class="search_box">
                            <div class="search_box_inner">
                                <div class="sbi_a">
                                    <span class="listtypevalue listtypeselect" onclick='/**/click_me_sbi($(this),"day");'>日报</span>
                                    <span class="listtypevalue" onclick='/**/click_me_sbi($(this),"week");'>周报</span>
                                    <span class="listtypevalue" onclick='/**/click_me_sbi($(this),"month");'>月报</span>
                                    <span class="listtypevalue" onclick='/**/click_me_sbi($(this),"year");'>年报</span>
                                </div>
                                <div class="sbi_b">
                                    <span class="lf"><input style="width:142px;" id="search_sales_bi_huohao" name="search_sales_bi_huohao" type="text" placeholder="请输入商品货号" class="iinput name_iime ino_ime_input iproduct_name"/></span>
                                    <span id="btn_products_search" onclick="/**/search_sbi()" class="btn_normal_blue public_search">搜索</span>
                                    <span class="clear_search" onclick="mount_to_frame('view_sales_bi_sales_time',1,'frame_sales_bi_sales_time')">清空<br>条件</span>
                                </div>
                            </div>                        
                        </div>
                        <div class="report_table_header" style="margin-top:0px; background:#f2f2f2; paddding:10px 0">
                            <div style="width:12%; color:#999999">日期</div>
                            <div style="width:11%; color:#999999">货号</div>
                            <div style="width:11%; color:#999999">颜色</div>
                            <div style="width:11%; color:#999999">尺码</div>
                            <div style="width:11%; color:#999999">销量</div>
                            <div style="width:11%; color:#999999">会员数</div>
                            <div style="width:11%; color:#999999">散客数</div>
                            <div style="width:11%; color:#999999">退货</div>
                            <div style="width:11%; color:#999999">详细</div>
                        </div>

<!-- refresh_begin -->
<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];

$ymd=empty($_REQUEST["bi_time"])?"day":$_REQUEST["bi_time"];
@$search_sales_bi_huohao=$_REQUEST["search_sales_bi_huohao"]=="请输入商品货号"?null:$_REQUEST["search_sales_bi_huohao"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id="";

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=50;$offset=($page-1)*$pagesize; 
$group=array("detail_order_{$ymd}","detail_p_huohao");
$types=array('thdj', 'phth','xsck');
$where=array(
    "detail_boss_m_bianhao=? and detail_master_bianhao=? and detail_order_type in ('". join("','",$types) ."') and detail_p_huohao=?",
    $boss_id,$order_master_id,$search_sales_bi_huohao
);
function pool_sales($row){
    return $row["phth"]+$row["xsck"];
}
$sums=array();
foreach($types as $type)
    $sums[]="sum(CASE WHEN detail_order_type='{$type}' THEN detail_order_num ELSE 0 END ) as {$type}";
$sums[]="count(distinct CASE WHEN detail_order_type in ('xsck','phth') AND detail_seller_bianhao!=1 AND  detail_seller_bianhao!=0 THEN detail_seller_bianhao END) as member_count";
$sums[]="count(distinct CASE WHEN detail_order_type in ('xsck','phth') AND detail_seller_bianhao=1 AND detail_seller_bianhao!=0 THEN detail_order_bianhao END) as non_member_count";
$historys=bi_select($sums,"ydf_order_detail",$where,$group,"pool_sales");

$sorts=sort_rows($historys,$group);
debug($sorts);
$rowcount=count($historys);$page_count=ceil($rowcount/$pagesize);  
//echo json_encode($historys);
for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
    $row_main=$historys[$sorts[$idx][0] ];
?>
                        <div class="report_table_body" style="border-bottom:1px dashed #ccc">
                            <div class="time" style="width:12%; font-size:14px">
                            <?php
                            echo show_report_date(@$_REQUEST["bi_time"],$row_main["detail_order_{$ymd}"]);
                            ?>
                            </div>
                            <div style="width:11%;"><?php echo $row_main["detail_p_huohao"] ?></div>
                            <div style="width:11%; height:15px">-</div>
                            <div style="width:11%; height:15px">-</div>
                            <div style="width:11%;"><?php echo $row_main["pool"] ?></div>
                            <div style="width:11%;"><?php echo $row_main["member_count"]?></div>
                            <div style="width:11%;"><?php echo $row_main["non_member_count"]?></div>
                            <div style="width:11%;"><?php echo $row_main["thdj"]?></div>
                            <div style="width:11%; text-align:center"><span style=" color:#0099FF; cursor:pointer" onclick="/**/ShowSalesProductGuige('<?php echo $row_main["detail_p_huohao"] ?>','<?php echo date("Y-m-d",$row_main["detail_order_{$ymd}"]) ?>')">详细</span></div>
                        </div>
                        <div id="layer_sales_product_guige_<?php echo $row_main["detail_p_huohao"] ?>_<?php echo date("Y-m-d",$row_main["detail_order_{$ymd}"]) ?>" style="width:100%; margin:0 auto; overflow:hidden; display:none">
                        </div>
<?php
}
?>
                    
                    
                    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>

<script>/*n*/    
    $("#pid_view_sales_bi_sales_time #pages_sbi").set_page_count("view_sales_bi_sales_time","pages_sbi",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
    <div class="ipages" id="pages_sbi" page="view_sales_bi_sales_time" form="form_sbi" count="<?php echo $page_count; ?>"/>
                    </form> <!-- 页码也作为表单项统一处理  -->

<script type="text/javascript">    


function ShowSalesProductGuige(p_huohao,time)
{
    if ($("#layer_sales_product_guige_"+p_huohao+"_"+time).is(":visible")==false)
    {
        $('#get_sales_guige_huohao').attr("value",p_huohao);
        $('#get_sales_guige_time').attr("value",time);
        $.ajax({
            url:"view-get-sales-guige", 
            async: false,
            type: "POST",
            data:$("#form_sbi").serialize(),
            success: function(html){
                $("#layer_sales_product_guige_"+p_huohao+"_"+time).html(html);
                $("#layer_sales_product_guige_"+p_huohao+"_"+time).show();
            }
        });
    }
    else
    {
        $("#layer_sales_product_guige_"+p_huohao+"_"+time).hide();
    }
}
</script>
