<?php
/* 
 * 
 * Template to display form to find cheapest and fastest route b/w source to destination
 * 
 */
?>
<!DOCTYPE html>
	
	<head>
		<title>PreScouter Coding Challenge</title>
		<link href="style.css" rel="stylesheet" /> 
	</head>
	
	<body>
		<!-- container div starts -->
		<div class="container">
			
			<!-- form starts -->
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
			<!-- form ends -->
			
			<!-- response div -->
			<div id="result_div"></div>
			
		</div>
		<!-- container div ends -->
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="custom.js"></script>
		
	</body>
</html>
