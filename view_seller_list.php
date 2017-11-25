<?php

include_once("check_dangkou_user.php");
include_once("{$root_path}/model/model_seller.php");
update_seller_cycle();
?>
<script type="text/javascript">    


function list_seller()
{
    $('#seller_searchwords').css("color","#cccccc");
    $("#pid_view_seller_list #pages_seller").set_page_num("view_seller_list","pages_seller",1);
	
    refresh_inner("view_seller_list?"+$("#form_seller").serialize() );
}

function search_seller()
{
	$("#btn_seller_search").parent().prev().find(".listtypevalue").removeClass('listtypeselect');
	
    $("#pid_view_seller_list #pages_seller").set_page_num("view_seller_list","pages_seller",1);

    refresh_inner("view_seller_list?"+$("#form_seller").serialize() );
}

function click_me_seller(obj,state)
{
	obj.parent().find(".listtypevalue").removeClass('listtypeselect');
    obj.addClass("listtypeselect");

    list_seller();
}
</script>
<form id="form_seller">
<div style="float:left; width:100%; overflow:hidden; display:block">
	<div style="float:left; width:100%; margin-top:20px; overflow:hidden; display:block">
		<div style="float:left; overflow:hidden; display:block">
			<span style="float:left"><input id="seller_searchwords" name="seller_searchwords" class="iinput name_iime ino_ime_input iseller_name" type="text" style="width:150px; padding:5px;" placeholder="请输入卖家拼音首字母"/></span>
			<span id="btn_seller_search" onclick="/**/search_seller()" class="btn_normal_blue public_search">搜索</span>
            <span class="clear_search" onclick="mount_to_frame('view_seller_list',1,'frame_seller_list')">清空<br>条件</span>
		</div>
		<div style="float:right">
			<span id="btn_sellerlist_addseller" class="btn_normal_blue" onclick="/**/ShowAddSellerLayer()">添加卖家</span>
		</div>
	</div>
	<div style="position:relative; float:left; width:100%; margin-top:20px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
		<div style="float:left;width:20%; padding:10px 0; text-align:center">昵称</div>
		<div style="float:left;width:20%; padding:10px 0; text-align:center">手机号</div>
		<div style="float:left;width:15%; padding:10px 0; text-align:center">结算类型</div>
		<div style="float:left;width:15%; padding:10px 0; text-align:center">添加时间</div>
		<div style="float:left;width:10%; padding:10px 0; text-align:center">大客户</div>
		<div style="float:left;width:20%; padding:10px 0; text-align:center;">操作</div>
	</div>
<!-- refresh_begin -->
<?php
@$seller_searchwords=$_REQUEST["seller_searchwords"]=="请输入卖家昵称"?null:$_REQUEST["seller_searchwords"];
$where=@array("seller_boss_m_bianhao=? and seller_name=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"],$seller_searchwords,$seller_searchwords);
$where=clean_where($where);

