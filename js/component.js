var _append=$.fn.append;
$.fn.extend({
    append:function(html){
        var res=_append.apply(this,[html]);
        append_complete(this);
        return res;
    }
});

function append_complete(obj)
{
    //初始化翻页容器
    obj.find(".ipages").init_ipages();
    $(".iedit_num").unbind("click").click(function(){
        obj=$(this);
        change_quantity(obj);//初始化点击拿货数量弹框
    });
    $(".iedit_price").unbind("click").click(function(){
        obj=$(this);
        change_pricetity(obj);//初始化单价弹框
    });
    $(".layui-layer-close").click(function(){
        obj=$(this);
        close_focus(obj);//初始化获取焦点
    });
    obj.find(".jianrongxing").init_jianrongxing();
    obj.find(".name_iime").init_name_iime();
    obj.find(".iinput").attr("required","required").css({"padding-right":"15px"});
    obj.find(".iinput").each(function(){
        if (!$(this).next().hasClass("iinput_clear")){
            obj.find(".iinput").after("<b class='iinput_clear'></b>");
        }
        if(!!window.ActiveXObject || "ActiveXObject" in window){
            $(this).on("keyup",function(){
                if($(this).val()!=""){
                    $(this).next(".iinput_clear").css("display","inline");
                }else{
                    $(this).next(".iinput_clear").css("display","none");
                }
            });
        }
    });
    obj.find(".iinput_clear").click(function(){
        $(this).css("display","none");
        $(this).siblings().val("");
        obj.find(".hint_box").hide().empty();
    });
    obj.find(".record").before(function(){
        var record_num = obj.find(".record_num").html();
        if(record_num == 0 && !$(this).prev().hasClass("iempty_tips")){
            return "<div class='iempty_tips'>暂无相关数据</div>";
        }
    });
    obj.find(".ikeyboard").clear_ikeyboard();//清空货号value
    obj.find(".ino_ime_input").init_ino_ime_input();
    obj.find(".ino_ime").init_ino_ime();
    obj.find(".datepicker").datepicker({duration:""});
    obj.find(".report_table_body").init_ireport_table_body();
}

(function($){
    var _ajax=$.ajax;
    //重写jquery的ajax方法
    $.ajax=function(opt){
        //备份opt中error和success方法
        var fn = {
            error:function(XMLHttpRequest, textStatus, errorThrown){},
            success:function(data, textStatus){}
        }
        if(opt.error){
            fn.error=opt.error;
        }
        if(opt.success){
            fn.success=opt.success;
        }
        //扩展增强处理
        var _opt = $.extend(opt,{
            error:function(XMLHttpRequest, textStatus, errorThrown){
                json=XMLHttpRequest.responseText.replaceAll("\n","").replaceAll("\r","").replace(/\<div debug\>.+?\<\/div\>/g, "");
                try{
                    fn.success(JSON.parse(json), textStatus);
                    return;
                }
                catch(err)
                {
                }
                layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
                fn.error(XMLHttpRequest, textStatus, errorThrown);
            },
            success:function(data, textStatus){
                if ((typeof data == 'string' && data.indexOf("session_is_disable")>0)
                    || data["state"]=="session_is_disable" )
                {
                    layer.alert('当前登录已过期，请重新登录！',
                        '1',
                        function(index){
                            window.location.href="/";
                        }
                    );
                }else{
                    fn.success(data, textStatus);
                }
            }
        });
        _ajax(_opt);
    };
})(jQuery);

function ChangeDangkouStore(dangkou_type,dangkou_bianhao,dangkou_name,dangkou_status){
    $.ajax({
        url:"session-dangkoustore",
        async: false,
        type: "POST",
        data:{var_dangkou_type:dangkou_type,var_dangkou_bianhao:dangkou_bianhao,var_dangkou_name:dangkou_name,var_dangkou_status:dangkou_status},
        success: function(html){
            if (dangkou_name=="")
            {
                $("#select_store_name").html("全部");
            }
            else
            {
                $("#select_store_name").html(dangkou_name);
            }
            window.location.href="myaccount";
        }
    });
}

function FactorySelectBoss(boss_id){
    $.ajax({
        url:"session-factory-select-boss",
        async: false,
        type: "POST",
        data:{var_boss_id:boss_id},
        success: function(html){
            $("#select_store_name").html(html);
            window.location.href="myaccount";
        }
    });
}

String.prototype.replaceAll = function(s1,s2) {
    return this.replace(new RegExp(s1,"gm"),s2);
}

function PrintOrder(order_bianhao){
    var iWidth=800;
    var iHeight=600;
    var iTop = (window.screen.availHeight-30-iHeight)/2
    var iLeft = (window.screen.availWidth-10-iWidth)/2;
    window.open ("print-order/"+order_bianhao, "newwindow", "height="+iHeight+", width="+iWidth+", top="+iTop+", left="+iLeft+", toolbar=no, menubar=no, scrollbars=yes, resizable=no, location=no, status=no")
}

