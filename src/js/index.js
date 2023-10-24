jQuery( document ).ready( function( $ ) {

	// Create collapsible sub menus in Divi Header Nav
	$( "<div class='sub-menu-toggle'></div>" ).insertBefore( "#main-header #mobile_menu.et_mobile_menu .menu-item-has-children > a" );

	// Submenu toggle
	const subMenuToggle = $( '#main-header #mobile_menu.et_mobile_menu .sub-menu-toggle' )

	if ( subMenuToggle.length ) {
		// Add the click event
		subMenuToggle.click( function() {
			// Toggle the class
			$( this ).toggleClass( 'popped' );
		} );
	}

	// Place custom javascript here
	// console.log( 'Hello World!' );
} );