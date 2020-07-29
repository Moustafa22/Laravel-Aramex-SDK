<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Octw\Aramex\Aramex;

class TestController extends Controller
{
    public function testRoute(){

        //  Creating shipmets requires pickups so we create pickups and save it's Guid to pass it to shipment creation method 

    	$data = Aramex::createPickup([
    		'name' => 'MyName',
    		'cell_phone' => '+123123123',
    		'phone' => '+123123123',
    		'email' => 'myEmail@gmail.com',
    		'city' => 'New York',
    		'country_code' => 'US',
            'zip_code'=> 99501,
    		'line1' => 'The line1 Details',
            'line2' => 'The line2 Details',
    		'line3' => 'The line2 Details',
    		'pickup_date' => time() + 45000,
    		'ready_time' => time()  + 43000,
    		'last_pickup_time' => time() +  45000,
    		'closing_time' => time()  + 45000,
    		'status' => 'Ready', 
    		'pickup_location' => 'some location',
    		'weight' => 123,
    		'volume' => 1
    	]);

        // extracting GUID
    	$guid = $data->pickupGUID;

        print_r(json_encode($data, JSON_PRETTY_PRINT));
        

        // For cancel Pickups

        // $anotherData = Aramex::cancelPickup($guid , 'Hello Aramex');

        // Shipment Creation method

        $anotherData = Aramex::createShipment([
            'shipper' => [
                'name' => 'Steve',
                'email' => 'email@users.companies',
                'phone'      => '+123456789982',
                'cell_phone' => '+321654987789',
                'country_code' => 'US',
                'city' => 'New York',
                'zip_code' => 10001,
                'line1' => 'Line1 Details',
                'line2' => 'Line2 Details',
                'line3' => 'Line3 Details',
            ],
            'consignee' => [
                'name' => 'Steve',
                'email' => 'email@users.companies',
                'phone'      => '+123456789982',
                'cell_phone' => '+321654987789',
                'country_code' => 'US',
                'city' => 'New York',
                'zip_code' => 32160,
                'line1' => 'Line1 Details',
                'line2' => 'Line2 Details',
                'line3' => 'Line3 Details',
            ],
            'shipping_date_time' => time() + 50000,
            'due_date' => time() + 60000,
            'comments' => 'No Comment',
            'pickup_location' => 'at reception',
            'pickup_guid' => $guid,
            'weight' => 1,
            'number_of_pieces' => 1,
            'description' => 'Goods Description, like Boxes of flowers',
        ]);


        print_r(json_encode($anotherData, JSON_PRETTY_PRINT));




        // Calculate Rate
        $originAddress = [
            'line_1' => 'Test string',
            'city' => 'Amman',
            'country_code' => 'JO'
        ];

        $destinationAddress = [
            'line_1' => 's',
            'city' => 'Dubai',
            'country_code' => 'AE'
            
        ];
        $shipmentDetails = [
            'weight' => 5, // KG
            'number_of_pieces' => 2,
            'payment_type' => 'P', // if u don't pass it, it will take the config default value 
            'product_group' => 'EXP', // if u don't pass it, it will take the config default value
            'product_type' => 'PPX', // if u don't pass it, it will take the config default value
        ];

        $shipmentDetails = [
            'weight' => 5, // KG
            'number_of_pieces' => 2,
        ]
        $currency = 'USD';
        $data = Aramex::calculateRate($originAddress, $destinationAddress , $shipmentDetails , 'USD');

        print(json_encode($data , JSON_PRETTY_PRINT));
    }
}
