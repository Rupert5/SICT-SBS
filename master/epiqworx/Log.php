<?php

/**
 * EpiqWorx by EpiQuadruple 
 * Licensed under the Epiquadruple General And Distribution License
 * Which You Can Find On https://epiquadruple.org
 */

namespace epiqworx;

/**
 * Description of Log
 * Writes and Edits Log text file.
 */
class Log {

    /**
     * Path to Log Folder.
     * NB: Make Sure That Write Permissions are on. 
     * @var string
     */
    private $path = '/epiqworx/log/';

    /**
     * Sets Time Zone on Instantiation 
     */
    function __construct() {
        date_default_timezone_set('Africa/Johannesburg');
        $this->path = dirname(dirname(__FILE__)) . $this->path;
    }

    /**
     * 	Creates the log
     *
     *   @param string $message the message which is written into the log.
     * 	@description:
     * 	 1. Checks if directory exists, if not, create one and call this method again.
     * 	 2. Checks if log already exists.
     * 	 3. If not, new log gets created. Log is written into the logs folder.
     * 	 4. Logname is current date(Year - Month - Day).
     * 	 5. If log exists, edit method called.
     * 	 6. Edit method modifies the current log.
     */
    public function write($message) {
        $date = new \DateTime();
        $log = $this->path . $date->format('Y-m-d') . ".md";
        if (is_writable(dirname($this->path))) {
            if (is_dir($this->path)) {
                if (!file_exists($log)) {$fh = fopen($log, 'a+');fclose($fh);}
                if (!file_exists($log)) {
                    return false;
                } else {
                    $this->edit($log, $date, $message);
                }
            } else {
                if (mkdir($this->path, 0777) === true) {
                    $this->write($message);
                }
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     *  Gets called if log exists. 
     *  Modifies current log and adds the message to the log.
     *
     * @param string $log
     * @param DateTimeObject $date
     * @param string $message
     */
    private function edit($log, $date, $message) {
        $logcontent = "Time : " . $date->format('H:i:s') . "\r\n" . $message . "\r\n\r\n";
        $logcontent = $logcontent . file_get_contents($log);
        file_put_contents($log, $logcontent);
    }

}
