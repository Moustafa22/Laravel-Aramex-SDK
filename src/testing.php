<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	
	$soapClient = new SoapClient('Shipping.wsdl');
	echo '<pre>';
	print_r($soapClient->__getFunctions());

	$params = array(
			'Shipments' => array(
				'Shipment' => array(
						'Shipper'	=> array(
										'Reference1' 	=> 'Ref 111111',
										'Reference2' 	=> 'Ref 222222',
										'AccountNumber' => '20016',
										'PartyAddress'	=> array(
											'Line1'					=> 'Mecca St',
											'Line2' 				=> '',
											'Line3' 				=> '',
											'City'					=> 'Amman',
											'StateOrProvinceCode'	=> '',
											'PostCode'				=> '',
											'CountryCode'			=> 'Jo'
										),
										'Contact'		=> array(
											'Department'			=> '',
											'PersonName'			=> 'Michael',
											'Title'					=> '',
											'CompanyName'			=> 'Aramex',
											'PhoneNumber1'			=> '5555555',
											'PhoneNumber1Ext'		=> '125',
											'PhoneNumber2'			=> '',
											'PhoneNumber2Ext'		=> '',
											'FaxNumber'				=> '',
											'CellPhone'				=> '07777777',
											'EmailAddress'			=> 'michael@aramex.com',
											'Type'					=> ''
										),
						),
												
						'Consignee'	=> array(
										'Reference1'	=> 'Ref 333333',
										'Reference2'	=> 'Ref 444444',
										'AccountNumber' => '',
										'PartyAddress'	=> array(
											'Line1'					=> '15 ABC St',
											'Line2'					=> '',
											'Line3'					=> '',
											'City'					=> 'Dubai',
											'StateOrProvinceCode'	=> '',
											'PostCode'				=> '',
											'CountryCode'			=> 'AE'
										),
										
										'Contact'		=> array(
											'Department'			=> '',
											'PersonName'			=> 'Mazen',
											'Title'					=> '',
											'CompanyName'			=> 'Aramex',
											'PhoneNumber1'			=> '6666666',
											'PhoneNumber1Ext'		=> '155',
											'PhoneNumber2'			=> '',
											'PhoneNumber2Ext'		=> '',
											'FaxNumber'				=> '',
											'CellPhone'				=> '',
											'EmailAddress'			=> 'mazen@aramex.com',
											'Type'					=> ''
										),
						),
						
						'ThirdParty' => array(
										'Reference1' 	=> '',
										'Reference2' 	=> '',
										'AccountNumber' => '',
										'PartyAddress'	=> array(
											'Line1'					=> '',
											'Line2'					=> '',
											'Line3'					=> '',
											'City'					=> '',
											'StateOrProvinceCode'	=> '',
											'PostCode'				=> '',
											'CountryCode'			=> ''
										),
										'Contact'		=> array(
											'Department'			=> '',
											'PersonName'			=> '',
											'Title'					=> '',
											'CompanyName'			=> '',
											'PhoneNumber1'			=> '',
											'PhoneNumber1Ext'		=> '',
											'PhoneNumber2'			=> '',
											'PhoneNumber2Ext'		=> '',
											'FaxNumber'				=> '',
											'CellPhone'				=> '',
											'EmailAddress'			=> '',
											'Type'					=> ''							
										),
						),
						
						'Reference1' 				=> 'Shpt 0001',
						'Reference2' 				=> '',
						'Reference3' 				=> '',
						'ForeignHAWB'				=> 'ABC 000111',
						'TransportType'				=> 0,
						'ShippingDateTime' 			=> time(),
						'DueDate'					=> time(),
						'PickupLocation'			=> 'Reception',
						'PickupGUID'				=> '',
						'Comments'					=> 'Shpt 0001',
						'AccountingInstrcutions' 	=> '',
						'OperationsInstructions'	=> '',
						
						'Details' => array(
										'Dimensions' => array(
											'Length'				=> 10,
											'Width'					=> 10,
											'Height'				=> 10,
											'Unit'					=> 'cm',
											
										),
										
										'ActualWeight' => array(
											'Value'					=> 0.5,
											'Unit'					=> 'Kg'
										),
										
										'ProductGroup' 			=> 'EXP',
										'ProductType'			=> 'PDX',
										'PaymentType'			=> 'P',
										'PaymentOptions' 		=> '',
										'Services'				=> '',
										'NumberOfPieces'		=> 1,
										'DescriptionOfGoods' 	=> 'Docs',
										'GoodsOriginCountry' 	=> 'Jo',
										
										'CashOnDeliveryAmount' 	=> array(
											'Value'					=> 0,
											'CurrencyCode'			=> ''
										),
										
										'InsuranceAmount'		=> array(
											'Value'					=> 0,
											'CurrencyCode'			=> ''
										),
										
										'CollectAmount'			=> array(
											'Value'					=> 0,
											'CurrencyCode'			=> ''
										),
										
										'CashAdditionalAmount'	=> array(
											'Value'					=> 0,
											'CurrencyCode'			=> ''							
										),
										
										'CashAdditionalAmountDescription' => '',
										
										'CustomsValueAmount' => array(
											'Value'					=> 0,
											'CurrencyCode'			=> ''								
										),
										
										'Items' 				=> array(
											
										)
						),
				),
		),
		
			'ClientInfo'  			=> array(
										'AccountCountryCode'	=> 'JO',
										'AccountEntity'		 	=> 'AMM',
										'AccountNumber'		 	=> '20016',
										'AccountPin'		 	=> '221321',
										'UserName'			 	=> 'reem@reem.com',
										'Password'			 	=> '123456789',
										'Version'			 	=> '1.0'
									),

			'Transaction' 			=> array(
										'Reference1'			=> '001',
										'Reference2'			=> '', 
										'Reference3'			=> '', 
										'Reference4'			=> '', 
										'Reference5'			=> '',									
									),
			'LabelInfo'				=> array(
										'ReportID' 				=> 9201,
										'ReportType'			=> 'URL',
			),
	);
	
	$params['Shipments']['Shipment']['Details']['Items'][] = array(
		'PackageType' 	=> 'Box',
		'Quantity'		=> 1,
		'Weight'		=> array(
				'Value'		=> 0.5,
				'Unit'		=> 'Kg',		
		),
		'Comments'		=> 'Docs',
		'Reference'		=> ''
	);
	
	print_r($params);
	
	try {
		$auth_call = $soapClient->CreateShipments($params);
		echo '<pre>';
		print_r($auth_call);
		die();
	} catch (SoapFault $fault) {
		die('Error : ' . $fault->faultstring);
	}
?>
