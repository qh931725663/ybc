<!-- dklr 档口利润 -->
<script type="text/javascript">    
function click_page_num_pdebug(obj)
{
    set_page_list_pdebug(obj);
    refresh_inner("view_finance_reg_cash?"+$("#form_pdebug").serialize() );
}
function set_page_list_pdebug(obj)
{
    if (obj.attr("id")=="last"||obj.attr("id")=="next")
    {
        mobj=$("#pages_pdebug").find("#m");
        if (obj.attr("id")=="last" && Number(mobj.html())-1>=1){
            var bingo=Number(mobj.html())-1;
            mobj.html(bingo);
            click_page_num_pdebug(mobj);
        }
        if (obj.attr("id")=="next" && Number(mobj.html())+1<=page_count_pdebug){
            var bingo=Number(mobj.html())+1;
            mobj.html(bingo);
            click_page_num_pdebug(mobj);
        }
        return;
    }

    $("#pages_pdebug").find("#ll").html("1");
    $("#pages_pdebug").find("#rr").html(page_count_pdebug);

    var bingo=Number(obj.html());

    $("#page_idx_pdebug").attr("value",bingo);

    $("#pages_pdebug").find("#m").html(bingo);//中间页码
    $("#pages_pdebug").find("#l1").html(bingo-1);//左1页码
    $("#pages_pdebug").find("#l2").html(bingo-2);//左2页码
    $("#pages_pdebug").find("#r1").html(bingo+1);//右1页码
    $("#pages_pdebug").find("#r2").html(bingo+2);//右2页码

    $("#pages_pdebug").find(".pagenolink").each(function(){
        var num=Number($(this).html())
        if (num<=0||num>page_count_pdebug){
            $(this).css("display","none");
        }else{
            $(this).css("display","inline");
        }
    });
}

function search_pdebug()
{
    mobj=$("#pages_pdebug").find("#m");
    mobj.html(1);
    set_page_list_pdebug(mobj);
    refresh_inner("view_finance_reg_cash?"+$("#form_pdebug").serialize() );
}
function click_me_pdebug(obj,state)
{
    $('#button_state_pdebug').attr('value',state);
    $(".list_button_pdebug").removeClass("listclassselect");
    $(".list_button_pdebug").addClass("listclassvalue");

    obj.removeClass("listclassvalue");
    obj.addClass("listclassselect");
    search_pdebug();
}

</script>
                <div style=" float:left; width:98%; min-height:800px; margin-top:0px; padding:15px 1%; background:#ffffff; overflow:hidden; display:block">
                    <form id="form_pdebug">
                    <div style="float:left; width:100%; margin-top:0px; overflow:hidden; display:block">
                        <div style="float:left">
                            <span style="font-size:14px; color:#00cc00; font-weight:bold;">日期：</span> 

                            <input  type="text" name="from_day" class="datepicker" size="12" maxlength="50" readonly="readonly" value="1970-01-01">
                            至 
                            <input  type="text" name="to_day" class="datepicker" size="12" maxlength="50" readonly="readonly" value="<?php echo date("Y-m-d")?>">
                            <span id="btn_copy_search" class="btn_normal_green" onclick="/**/search_pdebug()" >搜索</span>
                        </div>
                    </div>        

<!-- refresh_begin -->
                    <div style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
                        <div style="float:left;width:8%; padding:10px 0; text-align:center;">更新时间</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">操作</div>
                        <div style="float:left;width:12%; padding:10px 0; text-align:center">条码</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center;">自定义条码</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">产品</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">工厂</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">规格</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">工厂货号</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center">价格</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center;">合作模式</div>
                        <div style="float:left;width:8%; padding:10px 0; text-align:center;">周期</div>
                    </div>
                    <div id="pagelist" style="float:left; width:100%; overflow:hidden; display:block">
<?php
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];    
$user_id = $boss_id;

