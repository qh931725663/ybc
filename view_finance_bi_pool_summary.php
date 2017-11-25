<!-- txhz 提现资金汇总 --> 
<?php 
include_once "{$root_path}/model/model_bi.php";
?>
<script type="text/javascript">    
function click_me_bi_txhz(obj,state)
{
    $('#verify_state_bi_txhz').attr('value',state);
    obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");
    search_bi_txhz();
}


function search_bi_txhz()
{
    $("#pid_view_finance_bi_pool_summary #pages_bi_txhz").set_page_num("view_finance_bi_pool_summary","pages_bi_txhz",1);
    refresh_inner("view_finance_bi_pool_summary?"+$("#form_bi_txhz").serialize() );
}

function clean_search_bi_pool_summary()
{
    mount_to_frame('view_finance_bi_pool_summary',1,'frame_finance_bi_pool_summary');
}
</script>
                    <form id="form_bi_txhz">
                    <div class="search_box">
                        <div class="search_box_inner">
                            <div class="txhz_a">
                                <input  type="hidden" name="bi_time" id="verify_state_bi_txhz" value=""/>            
                                <span class="listtypevalue listtypeselect" onclick='/**/click_me_bi_txhz($(this),"day");'>日报</span>
                                <span class="listtypevalue" onclick='/**/click_me_bi_txhz($(this),"week");'>周报</span>
                                <span class="listtypevalue" onclick='/**/click_me_bi_txhz($(this),"month");'>月报</span>
                                <span class="listtypevalue" onclick='/**/click_me_bi_txhz($(this),"year");'>年报</span>
                            </div>
                            <div class="txhz_b">
                                <span class="lf">
                                    <select  name="bill_factory_id">
                                            <option value="">选择工厂</option>    
                                            <?php get_factory_option(); ?>
                                    </select>
                                </span>
                                <span onclick="/**/search_bi_txhz()" class="btn_normal_blue public_search_sm">搜索</span>
                                <span onclick="/**/clean_search_bi_pool_summary()" class="clear_search">清空<br>条件</span>
                            </div>
                        </div>
                    </div>     

<!-- refresh_begin -->
                    <div class="report_table_header" style="margin-top:0px; background:#f2f2f2">
                        <div style="width:10%">日期</div>
                        <div style="width:10%">工厂</div>
                        <div style="width:10%">上期结余资产</div>
                        <div style="width:8%">+ 本期进货</div>
                        <div style="width:8%">- 本期返厂</div>
                        <div style="width:8%">- 本期提现</div>
                        <div style="width:11%">= 本期结余资产=</div>
                        <div style="width:10%">本期结余库存</div>
                        <div style="width:10%">+ 本期交易中</div>
                        <div style="width:10%">+ 本期结余可提现</div>
                        <div style="width:5%">+ 错差</div>
                    </div>
                    <div id="pagelist">
<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
$ymd=empty($_REQUEST["bi_time"])?"day":$_REQUEST["bi_time"];

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize; 

//$funcs=array();
//$funcs[]=array("func"=>"get_history_agent_pools","ymd"=>$ymd,"bill_factory_id"=>@$_REQUEST["bill_factory_id"]);
//$funcs[]=array("func"=>"get_history_return_pools","ymd"=>$ymd,"bill_factory_id"=>@$_REQUEST["bill_factory_id"]);
//$funcs[]=array("func"=>"get_history_factory_agent_ys","ymd"=>$ymd,"bill_factory_id"=>@$_REQUEST["bill_factory_id"]);
//$funcs[]=array("func"=>"get_history_road_stock","ymd"=>$ymd,"bill_factory_id"=>@$_REQUEST["bill_factory_id"]);
//$rdata=mget($funcs);
////list($historys2,$historys2_idx)=$rdata["get_history_agent_pools"];
////list($historys_return,$historys_return_idx)=$rdata["get_history_return_pools"];
////list($historys_fys,$historys_fys_idx)=$rdata["get_history_factory_agent_ys"];
////list($historys_road,$historys_road_idx)=$rdata["get_history_road_stock"];
//list($historys2,$historys2_idx)=$rdata[0];
//list($historys_return,$historys_return_idx)=$rdata[1];
//list($historys_fys,$historys_fys_idx)=$rdata[2];
//list($historys_road,$historys_road_idx)=$rdata[3];


