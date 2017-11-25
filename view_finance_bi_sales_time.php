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

function search_xsrfx()
{
    $("#pid_view_finance_bi_sales_time #pages_xsrfx").set_page_num("view_finance_bi_sales_time","pages_xsrfx",1);
    refresh_inner("view_finance_bi_sales_time?"+$("#form_xsrfx").serialize() );
}
function clean_search_bi_sales_time()
{
    mount_to_frame('view_finance_bi_sales_time',1,'frame_finance_bi_sales_time');
}
</script>
                    <form id="form_xsrfx">        
                    <div class="search_box">
                        <div  class="search_box_inner">
                            <div class="xsrfx_a ismall_nav" names="bi_time" page="view_finance_bi_sales_time">
                                <span class="listtypevalue listtypeselect" values="bi_time:bill_day" >日报</span>
                                <span class="listtypevalue" values="bi_time:bill_month">月报</span>
                                <span class="listtypevalue" values="bi_time:bill_year">年报</span>
                            </div>
                            <div class="xsrfx_b">
                                <span>
                                    <select  name="dangkou_id">
                                        <option value="">选择档口</option>    
                                        <?php get_dangkou_option(1); ?>
                                    </select>
                                </span>
                                <span onclick="/**/search_xsrfx()" class="btn_normal_blue public_search_sm">搜索</span>
                                <span class="clear_search" onclick="mount_to_frame('view_finance_bi_sales_time',1,'frame_finance_bi_sales_time')">清空<br>条件</span>
                            </div>
                        </div>                        
                    </div>

<!-- refresh_begin -->

                    <div id="pagelist">
                        <div class="report_table_header" style="margin-top:0px; background:#f2f2f2">
                            <div style="width:15%; color:#999999">日期</div>
                            <div style="width:15%; color:#999999">档口</div>
                            <div style="width:10%; color:#999999">销售额</div>
                            <div style="width:10%; color:#999999">利润</div>
                            <div style="width:10%; color:#999999">退货支出</div>
                            <div style="width:20%; color:#999999">欠款</div>
                            <div style="width:20%; color:#999999">还款</div>
                        </div>

<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
$dangkou_id = empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"])?@$_REQUEST["dangkou_id"]:$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];

#得到档口集合
$p=rselect("*","ydf_dangkou",array("dangkou_boss_m_bianhao=? and dangkou_type=1",$boss_id));
$in_dangkou=array();
while($row=$p->fetch())
    $in_dangkou[]=$row["dangkou_bianhao"];
$in_dangkou=join(",",$in_dangkou);

$time_fields = array("bill_day"=>"bill_day","bill_year"=>"bill_year","bill_month"=>"bill_month"); 
if (empty($_REQUEST["bi_time"])){
    $time_field="bill_day";
}else {
    if (empty($time_fields[$_REQUEST["bi_time"]]))
        throw new PDOException("bill_time_field_invalid");
    $time_field=$time_fields[$_REQUEST["bi_time"]];
}
$time_format=$time_field=="bill_year"?"Y":"";
$time_format=$time_field=="bill_month"?"Y-m":$time_format;
$time_format=$time_field=="bill_day"?"Y-m-d":$time_format;
$last_time="";$color="background:#FFF5EE;";

$where=array("bill_boss_id=? and bill_dangkou_id=? and bill_dangkou_id in ($in_dangkou)",
    $boss_id,$dangkou_id);
$where=clean_where($where);
//print_r($where);

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;
$offset=($page-1)*$pagesize; 
//bill_source_id是否等于0可以区别账期客户和散客
$pres=cselect("{$time_field} as bi_time,bill_dangkou_id,
    sum(if(bill_type='xssr',bill_fund,0)) as xssr,
    sum(if(bill_type='thzc',bill_fund,0)) as thzc, 
    sum(CASE WHEN bill_type='xslr' THEN bill_fund WHEN bill_type='thtl' THEN -1*bill_fund ELSE 0 END  ) as dklr,
    sum(CASE WHEN bill_type='mjys' AND bill_is_credit_seller=0 AND bill_is_credit=1 THEN bill_fund ELSE 0 END ) as skqk,
    sum(CASE WHEN bill_type='mjss' AND bill_is_credit_seller=0 AND bill_is_credit=1 THEN bill_fund ELSE 0 END ) as skhk,
    sum(CASE WHEN bill_type='mjys' AND bill_is_credit_seller=1 THEN bill_fund ELSE 0 END ) as zqqk,
    sum(CASE WHEN bill_type='mjss' AND bill_is_credit_seller=1 THEN bill_fund ELSE 0 END ) as zqhk,
    sum(if(bill_type='xjcr',bill_fund,0)) as xjcr, 
    sum(if(bill_type='xscr',bill_fund,0)) as xscr, 
    sum(if(bill_type='jryl',bill_fund,0)) as jryl 
    ",
    //skqk:散客欠款 skhk:散客还款 zqqk:账期客户欠款 zqhk:账期客户还款 xssr:销售收入 thzc:退货支出 dklr:档口利润  xjcr:现金存入 xscr:线上存入 jryl:今日预留 
    //账期客户欠款统一在应收录入还款金额，而不是对单核销
    "ydf_finance_bill",$where,"bill_dangkou_id,{$time_field}","{$time_field} desc",$offset,$pagesize);
$p=$pres[0];
$page_count=ceil($pres[1]/$pagesize);  
if ($p->errorCode()!="00000"){
    print_r($p->errorInfo());
}


while ($row_fund=$p->fetch(PDO::FETCH_ASSOC))
{
    $temp=cselect("*","ydf_dangkou",array("dangkou_bianhao=?",$row_fund["bill_dangkou_id"]));
    $dangkou_name=$temp[0]->fetch()["dangkou_name"];

    if ($row_fund["bi_time"]!=$last_time)
    {
        $last_time=$row_fund["bi_time"];
        if ($color=="")
            $color="background:#FFF5EE;";
        else
            $color="";
    }
?>
<div style="<?php echo $color?>; border-bottom:1px dashed #cccccc" class="report_table_body">
                            <div style="height:35px; width:15%"><?php if($row_fund["bi_time"]>1){ echo date($time_format,$row_fund["bi_time"]);}else{echo "初始化";} ?></div>
                            <div style="height:35px; width:15%"><?php echo $dangkou_name?></div>
                            <div style="height:35px; width:10%"><?php echo $row_fund["xssr"] ?></div>
                            <div style="height:35px; width:10%"><?php echo $row_fund["dklr"] ?></div>
                            <div style="height:35px; width:10%"><?php echo $row_fund["thzc"] ?></div>
                            <div style="height:35px; width:20%"><?php echo "账期:{$row_fund['zqqk']};散客:{$row_fund['skqk']}" ?></div>
                            <div style="height:35px; width:20%"><?php echo "账期:{$row_fund['zqhk']};散客:{$row_fund['skhk']}" ?></div>
                        </div>
<?php
}
?>
                    
                    
                    </div>
                    <div class="record"> 共 <span class="record_num"><?php echo $pres[1]?></span> 条记录</div>

<script>/*n*/    
    $("#pid_view_finance_bi_sales_time #pages_xsrfx").set_page_count("view_finance_bi_sales_time","pages_xsrfx",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
    <div class="ipages" id="pages_xsrfx" page="view_finance_bi_sales_time" form="form_xsrfx" count="<?php echo $page_count; ?>"/>
                    </form> <!-- 页码也作为表单项统一处理  -->
