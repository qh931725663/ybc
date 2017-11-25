<?php

include_once("{$root_path}/model/model_seller.php");
update_seller_cycle();

if (($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1")) and empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]))
{
    $p=cselect("*","ydf_dangkou",array("dangkou_type='1' and dangkou_boss_m_bianhao=?",$_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]) );
    if (!$rowdangkou=$p[0]->fetch())
    {
        include_once "pc/view_store_apply.php";
    }
    else
    {
        if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]=="11")
        {
?>
                <div style="float:left; width:96%; min-height:800px; margin:15px 1% 0 1%; padding:10px 1%; background:#ffffff; overflow:hidden; display:block">
                    <div style="float:left; width:60%; overflow:hidden; display:block">
                        <div style="float:left; width:100%; margin-top:50px; overflow:hidden; display:block">
                            <div style="float:left; width:20%; height:50px; background:url(/pc/images/icon_daishenhe.png) center center no-repeat; overflow:hidden; display:block"></div>
                            <div style="float:left; width:80%; padding:5px 0; font-family:Microsoft YaHei; font-size:18px; font-weight:bold; color:#ff6000; overflow:hidden; display:block">申请已成功提交，请付款等待开通...</div>
                        </div>
                        <div style="float:left; width:80%; margin-left:20%; margin-top:20px; font-size:14px; overflow:hidden; display:block">服务费 ( <span style="font-size:14px;font-weight:bold; color:#d64126">6000 元 / 年</span> ) 请转账至支付宝：18668230665（姓名：胡覃）</div>
                        <div style="float:left; width:80%; margin-left:20%; margin-top:20px; font-size:14px; overflow:hidden; display:block">付款时，请务必备注说明申请注册的档口号</div>
                        <div style="float:left; width:80%; margin-left:20%; margin-top:20px; font-size:14px; overflow:hidden; display:block">如需帮助请拨打服务热线：0571-22810690</div>
                    </div>
                    <div style="float:left; width:40%; height:450px; margin-top:30px; background:url(/pc/images/ybc_alipay.png) center left no-repeat; background-size:contain; overflow:hidden; display:block">
                    </div>
                </div>
<?php        
        }
        elseif ((!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]=="12") or (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_COUNT"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_COUNT"]>"1") or (!empty($_SESSION["ERP_ACCOUNT_USER_TYPE"]) and $_SESSION["ERP_ACCOUNT_USER_TYPE"]=="1"))
        {
?>
                <div id="layer_sales_play_main" class="index_main_div">
                    <div class="index_sales_fund_panel">
                        <div style="position:relative; float:left; width:100%; height:71%; background:#65468c; overflow:hidden; display:block">
                            <div style="position:relative; float:left; width:100%; margin:0 auto; padding-top:10px; font-size:14px; color:#a8e2ee; text-align:center">今日销售额</div>
                            <div id="sales_play_today_sales_fund" style="position:relative; width:100%; font-size:60px; color:#ffffff; text-align:center" ></div>
                            <div style="width:30%; margin-left:70%; overflow:hidden; display:block">
                                <span style="float:left; width:45%; font-size:14px; color:#a8e2ee; text-align:right">今日销量</span>
                                <span id="sales_play_today_sales_num" style="float:left; width:50%; margin-left:5%; font-size:14px; color:#ffffff"></span>  
                            </div>
                            <div style="width:30%; margin-left:70%; padding-top:8px; overflow:hidden; display:block">
                                <span style="float:left; width:45%; font-size:14px; color:#a8e2ee; text-align:right">今日毛利</span><span id="sales_play_today_dklr" style="float:left; width:50%; margin-left:5%; font-size:14px; color:#ffffff"></span>  
                            </div>
                            <div style="width:30%; margin-left:70%; padding-top:8px; overflow:hidden; display:block">
                                <span style="float:left; width:45%; font-size:14px; color:#a8e2ee; text-align:right">本月销售额</span><span id="sales_play_thismonth_sales_fund" style="float:left; width:50%; margin-left:5%; font-size:14px; color:#ffffff"></span>  
                            </div>
                            <div style="width:30%; margin-left:70%; padding-top:8px; overflow:hidden; display:block">
                                <span style="float:left; width:45%; font-size:14px; color:#a8e2ee; text-align:right">本月毛利</span><span id="sales_play_thismonth_dklr" style="float:left; width:50%; margin-left:5%; font-size:14px; color:#ffffff"></span>  
                            </div>
                        </div>
                        <div style="position:relative; float:left; width:100%; height:29%; background:#65468c; border-top:1px solid #ffffff">
                            <div style="position:relative; float:left; width:16%; height:100%; background:url(/pc/images/dot_white.jpg) right center;background-repeat:repeat-y">
                                <div style="width:95%; padding:8px 0 8px 5%; font-size:14px; color:#a8e2ee; text-align:left; display:block">今日退货金额</div>
                                <div id="sales_play_today_thzc" style="width:100%; font-size:14px; color:#FFFF00; text-align:center"></div>
                                <div style="width:100%; padding-top:8px; font-size:14px; color:#a8e2ee; text-align:right; overflow:hidden; display:block">
                                    件数<span id="sales_play_today_thdj_num" style="margin:0 10px; font-size:14px; color:#ffffff"></span>  
                                </div>
                            </div>
                            <div style="position:relative; float:left; width:16%; height:100%; background:url(/pc/images/dot_white.jpg) right center;background-repeat:repeat-y">
                                <div style="width:95%; padding:8px 0 8px 5%; font-size:14px; color:#a8e2ee; text-align:left; display:block">今日卖家欠款</div>
                                <div id="sales_play_today_qk" style="width:100%; font-size:14px; color:#FFFF00; text-align:center"></div>
                                <div style="width:100%; padding-top:8px; font-size:14px; color:#a8e2ee; text-align:right; overflow:hidden; display:block">
                                    未还欠款<span id="sales_play_total_qk" style="margin:0 10px; font-size:14px; color:#ffffff"></span>  
                                </div>
                            </div>
                            <div style="position:relative; float:left; width:16%; height:100%; background:url(/pc/images/dot_white.jpg) right center;background-repeat:repeat-y">
                                <div style="width:95%; padding:8px 0 8px 5%; font-size:14px; color:#a8e2ee; text-align:left; display:block">今日拿货卖家数量</div>
                                <div id="sales_play_today_client_num" style="width:100%; font-size:14px; color:#FFFF00; text-align:center"></div>
                                <div style="width:100%; padding-top:8px; font-size:14px; color:#a8e2ee; text-align:right; overflow:hidden; display:block">
                                    会员总计数量<span id="sales_play_total_member_num" style="margin:0 10px; font-size:14px; color:#ffffff"></span>  
                                </div>
                            </div>
                            <div style="position:relative; float:left; width:16%; height:100%; background:url(/pc/images/dot_white.jpg) right center;background-repeat:repeat-y">
                                <div style="width:95%; padding:8px 0 8px 5%; font-size:14px; color:#a8e2ee; text-align:left; display:block">库存货款</div>
                                <div id="sales_play_total_stock_fund" style="width:100%; font-size:14px; color:#FFFF00; text-align:center"></div>
                                <div style="width:100%; padding-top:8px; font-size:14px; color:#a8e2ee; text-align:right; overflow:hidden; display:block">
                                    库存数量<span id="sales_play_total_stock_num" style="margin:0 10px; font-size:14px; color:#ffffff"></span>  
                                </div>
                            </div>
                            <div style="position:relative; float:left; width:16%; height:100%; background:url(/pc/images/dot_white.jpg) right center;background-repeat:repeat-y">
                                <div style="width:95%; padding:8px 0 8px 5%; font-size:14px; color:#a8e2ee; text-align:left; display:block">今日开支</div>
                                <div id="sales_play_today_out_fund" style="width:100%; font-size:14px; color:#FFFF00; text-align:center"></div>
                                <div style="width:100%; padding-top:8px; font-size:14px; color:#a8e2ee; text-align:right; overflow:hidden; display:block">
                                    本月开支<span id="sales_play_thismonth_out_fund" style="margin:0 10px; font-size:14px; color:#ffffff"></span>  
                                </div>
                            </div>
                            <div style="position:relative; float:left; width:20%; height:100%; background:#30c0db">
                                <div style="float:left; width:100%; padding-top:10px">
                                    <span class="index_link_dfk" id="daily_reimbursement_btn">日常报销待付款（ <span id="sales_play_daily_expense_work_num"></span> ）</span>
                                </div>
                                <div style="float:left; width:100%; padding-top:10px">
                                    <span id="factory_lift" class="index_link_dfk">工厂提现待付款（ <span id="sales_play_factory_cashier_work_num"></span> ）</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="layer_sales_fund_addup" style="position:relative; width:100%; height:55%; background:#ffffff; overflow:hidden; display:block">
                        <div style="position:relative; float:left; width:44%; height:100%; margin-right:1%; overflow:hidden; display:block">
                            <div  style="width:96%; margin:10px auto; overflow:hidden; display:block">
                                <div style="float:left; overflow:hidden; display:block">
                                    <span id="tag_rank_ereryday" class="listaddupbytype listaddupbytypeselect" onclick="click_rank_type($(this),'everyday')">销售日报</span>
                                    <span id="tag_rank_products" class="listaddupbytype" onclick="click_rank_type($(this),'products')">商品排行</span>
                                    <span id="tag_rank_sales" class="listaddupbytype" onclick="click_rank_type($(this),'sales')">卖家排行</span>
                                </div>
                                <div id="tag_date" style="float:right; overflow:hidden; display:none">
                                    <span id="addupbytime_today" class="listaddupbytime listaddupbytimeselect" onclick="click_rank_datetype($(this),'today')">今日</span>
                                    <span class="listaddupbytime" onclick="click_rank_datetype($(this),'thismonth')">本月</span>
                                </div>
                            </div> 
                            <div id="index_block_rank" style="position:relative; width:96%; height:80%; margin:0 auto; overflow:hidden; display:block"></div>
                        </div>
                        <div style="position:relative; float:left; width:54%; height:100%; margin-left:1%; overflow:hidden; display:block">
                            <div  style="width:96%; margin:10px auto; overflow:hidden; display:block">
                                <div style="float:left; margin-right:10px; padding:5px 0; overflow:hidden; display:block"><span id="index_charts_title" style="font-size:14px"></span> <span id="index_charts_item_name" style="font-size:14px; color:#d64126"></span></div>
                                <div style="float:right; margin-right:10px; padding:5px 0; overflow:hidden; display:block"><span style="font-size:14px; color:#999999"></span><span style="font-size:14px; color:#ee583d"></span></div>
                            </div> 
                            <div id="index_block_charts" style="position:relative; width:96%; height:80%; margin:0 auto; max-height:250px; overflow:hidden; display:block"></div>
                        </div>
                    </div>
                </div>
<script type="text/javascript">
var current_type="ereryday";
var current_date_type="today";
var current_charts_id="";
var current_charts_item="";
$(function(){
    $("#layer_sales_play_main").css("height",$(document.body).height()-50);

    $(window).resize(function(){
        $("#layer_sales_play_main").css("height",$(document.body).height()-50);
    });

    index_view_index_loading=layer.load(0, {
        shade: [0.3, '#000000']
    });
    //初始化开始数据
    var sales_play_today_sales_fund=0;
    var sales_play_today_sales_num=0;
    var sales_play_today_dklr=0;
    var sales_play_thismonth_sales_fund=0;
    var sales_play_thismonth_dklr=0;
    
    var sales_play_today_thzc=0;
    var sales_play_today_thdj_num=0;
    
    var sales_play_today_qk=0;
    var sales_play_total_qk=0;
    
    var sales_play_today_client_num=0;
    var sales_play_total_member_num=0;
    
    var sales_play_total_stock_fund=0;
    var sales_play_total_stock_num=0;
    
    var sales_play_today_out_fund=0;
    var sales_play_thismonth_out_fund=0;
    
    var sales_play_daily_expense_work_num=0;
    var sales_play_factory_cashier_work_num=0;
    
    $.ajax({
        url:"model-addup-bi", 
        async: true,
        type: "POST",
        data:{func:"boss_addup_index"},
        dataType:"json",
        success: function(html){
            layer.close(index_view_index_loading);
            var options = {
                            useEasing : true, 
                            useGrouping : true, 
                            separator : ',', 
                            decimal : '.', 
                            prefix : '', 
                            suffix : '' 
                            };
            if (parseInt(html["today_sales_fund"])==0)
            {
                $("#sales_play_today_sales_fund").html("暂无数据");
            }
            else if (sales_play_today_sales_fund<parseInt(html["today_sales_fund"]))
            {
                var current_sales_play_today_sales_fund = new CountUp("sales_play_today_sales_fund", sales_play_today_sales_fund, parseInt(html["today_sales_fund"]), 0, 1, options);
                current_sales_play_today_sales_fund.start();
                sales_play_today_sales_fund=parseInt(html["today_sales_fund"]);
            }
            
            if (parseInt(html["today_sales_num"])==0)
            {
                $("#sales_play_today_sales_num").html("暂无数据");
            }
            else if (sales_play_today_sales_num<parseInt(html["today_sales_num"]))
            {
                var current_sales_play_today_sales_num = new CountUp("sales_play_today_sales_num", sales_play_today_sales_num, parseInt(html["today_sales_num"]), 0, 1, options);
                current_sales_play_today_sales_num.start();
                sales_play_today_sales_num=parseInt(html["today_sales_num"]);
            }
            
            if (parseInt(html["today_dklr"])==0)
            {
                $("#sales_play_today_dklr").html("暂无数据");
            }
            else if (sales_play_today_dklr<parseInt(html["today_dklr"]))
            {
                var current_sales_play_today_dklr = new CountUp("sales_play_today_dklr", sales_play_today_dklr, parseInt(html["today_dklr"]), 0, 1, options);
                current_sales_play_today_dklr.start();
                sales_play_today_dklr=parseInt(html["today_dklr"]);
            }
            
            if (parseInt(html["thismonth_sales_fund"])==0)
            {
                $("#sales_play_thismonth_sales_fund").html("暂无数据");
            }
            else if (sales_play_thismonth_sales_fund<parseInt(html["thismonth_sales_fund"]))
            {
                var current_sales_play_thismonth_sales_fund = new CountUp("sales_play_thismonth_sales_fund", sales_play_thismonth_sales_fund, parseInt(html["thismonth_sales_fund"]), 0, 1, options);
                current_sales_play_thismonth_sales_fund.start();
                sales_play_thismonth_sales_fund=parseInt(html["thismonth_sales_fund"]);
            }
            
            if (parseInt(html["thismonth_dklr"])==0)
            {
                $("#sales_play_thismonth_dklr").html("暂无数据");
            }
            else if (sales_play_thismonth_dklr<parseInt(html["thismonth_dklr"]))
            {
                var current_sales_play_thismonth_dklr = new CountUp("sales_play_thismonth_dklr", sales_play_thismonth_dklr, parseInt(html["thismonth_dklr"]), 0, 1, options);
                current_sales_play_thismonth_dklr.start();
                sales_play_thismonth_dklr=parseInt(html["thismonth_dklr"]);
            }
            
            if (parseInt(html["today_thzc"])==0)
            {
                $("#sales_play_today_thzc").html("暂无数据");
            }
            else if (sales_play_today_thzc<parseInt(html["today_thzc"]))
            {
                var current_sales_play_today_thzc = new CountUp("sales_play_today_thzc", sales_play_today_thzc, parseInt(html["today_thzc"]), 0, 1, options);
                current_sales_play_today_thzc.start();
                sales_play_today_thzc=parseInt(html["today_thzc"]);
            }
            
            if (parseInt(html["today_thdj_num"])==0)
            {
                $("#sales_play_today_thdj_num").html("暂无数据");
            }
            else if (sales_play_today_thdj_num<parseInt(html["today_thdj_num"]))
            {
                var current_sales_play_today_thdj_num = new CountUp("sales_play_today_thdj_num", sales_play_today_thdj_num, parseInt(html["today_thdj_num"]), 0, 1, options);
                current_sales_play_today_thdj_num.start();
                sales_play_today_thdj_num=parseInt(html["today_thdj_num"]);
            }
            
            if (parseInt(html["today_qk"])==0)
            {
                $("#sales_play_today_qk").html("暂无数据");
            }
            else if (sales_play_today_qk<parseInt(html["today_qk"]))
            {
                var current_sales_play_today_qk = new CountUp("sales_play_today_qk", sales_play_today_qk, parseInt(html["today_qk"]), 0, 1, options);
                current_sales_play_today_qk.start();
                sales_play_today_qk=parseInt(html["today_qk"]);
            }
            
            if (parseInt(html["total_qk"])==0)
            {
                $("#sales_play_total_qk").html("暂无数据");
            }
            else if (sales_play_total_qk<parseInt(html["total_qk"]))
            {
                var current_sales_play_total_qk = new CountUp("sales_play_total_qk", sales_play_total_qk, parseInt(html["total_qk"]), 0, 1, options);
                current_sales_play_total_qk.start();
                sales_play_total_qk=parseInt(html["total_qk"]);
            }
            
            if (parseInt(html["today_client_num"])==0)
            {
                $("#sales_play_today_client_num").html("暂无数据");
            }
            else if (sales_play_today_client_num<parseInt(html["today_client_num"]))
            {
                var current_sales_play_today_client_num = new CountUp("sales_play_today_client_num", sales_play_today_client_num, parseInt(html["today_client_num"]), 0, 1, options);
                current_sales_play_today_client_num.start();
                sales_play_today_client_num=parseInt(html["today_client_num"]);
            }
            
            if (parseInt(html["total_member_num"])==0 )
            {
                $("#sales_play_total_member_num").html("暂无数据");
            }
            else if (sales_play_total_member_num<parseInt(html["total_member_num"]))
            {
                var current_sales_play_total_member_num = new CountUp("sales_play_total_member_num", sales_play_total_member_num, parseInt(html["total_member_num"]), 0, 1, options);
                current_sales_play_total_member_num.start();
                sales_play_total_member_num=parseInt(html["total_member_num"]);
            }
            
            if (parseInt(html["total_stock_fund"])==0)
            {
                $("#sales_play_total_stock_fund").html("暂无数据");
            }
            else if (sales_play_total_stock_fund<parseInt(html["total_stock_fund"]))
            {
                var current_sales_play_total_stock_fund = new CountUp("sales_play_total_stock_fund", sales_play_total_stock_fund, parseInt(html["total_stock_fund"]), 0, 1, options);
                current_sales_play_total_stock_fund.start();
                sales_play_total_stock_fund=parseInt(html["total_stock_fund"]);
            }
            
            if (parseInt(html["total_stock_num"])==0)
            {
                $("#sales_play_total_stock_num").html("暂无数据");
            }
            else if (sales_play_total_stock_num<parseInt(html["total_stock_num"]))
            {
                var current_sales_play_total_stock_num = new CountUp("sales_play_total_stock_num", sales_play_total_stock_num, parseInt(html["total_stock_num"]), 0, 1, options);
                current_sales_play_total_stock_num.start();
                sales_play_total_stock_num=parseInt(html["total_stock_num"]);
            }
            
            if (parseInt(html["today_out_fund"])==0)
            {
                $("#sales_play_today_out_fund").html("暂无数据");
            }
            else if (sales_play_today_out_fund<parseInt(html["today_out_fund"]))
            {
                var current_sales_play_today_out_fund = new CountUp("sales_play_today_out_fund", sales_play_today_out_fund, parseInt(html["today_out_fund"]), 0, 1, options);
                current_sales_play_today_out_fund.start();
                sales_play_today_out_fund=parseInt(html["today_out_fund"]);
            }
            
            if (parseInt(html["thismonth_out_fund"])==0 )
            {
                $("#sales_play_thismonth_out_fund").html("暂无数据");
            }
            else if (sales_play_thismonth_out_fund<parseInt(html["thismonth_out_fund"]))
            {
                var current_sales_play_thismonth_out_fund = new CountUp("sales_play_thismonth_out_fund", sales_play_thismonth_out_fund, parseInt(html["thismonth_out_fund"]), 0, 1, options);
                current_sales_play_thismonth_out_fund.start();
                sales_play_thismonth_out_fund=parseInt(html["thismonth_out_fund"]);
            }
            
            if (parseInt(html["daily_expense_work_num"])==0)
            {
                $("#sales_play_daily_expense_work_num").css("color","#ffffff");
                $("#sales_play_daily_expense_work_num").html("0");
            }
            else if (sales_play_daily_expense_work_num<parseInt(html["daily_expense_work_num"]))
            {
                $("#sales_play_daily_expense_work_num").css("color","#d64126");
                
                var current_sales_play_daily_expense_work_num = new CountUp("sales_play_daily_expense_work_num", sales_play_daily_expense_work_num, parseInt(html["daily_expense_work_num"]), 0, 1, options);
                current_sales_play_daily_expense_work_num.start();
                sales_play_daily_expense_work_num=parseInt(html["daily_expense_work_num"]);
            }
            
            if (parseInt(html["factory_cashier_work_num"])==0)
            {
                $("#sales_play_factory_cashier_work_num").css("color","#ffffff");
                $("#sales_play_factory_cashier_work_num").html("0");
            }
            else if (sales_play_factory_cashier_work_num<parseInt(html["factory_cashier_work_num"]))
            {
                $("#sales_play_factory_cashier_work_num").css("color","#d64126");
                
                var current_sales_play_factory_cashier_work_num = new CountUp("sales_play_factory_cashier_work_num", sales_play_factory_cashier_work_num, parseInt(html["factory_cashier_work_num"]), 0, 1, options);
                current_sales_play_factory_cashier_work_num.start();
                sales_play_factory_cashier_work_num=parseInt(html["factory_cashier_work_num"]);
            }
        }
    });
    
    click_rank_type("", "everyday");
    
    setInterval(function(){
        if (flag_view_index_setInterval==1)
        {        
            $.ajax({
                url:"model-addup-bi", 
                async: true,
                type: "POST",
                data:{func:"boss_addup_index"},
                dataType:"json",
                success: function(html){
                    var options = {
                                    useEasing : true, 
                                    useGrouping : true,
                                    separator : ',',
                                    decimal : '.',
                                    prefix : '',
                                    suffix : ''
                                    };
                    if (sales_play_today_sales_fund<parseInt(html["today_sales_fund"]))
                    {
                        var current_sales_play_today_sales_fund = new CountUp("sales_play_today_sales_fund", sales_play_today_sales_fund, parseInt(html["today_sales_fund"]), 0, 1, options);
                        current_sales_play_today_sales_fund.start();
                        sales_play_today_sales_fund=parseInt(html["today_sales_fund"]);
                    }
                    
                    if (sales_play_today_sales_num<parseInt(html["today_sales_num"]))
                    {
                        var current_sales_play_today_sales_num = new CountUp("sales_play_today_sales_num", sales_play_today_sales_num, parseInt(html["today_sales_num"]), 0, 1, options);
                        current_sales_play_today_sales_num.start();
                        sales_play_today_sales_num=parseInt(html["today_sales_num"]);
                    }
                    
                    if (sales_play_today_dklr<parseInt(html["today_dklr"]))
                    {
                        var current_sales_play_today_dklr = new CountUp("sales_play_today_dklr", sales_play_today_dklr, parseInt(html["today_dklr"]), 0, 1, options);
                        current_sales_play_today_dklr.start();
                        sales_play_today_dklr=parseInt(html["today_dklr"]);
                    }
                    
                    if (sales_play_thismonth_sales_fund<parseInt(html["thismonth_sales_fund"]))
                    {
                        var current_sales_play_thismonth_sales_fund = new CountUp("sales_play_thismonth_sales_fund", sales_play_thismonth_sales_fund, parseInt(html["thismonth_sales_fund"]), 0, 1, options);
                        current_sales_play_thismonth_sales_fund.start();
                        sales_play_thismonth_sales_fund=parseInt(html["thismonth_sales_fund"]);
                    }
                    
                    if (sales_play_thismonth_dklr<parseInt(html["thismonth_dklr"]))
                    {
                        var current_sales_play_thismonth_dklr = new CountUp("sales_play_thismonth_dklr", sales_play_thismonth_dklr, parseInt(html["thismonth_dklr"]), 0, 1, options);
                        current_sales_play_thismonth_dklr.start();
                        sales_play_thismonth_dklr=parseInt(html["thismonth_dklr"]);
                    }
                    
                    if (sales_play_today_thzc<parseInt(html["today_thzc"]))
                    {
                        var current_sales_play_today_thzc = new CountUp("sales_play_today_thzc", sales_play_today_thzc, parseInt(html["today_thzc"]), 0, 1, options);
                        current_sales_play_today_thzc.start();
                        sales_play_today_thzc=parseInt(html["today_thzc"]);
                    }
                    
                    if (sales_play_today_thdj_num<parseInt(html["today_thdj_num"]))
                    {
                        var current_sales_play_today_thdj_num = new CountUp("sales_play_today_thdj_num", sales_play_today_thdj_num, parseInt(html["today_thdj_num"]), 0, 1, options);
                        current_sales_play_today_thdj_num.start();
                        sales_play_today_thdj_num=parseInt(html["today_thdj_num"]);
                    }
                    
                    if (sales_play_today_qk<parseInt(html["today_qk"]))
                    {
                        var current_sales_play_today_qk = new CountUp("sales_play_today_qk", sales_play_today_qk, parseInt(html["today_qk"]), 0, 1, options);
                        current_sales_play_today_qk.start();
                        sales_play_today_qk=parseInt(html["today_qk"]);
                    }
                    
                    if (sales_play_total_qk<parseInt(html["total_qk"]))
                    {
                        var current_sales_play_total_qk = new CountUp("sales_play_total_qk", sales_play_total_qk, parseInt(html["total_qk"]), 0, 1, options);
                        current_sales_play_total_qk.start();
                        sales_play_total_qk=parseInt(html["total_qk"]);
                    }
                    
                    if (sales_play_today_client_num<parseInt(html["today_client_num"]))
                    {
                        var current_sales_play_today_client_num = new CountUp("sales_play_today_client_num", sales_play_today_client_num, parseInt(html["today_client_num"]), 0, 1, options);
                        current_sales_play_today_client_num.start();
                        sales_play_today_client_num=parseInt(html["today_client_num"]);
                    }
                    
                    if (sales_play_total_member_num<parseInt(html["total_member_num"]))
                    {
                        var current_sales_play_total_member_num = new CountUp("sales_play_total_member_num", sales_play_total_member_num, parseInt(html["total_member_num"]), 0, 1, options);
                        current_sales_play_total_member_num.start();
                        sales_play_total_member_num=parseInt(html["total_member_num"]);
                    }
                    
                    if (sales_play_total_stock_fund<parseInt(html["total_stock_fund"]))
                    {
                        var current_sales_play_total_stock_fund = new CountUp("sales_play_total_stock_fund", sales_play_total_stock_fund, parseInt(html["total_stock_fund"]), 0, 1, options);
                        current_sales_play_total_stock_fund.start();
                        sales_play_total_stock_fund=parseInt(html["total_stock_fund"]);
                    }
                    
                    if (sales_play_total_stock_num<parseInt(html["total_stock_num"]))
                    {
                        var current_sales_play_total_stock_num = new CountUp("sales_play_total_stock_num", sales_play_total_stock_num, parseInt(html["total_stock_num"]), 0, 1, options);
                        current_sales_play_total_stock_num.start();
                        sales_play_total_stock_num=parseInt(html["total_stock_num"]);
                    }
                    
                    if (sales_play_today_out_fund<parseInt(html["today_out_fund"]))
                    {
                        var current_sales_play_today_out_fund = new CountUp("sales_play_today_out_fund", sales_play_today_out_fund, parseInt(html["today_out_fund"]), 0, 1, options);
                        current_sales_play_today_out_fund.start();
                        sales_play_today_out_fund=parseInt(html["today_out_fund"]);
                    }
                    
                    if (sales_play_thismonth_out_fund<parseInt(html["thismonth_out_fund"]))
                    {
                        var current_sales_play_thismonth_out_fund = new CountUp("sales_play_thismonth_out_fund", sales_play_thismonth_out_fund, parseInt(html["thismonth_out_fund"]), 0, 1, options);
                        current_sales_play_thismonth_out_fund.start();
                        sales_play_thismonth_out_fund=parseInt(html["thismonth_out_fund"]);
                    }
                    
                    if (sales_play_daily_expense_work_num<parseInt(html["daily_expense_work_num"]))
                    {
                        if (parseInt(html["daily_expense_work_num"])==0)
                        {
                            $("#sales_play_daily_expense_work_num").css("color","#ffffff");
                        }
                        else
                        {
                            $("#sales_play_daily_expense_work_num").css("color","#d64126");
                        }
                        
                        var current_sales_play_daily_expense_work_num = new CountUp("sales_play_daily_expense_work_num", sales_play_daily_expense_work_num, parseInt(html["daily_expense_work_num"]), 0, 1, options);
                        current_sales_play_daily_expense_work_num.start();
                        sales_play_daily_expense_work_num=parseInt(html["daily_expense_work_num"]);
                    }
                    
                    if (sales_play_factory_cashier_work_num<parseInt(html["factory_cashier_work_num"]))
                    {
                        if (parseInt(html["factory_cashier_work_num"])==0)
                        {
                            $("#sales_play_factory_cashier_work_num").css("color","#ffffff");
                        }
                        else
                        {
                            $("#sales_play_factory_cashier_work_num").css("color","#d64126");
                        }
                        
                        var current_sales_play_factory_cashier_work_num = new CountUp("sales_play_factory_cashier_work_num", sales_play_factory_cashier_work_num, parseInt(html["factory_cashier_work_num"]), 0, 1, options);
                        current_sales_play_factory_cashier_work_num.start();
                        sales_play_factory_cashier_work_num=parseInt(html["factory_cashier_work_num"]);
                    }
                }
            });
            
            setInterval_refresh_rank_type(current_type, current_date_type, current_charts_id, current_charts_item);
        }
    },30000);
});

function setInterval_refresh_rank_type(var_type, date_type, var_charts_id, var_charts_item)
{
    $("#tag_rank_everyday").parent().find(".listaddupbytype").removeClass('listaddupbytypeselect');
    if (var_type=="everyday")
    {
        $("#tag_rank_everyday").addClass("listaddupbytypeselect");
    }
    else
    {
        if (var_type=="products")
        {
            $("#tag_rank_products").addClass("listaddupbytypeselect");
        }
        else if (var_type=="sales")
        {
            $("#tag_rank_sales").addClass("listaddupbytypeselect");
        }
    
        $("#addupbytime_today").parent().find(".listaddupbytime").removeClass('listaddupbytimeselect');
        if (date_type=="today")
        {
            $("#addupbytime_today").addClass("listaddupbytimeselect");
        }
        else
        {
            $("#addupbytime_today").next().addClass("listaddupbytimeselect");
        }
    }

    if (var_type=="everyday")
    {
        $("#index_charts_title").css("color","#058DC7");
        $("#index_charts_title").html("销售资金走势分析 [连续14天]");
        
        $.ajax({
            url:"view-index-get-everyday-sales",
            async: true,
            type: "POST",
            data:"",
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });       
    }    
    else if (var_type=="products")
    {
        $("#index_charts_title").css("color","#058DC7");
        $("#index_charts_title").html("商品销量走势分析 [连续14天]");
        
        $.ajax({
            url:"view-index-get-products-rank", 
            async: true,
            type: "POST",
            data:{var_date_type:date_type},
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });       
    }
    else if (var_type=="sales")
    {
        $("#index_charts_title").css("color","#50B432");
        $("#index_charts_title").html("销售资金走势分析 [连续14天]");
        
        $.ajax({
            url:"view-index-get-sales-fund-rank", 
            async: true,
            type: "POST",
            data:{var_date_type:date_type},
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });
    }
    
    click_charts_type(var_type, var_charts_id, var_charts_item);
}

function click_rank_type(obj,type)
{
    current_type=type;
    
    if (type=="everyday")
    {
       $("#tag_date").hide(); 
    }
    else
    {
        current_date_type="today";
        
        $("#tag_date").show(); 
        $("#addupbytime_today").parent().find(".listaddupbytime").removeClass('listaddupbytimeselect');
        $("#addupbytime_today").addClass("listaddupbytimeselect");
    }
    
    if (obj)
    {
        obj.parent().find(".listaddupbytype").removeClass('listaddupbytypeselect');
        obj.addClass("listaddupbytypeselect");
    }
    else
    {
        $("#tag_rank_ereryday").parent().find(".listaddupbytype").removeClass('listaddupbytypeselect');
        $("#tag_rank_ereryday").addClass("listaddupbytypeselect");
    }

    if (type=="everyday")
    {
        $("#index_charts_title").css("color","#058DC7");
        $("#index_charts_title").html("销售资金走势分析 [连续14天]");
        
        $.ajax({
            url:"view-index-get-everyday-sales", 
            async: true,
            type: "POST",
            data:"",
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });       
    }
    else if (type=="products")
    {
        $("#index_charts_title").css("color","#50B432");
        $("#index_charts_title").html("商品销量走势分析 [连续14天]");
        
        $.ajax({
            url:"view-index-get-products-rank", 
            async: true,
            type: "POST",
            data:{var_date_type:"today"},
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });       
    }
    else if (type=="sales")
    {
        $("#index_charts_title").css("color","#058DC7");
        $("#index_charts_title").html("销售资金走势分析 [连续14天]");
        
        $.ajax({
            url:"view-index-get-sales-fund-rank", 
            async: true,
            type: "POST",
            data:{var_date_type:"today"},
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });
    }
    
    $("#index_charts_item_name").html("");
    
    click_charts_type(type, "");
}

function click_rank_datetype(obj,datetype)
{
    current_date_type=datetype;
    
    if (obj)
    {
        obj.parent().find(".listaddupbytime").removeClass('listaddupbytimeselect');
        obj.addClass("listaddupbytimeselect");
    }

    if (current_type=="products")
    {
         $.ajax({
            url:"view-index-get-products-rank", 
            async: true,
            type: "POST",
            data:{var_date_type:datetype},
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });       
    }
    else if (current_type=="sales")
    {
        $.ajax({
            url:"view-index-get-sales-fund-rank", 
            async: true,
            type: "POST",
            data:{var_date_type:datetype},
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });
    }
}

function click_charts_type(charts_type,charts_id,charts_item)
{
    current_charts_id=charts_id;
    current_charts_item=charts_item;
    
    if (charts_id)
    {
        if (charts_item)
        {
            $("#index_charts_item_name").html("["+charts_item+"]");
        }
        else
        {
            $("#index_charts_item_name").html("["+charts_id+"]");
        }
    }
    
    $.ajax({
        url:"view-index-get-charts", 
        async: true,
        type: "POST",
        data:{var_type:charts_type,var_charts_id:charts_id},
        success: function(html){
            $("#index_block_charts").html(html);
        }
    });
}

$("#daily_reimbursement_btn").click(function(){
    ASYNC=false;
    $("#financial_management").trigger("click");
    $("#daily_reimbursement").trigger("click");
    ASYNC=true;
});

$("#factory_lift").click(function(){
    ASYNC=false;
    $("#factory_procurement").trigger("click");
    $("#consignment_payment_factory").trigger("click");
    ASYNC=true;
});
</script>
<?php
        }
        elseif (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]=="13")
        {
?>
                <div style="float:left; width:96%; min-height:800px; margin:15px 1% 0 1%; padding:10px 1%; background:#ffffff; overflow:hidden; display:block">
                    <div style="width:60%; margin:0 auto; overflow:hidden; display:block">
                        <div style="float:left; width:100%; margin-top:50px; overflow:hidden; display:block">
                            <div style="float:left; width:20%; height:50px; background:url(/pc/images/icon_daishenhe.png) center center no-repeat; overflow:hidden; display:block"></div>
                            <div style="float:left; width:80%; margin-top:10px; font-family:Microsoft YaHei; font-size:18px; font-weight:bold; color:#ff6000; overflow:hidden; display:block">对不起，此档口管理系统使用时间已到期！</div>
                        </div>
                        <div style="float:left; width:80%; margin-left:20%; margin-top:20px; font-size:14px; overflow:hidden; display:block">服务费 ( <span style="font-size:14px;font-weight:bold; color:#d64126">6000 元 / 年</span> ) 请转账至支付宝：18668230665（姓名：胡覃）</div>
                        <div style="float:left; width:80%; margin-left:20%; margin-top:20px; font-size:14px; overflow:hidden; display:block">如需帮助请拨打服务热线：0571-22810690</div>
                    </div>
                </div>
<?php
        }
    }
}
elseif (($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="1" or $_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="4") and !empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_TYPE"]) )
{
    if (!empty($_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]) and $_SESSION["ERP_ACCOUNT_USER_DANGKOU_STATUS"]=="13")
    {
?>
    <div style="float:left; width:96%; min-height:800px; margin:15px 1% 0 1%; padding:10px 1%; background:#ffffff; overflow:hidden; display:block">
        <div style="width:60%; margin:0 auto; overflow:hidden; display:block">
            <div style="float:left; width:100%; margin-top:50px; overflow:hidden; display:block">
                <div style="float:left; width:20%; height:50px; background:url(/pc/images/icon_daishenhe.png) center center no-repeat; overflow:hidden; display:block"></div>
                <div style="float:left; width:80%; margin-top:10px; font-family:Microsoft YaHei; font-size:18px; font-weight:bold; color:#ff6000; overflow:hidden; display:block">对不起，此档口管理系统使用时间已到期！</div>
            </div>
            <div style="float:left; width:80%; margin-left:20%; margin-top:20px; font-size:14px; overflow:hidden; display:block">服务费 ( <span style="font-size:14px;font-weight:bold; color:#d64126">6000 元 / 年</span> ) 请转账至支付宝：15968838151</div>
            <div style="float:left; width:80%; margin-left:20%; margin-top:20px; font-size:14px; overflow:hidden; display:block">如需帮助请拨打服务热线：0571-22810690</div>
        </div>
    </div>
<?php
    }
    else
    {
?>
<script type="text/javascript">
$(function(){
    mount_to_frame("frame_cashier");
});
</script>
<?php
    }
}
elseif ($_SESSION["ERP_ACCOUNT_LOGIN_TYPE"]=="2")
{
    if (empty($_SESSION["ERP_ACCOUNT_USER_BOSS_M_BIANHAO"]))
    {
?>
                <div style="float:left; width:96%; min-height:800px; margin:15px 1% 0 1%; padding:10px 1%; background:#ffffff; overflow:hidden; display:block">
                    <div style="float:left; width:100%; margin:10px 0; padding:10px 0; font-size:14px; color:#ee583d; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">请先选择合作档口负责人：</div>
                    <div style="float:left; width:100%; display:block">
                        <?php
                        $p=cselect("*","ydf_member",array("m_bianhao in (select factory_boss_m_bianhao from ydf_factory where del_state<>'1' and factory_manage='1' and factory_mobile='".$_SESSION["ERP_ACCOUNT_LOGIN_MOBILE"]."')"),"","m_bianhao");
                        while ($rowboss=$p[0]->fetch())
                        {
                        ?>
                        <div class="listclassvalueblock">
                            <div class="listclassvalue" onclick="/**/FactorySelectBoss(<?php echo $rowboss["m_bianhao"]?>)"><?php echo $rowboss["m_realname"] ?></div>
                        </div>
                        <?php
                        }
                        ?>
                        
                    </div>
                </div>
<?php
    }
    else
    {
?>
                <div class="index_main_div">
                    <div class="index_sales_fund_panel">
                        <div style="float:left; width:100%; height:250px; background:#65468c">
                            <div style="width:100%; margin:0 auto; padding-top:30px; font-size:14px; color:#a8e2ee; text-align:center">今日销售额</div>
                            <div id="sales_play_today_sales_fund" style="width:100%; margin-top:20px; font-size:60px; color:#ffffff; text-align:center" ></div>
                            <div style="width:30%; margin-left:70%; overflow:hidden; display:block">
                                <span style="float:left; width:45%; font-size:14px; color:#a8e2ee; text-align:right">今日销量</span>
                                <span id="sales_play_today_sales_num" style="float:left; width:50%; margin-left:5%; font-size:14px; color:#ffffff"></span>  
                            </div>
                            <div style="width:30%; margin-left:70%; padding-top:8px; overflow:hidden; display:block">
                                <span style="float:left; width:45%; font-size:14px; color:#a8e2ee; text-align:right">本月销售额</span><span id="sales_play_thismonth_sales_fund" style="float:left; width:50%; margin-left:5%; font-size:14px; color:#ffffff"></span>  
                            </div>
                            <div style="width:30%; margin-left:70%; padding-top:8px; overflow:hidden; display:block">
                                <span style="float:left; width:45%; font-size:14px; color:#a8e2ee; text-align:right">本月销量</span>
                                <span id="sales_play_thismonth_sales_num" style="float:left; width:50%; margin-left:5%; font-size:14px; color:#ffffff"></span>  
                            </div>
                            <div style="width:30%; margin-left:70%; padding-top:8px; overflow:hidden; display:block">
                                <span style="float:left; width:45%; font-size:14px; color:#a8e2ee; text-align:right">库存金额</span><span id="sales_play_total_stock_fund" style="float:left; width:50%; margin-left:5%; font-size:14px; color:#ffffff"></span>  
                            </div>
                            <div style="width:30%; margin-left:70%; padding-top:8px; overflow:hidden; display:block">
                                <span style="float:left; width:45%; font-size:14px; color:#a8e2ee; text-align:right">库存数量</span><span id="sales_play_total_stock_num" style="float:left; width:50%; margin-left:5%; font-size:14px; color:#ffffff"></span>  
                            </div>
                        </div>
                    </div>
                    <div id="layer_sales_fund_addup" style="float:left; width:100%; background:#ffffff; overflow:hidden; display:block">
                        <div style="float:left; width:44%; margin-right:1%; overflow:hidden; display:block">
                            <div  style="width:96%; margin:10px auto; overflow:hidden; display:block">
                                <div style="float:left; overflow:hidden; display:block">
                                    <span id="tag_rank_ereryday" class="listaddupbytype listaddupbytypeselect" onclick="click_rank_type($(this),'everyday')">销售日报</span>
                                    <span id="tag_rank_products" class="listaddupbytype" onclick="click_rank_type($(this),'products')">商品排行</span>
                                </div>
                                <div id="tag_date" style="float:right; overflow:hidden; display:none">
                                    <span id="addupbytime_today" class="listaddupbytime listaddupbytimeselect" onclick="click_rank_datetype($(this),'today')">今日</span>
                                    <span class="listaddupbytime" onclick="click_rank_datetype($(this),'thismonth')">本月</span>
                                </div>
                            </div> 
                            <div id="index_block_rank" style="width:96%; margin:0 auto; overflow:hidden; display:block"></div>
                        </div>
                        <div style="float:left; width:54%; margin-left:1%; overflow:hidden; display:block">
                            <div  style="width:96%; margin:10px auto; overflow:hidden; display:block">
                                <div style="float:left; margin-right:10px; padding:5px 0; overflow:hidden; display:block"><span id="index_charts_title" style="font-size:14px"></span> <span id="index_charts_item_name" style="font-size:14px; color:#d64126"></span></div>
                                <div style="float:right; margin-right:10px; padding:5px 0; overflow:hidden; display:block"><span style="font-size:14px; color:#999999"></span><span style="font-size:14px; color:#ee583d"></span></div>
                            </div> 
                            <div id="index_block_charts" style="width:96%; margin:0 auto; max-height:250px; overflow:hidden; display:block"></div>
                        </div>
                    </div>
                </div>
<script type="text/javascript">
var current_type="ereryday";
var current_date_type="today";
var current_charts_id="";
var current_charts_item="";
$(function(){
    index_view_index_loading=layer.load(0, {
        shade: [0.3, '#000000']
    });
    //初始化开始数据
    var sales_play_today_sales_fund=0;
    var sales_play_today_sales_num=0;
    var sales_play_thismonth_sales_fund=0;
    var sales_play_thismonth_sales_num=0;
    
    var sales_play_total_stock_fund=0;
    var sales_play_total_stock_num=0;
    
    $.ajax({
        url:"model-addup-bi-factory", 
        async: true,
        type: "POST",
        data:{func:"boss_addup_index"},
        dataType:"json",
        success: function(html){
            layer.close(index_view_index_loading);
            var options = {
                            useEasing : true, 
                            useGrouping : true, 
                            separator : ',', 
                            decimal : '.', 
                            prefix : '', 
                            suffix : '' 
                            };
            if (parseInt(html["today_sales_fund"])==0)
            {
                $("#sales_play_today_sales_fund").html("暂无数据");
            }
            else if (sales_play_today_sales_fund<parseInt(html["today_sales_fund"]))
            {
                var current_sales_play_today_sales_fund = new CountUp("sales_play_today_sales_fund", sales_play_today_sales_fund, parseInt(html["today_sales_fund"]), 0, 1, options);
                current_sales_play_today_sales_fund.start();
                sales_play_today_sales_fund=parseInt(html["today_sales_fund"]);
            }
            
            if (parseInt(html["today_sales_num"])==0)
            {
                $("#sales_play_today_sales_num").html("暂无数据");
            }
            else if (sales_play_today_sales_num<parseInt(html["today_sales_num"]))
            {
                var current_sales_play_today_sales_num = new CountUp("sales_play_today_sales_num", sales_play_today_sales_num, parseInt(html["today_sales_num"]), 0, 1, options);
                current_sales_play_today_sales_num.start();
                sales_play_today_sales_num=parseInt(html["today_sales_num"]);
            }
            
            if (parseInt(html["thismonth_sales_fund"])==0)
            {
                $("#sales_play_thismonth_sales_fund").html("暂无数据");
            }
            else if (sales_play_thismonth_sales_fund<parseInt(html["thismonth_sales_fund"]))
            {
                var current_sales_play_thismonth_sales_fund = new CountUp("sales_play_thismonth_sales_fund", sales_play_thismonth_sales_fund, parseInt(html["thismonth_sales_fund"]), 0, 1, options);
                current_sales_play_thismonth_sales_fund.start();
                sales_play_thismonth_sales_fund=parseInt(html["thismonth_sales_fund"]);
            }
            
            if (parseInt(html["thismonth_sales_num"])==0)
            {
                $("#sales_play_thismonth_sales_num").html("暂无数据");
            }
            else if (sales_play_thismonth_sales_num<parseInt(html["thismonth_sales_num"]))
            {
                var current_sales_play_thismonth_sales_num = new CountUp("sales_play_thismonth_sales_num", sales_play_thismonth_sales_num, parseInt(html["thismonth_sales_num"]), 0, 1, options);
                current_sales_play_thismonth_sales_num.start();
                sales_play_thismonth_sales_num=parseInt(html["thismonth_sales_num"]);
            }

            if (parseInt(html["total_stock_fund"])==0)
            {
                $("#sales_play_total_stock_fund").html("暂无数据");
            }
            else if (sales_play_total_stock_fund<parseInt(html["total_stock_fund"]))
            {
                var current_sales_play_total_stock_fund = new CountUp("sales_play_total_stock_fund", sales_play_total_stock_fund, parseInt(html["total_stock_fund"]), 0, 1, options);
                current_sales_play_total_stock_fund.start();
                sales_play_total_stock_fund=parseInt(html["total_stock_fund"]);
            }
            
            if (parseInt(html["total_stock_num"])==0)
            {
                $("#sales_play_total_stock_num").html("暂无数据");
            }
            else if (sales_play_total_stock_num<parseInt(html["total_stock_num"]))
            {
                var current_sales_play_total_stock_num = new CountUp("sales_play_total_stock_num", sales_play_total_stock_num, parseInt(html["total_stock_num"]), 0, 1, options);
                current_sales_play_total_stock_num.start();
                sales_play_total_stock_num=parseInt(html["total_stock_num"]);
            }
        }
    });
    
    click_rank_type("", "everyday");
    
    setInterval(function(){
        if (flag_view_index_setInterval==1)
        {        
            $.ajax({
                url:"model-addup-bi-factory", 
                async: true,
                type: "POST",
                data:{func:"boss_addup_index"},
                dataType:"json",
                success: function(html){
                    var options = {
                                    useEasing : true, 
                                    useGrouping : true,
                                    separator : ',',
                                    decimal : '.',
                                    prefix : '',
                                    suffix : ''
                                    };
                    if (sales_play_today_sales_fund<parseInt(html["today_sales_fund"]))
                    {
                        var current_sales_play_today_sales_fund = new CountUp("sales_play_today_sales_fund", sales_play_today_sales_fund, parseInt(html["today_sales_fund"]), 0, 1, options);
                        current_sales_play_today_sales_fund.start();
                        sales_play_today_sales_fund=parseInt(html["today_sales_fund"]);
                    }
                    
                    if (sales_play_today_sales_num<parseInt(html["today_sales_num"]))
                    {
                        var current_sales_play_today_sales_num = new CountUp("sales_play_today_sales_num", sales_play_today_sales_num, parseInt(html["today_sales_num"]), 0, 1, options);
                        current_sales_play_today_sales_num.start();
                        sales_play_today_sales_num=parseInt(html["today_sales_num"]);
                    }
                    
                    if (sales_play_thismonth_sales_fund<parseInt(html["thismonth_sales_fund"]))
                    {
                        var current_sales_play_thismonth_sales_fund = new CountUp("sales_play_thismonth_sales_fund", sales_play_thismonth_sales_fund, parseInt(html["thismonth_sales_fund"]), 0, 1, options);
                        current_sales_play_thismonth_sales_fund.start();
                        sales_play_thismonth_sales_fund=parseInt(html["thismonth_sales_fund"]);
                    }
                    
                    if (sales_play_thismonth_sales_num<parseInt(html["thismonth_sales_num"]))
                    {
                        var current_sales_play_thismonth_sales_num = new CountUp("sales_play_thismonth_sales_num", sales_play_thismonth_sales_num, parseInt(html["thismonth_sales_num"]), 0, 1, options);
                        current_sales_play_thismonth_sales_num.start();
                        sales_play_thismonth_sales_num=parseInt(html["thismonth_sales_num"]);
                    }
                    
                    if (sales_play_total_stock_fund<parseInt(html["total_stock_fund"]))
                    {
                        var current_sales_play_total_stock_fund = new CountUp("sales_play_total_stock_fund", sales_play_total_stock_fund, parseInt(html["total_stock_fund"]), 0, 1, options);
                        current_sales_play_total_stock_fund.start();
                        sales_play_total_stock_fund=parseInt(html["total_stock_fund"]);
                    }
                    
                    if (sales_play_total_stock_num<parseInt(html["total_stock_num"]))
                    {
                        var current_sales_play_total_stock_num = new CountUp("sales_play_total_stock_num", sales_play_total_stock_num, parseInt(html["total_stock_num"]), 0, 1, options);
                        current_sales_play_total_stock_num.start();
                        sales_play_total_stock_num=parseInt(html["total_stock_num"]);
                    }
                }
            });
            
            setInterval_refresh_rank_type(current_type, current_date_type, current_charts_id, current_charts_item);
        }
    },30000);
});

function setInterval_refresh_rank_type(var_type, date_type, var_charts_id, var_charts_item)
{
    $("#tag_rank_everyday").parent().find(".listaddupbytype").removeClass('listaddupbytypeselect');
    if (var_type=="everyday")
    {
        $("#tag_rank_everyday").addClass("listaddupbytypeselect");
    }
    else
    {
        $("#tag_rank_products").addClass("listaddupbytypeselect");
    
        $("#addupbytime_today").parent().find(".listaddupbytime").removeClass('listaddupbytimeselect');
        if (date_type=="today")
        {
            $("#addupbytime_today").addClass("listaddupbytimeselect");
        }
        else
        {
            $("#addupbytime_today").next().addClass("listaddupbytimeselect");
        }
    }

    if (var_type=="everyday")
    {
        $("#index_charts_title").css("color","#058DC7");
        $("#index_charts_title").html("销售资金走势分析 [连续14天]");
        
        $.ajax({
            url:"view-index-get-everyday-sales-factory", 
            async: true,
            type: "POST",
            data:"",
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });       
    }    
    else if (var_type=="products")
    {
        $("#index_charts_title").css("color","#058DC7");
        $("#index_charts_title").html("商品销量走势分析 [连续14天]");
        
        $.ajax({
            url:"view-index-get-products-rank-factory", 
            async: true,
            type: "POST",
            data:{var_date_type:date_type},
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });       
    }
    
    click_charts_type(var_type, var_charts_id, var_charts_item);
}

function click_rank_type(obj,type)
{
    current_type=type;
    
    if (type=="everyday")
    {
       $("#tag_date").hide(); 
    }
    else
    {
        current_date_type="today";
        
        $("#tag_date").show(); 
        $("#addupbytime_today").parent().find(".listaddupbytime").removeClass('listaddupbytimeselect');
        $("#addupbytime_today").addClass("listaddupbytimeselect");
    }
    
    if (obj)
    {
        obj.parent().find(".listaddupbytype").removeClass('listaddupbytypeselect');
        obj.addClass("listaddupbytypeselect");
    }
    else
    {
        $("#tag_rank_ereryday").parent().find(".listaddupbytype").removeClass('listaddupbytypeselect');
        $("#tag_rank_ereryday").addClass("listaddupbytypeselect");
    }

    if (type=="everyday")
    {
        $("#index_charts_title").css("color","#058DC7");
        $("#index_charts_title").html("销售资金走势分析 [连续14天]");
        
        $.ajax({
            url:"view-index-get-everyday-sales-factory", 
            async: true,
            type: "POST",
            data:"",
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });       
    }
    else if (type=="products")
    {
        $("#index_charts_title").css("color","#50B432");
        $("#index_charts_title").html("商品销量走势分析 [连续14天]");
        
        $.ajax({
            url:"view-index-get-products-rank-factory", 
            async: true,
            type: "POST",
            data:{var_date_type:"today"},
            success: function(html){
                $("#index_block_rank").html(html);
            }
        });       
    }
    
    $("#index_charts_item_name").html("");
    
    click_charts_type(type, "");
}

function click_rank_datetype(obj,datetype)
{
    current_date_type=datetype;
    
    if (obj)
    {
        obj.parent().find(".listaddupbytime").removeClass('listaddupbytimeselect');
        obj.addClass("listaddupbytimeselect");
    }

    $.ajax({
        url:"view-index-get-products-rank-factory", 
        async: true,
        type: "POST",
        data:{var_date_type:datetype},
        success: function(html){
            $("#index_block_rank").html(html);
        }
    }); 
}

function click_charts_type(charts_type,charts_id,charts_item)
{
    current_charts_id=charts_id;
    current_charts_item=charts_item;
    
    if (charts_id)
    {
        if (charts_item)
        {
            $("#index_charts_item_name").html("["+charts_item+"]");
        }
        else
        {
            $("#index_charts_item_name").html("["+charts_id+"]");
        }
    }
    
    $.ajax({
        url:"view-index-get-charts-factory", 
        async: true,
        type: "POST",
        data:{var_type:charts_type,var_charts_id:charts_id},
        success: function(html){
            $("#index_block_charts").html(html);
        }
    });
}
</script>
<?php
    }
}
?>
