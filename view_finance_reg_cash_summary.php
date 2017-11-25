<!-- txhz 提现资金汇总 --> 
<?php 
include_once "{$root_path}/model/model_bi.php";
function get_user_list()
{
    $boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
    $p=select("*","ydf_user",array("user_boss_m_bianhao=?",$boss_id));
    if ($p->errorCode()!="00000")
        print_r($p->errorInfo());
    while ($user=$p->fetch())
    {
        $p_member=select("*","ydf_member",array("m_bianhao=?",$user["user_self_m_bianhao"]));
        if($member=$p_member->fetch()){ 
            echo '<option value="'.$user["user_self_m_bianhao"].'">'.$member["m_name"].'</option>';
        }
    }
}
function get_factory_list()
{
    $boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
    $p=select("*","ydf_factory",array("factory_boss_m_bianhao=?",$boss_id));
    if ($p->errorCode()!="00000")
        print_r($p->errorInfo());
    while ($f_row=$p->fetch())
    {
        echo '<option value="'.$f_row["factory_bianhao"].'">'.$f_row["factory_name"].'</option>';
    }
}

function get_type_view($e_type){
    $payable_type=array("1001"=>"餐饮",  
        "1002"=>"交通",  
        "1003"=>"住宿",  
        "1004"=>"办公用品",  
        "1005"=>"营销广告",
        "1006"=>"员工工资",  
        "1007"=>"其他"); 
    return $payable_type[$e_type];
}
?>
<script type="text/javascript">    
function delete_txhz(bill_id)
{ 
    if (bill_id=="0"){
        return;
    }
    $.ajax({
        url:"model-bill-delete", 
        async: false,
        type: "POST",
        dataType:"json",
        data:{func:"delete_gcsq",bill_id:bill_id},
        error:function(){
            layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
        },
        success: function(html){
            if (html.desc.indexOf("have_son_bill")==0){
                layer.msg("删除失败，账单已经确认支付,除非撤销支付才能删除", {time: 2000, icon:2});
                return;
            }
            if (html.desc=="must_add_user"){
                layer.msg("删除失败，账单不属于本人！", {time: 2000, icon:2});
                return;
            }
            if (html.state!="ok"){
                layer.msg("删除失败！", {time: 2000, icon:2});
                return;
            }
            layer.msg('删除成功！', {time: 2000, icon:1});
            setTimeout(function(){
                refresh_inner("view_finance_reg_cash_summary?"+$("#form_txhz").serialize() );
            },0);
        }
    });    
}
function list_sdsy()
{
    //重置value
    $('#chuku_from_day').attr("value","");
    $('#chuku_to_day').attr("value","");
    /* $('#chuku_searchwords').attr("placeholder","请输入卖家昵称"); */
    /* $('#chuku_searchwords').css("color","#cccccc") */

    $("#pid_view_finance_reg_cash_summary #pages_txhz").set_page_num("view_finance_reg_cash_summary","pages_txhz",1);

    refresh_inner("view_finance_reg_cash_summary?"+$("#form_txhz").serialize() );
}

function search_sdsy()
{
    $("#btn_chukuorder_search").parent().prev().find(".listtypevalue").removeClass('listtypeselect');

    $("#pid_view_finance_reg_cash_summary #pages_txhz").set_page_num("view_finance_reg_cash_summary","pages_txhz",1);

    refresh_inner("view_finance_reg_cash_summary?"+$("#form_txhz").serialize() );
}

function search_txhz()
{
    mobj=$("#pages_txhz").find("#m");
    mobj.html(1);
    set_page_list_txhz(mobj);
    refresh_inner("view_finance_reg_cash_summary?"+$("#form_txhz").serialize() );
}
function click_me_txhz(obj,state)
{
    $('#bill_type_txhz').attr('value',state);
    $(".list_button_txhz").removeClass("listclassselect");
    $(".list_button_txhz").addClass("listclassvalue");

    obj.removeClass("listclassvalue");
    obj.addClass("listclassselect");
    search_txhz();
}
</script>
                <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block;">
                    <form id="form_txhz">

<!-- refresh_begin -->
                    <div id="pagelist" style="float:left; width:100%; overflow:hidden; display:block">
                        <div class="title_stalls" style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
                            <div style="width:30%;">工厂</div>
                            <div style="width:15%;">上月末可提现资金</div>
                            <div style="width:15%;">+ 本月生效资金</div>
                            <div style="width:15%;">- 本月已提现资金</div>
                            <div style="width:15%;">= 本月可提现资金</div>
                            <div style="width:10%;">付款</div>
                        </div>
<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
$where=@array("factory_boss_m_bianhao=?" ,$boss_id);
$where=clean_where($where);
//print_r($where);
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;$offset=($page-1)*$pagesize; 
$res=cselect("*","ydf_factory",$where,"","",$offset,$pagesize);
$p=$res[0];$rowcount=$res[1];
if ($p->errorCode()!="00000")
    print_r($p->errorInfo());

$page_count=ceil($rowcount/$pagesize);  
$historys=array();
$historys_idx=array();
get_history_agent_pools("month",null,$historys,$historys_idx);

