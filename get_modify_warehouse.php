<?php

include_once("check_dangkou_user.php");

$sqlstore="select * from ydf_dangkou where dangkou_bianhao = '".$_REQUEST["var_warehouse_bianhao"]."'";
$rsstore=mysql_query($sqlstore , $dbconn);    
$rowstore=mysql_fetch_array($rsstore);
?>
                        <form method="post" id="warehouse_modify_form">
                        <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                            <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 仓库名称：</span>
                            <span style="float:left; width:75%;"><input class="iinput" id="warehouse_modify_warehouse_name_<?php echo $_REQUEST["var_warehouse_bianhao"] ?>" name="warehouse_modify_warehouse_name_<?php echo $_REQUEST["var_warehouse_bianhao"] ?>" type="text" maxlength="50" style="width:200px; padding:5px 0" value="<?php echo $rowstore["dangkou_name"] ?>"></span>
                        </div>
                        <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                            <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 仓库联系人姓名：</span>
                            <span style="float:left; width:75%;"><input class="iinput" id="warehouse_modify_warehouse_manager_<?php echo $_REQUEST["var_warehouse_bianhao"] ?>" name="warehouse_modify_warehouse_manager_<?php echo $_REQUEST["var_warehouse_bianhao"] ?>" type="text" maxlength="50" style="width:100px; padding:5px 0" value="<?php echo $rowstore["dangkou_manager"] ?>"></span>
                        </div>
                        <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                            <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 仓库联系人手机号码：</span>
                            <span style="float:left; width:75%;"><input class="iinput" id="warehouse_modify_warehouse_mobile_<?php echo $_REQUEST["var_warehouse_bianhao"] ?>" name="warehouse_modify_warehouse_mobile_<?php echo $_REQUEST["var_warehouse_bianhao"] ?>" type="text" maxlength="50" style="width:200px; padding:5px 0" value="<?php echo $rowstore["dangkou_mobile"] ?>"></span>
                        </div>
                        <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                            <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 仓库详细地址：</span>
                            <span style="float:left; width:75%;"><input class="iinput" id="warehouse_modify_warehouse_address_<?php echo $_REQUEST["var_warehouse_bianhao"] ?>" name="warehouse_modify_warehouse_address_<?php echo $_REQUEST["var_warehouse_bianhao"] ?>" type="text" maxlength="255" style="width:400px; padding:5px 0" value="<?php echo $rowstore["dangkou_address"] ?>"></span>
                        </div>
                        <div style="float:left; width:75%; margin:30px 0 0 25%; overflow:hidden; display:block">
                            <span id="warehouse_modify_tip_notice_<?php echo $_REQUEST["var_warehouse_bianhao"] ?>" style="float:left"></span>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span id="warehouse_modify_affirm_btn" onclick="PostModifyWarehouse(<?php echo $_REQUEST["var_warehouse_bianhao"] ?>)" style="float:left; margin-left:25%; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认修改</span>
                        </div>    
                        <input type="hidden" name="warehouse_modify_warehouse_bianhao" value="<?php echo $_REQUEST["var_warehouse_bianhao"] ?>">
                        </form>

<script type="text/javascript">
    $('#layer_modify_warehouse').on('keydown',function(e){
                        if(e.keyCode == 13){
                            //模拟点击登陆按钮，触发上面的 Click 事件
                            $('#layer_modify_warehouse input,select').blur();
                            $("#warehouse_modify_affirm_btn").click(
                            );
                        }
                    });
</script>