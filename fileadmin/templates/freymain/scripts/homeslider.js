$(document).ready(function(){

	
$('.carousel').each(function(index, element) {
	var carnr = 'carousel'+index;
	$(this).attr('id', carnr);

});	
	
	

/* Homepage Aktuell Slider */
$('#carousel0 .news-list-view').on('init', function(event, slick){
    console.log("initialized")
});
	
$('#carousel0 .news-list-view').slick({
		infinite: true,
		slidesToShow:2,
		slidesToScroll:1,
		autoplay:true,
		autoplaySpeed:2000,
		dots:false,
		arrows:true,
		responsive: [
	 {
      breakpoint: 1080,
      settings: {
        arrows: true,
        slidesToShow: 2, 
		slidesToScroll: 1
      }
    },	
			
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2, 
		slidesToScroll: 1
      }
    },
	    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1, 
		slidesToScroll: 1
      }
    }	
  ]
});
	
	
});
	
	

	
/* match height aktuell panels*/
$(function() {
    $('.slick-slide').matchHeight();
});
	

/* Remove empty p tags */
$('p').each(function() {
	var $this = $(this);
	if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
		$this.remove();
});




