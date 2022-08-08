
function CheckFieldsFill(button,step){
	$("#"+button).removeClass("disabled");			
	$("#"+step+ " input, #"+step+" textarea").each(function() {
		if ($(this).val()==""){
			$("#"+button).addClass("disabled");
			return;	
		}
	});
}

function SelectTypeDelivery(val){
	$("#order_form_content .selected").removeClass("selected");
	switch (val.id) {
	case 'bt-delivery':
		$("#tab-delivery").addClass("selected");
		$("#popupOrder").remove();
		$(".checked").removeClass("checked");
		if (!$("#addressStep *").hasClass("sale_order_table")) 
			goaddressstep();		
		break;
	case 'bt-self-delivery':
		$("#tab-self-delivery").addClass("selected");
		window.location.reload();
	    break;
	case 'bt-ozon-delivery':
		$("#tab-ozon-delivery").addClass("selected");
		$("#popupOrder").remove();
	    break;
	}	
	$(val).addClass("selected");	
}

function ShowOrderDeliveryInfo(url,val,id){
	if ($(val).hasClass("checked")) return false;
	$("#del-holder-step1 *, #del-holder-step2 *, #del-holder-step3 *").remove();	
	if ($(".point-self-delivery *").hasClass("checked")){
		$("#popupOrder").remove();
		$(".checked").removeClass("checked");
	}
	$(val).addClass("checked");
	$(val).parent().append("<div class='b-box' id='popupOrder'></div>");
	$("#popupOrder").append("<div class='b-ico-wheel'></div>");	
	$("#ozon-del-content").remove();
	$.post(
		url,
		{
			"is_ajax_post":"Y",
			"show_delivery_info":"Y",
			"OUTPOST_ID":id			
		},
		function(data) {
			$(".b-ico-wheel").remove();
			$("#popupOrder").append(data);
		}
	);
};     

function CloseOrderDeliveryInfo(){
	$("#popupOrder").remove();
	$(".checked").removeClass("checked");
}

function ToggleOrderDeliveryInfo(){
	$("#point").toggle();
}

function goaddressstep(){
	$(".active").removeClass("active");
	$("#del-holder-step2 *").remove();
	$("#del-holder-step3 *").remove();		
	var orderForm = $('#ORDER_FORM');
	var pserialize = orderForm.serialize()+"&del_step_1=Y";
	$("#del-holder-step1 *").remove();	
	$("#del-holder-step1").append("<div class='b-ico-wheel'></div>");	
	$.post(
		orderForm.attr('action'),
		pserialize,
		function(data) {
			$('#dummy_ajax').append(data);
			data1 = $("#dummy_ajax").find('#ajax-content-step1').html();
			data2 = $("#dummy_ajax").find('#ajax-sale_order_summary').html();			
			$(".b-ico-wheel").remove();			
			$('#dummy_ajax *').remove();
			$("#del-holder-step1").append(data1);
			$("#holder-summary *").remove();
			$("#holder-summary").append(data2);
			$("#addressStep").addClass("active");
		}
	);
}
function gochargestep(){
	if($("#b-go-сhargestep").hasClass("disabled")) return false;
	$("#sale_order_delivery").remove()	
	var orderForm = $('#ORDER_FORM');	
	var pserialize = orderForm.serialize()+"&del_step_2=Y";	
	$("#del-holder-step1 *").remove();
	$("#del-holder-step2 *").remove();
	$("#del-holder-step1, #del-holder-step2").append("<div class='b-ico-wheel'></div>");		
	$(".active").removeClass("active");
	$.post(
		orderForm.attr('action'),
		pserialize,
		function(data) {
			$('#dummy_ajax').append(data);
			data1 = $("#dummy_ajax").find('#ajax-content-step1').html();
			data2 = $('#dummy_ajax').find('#ajax-content-step2').html();
			data3 = $('#dummy_ajax').find('#ajax-content-step3').html();
			$(".b-ico-wheel").remove();
			$('#dummy_ajax *').remove();
			$("#del-holder-step1").append(data1);
			$("#del-holder-step2").append(data2);
			$("#chargestep").addClass("active");
		}
	);
}
function gopersonaldatastep(){
	if($("#b-go-personaltep").hasClass("disabled")) return false;
 	$(".active").removeClass("active");
	var orderForm = $('#ORDER_FORM');
	var pserialize = orderForm.serialize()+"&del_step_3=Y";
	$("#del-holder-step2 *, #del-holder-step3 *, #holder-summary *").remove();	
	$("#del-holder-step2").append("<div class='b-ico-wheel'></div>");	
	$("#ozon-del-content").remove();
	$.post(
		orderForm.attr('action'),
		pserialize,	
		function(data) {
			$('#dummy_ajax').append(data);
			data1 = $('#dummy_ajax').find('#ajax-content-step2').html();
			data2 = $('#dummy_ajax').find('#ajax-content-step3').html();
			data3 = $('#dummy_ajax').find('#ajax-sale_order_summary').html();			
			$(".b-ico-wheel").remove();
			$('#dummy_ajax *').remove();
			$("#del-holder-step2").append(data1);
			$("#del-holder-step3").append(data2);
			$("#holder-summary").append(data3);			
			$("#personaldatastep").addClass("active");
		}
	);
}

