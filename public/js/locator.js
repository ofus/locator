function locate(page){
    var page = typeof(page) != 'undefined' ? page : document.getElementById('page_no').value;
    document.getElementById('page_no').value = page;
    var zip = document.getElementById('zip').value;
    var distance = document.getElementById('distance').value;
    var city = document.getElementById('city').value;
    var state = document.getElementById('state').value;
    
    zip = (zip == "Enter ZIP code")? "" : zip;
    city = (city == "Or Enter City")? "" : city;
    state = (state == "State")? "" : state; 
	
    if (zip != ""){
        showing = zip;
    } else {
        showing = city + ", " + state;
    }
	
	if ((zip == "" && city == "") || (city !="" && state == "" && zip == "") ){
        document.getElementById('locatorResultsContainer').innerHTML = "<span class=\"results_message\">Please enter either a Zip Code or a City and/or state to locate a store near you.</span>";
        return false;
    }

/* 8 results per page */

    jQuery.getJSON(
        "find_locations.php",
        { zip: zip, distance: distance, city: city, state: state, page: page},
        function(data){
            
            msg = data[0];
            var out = "", numResults = 0;
            jQuery.each(msg, function(i, val) {
                out += formatLocation(val);
                numResults++;
                jQuery.each(val, function(i2, val2) {
                });
                out += "\n\n";
            });
            
            var str = "<h2>Showing " + numResults + ' of ' + data[2] 
                + " results for <span>" + showing + "</span></h2>\n<ul>" 
                + out + "</ul>";             
            
            document.getElementById('locatorResultsContainer').innerHTML = out;
            document.getElementById('locatorResultsContainer').innerHTML += paginator(page,data[1]);
        }
    );
}

function paginator(page,total_pages){
    var out = "";
    out += "<div id=\"results_pager\">Pages:<br /><ul>\n";

    for (i=1; i<= total_pages; i++){
        out += '<li><a href="javascript:void(0)" onclick="locate(' + i + ')">' + i + "</a></li>\n";
    }

    out +="</ul></div>";
    return out;
}

function formatLocation(data) {
    var glink = "http://maps.google.com/?q=" + data.address + " " + data.city;
	
    var str = "<li class='locationListing'>\n";
    str += "<span class='locationListing locationName'>" + data.name + "</span><br />\n";
    str += "<span class='locationListing locationLoc'><a class='button' href='"+ glink +"' title='View Map' target='googlemaps'>View Map</a></span><br />\n";
    if (data.address) {
		str += "<span class='locationListing locationInfo'>" + data.address + "</span><br />\n";
	} else { str += "<span class='locationListing locationInfo' /><br />\n"; }
    if (data.city) {
		str += "<span class='locationListing locationInfo'>" + data.city + "</span><br />\n";
	} else { str += "<span class='locationListing locationInfo' /><br />\n"; }
	if (data.phone)	{
		    str += "<span class='locationListing locationInfo'>" + data.phone + "</span><br />\n";
	} else { str += "<span class='locationListing locationInfo' /><br />\n"; }
	if (data.country) {
      str += "<span class='locationListing locationInfo'>Country:&nbsp;" + data.country + "</span><br />\n";
	} else if (data.distance == 0){
      str += "<span class='locationListing locationInfo'>Located in your  Zip Code.</span><br />\n";
    }else{
      str += "<span class='locationListing locationInfo'>Distance:&nbsp;" + data.distance + "&nbsp;miles away</span><br />\n";
    }
    str += "</li>";
    
    return str;
}
