<!-- dkdj 档口登记 -->
<?php 

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_bill.php");

function get_user_list()
{
    $boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
    $p=select("*","ydf_user",array("user_boss_m_bianhao=?",$boss_id));
    if ($p->errorCode()!="00000")
        print_r($p->errorInfo());
    while ($user=$p->fetch())
    {
        echo '<option value="'.$user["user_self_m_bianhao"].'">'.$user["user_name"].'</option>';
    }
}
function get_last_day_reserve_fund($dangkou_id,$bill_day)
{
    //debug($bill_day);
    $boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
    $fund=0; //上日预留
    $where=array("bill_boss_id=? and bill_dangkou_id=? and bill_type='jryl' and bill_day<?",$boss_id,$dangkou_id,$bill_day);
    $p=cselect("bill_fund","ydf_finance_bill",$where,"","bill_day desc",0,1);
    //debug($where);
    //debug($p);
    if ($p[1]>=1){
        $fund=$p[0]->fetch()["bill_fund"]; 
    }
    debug($fund);
    return $fund;
}
?>
<script type="text/javascript">    
function list_sdsy()
{
    //重置value
    $('#chuku_from_day').attr("value","");
    $('#chuku_to_day').attr("value","");
    /* $('#chuku_searchwords').attr("placeholder","请输入卖家昵称"); */
    /* $('#chuku_searchwords').css("color","#cccccc") */

    $("#pid_view_finance_reg_pure_sales_fund #pages_dkdj").set_page_num("view_finance_reg_pure_sales_fund","pages_dkdj",1);

    refresh_inner("view_finance_reg_pure_sales_fund?"+$("#form_dkdj").serialize() );
}

function search_sdsy()
{
    $("#btn_chukuorder_search").parent().prev().find(".listtypevalue").removeClass('listtypeselect');

    $("#pid_view_finance_reg_pure_sales_fund #pages_dkdj").set_page_num("view_finance_reg_pure_sales_fund","pages_dkdj",1);

    refresh_inner("view_finance_reg_pure_sales_fund?"+$("#form_dkdj").serialize() );
}

function search_dkdj()
{
    mobj=$("#pages_dkdj").find("#m");
    mobj.html(1);
    set_page_list_dkdj(mobj);
    refresh_inner("view_finance_reg_pure_sales_fund?"+$("#form_dkdj").serialize() );
}
function click_me_dkdj(obj,state)
{
    $('#verify_state_dkdj').attr('value',state);
    $(".list_button_dkdj").removeClass("listclassselect");
    $(".list_button_dkdj").addClass("listclassvalue");

    obj.removeClass("listclassvalue");
    obj.addClass("listclassselect");
    search_dkdj();
}

function delete_dkdj(dangkou_id,bill_day)
{
    if(confirm("确定要删除选中的信息吗？一旦删除将不能恢复！"))
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
                refresh_inner("view_finance_reg_pure_sales_fund?"+$("#form_dkdj").serialize() );
            }
        });    
    }
}

</script>
                <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block;">
                    <form id="form_dkdj">      
                    <div  style="float:left; width:100%; margin:10px 0; padding:5px; overflow:hidden; display:block">
                        <div style="float:right; overflow:hidden; display:block">
                            <span style="float:left; overflow:hidden; display:block">
                                <span style="padding:5px 0">日期 <input class="datepicker" type="text" name="from_day"  size="12" maxlength="50" readonly="readonly" style="padding:5px"> 至 <input type="text" class="datepicker" name="to_day"  size="12" maxlength="50" readonly="readonly" style="padding:5px">
                                </span>
                            </span>
                            <span id="btn_chukuorder_search" onclick="search('view_finance_reg_pure_sales_fund','form_dkdj')" class="btn_normal_blue public_search_sm">搜索</span>
                            <span class="clear_search" onclick="mount_to_frame('view_finance_reg_pure_sales_fund',1,'frame_finance_reg_pure_sales_fund')">清空<br>条件</span>
                        </div>
                    </div>
<!-- refresh_begin -->
                    <div id="pagelist" style="float:left; width:100%; overflow:hidden; display:block">
<?php

