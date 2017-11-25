<?php

include_once("check_factory_user.php");

include_once "{$root_path}/model/model_bi.php";
?>
<form id="tixian">
<!-- refresh_begin -->
                        <div style="position:relative; float:left; width:100%; margin-top:20px; border-bottom:1px dashed #cccccc; display:block">
                            <div style="float:left;width:15%; padding:10px 0; color:#999999; text-align:center;">库存金额</div>
                            <div style="float:left;width:25%; padding:10px 0; color:#999999; text-align:center;">交易中</div>
                            <div style="float:left;width:20%; padding:10px 0; color:#999999; text-align:center;">已提现</div>
                            <div style="float:left;width:25%; padding:10px 0; color:#999999; text-align:center;">可提现</div>
                            <div style="float:left;width:15%; padding:10px 0; color:#999999; text-align:center;">提现</div>
                        </div>

<?php
include_once "{$root_path}/model/model_bi.php";
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id=@$_REQUEST["dangkou_id"];

$ymd="day";
@$factory_id=$_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"];
//@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize;
$group=array("detail_p_huohao");
list($historys9,$addup3)=get_history_stock_num($ymd="day",$group,$factory_id,null,$order_master_id,null,null,null);
$total_kucun=sum_addup($addup3);//取总库存
//得到货款总额
$total_payment=sum_addup($addup3,"pool_fund");
$t = microtime(true);
$historys2=array();
$historys2_idx=array();
get_history_agent_pools($ymd,@$factory_id,$historys2,$historys2_idx);
$historys_return=array();
$historys_return_idx=array();
get_history_return_pools($ymd,@$factory_id,1,$historys_return,$historys_return_idx);
$historys_fys=array();
$historys_fys_idx=array();
get_history_factory_agent_ys($ymd,@$factory_id,$historys_fys,$historys_fys_idx);
$historys_road=array();
$historys_road_idx=array();
get_history_road_stock($ymd,@$factory_id,1,$historys_road,$historys_road_idx);
$e = microtime(true);
$month_now=strtotime(date("Y-m-01",time()));
$gen_fund=get_factory_agent_fund($factory_id,$month_now,"month");
$group=array("bill_factory_id");
list($historys,$addup)=get_history_stock_fund($ymd,$group,null,@$factory_id,1);
//$sorts=sort_rows($historys,$group);
//$rowcount=count($historys);$page_count=ceil($rowcount/$pagesize);
$ret=[];
foreach ($addup as $key=>$value)
{
    //$ret[]=$value;
    debug($value["now"]);
    $ret[]=$historys[$value["now"] ];
}
$row_count=count($ret);
$sorts=sort_rows($ret,array("bill_day","bill_factory_id"),1);
for ($i=0;$i<$row_count;$i++)
{
    //$llog=new llog();
    //$idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
    //$nfund=$historys[$sorts[$idx][0] ];
    $factory_name="";$factory_mobile="";
    $bill_factory_id=$ret[$i]["bill_factory_id"];
    $p_f=rselect("*","ydf_factory",array("factory_boss_m_bianhao=? and factory_bianhao=?",$boss_id,$ret[$i]["bill_factory_id"] ));
    if ($row_f=$p_f->fetch())
    {
        $factory_name=$row_f["factory_name"];
        $factory_mobile=$row_f["factory_mobile"];
    }
    $bill_day=$ret[$i]["bill_{$ymd}"];
    $bill_factory_id=$ret[$i]["bill_factory_id"];
    $freeze_pool=get_freeze_fund_and_his_gen_history($ret[$i]["bill_factory_id"],$ret[$i]["bill_{$ymd}"],$ymd);
    $bidx=@$historys2_idx[$bill_day][$bill_factory_id];
    $surplus_cash=@$historys2[$bidx]["sum"]["pool"];
    $bidx=@$historys_return_idx[$bill_day][$bill_factory_id];
    $return_pool=@$historys_return[$bidx]["sum"]["pool"];
    $bidx=@$historys_fys_idx[$bill_day][$bill_factory_id];
    $fys_pool=@$historys_fys[$bidx]["sum"]["pool"];
    $bidx=@$historys_road_idx[$bill_day][$bill_factory_id];
    $road_pool=@$historys_road[$bidx]["sum"]["pool"];
    $gcsq=[$ret[$i]["sqyf"]];
    //得到初始化欠款
    $init_debt=get_factory_agent_init_debt($ret[$i]["bill_factory_id"]);
    //得到本期结余资产
    $debt=$init_debt+$ret[$i]["sum"]["gczc"]+$ret[$i]["sum"]["jhcb"]-$ret[$i]["sum"]["tfcb"]-$ret[$i]["sum"]["qccb"]-$ret[$i]["sum"]["sqyf"];
    //得到上期结余资产
    $last_addup=@$historys[$ret[$i]["last"]];
    $last_debt=$init_debt+$last_addup["sum"]["gczc"]+$last_addup["sum"]["jhcb"]-$last_addup["sum"]["tfcb"]-$last_addup["sum"]["qccb"]-$last_addup["sum"]["sqyf"];
    $jhcb=$ret[$i]["jhcb"];
    $qccb_tfcb=$ret[$i]["tfcb"]+$ret[$i]["qccb"];
    $stock_fund=$ret[$i]["sum"]["pool"];
    $total_stock_fund=$stock_fund+$return_pool+$road_pool;
    $total_freeze_fund=$freeze_pool["freeze_fund"]+$fys_pool;
    $diff_fund=padd(array($debt),array($total_stock_fund,$total_freeze_fund,$surplus_cash));
?>
                        <div style="position:relative; float:left; width:100%; overflow:hidden; display:block">
                            <div style="position:relative; float:left; width:100%; display:block">
                                <div style="float:left;width:15%; padding:10px 0; text-align:center;"><span style="color:#ee583d"><?php echo $total_payment?></span></div>
                                <div style="float:left;width:25%; padding:10px 0; text-align:center;"><span style="color:#ee583d"><?php echo $total_freeze_fund?></span></div>
                                <div style="float:left;width:20%; padding:10px 0; text-align:center;"><span style="color:#ee583d"><?php echo echo2($gen_fund["sqyf"]) ?></span></div>
                                <div style="float:left;width:25%; padding:10px 0; text-align:center;"><span id="factory_fund_agent_money" style="color:#ee583d"><?php echo echo2($surplus_cash) ?></span></div>
                                <div style="float:left;width:15%; padding:10px 0; text-align:center;"><span style="color:#0099FF; cursor:pointer" onclick="ShowFactoryGetcash(<?php echo echo2($surplus_cash) ?>)">提现</span></div>
                            </div>    
                        </div>
<?php
}
?>

                    <div style="position:relative; float:left; width:100%; margin-top:20px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
                        <div style="float:left;width:20%; padding:10px 0; color:#999999; text-align:center;">时间</div>
                        <div style="float:left;width:10%; padding:10px 0; color:#999999; text-align:center;">金额（元）</div>
                        <div style="float:left;width:40%; padding:10px 0; color:#999999; text-align:center;">资金账户</div>
                        <div style="float:left;width:15%; padding:10px 0; color:#999999; text-align:center;">状态</div>
                        <div style="float:left;width:15%; padding:10px 0; color:#999999; text-align:center;">操作</div>
                    </div>
                    <?php
                    @$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
                    $pagesize=20;
                    $offset=($page-1)*$pagesize;
                    $p=cselect("*","ydf_finance_bill",array("bill_type='gcsq' and bill_factory_id=?",$_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"]),"","bill_id desc",$offset,$pagesize);
                    $rowcount = $p[1];
                    $page_count=ceil($rowcount/$pagesize);
                    while ($rowbill=$p[0]->fetch())
                    {
                        $p_bill_bank=cselect("*","ydf_bank",array("bank_id=?",$rowbill["bill_bank_id"]));
                        $row_bill_bank=$p_bill_bank[0]->fetch();
                    ?>
                    <div id="pagelist" style="float:left; width:100%; padding:5px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                        <div style="float:left;width:20%; padding:10px 0; text-align:center;"><?php echo date("Y-m-d H:i:s",$rowbill["bill_add_time"]); ?></div>
                        <div style="float:left;width:10%; padding:10px 0; text-align:center;"><?php echo $rowbill["bill_fund"]; ?></div>
                        <div style="float:left;width:40%; padding:10px 0; text-align:center;"><?php echo $row_bill_bank["bank_type"]=="3"?"支付宝-账号：".$row_bill_bank["bank_user_account"]:"银行-账号：".$row_bill_bank["bank_user_account"]." ".$row_bill_bank["bank_name"]." ".$row_bill_bank["bank_user_name"]?></div>
                        <div style="float:left;width:15%; padding:10px 0; text-align:center;">
                            <?php
                            if ($rowbill["bill_verify_state"]=="0")
                            {
                                echo "<span style='color:#ee583d'>待付款</span>";
                            }
                            elseif ($rowbill["bill_verify_state"]=="1")
                            {
                                echo "<span style='color:#009900'>已付款</span>";
                            }
                            elseif ($rowbill["bill_verify_state"]=="2")
                            {
                                echo "<span style='color:#999999'>已驳回</span>";
                            }
                            ?>
                        </div>
                        <div style="float:left;width:15%; padding:10px 0; text-align:center;">
                            <?php
                            if ($rowbill["bill_verify_state"]<>"1")
                            {
                            ?>
                            <span style="color:#0099FF; cursor:pointer" onclick="DeleteGetcashBill(<?php echo $rowbill["bill_id"] ?>)">删除</span>
                            <?php
                            }
                            else
                            {
                            ?>
                            <span style="color:#999999">删除</span>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <script>/*n*//*n*/
                        $("#pid_view_factory_fund_agent #pages_tixian").set_page_count("view_factory_fund_agent","pages_tixian",<?php echo $page_count;?>);
                    </script>
                    <!-- refresh_end -->
                    <div class="ipages" id="pages_tixian" page="view_factory_fund_agent" form="tixian" count="<?php echo $page_count; ?>"/>
                    </form>
                    <div id="layer_factory_getcash" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
                        <form id="vform_factory_getcash">

                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 提现金额：</span>
                                <span style="float:left;">
                                <input id="bill_fund" name="table[1][bill_fund]" type="text" maxlength="50" style="width:100px; padding:5px"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 资金账户：</span>
                                <span style="float:left;">
                                    <select id="bill_bank" name="table[1][bill_bank]" style="padding:5px">
                                      <option value="" selected>请选择</option>
                                    <?php
                                    $p=cselect("*","ydf_bank",array("bank_boss_id=?",$_SESSION["ERP_ACCOUNT_LOGIN_BIANHAO"]),"","bank_id desc");
                                    while ($rowbank=$p[0]->fetch())
                                    {
                                    ?>
                                      <option value="<?php echo $rowbank["bank_id"]?>"><?php echo $rowbank["bank_type"]=="3"?"支付宝":$rowbank["bank_name"]?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; margin:5px 0; height:15px"></span>
                                <span style="float:left; color:#999999">请先在资金账户中添加后在此选择</span>
                            </p>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span id="tip_notice_getcash" style="float:left; margin-left:100px"></span>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span onclick="/**/PostFactoryGetcash()" style="float:left; margin-left:100px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认提现</span>
                        </div>
                        <input type="hidden" id="getcash_max"/>
                        <input type="hidden" name="table[1][bill_factory]" value="<?php echo $_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"]?>" />
                        <input type="hidden" name="table[1][bill_mode]" value="1" />
                        <input type="hidden" name="table[1][bill_type]" value="gcsq" />
                        <input type="hidden" name="table[1][bill_desc]" value="" />

                        </form>            
                    </div>
<script type="text/javascript">
function ShowFactoryGetcash(getcash_max){
    $("#getcash_max").val(getcash_max);
    index_layer_factory_getcash=layer.open({
        type: 1,
        area: ['420px', '300px'],
        title: false,
        content:$('#layer_factory_getcash')
    });
}

function PostFactoryGetcash(){ 
    if(!$("#bill_fund").val())
    {
        $("#tip_notice_getcash").html("<span style='font-size:12px; color:red'>亲，请填写提现金额哦！</span>");
        return false;
    }
    
    if(!$("#bill_bank").val())
    {
        $("#tip_notice_getcash").html("<span style='font-size:12px; color:red'>亲，请选择提现资金账户哦！</span>");
        return false;
    }

    if (parseFloat($("#bill_fund").val())<=0)
    {
        $("#tip_notice_getcash").html("<span style='font-size:12px; color:red'>亲，提现资金金额不能小于等于0哦！</span>");
        return false;
    }
        
    if (parseFloat($("#bill_fund").val())>parseFloat($("#getcash_max").val()))
    {
        $("#tip_notice_getcash").html("<span style='font-size:12px; color:red'>亲，提现资金金额不能超出本期可提现资金金额哦！</span>");
        return false;
    }
        
    $.ajax({
        url:"model-bill-insert", 
        async: false,
        type: "POST",
        dataType:"json",
        data:$("#vform_factory_getcash").serialize(),
        error:function(){
            layer.close(index_layer_factory_getcash);
            layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
        },
        success: function(html){
            layer.close(index_layer_factory_getcash);
            if (html.state!="ok"){
                layer.msg('提交失败！', {time: 2000, icon:2});
                return;
            }
            layer.msg('提交成功！', {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_factory_fund_agent',1,'frame_factory_fund_agent');
            },0);
        }
    });    
}

function DeleteGetcashBill(bill_id){ 
    if(confirm("确定要删除选中的信息吗？一旦删除将不能恢复！"))
    {
        $.ajax({
            url:"model-bill-delete", 
            async: false,
            type: "POST",
            dataType:"json",
            data:{func:"delete_gcsq",bill_id:bill_id},
            error:function(){
                layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
            },
            success: function(html){
                if (html.state=="ok"){
                    layer.msg('删除成功！', {time: 2000, icon:1});
                    setTimeout(function(){
                        mount_to_frame('view_factory_fund_agent',1,'frame_factory_fund_agent');
                    },0);
                }
                else if (html.state=="fail"){
                    layer.msg('删除失败！', {time: 2000, icon:2});
                    return;
                }
                else
                {
                    layer.msg(html.desc, {time: 2000, icon:2});
                    return;
                }
            }
        });    
    }
}
</script>
