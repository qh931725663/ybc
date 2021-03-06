<?php

include_once("check_factory_user.php");
include_once "{$root_path}/model/model_bi.php";

$p_factory=cselect("factory_bianhao","ydf_factory",array("factory_boss_m_bianhao=? and factory_mobile=?" ,$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"],$_SESSION["ERP_ACCOUNT_LOGIN_MOBILE"]));
$rowfactory=$p_factory[0]->fetch();
$factory_id=$rowfactory["factory_bianhao"];

$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];

$ymd=empty($_REQUEST["bi_time"])?"day":$_REQUEST["bi_time"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id="";

$group=array("detail_order_{$ymd}","detail_p_size");
$types=array('thdj',  'kccsh','jhrk','thsj','ckrk','dbrk', 'phth','xsck','qcfc','ckck','dbck');
$where=array(
    "detail_boss_m_bianhao=? and detail_master_bianhao=? and detail_master_bianhao!=0 and detail_p_huohao=? and detail_p_color=? and detail_p_size!='' and detail_factory_bianhao=?",
    $boss_id,$order_master_id,$_REQUEST["get_stock_guige_huohao"],$_REQUEST["get_stock_guige_color"],$factory_id
);
$sums=array();
foreach($types as $type)
    $sums[]="sum(CASE WHEN detail_order_type='{$type}' THEN detail_order_num ELSE 0 END ) as {$type}";
$historys=bi_select($sums,"ydf_order_detail",$where,$group,"pool_stocks");
$sorts=sort_rows($historys,$group,1);
$rowcount=count($historys);

$value_date=$_REQUEST["get_stock_guige_time"];
for ($i=0;$i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
    $row_main=$historys[$sorts[$idx][0] ];
    
    if (date("Y-m-d",$row_main["detail_order_{$ymd}"])<=$_REQUEST["get_stock_guige_time"] and $row_main["sum"]["pool"])
    {
        $value_date=date("Y-m-d",$row_main["detail_order_{$ymd}"]);
        break;
    }
}

for ($i=0;$i<$rowcount;$i++)
{
    $idx=$rowcount-1-$i;//historys是从老到新的顺序,所以从尾巴开始取是最新的
    $row_main=$historys[$sorts[$idx][0] ];
    
    if (date("Y-m-d",$row_main["detail_order_{$ymd}"])==$value_date)
    {

?>
                        <div style="width:100%; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
                            <div style="float:left; width:20%; height:15px"></div>
                            <div style="float:left; width:20%; height:15px"></div>
                            <div style="float:left; width:10%; height:15px"></div>
                            <div style="float:left; width:10%; height:15px; font-size:14px; text-align:center"><?php echo $row_main["detail_p_size"] ?></div>
                            <div style="float:left; width:10%; font-size:14px; text-align:center"><?php echo round($row_main["sum"]["pool"]) ?></div>
                            <div style="float:left; width:10%; height:15px"></div>
                            <div style="float:left; width:10%; height:15px"></div>
                            <div style="float:left; width:10%; height:15px"></div>
                        </div>
<?php
    }
}
?>
