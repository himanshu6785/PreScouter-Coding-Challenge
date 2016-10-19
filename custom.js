/**** Function to Call Ajax to Get Route b/w source and destination *****/
function getBestRoutes(){
	
	var dCity = $('#departure_city').val();		// Departure Value
	var aCity = $('#arrival_city').val();		// Arrival Value
	var sort_route = $('input[name=sort_route]:checked').val();	//Filter Value

	$.ajax({
		type: "POST",
		url: "ajax.php",
		data : { dCity : dCity, aCity : aCity, route : sort_route  },
		success: function(result){
			$("#result_div").html(result);	// Adding response to Div
		}, error: function(jqXHR, textStatus, errorThrown) {
			if(errorThrown){
				$("#result_div").html(errorThrown);	// Adding response to Div
			}
			else{
				$("#result_div").html("No Route Found");	// Adding response to Div	
			}
		}
	});

}

/**** Function to Reset From Fileds *****/
function clearForm(){
	$('#departure_city').prop('selectedIndex',0);
	$('#arrival_city').prop('selectedIndex',0);
	$('input[name="sort_route"]').prop('checked', false);
	
	$('#search').trigger('click');
	
}
