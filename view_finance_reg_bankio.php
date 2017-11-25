<!-- 761 -->
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
function get_type_view($e_type){
    $bankio_type=array("1001"=>"餐饮",  
        "1002"=>"交通",  
        "1003"=>"住宿",  
        "1004"=>"办公用品",  
        "1005"=>"营销广告",
        "1006"=>"员工工资",  
        "1007"=>"其他"); 
    return $bankio_type[$e_type];
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

    $("#pid_view_finance_reg_bankio #pages_761").set_page_num("view_finance_reg_bankio","pages_761",1);

    refresh_inner("view_finance_reg_bankio?"+$("#form_761").serialize() );
}

function search_sdsy()
{
    $("#btn_chukuorder_search").parent().prev().find(".listtypevalue").removeClass('listtypeselect');

    $("#pid_view_finance_reg_bankio #pages_761").set_page_num("view_finance_reg_bankio","pages_761",1);

    refresh_inner("view_finance_reg_bankio?"+$("#form_761").serialize() );
}

function search_761()
{
    mobj=$("#pages_761").find("#m");
    mobj.html(1);
    click_page_num_761(mobj);
    refresh_inner("view_finance_reg_bankio?"+$("#form_761").serialize() );
}
function click_me_761(obj,state)
{
    $('#verify_state_761').attr('value',state);
    $(".list_button_761").removeClass("listclassselect");
    $(".list_button_761").addClass("listclassvalue");

    obj.removeClass("listclassvalue");
    obj.addClass("listclassselect");
    search_761();
}

function verify_it_761(obj)
{
    var par=obj.parent().parent();
    $("#verify_bankio_761").attr("value",par.find("#bankio_761").html());
    $("#verify_bankio_id_761").attr("value",par.find("#bankio_id_761").html());
    index_layerstatus=layer.open({
        type: 1,
        shade: [0],
        area: ['auto', 'auto'],
        title: "报销确认",
        border: [0],
        page: {dom : '#layer_verify_761'}
    });
}

