jQuery( document ).ready( function( $ ) {
	// Create collapsible sub menus in Divi Header Nav
	$( "<div class='sub-menu-toggle'></div>" ).insertBefore( "#main-header #mobile_menu.et_mobile_menu .menu-item-has-children > a" );
	$( "#main-header #mobile_menu.et_mobile_menu .sub-menu-toggle" ).click(function () {
		$(this).toggleClass("popped");
	});
	// If a Divi Blurb module has a link around the blurb image or the blurb title, then move the link so it wraps the entire blurb
	$('.et_pb_blurb.blurb-click').each(function() {
		var blurb_content = $('.et_pb_blurb_content', this);
		var blurb_image_link = $('.et_pb_blurb_content .et_pb_main_blurb_image a', this);
		var blurb_title_link = $('.et_pb_blurb_content .et_pb_blurb_container .et_pb_module_header a', this);
		// if blurb has an image link and a title link, unwrap both links, and then wrap the image link around the entire content
		if ( $(blurb_image_link).length && $(blurb_title_link).length ) {
			blurb_image_link.contents().unwrap();
			blurb_title_link.contents().unwrap();
			blurb_content.wrap(blurb_image_link);
		}
		// otherwise, if blurb has only an image link, unwrap it, and then wrap it around the entire content
		else if ( $(blurb_image_link).length ) {
			blurb_image_link.contents().unwrap();
			blurb_content.wrap(blurb_image_link);
		}
		// otherwise, if blurb has only a title link, unwrap it, and then wrap it around the entire content
		else if ( $(blurb_title_link).length ) {
			blurb_title_link.contents().unwrap();
			blurb_content.wrap(blurb_title_link);
		}
	});
} );