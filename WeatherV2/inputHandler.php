<html>
    <head>
        <title>Weather Results</title>
    </head>
    <body>
    <?php include 'header.php';?>    
    <div  class="results-block">
    <?php
    //var_dump($_POST);
     /*
      This script was originally configured to need the following variables:
        1.$startDate = $_POST['startDate'];
        2.$endDate = $_POST['endDate'] != ""? $_POST['endDate']: $startDate;
        3.$endYear = $_POST['endYear'];
          $endYear = $endYear == "" ? $startDateYear: $endYear;
          The variables received in the $_POST have to be configured to fill these values
     */
    
            $_POST['startMonth'] = isset($_POST['startMonth']) ? $_POST['startMonth'] : "999" ;
            $_POST['endMonth'] = isset($_POST['endMonth']) ? $_POST['endMonth'] : "999" ;
            $_POST['startDay'] = isset($_POST['startDay']) ? $_POST['startDay'] : "999" ;
            $_POST['endDay'] = isset($_POST['endDay']) ? $_POST['endDay'] : "999" ;
            $_POST['startYear'] = isset($_POST['startYear']) ? $_POST['startYear'] : "999" ;
            $_POST['endYear'] = isset($_POST['endYear']) ? $_POST['endYear'] : "999" ;

            
       if ($_POST['formName']=="singleDateForm") {
            $startDate = $_POST['startDate'];
            $endDate = $startDate;
            $endYear = subStr($startDate, 0,4);
       }
       else if ($_POST['formName'] == "dateRangeForm"){
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'] != ""? $_POST['endDate']: $startDate;
            $endYear = subStr($startDate, 0,4);
       }
       else {
           
        // convert startMonth from text to number
            switch($_POST['startMonth']){
                case "January":
                    $startMonth = "01";
                    break;
                case "February":
                    $startMonth = "02";
                    break;
                case "March":
                    $startMonth = "03";
                    break;
                case "April":
                    $startMonth = "04";
                    break;
                case "May":
                    $startMonth = "05";
                    break;
                case "June":
                    $startMonth = "06";
                    break;
                case "July":
                    $startMonth = "07";
                    break;
                case "August":
                    $startMonth = "08";
                    break;
                case "September":
                    $startMonth = "09";
                    break;
                case "October":
                    $startMonth = "10";
                    break;
                  case "November":
                    $startMonth = "11";
                    break;                   
                case "December":
                    $startMonth = "12";
                    break;
                default:
                    $startMonth = "01";
                
            }
// convert endMonth from text to number
            switch($_POST['endMonth']){
                case "January":
                    $endMonth = "01";
                    break;
                case "February":
                    $endMonth = "02";
                    break;
                case "March":
                    $endMonth = "03";
                    break;
                case "April":
                    $endMonth = "04";
                    break;
                case "May":
                    $endMonth = "05";
                    break;
                case "June":
                    $endMonth = "06";
                    break;
                case "July":
                    $endMonth = "07";
                    break;
                case "August":
                    $endMonth = "08";
                    break;
                case "September":
                    $endMonth = "09";
                    break;
                case "October":
                    $endMonth = "10";
                    break;
                  case "November":
                    $endMonth = "11";
                    break;                   
                case "December":
                    $endMonth = "12";
                    break;
                default:
                    $endMonth = "01";
                
            }
            
            // if necessary, add 0 to startDay and endDay
            $startDay = $_POST['startDay'] < 10 ? "0" . $_POST['startDay'] : $_POST['startDay']; 
            $endDay = $_POST['endDay'] < 10 ? "0" . $_POST['endDay'] : $_POST['endDay'];
            // echo "<br> " . $startDay;
            
            $startDate = $_POST['startYear'] . "-" .$startMonth. "-" . $startDay;
           // echo "<br> " . $startDate;
            // Let's determine if it spanned two years, like from December through January
            $endDate = $endMonth >= $startMonth ? $_POST['startYear'] ."-".$endMonth."-".$endDay : ($_POST['startYear'] + 1 ) ."-".$endMonth."-".$endDay  ;
            $endYear = $_POST['endYear'];
       
       
        }

      // echo $startDate;






    // $startDate = $_POST['startDate'];
    // $endDate = $_POST['endDate'] != ""? $_POST['endDate']: $startDate;
    // The previous values may be incremented as part of the looping process
    // let's save a copy of them to record in the database
    $originalStartDate = $startDate;
    $originalEndDate = $endDate;

    $startDateDay = subStr($startDate,-5,5);
    $startDateYear = substr($startDate,0,4);
    
    // If the user wants ranges from multiple years, we'd better set up those dates
    $endDateYear = substr($endDate,0,4);
    $zipcode = $_POST['zip'];
    // let's make sure end year has some data, even the same as start year
 //   $endYear = $_POST['endYear'];
 //   $endYear = $endYear == "" ? $startDateYear: $endYear;
    $ip = $_SERVER['REMOTE_ADDR']; 
    // the pdo query option doesn't insert boolean values into the mysql tinyint field,
    // so these have to be converted into 1's for true and 0 for false
    $wind = isset($_POST['wind']) ? 1 : 0;
    $temperature = isset($_POST['temperature']) ? 1 : 0;
    $precipitation = isset($_POST['precipitation']) ? 1 : 0;
   
    /*
    require_once('login.php');
    try{
        $pdo = new PDO($attr, $user, $pass, $opts);
    }
    
    catch(PDOException $e)
    {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
    */

    // Let's create a table to display our data
    // First, we will create a header, which depends on which weather parameters were requested
    // The first has 2 parameters, date and zip
    echo "<table id =\"results-table\" ><caption>Weather Data, Daily</caption><tr><th>Date</th><th>Zip Code</th>";
    if($temperature ==1){
        // temp has 6 params
        echo "<th>Maximum Temp</th> <th>Minimum Temp</th> <th>Temp</th> <th>Feels Like Max</th> <th>Feels Like Min</th> <th>Feels Like</th>";
    }
    if($precipitation == 1){
        // 5 params
        echo "<th>Dew</th> <th>Humidity</th> <th>Precip</th> <th>Snow</th> <th>Snow Depth</th> ";
    }
    if($wind == 1){
        //2 params
        echo "<th>Wind Gust</th> <th>Wind Speed</th>";
    }
    echo "</tr>";
    

    // We will iterate through the date range for all the years in the year range
   //
   // While we do so, we will add the list of dates to an array, so we can record them in our database later
   $dateArray = array();

   
        // this for loop iterates thru the years
    for($years = $startDateYear; $years <= $endYear; ){
        //   echo "debug print start date $startDate end date $endDate";
            
        // let's build a url
        // ever year needs its own url, b/c the url needs that years dates
        if($startDate != "" &&  $endDate != ""){
            $dateRange = $startDate."/".$endDate;
        }
        else{
            $dateRange = $startDate;
        }
       $url =  "https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/" .$zipcode ."/".$dateRange."?unitGroup=us&include=days&key=UPK9GC2444Y8MLVEC5N8L732U&contentType=json";
            //echo $url;
        $json_data = file_get_contents($url);
        // $response_data = json_encode(json_decode($json_data),JSON_PRETTY_PRINT);
        // echo "<pre>".$response_data."</pre>";

        $response_data = json_decode($json_data,true);   
        // iterate thru days   
        for ($i = 0; $i < $response_data['queryCost'];$i++){
                
                // let's build a table row
                $row = "<tr><td>".$response_data['days'][$i]['datetime']."</td> <td>".$zipcode ."</td> ";
                // Let's add the date to our dateArray
                $dateArray[] = $response_data['days'][$i]['datetime'];
                if($temperature == 1){
                    $row .= "<td>". $response_data['days'][$i]['tempmax'] ."</td> <td>". $response_data['days'][$i]['tempmin']. "</td> <td>" . $response_data['days'][$i]['temp'] . "</td> <td>" . $response_data['days'][$i]['feelslikemax'] . "</td> <td>" . $response_data['days'][$i]['feelslikemin'] . "</td> <td>" . $response_data['days'][$i]['feelslike'] . "</td> ";
                }
                if($precipitation == 1){
                    $row .= "<td>". $response_data['days'][$i]['dew'] ."</td> <td> ". $response_data['days'][$i]['humidity'] ."</td> <td> ". $response_data['days'][$i]['precip'] ."</td> <td> ". $response_data['days'][$i]['snow'] ."</td> <td> ". $response_data['days'][$i]['snowdepth'] ."</td> ";
                }
                if($wind ==1){
                    $row .= "<td>" . $response_data['days'][$i]['windgust'] ."</td> <td> ". $response_data['days'][$i]['windspeed'] ."</td>" ;
                }

                $row .= "</tr>";
                echo $row ; 
        }
        

        // increment the years for next iteration
        $years += 1;
        $startDate = substr_replace($startDate,$years,0,4);
    // echo "years $years start date after increment $startDate";
        $newEndYear = substr($endDate,0,4) + 1;
        $endDate = substr_replace($endDate,$newEndYear,0,4);
    // echo $endDate;
}
// close the table
   echo "</table>";

   //update database