$t = microtime(true);  
$historys2=array();
$historys2_idx=array();
get_history_agent_pools($ymd,@$_REQUEST["bill_factory_id"],$historys2,$historys2_idx);

$historys_return=array();
$historys_return_idx=array();
get_history_return_pools($ymd,@$_REQUEST["bill_factory_id"],1,$historys_return,$historys_return_idx);

$historys_fys=array();
$historys_fys_idx=array();
get_history_factory_agent_ys($ymd,@$_REQUEST["bill_factory_id"],$historys_fys,$historys_fys_idx);

$historys_road=array();
$historys_road_idx=array();
get_history_road_stock($ymd,@$_REQUEST["bill_factory_id"],1,$historys_road,$historys_road_idx);
$e = microtime(true);  
//echo "db循环：".($e-$t)."\n"; 

//$group=array("bill_{$ymd}","bill_factory_id");
//$types=array('sjcb','jhcb','rkcb','pypk', 'xscb','qccb','ckcb', 'tfcb','sqyf','gczc');
//$where=array(
//    //"bill_boss_id=? and bill_type in ('". join("','",$types) ."') and bill_factory_id=? and bill_mode=1 and bill_is_close!=1",
//    "bill_boss_id=? and bill_factory_id=? and bill_mode=1 and bill_is_close!=1",
//    $boss_id,@$_REQUEST["bill_factory_id"]
//);
//function pool_stock($row){
//    return $row["sjcb"]+$row["jhcb"]+$row["rkcb"]+$row["pypk"]-$row["xscb"]-$row["qccb"]-$row["ckcb"];//退返成本不计库存
//}
//$sums=array();
//foreach($types as $type)
//    $sums[]="sum(CASE WHEN bill_type='{$type}' THEN bill_fund ELSE 0 END ) as {$type}";
//$historys=bi_select($sums,"ydf_finance_bill",$where,$group,"pool_stock");

