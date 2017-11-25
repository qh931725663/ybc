<?php
$var_type=!empty($_REQUEST["var_type"])?$_REQUEST["var_type"]:"";
$var_charts_id=!empty($_REQUEST["var_charts_id"])?$_REQUEST["var_charts_id"]:"";
$var_xAxis=array();

if ($var_type=="products")
{
    $var_series_name_sales_num="销售数量";
    $var_series_name_thdj_num="退货数量";
    $var_series_name_client_num="卖家数量";

    $var_series_data_sales_num=array();
    $var_series_data_thdj_num=array();
    $var_series_data_client_num=array();

    $where=array("detail_boss_m_bianhao=? and detail_order_day>=? and detail_p_huohao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"], strtotime(date("Y-m-d",strtotime("-13 day"))),$var_charts_id );
    $where=clean_where($where);
    $p=cselect("detail_order_day,
    sum(CASE WHEN detail_order_type in ('xsck','phth') THEN detail_order_num ELSE 0 END ) as sales_num,
    count(distinct CASE WHEN detail_order_type in ('xsck','phth') AND detail_seller_bianhao!=1 AND  detail_seller_bianhao!=0 THEN detail_seller_bianhao END) as member_count,
    count(distinct CASE WHEN detail_order_type in ('xsck','phth') AND detail_seller_bianhao=1 AND detail_seller_bianhao!=0 THEN detail_order_bianhao END) as non_member_count,
    sum(CASE WHEN detail_order_type='thdj' THEN detail_order_num ELSE 0 END ) as thdj_num
    ",
    "ydf_order_detail",$where,"detail_order_day","detail_order_day asc",0,14);
    $i=0;
    while($row=$p[0]->fetch())
    {
        $var_xAxis[$i]=date("m/d",$row["detail_order_day"]);
        $var_series_data_sales_num[$i]=round($row["sales_num"]);
        $var_series_data_thdj_num[$i]=round($row["thdj_num"]);
        $var_series_data_client_num[$i]=round($row["member_count"]+$row["non_member_count"]);
        $i++;
    }
    $var_highcharts=json_encode(array(
                                    "chart"=>array("type"=>"spline"),
                                    "title"=>array("text"=>""),
                                    "xAxis"=>array("categories"=>$var_xAxis),
                                    "yAxis"=>array(
                                                    "min"=>0,
                                                    "title"=>array("text"=>"")
                                                  ),
                                    "legend"=>array(
                                                    "align"=>"center",
                                                    "verticalAlign"=>"top"
                                                    ),
                                    "tooltip"=>array(
                                                    "shared"=>true,
                                                    "crosshairs"=>true
                                                    ),
                                    "credits"=>array(
                                                    "enabled"=>false
                                                    ),
                                    "series"=>array(
                                                    array(
                                                            "name"=>$var_series_name_sales_num,
                                                            "marker"=>array("symbol"=>"circle"),
                                                            "data"=>$var_series_data_sales_num
                                                         ),
                                                    array(
                                                            "name"=>$var_series_name_thdj_num,
                                                            "marker"=>array("symbol"=>"circle"),
                                                            "data"=>$var_series_data_thdj_num
                                                         ),
                                                    array(
                                                            "name"=>$var_series_name_client_num,
                                                            "marker"=>array("symbol"=>"circle"),
                                                            "data"=>$var_series_data_client_num
                                                         )
                                                    )
                                ));
}
elseif ($var_type=="everyday" or $var_type=="sales")
{
    $var_series_name_sales_fund="";
    $var_series_name_qk="";
    $var_series_name_thzc="";

    $var_series_data_sales_fund=array();
    $var_series_data_qk=array();
    $var_series_data_thzc=array();

    $var_series_name_sales_fund="销售额";
    $var_series_name_qk="欠款";
    $var_series_name_thzc="退款";

    $where=array("bill_boss_id=? and bill_day>=? and bill_seller_id=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"], strtotime(date("Y-m-d",strtotime("-13 day"))),$var_charts_id );
    $where=clean_where($where);
    $p=cselect("bill_day, 
    sum(if(bill_type='mjys',bill_fund,0)) as sales_fund,
    sum(CASE WHEN bill_type='mjys' AND bill_is_credit_seller=0 AND bill_is_credit=1 THEN bill_fund ELSE 0 END ) as skqk,
    sum(CASE WHEN bill_type='mjys' AND bill_is_credit_seller=1 THEN bill_fund ELSE 0 END ) as zqqk,
    sum(if(bill_type='thzc',bill_fund,0)) as thzc
    ",
    "ydf_finance_bill",$where,"bill_day","bill_day asc",0,14);
    $i=0;
    while($row=$p[0]->fetch())
    {
        $var_xAxis[$i]=date("m/d",$row["bill_day"]);
        $var_series_data_sales_fund[$i]=round($row["sales_fund"]);
        $var_series_data_qk[$i]=round($row["skqk"]+$row["zqqk"]);
        $var_series_data_thzc[$i]=round($row["thzc"]);
        $i++;
    }
    $var_highcharts=json_encode(array(
                                    "chart"=>array("type"=>"spline"),
                                    "title"=>array("text"=>""),
                                    "xAxis"=>array("categories"=>$var_xAxis),
                                    "yAxis"=>array(
                                                    "min"=>0,
                                                    "title"=>array("text"=>"")
                                                  ),
                                    "legend"=>array(
                                                    "align"=>"center",
                                                    "verticalAlign"=>"top"
                                                    ),
                                    "tooltip"=>array(
                                                    "shared"=>true,
                                                    "crosshairs"=>true
                                                    ),
                                    "credits"=>array(
                                                    "enabled"=>false
                                                    ),
                                    "series"=>array(
                                                    array(
                                                            "name"=>$var_series_name_sales_fund,
                                                            "marker"=>array("symbol"=>"circle"),
                                                            "data"=>$var_series_data_sales_fund
                                                         ),
                                                    array(
                                                            "name"=>$var_series_name_qk,
                                                            "marker"=>array("symbol"=>"circle"),
                                                            "data"=>$var_series_data_qk
                                                         ),
                                                    array(
                                                            "name"=>$var_series_name_thzc,
                                                            "marker"=>array("symbol"=>"circle"),
                                                            "data"=>$var_series_data_thzc
                                                         )
                                                    )
                                ));
}
?>
<script type="text/javascript">  
$(function(){  
    Highcharts.setOptions({
        colors: ['#058DC7', '#50B432', '#ED561B']
    });
    $('#lineChart').highcharts(<?php print_r($var_highcharts) ?>);
});  
</script> 
<div id="lineChart" style="positon:relative; width: 100%; min-width:450px; max-width:650px; height:100%"/>
