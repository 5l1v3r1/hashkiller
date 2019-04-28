<?php

/**
 *
 * @author Ardhana <zeebploit212@gmail.com>
 * @package API Hashkiller (MD5)
 *  
 */

require_once "vendor/autoload.php";
use \Hashkiller\MD5\Unhash;

$hashkiller = new Unhash;

header("Content-type: Application/Json");
header("Service-API: Hashkiller");
header("Version: 1.0 (Beta)");
header("Author: Ardhana <zeebploit212@gmail.com>");

if (isset($_GET["md5"])) {
    echo $hashkiller->crack($_GET["md5"])->json($hashkiller->getResult())->get();
}

else{
    echo $hashkiller->json(["success" => false, "error_msg" => "invalid parameter"])->get();
}

?>
