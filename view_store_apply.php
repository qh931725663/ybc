<?php
if (empty($_SESSION["ERP_ACCOUNT_LOGIN_BIANHAO"]))
{
    echo "<script language=javascript>alert('对不起，您尚未登录或者上次登录已过期！');</script>";
    echo "<script language=javascript>document.location.href='/';</script>";
    exit;
}
?>
                <div style="float:left; width:96%; min-height:800px; margin:15px 1% 0 1%; padding:10px 1%; background:#ffffff; overflow:hidden; display:block">
                    <div class="frame_tab_panel">
                        <div class="frame_tab_line">
                            <span class="frame_tab_item_select">申请使用档口管家</span>
                        </div>
                    </div> 
<form method="post" id="store_apply_form">

                        <div style="width:95%; margin:0 auto; overflow:hidden; display:block;">
                            <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                                <span style="float:left; width:20%; padding:5px 0; text-align:right">收费标准：</span>
                                <span style="float:left; width:80%; padding:5px 0; color:#ee583d">
                                6000 元/年
                                </span>
                            </div>
                            <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                                <span style="float:left; width:20%; padding:5px 0; text-align:right"><span style="color:red">*</span> 所在市场：</span>
                                <span style="float:left; width:80%;">
                                     <select id="dangkou_market" name="dangkou_market" style="padding:5px">    
                                        <option value="">选择</option>
                                        <option>电商基地</option>
                                        <option>四季星座</option>
                                        <option>钱塘男装</option>
                                        <option>新塘牛仔城</option>
                                    </select>
                                </span>
                            </div>
                            <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                                <span style="float:left; width:20%; padding:5px 0; text-align:right"><span style="color:red">*</span> 所在楼层：</span>
                                <span style="float:left; width:80%;">
                                     <select id="dangkou_layer" name="dangkou_layer" style="padding:5px">    
                                        <option value="">选择</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                        <option>13</option>
                                        <option>14</option>
                                        <option>15</option>
                                        <option>16</option>
                                        <option>17</option>
                                        <option>18</option>
                                        <option>19</option>
                                        <option>20</option>
                                    </select>
                                </span>
                            </div>
                            <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                                <span style="float:left; width:20%; padding:5px 0; text-align:right"><span style="color:red">*</span> 档口编号：</span>
                                <span style="float:left; width:80%;"><input id="dangkou_place" name="dangkou_place" type="text" maxlength="50" style="width:100px; padding:5px 0"> <span style="margin-left:5px; color:#999999">如：806，B368</span></span>
                            </div>
                            <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                                <span style="float:left; width:20%; padding:5px 0; text-align:right"><span style="color:red">*</span> 档口专用支付宝：</span>
                                <span style="float:left; width:80%;"><input id="dangkou_alipay_account" name="dangkou_alipay_account" type="text" maxlength="200" style="width:200px; padding:5px 0"></span>
                            </div>
                            <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                                <span style="float:left; width:20%; padding:5px 0; text-align:right"><span style="color:red">*</span> 仓库设置：</span>
                                <span style="float:left; width:80%;">
                                     <select id="dangkou_have_warehouse" name="dangkou_have_warehouse" style="padding:5px">    
                                        <option value="">选择</option>
                                        <option value="0">无</option>
                                        <option value="1">有</option>
                                    </select>
                                </span>
                            </div>
                            <div id="layer_store_apply_warehouse_set" style="position:relative; float:left; width:100%; display:none">
                                <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
                                    <span style="float:left; width:20%; padding:5px 0; text-align:right"><span style="color:red">*</span> 仓库名称：</span>
                                    <span style="float:left; width:80%;"><input id="warehouse_name" name="warehouse_name" type="text" maxlength="50" style="width:200px; padding:5px 0"><span style="margin-left:5px; color:#999999">命名规范：园区+仓库，如：中港仓库</span></span>
                                </div>
                            </div>
                            <div style="float:left; width:80%; margin:30px 0 0 20%; overflow:hidden; display:block">
                                <span id="tip_notice" style="float:left"></span>
                            </div>
                            <div style="float:left; width:80%; margin:20px 0 0 20%; overflow:hidden; display:block">
                                <span id="btn_applaydangkou_submit" class="btn_normal"> 确认提交 </span>
                            </div>
                        </div>    
</form>                        
                        


    
                </div>
<script type="text/javascript">    
$(function(){
    $("#dangkou_have_warehouse").change(function(){
        if ($(this).val()=="1")
        {                            
            $("#layer_store_apply_warehouse_set").show();
        }
        else
        {                            
            $("#layer_store_apply_warehouse_set").hide();
        }
    });
            
    $('#btn_applaydangkou_submit').click(function(){
        if(!$("#dangkou_market").val())
        {
            $("#tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择所在市场哦！</span>");
            return false;
        }
        if(!$("#dangkou_layer").val())
        {
            $("#tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择所在楼层哦！</span>");
            return false;
        }
        if(!$("#dangkou_place").val())
        {
            $("#tip_notice").html("<span style='font-size:14px; color:red'>亲，请填写档口编号哦！</span>");
            return false;
        }
        if(!$("#dangkou_alipay_account").val())
        {
            $("#tip_notice").html("<span style='font-size:14px; color:red'>亲，请填写支付宝账号哦！</span>");
            return false;
        }
        if(!$("#dangkou_have_warehouse").val())
        {
            $("#tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择仓库设置！</span>");
            return false;
        }
        if($("#dangkou_have_warehouse").val()=="1")
        {
            if(!$("#warehouse_name").val())
            {
                $("#tip_notice").html("<span style='font-size:14px; color:red'>亲，请填写仓库名称！</span>");
                return false;
            }
        }
                
        $.ajax({
            url:"post-store-apply", 
            async: false,
            type: "POST",
            data:$('#store_apply_form').serialize(),
            dataType:"json",
            success: function(html){
                if (html["state"]=="ok")
                {
                    layer.msg("亲，申请已成功提交哦！", {time: 2000, icon:1});
                    setTimeout(function(){
                        window.location.href="/myaccount";
                    },2000);
                }
                else
                {
                    layer.msg(html["desc"], {time: 2000, icon:2});
                }
            }
        });        
    });
});

</script>