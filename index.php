<?php

ob_start();
session_start();
use League\OAuth2\Client\Provider\Google;
require_once __DIR__ . '\login-google\vendor\autoload.php';


if (empty($_SESSION["userLogin"])){
    /**
     * Auth Google
     */
    
    $google = new \League\OAuth2\Client\Provider\Google(options:[
    'clientId' => '685686297065-9hjlpqitrj5lk56ti2rce2ih3jmn68au.apps.googleusercontent.com',
    'clientSecret' => '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',
    'redirectUri'  => 'https://tespis.vercel.app/user/index.html',
    ]);


    $authUrl = $google->getAuthorizationUrl();
    $error = filter_input(type: INPUT_GET, var_name:"error", filter: FILTER_SANITIZE_STRING);
    $code = filter_input(type: INPUT_GET, var_name:"code", filter:FILTER_SANITIZE_STRING);

    if($error){
        echo"<h3>Você precisa autorizar, para prosseguir.</h3>";
    }

    if($code){
    $token = $google->getAccesToken(grant_type("authorization_code"),
    ["code" => $code]);
   
    $_SESSION["userLogin"]= serialize($google->getResourceOwner($token));
    header(string: "Location:".GOOGLE["redirectUri"]);
    die;
    }
    //echo"<a title='Logar com Google' href='{$authUrl}'>Google Login</a>";
}

else{
    echo"<h2>User</h2>";
    /** @var \League\Oauth2\Client\Provider\Google $user */
    $user = unserialize($_SESSION["User Login"]);
    echo "<img width='20%' src='{$user->getAvatar()}' alt='{$user->getFirstname()}' title='{$user->getFirstname()}'/> <h1>Welcome {$user->getFirstname()}</h1>";
    
    var_dump($user->toArray());
}

ob_end_flush();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">
    <title>Téspis | Login</title>
    <link rel="stylesheet" href="./tespis-login/stylesheet-login.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:wght@800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
  </head>
  <body>
    <div class="container">
      <h2 id="tespis-logo">Téspis</h2>
      <input type="email" placeholder="Email" />
      <input type="password" placeholder="Password" />
      </div>
    <div class="google" style= "display:flex; flex-direction:column; align-items:center;">
      <?php 
      echo"<a title='Logar com Google' href='{$authUrl}'>Google Login</a>";
      ?>
      </div>
      
      <div class="butto">
      <button><a href="C:\xampp\htdocs\dev\tespis\user\index.html">Sign In</a></button>
      <a href="#">Forgot your password?</a>
      <a href="http://localhost/dev/formulary/index.php"><h6>Become a Member</h6></a>
    </div>
  </body>
</html>