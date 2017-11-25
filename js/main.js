var ASYNC=true;

function safe_select(sid)
{
    return $(sid);
}
//js隔离函数,js局域化
//语法1：script后加/*n*/ 标识该区块不要做代码隔离
//语法2:/**/表示当前页面的函数池/**/hello() 等价于 func_pool.hello()
function restrict_js(html,pid)
{
    var lines=html.split("\n");
    var injs=0;var first_js=1;
    var phtml="";var funcs="";var strict=1;
    var fnames={};var js_region={};
    for (var i =0;i<lines.length;i++)
    {
        var line=lines[i];
        //处理js区开始部分
        if (line.indexOf("<script")>=0 ){
            injs=1;
            funcs="";
            strict=(line.indexOf("/*n*/")>=0)?0:1;
            if (strict==1){
                if (first_js==1){
                    line=line+"var "+pid+"={};\n";//增加函数池对象
                    first_js=0;
                }
                line=line+"(function(){";
            }
        }
        //js区结束部分处理
        if (injs==1 && line.indexOf("</script")>=0){
            injs=0;
            if (strict==1)
                line=funcs+"})()"+line;
        }
        //得到需要隔离的JS区自定义函数名,并把内部函数放到函数池
        if (injs==1 && strict==1 && line.indexOf("function ")>=0){
            var fname=line.replace(/function +(.*?)\(.*/,"$1").replace("\n","").replace("\r","");
            funcs+=pid+"['"+fname+"']="+fname+";\n";
            fnames[fname]=1;
        }
        //jquery选择器替换为safe选择器
        if (line.indexOf("$(")>=0 && line.indexOf("pid_")<0){
            line=line.replace(/\$\((["'])/g, "safe_select($1#pid_"+pid+" ");
        }
        lines[i]=line;
        js_region[i]=injs;
    }
    // /**/ 表示替换为当前页面的函数池对象
    for (var i =0;i<lines.length;i++)
    {
        var line=lines[i];
        if (line.indexOf("/**/")>=0){
            var fname=line.replace(/.*\/\*\*\/(.*?)\(.*/,"$1").replace("\r\n","").replace("\r","");
            if (fname in fnames) 
                line=line.replace(/\/\*\*\//g, pid+".");
        }
        phtml+=line+"\n";
    }
    return phtml;
}
var debug;
function parse_static(html,pageid,just_inner)
{
    var just_inner = arguments[2] ? arguments[2] : 0;

    var head="";
    var body="";
    var tail="";
    var state=0;

    debug=restrict_js(html,pageid);
    if (pageid.indexOf("view_sale")>=0)
        html=debug;

    var lines=html.split("\n");
    var has_inner=0;
    for (var i =0;i<lines.length;i++)
    {
        line=lines[i]+"\n";
        if (state==0){
            head+=line;
        }
        if (state==1){
            body+=line;
        }
        if (state==2){
            tail+=line;
        }

        if (line.indexOf("refresh_begin")>=0){
            has_inner=1;
            state=1;
        }
        if (line.indexOf("refresh_end")>=0){
            state=2;
        }
    }
    //如果有页面refresh_begin标识
    if (has_inner==1){
        var inner_frame_id=pageid+"_inner_head_frame";
        if (just_inner!=1){
            //html=head+"<div id='"+inner_frame_id+"' style='overflow-y:auto;float:left;width:100%;height:2000px;display:block' > "+body+" </div>"+tail;
            html=head+"<div id='"+inner_frame_id+"'> "+body+" </div>"+tail;
        }else{
            html=body;
        }
    }
    return html;
}
function get_view_id(pid)
{
    var leaf=pid;
    if (leaf=="")
        return "";
    if (leaf.indexOf("view")>=0)
        return leaf;
    if (leaf in active_son){
        leaf=get_view_id(active_son[leaf]);
        return leaf;
    }else{
        return "";
    }
}
var zindex=100;
var click_history=[];
//一个框架页面有多个儿子，但只记录最新一个活动儿子
var active_son={};
var pid_full={};
var widx=0;
//挂载函数 挂载某个php页面到父页面
//pageid:要挂载的页面 refresh是否强制刷新 tabs_id 父页面  layer 是否对话框视图
function mount_to_frame(pageid, refresh, tabs_id,layer)
{
    //销售直播
    if (pageid=="view_index")
    {
        flag_view_index_setInterval=1;
    }
    else
    {
        flag_view_index_setInterval=0;
    }
    
    var raw_pageid=pageid; 
    var refresh = arguments[1] ? arguments[1] : 0;//设置参数refresh的默认值为0
    var tabs_id = arguments[2] ? arguments[2] : "parent";
    var layer = arguments[3] ? arguments[3] : 0;
    var page_param="";
    if(pageid.indexOf("?") >= 0){
        var pair = pageid.split("?");
        pageid=pair[0];
        page_param=pair[1];
    }
    active_son[tabs_id]=pageid;
    click_history.push([pageid,tabs_id]);
    //alert(JSON.stringify(click_history));
    var pageid2="pid_"+pageid; //pageid统一加前缀防止和tabsid或者其他id重名
    
    var ctabs_id="c_"+tabs_id;
    if ( $("#"+pageid2).length <= 0 || refresh == 1) 
    { 
        pid_full[pageid]=raw_pageid;
        $("#"+pageid2).remove();
	    $.ajax({
		url:""+pageid.replaceAll("_","-"), 
		async: ASYNC,
		type: "POST",
		data:page_param,
        beforeSend:function(){
            widx++;
            $("#main_body").css("cursor","wait");
            $(".menu_link").css("cursor","wait");
            $(".frame_tab_item").css("cursor","wait");
        },
        complete:function(){
            widx--;
            if (widx==0){
                $("#main_body").css("cursor","default");
                $(".menu_link").css("cursor","pointer");
                $(".frame_tab_item").css("cursor","pointer");
            }
        },
		success: function(html){
            html=parse_static(html,pageid,0);
            if (layer==0){
                html = "<div class=\""+ctabs_id+"\"  style=\"float:left; width:100%; padding:0 0 20px 0; overflow:hidden; display:block\" id=\""+pageid2+"\">"+html+"</div>";
            }
            if (layer==1){
                html = "<div style=\"float:left; width:100%; max-height:450px; margin:0px; padding:0px; overflow:auto; display:block\" >"+html+"</div>";
                close='<div class="divHead" onmousedown="div_down($(this))" style="float:left;cursor: move;height:20px;width:90%"/>';
                close+="<div style='float:left;width:10%' onclick=\"$(this).parent().css('display','none')\">关&nbsp&nbsp闭</div>";
                html = "<div class=\""+ctabs_id+"\" onmousedown=\"$(this).css('z-index',zindex++)\" style=\"position: absolute; z-index:99; width:70%; margin:100px; left:1px; top:1px; padding:5px; background-color:gray; overflow:hidden; display:block\" id=\""+pageid2+"\">"+close+html+"</div>";
            }
            $("#"+tabs_id).append(html);
            mount_complete($("#"+pageid2));
            $("#"+pageid2).css("z-index",zindex++);
            if (layer==0){
                $("."+ctabs_id).hide();
            }
            $("#"+pageid2).show();
        }
	    });
    }else{//如果不是新页面，就调用inner函数强制刷新列表
        var view_id = get_view_id(pageid);
        var raw_view_id = view_id;
        if (view_id!=""){
            if (view_id in pid_full){
                view_id=pid_full[view_id];
            }
            $("#"+pageid2).css("z-index",zindex++);
            if (layer==0){
                $("."+ctabs_id).hide();
            }
            $("#"+pageid2).show();
            refresh_inner(view_id);
            refresh_complete($("#pid_"+raw_view_id));
            $("#pid_"+raw_view_id+" .ibarcode").focus();
            //setTimeout("refresh_complete($('#pid_"+view_id+"'))",0);
        }
    }
	
    //var speed=200;//滑动的速度
    //$('body,html').animate({ scrollTop: 0 }, speed);
}
var AJAX_STACK = new Stack();  
var AJAX_FINISH = 1;
setInterval(function(){
    if (AJAX_FINISH == 1 && AJAX_STACK.length()>=1){
        AJAX_FINISH = 0;
        var pageid=AJAX_STACK.pop();
        refresh_inner_main(pageid);
    }

},100);
function refresh_inner(pageid)
{
    refresh_inner_main(pageid);
    //AJAX_STACK.push(pageid);
}
function refresh_inner_main(pageid)
{
    var raw_pageid=pageid; 
    var page_param="";
    if(pageid.indexOf("?") >= 0){
        var pair = pageid.split("?");
        pageid=pair[0];
        page_param=pair[1];
    }
    var tabs_id=pageid+"_inner_head_frame"
    pid_full[pageid]=raw_pageid;

    $.ajax({
    url:""+pageid.replaceAll("_","-"), 
    async: true,
    type: "POST",
    data:page_param,
    beforeSend:function(){
    },
    complete:function(){
        AJAX_FINISH=1;
    },
    success: function(html){
        html=parse_static(html,pageid,1);
        $("#"+tabs_id).html(html);
    }
    });
}
var posX; var posY; var fdiv; 
function div_down(obj)
{
    fdiv=obj.parent();
    if(!event) event = window.event; //IE 
    posX = event.clientX - parseInt(fdiv.css("left")); 
    posY = event.clientY - parseInt(fdiv.css("top")); 
    document.onmousemove = mousemove; 
}
document.onmouseup = function() 
{ 
    document.onmousemove = null; 
} 
function mousemove(ev) 
{ 
    if(ev==null) ev = window.event;//IE 
    fdiv.css("left",  (ev.clientX - posX) + "px"); 
    fdiv.css("top" , (ev.clientY - posY) + "px"); 
}

