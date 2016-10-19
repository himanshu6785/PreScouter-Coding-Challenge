<?php
/* 
 * 
 * Template to display form to find cheapest and fastest route b/w source to destination
 * 
 */
?>

<style>

	*{margin:0;padding:0;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;-o-box-sizing: border-box;-ms-box-sizing: border-box;box-sizing: border-box;}
	.container{margin: 50px auto 0;max-width: 400px;width: 100%;}
	#routeForm {border: 1px solid #CCC;width: 100%;display: inline-block;margin-bottom: 20px;padding: 20px;-webkit-box-shadow: 0 0 9px #ccc;-moz-box-shadow: 0 0 9px #ccc;-o-box-shadow: 0 0 9px #ccc;-ms-box-shadow: 0 0 9px #ccc;box-shadow: 0 0 9px #ccc;}
	#routeForm span {float: left;width: 180px;}
	#routeForm input[type="button"] {background: #ccc none repeat scroll 0 0;border: 0 none;margin-right: 10px;padding: 8px;}
	ul{background:#EEE;padding:10px;margin:0;float:left;list-style:none;width:100%;max-width:400px;}
	ul li{background:#FFF;margin:0 0 10px;float:left;width:100%;color:#777;}
	ul li span{float:left;padding:10px; max-width:200px;width:100%;display:inline-block;}
	ul li span ins{display:block;text-decoration:none;font-style:italic;font-size:13px;}
	ul li span + span{float:right;width:auto;}
	ul li span b{float:right;display:inline-block;}
	ul li:last-child span{font-weight:bold;}
	
</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<div class="container">
<form name="routeForm" id="routeForm">
	<div>
		<span>Departure City</span>    
		<select name="departure_city" id="departure_city">
			<option value="">--Departure City--</option>
			<option value="London">London</option>
			<option value="Amsterdam">Amsterdam</option>
			<option value="Warsaw">Warsaw</option>
			<option value="Stockholm">Stockholm</option>
		</select>
	</div>
    
	<p>&nbsp;</p>

	<div>
		<span>Arrival City</span>
		<select name="arrival_city" id="arrival_city">
			<option value="">--Arrival City--</option>
			<option value="London">London</option>
			<option value="Amsterdam">Amsterdam</option>
			<option value="Warsaw">Warsaw</option>
			<option value="Stockholm">Stockholm</option>
		</select>
	</div>

	<p>&nbsp;</p>
	
    <input type="radio" name="sort_route" value="Cheapest" onclick="getBestRoutes();" checked> Cheapest
    <input type="radio" name="sort_route" value="Fastest" onclick="getBestRoutes();"> Fastest
    
	<p>&nbsp;</p>
	<div>
		<input type="button" value="Search" id="search" onclick="getBestRoutes();">
		<input type="button" value="Reset" id="reset" onclick="clearForm();">
	</div>
	
</form>

<div id="result_div"></div>
</div>

<!------------- Script Begins ------------------>
<script type="text/javascript">
	
    /**** Function to Call Ajax to Get Route b/w source and destination *****/
    function getBestRoutes(){
		
        var dCity = $('#departure_city').val();
        var aCity = $('#arrival_city').val();
        var sort_route = $('input[name=sort_route]:checked').val();
 
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
</script>