function DeleteOrder(order_bianhao, return_url, return_from)
{
    if(confirm("确定要删除选中的信息吗？一旦删除将不能恢复！"))
    {
        if (order_bianhao=="0"){
            return;
        }
        $.ajax({
            url:"model-order-delete",
            async: false,
            type: "POST",
            dataType:"json",
            data:{order_bianhao:order_bianhao},
            error:function(){
                layer.msg('系统异常，请稍后再试:(', {time: 2000, icon:2});
            },
            success: function(html){
                if (html.state=="ok"){
                    layer.msg('删除成功！', {time: 2000, icon:1});
                    setTimeout(function(){
                        refresh_inner(return_url+$("#"+return_url).serialize() );
                    },0);
                }
                else if (html.state=="fail"){
                    layer.msg('删除失败！', {time: 2000, icon:2});
                    return;
                }
                else
                {
                    layer.msg(html.desc, {time: 2000, icon:2});
                    return;
                }
            }
        });
    }
}

(function ($) {

    $.fn.init_ipages=function(){
        return this.each(function(){
            if ($(this).attr("ipages")==1)
                return;
            $(this).attr("ipages","1");

            var page = $(this).attr("page");
            var count = $(this).attr("count");
            var id = "0";

            //初始化模板
            $(this).append($("#pages_tpl").html());
            $(this).set_page_num("","",1);
            //绑定事件函数
            var t_this=this;
            var input_idx_id = $(this).attr("input_idx_id");
            var j_form;
            if (typeof(input_idx_id)!="undefined")
                j_form=$(input_idx_id).parents("form");
            else
                j_form=$(this).parents("form");

            $(this).find(".page_ele").click(function(){
                set_page_list(t_this,$(this).attr("num"));
                refresh_inner(page+"?"+j_form.serialize() );
            });
        });
    };
    $.fn.set_page_count=function(xx1,xx2,count){
        return this.each(function(){
            $(this).attr("count",count);
            set_page_list(this,$(this).find("#m").attr("num"));
        });
    };
//设置当前第几页
    $.fn.set_page_num=function(xx1,xx2,num){
        return this.each(function(){
            set_page_list(this,num);
        });
    };
    function set_page_list(id,bingo)
    {
        var bingo=Number(bingo);
        var pcount=$(id).attr("count");
        if (pcount==0)
            $(id).css("display","none");
        else
            $(id).css("display","block");
        if (bingo>pcount || bingo<1)
            return;

        $(id).find("#ll").attr("num","1").html("1");
        $(id).find("#rr").attr("num",pcount).html(pcount);

        var input_idx_id = $(id).attr("input_idx_id");
        if (typeof(input_idx_id)!="undefined")
            $(input_idx_id).attr("value",bingo);
        else
            $(id).find("#pages_idx_i").attr("value",bingo);

        $(id).find("#last").attr("num",bingo-1);//中间页码
        $(id).find("#next").attr("num",bingo+1);//中间页码
        $(id).find("#m").attr("num",bingo).html(bingo);//中间页码
        $(id).find("#l1").attr("num",bingo-1).html(bingo-1);//左1页码
        $(id).find("#l2").attr("num",bingo-2).html(bingo-2);//左2页码
        $(id).find("#r1").attr("num",bingo+1).html(bingo+1);//右1页码
        $(id).find("#r2").attr("num",bingo+2).html(bingo+2);//右2页码

        $(id).find(".pagelink").each(function(){
            var num=Number($(this).html())
            if (num<=0||num>pcount){
                $(this).css("display","none");
            }else{
                $(this).css("display","inline");
            }
        });
    }

})(window.jQuery);

function init_small_nav(obj)
{
    //小导航的初始化
    obj.find(".ismall_nav").each(function(index,element)
    {
        var names = $(element).attr("names");
        if (typeof(names)=="undefined")
            return;
        names=names.split(";");
        for (var i=0;i<names.length;i++)
        {
            $(element).append("<input name='"+names[i]+"' type='hidden' value=''/>");
        }
    });
    //小导航绑定click
    obj.find(".listtypevalue,.listtypeselect").click(function(){
        //改变被点击的按钮颜色
        obj=$(this);
        obj.parent().find(".listtypevalue").removeClass('listtypeselect');
        obj.addClass("listtypeselect");

        //设置input值
        var values = obj.attr("values");
        if (typeof(values)=="undefined")
            return;
        values=values.split(";");
        for (var i=0;i<values.length;i++)
        {
            kv=values[i].split(":");
            obj.parent().find("input[name='"+kv[0]+"']").attr("value",kv[1]);
        }

        //执行refresh_inner
        var page = obj.parents(".ismall_nav").attr("page");
        if (typeof(page)=="undefined")
            return;
        var ipages_id = obj.parents("form").find(".ipages").attr("id");
        $("#pid_"+page+" #"+ipages_id).set_page_num("","",1);
        refresh_inner(page+"?"+obj.parents("form").serialize() );

    });
}

function mount_complete(obj)
{
    //标签页绑定click
    obj.find(".frame_tab_item_select,.frame_tab_item").click(function(){
        obj=$(this);
        obj.parent().find(".frame_tab_item_select").removeClass('frame_tab_item_select').addClass("frame_tab_item");
        obj.addClass("frame_tab_item_select");
    });
    //obj.find(".ipages").each(function(){
    //    var page = $(this).attr("page");
    //    var form = $(this).attr("form");
    //    var id = $(this).attr("id");
    //    var count = $(this).attr("count");
    //    init_pages(page,form,id,count);
    //});
    //初始化小导航
    init_small_nav(obj);

}





function refresh_complete(obj)
{

}

