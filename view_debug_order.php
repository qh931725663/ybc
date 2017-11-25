<!-- dklr 档口利润 -->
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
function click_page_num_order_debug(obj)
{
    set_page_list_order_debug(obj);
    refresh_inner("view_finance_reg_cash?"+$("#form_order_debug").serialize() );
}
function set_page_list_order_debug(obj)
{
    if (obj.attr("id")=="last"||obj.attr("id")=="next")
    {
        mobj=$("#pages_order_debug").find("#m");
        if (obj.attr("id")=="last" && Number(mobj.html())-1>=1){
            var bingo=Number(mobj.html())-1;
            mobj.html(bingo);
            click_page_num_order_debug(mobj);
        }
        if (obj.attr("id")=="next" && Number(mobj.html())+1<=page_count_order_debug){
            var bingo=Number(mobj.html())+1;
            mobj.html(bingo);
            click_page_num_order_debug(mobj);
        }
        return;
    }

    $("#pages_order_debug").find("#ll").html("1");
    $("#pages_order_debug").find("#rr").html(page_count_order_debug);

    var bingo=Number(obj.html());

    $("#page_idx_order_debug").attr("value",bingo);

    $("#pages_order_debug").find("#m").html(bingo);//中间页码
    $("#pages_order_debug").find("#l1").html(bingo-1);//左1页码
    $("#pages_order_debug").find("#l2").html(bingo-2);//左2页码
    $("#pages_order_debug").find("#r1").html(bingo+1);//右1页码
    $("#pages_order_debug").find("#r2").html(bingo+2);//右2页码

    $("#pages_order_debug").find(".pagenolink").each(function(){
        var num=Number($(this).html())
        if (num<=0||num>page_count_order_debug){
            $(this).css("display","none");
        }else{
            $(this).css("display","inline");
        }
    });
}

function search_order_debug()
{
    mobj=$("#pages_order_debug").find("#m");
    mobj.html(1);
    set_page_list_order_debug(mobj);
    refresh_inner("view_finance_reg_cash?"+$("#form_order_debug").serialize() );
}
function click_me_order_debug(obj,state)
{
    $('#button_state_order_debug').attr('value',state);
    $(".list_button_order_debug").removeClass("listclassselect");
    $(".list_button_order_debug").addClass("listclassvalue");

    obj.removeClass("listclassvalue");
    obj.addClass("listclassselect");
    search_order_debug();
}

</script>
                <div style=" float:left; width:98%; min-height:800px; margin-top:0px; padding:15px 1%; background:#ffffff; overflow:hidden; display:block">
                    <form id="form_order_debug">
                    <div style="float:left; width:100%; margin-top:0px; overflow:hidden; display:block">
                        <div style="float:left">
                            <span style="font-size:14px; color:#00cc00; font-weight:bold;">日期：</span> 

                            <input  type="text" name="from_day" class="datepicker" size="12" maxlength="50" readonly="readonly" value="1970-01-01">
                            至 
                            <input  type="text" name="to_day" class="datepicker" size="12" maxlength="50" readonly="readonly" value="<?php echo date("Y-m-d")?>">
                            <span style="font-size:14px; color:#00cc00; font-weight:bold;">工厂：</span> 
                            <select  name="order_factory_id" style="padding:5px">
                                <option value="">全部工厂</option>    
                                <?php get_factory_option(); ?>
                            </select>
                            <span id="btn_copy_search" class="btn_normal_green" onclick="/**/search_order_debug()" >搜索</span>
                        </div>
                    </div>        

<!-- refresh_begin -->
                    <div style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
                        <div style="float:left;width:7%; padding:10px 0; text-align:center;">更新时间</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center">操作</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center">类型</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center">单号</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center;">源</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center">master</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center">slave</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center">用户</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center">卖家</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center">工厂</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center">pay</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center;">pickup</div>
                        <div style="float:left;width:7%; padding:10px 0; text-align:center;">添加时间</div>
                    </div>
                    <div id="pagelist" style="float:left; width:100%; overflow:hidden; display:block">