@$from_day=$_REQUEST["from_day"]?get_ymd($_REQUEST["from_day"])["d"]:null;
@$to_day=$_REQUEST["to_day"]?get_ymd($_REQUEST["to_day"])["d"]+24*3600:null;
$where=@array("p_barcode_boss_m_bianhao=?  and del_state in (0,1,2)" ,$boss_id);
$where=clean_where($where);

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=50;
$offset=($page-1)*$pagesize; 

$p=cselect("*","ydf_products_barcode",$where,"","update_time desc,p_barcode_bianhao desc",$offset,$pagesize);
if ($p[0]->errorCode()!="00000")
    print_r($p[0]->errorInfo());
$rowcount = $p[1];
$page_count=ceil($rowcount/$pagesize);  
$color="";$last_time=0;
while($row_bill=$p[0]->fetch(PDO::FETCH_ASSOC))
{
    include_once "{$root_path}/model/model_factory.php";
    $factory_name="";
    if (!empty($row_bill["p_barcode_factory_bianhao"])){
        $ires=get_factory_info($boss_id,$row_bill["p_barcode_factory_bianhao"],"2");
        $factory_name=$ires[1];
    }

    include_once "{$root_path}/model/model_bill.php";
    $op="";
    $del_state_show=array(0=>"insert",1=>"delete",2=>"update");
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
                            <div style="float:left;width:12%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["p_barcode_bianhao"]?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["p_barcode_customize_bianhao"]?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["p_barcode_p_bianhao"] ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["p_barcode_factory_bianhao"];echo "($factory_name)" ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["p_barcode_p_type_bianhao"] ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["p_barcode_factory_huohao"] ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["p_barcode_valueprice"] ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["p_barcode_factory_mode"] ?></div>
                            <div style="float:left;width:8%; height:25px; padding:10px 0; text-align:center"><?php echo $row_bill["p_barcode_factory_cycle"] ?></div>
                            
                            <div style="float:right;width:100%; height:25px; padding:10px 0; text-align:right">
<?php 
    echo "boss:{$row_bill['p_barcode_boss_m_bianhao']};";
?>
                            </div>
                        </div>
<?php
}
?>
                    
                    
                    </div>
                    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 个报销记录</div>

<script>/*n*/    
var page_count_pdebug=<?php echo $page_count; ?>;
/**/set_page_list_pdebug($("#pages_pdebug").find("#m"));
</script>

<!-- refresh_end -->
                    <div class="showpage" id="pages_pdebug">
                        <input id="page_idx_pdebug" name="page_idx" style="display:none" value="1"/>
                        <span style="display:block">
                            <span class="pagenolink" id="last" onclick="/**/click_page_num_pdebug($(this))" >上一页</span>
                            <span class="pagenolink" id="ll" onclick="/**/click_page_num_pdebug($(this))" />
                            <span class="pageblank"  id="lb">...</span>
                            <span class="pagenolink" id="l2" onclick="/**/click_page_num_pdebug($(this))" />
                            <span class="pagenolink" id="l1" onclick="/**/click_page_num_pdebug($(this))" />
                            <span class="pageselect" id="m"  onclick="/**/click_page_num_pdebug($(this))"  >1</span>
                            <span class="pagenolink" id="r1" onclick="/**/click_page_num_pdebug($(this))" />
                            <span class="pagenolink" id="r2" onclick="/**/click_page_num_pdebug($(this))" />
                            <span class="pageblank"  id="rb">...</span>
                            <span class="pagenolink" id="rr" onclick="/**/click_page_num_pdebug($(this))" />
                            <span class="pagenolink" id="next" onclick="/**/click_page_num_pdebug($(this))" >下一页</span>
                        </span>
                    </div>
                    </form> <!-- 页码也作为表单项统一处理  -->
                </div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".datepicker").datepicker({duration:""});
        $(".datepicker").datepicker({duration:""});//绑定输入框
    });
</script>