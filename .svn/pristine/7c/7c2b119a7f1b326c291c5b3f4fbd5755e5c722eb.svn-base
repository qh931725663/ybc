<!-- 722 -->
<?php 
$day=get_ymd("",-3600*24)["d"];
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
//$dangkou_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
$dangkou_id=10000011;


?>

                <div style=" float:left; width:98%; margin-top:0px; padding:0px 1%; background:#ffffff; overflow:hidden; display:block">
                    <form id="form_722">

                    <div style="position:relative; float:left; width:100%; margin-top:20px; background:#f2f2f2; display:block">
                        <div style="float:left;width:20%; padding:10px 0; color:#999999; text-align:center">报销类型</div>
                        <div style="float:left;width:15%; padding:10px 0; color:#999999; text-align:center;">报销金额</div>
                        <div style="float:left;width:30%; padding:10px 0; color:#999999; text-align:center;">详细说明</div>
                        <div style="float:left;width:25%; padding:10px 0; color:#999999; text-align:center">收款账户</div>
                        <div style="float:left;width:10%; padding:10px 0; color:#999999; text-align:center;">删除</div>
                    </div>
                    <div id="box_722" style="float:left; width:100%; overflow:hidden; display:block">
<?php 
for ($i=0;$i<2;$i++)
{ 
    $display="block";
    if ($i==0)
    {
        $display="none";
    }
?>                    
                        <div id="row_722" class="crow_722" style="position:relative;width:100%; padding:10px 0; border-top:1px solid #cccccc; overflow:hidden; display:<?php echo $display;?>">
                            <div style="float:left;width:20%; padding:10px 0; text-align:center">
                                <select class="bill_small_type_722"  name="table[<?php echo $i ?>][bill_small_type]" style="padding:5px" onchange="set_bill_type($(this))">   
                                    <option value="">请选择</option>    
                                    <?php get_expence_type_list()?>
                                </select>
                            </div>
                            <div style="float:left;width:15%; height:25px; padding:10px 0; text-align:center">
                                <input  class="fund_722 iinput" name="table[<?php echo $i ?>][bill_fund]" type="text" style="width:70px; padding:7px 0 7px 10px; background:#f2f2f2; border:0"  />
                                <input class="bill_type_722" name="table[<?php echo $i ?>][bill_type]" type="text" style="display:none"/><!--账单类型：报销应付-->
                                <input class="bill_user_722" name="table[<?php echo $i ?>][bill_user]" type="text" style="display:none"/><!--账单类型：报销应付-->
                            </div>
                            <div style="float:left;width:30%; height:25px; padding:10px 0; text-align:center">
                                <input class="desc_722 iinput" name="table[<?php echo $i ?>][bill_desc]" type="text" style="width:120px; padding:7px 0 7px 10px; background:#f2f2f2; border:0" />
                            </div>
                            <div  style="float:left;width:25%; height:25px; padding:10px 0; text-align:center">
                                <select class="bank_722" name="table[<?php echo $i ?>][bill_bank]" style="padding:5px">
                                  <option value="" selected>请选择</option>
                                <?php
                                $p=cselect("*","ydf_bank",array("bank_isstaff='1' and bank_user_account!='' and bank_boss_id=?",$_SESSION["ERP_ACCOUNT_USER_SELF_M_BIANHAO"]),"","bank_id desc");
                                while ($rowbank=$p[0]->fetch())
                                {
                                ?>
                                  <option value="<?php echo $rowbank["bank_id"]?>"><?php echo $rowbank["bank_type"]=="3"?"支付宝":$rowbank["bank_user_name"]?></option>
                                <?php
                                }
                                ?>
                                </select>
                            </div>
                            <div style="float:left;width:10%; height:25px; padding:10px 0; text-align:center">
                                <span style="cursor:pointer" onclick="/**/$(this).parent().parent().remove()">删除</span>
                            </div>
                        </div>
<?php 
} 
?>                    
                    </div>
                    </form>

                    <div style="float:left; width:100%; margin-top:0px; overflow:hidden; display:block">
                        <span class="btn_long_add" onclick="/**/add_row_722()">+</span>
                    </div>

                    
                    <div style="float:left; width:100%; margin-top:20px; overflow:hidden; display:block">
                        <div style="float:right">
                            <span id="btn1" class="btn_normal_blue" onclick="/**/submit_722()">确认提交</span>
                        </div>
                    </div>        
        </div>



                </div>
                
<script type="text/javascript">    
var row_idx_722=2;
function add_row_722()
{
    var temp = $("#row_722").clone();
    temp.css("display","block");
    temp.find("[name]").each(function(){
        var new_v=$(this).attr("name").replace(/\[0\]/,"["+row_idx_722+"]");
        $(this).attr("name",new_v);
    }) ;
    temp.appendTo($("#box_722")); 
    row_idx_722=row_idx_722+1;
}
function del_row_722(obj)
{
    $(this).parent().parent().remove();
}

function submit_722(){
    var ret = 0;
    i=0;
    $(".crow_722").each(function(){
        if (i>0)
        {
            if ($(this).find(".bill_small_type_722").val()=="")
            {
                alert("请选择报销类型！");
                ret=1;
                return false;
            }
            if ($(this).find(".fund_722").attr("value")=="") 
            {
                alert("请填写报销金额！");
                ret=1;
                return false;
            }
            if ($(this).find(".bank_722").val()=="") 
            {
                alert("请选择收款账户！");
                ret=1;
                return false;
            }
        }   
        
        i++;
    })
    
    if (ret==1){
        return;
    }

    var form_content = $("#form_722").serialize();
    $.ajax({
        url:"model-bill-insert", 
        async: false,
        type: "POST",
        data:form_content,
        dataType:"json",
        success: function(html){
            if (html.state!="ok"){
                alert("添加新的记账失败:(");
                return false;
            }
            layer.close(index_layer_expence_add);
            layer.msg("添加新的记账成功:)", {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_finance_reg_expence',1,'frame_finance_reg_expence');
            },2000);
        },
        error:function(){
            alert("系统错误！请稍后再试");
        }
    });    
}


$('#form_722').keydown(function(e){
    if(e.keyCode == 13){
        //模拟点击登陆按钮，触发上面的 Click 事件
        $('#form_722 input,select').blur();
        $("#layer_expence_add span.btn_normal_red").trigger("click");
    }
});



function set_bill_type(obj)
{
    if (obj.attr("value")==""){
        obj.parent().parent().find(".bill_type_722").attr("value","");
        obj.parent().parent().find(".bill_user_722").attr("value","");
    }else{
        obj.parent().parent().find(".bill_type_722").attr("value","bxsq");
        obj.parent().parent().find(".bill_user_722").attr("value","<?php echo $_SESSION["ERP_ACCOUNT_USER_SELF_M_BIANHAO"]?>");
    }
}
</script>
