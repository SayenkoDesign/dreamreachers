(function (document, window, $) {

	'use strict';
    
    var $other = $('#choice_8_1_4');
    var $other_amount = $('#input_8_4');
    
    $('.populate-family select').on('change', function() {
        var matches = this.value.match(/\[(.*?)\]/);

        if (matches) {
            var submatch = matches[1];
            var values = submatch.split('|');
            if(values[0]) {
               $other_amount.val('$' + values[0]); 
               $other.attr('checked',true);
            }
            
        } else {
            //$('#input_8_4').val('');
            //$('#choice_8_1_4').attr('checked',false);
        }
    });

	
    $('#input_8_1 input[type=radio]').change(function() {
                
        var selected = $('.populate-family select').children("option:selected").val();
        var matches = selected.match(/\[(.*?)\]/);
        
        if (matches) {
            var submatch = matches[1];
            var values = submatch.split('|');
            var check_amount = 0;
            
            if( true === $other.attr('checked') ) {
                $other_amount.val('$' + values[0]); 
            } else {
                if(values[0]) {
                    check_amount = values[0];
                    var amount = this.value.split('|');
                    // Let them set a lower amount only
                    if( amount[1] > 0 && amount[1] < check_amount ) {
                        $other_amount.val('$' + amount[1]);
                    }
                }
            }
            
            
        }
    });
    
    
}(document, window, jQuery));