@$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;
$pagesize=20;
$offset=($page-1)*$pagesize; 
$p=cselect("*","ydf_seller",$where,"","seller_bianhao desc",$offset,$pagesize);
$rowcount=$p[1];
$page_count=ceil($rowcount/$pagesize);  
while ($rowpagedata=$p[0]->fetch())
{
?>
	<div class="report_table_body" style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
		<div style="float:left;width:20%; padding:10px 0; text-align:center"><?php echo $rowpagedata["seller_name"] ?></div>
		<div style="float:left;width:20%; padding:10px 0; text-align:center"><?php echo $rowpagedata["seller_mobile"] ?></div>
		<div style="float:left;width:15%; padding:10px 0; text-align:center"><?php echo $rowpagedata["seller_cycle"]>"0"?"<span style='color:#d64126'>账期</span>":"<span style='color:#009900'>现结</span>"; ?></div>
		<div style="float:left;width:15%; padding:10px 0; text-align:center"><?php echo date("Y-m-d",$rowpagedata["seller_addtime"]); ?></div>
		<div style="float:left;width:10%; padding:10px 0; text-align:center">
			<?php
			if ($rowpagedata["seller_isvip"]=="1")
			{
			?>
			<span style="color:#009900; cursor:pointer" onclick="SetSellerVip(<?php echo $rowpagedata["seller_bianhao"]?>,0)">是</span>
			<?php
			}
			elseif ($rowpagedata["seller_isvip"]=="0")
			{
			?>
			<span style="color:#0099FF; cursor:pointer" onclick="SetSellerVip(<?php echo $rowpagedata["seller_bianhao"]?>,1)">否</span>
			<?php
			}
			?>
		</div>
		<div style="float:left;width:20%; padding:10px 0; text-align:center">
			<span style="color:#0099FF; cursor:pointer" onclick="ShowSellerSetPriceLayer(<?php echo $rowpagedata["seller_bianhao"]?>)">差价设置</span> | <span style="color:#0099FF; cursor:pointer" onclick="ShowModifySellerLayer(<?php echo $rowpagedata["seller_bianhao"]?>)">修改</span> <span style="color:#0099FF; cursor:pointer; display:none;" onclick="DeleteSeller(<?php echo $rowpagedata["seller_bianhao"]?>)">删除</span>
		</div>
	</div>
<?php
}
?>
	
	<div style="float:right; margin-top:5px; font-size:14px"> 共 <span style="font-size:14px; color:#d51938; font-weight:bold;"><?php echo $rowcount?></span> 个卖家</div>

<script>/*n*//*n*/    
    $("#pid_view_seller_list #pages_seller").set_page_count("view_seller_list","pages_seller",<?php echo $page_count;?>);
</script>
</div>
<!-- refresh_end -->                    
    <div class="ipages" id="pages_seller" page="view_seller_list" form="form_seller" count="<?php echo $page_count; ?>"/>

</form> <!-- 页码也作为表单项统一处理  -->

<div id="layer_addseller" style="float:left; width:350px; padding:25px; overflow:visible; display:none">
	<div style="float:left; width:100%; line-height:1.8; overflow:visible; display:block">
		<p style="float:left; width:100%; padding:5px 0; display:block">
			<span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 手机号：</span>
			<span style="float:left;">
			<input name="seller_mobile" id="seller_mobile" type="text" maxlength="50" style="width:150px; padding:5px"/>
			</span>
		</p>
		<p style="float:left; width:100%; padding:5px 0; display:block">
			<span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 卖家昵称：</span>
			<span style="float:left;">
			<input name="seller_name" id="seller_name" type="text" maxlength="50" style="width:150px; padding:5px"/>
			</span>
		</p>
		<p style="float:left; width:100%; padding:5px 0; display:block">
			<span style="float:left; width:80px; color:#999999; margin:5px 0; text-align:right"><span style="color:red">*</span> 结算类型：</span>
			<span style="float:left;">
				<select id="seller_cycle" name="seller_cycle" style="padding:5px">
				  <option value="" selected>请选择</option>
				  <option value="0">现结</option>
				  <option value="7">账期</option>
				</select>
			</span>
		</p>
	</div>
	<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
		<span id="add_seller_tip_notice" style="float:left;margin-left:80px"></span>
	</div>
	<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
		<span id="add_seller_affirm_btn" onclick="PostAddSeller()" style="float:left; margin-left:80px; margin-bottom:50px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer">确认添加</span>
	</div>				
</div>
						
<div id="layer_modifyseller" style="float:left; width:350px; padding:25px; overflow:visible; display:none">

</div>

<div id="layer_sellergoods" style="float:left; width:550px; padding:25px; overflow:visible; display:none">

</div>
						
<script type="text/javascript">
var listtype="sellerlist";