$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
$dangkou_id = empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"])?@$_REQUEST["dangkou_id"]:$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
#得到档口集合
$p=rselect("*","ydf_dangkou",array("dangkou_boss_m_bianhao=? and dangkou_type=1",$boss_id));
$in_dangkou=array();
while($row=$p->fetch())
    $in_dangkou[]=$row["dangkou_bianhao"];
$in_dangkou=join(",",$in_dangkou);

@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600-1:null;
$where=array("bill_boss_id=? and bill_dangkou_id=? and bill_add_time>946659661 and bill_add_time>=? and bill_add_time<=? and bill_dangkou_id in ($in_dangkou)",$boss_id,$dangkou_id,$from_day,$to_day);
$where=clean_where($where);
//print_r($where);

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;
$offset=($page-1)*$pagesize; 
//bill_source_id是否等于0可以区别账期客户和散客
$pres=cselect("bill_day, bill_user_id ,bill_dangkou_id,
    sum(CASE WHEN bill_type='mjys' AND bill_is_credit_seller=0 AND bill_is_credit=1 THEN bill_fund ELSE 0 END ) as skqk,
    sum(CASE WHEN bill_type='mjss' AND bill_is_credit_seller=0 AND bill_is_credit=0 THEN bill_fund ELSE 0 END ) as skfk_bak,
    sum(CASE WHEN bill_type='mjss' AND bill_is_credit_seller=0 AND bill_is_credit=1 THEN bill_fund ELSE 0 END ) as skhk_bak,
    sum(CASE WHEN bill_type='mjys' AND bill_is_credit_seller=1 THEN bill_fund ELSE 0 END ) as zqqk,
    sum(CASE WHEN bill_type='yhcr' AND bill_small_type='mjss' AND bill_is_credit_seller=0 AND bill_is_credit=1 THEN bill_fund ELSE 0 END ) as skhk,
    sum(CASE WHEN bill_type='yhcr' AND bill_small_type='mjss' AND bill_is_credit_seller=0 AND bill_is_credit=0 THEN bill_fund ELSE 0 END ) as skfk,
    sum(CASE WHEN bill_type='yhcr' AND bill_small_type='mjss' AND bill_is_credit_seller=1 THEN bill_fund ELSE 0 END ) as zqhk,
    sum(CASE WHEN bill_type='yhzc' AND bill_small_type='mjsf' THEN bill_fund ELSE 0 END ) as mjsf,
    sum(CASE WHEN bill_type='mjsf' THEN bill_fund ELSE 0 END ) as mjsf_bak,
    sum(if(bill_type='xssr',bill_fund,0)) as xssr,
    sum(if(bill_type='thzc',bill_fund,0)) as thzc, 
    sum(if(bill_type='xjcr',bill_fund,0)) as xjcr, 
    sum(if(bill_type='xscr',bill_fund,0)) as xscr, 
    sum(if(bill_type='jryl',bill_fund,0)) as jryl 
    ",
    //sksk:散客付款 skqk:散客欠款 skhk:散客还款 zqqk:账期客户欠款 zqhk:账期客户还款 xssr:销售收入 mjsf:实际退货支出 thzc:退货支出 xjcr:现金存入 xscr:线上存入 jryl:今日预留 
    //账期客户欠款统一在应收录入还款金额，而不是对单核销
    "ydf_finance_bill",$where,"bill_dangkou_id,bill_day","bill_day desc",$offset,$pagesize);
$p=$pres[0];
$page_count=ceil($pres[1]/$pagesize);  
if ($p->errorCode()!="00000"){
    print_r($p->errorInfo());
}

debug($pres);

