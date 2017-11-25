<?php
include_once "{$root_path}/model/model_bi.php";
$boss_id = $_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"];
$ymd=empty($_REQUEST["bi_time"])?"day":$_REQUEST["bi_time"];
if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"]))
    $order_master_id=$_SESSION["ERP_ACCOUNT_USER_DANGKOU_BIANHAO"];
else
    $order_master_id="";
$kucun_color=$_REQUEST["kucun_color"];
$product_id=$_REQUEST['get_stock_guige_huohao'];
$factory_id= $_REQUEST['factory_id'];
//得到每个货号下每个档口的库存
$group=array("detail_p_huohao","detail_p_color","detail_p_size","detail_master_bianhao");
list($historys,$detail_addup)=get_history_stock_num($ymd="day",$group,$factory_id,$product_id,null,$kucun_color,null,null);
debug($historys);

//得到每个货号的公司总库存，不区分档口
$group=array("detail_p_huohao","detail_p_color","detail_p_size");
list($historys2,$addup)=get_history_stock_num($ymd="day",$group,$factory_id,$product_id,null,$kucun_color,null,null);
$addup_list=array_values($addup);
$size_map=array("S"=>1,"M"=>2,"L"=>3,"XL"=>4,"2XL"=>5,"3XL"=>6,"4XL"=>7,"5XL"=>8,"6XL"=>9);
foreach($addup_list as &$row)
    if (array_key_exists($row["detail_p_size"],$size_map))
        $row["new_detail_p_size"]=$size_map[$row["detail_p_size"]];
    else
        $row["new_detail_p_size"]=$row["detail_p_size"];
unset($row);
debug($addup_list);
$keys=array("new_detail_p_size"=>"r");
$addup_sorts=ysort($addup_list,$keys);

//七日总销和均销
$group=array("detail_p_huohao","detail_p_color","detail_p_size");
$where=array("detail_p_huohao=?  and detail_p_color=?",$product_id,$kucun_color);
$event_inventory=predict(7,7,7,$group,$where);
debug($event_inventory);
//得到档口列表
$dangkou_arr=get_dangkou_list();//档口仓库和编号数组
debug($dangkou_arr);

$rowcount=count($addup);
//$add_color_size=[];
//$ret=[];
///foreach ($addup as $key=>$value)
//{
//    $add_color_size[]=$key;
//    $ret[]=$value;
//}
//debug($ret);
//debug($add_color_size);
for ($i=0;$i<$rowcount;$i++)
{
    //$pool=$ret[$i]["pool"];
    $idx=$addup_sorts[$i]["idx"];

    $row=$historys2[$addup_list[$idx]["now"]];
    debug($row);
    $pool=$row["sum"]["pool"];
    $huohao=$row["detail_p_huohao"];
    $color=$row["detail_p_color"];
    $size=$row["detail_p_size"];
    //list($huohao,$color,$size) = split('#', $add_color_size[$i]);
    if(array_key_exists($huohao.'#'.$color.'#'.$size, $event_inventory)==false){
        $avg_num=0;
        $total_num=0;
    }else{
        $avg_num=round($event_inventory[$huohao.'#'.$color.'#'.$size]["avg_num"]);
        $total_num=round($event_inventory[$huohao.'#'.$color.'#'.$size]["total_num"]);
    }
    //取分库存
    $fen_kucun="";
    for($p=0;$p<count($dangkou_arr);$p++){
        $dangkou_hao=$dangkou_arr[$p][0];
        $dangkou_name=$dangkou_arr[$p][1];
        if(array_key_exists($huohao.'#'.$color.'#'.$size.'#'.$dangkou_hao,$detail_addup)==false){
            $fen_kucun.="<span class='lf' style='margin-top:4px;margin-right:5px;'>".$dangkou_name.":0"."</span>";
        }else{
            $fen_kucun.="<span class='lf' style='margin-top:4px;margin-right:5px;'>".$dangkou_name.":".floatval($detail_addup[$huohao.'#'.$color.'#'.$size.'#'.$dangkou_hao]['pool'])."</span>";
        }
    }
?>
    <div style="width:100%;background:#f2f2f2; margin:0 auto; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block;">
        <div style="float:left; width:8%; height:15px;text-align:center;margin-left:16%;"><?php echo $size ?></div>
        <div style="float:left; width:6%;text-align:center;margin-left:1%"><?php echo floatval($pool) ?></div>
        <div class="kucun_sp" style="float:left; width:16%; text-align:center;margin-left:6%;"><?php echo $fen_kucun ?></div>
        <div style="float:left; width:6%; height:15px;text-align:center;margin-left:9%"><?php echo $avg_num ?></div>
        <div style="float:left;width:6%;height:14px;text-align:center;margin-left:10%"><?php echo $total_num ?></div>
    </div>
<?php
}
?>