function ShowAddSellerLayer(){
	index_layer_addseller=layer.open({
		type: 1,
		area: ['420px', '300px'],
		title: false,
		content:$('#layer_addseller')
	});
}

var tianjiamaijia = 0;
function PostAddSeller(){ 
	if(!$("#seller_mobile").val())
	{
		$("#add_seller_tip_notice").html("<span style='font-size:14px; color:red'>亲，卖家手机不能为空哦！</span>");
		return false;
	}
	
	if(!$("#seller_name").val())
	{
		$("#add_seller_tip_notice").html("<span style='font-size:14px; color:red'>亲，卖家昵称不能为空哦！</span>");
		return false;
	}
	
	if(!$("#seller_cycle").val())
	{
		$("#add_seller_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择卖家账期哦！</span>");
		return false;
	}
		
	$.ajax({
		url:"model-post-addseller", 
		async: false,
		type: "POST",
		data:{var_seller_mobile:$("#seller_mobile").val(),var_seller_name:$("#seller_name").val(),var_seller_cycle:$("#seller_cycle").val()},
		dataType:"json",
		success: function(html){
			if (html["state"]=="ok")
			{
				layer.close(index_layer_addseller);
				layer.msg("卖家添加成功！", {time: 2000, icon:1});
				tianjiamaijia=1;
				$("#shandianchuhuo").on("click",function(){
					if(tianjiamaijia==1){
                    	mount_to_frame('frame_cashier',1);
                    }
                    tianjiamaijia=0;
                    if(tianjiamaijia==1){
                    	mount_to_frame('frame_cashier');
                    }
				});


				setTimeout(function(){
					MenuLinkClick('view_seller_list',1,'frame_seller');
				},2000);
				refresh_inner("view_seller_list?"+$("#form_seller").serialize() );

			}
			else
			{
				$("#add_seller_tip_notice").html("<span style='font-size:14px; color:red'>"+html["desc"]+"</span>");
			}
		}
	});	
}


function ShowModifySellerLayer(seller_bianhao){
	$.ajax({
		url:"view-get-modifyseller", 
		async: false,
		type: "POST",
		data:{var_seller_bianhao:seller_bianhao},
		success: function(html){
			$("#layer_modifyseller").html(html);
		}
	});	
	
	index_layermodifyseller=layer.open({
		type: 1,
		area: ['420px', '300px'],
		title: false,
		content:$('#layer_modifyseller')
	});
}

function PostModifySeller(){ 
	if(!$("#modifyseller_seller_mobile").val())
	{
		$("#modify_seller_tip_notice").html("<span style='font-size:14px; color:red'>亲，卖家手机不能为空哦！</span>");
		return false;
	}
	
	if(!$("#modifyseller_seller_name").val())
	{
		$("#modify_seller_tip_notice").html("<span style='font-size:14px; color:red'>亲，卖家昵称不能为空哦！</span>");
		return false;
	}
	
	if(!$("#modifyseller_seller_name").val())
	{
		$("#modify_seller_tip_notice").html("<span style='font-size:14px; color:red'>亲，请选择卖家结算周期哦！</span>");
		return false;
	}
		
	$.ajax({
		url:"model-post-modifyseller", 
		async: false,
		type: "POST",
		data:$('#modifysellerform').serialize(),
		dataType:"json",
		success: function(html){
			if (html["state"]=="ok")
			{
				layer.close(index_layermodifyseller);
				layer.msg("卖家修改成功！", {time: 2000, icon:1});
				setTimeout(function(){
					refresh_inner("view_seller_list?"+$("#form_seller").serialize() );
				},2000);
				refresh_inner("view_seller_list?"+$("#form_seller").serialize() );
			}
			else
			{
				$("#modify_seller_tip_notice").html("<span style='font-size:14px; color:red'>"+html["desc"]+"</span>");
			}
		}
	});	
}

