<?php

include_once("check_dangkou_user.php");
?>

                        <?php
                        if ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1")
                        {
                        ?>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span style="float:left; width:120px; padding-top:8px; text-align:right">调拨到仓库：</span>
                            <span style="float:left;margin-left:10px">
                                <select id="diaobochuku_select_store" name="diaobochuku_select_store" style="padding:5px">    
                                    <option value="">选择</option>    
                                    <?php
                                    $rsdata=mysql_query("select * from ydf_dangkou where dangkou_type='2' and dangkou_boss_m_bianhao = '".$_SESSION["ERP_ACCOUNT_LOGIN_BIANHAO"]."' order by dangkou_bianhao desc", $dbconn);
                                    while($rowdata = mysql_fetch_array($rsdata))
                                    {
                                    ?>
                                    <option value="<?php echo $rowdata["dangkou_bianhao"]?>"><?php echo $rowdata["dangkou_name"]?></option>    
                                    <?php
                                    }
                                    ?>
                                </select>
                            </span>
                        </div>
                        <?php
                        }
                        elseif ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="2")
                        {
                        ?>
                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span style="float:left; width:120px; padding-top:8px; text-align:right">调拨到档口：</span>
                            <span style="float:left;margin-left:10px">
                                <select id="diaobochuku_select_store" name="diaobochuku_select_store" style="padding:5px">    
                                    <option value="">选择</option>    
                                    <?php
                                    $rsdata=mysql_query("select * from ydf_dangkou where dangkou_type='2' and dangkou_boss_m_bianhao = '".$_SESSION["ERP_ACCOUNT_LOGIN_BIANHAO"]."' order by dangkou_bianhao desc", $dbconn);
                                    while($rowdata = mysql_fetch_array($rsdata))
                                    {
                                    ?>
                                    <option value="<?php echo $rowdata["dangkou_bianhao"]?>"><?php echo $rowdata["dangkou_name"]?></option>    
                                    <?php
                                    }
                                    ?>            
                                </select>
                            </span>
                        </div>
                        <?php
                        }
                        ?>

                        <div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block">
                            <span style="float:left; margin-left:130px; padding:7px 20px; background:#ee583d; color:#FFFFFF; cursor:pointer" onclick="PostDiaobochukuSelectStore()">下一步</span>
                        </div>
                        
<script type="text/javascript">    
function PostDiaobochukuSelectStore(){
    if  ($("#diaobochuku_select_store").val()=="")
    {
        <?php
        if ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="1")
        {
        ?>
        alert("请先选择调拨到仓库！");
        <?php
        }
        elseif ($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]=="2")
        {
        ?>
        alert("请先选择调拨到档口！");
        <?php
        }
        ?>
        return false;
    }
    
    $.ajax({
        url:"getdiaobochukustore", 
        async: false,
        type: "POST",
        data:{var_diaobo_to_store:$("#diaobochuku_select_store").val()},
        dataType:"json",
        success: function(html){
            order_diaobo_to_store_bianhao=html["order_diaobo_to_store_bianhao"];
            order_diaobo_to_store_name=html["order_diaobo_to_store_name"];
            
            $.ajax({
                url:"getselectdiaobochukuorderlist", 
                async: false,
                type: "POST",
                data:"",
                success: function(html){
                    $("#layer_store_manage").html(html);
                }
            });
        }
    });
}
</script>