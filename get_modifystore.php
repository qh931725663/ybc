<?php

include_once("check_dangkou_user.php");

$sqlstore="select dangkou_name from ydf_dangkou where dangkou_bianhao = '".$_REQUEST["var_store_bianhao"]."'";
$rsstore=mysql_query($sqlstore , $dbconn);    
$rowstore=mysql_fetch_array($rsstore);
?>
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px;font-size:12px; margin:5px 0; text-align:right"><span style="color:red">*</span> 仓库名称：</span>
                                <span style="float:left;">
                                <input id="store_name_<?php echo $_REQUEST["var_store_bianhao"] ?>" name="store_name<?php echo $_REQUEST["var_store_bianhao"] ?>" type="text" maxlength="50" style="width:150px; padding:5px" value="<?php echo $rowstore["dangkou_name"] ?>"/>
                                </span>
                            </p>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span onclick="PostModifyStore(<?php echo $_REQUEST["var_store_bianhao"] ?>)" style="float:left; margin-left:150px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认修改</span>
                        </div>    