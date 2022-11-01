/* Module Global */
$(".gridcontainer").wrapInner( '<div class="row" id="gridrow" /></div>');

/* build columns for bootstrap */
$(".gridcontainer" ).each(function() {
   var cols =  $(this).attr('data-cols');
  $(this).find('#gridrow .modul > div, #gridrow .modul > a').wrap( '<div class="col-sm-'+ cols +' gridcol"></div>');
  
});

/* match height of content elements */
$(".gridcontainer" ).each(function() {
   $(function() { $('.gridcol').matchHeight(); });
});


 /* remove unused t3 classes */
$(".gridcol" ).each(function() {
    $(this).find('.csc-textpic:first').removeClass().addClass('csc-textpic');
    $(this).find('.csc-textpic:first').unwrap();
   
});


/* put t3 text after figure */
$('.gridcol .csc-textpic-text').each(function(){
	$(this).parent().find('figure').append($(this));
	$(this).wrap( '<figcaption></figcaption>');
}); 




/* put t3 header before body/p text */	
$('.gridcol .csc-header').each(function(){
	$(this).parent().find('.csc-textpic-text').prepend($(this));
}); 





/* Foto Gallery */
$( '.gallery .lightbox' ).append( '<div class="overlay" ><i class="fa fa-camera gcamera" aria-hidden="true"></i></div>');




/* Merkur Effect */
$('.team .mail').each(function() {
	//$(this).addClass('anim');
	//$(this).text($(this).text().replace('Email',''));
	
$('.team .mail').html('<i class="fa fa-envelope" aria-hidden="true"></i>');
$('.team .mphone').html('<i class="fa fa-phone-square" aria-hidden="true"></i>');
	

 //$(this).html('<img src="fileadmin/templates/dpmain/bilder/mail_icon.png" alt="" width="65" height="63" class="mailimg">'); 
});



/* match height of tx_news list view */
$(".news-list" ).each(function() {
   $(function() { $('.ncol').matchHeight(); });
});


