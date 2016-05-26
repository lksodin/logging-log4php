<?php
class LoggerAppenderServerDailyFile extends LoggerAppenderDailyFile {

  protected function getTargetFile() {
    $replace_map = array(
      '%d' => $this->currentDate,
      '%s' => $this->getServerIdentification()
    );
    return str_replace(array_keys($replace_map), array_values($replace_map), $this->file);
  }

  protected function getServerIdentification()
  {
    if(isset($_SERVER['SERVER_ADDR'])) {
      return $_SERVER['SERVER_ADDR'];
    } elseif (function_exists('php_uname')) {
      return php_uname('n');
    } else {
      return '';
    }
  }
}
