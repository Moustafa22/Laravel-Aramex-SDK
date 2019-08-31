<?php 

namespace Octw\Aramex\Helpers;

use Octw\Aramex\Validators\Validator;
/**
* Basic Helper to extract data from param array and some validations.
*/
class AramexHelper
{


	/**
	* @function just Data extraction nothing functional.
    * @param Array of options.
    * @return Object of all required details about the consignee.
	*/
	public static function extractConsigneeObject($param = []){

		// 		Validation

       	// Validate First
        Validator::validateAddressObject($param);

        //		Extract Data into a new object
        
        // Create the Objcect
        $consignee =  new \stdClass;

        // Start extracting
        $consignee->name = $param['name']; 
        $consignee->email = $param['email'];

        $consignee->phone_number = $param['phone'];
        $consignee->phone = $param['cell_phone'];

        $consignee->country_code = $param['country_code'];
        $consignee->city = $param['city'];

        $consignee->line1 = $param['line1'];
        $consignee->line2 = $param['line2'];
        $consignee->line3 = $param['line3'];
        
        return $consignee;
    }



    public static function extractPickupAddressContact($param =[])
    {

		// 		Validation

       	// Validate First

    	Validator::validateAddressObject($param);

		// Create the Objcect
        $pickupAddress = new \stdClass;

        // Start extracting
        $pickupAddress->PersonName = $param['name']; 
        $pickupAddress->EmailAddress = $param['email'];

        $pickupAddress->PhoneNumber1 = $param['phone'];
        $pickupAddress->CellPhone = $param['cell_phone'];

        $pickupAddress->CountryCode = $param['country_code'];
        $pickupAddress->City = $param['city'];
        $pickupAddress->ZipCode = isset($param['zip_code'])? $param['zip_code'] : '';

        $pickupAddress->Line1 = $param['line1'];
        $pickupAddress->Line2 = $param['line2'];
        $pickupAddress->Line3 = isset($param['line3']) ? $param['line3'] : '';
        
        return $pickupAddress;
    }

    public static function extractPickupDetails($param)
    {
    	// 		Validation
    	// Validate First
    	Validator::validatePickupDetails($param);

    	// Create the Object 

    	$pickupDetails = new \stdClass;

    	// Start extracting
		$pickupDetails->Reference1 = isset($param['reference1']) ? $param['reference1']: time() ; 
        $pickupDetails->Reference2 = isset($param['reference2']) ? $param['reference2']:'' ;
		$pickupDetails->Reference3 = isset($param['reference3']) ? $param['reference3']:'' ;
		
		$pickupDetails->PickupLocation = $param['pickup_location'];
		$pickupDetails->Status = $param['status'];

		$pickupDetails->PickupDate = $param['pickup_date'];
		$pickupDetails->ReadyTime = $param['ready_time'];
		$pickupDetails->LastPickupTime = $param['last_pickup_time'];
		$pickupDetails->ClosingTime = $param['closing_time'];
		
		$pickupDetails->ProductGroup = isset($param['product_group']) ?$param['product_group'] : config('aramex.ProductGroup') ; 
		$pickupDetails->Payment = isset($param['payment']) ?$param['payment'] : config('aramex.Payment') ; 
		$pickupDetails->ProductType = isset($param['product_type']) ?$param['product_type'] : config('aramex.ProductType')  ; 

		$pickupDetails->Weight = $param['weight'];
		$pickupDetails->Volume = $param['volume'];

		return $pickupDetails;
    }

    public static function extractShipperAddressContact($param = [] )
    {
        // Validation 

        Validator::validateAddressObject($param['shipper']);

        $addresDetails = new \stdClass;

        $addresDetails->PersonName = $param['shipper']['name']; 
        $addresDetails->EmailAddress = $param['shipper']['email'];

        $addresDetails->PhoneNumber1 = $param['shipper']['phone'];
        $addresDetails->CellPhone = $param['shipper']['cell_phone'];

        $addresDetails->CountryCode = $param['shipper']['country_code'];
        $addresDetails->City = $param['shipper']['city'];
        $addresDetails->ZipCode = isset($param['shipper']['zip_code'])? $param['shipper']['zip_code'] : '';

        $addresDetails->Line1 = $param['shipper']['line1'];
        $addresDetails->Line2 = $param['shipper']['line2'];
        $addresDetails->Line3 = isset($param['shipper']['line3']) ? $param['shipper']['line3'] : '';
        
        return $addresDetails;
    } 

    public static function extractConsigneeAddressContact($param = [] )
    {
        // Validation 

        Validator::validateAddressObject($param['consignee']);

        $addresDetails = new \stdClass;

        $addresDetails->PersonName = $param['consignee']['name']; 
        $addresDetails->EmailAddress = $param['consignee']['email'];

        $addresDetails->PhoneNumber1 = $param['consignee']['phone'];
        $addresDetails->CellPhone = $param['consignee']['cell_phone'];

        $addresDetails->CountryCode = $param['consignee']['country_code'];
        $addresDetails->City = $param['consignee']['city'];
        $addresDetails->ZipCode = isset($param['consignee']['zip_code'])? $param['consignee']['zip_code'] : '';

        $addresDetails->Line1 = $param['consignee']['line1'];
        $addresDetails->Line2 = $param['consignee']['line2'];
        $addresDetails->Line3 = isset($param['consignee']['line3']) ? $param['consignee']['line3'] : '';
        
        return $addresDetails;
    }

    public static function extractShipmentDetails($param = []){
        // Validation 

        Validator::validateShipmentDetails($param);

        $shipmentDetails = new \stdClass;

        $shipmentDetails->ShippingDateTime = $param['shipping_date_time'];
        $shipmentDetails->DueDate = $param['due_date'];
        $shipmentDetails->Comments = $param['comments'];
        
        $shipmentDetails->PickupLocation = $param['pickup_location'];
        $shipmentDetails->PickupGUID = $param['pickup_guid'];
        
        $shipmentDetails->ActualWeight = $param['weight'];
        $shipmentDetails->NumberOfPieces = $param['number_of_pieces'] ?? 1;
        $shipmentDetails->GoodsOriginCountry = $param['goods_country'] ?? null;
        
        $shipmentDetails->ProductGroup = $param['product_group'] ?? config('aramex.ProductGroup');
        $shipmentDetails->ProductType  = $param['product_type'] ?? config('aramex.ProductType');
        $shipmentDetails->PaymentType  = $param['payment_type'] ?? config('aramex.Payment');
        $shipmentDetails->PaymentType = $param['payment_type'] ?? config('aramex.Payment');
        $shipmentDetails->PaymentOptions = $param['payment_type'] ?? config('aramex.PaymentOptions');


        $shipmentDetails->DescriptionOfGoods = $param['description'] ?? "";

        $shipmentDetails->CollectAmount = $param['collect_amount'] ?? 0;

        $shipmentDetails->CashOnDeliveryAmount = $param['cash_on_delivery_amount'] ?? 0;
        
        $shipmentDetails->InsuranceAmount = $param['insurance_amount'] ?? 0;
        
        $shipmentDetails->CustomsValueAmount = $param['customs_value_amount'] ?? 0;

        $shipmentDetails->CashAdditionalAmount = $param['cash_additional_amount'] ?? 0;
        $shipmentDetails->CashAdditionalAmountDescription = $param['cash_additional_amount_description'] ?? "";

        $shipmentDetails->CurrencyCode = $param['currency_code'] ?? config('aramex.CurrencyCode');

        return $shipmentDetails;
    }

}