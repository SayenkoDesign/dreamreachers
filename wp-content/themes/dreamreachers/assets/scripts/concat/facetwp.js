(function($) {
    $(document).on('facetwp-loaded', function() {
        if (FWP.loaded) {
            var target = $('.facetwp-template');
            if( $('.facetwp-filters').length ) {
                var target = $('.facetwp-filters');
            }
                        
            $.smoothScroll({
                scrollTarget: target,
                offset: -150
            });
            
            
        }
        
        Foundation.reInit('equalizer');
        
    });
    
    
    
    
    
    
    
    
})(jQuery);