<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
$user_id = $boss_id;

@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;
$where=@array("order_boss_m_bianhao=? and order_addtime>=? and order_add_time<=? and del_state in (0,1,2)" ,
        $boss_id,$from_day,$to_day 
        );
$where=clean_where($where);
echo $where[0];

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=50;
$offset=($page-1)*$pagesize; 

$p=cselect("*","ydf_order",$where,"","update_time desc,order_bianhao desc",$offset,$pagesize);
if ($p[0]->errorCode()!="00000")
    print_r($p[0]->errorInfo());
$rowcount = $p[1];
$page_count=ceil($rowcount/$pagesize);  
$color="";$last_time=0;
while($row_bill=$p[0]->fetch(PDO::FETCH_ASSOC))
{
    $p_member=select("*","ydf_user",array("user_bianhao=?",$row_bill["order_user_m_bianhao"]) );
    $user_name="";
    if ($row_member=$p_member->fetch()){
        $user_name=$row_member["user_name"]; 
    }
    include_once "{$root_path}/model/model_factory.php";
    $factory_name="";
    if (!empty($row_bill["order_factory_bianhao"])){
        $ires=get_factory_info($boss_id,$row_bill["order_factory_bianhao"],"2");
        if (count($ires)!=4){
            echo $ires[0];
            continue;
        }
        $factory_name=$ires[1];
    }

    $op="";
    $del_state_show=array(0=>"insert",1=>"delete",2=>"update");
    if ($row_bill["update_time"]==$row_bill["order_addtime"] && $row_bill["del_state"]==2)
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
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2(date("Y-m-d H:i:s",$row_bill["update_time"])) ?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo $op?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["order_type"])?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["order_bianhao"]) ?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["order_source_bianhao"]) ?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["order_master_bianhao"])?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["order_slave_bianhao"])?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["order_user_m_bianhao"]) ?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["order_seller_bianhao"]) ?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["order_factory_bianhao"]) ?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["order_is_pay"]) ?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2($row_bill["order_is_pickup"]) ?></div>
                            <div style="float:left;width:7%; height:25px; padding:10px 0; text-align:center"><?php echo echo2(date("Y-m-d H:i:s",$row_bill["order_addtime"])) ?></div>
                        </div>
<?php
}
?>
                    
                    
                    </div>
                    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个报销记录</div>

<script>/*n*/    
var page_count_order_debug=<?php echo $page_count; ?>;
/**/set_page_list_order_debug($("#pages_order_debug").find("#m"));
</script>

<!-- refresh_end -->
                    <div class="showpage" id="pages_order_debug">
                        <input id="page_idx_order_debug" name="page_idx" style="display:none" value="1"/>
                        <span style="display:block">
                            <span class="pagenolink" id="last" onclick="/**/click_page_num_order_debug($(this))" >上一页</span>
                            <span class="pagenolink" id="ll" onclick="/**/click_page_num_order_debug($(this))" />
                            <span class="pageblank"  id="lb">...</span>
                            <span class="pagenolink" id="l2" onclick="/**/click_page_num_order_debug($(this))" />
                            <span class="pagenolink" id="l1" onclick="/**/click_page_num_order_debug($(this))" />
                            <span class="pageselect" id="m"  onclick="/**/click_page_num_order_debug($(this))"  >1</span>
                            <span class="pagenolink" id="r1" onclick="/**/click_page_num_order_debug($(this))" />
                            <span class="pagenolink" id="r2" onclick="/**/click_page_num_order_debug($(this))" />
                            <span class="pageblank"  id="rb">...</span>
                            <span class="pagenolink" id="rr" onclick="/**/click_page_num_order_debug($(this))" />
                            <span class="pagenolink" id="next" onclick="/**/click_page_num_order_debug($(this))" >下一页</span>
                        </span>
                    </div>
                    </form> <!-- 页码也作为表单项统一处理  -->
                </div>
<script>
    $(document).ready(function() {
        $(".datepicker").datepicker({duration:""});
        $(".datepicker").datepicker({duration:""});//绑定输入框
    });
</script>
