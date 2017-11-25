<?php

include_once("check_dangkou_user.php");

$p_factory=cselect("*","ydf_factory",array("factory_bianhao=?",$_REQUEST["var_factory_id"]));
$rowfactory=$p_factory[0]->fetch();
$bill_user = $_SESSION["ERP_ACCOUNT_USER_SELF_M_BIANHAO"];

?>

<form id="form_factory_getcash_confirm">
                        <div class="factory_getcash_confirm_content">
                            <div class="factory_getcash_confirm_row">
                                <p>
                                    <span>工厂：</span>
                                </p>
                                <p style="text-align:left">
                                    <span><?php echo $rowfactory["factory_name"] ?></span>
                                </p>
                            </div>
                            <div class="factory_getcash_confirm_row">
                                <p><span>可提现资金：</span></p>
                                <p style="color:red; text-align:left" id="cash_available_num">
                                </p>
                            </div>
                            <div class="factory_getcash_confirm_row">
                                <p><span style="color:red">*</span><span>付款资金账户：</span></p>
                                <select id="payment_funds_account" name="bill_bank_from">
                                    <option value="">请选择资金账户</option>
                                    <?php
                                    if ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4" and ($_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1" or $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="3")))
                                    {
                                        $p=cselect("*","ydf_bank",array("bank_type<>'4' and bank_type<>'1' and bank_type<>'5' and bank_isstaff='0' and bank_boss_id=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","bank_id desc");
                                        while ($rowbank=$p[0]->fetch())
                                        {
                                        ?>
                                            <option value="<?php echo $rowbank["bank_id"]?>"><?php echo $rowbank["bank_type"]=="3"?"支付宝：".$rowbank["bank_user_account"]:$rowbank["bank_name"]." ".$rowbank["bank_user_account"]." ".$rowbank["bank_user_name"]?></option>
                                    <?php
                                        }
                                    }
                                    elseif (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1")
                                    {
                                        $p_dangkou_bank=cselect("*","ydf_dangkou_bank",array("dangkou_bank_type='3' and dangkou_bank_dangkou_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]) );
                                        if ($rowdangkoubank=$p_dangkou_bank[0]->fetch())
                                        {
                                            $p_bank=cselect("*","ydf_bank",array("bank_id=?",$rowdangkoubank["dangkou_bank_bank_bianhao"]) );
                                            $rowbank=$p_bank[0]->fetch();
                                        ?>
                                            <option value="<?php echo $rowbank["bank_id"]?>"><?php echo "支付宝 ".$rowbank["bank_user_account"] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="factory_getcash_confirm_row" style="display:none;">
                                <p><span style="color:red">*</span><span>收款资金账户：</span></p>
                                <select id="collection_fund_account" >
                                    <option value="">请选择资金账户</option>
                                </select>
                            </div>
                            <div class="factory_getcash_confirm_row">
                                <p><span style="color:red">*</span><span>付款金额：</span></p>
                                <input type="text" class="iinput" id="payment_amount" name="bill_fund">
                            </div>
                        </div>
                        <div style="width:100%; margin-top:10px" class="lf of dp">
                            <span id="add_getcash_tip_notice" style="margin-left:80px" class="lf"></span>
                        </div>
                        <div style="float:left; width:100%; margin-top:18px; overflow:hidden; display:block">
                            <span id="factory_getcash_confirm_btn" onclick="/**/PaymentAccount()" style="float:left; margin-left:185px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认付款</span>
                        </div>
                        <input type="hidden" name="bill_user" value="<?php echo $bill_user ?>" />
                        <input type="hidden" name="bill_bank_to" value="" />
                        <input type="hidden" name="func" value="pay_zdfk" />
                        <input type="hidden" name="bill_factory_id" value="<?php echo $_REQUEST['var_factory_id']; ?>" />
                    </form>

<script>
    function PaymentAccount(){
        if(!$("#payment_funds_account").val())
        {
            $("#add_getcash_tip_notice").html("<span style='font-size:14px; color:red'>亲，付款资金账户不能为空哦！</span>");
            return false;
        }
        if(!$("#payment_amount").val())
        {
            $("#add_getcash_tip_notice").html("<span style='font-size:14px; color:red'>亲，请输入付款金额哦！</span>");
            return false;
        }

        $.ajax({
            url:"model-bill-update",
            async: false,
            type: "POST",
            dataType:"json",
            data:$("#form_factory_getcash_confirm").serialize(),
            error:function(){
                layer.close(index_layer_factory_getcash_confirm);
                layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
            },
            success: function(html){
                layer.close(index_layer_factory_getcash_confirm);
                if (html.state!="ok"){
                    layer.msg('提交失败！', {time: 2000, icon:2});
                    return;
                }
                layer.msg('提交成功！', {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_agent_finance_addup',1,'frame_agent_finance_addup');
                },0);
            }
        });
    }
</script>