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

    /*
    echo $api_url;
    echo "<pre>";
    var_dump($xml);
    echo "</pre>";
    */

    $csv = generateCSV($xml, $api_url_accept); 

    if($csv !== null){
		writeCsv($csv, $csvPath);		
    }
    else{
	    echo "No new orders!";
    }
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
function generateCSV($xml, $api_url_accept){
    
    $csv = "";

    //TODO: Multiple products
    //TODO: Time management
    //TODO: Accept orders?


    foreach($xml->datas[0]->order as $orderline){
        /* echo "<pre>";
        var_dump($orderline);
        echo "</pre>"; */

        foreach($orderline->products->product as $productline){
            $csv = $csv . $orderline->order_ref . ";";
            $csv = $csv . $orderline->order_time . ";";
            $csv = $csv . $orderline->billing_address->email . ";";
            $csv = $csv . $productline->sku . ";";
            $csv = $csv . $productline->quantity . ";";
            $csv = $csv . $productline->price . ";";
            $csv = $csv . $orderline->shipping_address->firstname . " " . $orderline->shipping_address->lastname . ";";
            $csv = $csv . $orderline->shipping_address->company . ";";
            $csv = $csv . $orderline->shipping_address->address_1 . ";";
            $csv = $csv . $orderline->shipping_address->zipcode . ";";
            $csv = $csv . $orderline->shipping_address->city . ";";
            $csv = $csv . $orderline->shipping_address->country_iso . ";";
            $csv = $csv . $orderline->billing_address->firstname . " " . $orderline->billing_address->lastname . ";";
            $csv = $csv . $orderline->billing_address->company . ";";
            $csv = $csv . $orderline->billing_address->address_1 . ";";
            $csv = $csv . $orderline->billing_address->zipcode . ";";
            $csv = $csv . $orderline->billing_address->city . ";";
            $csv = $csv . $orderline->billing_address->country_iso . ";";
            $csv = $csv . $orderline->billing_address->phone . ";";
            $csv = $csv . $orderline->payment_solution . ";";
            $csv = $csv . $orderline->shipping_price;
            $csv = $csv . "\r\n";
        }

        $api_url = str_replace("%ORDERREF%", $orderline->order_ref, $api_url_accept);
        $xml_src = file_get_contents($api_url);      
    }

    echo $csv;
    
    if($csv !== ""){
        $csv = generateCSVHeadline().$csv;
        return $csv;
    }
    
    
    return null;
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
            . "Phone;PaymentType;Shipping" . "\r\n";
    return $csv_headline;
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
