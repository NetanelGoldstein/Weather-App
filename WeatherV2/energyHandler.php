<html>
    <head>
        <title>Weather Results</title>
    </head>
    <body>
    <?php include 'header.php';?>   
    <div id="energy-results-block" class="results-block"> 
     <div class="content-block-head">
                <h2>Jump in.</h2>
                <p>Here are the results of your query</p>
            </div> 
    <?php
    
            //var_dump($_POST);
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            $state = $_POST['state'];
        $url = "https://api.eia.gov/v2/electricity/retail-sales/data?api_key=cFoWNOgDgPaMkji90E91eVYIqLBuw78A9ORPbvgs&data[]=sales&facets[sectorid][]=RES&facets[stateid][]=".$state."&frequency=monthly&start=".$startDate."&end=".$endDate."&sort[0][column]=period&sort[0][direction]=asc";
       //echo $url;


    // this disables the ssl in a really insecure way to avoid ssl issues
        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
                ),
        );
        
        $data = file_get_contents($url,false,stream_context_create($arrContextOptions));
        //echo $data;
        $data = json_decode($data,true);
        $numOfMonthsQueried = $data["response"]["total"];
        if($numOfMonthsQueried > 0){
            //echo "<br>months queried: " . $numOfMonthsQueried;
            echo "<table id=\"results-table\"><caption>Energy Consumption per Month</caption><tr><th>State</th><th>YYYY-MM</th><th>Electricity Sales - Million KW hrs </th></tr>";
            for($i = 0; $i < $numOfMonthsQueried; $i++){
                echo"<tr><td>$state</td><td>" .  $data['response']['data'][$i]['period'] ."</td><td>" . $data['response']['data'][$i]['sales'] ."</td></tr>";
            }
        }
        else{
            echo "<div class=\"content-block\"><p>There is no information available for that query. Try a different one. Different states update data at different times </p></div>";
        }
        //$data = json_encode($data, JSON_PRETTY_PRINT);
        //echo "<pre>".$data."</pre>";

    ?>
    </div>
    </body>
</html>