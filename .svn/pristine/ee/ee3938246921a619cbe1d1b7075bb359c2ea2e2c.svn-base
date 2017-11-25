<?php
$var_type=!empty($_REQUEST["var_type"])?$_REQUEST["var_type"]:"";
$var_charts_id=!empty($_REQUEST["var_charts_id"])?$_REQUEST["var_charts_id"]:"";
$var_xAxis=array();

if ($var_type=="products")
{
    $var_series_name_sales_num="销售数量";

    $var_series_data_sales_num=array();

    $where=array("detail_boss_m_bianhao=? and detail_order_day>=? and detail_p_huohao=? and detail_factory_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"], strtotime(date("Y-m-d",strtotime("-13 day"))),$var_charts_id, $_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"] );
    $where=clean_where($where);
    $p=cselect("detail_order_day,
    sum(CASE WHEN detail_order_type in ('xsck','phth') THEN detail_order_num ELSE 0 END ) as sales_num
    ",
    "ydf_order_detail",$where,"detail_order_day","detail_order_day asc",0,14);
    $i=0;
    while($row=$p[0]->fetch())
    {
        $var_xAxis[$i]=date("m/d",$row["detail_order_day"]);
        $var_series_data_sales_num[$i]=round($row["sales_num"]);
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
                                                         )
                                                    )
                                ));
}
elseif ($var_type=="everyday")
{
    $var_series_name_sales_fund="";

    $var_series_data_sales_fund=array();

    $var_series_name_sales_fund="销售额";

    $where=array("bill_boss_id=? and bill_day>=? and bill_factory_id=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"], strtotime(date("Y-m-d",strtotime("-13 day"))),$_SESSION["ERP_ACCOUNT_USER_FACTORY_BIANHAO"] );
    $where=clean_where($where);
    $p=cselect("bill_day, 
    sum(if(bill_type='dxsr',bill_fund,0)) as sales_fund
    ",
    "ydf_finance_bill",$where,"bill_day","bill_day asc",0,14);
    $i=0;
    while($row=$p[0]->fetch())
    {
        $var_xAxis[$i]=date("m/d",$row["bill_day"]);
        $var_series_data_sales_fund[$i]=round($row["sales_fund"]);
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
<div id="lineChart" style="width: 100%; min-width:450px; max-width:650px; height: 250px"/>
