<?php

include_once("check_dangkou_user.php");

$rsdangkou=mysql_query("select * from ydf_dangkou where dangkou_bianhao='".$_REQUEST["var_dangkou_bianhao"]."'", $dbconn);
$rowdangkou=mysql_fetch_array($rsdangkou);

$dangkou_warehouse_bianhao="";
$dangkou_warehouse_name="";
$sqldangkouwarehouse="select * from ydf_dangkou_warehouse where dangkou_warehouse_dangkou_bianhao='".$rowdangkou["dangkou_bianhao"]."'";
$rsdangkouwarehouse=mysql_query($sqldangkouwarehouse , $dbconn);    
if ($rowdangkouwarehouse=mysql_fetch_array($rsdangkouwarehouse))
{
    $rswarehouse=mysql_query("select * from ydf_dangkou where dangkou_bianhao='".$rowdangkouwarehouse["dangkou_warehouse_warehouse_bianhao"]."'", $dbconn);
    $rowwarehouse=mysql_fetch_array($rswarehouse);
    
    $dangkou_warehouse_bianhao=$rowwarehouse["dangkou_bianhao"];
    $dangkou_warehouse_name=$rowwarehouse["dangkou_name"];
}
?>
<form method="post" id="store_modify_form">
<div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
    <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 所在市场：</span>
    <span style="float:left; width:75%;">
         <select id="store_modify_store_market" name="store_modify_store_market" style="padding:5px">    
            <option value="">选择</option>
            <option <?php if ($rowdangkou["dangkou_market"]=="电商基地") { echo "selected"; } ?>>电商基地</option>
            <option <?php if ($rowdangkou["dangkou_market"]=="四季星座") { echo "selected"; } ?>>四季星座</option>
        </select>
    </span>
</div>
<div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
    <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 所在楼层：</span>
    <span style="float:left; width:75%;">
         <select id="store_modify_store_layer" name="store_modify_store_layer" style="padding:5px">    
            <option value="">选择</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="1") { echo "selected"; } ?>>1</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="2") { echo "selected"; } ?>>2</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="3") { echo "selected"; } ?>>3</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="4") { echo "selected"; } ?>>4</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="5") { echo "selected"; } ?>>5</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="6") { echo "selected"; } ?>>6</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="7") { echo "selected"; } ?>>7</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="8") { echo "selected"; } ?>>8</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="9") { echo "selected"; } ?>>9</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="10") { echo "selected"; } ?>>10</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="11") { echo "selected"; } ?>>11</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="12") { echo "selected"; } ?>>12</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="13") { echo "selected"; } ?>>13</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="14") { echo "selected"; } ?>>14</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="15") { echo "selected"; } ?>>15</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="16") { echo "selected"; } ?>>16</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="17") { echo "selected"; } ?>>17</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="18") { echo "selected"; } ?>>18</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="19") { echo "selected"; } ?>>19</option>
            <option <?php if ($rowdangkou["dangkou_layer"]=="20") { echo "selected"; } ?>>20</option>
        </select>
    </span>
</div>
<div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
    <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 档口编号：</span>
    <span style="float:left; width:75%;"><input class="iinput" id="store_modify_store_place" name="store_modify_store_place" type="text" maxlength="100" style="width:200px; padding:5px 0" value="<?php echo $rowdangkou["dangkou_place"]?>"> <span style="margin-left:5px; color:#999999">如：806，B368</span></span>
</div>
<div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
    <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 档口联系人姓名：</span>
    <span style="float:left; width:75%;"><input class="iinput" id="store_modify_store_manager" name="store_modify_store_manager" type="text" maxlength="50" style="width:100px; padding:5px 0" value="<?php echo $rowdangkou["dangkou_manager"]?>"></span>
</div>
<div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
    <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 档口联系人手机号码：</span>
    <span style="float:left; width:75%;"><input class="iinput" id="store_modify_store_mobile" name="store_modify_store_mobile" type="text" maxlength="50" style="width:200px; padding:5px 0" value="<?php echo $rowdangkou["dangkou_mobile"]?>"></span>
</div>
<div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
    <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 档口详细地址：</span>
    <span style="float:left; width:75%;"><input class="iinput" id="store_modify_store_address" name="store_modify_store_address" type="text" maxlength="255" style="width:400px; padding:5px 0" value="<?php echo $rowdangkou["dangkou_address"]?>"></span>
</div>
<div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
    <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 仓库设置：</span>
    <span style="float:left; width:75%;">
         <select id="store_modify_store_have_warehouse" name="store_modify_store_have_warehouse" style="padding:5px">    
            <option value="">选择</option>
            <option value="0"<?php echo $dangkou_warehouse_bianhao?"":" selected"; ?>>无</option>
            <option value="1"<?php echo $dangkou_warehouse_bianhao?" selected":""; ?>>有</option>
        </select>
    </span>
</div>
<div id="layer_store_modify_warehouse_set" style="position:relative; float:left; width:100%; display:<?php echo $dangkou_warehouse_bianhao?"block":"none"; ?>">
    <div style="position:relative; float:left; width:100%; margin-top:10px; padding:10px 0; display:block">
        <span style="float:left; width:25%; padding:5px 0; color:#999999; text-align:right"><span style="color:red">*</span> 仓库名称：</span>
        <span style="float:left; width:75%;">
             <select id="store_modify_warehouse_bianhao" name="store_modify_warehouse_bianhao" style="padding:5px">    
                <option value="">选择</option>
                <?php
                $rswarehouse=mysql_query("select * from ydf_dangkou where dangkou_type='2' and dangkou_boss_m_bianhao='".$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]."' order by dangkou_bianhao asc", $dbconn);
                while($rowwarehouse=mysql_fetch_array($rswarehouse))
                {
                ?>
                <option value="<?php echo $rowwarehouse["dangkou_bianhao"] ?>"<?php echo $dangkou_warehouse_bianhao==$rowwarehouse["dangkou_bianhao"]?" selected":""; ?>><?php echo $rowwarehouse["dangkou_name"] ?></option>
                <?php
                }
                ?>
            </select>
            <span style="margin-left:5px; color:#999999">请在仓库设置中新增更多仓库</span>
        </span>
    </div>
</div>
<div style="float:left; width:80%; margin:30px 0 0 25%; overflow:hidden; display:block">
    <span id="store_modify_tip_notice" style="float:left"></span>
</div>
<div style="float:left; width:80%; margin:20px 0 0 25%; overflow:hidden; display:block">
    <span id="store_modify_affirm_btn" class="btn_normal" onclick="PostStoreModify()"> 确认修改 </span>
</div>    
<input type="hidden" name="store_modify_store_bianhao" value="<?php echo $rowdangkou["dangkou_bianhao"]?>">
</form>    
<script type="text/javascript">    
$(function(){
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

$("#layer_store_modify").on('keydown',function(e){

            if(e.keyCode == 13){
                //模拟点击登陆按钮，触发上面的 Click 事件
                $('#layer_store_modify input,select').blur();
                $("#store_modify_affirm_btn").click(
                );
            }
        });
</script>