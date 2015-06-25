<!DOCTYPE html>
<html>
<head>
<title>Facebook Friends List</title>
<meta charset="UTF-8">
</head>
<body>
<?php
$fbconfig['appid'] = "978692375515341";
$fbconfig['secret'] = "b9092f3d1c5b5afb13f617f3b75586a7";
?>
<script>
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    if (response.status === 'connected') {
      userAPI();

    } else if (response.status === 'not_authorized') {
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
    appId      : <?php echo $fbconfig['appid']; ?>,
    cookie     : true,  // enable cookies to allow the server to access 
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.2' // use version 2.2
	
  });
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  function userAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML =
        'Thanks for logging in, ' + response.name + '!';
		
    });
	
  }
</script>

<?php
require_once 'dbconfig.php';
include_once ('facebook-php-sdk-master\src\facebook.php');
  $facebook = new Facebook(array(
'appId'  => $fbconfig['appid'],
'secret' => $fbconfig['secret'],
'cookie' => true,
));
$user       = $facebook->getUser();
$loginUrl   = $facebook->getLoginUrl(
array(
'scope'         => 'email,user_friends,user_friends'
)
);
$user_profile = $facebook->api('/me');
$user_friends = $facebook->api('/me/taggable_friends');
$access_token = $facebook->getAccessToken();
//echo '<pre>';print_r($user_friends);exit;
?>
<fb:login-button scope="public_profile,email,user_friends" onlogin="checkLoginState();">
</fb:login-button>

<div id="status">
</div>
<?php
$id=$user_profile['id'];
$user_friends=$user_friends['data'];
$loginUsers = "SELECT * FROM fb_friends where fb_user_id='".$id."'" ;
$login = mysqli_query($connection,$loginUsers);
$Lus=mysqli_num_rows($login);
if($Lus==0){
for($i=0; $i<count($user_friends); $i++){
$name=$user_friends[$i]['name'];
mysqli_query($connection,"CALL `fb_firends_insert`('".$name."', '".$id."')");
}
}
$sqlGetUsers = "SELECT * FROM fb_friends where fb_user_id='".$id."'" ;
$rsUsers = mysqli_query($connection,$sqlGetUsers);
$rowcount=mysqli_num_rows($rsUsers);
if($rowcount>0){ 
echo '<table>'; 
echo '<tr><th>SNo.</th><th>Name</th><th></th><th><a href="download.php?userid='.$id.'">Export</a></th></tr>';
$cNt=1;
while($dataUsers = mysqli_fetch_array($rsUsers)){ 
echo '<tr><td>'.$cNt.'</td><td>'.$dataUsers['user_first_name'].'</td></tr>';
$cNt++;
}
echo '</table>';  
}
?>
</body>
</html>