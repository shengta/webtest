<?
class mycard extends db{
  static $table = 'mycard';
  static $test_mode = true;
  static $config = array();
  
  function __construct($type)
  {
    $_config = conf('payment');
    if(self::$test_mode) self::$config = $_config['mycard']['test'][$type];
    parent::__construct();
  }
  
  //billing
  //文件來源 MyCard Billing CP廠商介接文件1.8.4-Ch.En.pdf
  function billing($data)
  {
    //$data['order_uid'];//訂單編號
    //$data['amount'];//金額
    if(!$data['order_uid']) return false;
    if(!$data['amount'])    return false;
    if(!$data['ServiceId']) return false;
    

    //$url = str_replace('{ServiceId}',self::$config['FactoryId'],self::$config['BillingAuthUrl']);
    $url = str_replace('{ServiceId}',$data['ServiceId'],self::$config['AuthUrl']);
    $url = str_replace('{TradeSeq}',$data['order_uid'],$url);
    $url = str_replace('{PaymentAmount}',$data['amount'],$url);
    $rec_data = get_content($url);
    
    if($rec_data == '')
    {
      $ret['status'] = '404';
      $ret['data']   = 'connect error';
      return $ret;
    }
    /*
    Array
(
    [status] => 1
    [data] => Array
        (
            [0] => 1
            [1] => 授權成功
            [2] => MFF150907000023
            [3] => 3E600DAF476DDFF37BF42FCEF18A289732D2D69BD10F3599
        )

)
    */
    $rec = explode('|',strip_tags($rec_data));
    $ret['status'] = $rec[0];
    $ret['data'] = $rec;
    
    self::payment_log($data['order_uid'],$url,'',$rec_data);
    return $ret;
  }
  
  //點數交易
  function point($data)
  {
    if(!$data['order_uid']) return false;
    if(!$data['amount'])    return false;
    
    $url = str_replace('{FactoryId}',self::$config['FactoryId'],self::$config['AuthUrl']);
    $url = str_replace('{FactoryServiceId}',self::$config['FactoryServiceId'],$url);
    $url = str_replace('{FactoryReturnUrl}',urlencode(self::$config['ReturnUrl']),$url);
    $url = str_replace('{FactorySeq}',$data['order_uid'],$url);
    $url = str_replace('{PointPayment}',$data['amount'],$url);
    //echo $url.'<br>';
    $rec_data = get_content($url);
    preg_match('/<ReturnMsgNo>(.*?)<\/ReturnMsgNo>/',$rec_data,$MsgNo);
    preg_match('/<ReturnTradeSeq>(.*?)<\/ReturnTradeSeq>/',$rec_data,$ReturnTradeSeq);
    preg_match('/<ReturnAuthCode>(.*?)<\/ReturnAuthCode>/',$rec_data,$ReturnAuthCode);
    $ret['status'] = $MsgNo[1];
    $ret['data']['TradeSeq'] = $ReturnTradeSeq[1];
    $ret['data']['AuthCode'] = $ReturnAuthCode[1];
    self::payment_log($order_uid,$url,'',$rec_data);
    return $ret;
    
  }
  
  
  function auth($order_uid)
  {
    $url = self::$config['AuthUrl'].'?facId='.self::$config['facId'];
    $url .= '&facTradeSeq='.$order_uid;
    $url .= '&hash='.hash('sha256',self::$config['KEY1'].self::$config['facId'].$order_uid.self::$config['KEY2']);
    //echo $url.'<br>';
    $rec_data = get_content($url);
    
    self::payment_log($order_uid,$url,'',$rec_data);
    return $rec_data;
  }
  
  
  function payment_log($order_uid,$send_url,$post_data,$rec_data)
  {
    $ins['order_uid'] = $order_uid;
    $ins['send_data'] = json_encode(array('url'=>$send_url,'post'=>$post_data));
    $ins['rec_data']  = json_encode($rec_data);
    $ins['user_ip']   = get_ip();
    parent::db_ins('payment_log',$ins);
  }
}