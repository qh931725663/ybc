<!-- mjyshz 卖家应收汇总 --> 
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

?>
<script type="text/javascript">    
function delete_mjyshz(bill_id)
{ 
    if (bill_id=="0"){
        return;
    }
    $.ajax({
        url:"model-bill-delete", 
        async: false,
        type: "POST",
        dataType:"json",
        data:{func:"delete_mjss",bill_id:bill_id},
        error:function(){
            layer.msg("系统异常，请稍后再试:(", {time: 2000, icon:2});
        },
        success: function(html){
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
                refresh_inner("view_finance_reg_receivable_summary?"+$("#form_mjyshz").serialize() );
            },0);
        }
    });    
}
function click_page_num_mjyshz(obj)
{
    set_page_list_mjyshz(obj);
    refresh_inner("view_finance_reg_receivable_summary?"+$("#form_mjyshz").serialize() );
}
function set_page_list_mjyshz(obj)
{
    if (obj.attr("id")=="last"||obj.attr("id")=="next")
    {
        mobj=$("#pages_mjyshz").find("#m");
        if (obj.attr("id")=="last" && Number(mobj.html())-1>=1){
            var bingo=Number(mobj.html())-1;
            mobj.html(bingo);
            click_page_num_mjyshz(mobj);
        }
        if (obj.attr("id")=="next" && Number(mobj.html())+1<=page_count_mjyshz){
            var bingo=Number(mobj.html())+1;
            mobj.html(bingo);
            click_page_num_mjyshz(mobj);
        }
        return;
    }

    $("#pages_mjyshz").find("#ll").html("1");
    $("#pages_mjyshz").find("#rr").html(page_count_mjyshz);

    var bingo=Number(obj.html());

    $("#page_idx_mjyshz").attr("value",bingo);

    $("#pages_mjyshz").find("#m").html(bingo);//中间页码
    $("#pages_mjyshz").find("#l1").html(bingo-1);//左1页码
    $("#pages_mjyshz").find("#l2").html(bingo-2);//左2页码
    $("#pages_mjyshz").find("#r1").html(bingo+1);//右1页码
    $("#pages_mjyshz").find("#r2").html(bingo+2);//右2页码

    $("#pages_mjyshz").find(".pagenolink").each(function(){
        var num=Number($(this).html())
        if (num<=0||num>page_count_mjyshz){
            $(this).css("display","none");
        }else{
            $(this).css("display","inline");
        }
    });

}

function search_mjyshz()
{
    mobj=$("#pages_mjyshz").find("#m");
    mobj.html(1);
    set_page_list_mjyshz(mobj);
    refresh_inner("view_finance_reg_receivable_summary?"+$("#form_mjyshz").serialize() );
}
function click_me_mjyshz(obj,state)
{
    $('#bill_type_mjyshz').attr('value',state);
    $(".list_button_mjyshz").removeClass("listclassselect");
    $(".list_button_mjyshz").addClass("listclassvalue");

    obj.removeClass("listclassvalue");
    obj.addClass("listclassselect");
    search_mjyshz();
}
</script>
                <div style=" float:left; width:98%; min-height:800px; margin-top:0px; padding:15px 1%; background:#ffffff; overflow:hidden; display:block">
                    <form id="form_mjyshz">
                    <div style="float:left; width:100%; margin-top:0px; overflow:hidden; display:block">
                        <div style="float:left">

                            <span style="font-size:14px; color:#00cc00; font-weight:bold;">档口：</span> 
                            <select  name="bill_factory_id" style="padding:5px">
                                <option value="">全部档口</option>    
                                <?php  ?>
                            </select>
                            <span style="font-size:14px; color:#00cc00; font-weight:bold;">卖家：</span> 
                            <input  type="text"  style="" value=""/>
                            <span id="btn_copy_search" class="btn_normal_green" onclick="/**/search_mjyshz()" >搜索</span>
                        </div>
                        <div style="float:right">
                            <span id="btn_copy_search" class="btn_normal_green" onclick="/**/mount_to_frame('view_finance_reg_receivable',0,'frame_finance_reg_receivable')">返&nbsp回</span>
                        </div>
                    </div>        
                    <div style="float:left; width:100%; margin-top:20px; overflow:hidden; display:block">
                        <div class="" >
                            <input  type="text" name="bill_type" id="bill_type_mjyshz" readonly="readonly" style="display:none" value=""/>
                            <div class="list_button_mjyshz listclassselect"style="margin-left:0px;float:left;font-size:14px" onclick='/**/click_me_mjyshz($(this),"");' >卖家应收汇总</div>
                        </div>
                    </div>

<!-- refresh_begin -->
                    <div style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
                        <div style="float:left;width:16%; padding:10px 0; text-align:center">卖家</div>
                        <div style="float:left;width:14%; padding:10px 0; text-align:center">手机号</div>
                        <div style="float:left;width:14%; padding:10px 0; text-align:center">累计应收欠款</div>
                        <div style="float:left;width:14%; padding:10px 0; text-align:center">累计还款</div>
                        <div style="float:left;width:14%; padding:10px 0; text-align:center">结余应收欠款</div>
                        <div style="float:left;width:14%; padding:10px 0; text-align:center;">操作</div>
                    </div>
                    <div id="pagelist" style="float:left; width:100%; overflow:hidden; display:block">
<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
$user_id = $boss_id;
$dangkou_id = $_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
$dangkou_id = 10000011;

