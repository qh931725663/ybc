<!-- dxzj 代销资金池 -->
<?php 
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
function delete_gcsq_dx_dxzj(bill_id){ 
    $.ajax({
        url:"model-bill-delete", 
        async: false,
        type: "POST",
        dataType:"json",
        data:{func:"delete_gcsq_dx",bill_id:bill_id},
        error:function(){
            layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
        },
        success: function(html){
            if (html.desc.indexOf("have_son_bill")==0 ){
                ZENG.msgbox.show("删除失败，账单已经确认支付,撤销支付才能删除", 4, 2000);
                return;
            }
            if (html.desc=="not_your_bill"){
                ZENG.msgbox.show("删除失败，账单不属于本人！", 4, 2000);
                return;
            }
            if (html.state!="ok"){
                layer.msg("删除失败！", {time: 2000, icon:2});
                return;
            }
            layer.msg('删除成功！', {time: 2000, icon:1});
            setTimeout(function(){
                refresh_inner("view_finance_reg_fund_pool?"+$("#form_dxzj").serialize() );
            },0);
        }
    });    
}
function delete_gcyf_dx_dxzj(bill_id)
{ 
    if (bill_id=="0"){
        return;
    }
    $.ajax({
        url:"model-bill-delete", 
        async: false,
        type: "POST",
        dataType:"json",
        data:{func:"delete_gcyf_dx",bill_id:bill_id},
        error:function(){
            layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
        },
        success: function(html){
            if (html.desc.indexOf("have_son_bill")==0){
                ZENG.msgbox.show("删除失败，账单已经确认支付,除非撤销支付才能删除", 4, 2000);
                return;
            }
            if (html.desc=="must_add_user"){
                ZENG.msgbox.show("删除失败，账单不属于本人！", 4, 2000);
                return;
            }
            if (html.state!="ok"){
                layer.msg("删除失败！", {time: 2000, icon:2});
                return;
            }
            layer.msg('删除成功！', {time: 2000, icon:1});
            setTimeout(function(){
                refresh_inner("view_finance_reg_fund_pool?"+$("#form_dxzj").serialize() );
            },0);
        }
    });    
}
function click_page_num_dxzj(obj)
{
    set_page_list_dxzj(obj);
    refresh_inner("view_finance_reg_fund_pool?"+$("#form_dxzj").serialize() );
}
function set_page_list_dxzj(obj)
{
    if (obj.attr("id")=="last"||obj.attr("id")=="next")
    {
        mobj=$("#pages_dxzj").find("#m");
        if (obj.attr("id")=="last" && Number(mobj.html())-1>=1){
            var bingo=Number(mobj.html())-1;
            mobj.html(bingo);
            click_page_num_dxzj(mobj);
        }
        if (obj.attr("id")=="next" && Number(mobj.html())+1<=page_count_dxzj){
            var bingo=Number(mobj.html())+1;
            mobj.html(bingo);
            click_page_num_dxzj(mobj);
        }
        return;
    }

    $("#pages_dxzj").find("#ll").html("1");
    $("#pages_dxzj").find("#rr").html(page_count_dxzj);

    var bingo=Number(obj.html());

    $("#page_idx_dxzj").attr("value",bingo);

    $("#pages_dxzj").find("#m").html(bingo);//中间页码
    $("#pages_dxzj").find("#l1").html(bingo-1);//左1页码
    $("#pages_dxzj").find("#l2").html(bingo-2);//左2页码
    $("#pages_dxzj").find("#r1").html(bingo+1);//右1页码
    $("#pages_dxzj").find("#r2").html(bingo+2);//右2页码

    $("#pages_dxzj").find(".pagenolink").each(function(){
        var num=Number($(this).html())
        if (num<=0||num>page_count_dxzj){
            $(this).css("display","none");
        }else{
            $(this).css("display","inline");
        }
    });

}

function search_dxzj()
{
    mobj=$("#pages_dxzj").find("#m");
    mobj.html(1);
    set_page_list_dxzj(mobj);
    refresh_inner("view_finance_reg_fund_pool?"+$("#form_dxzj").serialize() );
}
function click_me_dxzj(obj,state)
{
    $('#button_state_dxzj').attr('value',state);
    $(".list_button_dxzj").removeClass("listclassselect");
    $(".list_button_dxzj").addClass("listclassvalue");

    obj.removeClass("listclassvalue");
    obj.addClass("listclassselect");
    search_dxzj();
}
</script>
                <div style=" float:left; width:98%; margin-top:0px; padding:15px 1%; background:#ffffff; overflow:hidden; display:block">
                    <form id="form_dxzj">
                    <div style="float:left; width:100%; margin-top:0px; overflow:hidden; display:block">
                        <div style="float:left">
                            <span style="font-size:14px; color:#00cc00; font-weight:bold;">日期：</span> 

                            <input  type="text" name="from_day" onclick="/**/WdatePicker({dateFmt:'yyyy-MM-dd'})" size="12" maxlength="50" readonly="readonly" value="1970-01-01">
                            至 
                            <input  type="text" name="to_day" onclick="/**/WdatePicker({dateFmt:'yyyy-MM-dd'})" size="12" maxlength="50" readonly="readonly" value="<?php echo date("Y-m-d")?>">
                            <span style="font-size:14px; color:#00cc00; font-weight:bold;">工厂：</span> 
                            <select  name="bill_factory_id" style="padding:5px">
                                <option value="">全部工厂</option>    
                                <?php get_factory_list(); ?>
                            </select>
                            <span id="btn_copy_search" class="btn_normal_green" onclick="/**/search_dxzj()" >搜索</span>
                        </div>
                    </div>        
                    <div style="float:left; width:100%; margin-top:20px; overflow:hidden; display:block">
                        <div class="" >
                            <input  type="text" name="bill_is_close" id="button_state_dxzj" readonly="readonly" style="display:none" value=""/>
                            <div class="list_button_dxzj listclassselect"style="margin-left:0px;float:left;font-size:14px" onclick='/**/click_me_dxzj($(this),"");' >全部流水</div>
                            <div class="list_button_dxzj listclassvalue" style="margin-left:5px;float:left;font-size:14px"  onclick="/**/click_me_dxzj($(this),0);" >销售收入</div>
                            <div class="list_button_dxzj listclassvalue" style="margin-left:5px;float:left;font-size:14px"  onclick="/**/click_me_dxzj($(this),1);" >退货支出</div>
                            <div class="list_button_dxzj listclassvalue" style="margin-left:5px;float:left;font-size:14px"  onclick="/**/click_me_dxzj($(this),1);" >提现支出</div>
                        </div>
                    </div>

