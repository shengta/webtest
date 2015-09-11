<?
define('ROOT_PATH','/var/www/html/fb2get.com/kkplay/');
define('CLASS_PATH','/var/www/html/fb2get.com/kkplay/lib/');

//billing
$_config['payment']['mycard']['test']['billing']['FactoryId']      = 'kkptq';
$_config['payment']['mycard']['test']['billing']['AuthUrl']        = 'http://test.b2b.mycard520.com.tw/MyCardBillingRESTSrv/MyCardBillingRESTSrv.svc/Auth/{ServiceId}/{TradeSeq}/{PaymentAmount}';
$_config['payment']['mycard']['test']['billing']['MyCardUrl']      = 'http://test.mycard520.com.tw/MyCardBilling/';

//ingame
$_config['payment']['mycard']['test']['ingame']['facId'] = 'GFD2122';
$_config['payment']['mycard']['test']['ingame']['KEY1'] = 'mykkptq';
$_config['payment']['mycard']['test']['ingame']['KEY2'] = 'kkplaytw0000';
$_config['payment']['mycard']['test']['ingame']['AuthUrl']    = 'http://test.b2b.mycard520.com.tw/MyCardIngameService/Auth/';
$_config['payment']['mycard']['test']['ingame']['IngameUrl']  = 'http://test.mycard520.com.tw/MyCardIngame/';

//MyCard登入與點數服務1.3.6.pdf
$_config['payment']['mycard']['test']['point']['FactoryId']        = 'MFD0000537';
$_config['payment']['mycard']['test']['point']['FactoryServiceId'] = 'MFSD001226';
$_config['payment']['mycard']['test']['point']['AuthUrl']          = 'http://test.b2b.mycard520.com.tw/MyCardPointPaymentServices/MyCardPpServices.asmx/MyCardMemberServiceAuth?FactoryId={FactoryId}&FactoryServiceId={FactoryServiceId}&FactorySeq={FactorySeq}&PointPayment={PointPayment}&FactoryReturnUrl={FactoryReturnUrl}&BonusPayment=0';
$_config['payment']['mycard']['test']['point']['MyCardUrl']        = 'http://test.member.mycard520.com.tw/MemberLoginService';
$_config['payment']['mycard']['test']['point']['ReturnUrl']        = 'http://kkplay.fb2get.com/stored_point_return.php';


$_config['mysql']['host'] = 'localhost';
$_config['mysql']['user'] = 'kkplay';
$_config['mysql']['pass'] = 'mykkptq';
$_config['mysql']['lang'] = 'UTF8';
$_config['mysql']['db']   = 'kkplay';

/*
<MyCard會員扣點測試>

會員帳號/密碼          

ricky@soft-world.com.tw /  85239288   / 安全代碼: sw81231585  //有點數帳號，可進行扣點支付

wu543wu543@gmail.com  /  qqwpp543345  / 安全代碼: wu1111   //無點數帳號，專門檢測錯誤訊息顯示，請勿灌點!!

///////////////////////////////////////////////////////////////////////////

<Billing測試>
支付工具請選用===>測試金流 （測試金流為一個虛擬的金流，不會實際需要支付款項）

測試教學如下：     
第一步驟：輸入手機10個號碼（提供手機號碼以便後續交易紀錄查詢）
第二步驟：捐贈發票（請選擇預設的「捐贈發票」）
第三步驟：輸入驗證碼（請輸入「 sw27889188 」，即為交易成功；若輸入「 27889188 」，即為交易失敗，可用來檢測錯誤訊息顯示）
///////////////////////////////////////////////////////////////////////////
<In Game測試>    
測試環境專用的MyCard測試卡序號密碼（面額為150元）
MCARAZ0000003205   5RXH5KFPAW766Q83
MCARAZ0000003206   R545H6T6PQQHD935
*/

function set_log()
{
  ob_start();
  print_r($_POST);
  print_r($_GET);
  $html = ob_get_contents();
  ob_end_clean();
  
  $file = ROOT_PATH.'payment/log/'.str_replace(array('/payment/','.php'),'',$_SERVER['SCRIPT_NAME']).'_'.date('YmdHis');
  file_put_contents($file,$html);
}

function conf($type=''){
  global $_config;
  if($type == '') return $_config;
  return $_config[$type];
}

function __autoload($classname)
{
	if(!CLASS_PATH) die('CLASS_PATH ERROR');
		
	if(is_file(CLASS_PATH.$classname.'.class.php'))
	{
	  include_once CLASS_PATH.$classname.'.class.php';
	}else{
	  $classname = str_replace('\\','/',$classname);
    include_once CLASS_PATH.$classname.'.php';
  }
}


function pre($arr){
  echo '<pre>';
  print_r($arr);
  echo '</pre>';
}

function get_content($url,$post_data='')
{  
  $ch = curl_init();
  $options[CURLOPT_URL] = $url;
  $options[CURLOPT_HEADER]=0;
  $options[CURLOPT_VERBOSE]=0;
  $options[CURLOPT_FAILONERROR]=1;
  $options[CURLOPT_FOLLOWLOCATION]=1;
  $options[CURLOPT_RETURNTRANSFER]=1;
  $options[CURLOPT_USERAGENT]='User-agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0';
  
  $options[CURLOPT_TIMEOUT]=30;
  
  if(preg_match('/^https/',$url))
  {
    $options[CURLOPT_SSL_VERIFYHOST] = 0;
  	$options[CURLOPT_SSL_VERIFYPEER] = 0;
  }

  if($post_data != '')
  {
    $options[CURLOPT_POST] = 1;
    $options[CURLOPT_POSTFIELDS] = http_build_query($post_data);
  }
  
  curl_setopt_array($ch,$options);
  $res = curl_exec($ch);
  curl_close($ch);
  return $res;
}

function get_ip(){
  if (!empty($_SERVER['HTTP_CLIENT_IP']))
      $ip=$_SERVER['HTTP_CLIENT_IP'];
  else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  else
      $ip=$_SERVER['REMOTE_ADDR'];
  return $ip;
}

function href($url,$target = 'top')
{
  if($target != '') $target .= '.';
  echo '<script>';
  if($url == -1)
  {
    echo 'history.go(-1);';
  }
  else
  {
    echo $target.'location.href = "'.$url.'";';
  }
  echo '</script>';
  exit;
}

function alert($msg)
{
  echo '<script>';
  echo 'alert("'.$msg.'");';
  echo '</script>';
}