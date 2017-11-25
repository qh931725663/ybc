<?php
function get_last_day_reserve_fund($dangkou_id,$bill_day)
{
    $boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
    $fund=0; //上日预留
    $p=cselect("bill_fund","ydf_finance_bill",array("bill_boss_id=? and bill_dangkou_id=? and bill_type='jryl' and bill_day<?",$boss_id,$dangkou_id,$bill_day),"","bill_day desc",0,1);
    if ($p[1]==1){
        $fund=$p[0]->fetch()["bill_fund"];
    }
    return $fund;
}
?>
<script type="text/javascript">
function list_xsfx()
{
    //重置value
    $('#chuku_from_day').attr("value","");
    $('#chuku_to_day').attr("value","");
    /* $('#chuku_searchwords').attr("placeholder","请输入卖家昵称"); */
    /* $('#chuku_searchwords').css("color","#cccccc") */

    $("#pid_view_sales_bi_seller_time #pages_xsfx").set_page_num("view_sales_bi_seller_time","pages_xsfx",1);

    refresh_inner("view_sales_bi_seller_time?"+$("#form_xsfx").serialize() );
}
function search_xsfx()
{
    $("#pid_view_sales_bi_seller_time #pages_xsfx").set_page_num("view_sales_bi_seller_time","pages_xsfx",1);

    refresh_inner("view_sales_bi_seller_time?"+$("#form_xsfx").serialize() );

}

function click_me_xsfx(obj,state)
{
    $('#verify_state_xsfx').attr('value',state);

    obj.removeClass("listclassvalue");
    obj.addClass("listclassselect");
    search_xsfx();
}

function delete_xsfx(dangkou_id,bill_day)
{
    $.ajax({
        url:"model-bill-delete",
        async: false,
        type: "POST",
        dataType:"json",
        data:{func:"delete_daily_fund",dangkou_id:dangkou_id,bill_day:bill_day},
        error:function(){
            layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
        },
        success: function(html){
            if (html.state!="ok")
            {
                layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
                return;
            }
            refresh_inner("view_finance_bi_sales_time?"+$("#form_xsfx").serialize() );
        }
    });

}
function submit_xsfx(obj){
    var dangkou_id = obj.parent().find("#dangkou_for_add").attr("value") ;
    var bill_day = obj.parent().find("#day_for_add").attr("value") ;

    $.ajax({
        url:"model-bill-select",
        async: false,
        type: "POST",
        dataType:"json",
        data:{func:"is_daily_fund_exist",dangkou_id:dangkou_id,bill_day:bill_day},
        error:function(){
            layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
        },
        success: function(html){
            if (html.state!="ok")
            {
                layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
                return;
            }
            if (html.resp==1)
            {
                layer.msg("日记账已经存在！", {time: 2000, icon:2});
                return;
            }
            mount_to_frame('view_finance_bi_sales_time_2?dangkou_id='+dangkou_id+'&bill_day='+bill_day,1,'frame_finance_bi_sales_time',1);
        }
    });
}

