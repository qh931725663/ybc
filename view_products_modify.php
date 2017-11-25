<?php

include_once("check_dangkou_user.php");

$p_product=cselect("*","ydf_products",array("p_bianhao=?",$_REQUEST["var_p_bianhao"]));
$rowproduct=$p_product[0]->fetch();

$all_size_value_str="";
$p_product_size=cselect("p_type_size","ydf_products_type",array("p_type_p_bianhao=?",$_REQUEST["var_p_bianhao"]),"p_type_size");
$size_idx=0;
while($rowproductsize=$p_product_size[0]->fetch())
{
    if ($size_idx==0)
    {
        $all_size_value_str=$rowproductsize["p_type_size"];
    }
    else
    {
        $all_size_value_str.=",".$rowproductsize["p_type_size"];
    }
    $size_idx++;
}
?>
	            <link rel="stylesheet" type="text/css" href="/libs/oss/style.css"/>
                <div class="xgsp_box">
                    <div class="btn_box">
                        <div class="rt">
                            <span class="btn_normal_red" onclick="/**/mount_to_frame('view_products_list',0,'frame_products_list')">返回</span>
                        </div>
                    </div>
                    
<form method="post" id="products_modify_form">
                    <div class="form_box">
                        <div>
                            <div><span>*</span> 货号：</div>
                            <div><input id="product_huohao" name="product_huohao" type="text" size="10" maxlength="10" value="<?php echo $rowproduct["p_huohao"]?>" style="width:33%"></div>
                        </div>
                        <div>
                            <div><span>*</span> 出品档口：</div>
                            <div><input id="product_store" name="product_store" type="text" size="10" maxlength="50" value="<?php echo $rowproduct["p_store"]?>" style="width:33%"></div>
                        </div>
                        <div>
                            <div><span>*</span> 面料成分：</div>
                            <div><input id="product_composition" name="product_composition" type="text" size="30" maxlength="100" value="<?php echo $rowproduct["p_composition"]?>" style="width:33%"></div>
                        </div>
                        <div>
                            <div><span>*</span> 颜色：</div>
                            <div>
                                <?php
                                $p_product_color=cselect("*","ydf_products_type",array("p_type_p_bianhao=?",$_REQUEST["var_p_bianhao"]),"p_type_color","p_type_bianhao");
                                $color_idx=1;
                                while($rowproductcolor=$p_product_color[0]->fetch())
                                {
                                ?>
                                <div style="width:100%" class="lf">
                                    <div class="lf"><input name="table_color[<?php echo $color_idx ?>][color_checkbox]" type="checkbox" style="margin:5px" value="1" checked/></div>
                                    <div style="margin-left:10px" class="lf"><input name="table_color[<?php echo $color_idx ?>][color]" type="text" size="15" maxlength="20" style="padding:5px; border:0; border-bottom:1px solid #999999" value="<?php echo $rowproductcolor["p_type_color"] ?>"></div>
                                    <div style="margin-left:10px; padding:5px 0; color:#999999" class="lf">修改为：</div>
                                    <div style="margin-left:10px" class="lf"><input name="table_color[<?php echo $color_idx ?>][color_new]" type="text" size="15" maxlength="20" style="padding:5px; border:0; border-bottom:1px solid #999999"></div>
                                </div>
                                <?php
                                    $color_idx++;
                                }
                                ?>
                                <div style="width:100%" class="lf">
                                    <div class="lf"><input class="color_select" name="color_select" type="checkbox" style="margin:5px"/></div>
                                    <div style="margin-left:10px" class="lf"><input class="color_vale_select" name="color_value_select" type="text" size="15" maxlength="20" style="padding:5px; border:0; border-bottom:1px solid #999999; color:#cccccc" value="选择后输入颜色" readonly></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div><span>*</span> 尺码：</div>
                            <div><input class="size_type" name="size_type" type="radio" style="margin:5px" value="1" <?php echo $rowproduct["p_size_type"]=="1"?"checked":""?>/> 中国码 <input class="size_type" name="size_type" type="radio" style="margin:5px" value="2" <?php echo $rowproduct["p_size_type"]=="2"?"checked":""?>/> 欧码</div>
                        </div>
                        <div id="china_value_select" style="display:<?php echo $rowproduct["p_size_type"]=="1"?"block":"none"?>">
                            <div style="width:20%; height:25px" class="lf"></div>
                            <div style="width:80%" class="lf">
                                <div style="width:100%" class="lf">
                                    <span><input class="size_china_value" name="table_size[1][size]" type="checkbox" value="S" <?php echo strstr($all_size_value_str,"S")?"checked":"" ?>/> S</span>
                                    <span><input class="size_china_value" name="table_size[2][size]" type="checkbox" value="M" <?php echo strstr($all_size_value_str,"M")?"checked":"" ?>/> M</span>
                                    <span><input class="size_china_value" name="table_size[3][size]" type="checkbox" value="L" <?php echo strstr($all_size_value_str,"L")?"checked":"" ?>/> L</span>
                                    <span><input class="size_china_value" name="table_size[4][size]" type="checkbox" value="XL" <?php echo strstr($all_size_value_str,"XL")?"checked":"" ?>/> XL</span>
                                    <span><input class="size_china_value" name="table_size[5][size]" type="checkbox" value="2XL" <?php echo strstr($all_size_value_str,"2XL")?"checked":"" ?>/> 2XL</span>
                                    <span><input class="size_china_value" name="table_size[6][size]" type="checkbox" value="3XL" <?php echo strstr($all_size_value_str,"3XL")?"checked":"" ?>/> 3XL</span>
                                    <span><input class="size_china_value" name="table_size[7][size]" type="checkbox" value="4XL" <?php echo strstr($all_size_value_str,"4XL")?"checked":"" ?>/> 4XL</span>
                                    <span><input class="size_china_value" name="table_size[8][size]" type="checkbox" value="5XL" <?php echo strstr($all_size_value_str,"5XL")?"checked":"" ?>/> 5XL</span>
                                    <span><input class="size_china_value" name="table_size[9][size]" type="checkbox" value="6XL" <?php echo strstr($all_size_value_str,"6XL")?"checked":"" ?>/> 6XL</span>
                                </div>
                            </div>
                        </div>
                        <div id="europe_value_select" style="display:<?php echo $rowproduct["p_size_type"]=="2"?"block":"none"?>">
                            <div style="width:20%; height:25px" class="lf"></div>
                            <div style="width:80%" class="lf">
                                <div style="width:100%" class="lf">
                                    <span><input class="size_europe_value" name="table_size[1][size]" type="checkbox" value="27" <?php echo strstr($all_size_value_str,"27")?"checked":"" ?>/> 27</span>
                                    <span><input class="size_europe_value" name="table_size[2][size]" type="checkbox" value="28" <?php echo strstr($all_size_value_str,"28")?"checked":"" ?>/> 28</span>
                                    <span><input class="size_europe_value" name="table_size[3][size]" type="checkbox" value="29" <?php echo strstr($all_size_value_str,"29")?"checked":"" ?>/> 29</span>
                                    <span><input class="size_europe_value" name="table_size[4][size]" type="checkbox" value="30" <?php echo strstr($all_size_value_str,"30")?"checked":"" ?>/> 30</span>
                                    <span><input class="size_europe_value" name="table_size[5][size]" type="checkbox" value="31" <?php echo strstr($all_size_value_str,"31")?"checked":"" ?>/> 31</span>
                                    <span><input class="size_europe_value" name="table_size[6][size]" type="checkbox" value="32" <?php echo strstr($all_size_value_str,"32")?"checked":"" ?>/> 32</span>
                                    <span><input class="size_europe_value" name="table_size[7][size]" type="checkbox" value="33" <?php echo strstr($all_size_value_str,"33")?"checked":"" ?>/> 33</span>
                                    <span><input class="size_europe_value" name="table_size[8][size]" type="checkbox" value="34" <?php echo strstr($all_size_value_str,"34")?"checked":"" ?>/> 34</span>
                                    <span><input class="size_europe_value" name="table_size[9][size]" type="checkbox" value="35" <?php echo strstr($all_size_value_str,"35")?"checked":"" ?>/> 35</span>
                                    <span><input class="size_europe_value" name="table_size[10][size]" type="checkbox" value="36" <?php echo strstr($all_size_value_str,"36")?"checked":"" ?>/> 36</span>
                                    <span><input class="size_europe_value" name="table_size[11][size]" type="checkbox" value="37" <?php echo strstr($all_size_value_str,"37")?"checked":"" ?>/> 37</span>
                                    <span><input class="size_europe_value" name="table_size[12][size]" type="checkbox" value="38" <?php echo strstr($all_size_value_str,"38")?"checked":"" ?>/> 38</span>
                                    <span><input class="size_europe_value" name="table_size[13][size]" type="checkbox" value="39" <?php echo strstr($all_size_value_str,"39")?"checked":"" ?>/> 39</span>
                                    <span><input class="size_europe_value" name="table_size[14][size]" type="checkbox" value="40" <?php echo strstr($all_size_value_str,"40")?"checked":"" ?>/> 40</span>
                                    <span><input class="size_europe_value" name="table_size[15][size]" type="checkbox" value="41" <?php echo strstr($all_size_value_str,"41")?"checked":"" ?>/> 41</span>
                                    <span><input class="size_europe_value" name="table_size[16][size]" type="checkbox" value="42" <?php echo strstr($all_size_value_str,"42")?"checked":"" ?>/> 42</span>
                                    <span><input class="size_europe_value" name="table_size[17][size]" type="checkbox" value="43" <?php echo strstr($all_size_value_str,"43")?"checked":"" ?>/> 43</span>
                                    <span><input class="size_europe_value" name="table_size[18][size]" type="checkbox" value="44" <?php echo strstr($all_size_value_str,"44")?"checked":"" ?>/> 44</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div><span>*</span> 批发价：</div>
                            <div><input id="product_saleprice" name="product_saleprice" type="text" size="10" maxlength="10" style="padding:5px;width:33%" value="<?php echo $rowproduct["p_saleprice"]?>"/></div>
                        </div>
                        <div>
                            <div>大客价：</div>
                            <div><input id="product_vipprice" name="product_vipprice" type="text" size="10" maxlength="10" style="padding:5px;width:33%" value="<?php echo $rowproduct["p_vipprice"]?>"/></div>
                        </div>
                        <div style="margin-left:15%;">
                            <form name=theform>
                            <input type="radio" name="myradio" value="local_name" style="display:none;" />
                            <input type="hidden" name="myradio" value="random_name" checked/>
                            </form>

                            <h4 style="margin-top:5px;">您所选择的文件列表：</h4>
                            <div id="ossfile"></div>
                            <div style="font-size:16px;font-weight:bold;padding-bottom:5px;">商品图片：</div>
                            <div style="margin:5px 0;">
                                <?php
                                    if(!empty($rowproduct["p_pic"])){
                                        $url='https://ybc-image.oss-cn-hangzhou.aliyuncs.com/'.$rowproduct["p_pic"].'?x-oss-process=style/list';
                                    }else{
                                        $url="/pc/images/nopic.jpg";
                                    }
                                ?>
                                <div id="viewproduct_pic" style="background: url(<?php echo $url?>) #ffffff center center no-repeat;">
                                <input id="product_pic" name="product_pic" type="hidden" value="<?php echo $rowproduct["p_pic"]?>">
                                <!--<input id="uploadpic" name="uploadpic" accept="image/*" type="file" onchange="UploadProductPic()">-->
                                </div>
                                <div id="container">
                                    <a id="selectfiles" href="javascript:void(0);" class='btn'>选择文件</a>
                                    <a id="postfiles" href="javascript:void(0);" class='btn'>开始上传</a>
                                </div>

                            </div>
                        </div>
                        <input type="hidden" name="product_bianhao" value="<?php echo $_REQUEST["var_p_bianhao"] ?>">
                        <input type="hidden" name="func" value="update_product">
                        <div style="width:80%; margin:30px 0 0 20%" class="lf of dp">
                            <span id="notice_message" class="lf"></span>
                        </div>    
                        <div style="width:100%; padding:0 0" class="lf dp pt">
                            <div style="width:15%; height:25px" class="lf"></div>
                            <div style="width:80%" class="lf">

                                <span id="btn_modifyproduct_submit" class="btn_normal"> 确认修改 </span>

                            </div>
                        </div>
                    </div>

