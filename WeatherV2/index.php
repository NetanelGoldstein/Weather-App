
<html>
    <head>
        <charset="utf-8">
        <!-- the following 2 links are to 2 different themes. Do not use them together.-->
        <!--<link href="css\style-image.css" rel="stylesheet">  -->
        <link href="css\style-green.css" rel="stylesheet">
            <title> Weather Data</title>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div id="input-form-block" class="content-block">
            <div class="content-block-head">
                <h2>Jump in.</h2>
                <p>Your weather data is seconds away</p>
            </div> 
            <div class="input-form-block">

    <input type="radio" name="querySelector" id="singleDateSelector" checked>
    <input type="radio" name="querySelector" id="dateRangeSelector">
    <input type ="radio" name="querySelector" id="multiYearSelector">
    <div class="input-form-tab-bar" >
        <label for="singleDateSelector" class="querySelectorTabs">Single Date</label>
        <label for="dateRangeSelector" class="querySelectorTabs">Date Range</label>
        <label for="multiYearSelector" class="querySelectorTabs">Multi-Year</label>
    </div>
    <!-- There are 3 forms for 3 possible queries. Only the checked tab will display.
        Each form has hidden form prefilled with its title so the php can identify which form was submitted -->
    <!-- instructions and inputs for Single Date Query -->
    <form action="inputHandler.php" method="post" class="inputForm" id="singleDateForm">
        <div class="input-form-text">
            <input type="hidden"  name="formName" value="singleDateForm">
            <p><label>Date: <input type="date" name="startDate" required></label> </p>
            <p><label> Zipcode: <input type="text" name="zip" maxlength="5" minlength="5" required></label></p>
        </div>
        <div class="input-form-buttons">
            <p><input type="checkbox" name="temperature"  value="true"> Temperature </p>
            <p><input type="checkbox" name="precipitation" value="true"> Precipitation </p> 
            <p><input type="checkbox" name="wind" value="true"> Wind</p> 
        </div>
        <input type="submit">
    </form>

    <!-- instructions and inputs for Date Range Query -->
    <form action="inputHandler.php" method="post" class="inputForm" id="dateRangeForm">
        <div class="input-form-text">
            <input type="hidden" name="formName" value="dateRangeForm">
            <p><label>Start Date: <input type="date" name="startDate" required></label> </p>
            <p><label>End Date:<input type="date" name="endDate" required></label> </p>
            <p><label> Zipcode:<input type="text" name="zip" maxlength="5" minlength="5" required></label></p>
        </div>
        <div class="input-form-buttons">
            <p><input type="checkbox" name="temperature"  value="true"> Temperature </p>
            <p><input type="checkbox" name="precipitation" value="true"> Precipitation </p> 
            <p><input type="checkbox" name="wind" value="true"> Wind</p> 
        </div>
        <input type="submit">
    </form>

    <!-- Instructions and inputs for Multi-Year Query -->
    <form action="inputHandler.php" method="post" class="inputForm" id="multiYearForm" >
        <div class ="input-form-text">
            <input type="hidden" name="formName" value="multiYearForm">
            <p> Start Date </p>
            <p><label>Month<input list="months" required name="startMonth"></label>
               <label> Day <input type="number" min="1" max="31" name="startDay" required></label></p>

            <p> End Date </p>
            <p><label>Month<input list="months" name="endMonth"></label>
               <label> Day <input type="number" min="1" max="31" name="endDay"></label></p>
            <p>
            <label>Start Year<input type="number" min="1970" max="2050" name="startYear" required></label>
            <label>End Year<input type="number" min="1970" max="2050" name="endYear"></label></p>
            <p><label> Zipcode:<input type="text" name="zip" maxlength="5" minlength="5" required></label></p>
            <div class="input-form-buttons">
            <p><input type="checkbox" name="temperature"  value="true"> Temperature </p>
            <p><input type="checkbox" name="precipitation" value="true"> Precipitation </p> 
            <p><input type="checkbox" name="wind" value="true"> Wind</p> 
        </div>
        
            <datalist id="months">
                <option value="January">
                <option value="February">
                <option value="March">
                <option value="April">
                <option value="May">
                <option value="June">
                <option value="July">
                <option value="August">
                <option value="September">
                <option value="October">
                <option value="November">
                <option value="December">
            </datalist>   
           
        </div>
        <input type="submit"> 
    </form>
</div>
           
            </div>
       
    
        </div>
    </body>
</html>