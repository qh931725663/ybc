<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_bill.php");

$p=cselect("*","ydf_bank",array("bank_id=?",$_REQUEST["var_bank_id"]));
$rowbank=$p[0]->fetch();
?>
                        <form id="vform_zjzh_modify">
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <?php
                            if ($rowbank["bank_type"]=="2")
                            {
                            ?>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 开户银行：</span>
                                <span style="float:left;">
                                <input id="modify_bank_name" name="bank_name" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowbank["bank_name"] ?>"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 开户人姓名：</span>
                                <span style="float:left;">
                                <input id="modify_bank_user_name" name="bank_user_name" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowbank["bank_user_name"] ?>"/>
                                </span>
                            </p>
                            <?php
                            }
                            ?>
                            <p style="float:left; width:100%; padding:5px 0; display:<?php echo $rowbank["bank_type"]<>"4"?"block":"none"; ?>">
                                <span style="float:left; width:100px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 账号：</span>
                                <span style="float:left;">
                                <input id="modify_bank_user_account" name="bank_user_account" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowbank["bank_user_account"] ?>"/>
                                </span>
                            </p>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span id="tip_notice_modifybank" style="float:left; margin-left:100px"></span>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span onclick="/**/post_zjzh_modify()" style="float:left; margin-left:100px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认修改</span>
                        </div>
                        <input type="hidden" id="bank_id" name="bank_id" value="<?php echo $rowbank["bank_id"] ?>">
                        <input type="hidden" id="modify_bank_type" name="bank_type" value="<?php echo $rowbank["bank_type"] ?>">
                        <input type="hidden" name="op" value="update">
                        </form>    