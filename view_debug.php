<!-- dklr 档口利润 -->
<script type="text/javascript">    
function click_page_num_mdebug(obj)
{
    set_page_list_mdebug(obj);
    refresh_inner("view_finance_reg_cash?"+$("#form_mdebug").serialize() );
}
function set_page_list_mdebug(obj)
{
    if (obj.attr("id")=="last"||obj.attr("id")=="next")
    {
        mobj=$("#pages_mdebug").find("#m");
        if (obj.attr("id")=="last" && Number(mobj.html())-1>=1){
            var bingo=Number(mobj.html())-1;
            mobj.html(bingo);
            set_page_list_mdebug(mobj);
        }
        if (obj.attr("id")=="next" && Number(mobj.html())+1<=page_count_mdebug){
            var bingo=Number(mobj.html())+1;
            mobj.html(bingo);
            set_page_list_mdebug(mobj);
        }
        return;
    }

    $("#pages_mdebug").find("#ll").html("1");
    $("#pages_mdebug").find("#rr").html(page_count_mdebug);

    var bingo=Number(obj.html());

    $("#page_idx_mdebug").attr("value",bingo);

    $("#pages_mdebug").find("#m").html(bingo);//中间页码
    $("#pages_mdebug").find("#l1").html(bingo-1);//左1页码
    $("#pages_mdebug").find("#l2").html(bingo-2);//左2页码
    $("#pages_mdebug").find("#r1").html(bingo+1);//右1页码
    $("#pages_mdebug").find("#r2").html(bingo+2);//右2页码

    $("#pages_mdebug").find(".pagenolink").each(function(){
        var num=Number($(this).html())
        if (num<=0||num>page_count_mdebug){
            $(this).css("display","none");
        }else{
            $(this).css("display","inline");
        }
    });
}
function run_debug()
{
    $.ajax({
        url:"model-debug", 
        async: false,
        type: "POST",
        data:{case_id:1},
        dataType:"json",
        success: function(html){
            alert(JSON.stringify(html));
        }
    });
}

function search_mdebug()
{
    mobj=$("#pages_mdebug").find("#m");
    mobj.html(1);
    set_page_list_mdebug(mobj);
    refresh_inner("view_finance_reg_cash?"+$("#form_mdebug").serialize() );
}
function click_me_mdebug(obj,state)
{
    $('#button_state_mdebug').attr('value',state);
    $(".list_button_mdebug").removeClass("listclassselect");
    $(".list_button_mdebug").addClass("listclassvalue");

    obj.removeClass("listclassvalue");
    obj.addClass("listclassselect");
    search_mdebug();
}

</script>
                <div style=" float:left; width:98%; min-height:800px; margin-top:0px; padding:15px 1%; background:#ffffff; overflow:hidden; display:block">
                    <form id="form_mdebug">
                    <div style="float:left; width:100%; margin-top:0px; overflow:hidden; display:block">
                        <div style="float:left">
                            <span style="font-size:14px; color:#00cc00; font-weight:bold;">日期：</span> 

                            <input  type="text" name="from_day" class="datepicker" size="12" maxlength="50" readonly="readonly" value="1970-01-01">
                            至 
                            <input  type="text" name="to_day" class="datepicker" size="12" maxlength="50" readonly="readonly" value="<?php echo date("Y-m-d")?>">
                            <span id="btn_copy_search" class="btn_normal_green" onclick="/**/search_mdebug()" >搜索</span>
                            <span id="btn_copy_search" class="btn_normal_green" onclick="/**/run_debug()" >debug</span>
                        </div>
                    </div>        

<!-- refresh_begin -->
                    <div style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
                        <div style="float:left;width:8%; padding:10px 0; text-align:center;">更新时间</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">操作</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">类型</div>
                        <div style="float:left;width:12%; padding:10px 0; text-align:center">单号</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center;">金额</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">模式|verify</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">工厂</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">卖家</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">档口</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">银行</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center;">添加时间</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center;">生效时间</div>
                    </div>
                    <div id="pagelist" style="float:left; width:100%; overflow:hidden; display:block">
<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
$user_id = $boss_id;

@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;
$where=@array("bill_boss_id=? and bill_factory_id=? and bill_is_close=?  
        and bill_add_time>=? and bill_add_time<=? and bill_is_close=? and del_state in (0,1,2)" ,
        $boss_id,$_REQUEST["bill_factory_id"],$_REQUEST["bill_is_close"],
        $from_day,$to_day 
        );
$where=clean_where($where);
echo $where[0];

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=50;
$offset=($page-1)*$pagesize; 

