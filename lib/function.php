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

//MyCard�n�J�P�I�ƪA��1.3.6.pdf
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
<MyCard�|�����I����>

�|���b��/�K�X          

ricky@soft-world.com.tw /  85239288   / �w���N�X: sw81231585  //���I�Ʊb���A�i�i�榩�I��I

wu543wu543@gmail.com  /  qqwpp543345  / �w���N�X: wu1111   //�L�I�Ʊb���A�M���˴����~�T����ܡA�Ф����I!!

///////////////////////////////////////////////////////////////////////////

<Billing����>
��I�u��п��===>���ժ��y �]���ժ��y���@�ӵ��������y�A���|��ڻݭn��I�ڶ��^

���ձоǦp�U�G     
�Ĥ@�B�J�G��J���10�Ӹ��X�]���Ѥ�����X�H�K�����������d�ߡ^
�ĤG�B�J�G���صo���]�п�ܹw�]���u���صo���v�^
�ĤT�B�J�G��J���ҽX�]�п�J�u sw27889188 �v�A�Y��������\�F�Y��J�u 27889188 �v�A�Y��������ѡA�i�Ψ��˴����~�T����ܡ^
///////////////////////////////////////////////////////////////////////////
<In Game����>    
�������ұM�Ϊ�MyCard���եd�Ǹ��K�X�]���B��150���^
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