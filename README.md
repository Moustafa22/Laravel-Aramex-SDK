# Aramex-PHP-SDK
[![Packagist Downloads](https://img.shields.io/packagist/dt/octw/aramex?logo=packagist&logoColor=white) ](https://packagist.org/packages/octw/aramex)
<br/>
Open source Laravel SDK to integrate with Aramex API's.

## Installation 

``` bash
composer require octw/aramex
```

  To publish the package and create config file `aramex.php` run this command
  ``` bash
  php artisan vendor:publish --provider="Octw\Aramex\AramexServiceProvider"
  ```
  
  > Note that this package require `SOAP` extension on your server.<br>
  > Refer to those link for installation <br>
  > [php.net](https://www.php.net/manual/en/soap.installation.php) <br>
  > [digitalocean.com](https://www.digitalocean.com/community/questions/digital-ocean-a-soapclient-installation)

## Configurations

  After install the package you should publish the package in your project, 
  then it will create `config/aramex.php` file open it  and set your CientInfo and set other params depending on you business model. <br /> 
  NOTE: read comments in config file carefully 

## A Brief Documentation

  First you should read the official aramex documentation, understand the flow of their API's and parameters and decide the main puroposes of using aramex API.<br />
  doucmentation link: https://www.aramex.com/docs/default-source/resourses/resourcesdata/shipping-services-api-manual.pdf
  
  You can use the Aramex interface through: <br />
  
  ```php
  use Octw\Aramex\Aramex;
  ```
  or add it to Aliases in config/app.php file <br />
  
  ```php
  'Aramex' => Octw\Aramex\Aramex::class,
  ```
  
  then
  
  ```php
    use Aramex;
  ```
  
  However, The integration has 7 main functions:<br />
      - Create Pickup.<br />
      - Cancel Pickup. <br />
      - Create Shipment.<br />
      - Calculate Rate. <br />
      - Track Shipments. <br />
      - Fetch Countries. <br />
      - Fetch Cities. <br />
      - Validate Address. <br />
     
  
  
### Create Pickup Method

  takes array of parameters
  
``` php
    "name" => 'John' // User’s Name, Sent By or in the case of the consignee, to the Attention of.
    "cell_phone" => '+123456789' // Phone Number
    "phone" => '+123456789' // Phone Number
    "email" => 'email@domain.com'
    "country_code" => 'US' // ISO 3166-1 Alpha-2 Code
    "city" => 'New York' // City Name
    "zip_code" => 10001 // Postal Code
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
```

   return stdClass :  
``` json
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
```
      
   Sample Code :
``` php 
    $data = Aramex::createPickup([
    		'name' => 'MyName',
    		'cell_phone' => '+123123123',
    		'phone' => '+123123123',
    		'email' => 'myEmail@gmail.com',
    		'city' => 'New York',
    		'country_code' => 'US',
            'zip_code'=> 10001,
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
                'zip_code' => 10001,
                'line1' => 'Line1 Details',
                'line2' => 'Line2 Details',
                'line3' => 'Line3 Details',
            ],
            'shipping_date_time' => time() + 50000, // shipping date
            'due_date' => time() + 60000,  // due date of the shipment
            'comments' => 'No Comment', // ,comments
            'pickup_location' => 'at reception', // location as pickup
            'pickup_guid' => $guid, // GUID taken from createPickup method (optional)
            'weight' => 1, // weight
            'goods_country' => null, // optional
            'number_of_pieces' => 1,  // number of items
            'description' => 'Goods Description, like Boxes of flowers', // description
            'reference' => '01020102' // reference to print on shipment report (policy)
            'shipper_reference' => '19191', // optional
            'consignee_reference' => '010101', // optional 
            'services' => 'CODS,FIRST,FRDM, .. ' // ',' seperated string, refer to services in the official documentation
            'cash_on_delivery_amount' => 10.32 // in case of CODS (in USD only "as they want")
            'insurance_amount' => 0, // optional
            'collect_amount' => 0, // optional
            'customs_value_amount' => 0, //optional (required for express shipping)
            'cash_additional_amount' => 0, // optional 
            'cash_additional_amount_description' => 'Something here',
            'product_group' => 'DOM', // or EXP (defined in config file, if you dont pass it will take the config value)
            'product_type' => 'PPX', // refer to the official documentation (defined in config file, if you dont pass it will take the config value)
            'payment_type' => 'P', // P,C, 3 refer to the official documentation (defined in config file, if you dont pass it will take the config value)
            'payment_option' => null, // refer to the official documentation (defined in config file, if you dont pass it will take the config value)
```

   retrun stdClass:
``` json
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
      }
   }
```

  Error Response <br />

```json  
  {
    "error": true,
    "errors": [
      {
        "Code": "Aramex Error Code",
        "Message": "Aramex Error Message"
      },
      {
        "Code": "Aramex Error Code",
        "Message": "Aramex Error Message"
      }
    ]
  }
```
  Sample Code    
    
```php  
        $callResponse = Aramex::createShipment([
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
            // 'pickup_guid' => $guid,
            'weight' => 1,
            'number_of_pieces' => 1,
            'description' => 'Goods Description, like Boxes of flowers',
        ]);
        if (!empty($callResponse->error))
        {
            foreach ($callResponse->errors as $errorObject) {
              handleError($errorObject->Code, $errorObject->Message);
            }
        }
        else {
          // extract your data here, for example
          // $shipmentId = $response->Shipments->ProcessedShipment->ID;
          // $labelUrl = $response->Shipments->ProcessedShipment->ShipmentLabel->LabelURL;
        }
```

### Calculate Rate

  Calculate Rate API is used to get shipment pricing and details before you ship it. <br />
  
  it takes 4 parameters:<br />
  `Aramex::calculateRate($originAddress, $destinationAddress, $shipementDetails, $currency)` <br /><br />
  `$originAddress` and `$destinationAddress` are both arrays as follows: 
  
``` php
    [
        'line_1' => 'String|Required',
        'line_2' => 'String',
        'line_3' => 'String',
        'city' => 'String|Required',
        'state_code' => 'String',
        'postal_code' => 'String',
        'country_code' => 'String|max:2|min:2|Required',
        'longitude' => 'Double',
        'latitude' => 'Double',
        'building_number' => 'String',
        'building_name' => 'String',
    ]
``` 
  
  The `$shipmentDetails` parameter is an array describes some details about the shipment as follows:
  
``` php
    [
        'payment_type' => '', // default value in config file
        'product_group' => '', // default value in config file
        'product_type' => '', // default value in config file 
        'weight' => 5.2, // IN KG (Kilograms)
        'number_of_pieces' => 'Integer|Required',
        'height' => 5, // Dimensions in CM (optional)
        'width' => 3,  // Dimensions in CM (optional)
        'length' => 2  // Dimensions in CM (optional)
    ]
```
  
  The `$currency` is a string (3 Chars) for prefered currency calculations like `USD`,`AED`,`EUR`,`KWD` and so on. <br />
  Note that in case you want pass the dimensions, it will not take the parameters unless you pass all the `height`, `width`, `length`. <br />
  
  Sample Code 
  
``` php
        $originAddress = [
            'line_1' => 'Test string',
            'city' => 'Amman',
            'country_code' => 'JO'
        ];

        $destinationAddress = [
            'line_1' => 'Test String',
            'city' => 'Dubai',
            'country_code' => 'AE'
        ];

        $shipmentDetails = [
            'weight' => 5, // KG
            'number_of_pieces' => 2,
            'payment_type' => 'P', // if u don't pass it, it will take the config default value 
            'product_group' => 'EXP', // if u don't pass it, it will take the config default value
            'product_type' => 'PPX', // if u don't pass it, it will take the config default value
            'height' => 5.5, // CM
            'width' => 3,  // CM
            'length' => 2.3  // CM
        ];

        $shipmentDetails = [
            'weight' => 5, // KG
            'number_of_pieces' => 2, 
        ];

        $currency = 'USD';
        $data = Aramex::calculateRate($originAddress, $destinationAddress , $shipmentDetails , 'USD');
        
        if(!$data->error){
          dd($data);
        }
        else{
          // handle $data->errors
        }
 ```
   
  ### Response Object Samples<br/>
   -Success Response:

``` json
      {
         "Transaction":{
            "Reference1":"",
            "Reference2":"",
            "Reference3":"",
            "Reference4":"",
            "Reference5":null
         },
         "Notifications":{

         },
         "HasErrors":false,
         "TotalAmount":{
            "CurrencyCode":"USD",
            "Value":1004.74
         },
         "RateDetails":{
            "Amount":312.34,
            "OtherAmount1":0,
            "OtherAmount2":0,
            "OtherAmount3":78.08,
            "OtherAmount4":0,
            "OtherAmount5":475.73,
            "TotalAmountBeforeTax":866.15,
            "TaxAmount":138.59
         }
      }
```
    
   -Fail Response
    
```json
    {
      "error": 1,
      "errors": "Error strings one by one."
    }
```
  
  
  ### Track Shipments
  This service show the detailed updates on the shipments you created.<br />
  `Aramex::trackShipments($arrayOfShipmentIds);` <br /> 
  Basically get the IDs of the created shipments (`$createShipmentResults->Shipments->ProcessedShipment->ID`) and stack the IDs in an array and pass the array to the function.<br />
``` php
        $shipments = [ 
            $createShipmentResults->Shipments->ProcessedShipment->ID,
            $anotherCreateShipmentResults->Shipments->ProcessedShipment->ID,
        ];

        $data = Aramex::trackShipments($shipments);
```
  
  Sample Code<br />
``` php
        $shipments = [ 
            $createShipmentResults->Shipments->ProcessedShipment->ID,
            $anotherCreateShipmentResults->Shipments->ProcessedShipment->ID,
        ];

        $data = Aramex::trackShipments($shipments);
        
        if (!$data->error){
          // Code Here
        }
        else {
        // handle error
        }
```

  Repsponse Sample <br />
  Here I should mention if you pass wrong ID (Not Shipment ID) you will see the string you passed in `NonExistingWaybills` field. 
``` json
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
  "TrackingResults": {
    "KeyValueOfstringArrayOfTrackingResultmFAkxlpY": {
      "Key": "IdOfTheShipemnt", 
      "Value": {
        "TrackingResult": [
          {
            "WaybillNumber": "41118182136",
            "UpdateCode": "SH005",
            "UpdateDescription": "Delivered",
            "UpdateDateTime": "2015-07-13T13:08:00",
            "UpdateLocation": "Al Muqabalain, Jordan",
            "Comments": "AMJAD Delivered by (Ayman Abushhail)",
            "ProblemCode": "",
            "GrossWeight": "0.1",
            "ChargeableWeight": "0.1",
            "WeightUnit": "KG"
          },
          {
            "WaybillNumber": "41118182136",
            "UpdateCode": "SH003",
            "UpdateDescription": "Out for Delivery",
            "UpdateDateTime": "2015-07-13T08:46:00",
            "UpdateLocation": "Al Muqabalain, Jordan",
            "Comments": "",
            "ProblemCode": "",
            "GrossWeight": "0.1",
            "ChargeableWeight": "0.1",
            "WeightUnit": "KG"
          },
          {
            "WaybillNumber": "41118182136",
            "UpdateCode": "SH160",
            "UpdateDescription": "Under processing at operations facility",
            "UpdateDateTime": "2015-07-13T04:30:00",
            "UpdateLocation": "Al Muqabalain, Jordan",
            "Comments": "",
            "ProblemCode": "V01",
            "GrossWeight": "0.1",
            "ChargeableWeight": "0.1",
            "WeightUnit": "KG"
          },
      
          {
            "WaybillNumber": "30994423681",
            "UpdateCode": "SH014",
            "UpdateDescription": "Record created.",
            "UpdateDateTime": "2018-10-11T16:05:00",
            "UpdateLocation": "Amman, Jordan",
            "Comments": "0.5,0.5,KG ",
            "ProblemCode": "",
            "GrossWeight": "0.5",
            "ChargeableWeight": "0.5"
          }
        ]
      }
    }
  },
  "NonExistingWaybills":{
    "string":[
      "WrongIdIHavePassed",
      "TestId" 
    ]
  }
}
```
### Fetch Countries

  Fetching Aramex's Countries that is supported by Aramex and stored in their database. <br />
  You can either get all countries or get specific country information by passing country code as an optional parameter. <br />
  Please note that i recommend to call this method and insert all the response to your database so you can get the countries from your database and it is based on their countries so you don't waste time and make it unefficient by calling this API whenever you want to process countries data.<br />

``` php

        $data = Aramex::fetchCountries($countryCode); 
        // Or 
        $data = Aramex::fetchCountries();
```
  Response Sample <br />
``` 
  {
   "Transaction":{
      "Reference1":"",
      "Reference2":"",
      "Reference3":"",
      "Reference4":"",
      "Reference5":null
   },
   "Notifications":{

   },
   "HasErrors":false,
   "Countries":{
      "Country":[
         {
            "Code":"AD",
            "Name":"Andorra",
            "IsoCode":"AND",
            "StateRequired":true,
            "PostCodeRequired":false,
            "PostCodeRegex":{

            },
            "InternationalCallingNumber":"376"
         },
         {
            "Code":"AE",
            "Name":"United Arab Emirates",
            "IsoCode":"ARE",
            "StateRequired":true,
            "PostCodeRequired":false,
            "PostCodeRegex":{

            },
            "InternationalCallingNumber":"971"
         },
         ...
      ]
   }
}

``` 


### Fetch Cities
  Fetching Aramex's Cities by country code.<br />
``` php

        $data = Aramex::fetchCities('AE'); 

```

  Response Sample <br />

```
{
   "Transaction":{
      "Reference1":"",
      "Reference2":"",
      "Reference3":"",
      "Reference4":"",
      "Reference5":null
   },
   "Notifications":{

   },
   "HasErrors":false,
   "Cities":{
      "string":[
         "Abadilah",
         "Abu Dhabi",
         "Abu Hayl",
         "Abu Shagara",
         "Adhan",
         "Ajman City",
         "Akamiyah",
         "Al Ain City",
         "Al Ardiyah",
         "Al Azrah",
         "Al Dharbaniyah",
         ...
      ]
   }
}
```

### Validate Address
  
  To validate addresses and skipping struggling with users' inputs thats not compatible with Aramex's end, You can validate addresses before creating pickups or shipments.
```php
  
  $data = Aramex::validateAddress([
    'line_1':'Test', // optional (Passing it is recommended)
    'line_2':'Test', // optional
    'line_3':'Test', // optional
    'country_code':'JO',
    'postal_code':'', // optional
    'city':'Amman',
  ]);

```

  Response Sample <br />

```json
{
   "Transaction":{
      "Reference1":"",
      "Reference2":"",
      "Reference3":"",
      "Reference4":"",
      "Reference5":null
   },
   "Notifications":{

   },
   "HasErrors":false,
   "SuggestedAddresses":{

   }
}
```

Hope this helps you well, Buy me a coffee ;) <br />

[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/MoustafaAllahham)



MIT Licence 

Copyright 2019 Moustafa Allahham

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
