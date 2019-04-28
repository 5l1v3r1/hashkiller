<?php

/**
 *
 * @author Ardhana <zeebploit212@gmail.com>
 * @package API Hashkiller (MD5)
 *  
 */

namespace Hashkiller\MD5;

use \Http\Request\GET;
use \Http\Request\POST;
use \Http\Request\HttpRequest;

class Unhash extends HttpRequest{

    function hashtoolkit($str){
        $this->website = "hashtoolkit.com";
        $GET = new GET;
        $GET->set_url = "https://hashtoolkit.com/reverse-hash/?hash={$str}";
        $GET->execute();
        $get = $GET->getBody();

        if (!$get or preg_match("/No hashes found for/i", $get)) {
            $this->success = false;
            $this->result  = null;
            $this->time = null;
            return $this;
        }else{
            $this->success = true;
            $this->result  = $this->get_string($get, 'Hashes for: <code>', '</code>');
            $this->time = $GET->getTotalTime();
            return $this;
        }
    }

    function md5decrypt_net($str){
        $this->website = "md5decrypt.net";

        $POST = new POST;
        $POST->set_url = 'https://md5decrypt.net/en/';
        $POST->set_parameter = "hash={$str}&decrypt=Decrypt";

        $headers = [];
        $headers[] = 'Origin: https://md5decrypt.net';
        $headers[] = 'Upgrade-Insecure-Requests: 1';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36';
        $headers[] = 'Referer: https://md5decrypt.net/en/';
        $POST->set_headers = $headers;
        $POST->execute();
        $result = $POST->getBody();
        if (preg_match("/Found in/i", $result) and $result) {
            $cracked = $this->get_string($result, "</div><br/>{$str} : <b>","</b>");
            $this->success = true;
            $this->result  = $cracked;
            $this->time = $POST->getTotalTime();
            return $this;
        }else{
            $this->success = false;
            $this->result  = null; 
            return $this;
        }
    }

    function crack($str){
        $md5decrypt_net = $this->md5decrypt_net($str);
        if ($md5decrypt_net->success) {
            return $md5decrypt_net;
        }

        $hashtoolkit = $this->hashtoolkit($str);
        if($hashtoolkit->success){
            return $hashtoolkit;
        }
        $this->website = null;
        return $this;
    }

    function getResult(){
        return [
            "website" => $this->website,
            "success" => $this->success,
            "result" => $this->result,
            "time" => $this->time
        ];
    }
}
?>