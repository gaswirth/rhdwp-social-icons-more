function rhdSocialStyle( elemH, elemV ) {
	var $window = jQuery(window);

	// Init
	if ( elemH.visible() )
		elemV.hide();
	else
		elemV.show();

	$window.scroll(function(){
		if ( elemH.visible() === false ) {
			elemV.fadeIn('fast');
		} else {
			elemV.fadeOut('fast');
		}
	});
}