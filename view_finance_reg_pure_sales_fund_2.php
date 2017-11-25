<?php
$day=get_ymd("",-3600*24)["d"];
$boss_id=$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
$user_id=$_SESSION["ERP_ACCOUNT_USER_SELF_M_BIANHAO"];

//资金账户类型 2 银行 3 支付宝
$p1=cselect("*","ydf_bank",array("bank_boss_id=? and bank_type=2",$boss_id));
$row_bank=$p1[0]->fetch();

$p2=cselect("*","ydf_bank",array("bank_boss_id=? and bank_type=3",$boss_id));
$row_alipay=$p2[0]->fetch();
?>
<script type="text/javascript">    

function submit_dkdj2()
{
    layer.close(index_layer_storefinance_fundadd);
    
    if ($("#refund_dkdj2").attr("value")==""
        || $("#save_cash_dkdj2").attr("value")==""
        || $("#online_cash_dkdj2").attr("value")==""
        || $("#reserve_cash_dkdj2").attr("value")=="")
    {
                layer.msg("日记账条目不能为空！", {time: 2000, icon:2});
        return;
    }

    $(".cdangkou_dkdj2").attr("value","<?php echo $_REQUEST["dangkou_id"] ?>");
    $(".cuser_dkdj2").attr("value","<?php echo $user_id ?>");
    $(".bill_day_dkdj2").attr("value","<?php echo $_REQUEST["bill_day"] ?>");

    var form_content = $("#form_dkdj2").serialize();
    $.ajax({
        url:"model-bill-insert", 
        async: false,
        type: "POST",
        data:form_content,
        dataType:"json",
        success: function(html){
            if (html.state!="ok"){
                                layer.msg("添加新的记账失败:(", {time: 2000, icon:2});
                return;
            }
                        layer.msg("添加新的记账成功:)", {time: 2000, icon:1});
            setTimeout(function(){
                refresh_inner('view_finance_reg_pure_sales_fund',1,'frame_finance_reg_pure_sales_fund');
            },2000);
        },
        error:function(){
                        layer.msg("系统错误！请稍后再试。", {time: 2000, icon:2});
        }
    });    
}

</script>

                <div style=" float:left; width:98%;  margin-top:0px; padding:0px 1%; background:#ffffff; overflow:hidden; display:block">
                    <form id="form_dkdj2">
                    <div style="float:left; width:100%; overflow:hidden; display:block">
                        <div style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                            <div style="float:left;width:30%; padding:10px 0; color:#999999; text-align:right">日期：</div>
                            <div style="float:left; padding:10px 0; text-align:center"><?php echo $_REQUEST["bill_day"] ?></div>
                        </div>
                        <div style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                            <div style="float:left;width:30%; padding:10px 0; color:#999999; text-align:right">今日存入银行：</div>
                            <div style="float:left; height:25px; padding:10px 0; text-align:center">
                                <input name="table[a][bill_day]" class="bill_day_dkdj2" type="text" style="display:none"/>
                                <input name="table[a][bill_fund]" class="iinput" autocomplete="off" id="save_cash_dkdj2" type="text" style="width:100px; padding:7px 0 7px 10px; color:#999999; background:#f2f2f2; border:0"/>
                                <input name="table[a][bill_type]" value="xjcr" type="text" style="display:none"/>
                                <input name="table[a][bill_dangkou]" type="text" style="display:none" class="cdangkou_dkdj2"/>
                                <input name="table[a][bill_user]" type="text" style="display:none" class="cuser_dkdj2"/>
                                <input name="table[a][bill_bank]" type="text" style="display:none" value="<?php echo $row_bank["bank_id"]?>"/>
                            </div>
                        </div>
                        <div style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                            <div style="float:left;width:30%; padding:10px 0; color:#999999; text-align:right">支付宝今日收入：</div>
                            <div style="float:left;height:25px; padding:10px 0; text-align:center">
                                <input name="table[b][bill_day]" class="bill_day_dkdj2" type="text" style="display:none"/>
                                <input name="table[b][bill_fund]" class="iinput" autocomplete="off" id="online_cash_dkdj2" type="text" style="width:100px; padding:7px 0 7px 10px; color:#999999; background:#f2f2f2; border:0"/>
                                <input name="table[b][bill_type]" value="xscr" type="text" style="display:none"/>
                                <input name="table[b][bill_dangkou]" type="text" style="display:none" class="cdangkou_dkdj2"/>
                                <input name="table[b][bill_user]" type="text" style="display:none" class="cuser_dkdj2"/>
                                <input name="table[b][bill_bank]" type="text" style="display:none" value="<?php echo $row_alipay["bank_id"]?>"/>
                                <input name="table[b][cycle_seller_pay]" type="text" style="display:none" value="<?php echo $_REQUEST["cycle_seller_pay_fund"]?>"/>
                            </div>
                        </div>
                        <div style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
                            <div style="float:left;width:30%; padding:10px 0; color:#999999; text-align:right;">今日预留：</div>
                            <div style="float:left;height:25px; padding:10px 0; text-align:center">
                                <input name="table[c][bill_day]" class="bill_day_dkdj2" type="text" style="display:none"/>
                                <input name="table[c][bill_fund]" class="iinput" autocomplete="off" id="reserve_cash_dkdj2" type="text" style="width:100px; padding:7px 0 7px 10px; color:#999999; background:#f2f2f2; border:0"/>
                                <input name="table[c][bill_type]" value="jryl" type="text" style="display:none"/>
                                <input name="table[c][bill_dangkou]" type="text" style="display:none" class="cdangkou_dkdj2"/>
                                <input name="table[c][bill_user]" type="text" style="display:none" class="cuser_dkdj2"/>
                            </div>
                        </div>
                    
                    </div>

                    </form>
                    
                    <div style="float:left; width:100%; margin:20px 0 0 30%; overflow:hidden; display:block">
                        <div style="float:left;">
                            <span id="storefinance_fundadd_affirm_btn"  class="btn_normal_blue" onclick="/**/submit_dkdj2()">确认提交</span>
                        </div>
                    </div>        

                </div>
<script>
    $('#layer_storefinance_fundadd').keydown(function(e){
        if(e.keyCode == 13){
            //模拟点击登陆按钮，触发上面的 Click 事件
            $('#layer_storefinance_fundadd input,select').blur();
            $("#storefinance_fundadd_affirm_btn").trigger("click");
        }
    });
</script>