function post_verify_761(state){ 
    $("#layer_verify_state_761").attr("value",state);
    if(!$("#verify_bankio_761").val())
    {
        layer.msg("确认金额不能为空:(", {time: 2000, icon:2});
        return false;
    }
    if(state==2)
    {
        $("#verify_bankio_761").attr("value","0");
    }
        
    $.ajax({
        url:"model-expence-update", 
        async: false,
        type: "POST",
        dataType:"json",
        data:$("#form_verify_761").serialize(),
        error:function(){
            layer.close(index_layerstatus);
            layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
        },
        success: function(html){
            layer.close(index_layerstatus);
            layer.msg("确认成功！", {time: 2000, icon:1});
            setTimeout(function(){
                refresh_inner("view_finance_reg_bankio?"+$("#form_761").serialize() );
            },0);
        }
    });    
}
</script>
                    <form id="form_761">
                    <div style="float:right; width:10%; margin-top:18px; text-align:center; padding:10px 0;"><span id="cash_withdrawal" class="btn_normal_blue" style="margin-left:20px;">提现</span></div>
                    <div style="float:left; width:90%; margin-top:10px; overflow:hidden; display:block;">
                        <div style=" float:left; width:100%; margin-top:0px;border-bottom:1px dashed #cccccc; display:block">
                            <div style="display:inline-block; width:19%; text-align:center; padding:10px 0; color:#999999">上月未提净利</div>
                            <div style="display:inline-block; width:19%; text-align:center; padding:10px 0; color:#999999">+本月毛利</div>
                            <div style="display:inline-block; width:19%; text-align:center; padding:10px 0; color:#999999">-本月开支</div>
                            <div style="display:inline-block; width:19%; text-align:center; padding:10px 0; color:#999999">-本月已提</div>
                            <div style="display:inline-block; width:19%; text-align:center; padding:10px 0; color:#999999">=本期可提净利</div>
                        </div>

                        <?php
                        include_once("{$root_path}/model/model_bi.php");
                        include_once("{$root_path}/model/model_bill.php");
                            $ymd="month";
                            @$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=1;$offset=($page-1)*$pagesize;
                            list($historys,$addup) = get_history_net_profit($ymd,$seller_id=null);
                            $rowcount=count($historys);
                            for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
                            {
                                $idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
                                //$row=$historys[$sorts[$idx][0] ];
                                $row=$historys[$idx];
                                $maoli=$row["xslr"]-$row["thtl"];
                                $kaizhi=$row["bxsf"];
                                if($idx-1>=0){
                                    $row_l=$historys[$idx-1];
                                }else{
                                    $row_l["sum"]["pool"]=0;
                                }


                        ?>
                        <div style=" float:left; width:100%; margin-top:0px; display:block">
                            <div style="display:inline-block; width:19%; text-align:center; padding:10px 0; color: #ee583d;"><?php echo $row_l["sum"]["pool"]?></div>
                            <div style="display:inline-block; width:19%; text-align:center; padding:10px 0; color: #ee583d;"><?php echo $maoli?></div>
                            <div style="display:inline-block; width:19%; text-align:center; padding:10px 0; color: #ee583d;"><?php echo $kaizhi?></div>
                            <div id="benyueyiti" style="display:inline-block; width:19%; text-align:center; padding:10px 0; color: #ee583d;"><?php echo $row["qtzc"]?></div>
                            <div id="ketijingli" style="display:inline-block; width:19%; text-align:center; padding:10px 0; color: #ee583d;"><?php echo $row["sum"]["pool"]?></div>

                        </div>
                        <?php
                        break;
                        }
                        ?>

                    </div>
                    <div  style="float:left; width:100%; margin:10px 0; padding:5px; overflow:hidden; display:block">
                        <div style="float:right; overflow:hidden; display:block">
                            <span style="float:left; overflow:hidden; display:block">
                                <span style="padding:5px 0">日期 <input type="text" class="datepicker" name="from_day"  size="12" maxlength="50" readonly="readonly" style="padding:5px"> 至 <input type="text" class="datepicker" name="to_day" size="12" maxlength="50" readonly="readonly" style="padding:5px">
                                </span>
                            </span>
                            <span id="btn_chukuorder_search" class="btn_normal_blue public_search_sm" onclick="search('view_finance_reg_bankio','form_761')">搜索</span>
                            <span class="clear_search" onclick="mount_to_frame('view_finance_reg_bankio',1,'frame_finance_reg_bankio')">清空<br>条件</span>
                        </div>
                    </div>

                    <div class="title_stalls" style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
                        <div style="width:14%;">日期</div>
                        <div style="width:14%;">资金金额</div>
                        <div style="width:14%;visibility:hidden;">来源账单类型</div>
                        <div style="width:14%;">资金账户</div>
                        <div style="width:14%;visibility:hidden;">经办人</div>
                        <div style="width:16%;">备注</div>
                        <div style="width:14%;">操作</div>
                    </div>
<!-- refresh_begin -->
<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
$user_id = $boss_id;

@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600-1:null;
@$where=array("bill_boss_id=? and bill_add_user_id=?  and bill_type in ('qtsr','qtzc')
        and bill_add_time>=? and bill_add_time<=?" ,
        $boss_id,$_REQUEST["bill_add_user_id"],
        $from_day,$to_day
        );
$where=clean_where($where);
//print_r($where);
$p=select("count(*)","ydf_finance_bill",$where);
$rows = $p->fetch();
$rowcount = $rows[0];
@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;$page_count=ceil($rowcount/$pagesize);
$offset=($page-1)*$pagesize;

$p=select("*","ydf_finance_bill",$where,"bill_add_time desc",$offset,$pagesize);
if ($p->errorCode()!="00000")
    print_r($p->errorInfo());

