jQuery(function($){
	//When you click on a link with class of poplight and the href starts with a #
	$('a.poplight').on('click', function() {
		var popID = $(this).data('rel'); //Get Popup Name
		var popWidth = $(this).data('width'); //Gets Popup Width
		//Fade in the Popup and add close button
		$('#' + popID).fadeIn().css({ 'width': popWidth}).prepend('<a href="#" class="close"><img src="./img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>');
		//Define margin for center alignment (vertical + horizontal) - we add 80 to the height/width to accomodate for the padding + border width defined in the css
		var popMargTop = ($('#' + popID).height() + 80) / 2;
		var popMargLeft = ($('#' + popID).width() + 80) / 2;
		//Apply Margin to Popup
		$('#' + popID).css({
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		//Fade in Background
		$('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
		$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer

		return false;
	});
	//Close Popups and Fade Layer
	$('body').on('click', 'a.close, #fade', function() { //When clicking on the close or fade layer...
		$('#fade , .popup_block').fadeOut(function() {
			$('#fade, a.close').remove();
	}); //fade them both out

		return false;
	});
});
