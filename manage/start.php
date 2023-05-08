<?php
require_once('../includes/config.php');
require_once('../includes/class.customer_login.php');
	
$lgn = new CustomerLogin;

$msg = '';

// first version
function get_location($ip){
	
	//echo "ip ".$ip;
	//echo "<br />";
	
	$access_key = '05844069326bb748079507f1aa6a17fc';
	$ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$json = curl_exec($ch);
	curl_close($ch);
	$api_result = json_decode($json, true);
	
	$city = (isset($api_result['city']))? $api_result['city'] : 'none'; 
	$country = (isset($api_result['country_name']))? $api_result['country_name'] : 'none'; 
	$region_name = (isset($api_result['region_name']))? $api_result['region_name'] : 'none'; 
	$capital = (isset($api_result['location']['capital']))? $api_result['location']['capital'] : 'none'; 
	
	/*
	$city = $api_result['city'];
	$country = $api_result['country_name'];
	$region_name = $api_result['region_name'];
	$capital = $api_result['location']['capital'];
	*/
	
	$loc = array();
	$loc['city'] = $city;
	$loc['country'] = $country;
	$loc['capital'] = $capital;
	$loc['region_name'] = $region_name;
	
	return $loc;
}

// second version
//https://app.ipgeolocation.io/
// 
function get_geolocation($apiKey, $ip, $lang = "en", $fields = "*", $excludes = "") {
        $url = "https://api.ipgeolocation.io/ipgeo?apiKey=".$apiKey."&ip=".$ip."&lang=".$lang."&fields=".$fields."&excludes=".$excludes;
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: '.$_SERVER['HTTP_USER_AGENT']
        ));

	return curl_exec($cURL);
}

$apiKey = '21295947bb4445d5bd62d68868d23538';
//$ip = '5.25.160.123';
//$location = get_geolocation($apiKey, $ip); 
//$decodedLocation = json_decode($location, true);
//print_r($decodedLocation);





$ts = time();

$user_type_id  = 3;
$name = "Me";
$user_name = "mark.stanz@gmail.com";
$password = "nathannn1A@@";
	
//$password_salt = $lgn->generateSalt();
//$password_hash = $lgn->get_hash($password, $password_salt);
//$sql = "DELETE FROM profile
//		WHERE username = 'mark.stanz@gmail.com'";
//$result = $dbCustom->getResult($db,$sql);
/*
$sql = sprintf("INSERT INTO profile 
				(name, username, password_hash, password_salt, user_type_id, created, visited, profile_account_id)
   			   VALUES('%s','%s','%s','%s','%u','%u','%u','%u')", 
				$name, $user_name, $password_hash, $password_salt, $user_type_id, $ts, $ts, $_SESSION['profile_account_id']);
*/	
//$result = $dbCustom->getResult($db,$sql);

	
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Expert Answer</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">

<link rel="stylesheet" type="text/css" href="./assets/css/base.css">
<script src="../js/tinymce/tinymce.min.js"></script>

</head>
<body>

<div style="margin-left:20px;">
	<img height="40" src="<?php echo SITEROOT;?>/img/nat.png" />
	<?php
	echo "<span>Welcome  ".$lgn->getFullName()."<span>";
	echo "<span style='margin-left:30px; color:red; font-size:1.3em;'>".$msg."</span>";
	echo "<br />";
	require_once('includes/manage-nav.php');
	?>
</div>

<div class="row">		
	<div class="col-md-12">
		<div style="margin:10px;">

			<hr />					
			<?php	
			//echo "img_id:  ".$_SESSION['img_id'];
			$_SESSION['ret_dir'] = 'manage';
			$_SESSION['ret_page'] = 'start';
			$url_str = "../newupload/upload-pre-crop.php";
			?>
			<a href="<?php echo $url_str; ?>"  class="btn btn-info">New Cropper With Rotate</a>
			<hr />			
		

			<a href="profess-profiles.php">Member Profiles</a> 
			<hr />			
			<a href="profess-profiles.php">Member Skills</a>            		
			<hr />
			<a href="articles.php">Articles</a>            		
			<hr />
			<a href="questions.php">Questions</a>            		
			<hr />
			<a href="profess-profiles.php">Member Profiles</a>            		
		</div>			
	</div>
</div>
<?php

//http://api.ipstack.com/178.244.192.184?access_key=05844069326bb748079507f1aa6a17fc

//$sql = "DELETE FROM hit
//WHERE ip = '178.244.203.218'";
//$result = $dbCustom->getResult($db,$sql);
?>
 
<hr />
<center>
<table border='1' cellpadding='10'>
<tr>
<td>ip</td>
<td>isp</td>
<td>country_name</td>
<td>state_prov</td>
<td>city</td>
<td>when</td>
</tr>
<?php

//$s_ts = 24*60*60*4;
//$s_ts = 24*60*60;
//$s_ts = 12*60*60;
$s_ts = 10*60*60;


