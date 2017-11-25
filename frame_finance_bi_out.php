<div class="tab_frame_div" >
    <div class="tab_button_div">
        <script>mount_to_frame('frame_finance_bi_out_summary',0,'frame_finance_bi_out');</script>
        <span class="tab_button_select" onclick="click_tab_7($(this));mount_to_frame('frame_finance_bi_out_summary',0,'frame_finance_bi_out')">供应商汇总</span>
        <span class="tab_button"        onclick="click_tab_7($(this));mount_to_frame('frame_finance_bi_out_month',0,'frame_finance_bi_out')">月度分析</span>
    </div>    
    <div id="frame_finance_bi_out" />
</div>
<script>
function click_tab_7(obj)
{
    obj.parent().find(".tab_button,.tab_button_select").css("border-bottom","1px solid #cccccc");
    obj.css("border-bottom","1px solid #ffffff");
}
</script>
                
