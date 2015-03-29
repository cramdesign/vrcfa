/*
(function( $ ) {
	
	//Initializing jQuery UI Datepicker
	$( '#sbe-event-start-date' ).datepicker({
		dateFormat: 'MM dd, yy',
		onClose: function( selectedDate ){
			$( '#sbe-event-end-date' ).datepicker( 'option', 'minDate', selectedDate );
		}
	});
	
	$( '#sbe-event-end-date' ).datepicker({
		dateFormat: 'MM dd, yy',
		onClose: function( selectedDate ){
			$( '#sbe-event-start-date' ).datepicker( 'option', 'maxDate', selectedDate );
		}
	});

})( jQuery );
*/

var start_date = new Pikaday({
	field: document.getElementById('sbe-start-date'),
	format: 'MM dd, yy',
	onSelect: function() {
		end_date.setMinDate(this.getDate());
	}
});
 

var end_date = new Pikaday({
	field: document.getElementById('sbe-end-date'),
	format: 'MM dd, yy',
	onSelect: function() {
		start_date.setMaxDate(this.getDate());
	}
});