</script>
                    <form id="form_xsfx">        

                    <div class="search_box">
                        <div class="search_box_inner" >
                            <div class="xsfx_a ismall_nav" names="bi_time" page="view_sales_bi_seller_time">
                                <span class="listtypevalue listtypeselect" values="bi_time:day">日报</span>
                                <span class="listtypevalue" values="bi_time:month">月报</span>
                                <span class="listtypevalue" values="bi_time:year">年报</span>
                            </div>
                            <div class="xsfx_b">
                                <span class="sp_a" style="display:none;">
                                    <span>日期 <input type="text" class="datepicker" name="from_day"  size="12" maxlength="50" readonly="readonly" style="padding:5px"> 至 <input type="text" class="datepicker" name="to_day"  size="12" maxlength="50" readonly="readonly">
                                    </span>
                                </span>
                                <span class="sp_b">
                                    <span class="lf"><input id="search_sales_bi_huohao" name="seller_id" type="text" placeholder="请输入卖家拼音首字母" class="iinput name_iime ino_ime_input iseller_name" style="width:168px;"/></span>
                                    <span onclick="search('view_sales_bi_seller_time','form_xsfx')" class="btn_normal_blue public_search" style="margin-right:8px;">搜索</span>
                                    <span class="clear_search" onclick="mount_to_frame('view_sales_bi_seller_time',1,'frame_sales_bi_seller_time')">清空<br>条件</span>
                                </span>

                            </div>
                        </div>                        
                    </div>
                    <div class="report_table_header" style="margin:0 auto; background:#f2f2f2">
                        <div style="font-size:12px; width:11%; color:#999999">时间</div>
                        <div style="font-size:12px; width:11%; color:#999999">卖家</div>
                        <div style="font-size:12px; width:11%; color:#999999">上期结余欠款</div>
                        <div style="font-size:12px; width:11%; color:#999999">+ 本期拿货</div>
                        <div style="font-size:12px; width:11%; color:#999999">- 本期收款</div>
                        <div style="font-size:12px; width:11%; color:#999999">- 本期退货</div>
                        <div style="font-size:12px; width:11%; color:#999999">+ 本期退款</div>
                        <div style="font-size:12px; width:11%; color:#999999">= 结余欠款</div>
                        <div style="font-size:12px; width:11%; color:#999999">当期退货率</div>
                    </div>

<!-- refresh_begin -->
<?php
include_once "{$root_path}/model/model_bi.php";
$ymd=empty($_REQUEST["bi_time"])?"day":$_REQUEST["bi_time"];
@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600-1:null;
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize;


if(@$_REQUEST["seller_id"]=="匿名卖家"){
    $seller_bianhao=1;
}else{
    $p_seller=rselect("seller_bianhao","ydf_seller",array("seller_name=? and seller_boss_m_bianhao=?",@$_REQUEST["seller_id"],$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]));
    if ($r_seller=$p_seller->fetch())
        $seller_bianhao=$r_seller["seller_bianhao"];
}

list($historys,$addup)=get_history_sellers($ymd,@$seller_bianhao);
debug($historys);
$rowcount=count($historys);$page_count=ceil($rowcount/$pagesize);
for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
    //$row=$historys[$sorts[$idx][0] ];
    $row=$historys[$idx];
    $p=rselect("*","ydf_seller",array("seller_bianhao=?",$row['bill_seller_id']));
    $name="";
    if ($ro=$p->fetch())
         {
             $name=$ro["seller_name"];
         }
    $last_idx=$row["last"];
    $last_pool=0;
    if ($last_idx>=0){
        $row_last=$historys[$last_idx];
        $last_pool=$row_last["sum"]["pool"];
    }
    $tuihuolv=$row["mjys"]<=0?0:$row["mjyf"]/$row["mjys"];
?>

                        <div class="report_table_body" style="margin:0 auto; border-bottom:1px dashed #cccccc">
                            <div style="width:11%; font-size:12px;"><?php echo show_report_date($ymd,$row["bill_{$ymd}"])?></div>
                            <div style="width:11%; font-size:12px;"><?php if($name==""){echo "匿名卖家";}else{ echo $name;}?></div>
                            <div style="width:11%; font-size:12px;"><?php echo $last_pool?></div>
                            <div style="width:11%; font-size:12px;"><?php echo $row["mjys"]?></span></div>
                            <div style="width:11%; font-size:12px;"><?php echo $row["mjss"]?></span></div>
                            <div style="width:11%; font-size:12px;"><?php echo $row["mjyf"]?></span></div>
                            <div style="width:11%; font-size:12px;"><?php echo $row["mjsf"]?></span></div>
                            <div style="width:11%; font-size:12px;"><?php echo $row["sum"]["pool"]?></span></div>
                            <div style="width:11%; font-size:12px;"><?php echo round($tuihuolv ,2)?></div>
                        </div>
<?php
}
?>
                    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>

<script>/*n*/    
    $("#pid_view_sales_bi_seller_time #pages_xsfx").set_page_count("view_sales_bi_seller_time","pages_xsfx",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
    <div class="ipages" id="pages_xsfx" page="view_sales_bi_seller_time" form="form_xsfx" count="<?php echo $page_count; ?>"></div>
</form> <!-- 页码也作为表单项统一处理  -->
