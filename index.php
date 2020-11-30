<?php

require_once 'settings.php';

/* 
 * Check, if the csv exists.
 * If it doesn't exist: Download recent xml from the rakuten api
 * and parse it to csv. 
*/
if(!file_exists($csvPath)){
    $xml_src = file_get_contents($api_url);
    //$xml_src = file_get_contents("test.xml");
    $xml = simplexml_load_string($xml_src, null, LIBXML_NOCDATA);

    echo $api_url;
    echo "<pre>";
    var_dump($xml);
    echo "</pre>";

    $csv = generateCSV($xml, $lastDate); 

    if($csv !== null){
		writeCsv($csv, $csvPath);		
    }
    else{
	    echo "No new orders!";
    }
    writeDate($datePath);
}
else{
	echo "CSV file was not processed yet!";
}






/*
 * Generates the csv-content from a xml-file.
 * 
 * @param string    $xml    The xml you want to parse to csv.
 * @return string   $csv    The parsed csv. 
*/
function generateCSV($xml, $lastDate){
    
    $csv = null;
    
    
    if($csv !== null){
	    $csv = generateCSVHeadline().$csv;
    }
    
    
    return $csv;
}

/*
 * Generates the headline of the csv file.
 * 
 * @return string   $csv_headline    The headline for the csv file.
*/
function generateCSVHeadline(){
    $csv_headline = ""
            . "OrderNumber;OrderDate;EMail;"
            . "ArticleNumber;ArticleQuantity;ArticlePrice;"
            . "DeliveryClient;DeliveryClient2;DeliveryStreet;"
            . "DeliveryZIP;DeliveryCity;DeliveryCountry;"
            . "InvoiceClient;InvoiceClient2;InvoiceStreet;"
            . "InvoiceZIP;InvoiceCity;InvoiceCountry;"
            . "Phone;PaymentType;Shipping";
    return $csv_headline;
}

/*
 * Writes the current DateTime to a file.
*/
function writeDate($datePath){
    $date = new DateTime();
    
    $fp = fopen($datePath, 'w');
    fwrite($fp, $date->format('Y-m-d H:i:s'));
    fclose($fp);
}

/*
 * Creates a csv file from a string.
 * 
 * @input string    $csv    Csv content, that should be written to a file
*/
function writeCsv($csv, $csvPath){
    echo $csv;
    
    $fp = fopen($csvPath, 'w');
    fwrite($fp, $csv);
    fclose($fp);
}
