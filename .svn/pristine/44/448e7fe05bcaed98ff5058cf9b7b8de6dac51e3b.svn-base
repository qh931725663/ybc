<?php

include_once("check_dangkou_user.php");
?>
                <div class="search_box">
                    <div class="search_box_inner">
                        <div class="rt">
                            <span class="btn_normal_blue" onclick="/**/ShowAddWarehouseLayer()">添加仓库</span>
                        </div>
                    </div>        
                    <div class="report_table_header" style="margin-top:20px; background:#f2f2f2">
                        <div style="width:50%; color:#999999">仓库名称</div>
                        <div style="width:30%; color:#999999">添加时间</div>
                        <div style="width:20%; color:#999999">操作</div>
                    </div>
                    <div id="pagelist" >
                    
                    
<?php
$p=cselect("*","ydf_dangkou",array("dangkou_type='2' and dangkou_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]),"","dangkou_bianhao desc");
while ($rowpagedata=$p[0]->fetch())
{
?>
                        <div class="report_table_body" style=" border-bottom:1px solid #cccccc">
                            <div style="position:relative; width:100%; overflow:hidden; display:block">
                                <div style="float:left;width:50%; padding:10px 0; text-align:center"><?php echo $rowpagedata["dangkou_name"] ?></div>
                                <div style="width:30%; float:left; padding:10px 0; text-align:center"><?php echo date("Y-m-d H:i:s",$rowpagedata["dangkou_addtime"]); ?></div>
                                <div style="width:20%; float:left; padding:10px 0; text-align:center"><span style="color:#0099FF; cursor:pointer" onclick="/**/ShowModifyWarehouseLayer(<?php echo $rowpagedata["dangkou_bianhao"]?>)">修改</span> <span style="color:#0099FF; cursor:pointer; display:none;" onclick="/**/DeleteWarehouse(<?php echo $rowpagedata["dangkou_bianhao"]?>)">删除</span></div>
                            </div>
                            <div style="width:100%; text-align:center; padding:10px 0; border-top:1px dashed #cccccc; overflow:hidden; display:block">
                                <span style="color:#999999">仓库联系方式：</span><?php echo $rowpagedata["dangkou_manager"]."，".$rowpagedata["dangkou_mobile"]."，".$rowpagedata["dangkou_address"]?>
                            </div>
                        </div>
<?php
}
?>
                    
                    
                    </div>


                    <div id="layer_add_warehouse">
                        <form method="post" id="warehouse_add_form">
                        <div>
                            <span class="sp_a"><span style="color:red">*</span> 仓库名称：</span>
                            <span class="sp_b"><input class="iinput" id="warehouse_add_warehouse_name" name="warehouse_add_warehouse_name" type="text" maxlength="50" style="width:200px; padding:5px 0"></span>
                        </div>
                        <div>
                            <span class="sp_a"><span style="color:red">*</span> 仓库联系人姓名：</span>
                            <span class="sp_b"><input class="iinput" id="warehouse_add_warehouse_manager" name="warehouse_add_warehouse_manager" type="text" maxlength="50" style="width:100px; padding:5px 0"></span>
                        </div>
                        <div>
                            <span class="sp_a"><span style="color:red">*</span> 仓库联系人手机号码：</span>
                            <span class="sp_b"><input class="iinput" id="warehouse_add_warehouse_mobile" name="warehouse_add_warehouse_mobile" type="text" maxlength="50" style="width:200px; padding:5px 0"></span>
                        </div>
                        <div>
                            <span class="sp_a"><span style="color:red">*</span> 仓库详细地址：</span>
                            <span class="sp_b"><input class="iinput" id="warehouse_add_warehouse_address" name="warehouse_add_warehouse_address" type="text" maxlength="255" style="width:400px; padding:5px 0"></span>
                        </div>
                        <div style="width:75%; margin:20px 0 0 25%" class="dp of lf">
                            <span id="warehouse_add_tip_notice" class="lf"></span>
                        </div>
                        <div style="width:75%; margin:20px 0 0 25%" class="lf of dp">
                            <span class="btn_normal" onclick="/**/PostAddWarehouse()" id="warehouse_add_affirm_btn"> 确认添加 </span>
                        </div>  
                        </form>            
                    </div>
                    
                    <div id="layer_modify_warehouse" style="float:left; width:650px; padding:25px; overflow:visible; display:none">
                    </div>

                </div>
                
<script type="text/javascript">    
function ShowAddWarehouseLayer(){
    index_layer_add_warehouse=layer.open({
        type: 1,
        area: ['720px', '450px'],
        title: false,
        content:$('#layer_add_warehouse')
    });
}

function PostAddWarehouse(){ 
    if(!$("#warehouse_add_warehouse_name").val())
    {
        $("#warehouse_add_tip_notice").html("<span style='font-size:14px; color:red'>亲，仓库名称不能为空哦！</span>");
        return false;
    }
    
    if(!$("#warehouse_add_warehouse_manager").val())
    {
        $("#warehouse_add_tip_notice").html("<span style='font-size:14px; color:red'>亲，请填写档口联系人姓名哦！</span>");
        return false;
    }
    if(!$("#warehouse_add_warehouse_mobile").val())
    {
        $("#warehouse_add_tip_notice").html("<span style='font-size:14px; color:red'>亲，请填写档口联系人手机号码哦！</span>");
        return false;
    }
    if(!$("#warehouse_add_warehouse_address").val())
    {
        $("#warehouse_add_tip_notice").html("<span style='font-size:14px; color:red'>亲，请填写档口详细地址哦！</span>");
        return false;
    }
        
    $.ajax({
        url:"post-add-warehouse", 
        async: false,
        type: "POST",
        data:$('#warehouse_add_form').serialize(),
        success: function(html){
            if (parseInt(html)==1001)
            {
                alert("仓库名称不能与档口名称相同！");
                return false;            
            }
            else if (parseInt(html)==1002)
            {
                alert("仓库名称已存在！");
                return false;            
            }
            else
            {
                layer.close(index_layer_add_warehouse);
                layer.msg("添加成功！", {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_warehouse_list',1,'frame_warehouse');
                },2000);
            }
        }
    });    
}

$('#layer_add_warehouse').on('keyup',function(e){

            if(e.keyCode == 13){
                //模拟点击登陆按钮，触发上面的 Click 事件
                $('#layer_add_warehouse input,select').blur();
                $("#warehouse_add_affirm_btn").click(
                );
            }
        });

function ShowModifyWarehouseLayer(warehouse_bianhao)
{
    $.ajax({
        url:"get-modify-warehouse", 
        async: false,
        type: "POST",
        data:{var_warehouse_bianhao:warehouse_bianhao},
        success: function(html){
            $("#layer_modify_warehouse").html(html);
        }
    });
    
    index_layer_modify_warehouse=layer.open({
        type: 1,
        area: ['720px', '450px'],
        title: false,
        content:$('#layer_modify_warehouse')
    });
}

function PostModifyWarehouse(warehouse_bianhao){ 
    if(!$("#warehouse_modify_warehouse_name_"+warehouse_bianhao).val())
    {
        $("#warehouse_modify_tip_notice_"+warehouse_bianhao).html("<span style='font-size:14px; color:red'>亲，仓库名称不能为空哦！</span>");
        return false;
    }
    
    if(!$("#warehouse_modify_warehouse_manager_"+warehouse_bianhao).val())
    {
        $("#warehouse_modify_tip_notice_"+warehouse_bianhao).html("<span style='font-size:14px; color:red'>亲，请填写档口联系人姓名哦！</span>");
        return false;
    }
    if(!$("#warehouse_modify_warehouse_mobile_"+warehouse_bianhao).val())
    {
        $("#warehouse_modify_tip_notice_"+warehouse_bianhao).html("<span style='font-size:14px; color:red'>亲，请填写档口联系人手机号码哦！</span>");
        return false;
    }
    if(!$("#warehouse_modify_warehouse_address_"+warehouse_bianhao).val())
    {
        $("#warehouse_modify_tip_notice_"+warehouse_bianhao).html("<span style='font-size:14px; color:red'>亲，请填写档口详细地址哦！</span>");
        return false;
    }
        
    $.ajax({
        url:"post-modify-warehouse", 
        async: false,
        type: "POST",
        data:$('#warehouse_modify_form').serialize(),
        success: function(html){
            if (parseInt(html)==1001)
            {
                alert("仓库名称不能与档口名称相同！");
                return false;            
            }
            else if (parseInt(html)==1002)
            {
                alert("仓库名称已存在！");
                return false;            
            }
            else
            {
                layer.close(index_layer_modify_warehouse);
                layer.msg("修改成功！", {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_warehouse_list',1,'frame_warehouse');
                },2000);
            }
        }
    });    
}

function DeleteWarehouse(dangkou_bianhao){
    if(confirm("确定要删除当前的信息吗？"))
    {
    
        $.ajax({
            url:"delete-warehouse", 
            async: false,
            type: "POST",
            data:{var_dangkou_bianhao:dangkou_bianhao},
            success: function(html){
                layer.msg('删除成功！', {time: 2000, icon:1});
                setTimeout(function(){
                    mount_to_frame('view_warehouse_list',1,'frame_warehouse');
                },2000);
            }
        });
    }    
}
</script>