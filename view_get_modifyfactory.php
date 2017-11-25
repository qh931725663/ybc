<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_bill.php");

$p=cselect("*","ydf_factory",array("factory_bianhao=?",$_REQUEST["var_factory_bianhao"]));
$rowfactory=$p[0]->fetch();

$arr_factory_fund_init_bill=get_factory_fund_init_bill($rowfactory["factory_bianhao"]);
?>
                        <form id="vform_modify_factory">
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 工厂名称：</span>
                                <span style="float:left;">
                                <input class="iinput" name="modify_factory_name" id="modify_factory_name" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowfactory["factory_name"] ?>"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 手机号：</span>
                                <span style="float:left;">
                                <input class="iinput" name="modify_factory_mobile" id="modify_factory_mobile" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowfactory["factory_mobile"] ?>"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right">代销账期：</span>
                                <span style="float:left;">
                                    <select id="modify_factory_cycle" name="modify_factory_cycle" style="padding:5px">
                                      <option value=""  <?php echo $rowfactory["factory_cycle"]=="0"?"selected":""; ?>>请选择</option>
                                      <option value="1" <?php echo $rowfactory["factory_cycle"]=="1"?"selected":""; ?>>1天</option>
                                      <option value="5" <?php echo $rowfactory["factory_cycle"]=="5"?"selected":""; ?>>5天</option>
                                      <option value="10" <?php echo $rowfactory["factory_cycle"]=="10"?"selected":""; ?>>10天</option>
                                      <option value="15" <?php echo $rowfactory["factory_cycle"]=="15"?"selected":""; ?>>15天</option>
                                      <option value="20" <?php echo $rowfactory["factory_cycle"]=="20"?"selected":""; ?>>20天</option>
                                      <option value="30" <?php echo $rowfactory["factory_cycle"]=="30"?"selected":""; ?>>30天</option>
                                    </select>
                                    <input type="hidden" name="modify_factory_init_cycle" value="<?php echo $rowfactory["factory_init_cycle"] ?>"
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:none">
                                <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 代销初始交易中资金：</span>
                                <span style="float:left;">
                                <input class="iinput" name="modify_factory_fund_freeze" id="modify_factory_fund_freeze" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $arr_factory_fund_init_bill["freeze_fund"] ?>"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:none">
                                <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 代销初始可提现资金：</span>
                                <span style="float:left;">
                                <input class="iinput" name="modify_factory_fund_active" id="modify_factory_fund_active" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $arr_factory_fund_init_bill["active_fund"] ?>"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right">经销初始应付资金：</span>
                                <span style="float:left;">
                                <input class="iinput" name="modify_factory_fund_payable" id="modify_factory_fund_payable" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $arr_factory_fund_init_bill["payable_fund"] ?>"/>
                                </span>
                            </p>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span id="tip_modify_factory" style="float:left; margin-left:150px"></span>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span id="modify_factory_affirm_btn" onclick="PostModifyFactory()" class="btn_normal" style="margin-left:123px;">确认修改</span>
                        </div>    
                        <input type="hidden" name="op" value="update">
                        <input type="hidden" name="factory_id" value="<?php echo $_REQUEST["var_factory_bianhao"] ?>">
                        </form>
<script type="text/javascript">
    $('#layer_modifyfactory').on('keydown',function(e){

                if(e.keyCode == 13){
                    //模拟点击登陆按钮，触发上面的 Click 事件
                    $('#layer_modifyfactory input,select').blur();
                    $("#modify_factory_affirm_btn").click(
                    );
                }
            });
</script>