//@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
//@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;
$where=@array("bill_boss_id=? and bill_seller_id=? and bill_is_close=0 and bill_type in ('mjys','mjss')" ,//卖家应收 卖家实收 
        $boss_id,$_REQUEST["bill_seller_id"],
        );
$where=clean_where($where);
print_r($where);

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=10;$offset=($page-1)*$pagesize; 
$res=cselect("bill_seller_id,sum(if(bill_type='mjss',-1,1)*bill_fund) as bill_fund, 
    sum(if(bill_type='mjys',bill_fund,0)) as mjys,
    sum(if(bill_type='mjss',bill_fund,0)) as mjss
    ",
    "ydf_finance_bill",$where,"bill_seller_id","bill_fund desc",$offset,$pagesize);
$p=$res[0];$rowcount=$res[1];
if ($p->errorCode()!="00000")
    print_r($p->errorInfo());

$page_count=ceil($rowcount/$pagesize);  

$row_rec=$p->fetch(PDO::FETCH_ASSOC);
do{
    include_once "{$root_path}/model/model_seller.php";
    $seller_id=0;$seller_name="";$seller_mobile="";
    if (!empty($row_rec["bill_seller_id"])){
        $ires=get_seller_info($row_rec["bill_seller_id"]);
        if ($ires["state"]!="ok"){
            echo json_encode($ires);
            continue;
        }
        $seller_id=$ires["id"];
        $seller_name=$ires["name"];
        $seller_mobile=$ires["mobile"];
        $seller_credit=$ires["credit"];
    }

    $swhere=array("bill_boss_id=? and bill_seller_id=? and bill_type='mjss' ",$boss_id,$row_rec["bill_seller_id"]);
    $p2=cselect("max(bill_id)","ydf_finance_bill",$swhere);
    $maxid=$p2[0]->fetch()[0];
    $p2=cselect("*","ydf_finance_bill",array("bill_id=?",$maxid));
    $maxrow=$p2[0]->fetch();
?>
                        <div style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                            <div style="display:none" id="factory_id_mjyshz"><?php echo echo2($row_rec["bill_seller_id"]) ?></div>
                            <div style="float:left;width:16%; height:25px; padding:10px 0; text-align:center" id="factory_mjyshz"><?php echo echo2($seller_name) ?></div>
                            <div style="float:left;width:14%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($seller_mobile) ?></div>
                            <div style="float:left;width:14%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_rec["mjys"]) ?></div>
                            <div style="float:left;width:14%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_rec["mjss"]) ?></div>
                            <div style="float:left;width:14%; height:25px; padding:10px 0; text-align:center" id="payable_mjyshz"><?php echo echo2($row_rec["bill_fund"])?></div>
                            <div style="float:left;width:14%;padding:10px 0; text-align:center;"><a onclick="/**/pay_it_mjyshz($(this))" >添加还款记录</a>  </div>
                            <div style="float:left;width:100%; margin:0 auto; padding:10px 0; overflow:hidden; display:block;">
                            <div style="float:right; margin-left:10px; padding:5px 0; "><a onclick="/**/delete_mjyshz(<?php echo $maxrow["bill_id"]  ?>)" >撤销还款记录</a>  </div>
                                <div style="float:right; margin-left:10px; padding:5px 0; ">还款说明：<?php echo @echo2($maxrow["bill_desc"])?></div>
                                <div style="float:right; margin-left:10px; padding:5px 0; ">还款金额：<?php echo @echo2($maxrow["bill_fund"])?></div>
                                <div style="float:right; margin-left:0px; padding:5px 0;  ">最近一次还款信息 日期：<?php echo @echo2(date("Y-m-d",$maxrow["bill_add_time"])) ?></div>
                            </div>
                        </div>
<?php
}while($row_rec=$p->fetch(PDO::FETCH_ASSOC))
?>
                    
                    </div>
                    <div style="float:right; margin-top:5px; font-size:14px"> 共 <span style="font-size:14px; color:#d51938; font-weight:bold;"><?php echo $rowcount?></span> 个工厂</div>

<script>/*n*/    
var page_count_mjyshz=<?php echo $page_count; ?>;
/**/set_page_list_mjyshz($("#pages_mjyshz").find("#m"));
</script>

<!-- refresh_end -->
                    <div class="showpage" id="pages_mjyshz">
                        <input id="page_idx_mjyshz" name="page_idx" style="display:none" value="1"/>
                        <span style="display:block">
                            <span class="pagenolink" id="last" onclick="/**/click_page_num_mjyshz($(this))" >上一页</span>
                            <span class="pagenolink" id="ll" onclick="/**/click_page_num_mjyshz($(this))" />
                            <span class="pageblank"  id="lb">...</span>
                            <span class="pagenolink" id="l2" onclick="/**/click_page_num_mjyshz($(this))" />
                            <span class="pagenolink" id="l1" onclick="/**/click_page_num_mjyshz($(this))" />
                            <span class="pageselect" id="m"  onclick="/**/click_page_num_mjyshz($(this))"  >1</span>
                            <span class="pagenolink" id="r1" onclick="/**/click_page_num_mjyshz($(this))" />
                            <span class="pagenolink" id="r2" onclick="/**/click_page_num_mjyshz($(this))" />
                            <span class="pageblank"  id="rb">...</span>
                            <span class="pagenolink" id="rr" onclick="/**/click_page_num_mjyshz($(this))" />
                            <span class="pagenolink" id="next" onclick="/**/click_page_num_mjyshz($(this))" >下一页</span>
                        </span>
                    </div>
                    </form> <!-- 页码也作为表单项统一处理  -->

                </div>
                