var NumSound = function(){
    var num_idx=0;
    var waves = new Array();
    var num_arr;
    preload();
    function preload()
    {
        for(var i=0;i<10;i++){
            waves[i] = new Audio;
            waves[i].preload="load";
            waves[i].src = "/pc/wav/0"+i+".wav";
            waves[i].playbackRate=2;
            waves[i].addEventListener('ended',
                function () {
                    num_idx++;
                    if (num_idx<num_arr.length){
                        waves[num_arr[num_idx] ].play();
                    }
                }, false);
        }
    }
    function stop_all_sound()
    {
        for(var i=0;i<10;i++){
            waves[i].pause;
            waves[i].currentTime=0.0;
        }
    }
    this.play_sound=function(num)
    {
        stop_all_sound();
        num_idx=0;
        num_arr = num.toString().split("");
        waves[num_arr[0]].play();
    }
}
/*加载弹框layer页面*/
function layer_ui(){
    index_layer_chuku_add_seller=layer.open({
        type: 1,
        area: ['380px', '250px'],
        title: false,
        content:$('#layer_chuku_edit_product')
    });
    if(order_num_obj.parents(".iedit").find(".iedit_price").length==0){
        $(".add_seller_box_p1").css("display","none");
    }else{
        $(".add_seller_box_p1").css("display","block");
    }
    $(".ibarcode").blur();
}
/*拿货数量和商品金额*/
function update_price(){
    if(order_num_obj.attr("errmsg")=="iedit_num"){
        order_num_obj.val($("#chuku_edit_seller_num").val());
        order_num_obj.parents(".iedit").find(".iedit_price").val($("#chuku_edit_seller_price").val());
    }else{
        order_num_obj.val($("#chuku_edit_seller_price").val());
        order_num_obj.parents(".iedit").find(".iedit_num").val($("#chuku_edit_seller_num").val());

    }
    layer.close(index_layer_chuku_add_seller);
    $(".ibarcode").focus();

    var order_sum=0;
    var order_total_money=0;
    $(".iedit_num").each(function(){
        order_sum+=parseInt($(this).val());
        order_total_money+=$(this).val()*parseFloat($(this).parents(".iedit").find(".iedit_price").val());
    });
    //赋值数量和单价
    $('.itotalnum').html(order_sum);
    $('.itotalmoney').html(parseFloat(order_total_money.toFixed(2)));
    $('.inoticecount').html(order_sum);
}
var order_num_obj;
/*修改拿货数量和单价*/
function change_quantity(obj){
    order_num_obj=obj;
    layer_ui();
    if($(".iedit_price").attr("readonly")=="readonly"){//判断是否为匿名卖家
        var num=obj.val();
        $("#chuku_edit_seller_price").attr("disabled","disabled");
        var price=obj.parents(".iedit").find(".iedit_price").val();
        $("#chuku_edit_seller_num").val(num);
        $("#chuku_edit_seller_price").val(price);
    }else{
        $("#chuku_edit_seller_price").removeAttr("disabled");
        var num=obj.val();
        var price=obj.parents(".iedit").find(".iedit_price").val();
        $("#chuku_edit_seller_num").val(num);
        $("#chuku_edit_seller_price").val(price);
    }
}
function change_pricetity(obj){
    order_num_obj=obj;
    layer_ui();
    if($(".iedit_price").attr("readonly")=="readonly"){//判断是否为匿名卖家
        $("#chuku_edit_seller_price").attr("disabled","disabled");
        var price = obj.val();
        var num = obj.parents(".iedit").find(".iedit_num").val();
        $("#chuku_edit_seller_num").val(num);
        $("#chuku_edit_seller_price").val(price);
    }else{
        $("#chuku_edit_seller_price").removeAttr("disabled");
        var price = obj.val();
        var num = obj.parents(".iedit").find(".iedit_num").val();
        $("#chuku_edit_seller_num").val(num);
        $("#chuku_edit_seller_price").val(price);
    }
}
function close_focus(obj){//点击关闭出发焦点
    $(".ibarcode").focus();
}

