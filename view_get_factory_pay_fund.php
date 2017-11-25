<?php

include_once("check_dangkou_user.php");

$p_factory=cselect("*","ydf_factory",array("factory_bianhao=?",$_REQUEST["var_factory_id"]));
$rowfactory=$p_factory[0]->fetch();

$receivable_fund=$_REQUEST["var_pay_fund"];
?>
                        <form id="vform_factory_pay_fund">
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; margin:5px 0; color:#999999; text-align:right">工厂：</span>
                                <span style="float:left; margin:5px 0"><?php echo $rowfactory["factory_name"] ?></span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; margin:5px 0; color:#999999; text-align:right">应付资金：</span>
                                <span id="yingfuzijin" style="float:left; margin:5px 0"><?php echo $receivable_fund ?></span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 付款资金账户：</span>
                                <span style="float:left;">
                                    <select id="bill_bank" name="table[1][bill_bank]" style="padding:5px">
                                      <option value="" selected>请选择</option>
                                    <?php
                                    if (empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) and ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4" and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1")))
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
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 实付金额：</span>
                                <span style="float:left;">
                                <input id="bill_fund" name="table[1][bill_fund]" type="text" maxlength="50" style="width:100px; padding:5px"/>
                                </span>
                            </p>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span id="tip_notice_factory_pay_fund" style="float:left; margin-left:100px"></span>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span onClick="/**/PostFactoryPayFund()" style="float:left; margin-left:100px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认已支付</span>
                        </div>
                        <input type="hidden" name="table[1][bill_factory]" value="<?php echo $_REQUEST["var_factory_id"]?>" />
                        <input type="hidden" name="table[1][bill_desc]" value="" />
                        <input type="hidden" name="table[1][bill_type]" value="gcsf" />
                        </form>
<script>
    function PostFactoryPayFund(){
        if(!$("#bill_bank").val())
        {
            $("#tip_notice_factory_pay_fund").html("<span style='font-size:12px; color:red'>亲，请选择付款资金账户哦！</span>");
            return false;
        }

        if(!$("#bill_fund").val())
        {
            $("#tip_notice_factory_pay_fund").html("<span style='font-size:12px; color:red'>亲，请填写实付金额哦！</span>");
            return false;
        }
        if(parseInt($("#bill_fund").val())>parseInt($("#yingfuzijin").text())){
            $("#tip_notice_factory_pay_fund").html("<span style='font-size:12px; color:red'>亲，实付金额不能大于应付金额哦！</span>");
            return false;
        }
        $.ajax({
            url:"model-bill-insert",
            async: false,
            type: "POST",
            dataType:"json",
            data:$("#vform_factory_pay_fund").serialize(),
            error:function(){
                layer.close(index_layer_factory_pay_fund);
                layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
            },
            success: function(html){
                layer.close(index_layer_factory_pay_fund);
                if (html.state!="ok"){
                    layer.msg('提交失败！', {time: 2000, icon:2});
                    return;
                }
                layer.msg('提交成功！', {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_finance_reg_payable_summary',1,'frame_finance_reg_payable_summary');
                },0);
            }
        });
    }
</script>