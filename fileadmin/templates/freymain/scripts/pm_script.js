// JavaScript Document
$(document).ready(function(){
	$( ".tx-powermail" ).addClass( "clearfix" );
	/* add parsley error to seperate invoice fields */
	$("#powermail_field_rg_name").attr({required:'required', 'data-parsley-required-message':'Dieses Feld muss ausgef&uuml;llt werden'});
	$("#powermail_field_rg_strasse").attr({required:'required', 'data-parsley-required-message':'Dieses Feld muss ausgef&uuml;llt werden'});
	$("#powermail_field_rg_plzort").attr({required:'required', 'data-parsley-required-message':'Dieses Feld muss ausgef&uuml;llt werden'}); 
});  



$( "form" ).change(function() {
	
	/* show - hide fields : seperate invoice adress */
	if($("#powermail_field_rechnungsadresse_1").is(":checked")) {
		 $( ".layout2" ).hide( "slow" );
		 // disable required fields - if no separate invoice adress 
		 $("#powermail_field_rg_name").removeAttr('required data-parsley-required-message').removeClass( "parsley-error" ).prop( "disabled", true );
		 $("#powermail_field_rg_strasse").removeAttr('required data-parsley-required-message').removeClass( "parsley-error" ).prop( "disabled", true );
		 $("#powermail_field_rg_plzort").removeAttr('required data-parsley-required-message').removeClass( "parsley-error" ).prop( "disabled", true );
		 $("#powermail_field_rechnungsadresse_01").prop( "disabled", true );

		 $(".powermail_fieldwrap_rg_name ul").css("display", "none");
		 $(".powermail_fieldwrap_rg_strasse ul").css("display", "none"); 
		 $(".powermail_fieldwrap_rg_plzort ul").css("display", "none"); 
	}
	else {
		 $( ".layout2" ).show( "slow" );
		 // turn on required fields - if separate invoice adress
		 $("#powermail_field_rg_name").attr({required:'required', 'data-parsley-required-message':'Dieses Feld muss ausgef&uuml;llt werden'}).prop( "disabled", false );
		 $("#powermail_field_rg_strasse").attr({required:'required', 'data-parsley-required-message':'Dieses Feld muss ausgef&uuml;llt werden'}).prop( "disabled", false );
		 $("#powermail_field_rg_plzort").attr({required:'required', 'data-parsley-required-message':'Dieses Feld muss ausgef&uuml;llt werden'}).prop( "disabled", false );
		 $("#powermail_field_rechnungsadresse_01").prop( "disabled", false );
		 
		 $(".powermail_fieldwrap_rg_name ul").css("display", "block");
		 $(".powermail_fieldwrap_rg_strasse ul").css("display", "block"); 
		 $(".powermail_fieldwrap_rg_plzort ul").css("display", "block"); 
	}
});






/* turn off hidden fields - if item is not selected */
$( "form" ).submit(function( event ) {

	var rosenstrauss  = document.getElementById('powermail_field_anzahlrosenstrusse').value;
	var saisonstrauss  = document.getElementById('powermail_field_anzahlsaisonstrusse').value;
	var blumenherz  = document.getElementById('powermail_field_anzahlblumenherzen').value;
	var orchidee  = document.getElementById('powermail_field_anzahlorchideen').value;
	var langrosen  = document.getElementById('powermail_field_anzahllangstieligerosen').value;
	var blumenschale  = document.getElementById('powermail_field_preisvorstellung_02').value;
	var blumengesteck  = document.getElementById('powermail_field_preisvorstellung_03').value;
	var karte  = document.getElementById('powermail_field_anzahl').value;
	
	
	//Rosenstrauss
	if ( rosenstrauss.length === 0 )  {
	 $('#powermail_field_rosenstrauss').val("").attr("disabled",true);
	}
		
	//Saisonstrauss
	if ( saisonstrauss.length === 0 )  {
	 $('#powermail_field_saisonstrauss_01').val("").attr("disabled",true);
	}
	
	//Blumenherz
	if ( blumenherz.length === 0 )  {
	 $('#powermail_field_bestblumenherz').val("").attr("disabled",true);
	}
	
	//Orchidee
	if ( orchidee.length === 0 )  {
	 $('#powermail_field_bestorchidee').val("").attr("disabled",true);
	}
	
	//Langstielige Rosen
	if ( langrosen.length === 0 )  {
	 $('#powermail_field_bestlangstieligerosen').val("").attr("disabled",true);
	}
	
	//Blumenschale Sukkulenten
	if ( blumenschale.length === 0 )  {
	 $('#powermail_field_bestblumenschaltesukkulenten').val("").attr("disabled",true);
	}
	
	//Blumengesteck
	if ( blumengesteck.length === 0 )  {
	 $('#powermail_field_bestblumengesteck').val("").attr("disabled",true);
	}
	
	
	//Karte
	if ( karte.length === 0 )  {
	 $('#powermail_field_bestkarte').val("").attr("disabled",true);
	}
	 
 
return;
});