var VVIP_INPUT="#saoma_chuku_barcode";
(function($) {//热区 输入货号
    $.fn.init_ikeyboard=function(letters){
        return this.each(function(){
            if ($(this).attr("ikeyboard")==1)
                return;
            $(this).attr("ikeyboard","1");

            //初始化模板
            $(this).append($("#ikeyword_tpl").html());
            $(this).find("#qilaihai").parent(".ino_ime").css("width","32%");
            var lalala = $(this).find("#qilaihai").parent(".ino_ime").position().left;
            $(this).find("#qilaihai").parent(".ino_ime").next(".hint_box").offset({left:lalala});

            jkeyboard=$(this);
            var letter=letters.split("");
            letter.sort();
            for(var i=0;i<letter.length;i++) {
                $(this).find("li.ikey_letters").before("<li><span>"+letter[i]+"</span></li>");
            }
            $(this).find(".ikeywords ul li>span").attr("class","ikey");
            if($(this).hasClass("ikeyboard_tuihuo")){//初始化加载键盘确定按钮
                jkeyboard.find(".btn_sr").css("display","none");
            }
            $(this).find(".ikey").click(function(){//键盘点击
                jp_input=$(this).parents(".ikeyboard").find(".ikeyword_num");
                //赋值之前调用回调函数
                callback_func=jkeyboard.attr("onclick_before");
                var jp_pid=jp_input.val()+$(this).html();

                if(jkeyboard.hasClass("ikeyboard_tuihuo")){
                    jkeyboard.find(".btn_sr").click(function(){//点击确认按钮查询
                        (new Function("return "+callback_func+"('"+jp_pid+"')"))();
                    });
                }else{
                    (new Function("return "+callback_func+"('"+jp_pid+"')"))();
                }

                //input赋值
                var new_jp_pid=jp_input.val().toUpperCase()+$(this).html();
                jp_input.val(new_jp_pid);
            });
            $(this).find(".iinput_clear").click(function(){//点击X号清空工厂 颜色
                jp_input=$(this).parents(".ikeyboard").find(".ino_ime_proxy");
                //赋值之前调用回调函数
                callback_func=jkeyboard.attr("onclick_before");
                var jp_pid=jp_input.val("");

                (new Function("return "+callback_func+"('"+jp_pid+"')"))();
            });

            $(this).find(".btn_del").click(function(){//点击回退删除
                var l=jkeyboard.find(".ikeyword_num").val().length;
                var g=jkeyboard.find(".ikeyword_num").val();
                jkeyboard.find(".ikeyword_num").val(g.substring(0,l-1));
            });
            if($(this).hasClass("ikeyboard_tuihuo")){
                jkeyboard.find(".sure_add_huohao").click(function() {//点击确认添加按钮
                    jinput = $(this).parents(".ikeyboard").find(".ikeyword_num");
                    //赋值之前调用回调函数
                    callback_func = jkeyboard.attr("onclick_before");
                    var pid = jinput.val().toUpperCase();
                    (new Function("return " + callback_func + "('" + pid + "')"))();
                    //input赋值
                    var new_pid = jinput.val().toUpperCase();
                    jinput.val(new_pid);
                });
                $(this).find(".ino_ime_proxy").bind('keypress', function (event) {//回车事件
                    jinput = $(this).parents(".ikeyboard").find(".ikeyword_num");
                    //赋值之前调用回调函数
                    callback_func = jkeyboard.attr("onclick_before");
                    var pid = jinput.val().toUpperCase() + $(this).html();
                    if(event.keyCode=="13"){//退货登记回车
                        (new Function("return " + callback_func + "('" + pid + "')"))();
                        //input赋值
                        var new_pid = jinput.val().toUpperCase() + $(this).html();
                        jinput.val(new_pid);
                    }
                });
            }else{
                $(this).find(".ino_ime_proxy").bind('input propertychange', function () {
                    //jinput = $(this).parents(".ikeyboard").find(".ikeyword_num");
                    jinput = $(this).parents(".ikeyboard").find(".ino_ime_proxy");
                    //赋值之前调用回调函数
                    callback_func = jkeyboard.attr("onclick_before");
                    var pid = jinput.val().toUpperCase() + $(this).html();
                    (new Function("return " + callback_func + "('" + pid + "')"))();
                    //input赋值
                    var new_pid = jinput.val().toUpperCase() + $(this).html();
                    jinput.val(new_pid);
                });
            }
            if(!!window.ActiveXObject || "ActiveXObject" in window) {//判断是否是ie浏览器
                if($(this).hasClass("ikeyboard_tuihuo")){
                    jkeyboard.find(".sure_add_huohao").click(function() {//点击确认添加按钮
                        jinput = $(this).parents(".ikeyboard").find(".ikeyword_num");
                        //赋值之前调用回调函数
                        callback_func = jkeyboard.attr("onclick_before");
                        var pid = jinput.val().toUpperCase();
                        (new Function("return " + callback_func + "('" + pid + "')"))();
                        //input赋值
                        var new_pid = jinput.val().toUpperCase();
                        jinput.val(new_pid);
                        //$(".iproduct_name").val("");
                    });
                    $(this).find(".ikeyword_num").bind('keypress', function (event) {//回车事件
                        jinput = $(this).parents(".ikeyboard").find(".ikeyword_num");
                        //赋值之前调用回调函数
                        callback_func = jkeyboard.attr("onclick_before");
                        var pid = jinput.val().toUpperCase() + $(this).html();
                        if(event.keyCode=="13"){//退货登记回车
                            (new Function("return " + callback_func + "('" + pid + "')"))();
                            //input赋值
                            var new_pid = jinput.val().toUpperCase() + $(this).html();
                            jinput.val(new_pid);
                        }
                    });
                }else{
                    $(this).find(".ikeyword_num").bind('input propertychange', function () {
                        jinput = $(this).parents(".ikeyboard").find(".ikeyword_num");
                        //赋值之前调用回调函数
                        callback_func = jkeyboard.attr("onclick_before");
                        var pid = jinput.val().toUpperCase() + $(this).html();
                        (new Function("return " + callback_func + "('" + pid + "')"))();
                        //input赋值
                        var new_pid = jinput.val().toUpperCase() + $(this).html();
                        jinput.val(new_pid);
                    });
                }
                $(this).find(".ikeyword_num").click(function() {
                    VVIP_INPUT=".ikeyword_num";//让条码框失去焦点
                    jkeyboard.find(".ikeyword_num").focus();
                });
            }else{
                $(this).find(".ino_ime_proxy").click(function () {
                    VVIP_INPUT=".ino_ime_proxy";//让条码失去焦点
                    console.log(jkeyboard.parents().find(".ibarcode"));
                    jkeyboard.find(".ino_ime_proxy").focus();
                });
            }
        });
    };
    //清除货号value
    $.fn.clear_ikeyboard=function(){
        return this.each(function(){
            $(this).find(".ikeyword_num").val("");
        });
    };
})(window.jQuery);

