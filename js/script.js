jQuery( document ).ready(function(){
	jQuery( '#wpsos .toggle-btn' ).show();
	jQuery( '#wpsos .toggle' ).hide();
	jQuery( '#wpsos .toggle-btn' ).click( function( e ){
		e.preventDefault();
		jQuery( '#wpsos #toggle-' + e.target.id ).fadeToggle();
	})
});