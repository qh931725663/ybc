<?php 
include_once "{$root_path}/model/model_bi.php";
?>
<script type="text/javascript">    
function search_agent_finance_addup()
{
    $("#pid_view_finance_bi_pool_summary #pages_agent_finance_addup").set_page_num("view_finance_bi_pool_summary","pages_agent_finance_addup",1);

    refresh_inner("view_finance_bi_pool_summary?"+$("#form_agent_finance_addup").serialize() );

}

function clean_search_bi_pool_summary()
{
    mount_to_frame('view_finance_bi_pool_summary',1,'frame_finance_bi_pool_summary');
}
</script>
                    <form id="form_agent_finance_addup">
                    <div class="search_box">

                        <div class="search_box_inner">
                            <div class="txhz_a" style="margin-bottom:12px;">
                                <span class="lf">
                                    <select  name="factory_id" style="padding:5px;">
                                            <option value="">选择工厂</option>
                                            <?php get_factory_option(); ?>
                                    </select>
                                </span>
                                <span onclick="search('view_agent_finance_addup','form_agent_finance_addup')" class="btn_normal_blue public_search_sm">搜索</span>
                                <span class="clear_search" onclick="mount_to_frame('view_agent_finance_addup',1,'frame_agent_finance_addup')">清空<br>条件</span>
                            </div>
                            <div class="txhz_b" style="margin-right:10px;"><span style="color:#333; font-size:20px">总欠款：</span>
                                <span style="color:#ee583d; font-size:20px; font-weight:bold;" id="agent_finance_zongqiankuan">
                                <?php
                                    include_once "{$root_path}/model/model_bi.php";
                                    $ymd="day";

                                    @$factory_bianhao=$_REQUEST["factory_id"];
                                    list($historys,$addup)=get_history_agent_gcyf($ymd,@$factory_bianhao);
                                    debug($addup);
                                    echo sum_addup($addup);

                                ?>
                                </span>
                            </div>

                        </div>
                    </div>
                    <input id="page_idx" name="page_idx" type="hidden" value="1">
                    </form>

                <div id="pagelist">

                    <div class="report_table_header" style="margin-top:0px; background:#f2f2f2">
                        <div style="width:13%; color:#999999; text-align:center">工厂</div>
                        <div style="width:13%; color:#999999; text-align:center">最近交易时间</div>
                        <div style="width:13%; color:#999999; text-align:center">类型</div>
                        <div style="width:12%; color:#999999; text-align:center">单号</div>
                        <div style="width:12%; color:#999999; text-align:center">数量</div>
                        <div style="width:12%; color:#999999; text-align:center">金额</div>
                        <div style="width:13%; color:#999999; text-align:center">结余资产</div>
                        <div style="width:12%; color:#999999; text-align:center">对账</div>
                    </div>
                <!-- refresh_begin -->
                <span id="agent_finance_zqk" style="display:none;"><?php echo sum_addup($addup); ?></span>
                    <?php
                        include_once "{$root_path}/model/model_bi.php";
                        $ymd="day";
                        @$page=$_REQUEST["page_idx"]?$_REQUEST["page_idx"]:1;$pagesize=20;$offset=($page-1)*$pagesize;
                        @$factory_bianhao=$_REQUEST["factory_id"];
                        list($historys,$addup)=get_history_agent_gcyf($ymd,@$factory_bianhao);
                        debug($addup);
                        $rowcount=count($addup);
                        $page_count=ceil($rowcount/$pagesize);
                        $ret=[];
                        foreach ($addup as $key=>$value)
                        {
                            //$ret[]=$value;
                            $ret[]=$historys[$value["now"] ];
                        }
                        $sorts=sort_rows($ret,array("bill_day","bill_factory_id"),1);
                        for ($i=$offset;$i<$offset+$pagesize && $i<$rowcount;$i++)
                        {
                            $idx=$rowcount-1-$i;
                            $row=$ret[$sorts[$idx][0]];

                            debug($row);
                            $p=rselect("factory_name","ydf_factory",array("factory_bianhao=?",$row["bill_factory_id"]));
                            if($ro=$p->fetch()){
                                $nam=$ro["factory_name"];
                            }
                        ?>

                        <div class="report_table_body" style="border-bottom:1px dashed #cccccc">
                            <div style="width:13%; text-align:center"><?php echo $nam?></div>
                            <div style="width:13%; text-align:center">-</div>
                            <div style="width:13%; text-align:center">-</div>
                            <div style="width:12%; text-align:center">-</div>
                            <div style="width:12%; text-align:center">-</div>
                            <div style="width:12%; text-align:center">-</div>
                            <div style="width:13%; text-align:center"><?php echo $row["sum"]["pool"]?></div>
                            <div style="width:12%; text-align:center">
                                <span style="color:#0099FF; cursor:pointer" onclick="PayFund(<?php echo $row["bill_factory_id"] ?>)">主动付款</span> |
                                <span style="color:#0099FF; cursor:pointer" onclick="/**/ClickAgentFinanceDetail(<?php echo $row["bill_factory_id"]?>)">对账</span>

                            </div>
                        </div>
                        <div id="layer_agent_finance_detail_<?php echo $row["bill_factory_id"]?>" style="float:left; width:100%; background:#f2f2f2; overflow:hidden; display:none">
                        </div>
                    <?php
                    }
                    ?>

                    <div class="record"> 共 <span class="record_num"><?php echo $rowcount?></span> 条记录</div>

