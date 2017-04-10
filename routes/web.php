<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use GuzzleHttp\Client;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/passport',function(){
	return view('passport');
});


/**
 * 这是一个标准的获取流程 当然 cookie应由某些东西维护
 */
Route::get('/test',function(){
	$client = new Client();
	$jar = new \GuzzleHttp\Cookie\CookieJar;
	$response = $client->request('POST', 'http://jxxx.ncut.edu.cn/login.asp', [
		'headers'=>[
			//'Content-Type'=>'application/x-www-form-urlencoded',
			'User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2970.0 Safari/537.36',
			//'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			//'Accept-Encoding'=>'gzip, deflate',
			//'Accept-Language'=>'zh-CN,zh;q=0.8',
			//'Cache-Control'=>'max-age=0',
			//'Connection'=>'keep-alive',
			'Content-Type'=>'application/x-www-form-urlencoded',
			//'Content-Length'=>'65',
			//'Host'=>'jxxx.ncut.edu.cn',
			//'Origin'=>'http://jxxx.ncut.edu.cn',
			'Referer'=>'http://jxxx.ncut.edu.cn/',
			//'Upgrade-Insecure-Requests'=>'1',

		],
	    'form_params' => [
	        'category'=>'xs',
	        'uid'=>'13101040319',
	        'passwd'=>'202215',
	        'Submit.x'=>'2',
	        'Submit.y'=>'1'
	    ],
	    'allow_redirects'=>true,
	    'cookies'=>$jar
	    //'body'=>'category=xs&uid=13101040319&passwd=202215&Submit.x=23&Submit.y=14'
	]);
	//$content=$response->getBody();
	//echo $response->getStatusCode();
    $client = new Client();
	$response=$client->get('http://jxxx.ncut.edu.cn/xs/cjkb.asp?id=1',['cookies'=>$jar]);
	$content=$response->getBody();
	$content=str_replace('&nbsp;','',iconv(mb_detect_encoding($content, ['ASCII','GB2312','GBK','UTF-8']), "utf-8",$content));
	$preg = '/<A href=javascript:popup\(\'\/cx\/xskb_detail\.asp\?xh=.*?&skxq=(\d)&skdy=(\d)&nd=\d{4}&jb=\w&js=(\d)\'\) style=\'color:blue\'>(.*?)<br>(.*?)<br><font style=\'color:#336633\'>\[.*?\]<br>\(([0-9]{0,2})-([0-9]{0,2})(.*?)\)<\/font><br>(.*?)<\/A>/';
    preg_match_all($preg, $content, $matcher);
    dump($matcher);
});

Auth::routes();

