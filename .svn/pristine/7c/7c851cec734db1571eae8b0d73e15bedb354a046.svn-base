<?php
$seller_arr=[];
$p=cselect("seller_name,seller_pinyin","ydf_seller",array("seller_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]));
while ($row=$p[0]->fetch())
{
    $pinyins=$row["seller_pinyin"];
    $pinyins=explode(",",$pinyins);
    $prefixs=array();
    foreach($pinyins as $pinyin){
        $prefix="";
        $chars=str_split($pinyin);
        foreach($chars as $char)
        {
            $prefix.=$char;
            $prefixs[$prefix]=1;
        }
    }
    foreach($prefixs as $prefix=>$v){
        $seller_arr[$prefix][]=$row["seller_name"];
    }
    $seller_arr["NMMJ"][0]="匿名卖家";
    $seller_arr["N"][0]="匿名卖家";
    $seller_arr["NMM"][0]="匿名卖家";
    $seller_arr["NM"][0]="匿名卖家";
}

echo json_encode($seller_arr);
?>
