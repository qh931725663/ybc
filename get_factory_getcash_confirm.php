<?php
$p=cselect("*","ydf_finance_bill",array("bill_id=?",$_REQUEST["var_bill_id"]));
$rowbill=$p[0]->fetch();

$p_factory=cselect("*","ydf_factory",array("factory_bianhao=?",$rowbill["bill_factory_id"]));
$rowfactory=$p_factory[0]->fetch();

$p_bank=cselect("*","ydf_bank",array("bank_id=?",$rowbill["bill_bank_id"]));
$rowbank=$p_bank[0]->fetch();
?>
                        <form id="vform_factory_getcash_confirm">
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; margin:5px 0; color:#999999; text-align:right">提现工厂：</span>
                                <span style="float:left; margin:5px 0"><?php echo $rowfactory["factory_name"] ?></span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; margin:5px 0; color:#999999; text-align:right">提现金额：</span>
                                <span style="float:left; margin:5px 0"><?php echo $rowbill["bill_fund"]?></span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; margin:5px 0; color:#999999; text-align:right">提现资金账户：</span>
                                <span style="float:left; margin:5px 0"><?php echo $rowbank["bank_type"]=="3"?$rowbank["bank_user_account"]:$rowbank["bank_name"]." ".$rowbank["bank_user_account"]." "." ".$rowbank["bank_user_name"]?></span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 付款资金账户：</span>
                                <span style="float:left;">
                                    <select id="bill_bank" name="bill_bank" style="padding:5px">
                                      <option value="" selected>请选择</option>
                                    <?php
                                    $p=cselect("*","ydf_bank",array("bank_type<>'4' and bank_type<>'1' and bank_type<>'5' and bank_isstaff='0' and bank_boss_id=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","bank_id desc");
                                    while ($rowbank=$p[0]->fetch())
                                    {
                                    ?>
                                      <option value="<?php echo $rowbank["bank_id"]?>"><?php echo $rowbank["bank_type"]=="4"?"系统账户":($rowbank["bank_type"]=="3"?$rowbank["bank_user_account"]:$rowbank["bank_name"]." ".$rowbank["bank_user_account"]." ".$rowbank["bank_user_name"])?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </span>
                            </p>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span id="tip_notice_getcash" style="float:left; margin-left:100px"></span>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span onClick="/**/PostFactoryGetcashConfirm()" style="float:left; margin-left:100px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认已支付</span>
                        </div>
                        <input type="hidden" name="bill_id" value="<?php echo $_REQUEST["var_bill_id"]?>" />
                        <input type="hidden" name="bill_fund" value="<?php echo $rowbill["bill_fund"]?>" />
                        <input type="hidden" name="bill_desc" value="" />
                        <input type="hidden" name="func" value="pay_cash" />
                        </form>            