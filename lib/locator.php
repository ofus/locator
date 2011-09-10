<?php
/**
 * 
 * Locator.php
 * 
 * Do geolocation searches
 * 
 * @author Andrew L Joseph
 */

define("MAX_DISTANCE_MILES", 1000);

/*
 * A class to manage geolocation searches for dealer locations
 */
class Locator
{   
    /**
     *
     * @var resource database connection handle
     */
    protected $dbh;

    public function __construct()
    {
        $this->dbh = new mysqli("localhost", "root", "root", "locator");
    }
    
    /**
     * Get locations within distance d of a zip code
     * @param mixed zip code (integer) or array with city, state
     * @param int $distance within this distance
	 * @param int $offset pagination offset number
     * @return array 
     */
    public function search($data, $distance=10,$offset=0)
    {
        if (is_array($data)) {  // city search
            $loc = $this->getGeolocationFromCityState($data['city'], $data['state']);
        } else {    // zip code search
            $loc = $this->getGeolocation($data);
        }
        
        $mylon = $loc["lon"];
        $mylat = $loc["lat"];
        $lon1 = $mylon - $distance / abs(cos(deg2rad($mylat))*69);
        $lon2 = $mylon + $distance / abs(cos(deg2rad($mylat))*69);
        $lat1 = $mylat - ($distance / 69);
        $lat2 = $mylat + ($distance / 69);

        // based on query from
        // http://www.scribd.com/doc/2569355/Geo-Distance-Search-with-MySQL
        $sql = "SELECT dest.*, 3956 * 2 * ASIN(SQRT(POWER(SIN(($mylat - dest.lat) * pi()/180 / 2), 2) + COS($mylat * pi()/180) *COS(dest.lat * pi()/180) * POWER(SIN(($mylon - dest.lon) * pi()/180 / 2), 2)))as distance FROM location dest WHERE dest.lon between $lon1 and $lon2 and dest.lat between $lat1 and $lat2";
        $sql.= " ORDER BY distance ASC";
        $sql.= " LIMIT 8 OFFSET $offset";

	    $count_sql = "SELECT COUNT(dest.cust_no) as cust_count FROM location dest WHERE dest.lon between $lon1 and $lon2 and dest.lat between $lat1 and $lat2";
        $count_res = mysqli_query($this->dbh, $count_sql);
        $row_count = 0;

        while($r = mysqli_fetch_array($count_res)){
            $row_count = $r[0];
        }		

        $total_pages = intval($row_count / 8) + 1;

        $result = mysqli_query($this->dbh, $sql);
        $locations = Array();
        while ($row = mysqli_fetch_array($result)) {
            if ($row["distance"] == 0) {
                    $row["distance"] = "in your zip code";
            }
            $locations[] = Array(
                "name"      => $row["name"],
                "address"   => $row["street_2"],
                "city"      => $row["city"] . " " . $row["state"] . ", " . $row["zip"],
                "phone"     => $row["phone"],
                "distance"  => round($row["distance"], 1)
            );
        };
        return Array($locations, $total_pages,$row_count);
    }

   
    /**
     * get geolocation for a zip code
     * @param int $zip
     * @return array lat, lon array
     */
    public function getGeolocation($zip)
    {
        $this->sanitize($zip);
        $sql = "SELECT lat, lon FROM zip_codes WHERE zip=$zip";
        $result = mysqli_query($this->dbh, $sql); //$this->dbh->query($sql);
        $row = mysqli_fetch_row($result);
        mysqli_free_result($result);
        return Array("lat" => $row[0], "lon" => $row[1]);
    }
    
    /**
     * get geolocation for a city & state combo
     * @param string $city
     * @param string $state
     * @return array lat, lon array
     */
    public function getGeolocationFromCityState($city, $state)
    {
        $this->sanitize($city);
        $this->sanitize($state);
        $city = str_replace('\'', '', $city);
        $sql = "SELECT lat, lon FROM zip_codes WHERE city='$city' AND state='$state'";
        $result = mysqli_query($this->dbh, $sql);
        $row = mysqli_fetch_row($result);
        mysqli_free_result($result);
        return Array("sql" => $sql, "lat" => $row[0], "lon" => $row[1]);       
    }
    
    /**
     * escape bad chars to avoid sql injection etc
     * @param string $data data to sanitize
     */
    public function sanitize(&$data)
    {
        $data = mysqli_real_escape_string($this->dbh, $data);
    }
}

