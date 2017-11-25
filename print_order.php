<?php

include_once("check_dangkou_user.php");

$rsorder=mysql_query("select * from ydf_order where order_bianhao='$order_bianhao'" , $dbconn);
$roworder=mysql_fetch_array($rsorder);

$order_type="";
if ($roworder["order_type"]=="xsck" or $roworder["order_type"]=="dkph" or $roworder["order_type"]=="ckph")
{
    $order_type="销售单";
}
elseif ($roworder["order_type"]=="thdj")
{
    $order_type="退货单";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>打印订单-优百仓档口管家！</title>
<link rel=stylesheet type=text/css href="/pc/css/print.css">
<style media="print">
.noprint
{
    display: none;
}
.PageNext
{
    page-break-after: always;
}
.page{
size: A3 landscape;  
}
</style>
</head>

<body>
<div style="width:100%; margin:50px auto 20px; auto; overflow:hidden; display:block">
    <div id="OrderContent" style="width:100%; overflow:hidden; display:block">
        <div style="width:100%; margin:0 auto; overflow:hidden; display:block">
            <div style="margin-left: auto; margin-right:auto; width:90%; overflow:hidden; display:block">
                <div style="float:left; width:100%; padding:5px 0; text-align:center; overflow:hidden; display:block">
                    <span style="font-size:14px; font-weight:bold; line-height:1.8"><?php echo $roworder["order_type"]=="ckph"?$roworder["order_slave_name"]:$roworder["order_master_name"] ?> <br><?php echo $order_type ?></span>
                </div>
                <div style="float:left; width:100%; overflow:hidden; display:block">
                    <div style="width:100%; margin:0 auto; padding:5px 0; font-size:12px; border-bottom:1px dashed #000000; overflow:hidden; display:block;">
                        <?php
                        if ($roworder["order_seller_bianhao"]>"1")
                        {
                        ?>
                        卖家：<?php echo $roworder["order_seller_name"]?>
                        <?php
                        }
                        else
                        {
                        ?>
                        匿名卖家
                        <?php
                        }
                        ?>
                    </div>
                    <div style="width:100%; margin:0 auto; padding:5px 0; font-size:12px; border-bottom:1px dashed #000000; overflow:hidden; display:block;">
                        编号：<?php echo $roworder["order_bianhao"];?> / <?php echo date("Y-m-d",$roworder["order_addtime"]);?>
                    </div>
                    <div style="width:100%; margin:0 auto; padding:5px 0; border-bottom:1px solid #000000; overflow:hidden; display:block;">
                        <div style="float:left; width:20%; font-size:12px">货号</div>
                        <div style="float:left; width:20%; font-size:12px; text-align:center">颜色</div>
                        <div style="float:left; width:20%; font-size:12px; text-align:center">尺码</div>
                        <div style="float:left; width:20%; font-size:12px; text-align:center">单价</div>
                        <div style="float:left; width:20%; font-size:12px; text-align:center">数量</div>
                    </div>
                <?php
                $shop_totalnum=0;
                $shop_totalprice=0;
                $rsitem = mysql_query("select * from ydf_order_detail where detail_order_bianhao='".$roworder["order_bianhao"]."' order by detail_p_bianhao, detail_p_color, detail_p_size", $dbconn); 
                while ($rowitem=mysql_fetch_array($rsitem))
                {
                    $shop_totalnum+=$rowitem["detail_order_num"];
                    $shop_totalprice+=$rowitem["detail_order_num"]*$rowitem["detail_price"];
                ?>        
                    <div style="width:100%; margin:0 auto; padding:5px 0; border-bottom:1px dashed #000000; overflow:hidden; display:block;">
                        <div style="float:left; width:20%; height:20px; font-size:12px"><?php echo $rowitem["detail_p_huohao"]?></div>
                        <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $rowitem["detail_p_color"]?></div>
                        <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $rowitem["detail_p_size"]?></div>
                        <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo intval($rowitem["detail_price"]) ?></div>
                        <div style="float:left; width:20%; height:20px; font-size:12px; text-align:center"><?php echo $rowitem["detail_order_num"]?></div>
                    </div>
                <?php
                }
                ?>
                    <div style="width:100%; padding:10px 0; overflow:hidden; display:block;">
                        <span style="font-size:12px">数量：<span style=" font-size:12px"><?php echo $shop_totalnum?></span>, 金额：<span style="font-size:12px"><?php echo $shop_totalprice?></span></span>
                    </div>
                </div>
            </div>
        </div>
        <div style="width:100%; margin:0 auto; padding-top:200px; font-size:12px; font-weight:bold; text-align:center; overflow:hidden; display:block">
        ------撕纸线------
        </div>
    </div>
</div>
<div style="position:fixed; top:0; left:0; width:100%; height:35px; border-bottom:2px solid #2796aa; background:#30c0db; display:block; z-index:1">
    <div style="float:left; width:49%; padding:10px 0; text-align:center; overflow:hidden; display:block"><span style="font-size:14px; font-weight:bold; color:#ffffff; cursor:pointer" onclick="printorder('OrderContent')">开始打印</span></div>
    <div style="float:left; width:49%; padding:10px 0; text-align:center; overflow:hidden; display:block"><span style="font-size:14px; font-weight:bold; color:#ffffff; cursor:pointer" onclick="javascript:window.close()">关闭窗口</span></div>
</div>

<script language="javascript" type="text/javascript">
function printorder(myDiv){ 
    var newstr = document.getElementById(myDiv).innerHTML;
    var oldstr = document.body.innerHTML; 
    document.body.innerHTML = newstr; 
    window.print(); 
    document.body.innerHTML = oldstr; 
    return false; 
} 
</script>
</body>
</html>