// This is a list of field names in requests table
// requestId
//zipcode
//state
//ip
//temp
//wind
//precipitation
//startDate
//endDate
//ts
//startDateStartYear
//startDateEndYear
 /*   $query = "INSERT INTO requests(zipcode,ip,temp,wind,precipitation,startDate,endDate,firstYearOfQuery,LastYearOfQuery) VALUES ('$zipcode','$ip','$temperature','$wind','$precipitation','$originalStartDate','$originalEndDate','$startDateYear','$endYear')";
    $resultId = $pdo->query($query);
    $insertId = $pdo->lastInsertId();
    // This iterates through the queried dates and adds them to the queriedDates table
    foreach($dateArray as $day ){
        //echo $day . $insertId;
    $query = "INSERT INTO datesqueried (dateQueried, requestId) VALUES ('$day', '$insertId')";
    $result = $pdo->query($query);
   
    }
    // let's insert the user data
    // we will track user data with ip-api.org's api
// check the site for documentation
// fake ip to avoid local ip
 $ip = "56.184.182.36";
$url = "http://ip-api.com/json/" .$ip ."?fields=2879487";
//$url = "http://ip-api.com/json/24.184.182.36?fields=2879487";
$ipInfo =file_get_contents($url);
$ipInfo = json_decode($ipInfo,true);
 //$ipInfo = json_encode($ipInfo,JSON_PRETTY_PRINT);
//echo "<pre>".$ipInfo."</pre>";

// echo "<br> ipinfo " . $ipInfo;
//var_dump($ipInfo);

if ($ipInfo['status'] == "success"){
   
    // all variables start with $ip to distinguish them from other variables, such as the query zip, etc
    $ipContinentCode = $ipInfo['continentCode'];
    $ipCountry= $ipInfo['country'];
    $ipCountryCode= $ipInfo['countryCode'];
    $ipRegion= $ipInfo['region'];
    $ipRegionName= $ipInfo['regionName'];
    $ipCity = $ipInfo['city'];
    $ipDistrict= $ipInfo['district'];
    $ipZip= $ipInfo['zip'];
    $ipLat= $ipInfo['lat'];
    $ipLon = $ipInfo['lon'];
    $ipTimezone= $ipInfo['timezone'];
    $ipIsp= $ipInfo['isp'];
    $ipOrg= $ipInfo['org'];
    $ipAs= $ipInfo['as'];
    $ipMobile= isset($ipInfo['mobile']) ? 1 : 0;
    $ipProxy= isset($ipInfo['proxy'])? 1 : 0;


     // This command uses INSERT IGNORE to avoid an error if the ip is already a PK in the ipinfo table
     // IGNORE is a MySql command, it may not integarate with other DB's
    $query = "INSERT  INTO ipinfo (ipAddress,country,countryCode,region,city,zip,lat,lon,timezone,isp,org,asNum,regionName,continentCode,district,mobile,proxy,requestId) VALUES 
                                 ('$ip',  '$ipCountry', '$ipCountryCode', '$ipRegion', '$ipCity', '$ipZip','$ipLat','$ipLon','$ipTimezone','$ipIsp','$ipOrg','$ipAs','$ipRegionName','$ipContinentCode','$ipDistrict','$ipMobile','$ipProxy','$insertId')";
    $result = $pdo->query($query);
}
*/
    
   
     ?>
    </div>
    </body>
</html>