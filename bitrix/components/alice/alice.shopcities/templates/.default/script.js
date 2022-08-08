
$(window).load(function() {
	//$(".contactsdata").height($(".sitelogo").height());
});
$(document).ready(function(){
	//hide opt enter

	$(".banner-flow .opt-close, .opt-enter .opt-close").click(function() {
		var url = 'ajax.php';
		$(".opt-enter").css("position","static");
		$(".banner-flow").css("display","none");		
		$(".opt-close").css("display","none");
		$.post(	url,
				{
				'SESSION_OPT_HIDE':'Y'
				},
				function(data) {
				});
		return false;
	});
	//open city selector
	$(".header_city_selector > a.selected").click(function() {
	    $(".choose_city_popup").fadeToggle();
	});
    // select city
	$(".top_cities .region_link").click(function() {
	    var sHost = $(this).prop("rel");		
	    var sCompath = $(this).attr("compath");
		url = sCompath + '/ajax.php';
		var data = "cityid=" + sHost;
		$.post(	url,
				{
				'ajax_call':'y',
				'cityid':sHost
				},
				function(data) {
			$(".choose_city_popup").toggle();
			$(".header_city_selector > a.selected").html(data);     
			window.location.reload();
        });
		return false;
	});
    // close selector
	$(".choose_city_popup .close").click(function(){
	    $(".choose_city_popup").fadeOut();
	    return false;
	});
	$(".choose_city_popup").mouseleave(function() {
	    $(".choose_city_popup").fadeOut();
	    return false;
	})
});