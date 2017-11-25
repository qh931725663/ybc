var flag_view_index_setInterval=1;
var chuku_order_type;
var chuku_order_seller_bianhao; 
var chuku_order_seller_name; 
var chuku_order_seller_cycle;
var chuku_select_storewarehouse_bianhao;
var chuku_select_storewarehouse_name;
var chuku_select_storewarehouse_type;
var chuku_order_to_dangkou_bianhao;
var chuku_order_to_dangkou_name;

var tuihuo_order_seller_bianhao;
var tuihuo_order_seller_name; 
var tuihuo_order_seller_cycle;
var tuihuo_select_storewarehouse_bianhao; 
var tuihuo_select_storewarehouse_name;

var arrange_up_select_storewarehouse_bianhao;
var arrange_up_select_storewarehouse_name;

var arrange_factory_select_storewarehouse_bianhao;
var arrange_factory_select_storewarehouse_name;
var arrange_factory_select_storewarehouse_type;

var warehousepurchase_zjbh=0;

function search(page,form)
{
    var form_id="#pid_"+page+" #"+form;
    var ipages_id = $(form_id).find(".ipages").attr("id");
    $(form_id).find(".ipages").set_page_num(page,ipages_id,1);
    refresh_inner(page+"?"+$(form_id).serialize() );
}

//stack begin
function Stack()   
{  
    this.dataStore = [] ;  
    this.top = 0;  
    this.push = push;  
    this.pop = pop;  
    this.peek = peek;  
    this.clear = clear;  
    this.length = length;  
}  
function push(element)   
{  
    this. dataStore[this.top++] = element;  
}  
function peek()   
{  
    return this.dataStore[this.top- 1] ;  
}  
function pop()   
{  
    return this.dataStore[--this.top] ;  
}  
function clear()   
{  
    this.top = 0;  
}  
function length()   
{  
    return this.top;  
}  
//stack end 
