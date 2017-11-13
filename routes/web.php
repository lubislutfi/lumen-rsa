<?php

use phpseclib\Crypt\RSA;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/key', function () use ($router) {
    $rsa = new RSA();
    extract($rsa->createKey(1024));
    $myPubKey = $publickey;
    $myPrivKey = $privatekey;

    $rsa->loadKey($myPubKey); // public key
    echo "<br><br>Public Key<br>============<br>";
    echo $myPubKey;
    echo "<br><br>Private Key<br>============<br>";
    echo $myPrivKey;

    echo "<br><br>Plain Text<br>============<br>";
    $plaintext = 'Budi sedang mandi di kali bersama temannya';
    echo $plaintext;

    //$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_OAEP);
    $ciphertext = $rsa->encrypt($plaintext);
    echo "<br><br>Chiper Text<br>============<br>";
    echo $ciphertext;

    $rsa->loadKey($privatekey); // private key
    $decrypted = $rsa->decrypt($ciphertext);
    echo "<br><br>Decrypted Text<br>============<br>";
    echo $decrypted;

    //return $privatekey;
});


/*
$router->get('/getprivatekey', function () use ($router) {
    $rsa = new RSA();
    $rsa->createKey(1024);

    return $rsa->getPrivateKey();
});*/