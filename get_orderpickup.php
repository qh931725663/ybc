<?php

include_once("check_dangkou_user.php");

$p_order=cselect("*","ydf_order",array("order_bianhao=?",$_REQUEST["var_order_bianhao"]) );
$roworder=$p_order[0]->fetch();
?>
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 提货状态：</span>
                                <span style="float:left;">
                                    <select id="order_is_pickup_<?php echo $_REQUEST["var_order_bianhao"] ?>" name="order_is_pickup_<?php echo $_REQUEST["var_order_bianhao"] ?>" style="padding:5px">
                                      <option value="">请选择</option>
                                      <option value="0">待提货</option>
                                      <option value="1">已提货</option>
                                      <option value="2">放弃提货</option>
                                    </select>
                                </span>
                            </p>
                        </div>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span onclick="view_sales_pickup.PostSetOrderPickup(<?php echo $_REQUEST["var_order_bianhao"] ?>,<?php echo $roworder["order_seller_bianhao"] ?>)" style="float:left; margin-left:150px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认提交</span>
                        </div>    