while($row_bankio=$p->fetch(PDO::FETCH_ASSOC))
{
?>
                        <div class="list_stalls report_table_body" style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                            <div style="width:14%; height:25px;"><?php echo echo2(date("Y-m-d",$row_bankio["bill_add_time"])) ?></div>
                            <div style="width:14%; height:25px;"><?php echo echo2($row_bankio["bill_fund"])?></div>
                            <div style="width:14%; height:25px;visibility:hidden;"><?php echo echo2($row_bankio["bill_small_type"])?></div>
                            <div style="width:14%; height:25px;">
                            <?php
                                $r=rselect("*","ydf_bank",array("bank_isstaff='0' and bank_id=?", $row_bankio["bill_bank_id"]));
                                if($rowbank=$r->fetch())
                                    {
                                        ?>
                                        <?php echo $rowbank["bank_type"]=="4"?"系统账户":($rowbank["bank_type"]=="3"?$rowbank["bank_user_account"]:$rowbank["bank_name"]." ".$rowbank["bank_user_account"]." ".$rowbank["bank_user_name"])?>
                                        <?php
                                    }
                            ?>
                            </div>
                            <div style="width:14%; height:25px;visibility:hidden;"></div>
                            <div style="width:16%; height:25px;"><?php echo echo2($row_bankio["bill_desc"])?></div>
                            <div style="width:14%;"><a style="color:#ee583d; cursor: pointer" onclick="/**/DeleteOtherExpence(<?php echo $row_bankio["bill_id"] ?>)" >删除</a></div>
                        </div>
<?php
}
?>

                    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个记录</div>

