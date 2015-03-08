function rhdSocialStyle( elemH, elemV ) {
	var $window = jQuery(window);

	// Init
	if ( elemH.length && elemH.visible() ) {
		elemV.hide();

		$window.scroll(function(){
			if ( elemH.visible() === false ) {
				elemV.fadeIn('fast');
			} else {
				elemV.fadeOut('fast');
			}
		});
	} else {
		elemV.show();
	}
}