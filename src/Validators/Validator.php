<?php

namespace Octw\Aramex\Validators;

use Validator as StandardValidator;
use Illuminate\Validation\Rule;

/**
* Validation Only 
*/
trait Validator
{
	
    public static function validateAddressObject($param )
    {
    	$validator = StandardValidator::make($param, [
			"name"  => "required|min:3",
			"cell_phone"  => "required|min:8",
			"phone"  => "required|min:8",
			"email"  => "required|min:3",
			"city"  => "required|min:3",
			"country_code"  => "required|min:2",
			"line1"  => "required|min:5",
			"line2"  => "required|min:5",
		]);
		if ($validator->fails()) 
		{ 
		  throw new \Exception("Validation Error  \n".json_encode($validator->messages(), JSON_PRETTY_PRINT), 1);
		}
    }

	public static function validatePickupDetails($param)
	{
		$validator = StandardValidator::make($param , [
			'pickup_date' => 'required',
			'ready_time' => 'required',
			'last_pickup_time' => 'required',
			'closing_time' => 'required',
			'status' => ['required' ,  Rule::in(['Pending', 'Ready']),],
			'pickup_location' => 'required|string',
			'weight' => 'required',
			'volume' => 'required',
		]);
		if ($validator->fails()) 
		{ 
		  throw new \Exception("Validation Error <br> \n".json_encode($validator->messages(), JSON_PRETTY_PRINT), 1);
		}
	}

	public static function validateShipmentDetails($param)
	{
		$validator = StandardValidator::make($param , [
			'shipping_date_time' => 'required',
			'due_date' => 'required',
			'pickup_location' => 'required',
			'weight' => 'required',
		]);
		if ($validator->fails()) 
		{ 
		  throw new \Exception("Validation Error <br> \n".json_encode($validator->messages(), JSON_PRETTY_PRINT), 1);
		}
	}


	public static function validateCalculateRateAddress($param)
	{
		$validator = StandardValidator::make($param , [
			'city' => 'required|string',
			'country_code' => 'required|min:2|max:2',
		]);

		if ($validator->fails()) 
		{ 
		  throw new \Exception("Validation Error <br> \n".json_encode($validator->messages(), JSON_PRETTY_PRINT), 1);
		}
	}

	public static function validateCalculateRateDetails($param)
	{
		$validator =StandardValidator::make($param , [
			'weight' => 'required',
			'number_of_pieces' => 'required'
		]);


		if ($validator->fails()) 
		{ 
		  throw new \Exception("Validation Error <br> \n".json_encode($validator->messages(), JSON_PRETTY_PRINT), 1);
		}
	}

}