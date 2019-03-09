$(document).ready (function(){
	$(".sidebar-main #dezign-page-choose").change(function(){
		var class_select = $(this).val();
		$(".page-wrapper").removeClass("dezign-page-layout");
		$(".page-wrapper").removeClass("dezign-friendly");
		$(".page-wrapper").removeClass("dezign-page-view");
		$(".page-wrapper").addClass(class_select);
	});
});