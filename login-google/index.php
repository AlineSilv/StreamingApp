<?php

ob_start();
session_start();
use League\OAuth2\Client\Provider\Google;
require_once __DIR__ . '\vendor\autoload.php';



if (empty($_SESSION["userLogin"])){
    echo"<h3>Guest user</h3>";

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
    echo"<a title='Logar com Google' href='{$authUrl}'>Google Login</a>";
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