$start_ts = $ts - $s_ts;
//echo date('F j, Y, g:i a',$start_ts);

$sql = "DELETE FROM hit
		WHERE ip LIKE '95.181.238%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '125.162%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '66.220%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '31.13%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '69.171%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '158.69%'";
//$result = $dbCustom->getResult($db,$sql);


$sql = "DELETE FROM hit
		WHERE ip LIKE '173.252%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '5.25%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '212.80%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '18.212%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '54.36%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '167.114%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '159.65%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '69.171.251%'";
//$result = $dbCustom->getResult($db,$sql);

$sql = "DELETE FROM hit
		WHERE ip LIKE '144.76.96.236'";
//$result = $dbCustom->getResult($db,$sql);


$sql = "DELETE FROM hit
		WHERE ip LIKE '62.138.2%'";
//$result = $dbCustom->getResult($db,$sql);


$sql = "DELETE FROM hit
		WHERE ip LIKE '66.220.149%'";
//$result = $dbCustom->getResult($db,$sql);


$sql = "DELETE FROM hit
		WHERE ip LIKE '114.119.%'";
//$result = $dbCustom->getResult($db,$sql);


$sql = "DELETE FROM hit
		WHERE when_hit < '".$start_ts."'";
//$result = $dbCustom->getResult($db,$sql);



$sql = "SELECT * 
FROM hit
WHERE when_hit > '".$start_ts."'
ORDER BY id";

$result = $dbCustom->getResult($db,$sql);

while($row = $result->fetch_object()){

	//$loc = get_location($row->ip);
	
	//echo "<tr>";
	//echo "<td>".$row->ip."</td>";
	//echo "<td colspan='4'></td>";
	//echo "<td>".$loc['city']."</td>";
	//echo "<td>".$loc['region_name']."</td>";
	//echo "<td>".$loc['capital']."</td>";
	//echo "<td>".$loc['country']."</td>";
	//echo "<td>".date('F j, Y, g:i a',$row->when_hit)."</td>";
	//echo "</tr>";
	
	$location = get_geolocation($apiKey, $row->ip); 
	$decodedLocation = json_decode($location, true);


//print_r($decodedLocation);
//echo "<hr />";

$isp = "";
$country_name = "";
$state_prov = "";
$city = "";

	if(isset($decodedLocation['isp'])) $isp = $decodedLocation['isp'];
	if(isset($decodedLocation['country_name'])) $country_name = $decodedLocation['country_name'];
	if(isset($decodedLocation['state_prov'])) $state_prov = $decodedLocation['state_prov'];
	if(isset($decodedLocation['city'])) $city = $decodedLocation['city'];

	echo "<tr>";
	echo "<td>".$row->ip."</td>";	
	echo "<td>".$isp."</td>";
	echo "<td>".$country_name."</td>";
	echo "<td>".$state_prov."</td>";
	echo "<td>".$city."</td>";

	echo "<td>".date('M j, H:i',$row->when_hit)."</td>";
	echo "</tr>";
	
	
	
}

/*

	$email_addr = "support@pacificgrass.co";
	
	$link = "https://www.Expert Answer.com/#lgn";

	$message = '';
	$message.= "Thank you for joining Expert Answer";
	$message.= "\n\n\r If you haven't completed your setup, please sign in"; 
	$message.= "\n\n\r";
	$message.= $link;
	$message.= "\n\n\r";
	$subject = "Your Expert Answer Profile";		

	//$headers = "From: mark@nazardesigns.com";
	$headers = "From: admin@Expert Answer.com";
	$headers .= "\r\n";
	$headers .= "CC: mark@nazardesigns.com";

	$to = $email_addr;		
	//$to = "mark.stanz@gmail.com";
	error_reporting(0);
	if(mail($to, $subject, $message, $headers)){

	}else{
				
	}

*/





?>
</table>
</center>

<br />
<br />
<a href="tog.php">Sample Toggle </a>            		
			


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>
</html>



<!--

{"ip":"178.244.192.184",
"type":"ipv4",
"continent_code":"AS",
"continent_name":"Asia",
"country_code":"TR",
"country_name":"Turkey",
"region_code":"34",
"region_name":"Istanbul",
"city":"Istanbul",
"zip":"34010",
"latitude":41.01388931274414,
"longitude":28.96027946472168,
"location":{"geoname_id":745044,
	"capital":"Ankara",
	"languages":[{"code":"tr",
		"name":"Turkish"
		,"native":"T\u00fcrk\u00e7e"}]
	,"country_flag":"http:\/\/assets.ipstack.com\/flags\/tr.svg"
	,"country_flag_emoji":"\ud83c\uddf9\ud83c\uddf7"
	,"country_flag_emoji_unicode":"U+1F1F9 U+1F1F7"
	,"calling_code":"90"
	,"is_eu":false}}


New
International
Geographic
Gastro 
Enteritis
Recovery


-->























