<?php
$server = array();

//===== BEGIN Configuration =====
//***** BEGIN URLs To Check *****
//"name" is any name you want that will appear in the email title
//"url" is the direct URL of the server on online.net
//Example:
//$server[0]['name']="LT";//
//$server[0]['url']="https://www.online.net/en/dedicated-server/dedibox-lt";

//$server[1]['name']="Dedibox MD";
//$server[1]['url']="https://www.online.net/en/dedicated-server/dedibox-md";

//$server[1]['name']="Classic Server";
//$server[2]['url']="https://www.online.net/en/dedicated-server/dedibox-classic";

$server[0]['name']="";
$server[0]['url']="";

$server[1]['name']="";
$server[1]['url']="";
//***** END URLs To Check *****


//***** BEGIN Email Settings *****
$sendEmailTo="";//Your email address
$emailName="";//Just a name 
$emailSubject="%name% is Available";//%name% is the "name" defined above in the URLs section
$emailBodyContent="The server %name% is available";//%name% is the "name" defined above in the URLs section
$emailBodyContent.="<br /><br />";
$emailBodyContent.="URL:";
$emailBodyContent.="<br />";
$emailBodyContent.="%url%";//%url% is the "url" defined above in the URLs section
//***** END Email Settings *****


//===== END Configuration =====


//===== BEGING Execution =====
//Edit on you own risk

foreach($server as $u)
{
	if(isset($u['url']) && isset($u['name']))
	{
		$data = file_get_contents($u['url']);
		
		if(!empty($data))
		{
			$notAvailable = explode('Victim of its success',$data);
			$available = explode('itemprop="availability"',$data);

			//Not Available
			if(count($notAvailable) > 1)
			{
			}
			//Available
			elseif(count($available) > 1)
			{
				sendEmail($u['url'],$u['name'],$sendEmailTo,$emailSubject,$emailBodyContent,$emailName);
			}
		}
	}
}


function sendEmail($url,$name,$sendEmailTo,$emailSubject,$emailBodyContent,$emailName)
{
	// To send HTML mail, the Content-type header must be set
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=iso-8859-1';

	// Additional headers
	$headers[] = 'To: ' . $emailName . ' <' . $sendEmailTo . '>';

	$subject = str_replace("%name%",$name,$emailSubject);
	$subject = str_replace("%url%",$url,$subject);

	$message = str_replace("%name%",$name,$emailBodyContent);
	$message = str_replace("%url%",$url,$message);

	// Mail it
	if(!empty($sendEmailTo) && $sendEmailTo != "")
	mail($sendEmailTo, $subject, $message, implode("\r\n", $headers));
}
//===== END Execution =====
?>