$group=array("bill_factory_id");
list($historys,$addup)=get_history_stock_fund($ymd,$group,null,@$_REQUEST["bill_factory_id"],1);
//$sorts=sort_rows($historys,$group);
$rowcount=count($historys);$page_count=ceil($rowcount/$pagesize);  
for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
{
    $llog=new llog();
    $idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
    //$nfund=$historys[$sorts[$idx][0] ];
    $nfund=$historys[$idx];
    $factory_name="";$factory_mobile="";
    $p_f=rselect("*","ydf_factory",array("factory_boss_m_bianhao=? and factory_bianhao=?",$boss_id,$nfund["bill_factory_id"] ));
    if ($row_f=$p_f->fetch())
    {
        $factory_name=$row_f["factory_name"];
        $factory_mobile=$row_f["factory_mobile"];
    }
    $freeze_pool=get_freeze_fund_and_his_gen_history($nfund["bill_factory_id"],$nfund["bill_{$ymd}"],$ymd);
    $temp_s=get_stream_freeze_fund($nfund["bill_factory_id"],$nfund["bill_{$ymd}"],$ymd);
    debug(count($temp_s));
    $bidx=@$historys2_idx[$nfund["bill_{$ymd}"]][$nfund["bill_factory_id"]];
    $surplus_cash=@$historys2[$bidx]["sum"]["pool"];

    $bidx=@$historys_return_idx[$nfund["bill_{$ymd}"]][$nfund["bill_factory_id"]];
    $return_pool=@$historys_return[$bidx]["sum"]["pool"];

    $bidx=@$historys_fys_idx[$nfund["bill_{$ymd}"]][$nfund["bill_factory_id"]];
    $fys_pool=@$historys_fys[$bidx]["sum"]["pool"];

    $bidx=@$historys_road_idx[$nfund["bill_{$ymd}"]][$nfund["bill_factory_id"]];
    $road_pool=@$historys_road[$bidx]["sum"]["pool"];

    $gcsq=$nfund["sqyf"];

    //得到初始化欠款
    $init_debt=get_factory_agent_init_debt($nfund["bill_factory_id"]);
    //得到本期结余资产
    $debt=$nfund["sum"]["gczc"]+$nfund["sum"]["jhcb"]-$nfund["sum"]["tfcb"]-$nfund["sum"]["qccb"]-$nfund["sum"]["sqyf"];

    //得到上期结余资产
    $last_addup=@$historys[$nfund["last"]];
    $last_debt=$init_debt+$last_addup["sum"]["gczc"]+$last_addup["sum"]["jhcb"]-$last_addup["sum"]["tfcb"]-$last_addup["sum"]["qccb"]-$last_addup["sum"]["sqyf"];

    $jhcb=$nfund["jhcb"];
    $qccb_tfcb=$nfund["tfcb"]+$nfund["qccb"];
    $stock_fund=$nfund["sum"]["pool"];

    $total_stock_fund=$stock_fund+$return_pool+$road_pool;
    $total_freeze_fund=$freeze_pool["freeze_fund"]+$fys_pool;
    $diff_fund=padd(array($debt),array($total_stock_fund,$total_freeze_fund,$surplus_cash));
?>
                    <div class="report_table_body" style="border-bottom:1px dashed #cccccc">
                        <div style="width:10%"><?php echo show_report_date($ymd,$nfund["bill_{$ymd}"])?></div>
                        <div style="width:10%"><?php echo echo2($factory_name) ?></div>
                        <div style="width:10%"><?php echo echo2($last_debt) ?></div>
                        <div style="width:8%"><?php echo echo2($jhcb) ?></div>
                        <div style="width:8%"><?php echo echo2($qccb_tfcb) ?></div>
                        <div style="width:8%"><?php echo echo2($gcsq) ?></div>
                        <div style="width:11%; padding:6px 0">
                            <?php echo "$debt" ?>
                            <span class="btn_editor_icon" onclick="/**/ShowModifyFactoryFundLayer('<?php echo $nfund["bill_factory_id"]?>','<?php echo $nfund["bill_{$ymd}"]?>','<?php echo "$debt"?>','<?php echo $total_stock_fund ?>','<?php echo $total_freeze_fund ?>','<?php echo echo2($surplus_cash)?>','modify_asset')" />
                            <span style="float:left; width:100%; margin-top:5px; color:#999999; text-align:center">
                                <?php if (floatval($nfund['gczc'])!=0){echo "本期修正:{$nfund['gczc']}";} ?>
                            </span>
                        </div>
                        <div style="width:10%;overflow:hidden; display:block">
                            <span style="float:left; width:100%; text-align:center"><?php echo $total_stock_fund ?></span>
                            <span style="float:left; width:100%; margin-top:5px; color:#999999; text-align:center"><?php echo "未处理退货:$return_pool<br/>在途:$road_pool"?></span>
                        </div>
                        <div style="width:10%; padding:6px 0">
                            <span style="float:left; width:100%; text-align:center">
                                <?php echo $total_freeze_fund ?>
                                <span class="btn_editor_icon" onclick="/**/ShowModifyFactoryFundLayer('<?php echo $nfund["bill_factory_id"]?>','<?php echo $nfund["bill_{$ymd}"]?>','<?php echo "$debt"?>','<?php echo $total_stock_fund ?>','<?php echo $total_freeze_fund ?>','<?php echo echo2($surplus_cash)?>','modify_freeze')" />
                            </span>
                            <span style="float:left; width:100%; margin-top:5px; color:#999999; text-align:center"><?php echo "卖家欠款:$fys_pool"?></span>
                        </div>
                        <div style="width:10%; padding:6px 0"><?php echo echo2($surplus_cash) ?><span class="btn_editor_icon" onclick="/**/ShowModifyFactoryFundLayer('<?php echo $nfund["bill_factory_id"]?>','<?php echo $nfund["bill_{$ymd}"]?>','<?php echo "$debt"?>','<?php echo echo2($stock_fund)+$return_pool+$road_pool ?>','<?php echo $freeze_pool["freeze_fund"]+$fys_pool ?>','<?php echo echo2($surplus_cash)?>','modify_active')" /></div>
                        <div style="width:5%;color:#ee583d;"><?php echo $diff_fund ?></div>
                     </div>
<?php
}
?>
                    
                    </div>
                    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>

