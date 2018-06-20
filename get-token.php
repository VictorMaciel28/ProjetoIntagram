<?php
// Send a http request using curl
function getToken(){
     $username='d86f4162-ebb8-4db2-96d8-4f2819f2b712';
     $password='ykjAL20bmlcJ';
     $URL='https://gateway.watsonplatform.net/authorization/api/v1/token?url=https://gateway.watsonplatform.net/tone-analyzer/api';

     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $URL);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
     curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
     curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
     curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

     $result=curl_exec ($ch);
     curl_close ($ch);
     return $result;
}
echo getToken();
?>