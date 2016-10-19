<?php
/* 
 * 
 * Ajax file to fetch all the routes b/w Source to Destination
 * 
 */

if(isset($_REQUEST['dCity']) && Isset($_REQUEST['aCity']) && isset($_REQUEST['route'])){
    
	if(!empty($_REQUEST['dCity']) && !empty($_REQUEST['aCity']) && !empty($_REQUEST['route'])){
		
		$dcity = $_REQUEST['dCity']; $aCity = $_REQUEST['aCity']; $sortRoute = $_REQUEST['route'];
		$json_file = file_get_contents('response.json');
		$jdata = json_decode($json_file,true);

		// get all the routes with Arrival.City
		$keys = array_keys(array_column($jdata['deals'], 'arrival'), $aCity);
		$arrRoutes = array();
		foreach($keys as $key){
			$arrRoutes[] =  $jdata['deals'][$key];  
		}
 
 
		/****************** Direct Route exists Begins *****************************/
		$directRoutes = array();
		foreach ($arrRoutes as $val){
		  if($val['departure'] ==  $dcity){
			 $directRoutes[] = $val; 
		  }  
		}
		
		if(count($directRoutes) > 0){
			if(trim($sortRoute) == 'Cheapest'){
			   $output[] = getCheapestRoute($directRoutes);  
			}
			if(trim($sortRoute) == 'Fastest'){
			   $output[] = getFastestRoute($directRoutes);  
			}
			showRouteOutput($output);
		}
		 /****************** Direct Route Ends *****************************/
		else{
 
			$departure = array();

			foreach($jdata['deals'] as $key => $value){
				if($value['departure'] == $dcity){
					$departure[$value['departure']][] =  $value;
				}
			}
 
			createRouteArray($departure[$dcity]);  // Calling function to get routes

		}
 
	}  
	else{
		echo 'Select all Fields';
	}
    
}


function getPossibleArrivalCities($allRoutes,$dcity){ 
    // get all the possible arrival cities
    $keys = array_keys(array_column($allRoutes, 'arrival'), $aCity);
    echo $dcity;exit;
}


/*
 * 
 * Function to Get Cheapest Route b/w source and destination 
 * 
 */
function getCheapestRoute($routes){
    usort($routes,'CostAscSort');
    return $routes[0];
}


function CostAscSort($item1,$item2)
{
    if ($item1['cost'] == $item2['cost']) return 0;
    return ($item1['cost'] > $item2['cost']) ? 1 : -1;
}


/*
 * 
 * Function to Get Fastest Route b/w source and destination 
 * 
 */
function getFastestRoute($routes){
    usort($routes,'TimeAscSort');
    return $routes[0];
}


function TimeAscSort($item1,$item2)
{
    if (ltrim($item1['duration']['h'],0) == $item2['duration']['h']) return 0;
    return ($item1['duration']['h'] > $item2['duration']['h']) ? 1 : -1;
}


/*
 * 
 * Function to Get Routes Data b/w source and destination 
 * 
 */
function createRouteArray($arrayRoute){
	
	$directRoutesArray = array();
	$trackRouteArray = array();
	global $departure, $jdata, $trackRouteArray, $trackRouteDataArray, $sortRoute, $aCity; 
	
	$trackRouteArray[] = $arrayRoute[0]['departure'];

	foreach($arrayRoute as $ke => $val){
		if($val['arrival'] == $aCity){
			$directRoutesArray[$val['arrival']][] = $val; 
		}
		else{
			$trackRouteDataArray[$val['arrival']][] = $val; 
		}
	}	

	if(count($directRoutesArray) == 0){ 
		foreach($arrayRoute as $k1 => $v1){	
			foreach($jdata['deals'] as $key => $value){  
				if($v1['arrival'] == $value['departure']){
					$directRoutesArray[$v1['arrival']][] =  $value;
				}
			}
			createRouteArray($directRoutesArray[$v1['arrival']]);exit;
		}
	}
 
	$trackRouteDataArray[array_keys($directRoutesArray)[0]] = $directRoutesArray[$aCity];
	$trackRouteArray[] = $aCity;

	$output = Array();
	for($i = 1; $i < count($trackRouteArray); $i++){
		if(trim($sortRoute) == 'Cheapest'){
			$endArray = Array();
			foreach($trackRouteDataArray[$trackRouteArray[$i]] as $ky => $vl){
				if($vl['departure']== $trackRouteArray[$i-1]){
					$endArray[] = $vl;
				} 
			} 
		   $output[] = getCheapestRoute($endArray);  
		}
		
		if(trim($sortRoute) == 'Fastest'){
			$endArray = Array();
			foreach($trackRouteDataArray[$trackRouteArray[$i]] as $ky => $vl){
				if($vl['departure']== $trackRouteArray[$i-1]){
					$endArray[] = $vl;
				} 
			} 
		    $output[] = getFastestRoute($endArray);  
		}	
	}
	showRouteOutput($output);
	
}


/*
 * 
 * Function to display Routes on the frontend
 * 
 */
function showRouteOutput($output){
	
	global $jdata;
	$totalCost = 0 ;
	$totalTime = 0 ;
	
	$htmlOutput = "<ul>";
	
	foreach($output as $oKey => $oVal){
		$htmlOutput .= '<li>';
		$htmlOutput .= "<span>".$oVal['departure']." > ".$oVal['arrival']."<ins> ".$oVal['transport']." ".$oVal['reference']." for ".$oVal['duration']['h']."h".$oVal['duration']['m']."m </ins></span><span>".$oVal['cost']." ".$jdata['currency']."</span>";
		$htmlOutput .= '</li>';
		$totalCost = $totalCost + $oVal['cost'];
		$totalTime = $totalTime + $oVal['duration']['h'] * 3600 + $oVal['duration']['m'] * 60;
	}
	

	$hours = floor($totalTime/3600); // Calculate Total Hours
	$totalTime -= $hours*3600;	
	$minutes  = floor($totalTime/60); // Calculate Total Minutes
	
	$htmlOutput .= "<li>
				<span>
					Total <b>".$hours."h".$minutes."m"."</b>
				</span>
				<span>".$totalCost." ".$jdata['currency']."</span>
			</li>";
	$htmlOutput .= "</ul>";
	
	echo $htmlOutput ; //output for frontend 
	
}