function selectdelivery(){
	var orderForm = $('#ORDER_FORM');
	var pserialize = orderForm.serialize()+"&recalc_summary=Y";
	$("#holder-summary *").remove();
	$("#holder-summary").append("<div class='b-ico-wheel'></div>");	
	$.post(
		orderForm.attr('action'),
		pserialize,	
		function(data) {
			$(".b-ico-wheel").remove();
			$("#b-go-personaltep").removeClass("disabled");
			$("#holder-summary").append(data);
		}
	);
}

function submitForm(value){
	if($(value).hasClass("disabled")) return false;
	$("#error-holder *").remove();
	var orderForm = $('#ORDER_FORM');
	var url = orderForm.attr('action');
	var pserialize = orderForm.serialize()+"&confirmorder=Y";
	console.log(pserialize);
	$.post(
		url,
		pserialize,	
		function(data) {
			$('#error-holder').append(data);
		}
	);
}

function submitOzon(ozon_id){

	if (ozon_id == 'undefined:undefined')
		return false;
	
	var orderForm = $('#ORDER_FORM');
	$("#error-holder-ozon *").remove();
	var url = orderForm.attr('action');
	var pserialize = orderForm.serialize()+"&confirmorder=Y&ORDER_PROP_25=" + ozon_id;

	$.post(
		url,
		pserialize,	
		function(data) {
			$('#error-holder-ozon').append(data);
		}
	);
}


$( window ).on( "message", receiveMessage);
function receiveMessage(event)
{
	var price = 0;
	originalEvent = event.originalEvent;
    // Важно не слушать чужие события
	if (originalEvent.origin !== "https://rocket.ozon.ru")
     return;
	//ожидаем строку с JSON
	if (typeof(originalEvent.data) == "string")
	{
		data = JSON.parse(originalEvent.data);
		ozon_packages.forEach(function(item) {
			var price_ = delivery_price(item, data.price);
			price = price + price_;
		});
		submitOzon(data.id+":"+data.address);		
	}
}

function volume_weight(value)
{
	//Объемный вес в кг
	return Math.max(value[1]*value[2]*value[3]/1000/1000/5, value[0]/1000);
}

function delivery_price(value, price)
{
	switch (price) {
		case 180:
			price_ext = 35;		
			break;	
		case 240:
			price_ext = 45;		
			break;	
		case 360:
			price_ext = 65;		
			break;	
		default:
			price_ext = 15;		
	}	
			console.log(price_ext);				
	volume_weight_ = volume_weight(value);
	if (volume_weight_ >= 5)
		price_=1.2*(price-Math.ceil(price*20/120)+(Math.ceil(volume_weight_-5))*price_ext);
	else 
		price_=price;
	return Math.ceil(price_*1.5/10)*10;
}
