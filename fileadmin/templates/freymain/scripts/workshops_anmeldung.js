// Workshops Anmeldung

$( document ).ready(function() {

	/* get values  */
	var date = $(".article h5").data("t3-date");
	var title = $(".article h1").data("t3-title");

	$("#powermail_field_workshop").val(""+ date+": "+ title+"");
	
});