<?php
/**
 * A sequence number 用來辨識在同一個log檔中，多行的message是否由同一個process寫入
 */
class LoggerPatternConverterSequence extends LoggerPatternConverter {

  const RAND_STARTS = 10000;

  const RAND_ENDS = 99999;

  private $sequence = null;

  public function convert(LoggerLoggingEvent $event)
  {
    if ($this->sequence === null) {
      $this->sequence = sprintf('%s%s', time(), $this->randNum());
    }

    return $this->sequence;
  }

  private function randNum()
  {
    return rand(self::RAND_STARTS, self::RAND_ENDS);
  }
}
