jQuery(document).ready( function(){

	jQuery("#range-submit").on("click", function( e ){
		e.preventDefault();
		console.log('got here');
		// get range
		var rangestart = String( jQuery("select#range-start-year").val() ) + 
			String( jQuery("select#range-start-month").val() ) +
			String( jQuery("select#range-start-day").val() );
		var rangeend = String( jQuery("select#range-end-year").val() ) + 
			String( jQuery("select#range-end-month").val() ) +
			String( jQuery("select#range-end-day").val() );
console.log("rangestart: " + rangestart);
console.log("rangeend: " + rangeend);
		var entries = new Miso.Dataset({
			url: "harvest-range-json.php?rangestart=" + rangestart + "&rangeend=" + rangeend
		});
		console.dir(entries);
		// fetch data
		entries.fetch().then(function(){
	
				var total_hours = this.column("hours").data.reduce(
					function(previousValue, currentValue, index, array){
  						return previousValue + currentValue;
					});
			 

				var billable_entries = entries.rows( function(row) {
					return row["project-billable"] == true;
				});

				var total_billable_hours = billable_entries.column("hours").data.reduce(
					function(previousValue, currentValue, index, array){
						return previousValue + currentValue;				
					});

				console.log("Dataset Ready. Columns: " + this.columnNames() );
				console.log("There are " + this.length + " rows" );
				console.log("Hours: " + total_hours );
	
				console.log("Billable Hours: " + total_billable_hours );
		});
	});

});