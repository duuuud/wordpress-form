/* global wp, jQuery */

( function( $, api ) {
	$( function() {
		$('#submitForm input').on('focus', function() {
			$(this).prev().addClass('active-label');
		});
	} );
}( jQuery) );
