(function (document, window, $) {

	'use strict';

	// Load Foundation
	$(document).foundation();
   
    
    // Toggle menu
    
    $('li.menu-item-has-children > a').on('click',function(e){
        
        var $toggle = $(this).parent().find('.sub-menu-toggle');
        
        if( $toggle.is(':visible') ) {
            $toggle.trigger('click');
            e.preventDefault();
        }
        
        

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
