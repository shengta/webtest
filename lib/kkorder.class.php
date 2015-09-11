<?
class kkorder extends db{
  static $table = 'kkorder';
  var $setting;
  function __construct()
  {
    $_config = conf();
    parent::__construct();
  }
  
  
  function ins($data)
  {
    return parent::db_ins(self::$table,$data);
  }
  
  function upd($uid,$data)
  {
    return parent::db_upd(self::$table,$data,array('uid' => $uid));
  }
}