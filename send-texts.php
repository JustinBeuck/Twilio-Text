<?php

	ini_set('display_errors',1); 
	error_reporting(E_ALL);
	
	require "Libraries/Twilio/Twilio.php";
 	require "phone-numbers.php";
//  	require "phone-numbers-test.php";
 	
 	// IF RUNNING FROM TERMINAL 1st arg is name of message *.txt
 	
	 $file = $argv[1];
 	
    // Set our AccountSid and AuthToken from twilio.com/user/account
    $AccountSid	= "AC67d4d4df382fb076880a5a4803e93926";
    $AuthToken	= "d42fbfb5f4f9d32ab24966499086b8c0";
    // Instantiate a new Twilio Rest Client
    
    $client		= new Services_Twilio($AccountSid, $AuthToken);
    
    // Your Twilio Number or Outgoing Caller ID
    $from = '5124026818';
 	
  	$body = file_get_contents('./messages/'.$file);
 	
 	$i = 0;
 	$err = 0;
 	foreach( $numbers as $lead ){

	 	try {
	 		$to = $lead['number'];
			$client->account->sms_messages->create($from, $to, str_replace(array('||FirstName||', '||number||'), array($lead['FirstName'], $lead['number']), $body));
			
			echo 'Message Sent to : '.$to."\n";
			$i++;
			printf("Number of messages sent : %5d / %-5d | %6d%% Complete\n",$i,sizeof($numbers),round($i / sizeof($numbers) * 100,2));
			
	 	    
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			$err++;
		}
	 	
 	}

 	$client->account->sms_messages->create($from, '5126267631', "Operation Complete ".$i." text messages sent.\nScript has finished with ".$err." errors.");
 	echo "Operation Complete ".$i." text messages sent.\n";
?>