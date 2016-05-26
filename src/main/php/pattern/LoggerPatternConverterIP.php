<?php
/**
 */
class LoggerPatternConverterIP extends LoggerPatternConverter
{
  const SIMPLE = 0;
  const INDEXED = 1;
  const DETAIL = 2;

  private $format = self::SIMPLE;
  private $levels = array(
    'simple' => self::SIMPLE,
    'indexed' => self::INDEXED,
    'detail' => self::DETAIL
  );

  private $ip_index_map = array(
    'HTTP_CLIENT_IP',
    'HTTP_X_FORWARDED_FOR',
    'HTTP_X_FORWARDED',
    'HTTP_X_CLUSTER_CLIENT_IP',
    'HTTP_FORWARDED_FOR',
    'HTTP_FORWARDED',
    'REMOTE_ADDR',
    //'HTTP_VIA'
  );

  public function activateOptions()
  {
    // Parse the option (detail level)
    if (!empty($this->option)) {
      if(isset($this->levels[$this->option])) {
        $this->format = $this->levels[$this->option];
      }
    }
  }

  public function convert(LoggerLoggingEvent $event)
  {
    return $this->getClientIpInfo();
  }

  private function getClientIpInfo()
  {
    switch($this->format){
      case self::INDEXED :
        return $this->getClientIpWithIndex();
      break;

      case self::DETAIL :
        return $this->getFullClientIpInfo();
      break;

      case self::SIMPLE :
      default:
        return $this->getClientIp();
    }
  }

  protected function getClientIpArray()
  {
    $client_ip = array();

    foreach($this->ip_index_map as $index) {
      if (isset($_SERVER[$index])) {
        $client_ip[$index] = $_SERVER[$index];
      }
    }

    return $client_ip;
  }

  protected function getClientIp()
  {
    foreach($this->getClientIpArray() as $val) {
      return $val;
    }

    return '';
  }

  protected function getClientIpWithIndex()
  {
    foreach($this->getClientIpArray() as $key => $val) {
      return "{$key}:{$val}";
    }

    return '';
  }


  protected function getFullClientIpInfo()
  {
    $client_ip = array();

    foreach($this->getClientIpArray() as $key => $val) {
      $client_ip[] = "{$key}:{$val}";
    }

    return implode(',', $client_ip);
  }
}