/*加载自定义layer页面*/
function layer_additem(){
    index_layer_additem=layer.open({
        type: 1,
        area: ['500px', '272px'],
        title: false,
        content:$('#iadditem_tpl')
    });
    $(".ibarcode").blur();
}
function bind_click(){
    $(".products_dele").unbind("click").click(function(){
        //debugger;
        $(this).parent(".products_row").remove();
        var product_huohao="";
        $(".products_table li").each(function(){
            product_huohao+=","+$(this).find(".products_list").html();
        });
        var dangkou_hot_products=product_huohao.replace(",","");

        $ (".additem_list_bt").parent().remove();
        var product_data=dangkou_hot_products.split(",");
        $.each(product_data,function(index){
            if(product_data[0]!="") {
                $ (".additem_list").prepend("<li><span class='additem_list_bt'>" + product_data[index] + "</span></li>");
            }
        });
        if(!!window.ActiveXObject || "ActiveXObject" in window) {//判断是否是Ie浏览器,给ikeyword_num文本框赋值
            $(".additem_list_bt").click(function(){
                $ (".ikeyword_num").attr("value",$(this).text()).trigger("input");
                $(".sure_add_huohao").trigger("click");
                $(".hint_box").empty().hide();//防止输入法弹出
            });
        }else{
            $(".additem_list_bt").click(function(){
                $ (".ino_ime_proxy").attr("value",$(this).text()).trigger("input");
                $(".sure_add_huohao").trigger("click");
                $(".hint_box").empty().hide();//防止输入法弹出
            });
        }

        $.ajax({
            url:"update-hot-products",
            async: false,
            type: "POST",
            data:{dangkou_hot_products:dangkou_hot_products,dangkou_bianhao:chuku_select_storewarehouse_bianhao},
            dataType:"json",
            success: function(html){
            }
        });
    });
}
//添加自定义货号
(function($){
    $.fn.init_iadditem=function(chuku_select_storewarehouse_bianhao){
        return this.each(function(){
            if($(this).attr("iadditem")==1)
                return;
            $(this).attr("iadditem","1");
            var iadditem=$(this);
            $.getJSON('get-hot-products',{dangkou_bianhao:chuku_select_storewarehouse_bianhao},function(products){
                var product_data=products.split(",");
                iadditem.product_data=product_data;
                $.each(iadditem.product_data,function(index){
                    if(iadditem.product_data[0]!="") {
                        iadditem.find(".additem_list").prepend("<li><span class='additem_list_bt'>" + iadditem.product_data[index] + "</span></li>");
                    }
                });

                if(!!window.ActiveXObject || "ActiveXObject" in window) {//判断是否是Ie浏览器,给ikeyword_num文本框赋值
                    if(jkeyboard.hasClass("ikeyboard_tuihuo")) {//判断是否需要回车事件表识，然后模拟点击赋值
                        iadditem.find(".additem_list_bt").click(function () {
                            iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).html()).trigger("input");
                            iadditem.prev().find(".ino_ime_input").attr("value",iadditem.prev().find(".ino_ime_proxy").val());

                            iadditem.prev().find(".sure_add_huohao").trigger("click");
                            $(".hint_box").empty().hide();//防止输入法弹出
                        });
                    }else{
                        $(".additem_list_bt").click(function () {
                            //iadditem.prev().find(".ikeyword_num").attr("value", $(this).text()).trigger("input");
                            iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).html()).trigger("input");
                            iadditem.prev().find(".ino_ime_input").attr("value",iadditem.prev().find(".ino_ime_proxy").val());

                            $(".hint_box").empty().hide();//防止输入法弹出
                        });
                    }
                }else{
                    if(jkeyboard.hasClass("ikeyboard_tuihuo")) {//判断是否需要回车事件表识，然后模拟点击赋值
                        iadditem.find(".additem_list_bt").click(function () {
                            //iadditem.prev().find(".ikeyword_num").attr("value", $(this).text());
                            //iadditem.prev().find(".ino_ime_proxy").trigger("input");
                            iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).html()).trigger("input");
                            iadditem.prev().find(".ino_ime_input").attr("value",iadditem.prev().find(".ino_ime_proxy").val());

                            iadditem.prev().find(".sure_add_huohao").trigger("click");
                            $(".hint_box").empty().hide();//防止输入法弹出
                        });
                    }else{
                        iadditem.find(".additem_list_bt").click(function () {
                            iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).html()).trigger("input");
                            iadditem.prev().find(".ino_ime_input").attr("value",iadditem.prev().find(".ino_ime_proxy").val());
                            $(".hint_box").empty().hide();//防止输入法弹出
                        });
                    }
                }
            });
            $(this).find(".additem_btn").click(function(){
                if(!!window.ActiveXObject || "ActiveXObject" in window) {//判断是否是Ie浏览器,给ikeyword_num文本
                    $(".additem_list_bt").click(function () {
                        //iadditem.prev().find(".ikeyword_num").attr("value", $(this).text()).trigger("input");
                        iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).html()).trigger("input");
                        iadditem.prev().find(".ino_ime_input").attr("value",iadditem.prev().find(".ino_ime_proxy").val());

                        $(".sure_add_huohao").trigger("click");
                        $(".hint_box").empty().hide();//防止输入法弹出
                    });
                }else{
                    $(".additem_list_bt").click(function () {
                        //iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).text()).trigger("input");
                        iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).html()).trigger("input");
                        iadditem.prev().find(".ino_ime_input").attr("value",iadditem.prev().find(".ino_ime_proxy").val());

                        $(".sure_add_huohao").trigger("click");
                        $(".hint_box").empty().hide();//防止输入法弹出
                    });
                }
                index_layer_additem2=layer.open({
                    type: 1,
                    area: ['500px', '272px'],
                    title: false,
                    content:$('#iadditem_tpl')
                });
                iadditem.prev().find(".ino_ime_input").attr("value",iadditem.prev().find(".ino_ime_proxy").val());
                $('.layui-layer-close').click(function(){layer.close(index_layer_additem2);});
                $(".ibarcode").blur();
                $("#update_article_num").val("");
                $ (".products_table").empty();
                $.getJSON('get-hot-products',{dangkou_bianhao:chuku_select_storewarehouse_bianhao},function(products) {
                    var product_dat = products.split(",");
                    iadditem.product_dat = product_dat;
                    $.each(iadditem.product_dat, function (index) {
                        if (iadditem.product_dat[0] != "") {
                            $ (".products_table").prepend("<li class='products_row'><span class='products_list'>" + iadditem.product_dat[index] + "</span><span class='products_dele'>删除</span></li>");                        }
                    });
                    bind_click();
                });

                $(this).parents().find(".btn_products").unbind("click").click(function(){
                    if(!$("#update_article_num").val())
                    {
                        alert("货号不能不空！");
                        return false;
                    }
                    var product_huohao="";
                    iadditem.parents().find(".products_table li").each(function(){
                        product_huohao+=","+$(this).find(".products_list").html();
                    });
                    var dangkou_hot_products=$("#update_article_num").val().toUpperCase()+product_huohao;
                    $.ajax({
                        url:"update-hot-products",
                        async: false,
                        type: "POST",
                        data:{dangkou_hot_products:dangkou_hot_products,dangkou_bianhao:chuku_select_storewarehouse_bianhao},
                        dataType:"json",
                        success: function(html) {
                            if (html.state=="ok") {
                                $(".products_table").prepend("<li class='products_row'><span class='products_list'>" + $('#update_article_num').val().toUpperCase() + "</span><span class='products_dele'>删除</span></li>");
                                iadditem.find(".additem_list").prepend("<li><span class='additem_list_bt'>" + $('#update_article_num').val().toUpperCase() + "</span></li>");
                            }
                            bind_click();
                            if(!!window.ActiveXObject || "ActiveXObject" in window) {//判断是否是Ie浏览器,给ikeyword_num文本
                                if(jkeyboard.hasClass("ikeyboard_tuihuo")) {
                                    iadditem.find(".additem_list_bt").click(function () {
                                        //iadditem.prev().find(".ikeyword_num").attr("value", $(this).text());
                                        //iadditem.prev().find(".ino_ime_proxy").trigger("input");
                                        iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).html()).trigger("input");
                                        iadditem.prev().find(".ino_ime_input").attr("value",iadditem.prev().find(".ino_ime_proxy").val());

                                        iadditem.prev().find(".sure_add_huohao").trigger("click");
                                        $(".hint_box").empty().hide();//防止输入法弹出
                                    });
                                }else{
                                    $(".additem_list_bt").click(function () {
                                        //iadditem.prev().find(".ikeyword_num").attr("value", $(this).text()).trigger("input");
                                        iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).html()).trigger("input");
                                        iadditem.prev().find(".ino_ime_input").attr("value",iadditem.prev().find(".ino_ime_proxy").val());

                                        $(".hint_box").empty().hide();//防止输入法弹出
                                    });
                                }
                            }else{
                                if(jkeyboard.hasClass("ikeyboard_tuihuo")) {
                                    iadditem.find(".additem_list_bt").click(function () {
                                        //iadditem.prev().find(".ikeyword_num").attr("value", $(this).text());
                                        //iadditem.prev().find(".ino_ime_proxy").trigger("input");
                                        iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).html()).trigger("input");
                                        iadditem.prev().find(".ino_ime_input").attr("value",iadditem.prev().find(".ino_ime_proxy").val());

                                        iadditem.prev().find(".sure_add_huohao").trigger("click");
                                        $(".hint_box").empty().hide();//防止输入法弹出
                                    });
                                }else{
                                    $(".additem_list_bt").click(function () {
                                        iadditem.prev().find(".ino_ime_proxy").attr("value", $(this).text()).trigger("input");

                                        $(".hint_box").empty().hide();//防止输入法弹出
                                    });
                                }
                            }
                        }
                    });
                });
                bind_click();
            });
        });
    }
})(window.jQuery);

