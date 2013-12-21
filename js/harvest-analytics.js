jQuery(document).ready( function(){
	console.log('got here');
	var entries = new Miso.Dataset({
		url: 'harvest-range-json.php'
	});

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