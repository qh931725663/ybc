<?php
$p_factory=cselect("*","ydf_factory",array("factory_bianhao=?",$_REQUEST["var_factory_id"]));
$rowfactory=$p_factory[0]->fetch();

$pay_max=$_REQUEST["var_pay_max"];
?>
                        <form id="vform_factory_pay">
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; margin:5px 0; color:#999999; text-align:right">工厂：</span>
                                <span style="float:left; margin:5px 0"><?php echo $rowfactory["factory_name"] ?></span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; margin:5px 0; color:#999999; text-align:right">可提现资金：</span>
                                <span style="float:left; margin:5px 0"><?php echo $pay_max ?></span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 收款资金账户：</span>
                                <span style="float:left;">
                                    <select id="bill_bank_to" name="table[1][bill_bank_to]" style="padding:5px">
                                      <option value="" selected>请选择</option>
                                    <?php
                                    $p=cselect("*","ydf_bank",array("bank_boss_id=(select m_bianhao from ydf_member where m_mobile=?)",$rowfactory["factory_mobile"]),"","bank_id desc");
                                    while ($rowbank=$p[0]->fetch())
                                    {
                                    ?>
                                      <option value="<?php echo $rowbank["bank_id"]?>"><?php echo $rowbank["bank_type"]=="3"?$rowbank["bank_user_account"]:$rowbank["bank_name"]." ".$rowbank["bank_user_account"]." "." ".$rowbank["bank_user_name"]?></option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 付款资金账户：</span>
                                <span style="float:left;">
                                    <select id="bill_bank_from" name="table[1][bill_bank_from]" style="padding:5px">
                                      <option value="" selected>请选择</option>
                                    <?php
                                    $p=cselect("*","ydf_bank",array("bank_isstaff='0' and bank_boss_id=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","bank_id desc");
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
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 付款金额：</span>
                                <span style="float:left;">
                                <input id="bill_fund" name="table[1][bill_fund]" type="text" maxlength="50" style="width:100px; padding:5px"/>
                                </span>
                            </p>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span id="tip_notice_facotry_pay" style="float:left; margin-left:100px"></span>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span onClick="/**/PostFactoryPay()" style="float:left; margin-left:100px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认已支付</span>
                        </div>
                        <input type="hidden" name="table[1][bill_factory]" value="<?php echo $_REQUEST["var_factory_id"]?>" />
                        <input type="hidden" name="table[1][bill_desc]" value="" />
                        <input type="hidden" name="table[1][bill_type]" value="sqyf" />
                        </form>            