function SetSellerVip(seller_bianhao, seller_vip){
	var setsellervip_message="确定要设置当前的信息吗？";
	if (seller_vip==0)
	{
	 	setsellervip_message="确定要取消当前卖家的大客户设置吗？";
	}
	else if (seller_vip==1)
	{
		setsellervip_message="确定要设置当前卖家为大客户吗？";
	}
	
	if(confirm(setsellervip_message))
	{
		$.ajax({
			url:"set-sellervip", 
			async: false,
			type: "POST",
			data:{var_seller_bianhao:seller_bianhao,var_seller_vip:seller_vip},
			success: function(html){
				layer.msg("设置成功！", {time: 2000, icon:1});
				setTimeout(function(){
					refresh_inner("view_seller_list?"+$("#form_seller").serialize());
				},2000);
			}
		});	
	}
}

function ShowSellerSetPriceLayer(seller_bianhao){
	$.ajax({
		url:"view-get-sellergoods", 
		async: false,
		type: "POST",
		data:{var_seller_bianhao:seller_bianhao},
		success: function(html){
			$("#layer_sellergoods").html(html);
		}
	});
	
	index_layersellergoods=layer.open({
		type: 1,
		area: ['620px', '500px'],
		title: false,
		content:$('#layer_sellergoods')
	});
}

function AddSellerGoods(seller_bianhao){
	if ($("#s_huohao_" + seller_bianhao).val()=="")
	{
		alert("请填写商品货号");
		return false;
	}
	if ($("#s_price_" + seller_bianhao).val()=="")
	{
		alert("请填写卖家指定价格");
		return false;
	}
	
	$.ajax({
		url:"model-post-addsellergoods", 
		async: false,
		type: "POST",
		data:{var_seller_bianhao:seller_bianhao,var_s_huohao:$("#s_huohao_" + seller_bianhao).val(),var_s_price:$("#s_price_" + seller_bianhao).val()},
		dataType:"json",
		success: function(html){
			if (html["state"]=="ok")
			{
				layer.close(index_layermodifyseller);
				layer.msg("卖家修改成功！", {time: 2000, icon:1});
				setTimeout(function(){
					refresh_inner("view_seller_list?"+$("#form_seller").serialize() );
				},2000);
			}
			else
			{
				alert(html["desc"]);
				return false;		
			}
		}
	});	
	
	$.ajax({
		url:"view-get-sellergoods", 
		async: false,
		type: "POST",
		data:{var_seller_bianhao:seller_bianhao},
		success: function(html){
			$("#layer_sellergoods").html(html);
		}
	});
}

function DeleteSellerGoods(seller_bianhao,seller_price_bianhao){
	if(confirm("确定要删除当前的卖家价格吗？"))
	{
	
		$.ajax({
			url:"model-delete-sellergoods", 
			async: false,
			type: "POST",
			data:{var_seller_price_bianhao:seller_price_bianhao},
			success: function(html){

			}
		});
		
		$.ajax({
			url:"view-get-sellergoods", 
			async: false,
			type: "POST",
			data:{var_seller_bianhao:seller_bianhao},
			success: function(html){
				$("#layer_sellergoods").html(html);
			}
		});
	}	
}

function DeleteSeller(seller_bianhao){
	if(confirm("确定要删除当前的信息吗？"))
	{
	
		$.ajax({
			url:"delete-seller", 
			async: false,
			type: "POST",
			data:{var_seller_bianhao:seller_bianhao},
			success: function(html){
				layer.msg('删除成功！', {time: 2000, icon:1});
				setTimeout(function(){
					MenuLinkClick('view_seller_list',1,'frame_seller');
				},2000);
				refresh_inner("view_seller_list?"+$("#form_seller").serialize() );
			}
		});
	}	
}

$("#layer_addseller").on("keydown",function(e){
    if(e.keyCode == 13){
        $('#layer_addseller input,select').blur();
        $("#add_seller_affirm_btn").trigger("click");
    }
});
</script>