//输入法


(function($) {
    $.fn.init_name_iime=function(){
        return this.each(function(){
            if ($(this).attr("name_iime")==1)
                return;
            $(this).attr("name_iime","1");
            var jinput=$(this);
            jinput.wrap("<div class='ino_ime'></div>");

            //if(jinput.parents().find(".ikeyboard").attr("ikeyboard")==1){
            //    jinput.parents().find(".ikeyboard").after("<div class='hint_box' ></div>");
            //    //jinput.parents().find(".ikeyboard").find(".hint_box").css({position:"absolute",top:-42});
            //}else{
                jinput.parent(".ino_ime").after("<div class='hint_box' ></div>");
            //}
        });
    };
})(window.jQuery);
//判断输入框

(function($) {
    $.fn.init_ino_ime_input=function(){
        return this.each(function(){
            if ($(this).attr("ino_ime_input")==1)
                return;
            $(this).attr("ino_ime_input","1");
            if(!!window.ActiveXObject || "ActiveXObject" in window){

            }else{
                if($(this).hasClass("iseller_name")){
                    //$(this).after("<input type='password' required='required' class='ino_ime_proxy iseller_name' id='ikeyword_num' autocomplete='off'/>");
                    $(this).after('<input type="text" onfocus="this.type=\'password\'" onblur="this.type=\'text\'" required="required" class="ino_ime_proxy iseller_name" autocomplete="off"/>');
                }
                if($(this).hasClass("iproduct_name")){
                    $(this).after('<input type="text" onfocus="this.type=\'password\'" onblur="this.type=\'text\'" required="required" class="ino_ime_proxy iproduct_name" autocomplete="off"/>');
                }
            }
        });
    };

    $.fn.init_ino_ime = function() {
        return this.each(function(){
            if ($(this).attr("ino_ime")==1)
                return;
            $(this).attr("ino_ime","1");
            var wrap = $(this);
            var proxy = wrap.find('.ino_ime_proxy');
            var input = wrap.find('.ino_ime_input');
            var input_width = input.outerWidth(true);
            proxy.css("width",input_width);
            var product_pinyin;
            var seller_pinyin;
            if(input.hasClass("iseller_name")){
                $.ajax({
                    url:"get-pinyin",
                    async: false,
                    dataType:"json",
                    success:function(data){
                        seller_pinyin = data;
                    }
                });
            }
            if(input.hasClass("iproduct_name")){
                $.ajax({
                    url:"get-product-pinyin",
                    async: false,
                    dataType:"json",
                    success:function(data){
                        product_pinyin = data;
                    }
                });
            }
            //for(var key in product_pinyin){
            //    product_pinyin[key] = product_pinyin[key].sort();
            //}
            var p = [];
            var ele = "";
            var input_val;
            input.keypress(function(e){
                var keycode = e.keyCode;
                for( ele in p ){
                    if(keycode == p[ele]&&keycode<=57&&keycode>=49&&$(this).hasClass("iseller_name")){
                        $(this).attr("value",seller_pinyin[input_val.toUpperCase()][ele]);
                        input.val(this.value);
                        $(this).parent().nextAll(".hint_box").empty();
                        p=[];ele="";
                        return event.returnValue = false;
                    }
                }
                if($(this).parent().nextAll(".hint_box").html()==""){
                    return event.returnValue = true;
                }else if(keycode ==32){
                    $(this).attr("value",seller_pinyin[input_val.toUpperCase()][0]);
                    input.val(this.value);
                    $(this).parent().nextAll(".hint_box").hide().empty();
                    p=[];ele="";
                    return event.returnValue = false;
                }
            });
            input.bind('keyup', function() {input_val = $(this).val();
                if($(this).hasClass("iseller_name")){
                    if(input_val.toUpperCase() in seller_pinyin){
                        $(this).parent().nextAll(".hint_box").empty();
                        for( ele in seller_pinyin[input_val.toUpperCase()])
                        {
                            p[ele] = parseInt(ele)+49;
                            $(this).parent().nextAll(".hint_box").show().append(function(){
                                if(ele<9){
                                    return "<span>"+"<b>"+p[ele]+"</b>"+(parseInt(ele)+1)+seller_pinyin[input_val.toUpperCase()][ele]+"</span>&nbsp;";
                                }
                            });
                        }
                        if(ele>9){
                            $(this).parent().nextAll(".hint_box").children().last().after("<b>. . .</b>");
                        }

                    }else{
                        $(this).parent().nextAll(".hint_box").empty().hide();
                        p=[];ele="";
                    }
                }
                if($(this).hasClass("iproduct_name")){
                    if(input_val.toUpperCase() in product_pinyin){
                        $(this).parent().nextAll(".hint_box").empty();
                        for( ele in product_pinyin[input_val.toUpperCase()])
                        {
                            p[ele] = parseInt(ele)+49;
                            $(this).parent().nextAll(".hint_box").show().append(function(){
                                if(ele<9){
                                    return "<span>"+"<b>"+p[ele]+"</b>"+product_pinyin[input_val.toUpperCase()][ele]+"</span>&nbsp;";
                                }
                            });
                        }
                        if(ele>9){
                            $(this).parent().nextAll(".hint_box").children().last().after("<b>. . .</b>");
                        }

                    }else{
                        $(this).parent().nextAll(".hint_box").hide().empty();
                        p=[];ele="";
                    }
                }
                $(this).parent().nextAll(".hint_box").children("span").click(function(){
                    $(this).parent().prevAll().children(".name_iime").attr("value",$(this).text().replace(/-?[1-9]\d*/,"")).trigger("input");
                    input.parent().nextAll(".hint_box").hide().empty();
                    p=[];ele="";
                });
            });
            proxy.keypress(function(e){
                var keycode = e.keyCode;
                for( ele in p ){
                    if(keycode == p[ele]&&keycode<=57&&keycode>=49&&$(this).hasClass("iseller_name")){
                        $(this).attr("value",seller_pinyin[input_val.toUpperCase()][ele]);
                        input.val(this.value);
                        $(this).parent().nextAll(".hint_box").hide().empty();
                        p=[];ele="";
                        return event.returnValue = false;
                    }else if((keycode ==32||keycode ==13)&&$(this).hasClass("iseller_name")){
                        $(this).attr("value",seller_pinyin[input_val.toUpperCase()][0]).trigger("input");;
                        input.val(this.value);
                        $(this).parent().nextAll(".hint_box").hide().empty();
                        p=[];ele="";
                        return event.returnValue = false;
                    }


                    if($(this).hasClass("iproduct_name")&&(keycode ==32||keycode ==13)){
                        $(this).attr("value",product_pinyin[input_val.toUpperCase()][0]).trigger("input");;
                        input.val(this.value);
                        $(this).parent().nextAll(".hint_box").hide().empty();
                        p=[];ele="";
                        return event.returnValue = false;
                    }
                }
                if($(this).parent().nextAll(".hint_box").html()==""){
                    return event.returnValue = true;
                }
            });
            proxy.bind('input propertychange', function() {
                input.val(this.value);
                input_val = $(this).val();
                if($(this).val()!=""){
                    $(this).next().css("display","inline");
                }else{
                    $(this).next().css("display","none");
                }
                if($(this).hasClass("iseller_name")){
                    if(input_val.toUpperCase() in seller_pinyin){
                        $(this).parent().nextAll(".hint_box").hide().empty();
                        for( ele in seller_pinyin[input_val.toUpperCase()])
                        {
                            p[ele] = parseInt(ele)+49;
                            $(this).parent().nextAll(".hint_box").show().append(function(){
                                if(ele<9){
                                    return "<span>"+"<b>"+p[ele]+"</b>"+(parseInt(ele)+1)+seller_pinyin[input_val.toUpperCase()][ele]+"</span>&nbsp;";
                                }
                            });
                        }
                        if(ele>9){
                            $(this).parent().nextAll(".hint_box").children().last().after("<b>. . .</b>");
                        }

                    }else{
                        $(this).parent().nextAll(".hint_box").hide().empty();
                        p=[];ele="";
                    }
                }
                if($(this).hasClass("iproduct_name")){
                    if(input_val.toUpperCase() in product_pinyin){
                        $(this).parent().nextAll(".hint_box").hide().empty();
                        for( ele in product_pinyin[input_val.toUpperCase()])
                        {
                            p[ele] = parseInt(ele)+49;
                            $(this).parent().nextAll(".hint_box").show().append(function(){
                                if(ele<9){
                                    return "<span>"+"<b>"+p[ele]+"</b>"+product_pinyin[input_val.toUpperCase()][ele]+"</span>&nbsp;";
                                }
                            });
                        }
                        if(ele>9){
                            $(this).parent().nextAll(".hint_box").children().last().after("<b>. . .</b>");
                        }

                    }else{
                        $(this).parent().nextAll(".hint_box").hide().empty();
                        p=[];ele="";
                    }
                }
                $(this).parent().nextAll(".hint_box").children("span").click(function(){
                    $(this).parent().prevAll().children(".name_iime").attr("value",$(this).text().replace(/-?[1-9]\d*/,""));
                    $(this).parent().prevAll().children(".ino_ime_proxy").attr("value",$(this).text().replace(/-?[1-9]\d*/,"")).trigger("input");
                    input.parent().nextAll(".hint_box").hide().empty();
                    p=[];ele="";
                });

            });
        });
    };

})(window.jQuery);

