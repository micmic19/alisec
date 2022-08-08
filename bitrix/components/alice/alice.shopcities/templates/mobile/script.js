
function alicesetcity(param) {
	url='/bitrix/components/alice/alice.shopcities/ajax.php';
	var data = "cityid=" + param;
	BX.showWait();
    BX.ajax.post(url, data, function() {
		window.location="/m/";
        BX.closeWait();
    });
	return false;	
} 
