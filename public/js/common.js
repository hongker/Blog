$("#logout").click(function() {
	$.post("/login/logout",function(data){
	    var result = $.parseJSON(data);
	    if(result.errNo==0) {
			alert('退出成功');
			//跳转
			location.href='/';
		}else {
			alert(result.errMsg);
		}
	});
});