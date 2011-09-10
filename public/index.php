<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Locator</title>
    <link media="all" href="css/styles.css" type="text/css" rel="stylesheet" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/locator.js"></script>
</head>
<body>
<div class="wrapper">

    <div>
        Locator (used in a much prettier way at <a href="http://www.montanasilversmiths.com/store-locator" title="Montana Silversmiths">http://www.montanasilversmiths.com/store-locator</a>)
    </div>
    
    <div id="locatorSearchFormContainer">
        <form id="locatorSearchForm" onsubmit="locate();return false">
            <input id="zip" type="text" value="Enter Zip Code" name="zip" onclick="this.value='';document.getElementById('city').value='';" />
            <input id="city" type="text" value="Or Enter City" onclick="this.value='';document.getElementById('zip').value='';" />
            <select id="state" name="state"> <option selected="selected">State</option> <option value="AL">Alabama</option> <option value="AK">Alaska</option> <option value="AZ">Arizona</option> <option value="AR">Arkansas</option> <option value="CA">California</option> <option value="CO">Colorado</option> <option value="CT">Connecticut</option> <option value="DE">Delaware</option> <option value="DC">District Of Columbia</option> <option value="FL">Florida</option> <option value="GA">Georgia</option> <option value="HI">Hawaii</option> <option value="ID">Idaho</option> <option value="IL">Illinois</option> <option value="IN">Indiana</option> <option value="IA">Iowa</option> <option value="KS">Kansas</option> <option value="KY">Kentucky</option> <option value="LA">Louisiana</option> <option value="ME">Maine</option> <option value="MD">Maryland</option> <option value="MA">Massachusetts</option> <option value="MI">Michigan</option> <option value="MN">Minnesota</option> <option value="MS">Mississippi</option> <option value="MO">Missouri</option> <option value="MT">Montana</option> <option value="NE">Nebraska</option> <option value="NV">Nevada</option> <option value="NH">New Hampshire</option> <option value="NJ">New Jersey</option> <option value="NM">New Mexico</option> <option value="NY">New York</option> <option value="NC">North Carolina</option> <option value="ND">North Dakota</option> <option value="OH">Ohio</option> <option value="OK">Oklahoma</option> <option value="OR">Oregon</option> <option value="PA">Pennsylvania</option> <option value="RI">Rhode Island</option> <option value="SC">South Carolina</option> <option value="SD">South Dakota</option> <option value="TN">Tennessee</option> <option value="TX">Texas</option> <option value="UT">Utah</option> <option value="VT">Vermont</option> <option value="VA">Virginia</option> <option value="WA">Washington</option> <option value="WV">West Virginia</option> <option value="WI">Wisconsin</option> <option value="WY">Wyoming</option> </select>
            <select id="distance" name="distance">
                <option value="5">5 miles</option>
                <option value="10" selected>10 miles</option>
                <option value="25">25 miles</option>
                <option value="50">50 miles</option>
                <option value="75">75 miles</option>
                <option value="100">100 miles</option>
            </select>
            <input id="page_no" type="hidden" value="1" />
            <button id="submitButton" onclick="locate();">Search</button>
            
        </form>
    </div>
    
    <div id="locatorResultsContainer">
        <span>Enter your location</span>
    </div>
</div>
</body>
</html>