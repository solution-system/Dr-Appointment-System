$(function() {

	$('#snell-slideshow .pics').cycle({
		fx:     'fade',
		speed:   2500,
		timeout: 2000 , 
		next:   '#next',
		prev:   '#prev',
		pause:  1 ,
		after:     function() {
            $('#caption').html(this.alt);
        }

	});	
});