<script>/*n*/
    $("#agent_finance_zongqiankuan").html($("#agent_finance_zqk").html());
    $("#pid_view_agent_finance_addup #pages_agent_finance_addup").set_page_count("view_agent_finance_addup","pages_agent_finance_addup",<?php echo $page_count;?>);
</script>

<!-- refresh_end -->
    <div class="ipages" input_idx_id="#pid_view_agent_finance_addup #page_idx" id="pages_agent_finance_addup" page="view_agent_finance_addup" form="form_agent_finance_addup" count="<?php echo $page_count; ?>"/>
                     <!-- 页码也作为表单项统一处理  -->
                </div>
                                        <div id="layer_modifyfund">
                                        
                                        </div>
                <div id="layer_factory_getcash_confirm" style="float:left; width:500px; padding:30px; overflow:visible; display:none">

                </div>
                
<script type="text/javascript">
function ClickAgentFinanceDetail(factory_id){
    if ($("#layer_agent_finance_detail_"+factory_id).is(":visible")==false)
    {
        $("#layer_agent_finance_detail_"+factory_id).show();
        mount_to_frame('view_get_agent_finance_detail__'+factory_id+'?var_factory_id='+factory_id,0,'layer_agent_finance_detail_'+factory_id);
    }else{
        $("#layer_agent_finance_detail_"+factory_id).hide();
    }

    /*if ($("#layer_agent_finance_detail_"+factory_id).is(":visible")==false)
    {
        $.ajax({
            url:"view-get-agent-finance-detail", 
            async: false,
            type: "POST",
            data:{var_factory_id:factory_id},
            success: function(html){
                $("#layer_agent_finance_detail_"+factory_id).html(html);
                $("#layer_agent_finance_detail_"+factory_id).show();
            }
        });
    }
    else
    {
        $("#layer_agent_finance_detail_"+factory_id).hide();
    }*/
}

function ShowModifyFactoryFundLayer(factory_id, bill_time, fund_asset, fund_stock, fund_freeze, fund_active,opt){
    $.ajax({
        url:"view-get-modifyfactoryfund", 
        async: false,
        type: "POST",
        data:{var_factory_id:factory_id,var_bill_time:bill_time,var_fund_asset:fund_asset,var_fund_stock:fund_stock,var_fund_freeze:fund_freeze,var_fund_active:fund_active,var_opt:opt},
        success: function(html){
            $("#layer_modifyfund").html(html);
        }
    });    
    
    index_layer_modifyfund=layer.open({
        type: 1,
        area: ['420px', '370px'],
        title: false,
        content:$('#layer_modifyfund')
    });
}