(function($) {
    $.fn.init_jianrongxing = function() {
        return this.each(function() {
            if ($(this).attr("jianrongxing") == 1)
                return;
            $(this).attr("jianrongxing", "1");
            if(!!window.ActiveXObject || "ActiveXObject" in window){
                $(this).css("margin-top","30px");
            }
        });
    }
})(window.jQuery);

(function($) {
    $.fn.init_ireport_table_body = function() {
        return this.each(function() {
            if ($(this).attr("report_table_body") == 1)
                return;
            $(this).attr("report_table_body", "1");
            var report_table_body = $(this).find(".report_table_body");
            for(var i=0; i<report_table_body.length; i++){
                var b=(i+1)%2
                if(b==1){
                    $(report_table_body[i]).css("background-color","#fff");
                }
                if(b==0){
                    $(report_table_body[i]).css("background-color","#FFF5EE");
                }
            }
        });
    }
})(window.jQuery);


(function($) {
    $.fn.init_ipid_ime= function() {
        return this.each(function() {
            if ($(this).attr("ipid_ime") == 1)
                return;
            $(this).attr("ipid_ime", "1");


        });
    }

    function append_buttons(obj, select_chuku_huohao, select_chuku_factory, select_chuku_color)
    {
        $('.select_chuku_color_radioToggle').removeClass('current');
        obj.addClass('current');

        var var_colorsize_html="";
        var_colorsize_html+="<div style='float:left; width:15%; padding:5px 0; color:#999999; text-align:right; overflow:hidden; display:block'>尺码：</div>";
        var_colorsize_html+="<div class='addchoosebox'>";
        var_colorsize_html+="    <ul>";
        for (key in chuku_getproductdetailbyhuohao[select_chuku_huohao][select_chuku_factory][select_chuku_color])
        {
            var_colorsize_html+="        <li>";
            var_colorsize_html+="            <span class='select_chuku_size_radioToggle canaddcurrent' onclick='/**/GetChukuBarcodeByHuohaoFactoryColorSize($(this), \"" + select_chuku_huohao + "\", \"" + select_chuku_factory + "\", \"" + select_chuku_color + "\", \"" + key + "\")'>" + key + "</span>";
            var_colorsize_html+="        </li>";
        }
        var_colorsize_html+="    </ul>";
        var_colorsize_html+="</div>";

        $("#select_chuku_size").html(var_colorsize_html);
        $("#select_chuku_size").show();

        $("#select_chuku_order").hide();
    }

})(window.jQuery);