<script>/*n*//*n*/
//$("#benyueyiti").html($("#byyt").html());
$("#pid_view_finance_reg_bankio #pages_761").set_page_count("view_finance_reg_bankio","pages_761",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
                    <div class="ipages" id="pages_761" page="view_finance_reg_bankio" form="form_761" count="<?php echo $page_count; ?>"/>
                    </form> <!-- 页码也作为表单项统一处理  -->

                    <form id="form_verify_761">
                    <div id="layer_verify_761" style="float:left; width:350px; max-height:400px; padding:30px; border:2px solid #cccccc; overflow:hidden; display:none">
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px;font-size:12px; margin:5px 0; text-align:right"><span style="color:red">*</span> 报销单号：</span>
                                <span style="float:left;">
                                <input id="verify_bankio_id_761" name="bankio_id" type="text" maxlength="50" style="width:150px; padding:5px" />
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px;font-size:12px; margin:5px 0; text-align:right"><span style="color:red">*</span> 确认金额：</span>
                                <span style="float:left;">
                                <input id="verify_bankio_761" name="verify_bankio" type="text" maxlength="50" style="width:150px; padding:5px"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px;font-size:12px; margin:5px 0; text-align:right"><span style="color:red">*</span> 确认说明：</span>
                                <span style="float:left;">
                                <input id="verify_detail_761" name="verify_detail" type="text" maxlength="50" style="width:150px; padding:5px"/>
                                <input id="layer_verify_state_761" name="verify_state" type="text" style="display:none"/>
                                </span>
                            </p>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span onclick="/**/post_verify_761(1)" style="float:right;  margin:10px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">提交确认</span>
                            <span onclick="/**/post_verify_761(2)" style="float:right;   margin:10px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">驳回请求</span>
                        </div>
                    </div>
                    </form>
                    <div id="layer_account_add" style="float:left; width:450px;height:198px; padding:25px; overflow:visible; display:none">
                        <form id="form_want_account">
                            <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                                <input name="table[1][bill_small_type]" value="1001" style="display:none" >
                                <p style="float:left; width:100%; padding:5px 0; display:none">
                                    <span style="float:left; width:100px; margin:5px 0; color:#999999; text-align:right">类型:</span>
                                        <select class="bill_type" name="table[1][bill_type]" style="padding:5px">
                                         <option value="" >请选择</option>
                                         <option value="qtsr">收入</option>
                                         <option value="qtzc" selected>支出</option>
                                        </select>
                                </p>
                                <p style="float:left; width:100%; padding:5px 0; display:block">
                                    <span style="float:left; width:100px; margin:5px 0; color:#999999; text-align:right">金额:</span>
                                    <input id="capital" name="table[1][bill_fund]" type="text" style="height:24px;"/>
                                </p>
                                <p style="float:left; width:100%; padding:5px 0; display:block">
                                    <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"> 资金账户：</span>
                                    <span style="float:left;">
                                        <select class="bill_bank" name="table[1][bill_bank]" style="padding:5px;width:250px;">
                                            <option value="" selected>请选择</option>
                                                <?php
                                                $pb=rselect("*","ydf_bank",array("bank_type<>'4' and bank_type<>'5' and bank_type<>'1' and bank_isstaff='0' and bank_boss_id=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","bank_id desc");
                                                while ($rbank=$pb->fetch())
                                                {
                                                ?>
                                                  <option value="<?php echo $rbank["bank_id"]?>"><?php echo $rbank["bank_type"]=="4"?"系统账户":($rbank["bank_type"]=="3"?$rbank["bank_user_account"]:$rbank["bank_name"]." ".$rbank["bank_user_account"]." ".$rbank["bank_user_name"])?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </span>
                                </p>
                                <p style="float:left; width:100%; padding:5px 0; display:block">
                                    <span  style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right">备注：</span>
                                    <span style="float:left;">
                                    <input name="table[1][bill_desc]" type="text" maxlength="50" style="width:150px; padding:5px;width:236px;"/>
                                    </span>
                                </p>
                            </div>
                            <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                                <span id="confirm_account_btn" style="float:left; margin-left:100px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认提现</span>
                            </div>
                        </form>
                    </div>
<script>
$('#layer_account_add').on('keydown',function(e){
    if(e.keyCode == 13){
        //模拟点击登陆按钮，触发上面的 Click 事件
        $('#layer_account_add input,select').blur();
        $("#confirm_account_btn").click();
    }
});
$("#cash_withdrawal").click(function(){//我要记账
   index_layer_account_add=layer.open({
        type: 1,
        area: ['600px', '300px'],
        title: false,
        content:$('#layer_account_add')
   });
});
$("#confirm_account_btn").click(function(){//确认记账
    if(parseInt($("#capital").val())>parseInt($("#ketijingli").text())){
        alert("亲，提现金额不能大于可提净利！");
        return false;
    }
    if(!$(".bill_bank").val())
    {
        alert("亲，请填选择资金账户！");
        return false;
    }

    $.ajax({
        url:"model-bill-insert",
        async: false,
        type: "POST",
        dataType:"json",
        data:$("#form_want_account").serialize(),
        success: function(html){
            if(html.state!="ok"){
                alert("提现失败！");
                return false;
            }
            layer.close(index_layer_account_add);
            layer.msg("提现成功!", {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_finance_reg_bankio',1,'frame_finance_reg_bankio');

                $("#form_want_account").get(0).reset()
            },2000);
        },
        error:function(){
            alert("系统错误！请稍后再试");
        }
    });
});

function DeleteOtherExpence(bill_id){
    if(confirm("确定要删除选中的信息吗？一旦删除将不能恢复！"))
    {
        $.ajax({
            url:"model-bill-delete",
            async: false,
            type: "POST",
            dataType:"json",
            data:{func:"delete_qtzc",bill_id:bill_id},
            error:function(){
                layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
            },
            success: function(html){
                if (html.state=="ok"){
                    layer.msg('删除成功！', {time: 2000, icon:1});
                    setTimeout(function(){
                        mount_to_frame('view_finance_reg_bankio',1,'frame_finance_reg_bankio');
                    },0);
                }
                else if (html.state=="fail"){
                    layer.msg('删除失败！', {time: 2000, icon:2});
                    return;
                }
                else
                {
                    layer.msg('你没有删除权限', {time: 2000, icon:2});
                    return;
                }
            }
        });
    }
}
</script>
                
