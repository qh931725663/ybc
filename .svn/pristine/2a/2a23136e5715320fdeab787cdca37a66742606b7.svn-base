<style type="text/css">
.barcodeImg{margin:0px}
</style>
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

<div style="margin:10px" class='noprint'>    
    <div id="bcBlock" style="display:none; margin-right:auto; margin-left:auto;width:130px">
        <div style='margin:0px'>合格证</div>
        <div  style='margin:0px'>出品：<span id='dealer'>B368</span></div>
        <div  style='margin:0px'>货号：<span id='product'>K01</span></div>
        <div  style='margin:0px'>规格：<span id='size'>黑色 29</span></div>
        <div  style='margin:0px'>成份：<span id='ingredient'>95%棉</span></div>
        <div id="bcTarget" class="barcodeImg" style="margin-top:0px;margin-bottom:0px" ></div>
        <div id="barcodeNum" style='margin:0px'>00000000</div>
    </div>            
</div>
<div  id="parent"/>

<script type="text/javascript">

function printBatch()
{
    var batch = [ {"bc":"112233445566","bc_count":"2","dealer":"B366","product":"F01","size":"黑色 77","ingredient":"99%棉"} ,
                    {"bc":"665544332211","bc_count":"3"}  ]
    code128(batch);
}
function code128(batch){
    $("#parent").empty();
    for (var i=0;i<batch.length;++i)
    {
        var barcode = batch[i]["bc"];
        var count = batch[i]["bc_count"];
        $("#bcTarget").empty().barcode(barcode, "code128",{barWidth:1.5, fontSize:15,barHeight:30,output:'bmp',showHRI:true});
        $("#dealer").html(batch[i]["dealer"]);
        $("#product").html(batch[i]["product"]);
        $("#size").html(batch[i]["size"]);
        !!batch[i]["ingredient"]?$("#ingredient").html(batch[i]["ingredient"]):$("#ingredient").html("");
        $("#barcodeNum").html(barcode);
        for (var j=0;j<count;++j){
            var temp = $("#bcBlock").clone();
            temp.css("display","block");
            temp.appendTo($("#parent"));
            if (j+1!=count){
                $("#parent").append("<div class='PageNext'></div><hr align='center' width='100%' size='1' noshade class='noprint'>");
            }
        }
        
        if (i+1!=batch.length){

            $("#parent").append("<div class='PageNext'></div><hr align='center' width='100%' size='2' noshade ><div class='PageNext'></div>");
        }
    }
    $(".barcodeImg").css("","")
}

function datamatrix(){
    $("#bcTarget").empty().barcode($("#src").val(), "datamatrix",{barWidth:2, barHeight:30,showHRI:false});
}
</script>
