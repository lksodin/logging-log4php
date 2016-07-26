<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements. See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * An Appender that automatically creates a new logfile each day each server
 * (by server ip).
 *
 * The file is rolled over once a day. That means, for each day a new file
 * is created. A formatted version of the date pattern is used as to create
 * the file name using the {@link PHP_MANUAL#sprintf} function.
 *
 * This appender uses a layout.
 *
 * @version $Revision$
 * @package log4php
 * @subpackage appenders
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */
class LoggerAppenderServerDailyFile extends LoggerAppenderDailyFile {

  /**
   * Determines target file. Replaces %d in file path with a date.
   * Replaces %s in file path with a server ip or uname -n.
   */
  protected function getTargetFile()
  {
    $replace_map = array(
      '%d' => $this->currentDate,
      '%s' => $this->getServerIdentification()
    );
    return str_replace(array_keys($replace_map), array_values($replace_map), $this->file);
  }

  /**
   * Returns the server identification.
   * @return string
   */
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
