<?php

include_once("check_dangkou_user.php");
include_once "{$root_path}/model/model_bill.php";
?>
                <div class="search_box">
                    <div style="width:100%; margin-top:20px" class="dp of lf">
                        <div class="rt">
                            <span class="btn_normal_blue"  onclick="/**/ShowStoreAddpLayer()">添加档口</span>
                        </div>
                    </div>        
                    <div class="report_table_header" style="margin-top:20px; background:#f2f2f2">
                        <div style="width:20%; color:#999999">档口名称</div>
                        <div style="width:20%; color:#999999">仓库设置</div>
                        <div style="width:15%; color:#999999">起用时间</div>
                        <div style="width:15%; color:#999999">到期时间</div>
                        <div style="width:15%; color:#999999">状态</div>
                        <div style="width:15%; color:#999999">操作</div>
                    </div>
                    <div id="pagelist">
                    
                    
<?php
$p_pagedata=cselect("*","ydf_dangkou",array("dangkou_type='1' and dangkou_boss_m_bianhao =?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","dangkou_bianhao desc");
while ($rowpagedata=$p_pagedata[0]->fetch())
{
    $warehouse_name="无";
    $p_dangkou_warehouse=cselect("dangkou_warehouse_warehouse_bianhao","ydf_dangkou_warehouse",array("dangkou_warehouse_dangkou_bianhao=?",$rowpagedata["dangkou_bianhao"]));
    if ($rowdangkouwarehouse=$p_dangkou_warehouse[0]->fetch())
    {
        $p_warehouse=cselect("*","ydf_dangkou",array("dangkou_bianhao=?",$rowdangkouwarehouse["dangkou_warehouse_warehouse_bianhao"]));
        if ($rowwarehouse=$p_warehouse[0]->fetch())
        {
            $warehouse_name=$rowwarehouse["dangkou_name"];
        }
    }

    $bank_info="暂未设置";
    $rsbank=mysql_query("select * from ydf_bank where bank_type='2' and bank_id in (select dangkou_bank_bank_bianhao from ydf_dangkou_bank where dangkou_bank_dangkou_bianhao='".$rowpagedata["dangkou_bianhao"]."')", $dbconn);
    if($rowbank=mysql_fetch_array($rsbank))
    {
        $bank_info=$rowbank["bank_user_account"]." | ".$rowbank["bank_name"]." | ".$rowbank["bank_user_name"];
    }
        
    $alipay_account="暂未设置";
    $rsalipay=mysql_query("select * from ydf_bank where bank_type='3' and bank_id in (select dangkou_bank_bank_bianhao from ydf_dangkou_bank where dangkou_bank_dangkou_bianhao='".$rowpagedata["dangkou_bianhao"]."')", $dbconn);
    if($rowalipay=mysql_fetch_array($rsalipay))
    {
        $alipay_account=$rowalipay["bank_user_account"];
    }
?>
                        <div style="position:relative;width:100%; padding:10px 0; border-bottom:1px solid #cccccc; overflow:hidden; display:block">
                            <div class="report_table_body">
                                <div style="width:20%"><?php echo $rowpagedata["dangkou_name"] ?></div>
                                <div style="width:20%"><?php echo $warehouse_name ?></div>
                                <div style="width:15%; height:25px"><?php echo $rowpagedata["dangkou_starttime"]>"0"?date("Y-m-d",$rowpagedata["dangkou_starttime"]):"-"?></div>
                                <div style="width:15%; height:25px"><?php echo $rowpagedata["dangkou_endtime"]>"0"?date("Y-m-d",$rowpagedata["dangkou_endtime"]):"-"?></div>
                                <div style="width:15%; height:25px">
                                <?php
                                if ($rowpagedata["dangkou_endtime"]=="0")
                                {
                                ?>
                                <span style="color:#d64126">待付款</span>
                                <?php
                                }
                                elseif ($rowpagedata["dangkou_endtime"]>strtotime(date("Y-m-d H:i:s")))
                                {                
                                ?>
                                <span style="color:#009900">正常</span>
                                <?php
                                }
                                else
                                {
                                ?>
                                <span style="color:#0099FF">到期</span>
                                <?php
                                }
                                ?>
                                </div>
                                <div style="width:15%; padding:0">
                                    <div style="width:100%; padding:5px 0" class="dp of">
                                        <?php 
                                        if ($rowpagedata["dangkou_endtime"]=="0") 
                                        { 
                                        ?>
                                        <span style="color:#0099FF; cursor:pointer" onclick="/**/ShowStorePaymentLayer()">付款</span> | 
                                        <?php  
                                        }
                                        ?>
                                        <span style="color:#0099FF; cursor:pointer" onclick="/**/ShowStoreModifyLayer(<?php echo $rowpagedata["dangkou_bianhao"]?>)">修改</span>
                                    </div>
                                    <div style="width:100%; padding:5px 0" class="dp of">
                                        <span style="color:#0099FF; cursor:pointer" onclick="/**/ShowStoreFundaccountLayer(<?php echo $rowpagedata["dangkou_bianhao"]?>)">绑定资金账户</span>
                                    </div>
                                </div>
                            </div>
                            <div style="width:100%; text-align:center; padding:10px 0; border-top:1px dashed #cccccc; overflow:hidden; display:block">
                                <span style="color:#999999">银行账号：</span><?php echo $bank_info ?>
                                <span style="color:#999999">支付宝账号：</span><?php echo $alipay_account ?>
                                <span style="color:#999999">初始预留现金：</span><?php echo get_init_fund_bill("jrylcsh",$rowpagedata["dangkou_bianhao"]) ?>
                            </div>
                            <div style="width:100%; text-align:center; padding:10px 0; border-top:1px dashed #cccccc; overflow:hidden; display:block">
                                <span style="color:#999999">档口联系方式：</span><?php echo $rowpagedata["dangkou_manager"]."，".$rowpagedata["dangkou_mobile"]."，".$rowpagedata["dangkou_address"]?>
                            </div>
                        </div>
<?php
}
?>
                    
                    


                    <div id="layer_store_add">
                        <form method="post" id="store_add_form">
                        <div>
                            <span class="sp_a">收费标准：</span>
                            <span style="float:left; padding:5px 0; color:#ee583d">
                            6000 元/年
                            </span>
                        </div>
                        <div>
                            <span class="sp_a"><span style="color:red">*</span> 所在市场：</span>
                            <span class="sp_b">
                                 <select id="store_add_store_market" name="store_add_store_market" style="padding:5px">    
                                    <option value="">选择</option>
                                    <option>电商基地</option>
                                    <option>四季星座</option>
                                    <option>钱塘男装</option>
                                    <option>新塘牛仔城</option>
                                </select>
                            </span>
                        </div>
                        <div>
                            <span class="sp_a"><span style="color:red">*</span> 所在楼层：</span>
                            <span class="sp_b">
                                 <select id="store_add_store_layer" name="store_add_store_layer" style="padding:5px">    
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
                        <div>
                            <span class="sp_a"><span style="color:red">*</span> 档口编号：</span>
                            <span class="sp_b"><input class="iinput" id="store_add_store_place" name="store_add_store_place" type="text" maxlength="50" style="width:100px; padding:5px 0"> <span style="margin-left:5px; color:#999999">如：806，B368</span></span>
                        </div>
                        <div>
                            <span class="sp_a"><span style="color:red">*</span> 档口专用支付宝：</span>
                            <span class="sp_b"><input class="iinput" id="store_add_alipay_account" name="store_add_alipay_account" type="text" maxlength="50" style="width:200px; padding:5px 0"></span>
                        </div>
                        <div>
                            <span class="sp_a"><span style="color:red">*</span> 仓库设置：</span>
                            <span class="sp_b">
                                 <select id="store_add_store_have_warehouse" name="store_add_store_have_warehouse" style="padding:5px">    
                                    <option value="">选择</option>
                                    <option value="0">无</option>
                                    <option value="1">有</option>
                                </select>
                            </span>
                        </div>
                        <div id="layer_store_add_warehouse_set" style="display:none">
                            <div>
                                <span class="sp_a"><span style="color:red">*</span> 仓库名称：</span>
                                <span class="sp_b">
                                     <select id="store_add_warehouse_bianhao" name="store_add_warehouse_bianhao" style="padding:5px">    
                                        <option value="">选择</option>
                                        <?php
                                        $rswarehouse=mysql_query("select * from ydf_dangkou where dangkou_type='2' and dangkou_boss_m_bianhao='".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."' order by dangkou_bianhao asc", $dbconn);
                                        while($rowwarehouse=mysql_fetch_array($rswarehouse))
                                        {
                                        ?>
                                        <option value="<?php echo $rowwarehouse["dangkou_bianhao"] ?>"><?php echo $rowwarehouse["dangkou_name"] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span style="margin-left:5px; color:#999999">请在仓库设置中新增更多仓库</span>
                                </span>
                            </div>
                        </div>
                        <div style="width:75%; margin:20px 0 0 25%" class="lf of dp">
                            <span id="store_add_tip_notice" style="float:left"></span>
                        </div>
                        <div style="width:75%; margin:20px 0 0 25%" class="lf of dp">
                            <span class="btn_normal" onclick="/**/PostStoreAdd()" id="store_add_affirm_btn"> 确认添加 </span>
                        </div>    
                        </form>        
                    </div>
                    
                    <div id="layer_store_modify">
        
                    </div>
                    
                    <div id="layer_store_payment">
                        <div style="width:100%; margin:0 auto; overflow:hidden; display:block">
                            <div style="float:left; width:100%; margin-top:50px; overflow:hidden; display:block">
                                <div style="float:left; width:20%; height:50px; background:url(/pc/images/icon_daishenhe.png) center center no-repeat; overflow:hidden; display:block"></div>
                                <div style="float:left; width:80%; padding:5px 0; font-family:Microsoft YaHei; font-size:18px; font-weight:bold; color:#ff6000; overflow:hidden; display:block">申请已成功提交，请付款等待开通...</div>
                            </div>
                            <div style="float:left; width:80%; margin-left:20%; margin-top:20px; font-size:14px; overflow:hidden; display:block">服务费 ( <span style="font-size:14px;font-weight:bold; color:#d64126">6000 元 / 年</span> ) 请转账至支付宝：18668230665（姓名：胡覃）</div>
                            <div style="float:left; width:80%; margin-left:20%; margin-top:20px; font-size:14px; color:#d64126; overflow:hidden; display:block">付款时，请务必 备注说明 申请注册的档口号</div>
                            <div style="float:left; width:80%; margin-left:20%; margin-top:20px; font-size:14px; overflow:hidden; display:block">如需帮助请拨打服务热线：0571-22810690</div>
                        </div>        
                    </div>
                    
                    <div id="layer_store_fundaccount">
        
                    </div>
                    
                </div>
                
                
<script type="text/javascript">    
$(function(){
    $("#store_add_store_have_warehouse").change(function(){
        if ($(this).val()=="1")
        {                            
            $("#layer_store_add_warehouse_set").show();
        }
        else
        {                            
            $("#layer_store_add_warehouse_set").hide();
        }
    });
    
    $("#store_modify_store_have_warehouse").change(function(){
        if ($(this).val()=="1")
        {                            
            $("#layer_store_modify_warehouse_set").show();
        }
        else
        {                            
            $("#layer_store_modify_warehouse_set").hide();
        }
    });
});

function ShowStoreAddpLayer(){
    index_layerstatus=layer.open({
        type: 1,
        area: ['720px', '500px'],
        title: false,
        content:$('#layer_store_add')
    });
}

function PostStoreAdd(){ 
    if(!$("#store_add_store_market").val())
    {
        $("#store_add_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择所在市场哦！</span>");
        return false;
    }
    if(!$("#store_add_store_layer").val())
    {
        $("#store_add_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择所在楼层哦！</span>");
        return false;
    }
    if(!$("#store_add_store_place").val())
    {
        $("#store_add_tip_notice").html("<span style='font-size:14px; color:red'>亲，请填写档口编号哦！</span>");
        return false;
    }
    if(!$("#store_add_alipay_account").val())
    {
        $("#store_add_tip_notice").html("<span style='font-size:14px; color:red'>亲，请填写支付宝账号哦！</span>");
        return false;
    }
    if(!$("#store_add_store_have_warehouse").val())
    {
        $("#store_add_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择仓库设置！</span>");
        return false;
    }
    if($("#store_add_store_have_warehouse").val()=="1")
    {
        if(!$("#store_add_warehouse_bianhao").val())
        {
            $("#store_add_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择仓库名称！</span>");
            return false;
        }
    }
        
    $.ajax({
        url:"post-store-add", 
        async: false,
        type: "POST",
        data:$('#store_add_form').serialize(),
        success: function(html){
            if (parseInt(html)==1001)
            {
                alert("此档口已存在！");
                return false;            
            }
            else
            {
                layer.close(index_layerstatus);
                layer.msg("添加成功！", {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_store_list',1,'frame_store');
                },2000);
            }
        }
    });    
}

    $("#layer_store_add").on('keydown',function(e){
        if(e.keyCode == 13){
        //模拟点击登陆按钮，触发上面的 Click 事件
        $('#layer_store_add input,select').blur();
        $("#store_add_affirm_btn").click();
        }
    });


function ShowStoreModifyLayer(dangkou_bianhao){
    $.ajax({
        url:"view-get-store-modify", 
        async: false,
        type: "POST",
        data:{var_dangkou_bianhao:dangkou_bianhao},
        success: function(html){
            $("#layer_store_modify").html(html);
        }
    });    
    
    index_layer_store_modify=layer.open({
        type: 1,
        area: ['720px', '500px'],
        title: false,
        content:$('#layer_store_modify')
    });
}

function PostStoreModify(){ 
    if(!$("#store_modify_store_market").val())
    {
        $("#store_modify_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择所在市场哦！</span>");
        return false;
    }
    if(!$("#store_modify_store_layer").val())
    {
        $("#store_modify_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择所在楼层哦！</span>");
        return false;
    }
    if(!$("#store_modify_store_place").val())
    {
        $("#store_modify_tip_notice").html("<span style='font-size:14px; color:red'>亲，请填写档口编号哦！</span>");
        return false;
    }
    if(!$("#store_modify_store_have_warehouse").val())
    {
        $("#store_modify_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择仓库设置！</span>");
        return false;
    }
    if($("#store_modify_store_have_warehouse").val()=="1")
    {
        if(!$("#store_modify_warehouse_bianhao").val())
        {
            $("#store_modify_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择仓库名称！</span>");
            return false;
        }
    }
        
    $.ajax({
        url:"post-store-modify", 
        async: false,
        type: "POST",
        data:$('#store_modify_form').serialize(),
        dataType:"json",
        success: function(html){
            if (html["state"]=="ok")
            {
                layer.close(index_layer_store_modify);
                layer.msg("修改成功！", {time: 2000, icon:1});
                mount_to_frame('view_store_list',1,'frame_store');
            }
            else
            {
                layer.msg(html["desc"], {time: 2000, icon:2});
            }
        }
    });    
}

function ShowStorePaymentLayer(){
    index_layerstorepayment=layer.open({
        type: 1,
        area: ['720px', '300px'],
        title: false,
        content:$('#layer_store_payment')
    });
}

function ShowStoreFundaccountLayer(dangkou_bianhao){
    $.ajax({
        url:"view-get-fundaccount", 
        async: false,
        type: "POST",
        data:{var_dangkou_bianhao:dangkou_bianhao},
        success: function(html){
            $("#layer_store_fundaccount").html(html);
        }
    });    
    
    index_layer_store_fundaccount=layer.open({
        type: 1,
        area: ['520px', '400px'],
        title: false,
        content:$('#layer_store_fundaccount')
    });
}

function PostStoreFundaccount(){     
    if(!$("#store_cash_init").val())
    {
        $("#store_fundaccount_tip_notice").html("<span style='font-size:12px; color:red'>亲，初始预留资金必填！</span>");
        return false;
    }
        
    $.ajax({
        url:"post-store-fundaccount", 
        async: false,
        type: "POST",
        data:$('#fundaccountmodifyform').serialize(),
        success: function(html){
            layer.close(index_layer_store_fundaccount);
            layer.msg("资金账户设置成功！", {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_store_list',1,'frame_store');
            },2000);
        }
    });    
}
</script>