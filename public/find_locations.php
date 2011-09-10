<?php
/**
 * find_locations.php
 * 
 * Return a set of locations from the database as JSON
 * @author Andrew L Joseph
 */

require_once("../lib/locator.php");

$l = new Locator();

if (!isset($_REQUEST["page"])){
    $offset = 0;
}else{
    $offset = ($_REQUEST["page"] - 1) * 8;
}

if ( !isset($_REQUEST["distance"]) ) {
    die("bad request: no distance specified");
}

$distance = intval($_REQUEST["distance"]);
if (!is_int($distance) || $distance < 0 || $distance > MAX_DISTANCE_MILES) {
    $distance = 10; // make sure distance is appropriate
}

if (isset($_REQUEST["zip"]) && $_REQUEST['zip'] != "") {
    $zip = intval($_REQUEST["zip"]);
    if (!is_int($zip)) {
        die("bad request: zip code not valid");
    }
    $results = $l->search($zip, $distance,$offset);
} else if (isset($_REQUEST["city"]) && isset($_REQUEST["state"]))  {
    $results = $l->search(Array(
        'city'      => $_REQUEST["city"],
        'state'      => $_REQUEST["state"]
    ), $distance,$offset);
} else die("bad request");


header("Content-Type: application/json");
echo json_encode($results); die;

