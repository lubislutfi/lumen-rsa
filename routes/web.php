<?php

use phpseclib\Crypt\RSA;
use phpseclib\Math\BigInteger;
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

    $headerPrivKey = "-----BEGIN RSA PRIVATE KEY-----";
    $trailerPrivKey = "\n-----END RSA PRIVATE KEY-----";
    $trailerPrivKey2 = "-----END RSA PRIVATE KEY-----";
    $headerPubKey = "-----BEGIN RSA PUBLIC KEY-----";
    $trailerPubKey = "\n-----END RSA PUBLIC KEY-----";
    $trailerPubKey2 = "-----END RSA PUBLIC KEY-----";
    
    //define('CRYPT_RSA_MODE', RSA::MODE_INTERNAL);        
    $rsax = new RSA();
    $rsax->setPrivateKeyFormat(RSA::PRIVATE_FORMAT_PKCS1);
    $rsax->setPublicKeyFormat(RSA::PUBLIC_FORMAT_PKCS1);
    define('CRYPT_RSA_EXPONENT', 65537);
   // $rsax->setPublicKeyFormat(RSA::PUBLIC_FORMAT_RAW);    

    $key = $rsax->createKey(1024);
    $pub = $key['publickey'];
    $priv = $key['privatekey'];

    $privKeyPlain = $priv;
    $pubKeyPlain = $pub;
    $privKeyPlain =  str_replace($headerPrivKey,"", $privKeyPlain);    
    $privKeyPlain =  str_replace($trailerPrivKey,"", $privKeyPlain);     
    $privKeyPlain =  str_replace($trailerPrivKey2,"", $privKeyPlain);     
    $pubKeyPlain =  str_replace($headerPubKey,"", $pubKeyPlain);    
    $pubKeyPlain =  str_replace($trailerPubKey,"", $pubKeyPlain);     
    $pubKeyPlain =  str_replace($trailerPubKey2,"", $pubKeyPlain);     
    
    //print_r($key);

    $nl = '<br>';
    echo "Private Key:";    
    echo '<pre><code>';
    echo $priv;
    echo '</code></pre>';
    echo $nl;
   
    echo "Public Key:";
    echo '<pre><code>';
    echo $pub;
    echo '</code></pre>';

    $nl = '<br>';
    echo "Private Key Plain:";    
    echo '<pre><code>';
    echo $privKeyPlain;
    echo '</code></pre>';
    echo $nl;
   
    echo "Public Key Plain:";
    echo '<pre><code>';
    echo $pubKeyPlain;
    echo '</code></pre>';

    echo '<hr>';
    echo "\n=======\n\n";
    $rsa = new RSA();
    $rsa->setPrivateKeyFormat(RSA::PRIVATE_FORMAT_XML);
    $rsa->setPublicKeyFormat(RSA::PUBLIC_FORMAT_RAW);
    //define('CRYPT_RSA_EXPONENT', 65537);
   // $rsax->setPublicKeyFormat(RSA::PUBLIC_FORMAT_RAW);    

    $key = $rsa->createKey(1024);
    //print_r($key);
    $pubModulus = $key['publickey']['n'];
    $pubExponent = $key['publickey']['e'];
    $priv = $key['privatekey'];
    $pubModulus = new BigInteger($pubModulus);
    $pubExponent = new BigInteger($pubExponent);
    $pubModulus = $pubModulus->toHex();
    $pubExponent = $pubExponent->toHex();

    $xml=simplexml_load_string($priv) or die("Error: Cannot create object");
    echo $nl.$nl;
    echo "PRIV XML: ";
    print_r($xml);
    echo $nl.$nl;
    
    echo "D:";
    echo '<pre><code>';
    echo $xml->D;
    echo '</code></pre>';

    echo "Public Key 2 Modulus (HEX):";
    echo '<pre><code>';
    echo $pubModulus;
    echo '</code></pre>';

    echo "Public Key 2 Exponent (HEX):";
    echo '<pre><code>';
    echo $pubExponent;
    echo '</code></pre>';

    echo "Private Key 2:";
    echo '<pre><code>';
    echo $priv;
    echo '</code></pre>';



   // echo $modulus;
   // echo $nl;
    //echo $exponent;

    //$rsay->loadKey(array('n' => $modulus, 'e' => $exponent));

    /*
    $e = new BigInteger($rsax->createKey(1024)['publickey'], 256);
    $n = new BigInteger(base64_decode(65537), 6);
    echo $e;
    echo "<br>";
    echo $n;
    */
   /* $rsa->setPrivateKeyFormat(RSA::PRIVATE_FORMAT_PKCS8);
    $rsa->setPublicKeyFormat(RSA::PRIVATE_FORMAT_PKCS8);
 
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

    $rsa->loadKey($myPrivKey); // private key
    $decrypted = $rsa->decrypt($ciphertext);
    echo "<br><br>Decrypted Text<br>============<br>";
    echo $decrypted;
*/
    //return $privatekey;
});

$router->get('/tes', function () use ($router) {
    
        $nl = "<br>";
        /*$headerPrivKey = "-----BEGIN RSA PRIVATE KEY-----";
        $trailerPrivKey = "\n-----END RSA PRIVATE KEY-----";
        $trailerPrivKey2 = "-----END RSA PRIVATE KEY-----";
        $headerPubKey = "-----BEGIN RSA PUBLIC KEY-----";
        $trailerPubKey = "\n-----END RSA PUBLIC KEY-----";
        $trailerPubKey2 = "-----END RSA PUBLIC KEY-----";
        define('CRYPT_RSA_EXPONENT', 65537);*/        
        $rsa = new RSA();
        $rsa->setPrivateKeyFormat(RSA::PRIVATE_FORMAT_XML);
        $rsa->setPublicKeyFormat(RSA::PUBLIC_FORMAT_RAW);
    
        $key = $rsa->createKey(1024);

        $publicKey = $key['publickey'];
        $privateKey = simplexml_load_string($key['privatekey']) or die("Error: Cannot create object");

        $n = $publicKey['n'];
        $e = $publicKey['e'];
        $d = $privateKey->D;

        $nHex = new BigInteger($n);
        $eHex = new BigInteger($e);
        //$dHex = new BigInteger($d);
        $nHex = $nHex->toHex();
        $eHex = $eHex->toHex();
        //$dHex = $d->toHex();

        echo $nl.$nl;        
        echo "pub mentah:";
        echo '<pre><code>';
        echo print_r($publicKey);
        echo '</code></pre>';

        echo $nl.$nl;        
        echo "priv mentah:";
        echo '<pre><code>';
        echo print_r($privateKey);
        echo '</code></pre>';

        echo $nl.$nl;        
        echo "n (Plain):";
        echo '<pre><code>';
        echo $n;
        echo '</code></pre>';
    
        echo $nl.$nl;        
        echo "e (Plain):";
        echo '<pre><code>';
        echo $e;
        echo '</code></pre>';
    
        echo $nl.$nl;        
        echo "d (Plain):";
        echo '<pre><code>';
        echo $d;    
        echo '</code></pre>';

        echo $nl.$nl;        
        echo "n (Hex):";
        echo '<pre><code>';
        echo $nHex;
        echo '</code></pre>';
    
        echo $nl.$nl;        
        echo "e (Hex):";
        echo '<pre><code>';
        echo $eHex;
        echo '</code></pre>';
    
        echo $nl.$nl;        
        echo "d (Hex):";
        echo '<pre><code>';
        //echo $dHex;    
        echo '</code></pre>';

    
    });