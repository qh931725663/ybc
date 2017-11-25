<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_bill.php");
?>

                <div class="search_box">
                    <div class="search_box_inner" style="margin:10px 0 0; padding:0">
                        <div style="float:right">
                            <span class="btn_normal_blue" onclick="/**/ShowAddFactoryLayer()">添加工厂</span>
                        </div>
                    </div>        
                    <div class="report_table_header" style="margin-top:20px; background:#f2f2f2">
                        <div style="width:15%;">工厂名称</div>
                        <div style="width:15%;">手机号</div>
                        <div style="width:14%;">添加时间</div>
                        <div style="width:14%;">代销账期</div>
                        <div style="width:12%; display:none">代销初始交易中资金</div>
                        <div style="width:12%; display:none">代销初始可提现资金</div>
                        <div style="width:14%;">经销初始应付资金</div>
                        <div style="width:14%;">工厂管理</div>
                        <div style="width:14%;">操作</div>
                    </div>
                    <div id="pagelist" style="float:left; width:100%; overflow:hidden; display:block">
                    
                    
<?php
$p=cselect("*","ydf_factory",array("factory_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","factory_addtime desc");
while ($rowpagedata=$p[0]->fetch())
{
    $arr_factory_fund_init_bill=get_factory_fund_init_bill($rowpagedata["factory_bianhao"]);
?>
                        <div class="report_table_body" style="border-bottom:1px dashed #cccccc">
                            <div style="width:15%;"><?php echo $rowpagedata["factory_name"] ?></div>
                            <div style="width:15%;"><?php echo $rowpagedata["factory_mobile"] ?></div>
                            <div style="width:14%;"><?php echo date("Y-m-d",$rowpagedata["factory_addtime"]); ?></div>
                            <div style="width:14%; color:#ee583d;"><?php echo $rowpagedata["factory_cycle"]>"0"?$rowpagedata["factory_cycle"]:"-" ?></div>
                            <div style="width:12%; display:none"><?php echo $arr_factory_fund_init_bill["freeze_fund"] ?></div>
                            <div style="width:12%; display:none"><?php echo $arr_factory_fund_init_bill["active_fund"] ?></div>
                            <div style="width:14%;"><?php echo $arr_factory_fund_init_bill["payable_fund"] ?></div>
                            <div style="width:14%;">
                                <?php
                                if ($rowpagedata["factory_manage"]=="1")
                                {
                                ?>
                                <span style="color:#009900">启用</span>
                                <?php
                                }
                                elseif ($rowpagedata["factory_manage"]=="2")
                                {
                                ?>
                                <span style="color:#d64126">禁用</span>
                                <?php
                                }
                                ?>
                            </div>
                            <div style="float:left;width:14%; padding:10px 0; text-align:center"><span style="color:#0099FF; cursor:pointer" onclick="/**/ShowModifyFactoryLayer(<?php echo $rowpagedata["factory_bianhao"]?>)">修改</span> <span style="color:#0099FF; cursor:pointer; display:none" onclick="/**/DeleteFactory(<?php echo $rowpagedata["factory_bianhao"]?>)">删除</span></div>
                        </div>
<?php
}
?>
                    
                    
                    </div>


                    <div id="layer_addfactory" style="float:left; width:400px; padding:25px; overflow:visible; display:none">
                        <form id="vform_add_factory">
                        <div style="float:left; width:100%; line-height:1.8; overflow:hidden; display:block">
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 工厂名称：</span>
                                <span style="float:left;">
                                <input class="iinput" autocomplete="off" name="factory_name" id="factory_name" type="text" maxlength="50" style="width:150px; padding:5px"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 手机号：</span>
                                <span style="float:left;">
                                <input class="iinput" autocomplete="off" name="factory_mobile" id="factory_mobile" type="text" maxlength="50" style="width:150px; padding:5px"/>
                                </span>
                            </p>
                            <p style="float:left; width:100%; padding:5px 0; display:block">
                                <span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right">代销账期：</span>
                                <span style="float:left;">
                                    <select id="factory_cycle" name="factory_cycle" style="padding:5px">
                                      <option value="" selected>请选择</option>
                                      <option value="1">1天</option>
                                      <option value="5">5天</option>
                                      <option value="10">10天</option>
                                      <option value="15">15天</option>
                                      <option value="20">20天</option>
                                      <option value="30">30天</option>
                                    </select>
                                </span>
                            </p>
							<p style="float:left; width:100%; padding:5px 0; display:block">
								<span style="float:left; width:150px; color:#999999; margin:5px 0; text-align:right">经销初始应付资金：</span>
								<span style="float:left;">
								<input name="factory_fund_payable" id="factory_fund_payable" type="text" maxlength="50" style="width:100px; padding:5px" value="0"/>
								</span>
							</p>
                        </div>
                        <div style="float:left; margin:20px 0 0 150px; overflow:hidden; display:block">
                            <span id="tip_add_factory" style="float:left"></span>
                        </div>
                        <div style="float:left; margin:20px 0 0 150px; overflow:hidden; display:block">
                            <span id="add_factory_affirm_btn" onclick="/**/PostAddFactory()" class="btn_normal">确认添加</span>
                        </div>    
                        <input type="hidden" name="op" value="insert" id="add_factory_affirm_btn">
                        </form>            
                    </div>
                    
                    <div id="layer_modifyfactory" style="float:left; width:400px; padding:25px; overflow:visible; display:none">
            
                    </div>

                </div>
                
<script type="text/javascript">
function ShowAddFactoryLayer(){
    index_layer_addfactory=layer.open({
        type: 1,
        area: ['500px', '500px'],
        title: false,
        content:$('#layer_addfactory')
    });
}

function PostAddFactory(){ 
    if(!$("#factory_name").val())
    {
        $("#tip_add_factory").html("<span style='font-size:12px; color:red'>亲，工厂名称不能为空哦！</span>");
        return false;
    }
    
    if(!$("#factory_mobile").val())
    {
        $("#tip_add_factory").html("<span style='font-size:12px; color:red'>亲，手机号码不能为空哦！</span>");
        return false;
    }
        
    $.ajax({
        url:"model-factory-api", 
        async: false,
        type: "POST",
        dataType:"json",
        data:$("#vform_add_factory").serialize(),
        error:function(){
            layer.close(index_layer_addfactory);
            layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
        },
        success: function(html){
            layer.close(index_layer_addfactory);
            if (html.state!="ok"){
                layer.msg('提交失败！', {time: 2000, icon:2});
                return;
            }
            layer.msg('提交成功！', {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_factory_list',1,'frame_factory');
            },0);
        }
    });    
}

 $("#layer_addfactory").on("keydown",function(e){
    if(e.keyCode == 13){
        $('#layer_addfactory input,select').blur();
        $("#add_factory_affirm_btn").trigger("click");
    }
});


function ShowModifyFactoryLayer(factory_bianhao)
{
    $.ajax({
        url:"view-get-modifyfactory", 
        async: false,
        type: "POST",
        data:{var_factory_bianhao:factory_bianhao},
        success: function(html){
            $("#layer_modifyfactory").html(html);
        }
    });
    
    index_layer_modifyfactory=layer.open({
        type: 1,
        area: ['500px', '600px'],
        title: false,
        content:$('#layer_modifyfactory')
    });
    setTimeout("$('.layui-layer-close').click(function(){layer.close(index_layer_modifyfactory);})",500);
}

function PostModifyFactory(){ 
    if(!$("#modify_factory_name").val())
    {
        $("#tip_modify_factory").html("<span style='font-size:12px; color:red'>亲，工厂名称不能为空哦！</span>");
        return false;
    }
    
    if(!$("#modify_factory_mobile").val())
    {
        $("#tip_modify_factory").html("<span style='font-size:12px; color:red'>亲，手机号码不能为空哦！</span>");
        return false;
    }
        
    $.ajax({
        url:"model-factory-api", 
        async: false,
        type: "POST",
        dataType:"json",
        data:$("#vform_modify_factory").serialize(),
        error:function(){
            layer.close(index_layer_modifyfactory);
            layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
        },
        success: function(html){
            layer.close(index_layer_modifyfactory);
            if (html.state!="ok"){
                layer.msg('提交失败！', {time: 2000, icon:2});
                return;
            }
            layer.msg('提交成功！', {time: 2000, icon:1});
            setTimeout(function(){
                mount_to_frame('view_factory_list',1,'frame_factory');
            },0);
        }
    });
}

function DeleteFactory(factory_id){
    if(confirm("确定要删除选中的信息吗？一旦删除将不能恢复！"))
    {
        $.ajax({
            url:"model-factory-api", 
            async: false,
            type: "POST",
            dataType:"json",
            data:{op:"delete",factory_id:factory_id},
            error:function(){
                layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
            },
            success: function(html){
                if (html.state!="ok"){
                    layer.msg('删除失败！', {time: 2000, icon:2});
                    return;
                }
                layer.msg('删除成功！', {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_factory_list',1,'frame_factory');
                },0);
            }
        });   
    } 
}
</script>