while ($row_fund=$p->fetch(PDO::FETCH_ASSOC))
{
    $bill_desc="";
    $p1=rselect("bill_desc","ydf_finance_bill",array("bill_type='jryl' and bill_day=? and bill_dangkou_id=?",$row_fund["bill_day"],$row_fund["bill_dangkou_id"]));
    if($ro=$p1->fetch()){
        $bill_desc=$ro["bill_desc"];
    }
debug($ro);
    $sryl=get_last_day_reserve_fund($row_fund["bill_dangkou_id"],$row_fund["bill_day"]); //上日预留
    $jrsr=$row_fund["xssr"]+$row_fund["skhk"]+$row_fund["zqhk"]+$sryl; //今日收入            
    debug($row_fund["xssr"]."|".$row_fund["skhk"]."|".$row_fund["zqhk"]."|".$sryl);            
    $jrzc=$row_fund["mjsf"]+$row_fund["skqk"]+$row_fund["zqqk"]+$row_fund["jryl"]; //今日支出   
    debug($row_fund["mjsf"]."|".$row_fund["skqk"]."|".$row_fund["zqqk"]."|".$row_fund["jryl"]);   
    $jryc=$jrsr-$jrzc-$row_fund["xscr"];//今日应存
    debug($jrsr."-".$jrzc."-".$row_fund["xscr"]);
    $temp=rselect("*","ydf_dangkou",array("dangkou_bianhao=?",$row_fund["bill_dangkou_id"]));
    $dangkou_name=$temp->fetch()["dangkou_name"];
    
    $bank_fund="-";
    $alipay_fund="-";
    $dangkou_fund="-";
    $fund_diff="-";
    $temp_day=date("Y-m-d",$row_fund["bill_day"]);
    $arr_account_fund=get_dangkou_daily_fund_bill($row_fund["bill_dangkou_id"],$temp_day);
    if ($arr_account_fund["state"]=="ok")
    {
    debug($arr_account_fund);
        $bank_fund=$arr_account_fund["bank_fund"];
        //$alipay_fund=padd(array($arr_account_fund["alipay_fund"],$row_fund['zqhk']));
        $alipay_fund=$arr_account_fund["alipay_fund"];
        $dangkou_fund=$arr_account_fund["dangkou_fund"];
        $fund_diff=$row_fund["xjcr"]-$jryc;
    }

?>
                        <div style="width:99%; margin:0 auto 20px auto; background:#ffffff; border:1px solid #cccccc; overflow:hidden; display:block">
                            <div style="float:left; width:98%; padding:10px 1%; overflow:hidden; display:block">
                                <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
                                    <div style="float:left; padding:5px 0; font-size:12px"><span style="color:#999999">日期：</span><?php echo date("Y-m-d",$row_fund["bill_day"]) ?></div>
                                    <div style="float:left; margin-left:10px; padding:5px 0; font-size:12px"><span style="color:#999999">档口：</span><span style="color:#0099FF"><?php echo $dangkou_name?></span></div>    
                                    <div style="float:right; text-align:right">
                                        <span class="btn_order_red" onclick="/**/delete_dkdj('<?php echo $row_fund["bill_dangkou_id"] ?>','<?php echo date("Y-m-d",$row_fund["bill_day"]) ?>')">删除记账</span>
                                    </div>
                                    <div style="float:right; text-align:right">
                                        <span class="btn_order_red" onclick="/**/ShowSetAccountFund('<?php echo $row_fund["bill_dangkou_id"] ?>','<?php echo date("Y-m-d",$row_fund["bill_day"]) ?>','<?php echo $row_fund['zqhk'] ?>')">资金记账</span>
                                    </div>
                                </div>
                                <div class="warehouse_table text_center">
                                    <div style="width:11%;">银行存入</div>
                                    <div style="width:11%;">+ 支付宝收入</div>
                                    <div style="width:11%;">+ 今日预留</div>
                                    <div style="width:11%;">+ 退货支出</div>
                                    <div style="width:11%;">- 现结卖家付款</div>
                                    <div style="width:11%;">- 现结卖家还款</div>
                                    <div style="width:11%;">- 账期卖家还款</div>
                                    <div style="width:11%;">- 昨日预留</div>
                                    <div style="width:12%;">= 错差资金</div>
                                </div>
                                <div class="warehouse_list finance_td text_center">
                                    <div style="width:11%;"><?php echo $bank_fund ?></div>
                                    <div style="width:11%;"><?php echo $alipay_fund ?></div>
                                    <div style="width:11%;"><?php echo $dangkou_fund ?></div>
                                    <div style="width:11%;"><?php echo $row_fund['mjsf']?></div>
                                    <div style="width:11%;"><?php echo $row_fund["skfk"]?></div>
                                    <div style="width:11%;"><?php echo $row_fund["skhk"]?></div>
                                    <div style="width:11%;"><?php echo $row_fund['zqhk']?></div>
                                    <div style="width:11%;"><?php echo $sryl?></div>
                                    <div  style="width:12%;"><?php echo $fund_diff ?>
                                    <?php
                                        if($fund_diff!="-"){
                                    ?>
                                         <span class="btn_editor_icon"  onclick="/**/record_wrong_reason('<?php echo $row_fund["bill_dangkou_id"] ?>','<?php echo $row_fund["bill_day"] ?>');"></span>
                                    <?php
                                        }
                                    ?>
                                    </div>

                                    <?php
                                        if($fund_diff!="-"){
                                    ?>
                                    <div style="float:right;margin-top:10px;color:#999999;text-align:left;"><?php if($bill_desc==""){echo "暂无备注";}else{echo $bill_desc;} ?></div>
                                    <span style="float:right;margin-top:10px;color:#999999;">错差备注：</span>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
<?php
}
?>
                    
                    
                    </div>
                    <div class="record"> 共 <span class="record_num"><?php echo $pres[1]?></span> 条记录</div>

<script>/*n*//*n*/
$("#pid_view_finance_reg_pure_sales_fund #pages_dkdj").set_page_count("view_finance_reg_pure_sales_fund","pages_dkdj",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
                  <div class="ipages" id="pages_dkdj" page="view_finance_reg_pure_sales_fund" form="form_dkdj" count="<?php echo $page_count; ?>"/>

                    </form> <!-- 页码也作为表单项统一处理  -->
                </div>
                
                <div id="layer_storefinance_fundadd" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
        
                </div>
                    <div id="layer_dangkou_money_record" style="display:none;">
                        <textarea class="wrong_reason" rows="10" cols="30" name="wrong_reason" placeholder="请记录错差原因" style="margin:10% 0 0 15%;width:65%;padding:5px 5px;"></textarea>
                        <span id="sure_money_record" class="btn_order_red" style="display:block;width:18%;height:6%;line-height:14px;margin:10px auto;">确认记录</span>
                    </div>

<script type="text/javascript">
function record_wrong_reason(dangkou_id,bill_day)
{//档口记账资金错差原因
    index_layer_dangkou_money_record=layer.open({
    type: 1,
    area: ['420px', '300px'],
    title: false,
    content:$('#layer_dangkou_money_record')
    });
    $("#sure_money_record").unbind("click").click(function(){
        layer.close(index_layer_dangkou_money_record);
        var wrong_reason=$(this).prev(".wrong_reason").val();
        //debugger;
        $.ajax({
            url:"api-dangkou-note",
            async: false,
            type: "POST",
            dataType:"json",
            data:{wrong_reason:wrong_reason,dangkou_id:dangkou_id,bill_day:bill_day},
            success: function(html){
            refresh_inner("view_finance_reg_pure_sales_fund");
            }
        });
        $(this).prev(".wrong_reason").val("");
    });
}
function ShowSetAccountFund(dangkou_id, bill_date, cycle_seller_pay_fund)
{
    var record_exist=true;
    $.ajax({
        url:"model-bill-select", 
        async: false,
        type: "POST",
        dataType:"json",
        data:{func:"is_daily_fund_exist",dangkou_id:dangkou_id,bill_day:bill_date},
        error:function(){
            layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
        },
        success: function(html){
            if (html.state!="ok")
            {
                layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
                record_exist=false;
                return;
            }
            
            if (html.resp==1)
            {
                layer.msg("日记账已经存在！", {time: 2000, icon:2});
                record_exist=false;
                return;
            }
        }
    }); 
    
    if (record_exist==true)
    {
        $.ajax({
            url:"view-finance-reg-pure-sales-fund-2", 
            async: false,
            type: "POST",
            data:{dangkou_id:dangkou_id, bill_day:bill_date, cycle_seller_pay_fund:cycle_seller_pay_fund},
            success: function(html){
                $("#layer_storefinance_fundadd").html(html);
            }
        });
        
        index_layer_storefinance_fundadd=layer.open({
            type: 1,
            area: ['420px', '400px'],
            title: false,
            content:$('#layer_storefinance_fundadd')
        });
    }
}

</script>