<!-- refresh_begin -->
                    <div style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
                        <div style="float:left;width:20%; padding:10px 0; text-align:center">单号</div>
                        <div style="float:left;width:20%; padding:10px 0; text-align:center;">日期</div>
                        <div style="float:left;width:20%; padding:10px 0; text-align:center">工厂</div>
                        <div style="float:left;width:20%; padding:10px 0; text-align:center">资金类型</div>
                        <div style="float:left;width:20%; padding:10px 0; text-align:center;">金额</div>
                    </div>
                    <div id="pagelist" style="float:left; width:100%; overflow:hidden; display:block">
<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
$user_id = $boss_id;
$dangkou_id = $_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
$dangkou_id = 10000011;

@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;
$where=@array("bill_boss_id=? and bill_factory_id=? and bill_is_close=?  
        and bill_add_time>=? and bill_add_time<=? and bill_is_close=? and bill_mode=1 and bill_type in ('gcsq','xscb','thcb')" ,
        $boss_id,$_REQUEST["bill_factory_id"],$_REQUEST["bill_is_close"],
        $from_day,$to_day 
        );
$where=clean_where($where);
echo $where[0];

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
echo "++$page++";
$pagesize=10;
$offset=($page-1)*$pagesize; 
echo $offset."||";
echo $pagesize;
$p=cselect("*","ydf_finance_bill",$where,"","bill_id desc",$offset,$pagesize);
if ($p[0]->errorCode()!="00000")
    print_r($p[0]->errorInfo());
$rowcount = $p[1];
$page_count=ceil($rowcount/$pagesize);  

$row_bill=$p[0]->fetch(PDO::FETCH_ASSOC);
do{
    include_once "{$root_path}/model/model_factory.php";
    $factory_name="";$factory_mobile="";$factory_total_payable="";
    if (!empty($row_bill["bill_factory_id"])){
        $ires=get_factory_info($boss_id,$row_bill["bill_factory_id"],"2");
        if (count($ires)!=4){
            echo $ires[0];
            continue;
        }
        $factory_name=$ires[1];
        $factory_mobile=$ires[2];
        $factory_total_payable=$ires[3];
    }

?>
                        <div style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                            <div style="float:left;width:20%; height:25px; padding:10px 0; text-align:center" id="bill_dxzj" ><?php echo echo2($row_bill["bill_id"]) ?></div>
                            <div style="float:left;width:20%; height:25px; padding:10px 0; text-align:center"><?php echo echo2(date("Y-m-d",$row_bill["bill_add_time"])) ?></div>
                            <div style="float:left;width:20%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($factory_name) ?></div>
                            <div style="float:left;width:20%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["bill_type"])?></div>
                            <div style="float:left;width:20%; height:25px; padding:10px 0; text-align:center" id="payable_fund_dxzj"><?php echo echo2($row_bill["bill_fund"])?></div>
                        </div>
<?php
}while($row_bill=$p[0]->fetch(PDO::FETCH_ASSOC))
?>
                    
                    
                    </div>
                    <div style="float:right; margin-top:5px; font-size:14px"> 共 <span style="font-size:14px; color:#d51938; font-weight:bold;"><?php echo $rowcount?></span> 个报销记录</div>

<script>/*n*/    
var page_count_dxzj=<?php echo $page_count; ?>;
/**/set_page_list_dxzj($("#pages_dxzj").find("#m"));
</script>

<!-- refresh_end -->
                    <div class="showpage" id="pages_dxzj">
                        <input id="page_idx_dxzj" name="page_idx" style="display:none" value="1"/>
                        <span style="display:block">
                            <span class="pagenolink" id="last" onclick="/**/click_page_num_dxzj($(this))" >上一页</span>
                            <span class="pagenolink" id="ll" onclick="/**/click_page_num_dxzj($(this))" />
                            <span class="pageblank"  id="lb">...</span>
                            <span class="pagenolink" id="l2" onclick="/**/click_page_num_dxzj($(this))" />
                            <span class="pagenolink" id="l1" onclick="/**/click_page_num_dxzj($(this))" />
                            <span class="pageselect" id="m"  onclick="/**/click_page_num_dxzj($(this))"  >1</span>
                            <span class="pagenolink" id="r1" onclick="/**/click_page_num_dxzj($(this))" />
                            <span class="pagenolink" id="r2" onclick="/**/click_page_num_dxzj($(this))" />
                            <span class="pageblank"  id="rb">...</span>
                            <span class="pagenolink" id="rr" onclick="/**/click_page_num_dxzj($(this))" />
                            <span class="pagenolink" id="next" onclick="/**/click_page_num_dxzj($(this))" >下一页</span>
                        </span>
                    </div>
                    </form> <!-- 页码也作为表单项统一处理  -->

 

                </div>
                
