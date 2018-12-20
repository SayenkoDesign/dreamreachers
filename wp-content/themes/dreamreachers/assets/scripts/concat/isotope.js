(function($) {
	'use strict';
	
    var $grid = $('.isotopes.grid');
    
    $( '.details', $grid).matchHeight({
        byRow: false,
        property: 'height',
        target: null,
        remove: false
    });
    
    
	 if( $grid.size() ) {
        
        Isotope.Item.prototype._create = function() {
          // assign id, used for original-order sorting
          this.id = this.layout.itemGUID++;
          // transition objects
          this._transn = {
            ingProperties: {},
            clean: {},
            onEnd: {}
          };
          this.sortData = {};
        };
        
        Isotope.Item.prototype.layoutPosition = function() {
          this.emitEvent( 'layout', [ this ] );
        };
        
        Isotope.prototype.arrange = function( opts ) {
          // set any options pass
          this.option( opts );
          this._getIsInstant();
          // just filter
          this.filteredItems = this._filter( this.items );
          // flag for initalized
          this._isLayoutInited = true;
        };
        
        // layout mode that does not position items
        Isotope.LayoutMode.create('none');
        
        
        var itemReveal = Isotope.Item.prototype.reveal;
        Isotope.Item.prototype.reveal = function() {
          itemReveal.apply( this, arguments );
          $( this.element ).removeClass('isotope-hidden');
          $( this.element ).unwrap( '<div class="hide" />' );
        };
        
        var itemHide = Isotope.Item.prototype.hide;
        Isotope.Item.prototype.hide = function() {
          itemHide.apply( this, arguments );
          $( this.element ).addClass('isotope-hidden');
          $( this.element ).wrap('<div class="hide" />');
          
        };
        
        
        $grid.isotope({
          itemSelector: 'article',
          layoutMode: 'none',
          transitionDuration: 0,
           // disable scale transform transition when hiding
            hiddenStyle: {
                opacity: 0,
                transform: 0
            },
            visibleStyle: {
                opacity: 1,
                transform: 0
            }
        });
        
        // filter items on button click
        $('.filter-button-group').on( 'click', 'button', function() {
            $('.filter-button-group button').removeClass("active");
            $(this).addClass("active");  
            $('#region-filters').foundation('close');
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ 
                filter: filterValue
            });
            
        });

    }

	
})(jQuery);
