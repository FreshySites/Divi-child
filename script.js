jQuery( document ).ready( function( $ ) {
	// Create collapsible sub menus in Divi Header Nav
	$( "<div class='sub-menu-toggle'></div>" ).insertBefore( "#main-header #mobile_menu.et_mobile_menu .menu-item-has-children > a" );
	$( "#main-header #mobile_menu.et_mobile_menu .sub-menu-toggle" ).click(function () {
		$(this).toggleClass("popped");
	});
} );
