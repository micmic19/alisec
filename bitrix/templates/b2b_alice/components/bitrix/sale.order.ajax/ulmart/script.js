
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
	if (val.id=='bt-delivery'){
		$("#order_form_content .selected").removeClass("selected");
		$(val).addClass("selected");
		$("#tab-delivery").addClass("selected");
		$("#popupOrder").remove();
		$(".checked").removeClass("checked");
		if (!$("#addressStep *").hasClass("sale_order_table")) 
			goaddressstep();		
	}else{
		$("#tab-self-delivery").addClass("selected");	
		window.location.reload();		
	}
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
	$.post(
		url,
		pserialize,	
		function(data) {
			$('#error-holder').append(data);
		}
	);
}

/*
function fShowStore(id)
{
	var strUrl = '/bitrix/components/bitrix/sale.order.ajax/templates/visual/map.php';
	var strUrlPost = 'delivery=' + id;

	var storeForm = new BX.CDialog({
				'title': '<?=GetMessage('SOA_ORDER_GIVE')?>',
				head: '',
				'content_url': strUrl,
				'content_post': strUrlPost,
				'width':700,
				'height':450,
				'resizable':false,
				'draggable':false
			});

	var button = [
			{
				title: '<?=GetMessage('SOA_POPUP_SAVE')?>',
				id: 'crmOk',
				'action': function ()
				{
					GetBuyerStore();
					BX.WindowManager.Get().Close();
				}
			},
			BX.CDialog.btnCancel
		];
	storeForm.ClearButtons();
	storeForm.SetButtons(button);
	storeForm.Show();
}

function GetBuyerStore()
{
	BX('BUYER_STORE').value = BX('POPUP_STORE_ID').value;
	//BX('ORDER_DESCRIPTION').value = '<?=GetMessage("SOA_ORDER_GIVE_TITLE")?>: '+BX('POPUP_STORE_NAME').value;
	BX('store_desc').innerHTML = BX('POPUP_STORE_NAME').value;
	BX.show(BX('select_store'));
}
*/