</form>
                    
                </div>
                
<script type="text/javascript">    
var color_idx=<?php echo $color_idx?>;
$(function(){    
    $(".color_select").change(function(){
        if ($(this).is(":checked"))
        {                            
            var add_html="<div style='float:left; width:100%'>" +
                         "    <div style='float:left'><input class='color_selected' name='table_color["+color_idx+"][color_checkbox]' type='checkbox' style='margin:5px' onchange='EmptyColorSelected(this)' value='1' checked/></div>" +
                         "    <div style='float:left; margin-left:10px'><input class='color_vale_selected' name='table_color["+color_idx+"][color]' type='text' size='15' maxlength='20' style='padding:5px; border:0; border-bottom:1px solid #999999; color:#333333'></div>" +
                         "</div>";
                         
            $(this).parent().parent().before(add_html);
            $(this).attr("checked",false);
            
            color_idx++;
        }
    });
    
    $(".size_type").change(function(){
        if ($('input:radio[name="size_type"]:checked').val()=="1")
        {
            $(".size_europe_value").each(function(){
               $(this).attr("checked",false);
            });
            $("#china_value_select").show();
            $("#europe_value_select").hide();
        }
        
        if ($('input:radio[name="size_type"]:checked').val()=="2")
        {
            $(".size_china_value").each(function(){
               $(this).attr("checked",false);
            });
            $("#china_value_select").hide();
            $("#europe_value_select").show();
        }
    });
    
    $('#btn_modifyproduct_submit').click(function(){
        if ($("#product_huohao").val()=="")
        {
            $("#notice_message").html("<img src=/pc/images/error.png> <span style='color:red'>请填写商品货号！</span>");
            return false;
        }
        
        if ($("#product_store").val()=="")
        {
            $("#notice_message").html("<img src=/pc/images/error.png> <span style='color:red'>请填写商品出品档口！</span>");
            return false;
        }

        if ($("#product_composition").val()=="")
        {
            $("#notice_message").html("<img src=/pc/images/error.png> <span style='color:red'>请填写商品面料成分！</span>");
            return false;
        }
        
        if ($("#product_saleprice").val()=="")
        {
            $("#notice_message").html("<img src=/pc/images/error.png> <span style='color:red'>请填写批发价！</span>");
            return false;
        }
        
        $.ajax({
            url:"model-product-api", 
            async: false,
            type: "POST",
            data:$('#products_modify_form').serialize(),
            dataType:"json",
            success: function(html){
                if (html["state"]=="ok")
                {
                    layer.msg("商品修改成功！", {time: 2000, icon:1});
                    setTimeout(function(){
                        mount_to_frame('view_products_list',1,'frame_products_list');
                    },2000);
                }
                else
                {
                    layer.msg(html["desc"], {time: 2000, icon:2});
                }
            }
        });    
    });
});

function EmptyColorSelected(obj_val)
{
   $(obj_val).parent().parent().empty();
}

function UploadProductPic()
{
    var formData = new FormData($( "#products_modify_form" )[0]);  
    $.ajax({  
        url: '/postuploadpic' ,  
        type: 'POST',  
        data: formData,  
        async: false,  
        cache: false,  
        contentType: false,  
        processData: false,  
        success: function (returndata) {  
            $("#viewproduct_pic").css("background-image","url(" + returndata + ")");
            $("#product_pic").val(returndata);
        },  
        error: function (returndata) {  
          alert("上传失败！请稍后再试。");  
        }  
    });
}
$('#pid_view_products_modify').on('keydown',function(e){
    if(e.keyCode == 13){
        //模拟点击登陆按钮，触发上面的 Click 事件
        $('#pid_view_products_modify input,select').blur();
        $("#btn_modifyproduct_submit").click();
    }
});
</script>
<script type="text/javascript" src="/libs/oss/lib/plupload-2.1.2/js/plupload.full.min.js"></script>
<script type="text/javascript" src="/libs/oss/upload.js"></script>
