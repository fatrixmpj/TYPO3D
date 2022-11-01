// JavaScript Document

	
$( ".image-list .image-label" ).click(function() {
 	//$(this).closest('input[type="radio"]').prop("checked", true);
	$(this).parent().find('input[type="radio"]').prop("checked", true);
});

