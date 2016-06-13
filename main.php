<?php

require 'vendor/autoload.php';
use Symfony\Component\DomCrawler\Crawler;
/**
 * Created by PhpStorm.
 * User: shellus
 * Date: 2016-06-06
 * Time: 15:33
 */
date_default_timezone_set('Asia/Shanghai');

// 如果在9点-21点间，则允许允许，需配合cron或计划任务使用
if((int)date('H',time()) < 9 || (int)date('H',time()) > 22){
    var_dump("hour:".date('H',time())." so not run");
    exit(0);
};



// 载入.env 配置
foreach (explode(PHP_EOL,file_get_contents('./.env')) as $evn){
    putenv(trim($evn));
}


/**
 * @param $url
 * @param string $method
 * @param array $data
 * @param array $headers
 * @return \anlutro\cURL\Request
 */
function curl($url, $method = 'GET', $data = [], $headers = [])
{
    $request = (new \anlutro\cURL\cURL) -> newRequest($method, $url, $data);
    foreach ($headers as $key => $value){
        $request -> setHeader($key, $value);
    }
    return $request;
}

/**
 * @param $phone
 * @param $content
 * @return string
 */
function sms_send($phone, $content){
    $url = "http://api.smsbao.com/sms?u=".getenv('SMS_USERNAME')."&p=".md5(getenv('SMS_PASSWORD'))."&m={$phone}&c=" . urlencode("【专属好心情】今天段子已送到:\n$content\n退订请在1秒内回复TD退订");
    var_dump($url);
    return curl($url) -> send()->body;
}

/**
 * @return string
 */
function get_qiubai_html(){
    $data = curl('http://www.qiushibaike.com/', 'GET', [], [
        'User-Agent'    => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36',
        'Accept'        => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    ]);
    return $data -> send() ->body;
}

$html = get_qiubai_html();
$crawler = new Crawler($html);
$c = $crawler->filter('.article div.content') -> getNode((int)date('H',time())%20) -> textContent;
var_dump($c);
$body = sms_send(getenv('SEND_PHONE'), $c);
var_dump($body);
exit((int)$body);


