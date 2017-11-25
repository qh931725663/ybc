<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_bill.php");
?>
<script type="text/javascript">    
function list_sdsy()
{
    //重置value
    $('#chuku_from_day').attr("value","");
    $('#chuku_to_day').attr("value","");
    /* $('#chuku_searchwords').attr("placeholder","请输入卖家昵称"); */
    /* $('#chuku_searchwords').css("color","#cccccc") */

    $("#pid_view_finance_reg_repayment #pages_771").set_page_num("view_finance_reg_repayment","pages_771",1);

    refresh_inner("view_finance_reg_repayment?"+$("#form_mjhk").serialize() );
}

function search_sdsy()
{
    $("#btn_chukuorder_search").parent().prev().find(".listtypevalue").removeClass('listtypeselect');

    $("#pid_view_finance_reg_repayment #pages_771").set_page_num("view_finance_reg_repayment","pages_771",1);

    refresh_inner("view_finance_reg_repayment?"+$("#form_mjhk").serialize() );
}

function search_mjhk()
{
    mobj=$("#pages_mjhk").find("#m");
    mobj.html(1);
    set_page_list_mjhk(mobj);
    refresh_inner("view_finance_reg_pure_sales_fund?"+$("#form_mjhk").serialize() );
}
function click_me_mjhk(obj,state)
{
    $('#verify_state_mjhk').attr('value',state);
    $(".list_button_mjhk").removeClass("listclassselect");
    $(".list_button_mjhk").addClass("listclassvalue");

    obj.removeClass("listclassvalue");
    obj.addClass("listclassselect");
    search_mjhk();
}

function delete_mjhk(dangkou_id,bill_day)
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
                refresh_inner("view_finance_reg_pure_sales_fund?"+$("#form_mjhk").serialize() );
            }
        });    
    }
}

</script>
<form id="form_mjhk">
<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block;">
    <div  style="float:left; width:100%; margin:10px 0; padding:5px; overflow:hidden; display:block">
        <div style="float:left; overflow:hidden; display:block">
            <input type="hidden" id="order_type" name="order_type"/>
            <span class="listtypevalue listtypeselect">全部</span>
        </div>
        <div style="float:right; overflow:hidden; display:block">
            <span style="float:left; overflow:hidden; display:block">
                <span style="padding:5px 0">日期 <input type="text" class="datepicker"  name="search_store_dangkoubuhuo_from_date"  size="12" maxlength="50" readonly="readonly" style="padding:5px"> 至 <input type="text" class="datepicker"  name="search_sotre_dangkoubuhuo_to_date"  size="12" maxlength="50" readonly="readonly" style="padding:5px">
                </span>
            </span>
            <span id="btn_chukuorder_search" class="btn_normal_green">搜索</span>
        </div>
    </div>
<!-- refresh_begin -->
    <div id="pagelist">
        <div class="title_stalls" style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
            <div style="width:10%;">日期</div>
            <div style="width:10%;">卖家</div>
            <div style="width:10%;">手机号</div>
            <div style="width:10%;">还款金额</div>
            <div style="width:30%;">收款资金账户</div>
            <div style="width:10%;">状态</div>
            <div style="width:10%;">确认人</div>
            <div style="width:10%;">操作</div>
        </div>
    
<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]; 

@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;
$where=@array("bill_boss_id=? and bill_seller_id=?  
        and bill_add_time>=? and bill_add_time<=? and bill_type='mjssd'" ,
        $boss_id,$_REQUEST["bill_seller_id"],
        $from_day,$to_day 
        );
$where=clean_where($where);
//echo $where[0];

$p=select("count(*)","ydf_finance_bill",$where);
$rows = $p->fetch();
$rowcount = $rows[0];
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;$page_count=ceil($rowcount/$pagesize);  
$offset=($page-1)*$pagesize; 

$p=select("*","ydf_finance_bill",$where,"bill_add_time desc",$offset,$pagesize);
if ($p->errorCode()!="00000")
    print_r($p->errorInfo());
while($row_bill=$p->fetch(PDO::FETCH_ASSOC))
{
    $pseller=rselect("*","ydf_seller",array("seller_bianhao=?",$row_bill["bill_seller_id"]));
    $rowseller=$pseller->fetch();

    $p_bill_bank=cselect("*","ydf_bank",array("bank_id=?",$row_bill["bill_bank_id"]));
    $row_bill_bank=$p_bill_bank[0]->fetch();
?>        
        <div class="list_stalls" style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
            <div style="width:10%;"><?php echo echo2(date("Y-m-d H:i:s",$row_bill["bill_add_time"])) ?></div>
            <div style="width:10%;"><?php echo $rowseller["seller_name"] ?></div>
            <div style="width:10%;"><?php echo $rowseller["seller_mobile"] ?></div>
            <div style="width:10%;"><?php echo echo2($row_bill["bill_fund"])?></div>
            <div style="width:30%;"><?php echo $row_bill_bank["bank_type"]=="3"?"支付宝 ".$row_bill_bank["bank_user_account"]:$row_bill_bank["bank_name"].$row_bill_bank["bank_user_account"].$row_bill_bank["bank_user_name"]?></div>
            <div style="width:10%;">-</div>
            <div style="width:10%;">-</div>
            <div style="width:10%;"><span style="color:#0099FF; cursor:pointer">确认收款</span></div>
        </div>   
<?php
}
?>                 
        <div style="float:right; margin-top:5px; font-size:14px"> 共 <span style="font-size:14px; color:#d51938; font-weight:bold;">0</span> 条记录</div>
<script>/*n*//*n*/
$("#pid_view_finance_reg_repayment #pages_771").set_page_count("view_finance_reg_repayment","pages_771",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
        <div class="ipages" id="pages_771" page="view_finance_reg_repayment" form="form_mjhk" count="<?php echo $page_count; ?>"/>
        </form> <!-- 页码也作为表单项统一处理  -->
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

            $(".datepicker").datepicker({duration:""});
            $(".datepicker").datepicker({duration:""});//绑定输入框

        });
</script>