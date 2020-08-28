<?php

$receivedcert = ($_POST["cert"]); //extracts the cert from the POST request and stores it

$parsedcert = openssl_x509_parse($receivedcert, false); //parses the cert into an array

// use these below to explore the structure of the array
//print_r(array_values($parsedcert));
//print_r(array_keys($parsedcert));

//extract just the info we want from the array based on current SSL hopper values 

$comName = ($parsedcert['subject']['commonName']);
$altName = ($parsedcert['extensions']['subjectAltName']);
$orgName = ($parsedcert['subject']['organizationName']);
$orgLocality = ($parsedcert['subject']['localityName']);
$orgState = ($parsedcert['subject']['stateOrProvinceName']);
$orgCountry = ($parsedcert['subject']['countryName']);
$validFrom = ($parsedcert['validFrom_time_t']);
$validTo = ($parsedcert['validTo_time_t']);
$issuer = ($parsedcert['issuer']['commonName'].", ".$parsedcert['issuer']['organizationName']);
$serialNumber = ($parsedcert['serialNumberHex']);

//convert the data into a JSON file to be parsed client side

//the str_replace removes the "dns" from the SAN to match SSL hopper

$certAsJson = array('Common Name'=>$comName, 'Subject Alternative Name' => str_replace("DNS:","",$altName), "Organization" => $orgName, "Locality" => $orgLocality, "State" => $orgState, "Country" => $orgCountry, "Valid From" => date('F d, Y', $validFrom), "Valid To" => date('F d, Y',$validTo), "Issuer" => $issuer, "Serial Number"=> $serialNumber);

//return the data to the client
echo json_encode($certAsJson);

// KEY VALUES available are below
//(
//     [0] => name
//     [1] => subject
//     [2] => hash
//     [3] => issuer
//     [4] => version
//     [5] => serialNumber
//     [6] => serialNumberHex
//     [7] => validFrom
//     [8] => validTo
//     [9] => validFrom_time_t
//     [10] => validTo_time_t
//     [11] => signatureTypeSN
//     [12] => signatureTypeLN
//     [13] => signatureTypeNID
//     [14] => purposes
//     [15] => extensions
?>