while($row_factory=$p->fetch(PDO::FETCH_ASSOC))
{
    include_once "{$root_path}/model/model_factory.php";
    $factory_name="";$factory_mobile="";
    if (!empty($row_factory["factory_bianhao"])){
        $ires=get_factory_info($boss_id,$row_factory["factory_bianhao"],"2");
        if (count($ires)!=4){
            echo $ires[0];
            continue;
        }
        $factory_name=$ires[1];
        $factory_mobile=$ires[2];
    }
    $month_now=strtotime(date("Y-m-01",time()));
    $active_fund=get_active_fund_and_his_gen_history($row_factory["factory_bianhao"],$month_now,"month");
    $gen_fund=get_factory_agent_fund($row_factory["factory_bianhao"],$month_now,"month");

    $now_idx=$historys_idx[$month_now][$row_factory["factory_bianhao"]];
    $addup_now=@$historys[$now_idx];
    $pool_now=$addup_now["sum"]["pool"];

    $last_idx=$addup_now["last"];
    $addup_last=@$historys[$last_idx];
    $pool_last=$addup_last["sum"]["pool"];
?>
                        
                        <div class="list_stalls" style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                            <div style="width:30%;"><span style="color:#0099FF"><?php echo echo2($factory_name) ?></span></div>
                            <div style="width:15%;"><span style="color:#ee583d"><?php echo echo2($pool_last) ?></span></div>
                            <div style="width:15%;"><span style="color:#ee583d"><?php echo echo2($active_fund["active_fund"]) ?></span></div>
                            <div style="width:15%;"><span style="color:#ee583d"><?php echo echo2($gen_fund["sqyf"]) ?></span></div>
                            <div style="width:15%;"><span style="color:#ee583d"><?php echo echo2($pool_now) ?></span></div>
                            <div style="width:10%;"><span style="color:#0099FF; cursor:pointer" onclick="ShowFactoryPay(<?php echo $row_factory["factory_bianhao"]?>,<?php echo echo2($pool_now) ?>)">付款</span></div>
                            <?php
                            $p_factory_bill=cselect("*","ydf_finance_bill",array("bill_type='sqsf' and bill_factory_id=?",$row_factory["factory_bianhao"]),"","bill_id desc");
                            if ($row_factory_bill=$p_factory_bill[0]->fetch())
                            {
                            ?>
                            <div style="float:left;width:100%; margin:0 auto; padding:10px 0; overflow:hidden; display:block;">
                                <div style="float:right; padding:5px 0">
                                    <span style="float:left"><span style="color:#999999">最近一次付款日期：</span><?php echo date("Y-m-d H:i:s",$row_factory_bill["bill_add_time"]) ?></span>
                                    <span style="float:left; margin-left:10px"><span style="color:#999999">付款人：</span><?php echo $row_factory_bill["bill_add_user_id"] ?></span>
                                    <span style="float:left; margin-left:10px"><span style="color:#999999">付款金额：</span><?php echo $row_factory_bill["bill_fund"] ?></span>                                    
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
<?php
}
?>
                    
                    </div>
                    <div style="float:right; margin-top:5px; font-size:14px"> 共 <span style="font-size:14px; color:#d51938; font-weight:bold;"><?php echo $rowcount?></span> 个工厂</div>

<script>/*n*//*n*/
$("#pid_view_finance_reg_cash_summary #pages_txhz").set_page_count("view_finance_reg_cash_summary","pages_txhz",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
                    <div class="ipages" id="pages_txhz" page="view_finance_reg_cash_summary" form="form_txhz" count="<?php echo $page_count; ?>"/>
                    </form> <!-- 页码也作为表单项统一处理  -->

                </div>
                
                <div id="layer_factory_pay" style="float:left; width:500px; padding:25px; overflow:visible; display:none">
    
                </div>         
<script type="text/javascript">                    
function ShowFactoryPay(factory_id, pay_max){
    $.ajax({
        url:"view-get-factory-pay", 
        async: false,
        type: "POST",
        data:{var_factory_id:factory_id,var_pay_max:pay_max},
        success: function(html){
            $("#layer_factory_pay").html(html);
        }
    });
    
    index_layer_factory_pay=layer.open({
        type: 1,
        area: ['570px', '400px'],
        title: false,
        content:$('#layer_factory_pay')
    });
}

function PostFactoryPay(){
    if(!$("#bill_bank_to").val())
    {
        $("#tip_notice_facotry_pay").html("<span style='font-size:12px; color:red'>亲，请选择工厂收款资金账户哦！</span>");
        return false;
    }
    
    if(!$("#bill_bank_from").val())
    {
        $("#tip_notice_facotry_pay").html("<span style='font-size:12px; color:red'>亲，请选择付款资金账户哦！</span>");
        return false;
    }
    
    if(!$("#bill_fund").val())
    {
        $("#tip_notice_facotry_pay").html("<span style='font-size:12px; color:red'>亲，请填写付款金额哦！</span>");
        return false;
    }
        
    $.ajax({
        url:"model-bill-insert", 
        async: false,
        type: "POST",
        dataType:"json",
        data:$("#vform_factory_pay").serialize(),
        error:function(){
            layer.close(index_layer_factory_pay);
            layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
        },
        success: function(html){
            layer.close(index_layer_factory_pay);
            if (html.state!="ok"){
                layer.msg('提交失败！', {time: 2000, icon:2});
                return;
            }
            layer.msg('提交成功！', {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_finance_reg_cash_summary',1,'frame_finance_reg_cash_summary');
            },0);
        }
    });    
}
</script>
