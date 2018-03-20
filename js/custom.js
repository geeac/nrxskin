( function ( document, $, undefined ) {
	$(document).ready(function () {

		/* Push the body and the nav over by 285px over */
		$('.icon-menu').click(function() {
			$('.nav-secondary').animate({
				left: "0px"
			}, 200);

			$('body').animate({
				left: "285px"
			}, 200);
				
			$( '.site-container' ).prepend( '<div class="overlay"></div>' );
		});

		/* Then push them back */
		var closeMenu = function() {
			$('.nav-secondary').animate({
				left: "-285px"
			}, 200);

			$('body').animate({
  				left: "0px"
    			}, 200);
			$( '.overlay' ).remove();

		}
		$(document).on('click', '.icon-close', closeMenu);
		$(document).on('click', '.overlay', closeMenu);

		/* Subscribe optin rollover*/
		$(".header-top .button.subscribe").hover( function() { $(".header-top #mc_embed_signup").show();  } );
		$(".header-top #mc_embed_signup").mouseleave(function() { $(this).hide();  } );

		$(".entry-content .mc-field-group.input-group h5").click( function() { $(".entry-content .mc-field-group.input-group ul").toggle();  } );
		/*$(".mc-field-group.input-group ul").mouseleave(function() { $(this).hide();  } );*/


	});

})( document, jQuery );