$p=cselect("*","ydf_finance_bill",$where,"","update_time desc,bill_id desc",$offset,$pagesize);
if ($p[0]->errorCode()!="00000")
    print_r($p[0]->errorInfo());
$rowcount = $p[1];
$page_count=ceil($rowcount/$pagesize);  
$color="";$last_time=0;
while($row_bill=$p[0]->fetch(PDO::FETCH_ASSOC))
{
    $p_member=select("*","ydf_user",array("user_bianhao=?",$row_bill["bill_add_user_id"]) );
    $user_name="";
    if ($row_member=$p_member->fetch()){
        $user_name=$row_member["user_name"]; 
    }
    include_once "{$root_path}/model/model_factory.php";
    $factory_name="";
    if (!empty($row_bill["bill_factory_id"])){
        $ires=get_factory_info($boss_id,$row_bill["bill_factory_id"],"2");
        if (count($ires)!=4){
            echo $ires[0];
            continue;
        }
        $factory_name=$ires[1];
    }

    include_once "{$root_path}/model/model_bill.php";
    $op="";
    $del_state_show=array(0=>"insert",1=>"delete",2=>"update");
    if ($row_bill["update_time"]==$row_bill["bill_add_time"] && $row_bill["del_state"]==2)
        $op="insert-update";
    else
        $op=$del_state_show[$row_bill['del_state']];

    if ($row_bill["update_time"]!=$last_time)
    {
        $last_time=$row_bill["update_time"];
        if ($color=="")
            $color="background:#FFF5EE;";
        else
            $color="";
    }
?>
                        <div style="position:relative;width:100%;<?php echo $color?> padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo echo2(date("Y-m-d H:i:s",$row_bill["update_time"])) ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $op?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["bill_type"];echo "({$row_bill["bill_small_type"]})"?></div>
                            <div style="float:left;width:12%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["bill_id"];echo "({$row_bill['bill_source_id']})" ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["bill_fund"]?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["bill_mode"] ;echo "|{$row_bill['bill_verify_state']}" ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["bill_factory_id"] ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["bill_seller_id"] ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["bill_dangkou_id"] ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["bill_bank_id"] ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo date("Y-m-d H:i:s",$row_bill["bill_add_time"]) ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo date("Y-m-d H:i:s",$row_bill["bill_active_time"]) ?></div>
                            
                            <div style="float:right;width:100%; height:25px; padding:10px 0; text-align:right">
<?php 
    echo "boss:{$row_bill['bill_boss_id']};";
    echo "add:{$row_bill['bill_add_user_id']}"; 
    echo "当事人:{$row_bill['bill_user_id']}"; 
    echo "是否账期卖家:{$row_bill['bill_is_credit_seller']}"; 
    echo "是否赊账:{$row_bill['bill_is_credit']}"; 
?>
                            </div>
                        </div>
<?php
}
?>
                    
                    
                    </div>
                    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个报销记录</div>

<script>/*n*/    
var page_count_mdebug=<?php echo $page_count; ?>;
/**/set_page_list_mdebug($("#pages_mdebug").find("#m"));
</script>

<!-- refresh_end -->
                    <div class="showpage" id="pages_mdebug">
                        <input id="page_idx_mdebug" name="page_idx" style="display:none" value="1"/>
                        <span style="display:block">
                            <span class="pagenolink" id="last" onclick="/**/click_page_num_mdebug($(this))" >上一页</span>
                            <span class="pagenolink" id="ll" onclick="/**/click_page_num_mdebug($(this))" />
                            <span class="pageblank"  id="lb">...</span>
                            <span class="pagenolink" id="l2" onclick="/**/click_page_num_mdebug($(this))" />
                            <span class="pagenolink" id="l1" onclick="/**/click_page_num_mdebug($(this))" />
                            <span class="pageselect" id="m"  onclick="/**/click_page_num_mdebug($(this))"  >1</span>
                            <span class="pagenolink" id="r1" onclick="/**/click_page_num_mdebug($(this))" />
                            <span class="pagenolink" id="r2" onclick="/**/click_page_num_mdebug($(this))" />
                            <span class="pageblank"  id="rb">...</span>
                            <span class="pagenolink" id="rr" onclick="/**/click_page_num_mdebug($(this))" />
                            <span class="pagenolink" id="next" onclick="/**/click_page_num_mdebug($(this))" >下一页</span>
                        </span>
                    </div>
                    </form> <!-- 页码也作为表单项统一处理  -->
                </div>
<script type="text/javascript">
    $(document).ready(function() {
            $(".datepicker").datepicker({duration:""});
        });
</script>