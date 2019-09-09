# Aramex-PHP-SDK

Aramex open source Laravel SDK to integrate with Aramex API's.

## Installation 

``` bash
composer require octw/aramex
```

## Configurations

  After install the package you should publish the package in your project, 
  then it will create `config/aramex.php` file open it  and set your CientInfo and set other params depending on you business model. <br /> 
  NOTE: read comments in config file carefully 

## A Brief Documentation

  First you should read the official aramex documentation, understand the flow of their API's and parameters and decide the main puroposes of using aramex API.<br />
  doucmentation link: https://www.aramex.com/docs/default-source/resourses/resourcesdata/shipping-services-api-manual.pdf
  
  However, The integration has 2 main functions:<br />
      - Create Pickup.<br />
      - Create Shipment.<br />
     
  
  
### Create Pickup Method

  takes array of parameters
  
    ```
    "name" => 'John' // User’s Name, Sent By or in the case of the consignee, to the Attention of.
    "cell_phone" => '+123456789' // Phone Number
    "phone" => '+123456789' // Phone Number
    "email" => 'email@domain.com'
    "country_code" => 'US' // ISO 3166-1 Alpha-2 Code
    "city" => 'New York' // City Name
    "zip_code" => 321654 // Postal Code
    "line1" => 'Line 1 Details'
    "line2" => 'Line 2 Details'
    "line3" => 'Line 3 Details'
    "pickup_date" => time() // time parameter describe the date of the pickup
    "ready_time" => time() // time parameter describe the ready pickup date
    "last_pickup_time" => time() // time parameter
    "closing_time" => time() // time parameter
    "status" => 'Ready' // or Pending
    "pickup_location" => 'at company's reception' // location details
    "weight" => 12 // wieght of the pickup (in KG)
    "volume" => 80 // volume of the pickup  (in CM^3)
    
     return stdClass :  
     {
      "error": 0,
      "pickupGUID": "4e29b471-0ed8-4ba8-ac0e-fddedfb6beec",
      "pickupID": "H310146"
     }
     in case of error
     {
      "error": 1,
      "errors": [
        // Aramex's response errors
      ]
     }
      
      
    Sample Code :
    
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
       if (!$data->error)
          $guid = $data->pickupGUID;
    ```
    
    
### Create Shipment Method

  takes array of parameters
  ```php
            'shipper' => [
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
            'shipping_date_time' => time() + 50000, // shipping date
            'due_date' => time() + 60000,  // due date of the shipment
            'comments' => 'No Comment', // ,comments
            'pickup_location' => 'at reception', // location as pickup
            'pickup_guid' => $guid, // GUID taken from createPickup method
            'weight' => 1, // weight
            'number_of_pieces' => 1,  // number of boxes
            'description' => 'Goods Description, like Boxes of flowers', // description
```
    retrun stdClass:
    {
      "Transaction": {
          "Reference1": "",
          "Reference2": "",
          "Reference3": "",
          "Reference4": "",
          "Reference5": null
      },
      "Notifications": {},
      "HasErrors": false,
      "Shipments": {
          "ProcessedShipment": {
              "ID": "0",
              "Reference1": null,
              "Reference2": null,
              "Reference3": null,
              "ForeignHAWB": null,
              "HasErrors": false,
              "Notifications": {},
              "ShipmentLabel": null,
              "ShipmentDetails": {
                  "Origin": "AMM",
                  "Destination": "AMM",
                  "ChargeableWeight": {
                      "Unit": "KG",
                      "Value": 1
                  },
                  "DescriptionOfGoods": "Hello World",
                  "GoodsOriginCountry": null,
                  "NumberOfPieces": 1,
                  "ProductGroup": "EXP",
                  "ProductType": "EPX",
                  "PaymentType": "P",
                  "PaymentOptions": null,
                  "CustomsValueAmount": {
                      "CurrencyCode": "USD",
                      "Value": 0
                  },
                  "CashOnDeliveryAmount": {
                      "CurrencyCode": "USD",
                      "Value": 0
                  },
                  "InsuranceAmount": {
                      "CurrencyCode": "USD",
                      "Value": 0
                  },
                  "CashAdditionalAmount": {
                      "CurrencyCode": "USD",
                      "Value": 0
                  },
                  "CollectAmount": {
                      "CurrencyCode": "USD",
                      "Value": 0
                  },
                  "Services": null
              },
              "ShipmentAttachments": {
                  "ProcessedShipmentAttachment": {
                      "Name": "CommercialInvoice_6048abe44a664c3cb7ce9f7d47879115.pdf",
                      "Type": "CommercialInvoice",
                      "Url": "http://www.dev.aramex.net/content/rpt_cache/CommercialInvoice_6048abe44a664c3cb7ce9f7d47879115.pdf"
                  }
              },
              "ShipmentThirdPartyProcessedObject": null
          }
      }}
  Sample Code
   
    
    
```php  
        $anotherData = Aramex::createShipment([
            'shipper' => [
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
```
MIT Licence 

Copyright 2019 Octopus-Works

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
