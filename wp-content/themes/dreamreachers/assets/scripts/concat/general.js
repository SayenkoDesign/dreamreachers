(function (document, window, $) {

	'use strict';

	// Load Foundation
	$(document).foundation();
        
    $(".nav-primary").accessibleDropDownMenu();
    
    /*
    $(window).on('load changed.zf.mediaquery', function(event, newSize, oldSize) {
        
        if( Foundation.MediaQuery.atLeast('large') ) {
          $('.site-header').addClass('fixed');
          //$('.sticky-header').css( 'height', $('.site-header').height() );
        }
        else {
            $('.sticky-header').css( 'height', '' );
        }
                
    });
    */
    
    
    // Toggle menu
    
    $('li.menu-item-has-children > a').on('click',function(e){
        
        var $toggle = $(this).parent().find('.sub-menu-toggle');
        
        if( $toggle.is(':visible') ) {
            $toggle.trigger('click');
        }
        
        e.preventDefault();

    });
    
    
    $('.nav-primary .menu-item-object-service a').each(function() {
         var icon = $(this).data('icon');
         $(this).wrapInner( '<span></span>');
         $(this).prepend( icon  );
    });
    
    
    $('.animate-numbers span').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
    
    
}(document, window, jQuery));