function PostModifyFactoryFund(){
    if($("#modifyfactoryfund_opt_type").val()=="modify_asset" && !$("#modifyfactoryfund_fund_asset").val())
    {
        $("#modifyfactoryfund_tip_notice").html("<span style='font-size:14px; color:red'>亲，本期结余资产不能为空哦！</span>");
        return false;
    }
    
    if($("#modifyfactoryfund_opt_type").val()!="modify_asset" && !$("#modifyfactoryfund_fund_freeze").val())
    {
        $("#modifyfactoryfund_tip_notice").html("<span style='font-size:14px; color:red'>亲，本期交易中资金不能为空哦！</span>");
        return false;
    }
    
    if($("#modifyfactoryfund_opt_type").val()!="modify_asset" && !$("#modifyfactoryfund_fund_active").val())
    {
        $("#modifyfactoryfund_tip_notice").html("<span style='font-size:14px; color:red'>亲，本期结余可提现资金不能为空哦！</span>");
        return false;
    }
        
    $.ajax({
        url:"model-post-modifyfactoryfund", 
        async: false,
        type: "POST",
        data:$('#modifyfactoryfundform').serialize(),
        dataType:"json",
        success: function(html){
            if (html["state"]=="ok")
            {
                layer.close(index_layer_modifyfund);
                layer.msg("工厂资金修改成功！", {time: 2000, icon:1});
                setTimeout(function(){
                    refresh_inner("view_finance_bi_pool_summary?"+$("#form_agent_finance_addup").serialize() );
                },2000);
            }
            else
            {
                $("#modifyfactoryfund_tip_notice").html("<span style='font-size:14px; color:red'>"+html["desc"]+"</span>");
            }
        }
    });    
}

function PayFund(factory_id){
    $.ajax({
        url:"view-get-daixiao-pay",
        async: false,
        type: "POST",
        data:{var_factory_id:factory_id},
        success: function(html){
            $("#layer_factory_getcash_confirm").html(html);
        }
    });
   index_layer_factory_getcash_confirm=layer.open({
       type: 1,
       area: ['600px', '350px'],
       title: false,
       content:$('#layer_factory_getcash_confirm')
   });
   var factory_bank;
       $.ajax({
           url:"get-factory-bank",
           async: false,
           type: "GET",
           data:{var_factory_id:factory_id},
           dataType:"json",
           error:function(){

               layer.msg('系统错误', {time: 2000, icon:2});

           },
           success: function(html){
               factory_bank = html;
           }
       });
       console.log(factory_bank);
       $("#cash_available_num").empty();
       $("#cash_available_num").prepend(function(){
           for(var ele in factory_bank[0]){
               return "<span style='color:red'>"+factory_bank[0][0]+"</span>";
           }
       });
       $("#collection_fund_account").empty();
       for(var ele in factory_bank){
           if(ele=="bank_boss_id"){
               for(var i=0;i<factory_bank[ele].length;i++){
                   $("#collection_fund_account").prepend(function(){
                       return "<option value="+factory_bank[ele][i]+" class='zijin"+i+"'></option>";
                   });
               }
           }
           if(ele=="bank_name"){
               for(var i=0;i<factory_bank[ele].length;i++){
                   $(".zijin"+i+"").append(function(){
                       return "<span>"+factory_bank[ele][i]+"</span> ";
                   });
               }
           }
           if(ele=="bank_user_account"){
               for(var i=0;i<factory_bank[ele].length;i++){
                   $(".zijin"+i+"").append(function(){
                       return "<span>"+factory_bank[ele][i]+"</span> ";
                   });
               }
           }
           if(ele=="bank_user_name"){
               for(var i=0;i<factory_bank[ele].length;i++){
                   $(".zijin"+i+"").append(function(){
                       return "<span>"+factory_bank[ele][i]+"</span> ";
                   });
               }
           }
       }
}
</script>
