<div style="float:left; width:100%; margin-top:10px; overflow:hidden; display:block;">
    <div  style="float:left; width:100%; margin:10px 0; padding:5px; overflow:hidden; display:block">
        <div style="float:left; overflow:hidden; display:block">
            <input type="hidden" id="order_type" name="order_type"/>
            <span class="listtypevalue listtypeselect">全部</span>
        </div>
        <div style="float:right; overflow:hidden; display:block">
            <span style="float:left; overflow:hidden; display:block">
                <span style="padding:5px 0">日期 <input type="text" class="datepicker" name="search_store_dangkoubuhuo_from_date"  size="12" maxlength="50" readonly="readonly" style="padding:5px"> 至 <input type="text" class="datepicker" name="search_sotre_dangkoubuhuo_to_date"  size="12" maxlength="50" readonly="readonly" style="padding:5px">
                </span>
            </span>
            <span id="btn_chukuorder_search" class="btn_normal_red">搜索</span>
        </div>
    </div>
    <div class="title_stalls" style="position:relative; float:left; width:100%; margin-top:0px; background:#f2f2f2; border-bottom:1px solid #cccccc; display:block">
        <div style="width:15%;">日期</div>
        <div style="width:15%;">工厂</div>
        <div style="width:15%;">手机号</div>
        <div style="width:10%;">付款金额</div>
        <div style="width:35%;">工厂资金账户</div>
        <div style="width:10%;">状态</div>
    </div>

    
    <div class="list_stalls" style="position:relative;width:100%; padding:10px 0; border-bottom:1px dashed #cccccc; overflow:hidden; display:block">
        <div style="width:15%;"><span style="color:#ee583d">-</span></div>
        <div style="width:15%;"><span style="color:#0099FF">-</span></div>
        <div style="width:15%;"><span style="color:#ee583d">-</span></div>
        <div style="width:10%;"><span style="color:#ee583d">-</span></div>
        <div style="width:35%;"><span style="color:#ee583d">-</span></div>
        <div style="width:10%;"><span style="color:#ee583d">-</span></div>
        
        <div style="float:left;width:100%; margin:0 auto; padding:10px 0; overflow:hidden; display:block;">
            <div style="float:right; padding:5px 0">
                <span style="float:left"><span style="color:#999999">最近一次付款日期：</span>-</span>
                <span style="float:left; margin-left:10px"><span style="color:#999999">付款人：</span>-</span>
                <span style="float:left; margin-left:10px"><span style="color:#999999">付款金额：</span>-</span>                                    
            </div>
        </div>
    </div>                    
    <div class="record"> 共 <span class="record_num">0</span> 条记录</div>

</div>

<script type="text/javascript">
    $(document).ready(function() {

        $(".datepicker").datepicker({duration:""});
        $(".datepicker").datepicker({duration:""});//绑定输入框

    });
</script>