<script>/*n*/    
$("#pid_view_finance_bi_pool_summary #pages_bi_txhz").set_page_count("view_finance_bi_pool_summary","pages_bi_txhz",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
                    <div class="ipages" id="pages_bi_txhz" page="view_finance_bi_pool_summary" form="form_bi_txhz" count="<?php echo $page_count; ?>"/>
                    </form> <!-- 页码也作为表单项统一处理  -->
                
                                        <div id="layer_modifyfund">
                                        
                                        </div>
                
<script type="text/javascript">
function ShowModifyFactoryFundLayer(factory_id, bill_time, fund_asset, fund_stock, fund_freeze, fund_active,opt){
    $.ajax({
        url:"view-get-modifyfactoryfund", 
        async: false,
        type: "POST",
        data:{var_factory_id:factory_id,var_bill_time:bill_time,var_fund_asset:fund_asset,var_fund_stock:fund_stock,var_fund_freeze:fund_freeze,var_fund_active:fund_active,var_opt:opt},
        success: function(html){
            $("#layer_modifyfund").html(html);
        }
    });    
    
    index_layer_modifyfund=layer.open({
        type: 1,
        area: ['420px', '370px'],
        title: false,
        content:$('#layer_modifyfund')
    });
}

function PostModifyFactoryFund(){
    if($("#modifyfactoryfund_opt_type").val()=="modify_asset" && !$("#modifyfactoryfund_fund_asset").val())
    {
        $("#modifyfactoryfund_tip_notice").html("<span style='font-size:14px; color:red'>亲，本期结余资产不能为空哦！</span>");
        return false;
    }
    
    if($("#modifyfactoryfund_opt_type").val()!="modify_asset" && !$("#modifyfactoryfund_fund_freeze").val())
    {
        $("#modifyfactoryfund_tip_notice").html("<span style='font-size:14px; color:red'>亲，本期交易中资金不能为空哦！</span>");
        return false;
    }
    
    if($("#modifyfactoryfund_opt_type").val()!="modify_asset" && !$("#modifyfactoryfund_fund_active").val())
    {
        $("#modifyfactoryfund_tip_notice").html("<span style='font-size:14px; color:red'>亲，本期结余可提现资金不能为空哦！</span>");
        return false;
    }
        
    $.ajax({
        url:"model-post-modifyfactoryfund", 
        async: false,
        type: "POST",
        data:$('#modifyfactoryfundform').serialize(),
        dataType:"json",
        success: function(html){
            if (html["state"]=="ok")
            {
                layer.close(index_layer_modifyfund);
                layer.msg("工厂资金修改成功！", {time: 2000, icon:1});
                setTimeout(function(){
                    refresh_inner("view_finance_bi_pool_summary?"+$("#form_bi_txhz").serialize() );
                },2000);
            }
            else
            {
                $("#modifyfactoryfund_tip_notice").html("<span style='font-size:14px; color:red'>"+html["desc"]+"</span>");
            }
        }
    });    
}

</script>
