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
	$client = new Client([
	    // Base URI is used with relative requests
	    'base_uri' => 'http://jxxx.ncut.edu.cn',
	    // You can set any number of default request options.
	    //'timeout'  => 2.0,
	]);
	$jar = new \GuzzleHttp\Cookie\CookieJar;
	$request=$client->post('login.asp');
	$response = $client->request('POST', 'http://jxxx.ncut.edu.cn/login.asp', [
		'headers'=>[
			//'Content-Type'=>'application/x-www-form-urlencoded',
			'User-Agent'=>'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2970.0 Safari/537.36',
			'Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
			'Accept-Encoding'=>'gzip, deflate',
			'Accept-Language'=>'zh-CN,zh;q=0.8',
			'Cache-Control'=>'max-age=0',
			'Connection'=>'keep-alive',
			'Content-Type'=>'application/x-www-form-urlencoded',
			//'Content-Length'=>'65',
			'Host'=>'jxxx.ncut.edu.cn',
			'Origin'=>'http://jxxx.ncut.edu.cn',
			'Referer'=>'http://jxxx.ncut.edu.cn/',
			'Upgrade-Insecure-Requests'=>'1',

		],
	    'form_params' => [
	        'category'=>'xs',
	        'uid'=>'14103020114',
	        'passwd'=>'052421',
	        'Submit.x'=>'2',
	        'Submit.y'=>'1'
	    ],
	    'allow_redirects'=>false,
	    'cookies'=>$jar
	    //'body'=>'category=xs&uid=13101040319&passwd=202215&Submit.x=23&Submit.y=14'
	]);
	//var_dump($response);
	//echo $response->getStatusCode();
	var_dump($jar);
	$response=$client->get('xs/cjkb.asp?id=5',['cookies'=>$jar]);
	echo iconv("gbk", "utf-8", strip_tags($response->getBody(),'<td>,<tr>,<table>,<th>'));
});
