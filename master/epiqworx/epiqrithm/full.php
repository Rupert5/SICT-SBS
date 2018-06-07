<?php

//---------------------------------------------------DEFINE GLOBAL PATH CONSTANT
$phpSelf = explode('/', filter_input(INPUT_SERVER, 'PHP_SELF'));
if (empty($level)) {
    $level = 1;
}   //----------------------------------------------website hierachy
$temp = "";
for ($k = 1; $k < count($phpSelf) - $level; $k++) {
    $temp .= '/' . $phpSelf[$k];
}
define('ROOT', $temp);
define('PATH', "http://" . filter_input(INPUT_SERVER, 'HTTP_HOST') . ROOT);

abstract class Convert {

    //<editor-fold desc="Binary-Decimal" defaultstate="collapsed">
    public static function decimalToBinary($aug, $bits) {
        $digit = antiWhiteSpace($aug);  //clear any possible whitespaces from argument
        if (empty($digit)) {
            return null;
        }    //ignore whole function if test value is NULL
        else if (!is_numeric($digit)) {
            return 1;
        }
        $binary = "";   //string to be used to concatenate '1's and '0's based on exponential factors equivalent
        for ($k = 0; $k < $bits; $k++) {
            if ($digit >= pow(2, ($bits - 1) - $k)) {
                $binary .= "1";
                $digit -= pow(2, ($bits - 1) - $k);
            } else {
                $binary .= "0";
            }
        }
        return $binary;
    }

    public static function binaryToDecimal($binary) {
        if (!isset($binary)) {
            return NULL;
        }
        $val = 0;   //variable to be used to accumulate exponential equivalents of the '1's in the binary
        for ($k = 0; $k < strlen($binary); $k++) {
            if (substr($binary, $k, 1) == '1') {
                $val += pow(2, (strlen($binary) - 1) - $k);
            }
        }
        return $val;
    }

//</editor-fold>
}

abstract class Text {

//<editor-fold desc="Text Formatting" defaultstate="collapsed">
    public static function phoneFormat($text) {
        $txt = antiWhiteSpace($text);
        if (strlen($txt) == 10) {
            return "(" . substr($txt, 0, 3) . ") " . substr($txt, 3, 3) . " - " . substr($txt, 6, 4);
        }
        return $text;
    }

    public static function currency($value, $symbol) {
        $value = explode('.', $value);
        $string = "";
        $count = 0;
        for ($k = (strlen($value[0]) - 1); $k >= 0; $k--) {
            if ($count == 3) {
                $count = 0;
                $string .= " " . $value[0][$k];
            } else {
                $count++;
                $string .= $value[0][$k];
            }
        }
        $string = strrev($string);
        return "$symbol $string." . $value[1];
    }

    public static function reversePhoneFormat($text) {
        $txt = antiWhiteSpace($text);
        if (strlen($txt) == 13) {
            return substr($txt, 1, 3) . substr($txt, 5, 3) . substr($txt, 9, 4);
        }
        return $text;
    }

    public static function isEmail($txt) {
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $txt)) {
            return false;
        }
        return true;
    }
    public static function isName($txt){
        if (!preg_match("/^([a-zA-Z' ]+)$/", $txt)) {
            return false;
        }
        return true;
    }
    public static function isNamePlus($text,$min=1,$max=20){
        $text = trim($text);
        if(strlen($text)<$min){            return "minimum character length: $min";}
        if(strlen($text)>$max){            return "maximum character length: $max";}
        if(!preg_match("/^([a-zA-Z' ]+)$/", $text)){            return "name not valid";}
        return 'success';
    }
    public static function isAlphabet($value){
        $value = strtoupper(self::antiWhiteSpace($value));
        foreach (str_split($value) as $c){
            if(ord($c) < 65 || ord($c) > 90){                return false;}
        }
        return true;
    }
    public static function isSymbol($char){
        $char = self::antiWhiteSpace($char);
        foreach (str_split($char) as $c){
            if(ord($c) < 48 || (ord($c) > 57 && ord($c) < 65) || (ord($c) > 90 && ord($c) < 97) || ord($c)>122){                return true;}
        }
        return false;
    }

//</editor-fold>
//<editor-fold desc="Integral Validation" defaultstate="collapsed">
    public static function isInt($txt) {
        $txt = self::antiWhiteSpace($txt);    //remove whitspaces, for they have an ASCII equivalent of 32
        if (empty($txt)) {
            return false;
        }    //exit function if value is left NULL
        foreach (str_split($txt) as $a) {
            if (ord($a) < 48 || ord($a) > 57) {
                return false;
            }
        }   //break string into array to test characters at a time. ASCII numeric range 48 - 57
        return true;
    }

    public static function containsInt($text) {
        foreach (str_split($text . "") as $a) {
            if (ord($a) >= 48 && ord($a) <= 57) {
                return true;
            }
        }   //break string into array to test characters at a time. ASCII numeric range 48 - 57
        return false;
    }

//</editor-fold>
//<editor-fold desc="antiWhiteSpace" defaultstate="collapsed">
    /* -These Functions perform whitespace bypassing tasks
     * -Remove white-spaces from string
     */
    public static function antiWhiteSpace($text) {  //take string as a parameter, remove white-spaces, then return it
        if (empty($text)) {
            return NULL;
        }    //exit function if argument is not initialized
        $txt = "";
        foreach (str_split($text) as $a) {
            if (ord($a) != 32) {
                $txt .= $a;
            }
        } //break string into array to test characters at a time. Append char to running string if !whitespace
        return $txt;
    }

    public static function textLength($text) {  //count string length excluding white-spaces
        $txt = "";
        foreach (str_split($text . "") as $a) {
            if (ord($a) != 32) {
                $txt .= $a;
            }
        } //break string into array to test characters at a time. Append char to running string if !whitespace
        return strlen($txt);
    }

    public static function isNull($text) {
        if (strlen($text) < 1) {
            return true;
        } else {
            return false;
        }
    }

//</editor-fold>
//<editor-fold desc="crypt" defaultstate="collapsed">
    public static function encrypt($data,$key){
        $encryption_key = base64_decode($key);  //  ---------------------------- remove base64 encodeing from key
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher="AES-256-CBC")); //  generate an initialization vector
        $encrypted = openssl_encrypt($data,$cipher,$encryption_key,0,$iv);  //-- encrypt data using AES 256 encryption in CBC mode using encryption key and initialization vector.
        return base64_encode($encrypted.'::'.$iv);
    }
    public static function decrypt($data,$key){
        $encryption_key = base64_decode($key);  //  ---------------------------- remove base64 encodeing from key
        list($encryption_data,$iv) = explode('::',base64_decode($data),2);  //-- split encrypted data from IV - unique seperator used was '::'
        return openssl_decrypt($encryption_data,'AES-256-CBC',$encryption_key,0,$iv);
    }
//</editor-fold>
}

abstract class Filter {

    // replace any non-ascii character with its hex code.
    public static function escape($string) {
        $return = '';
        for ($i = 0; $i < strlen($string); ++$i) {
            $char = $string[$i];
            $ord = ord($char);
            if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126) {
                $return .= $char;
            } else {
                $return .= '\\x' . dechex($ord);
            }
        }
        return $return;
    }

    public static function reverse_escape($string) {
        $return = '';
        for ($i = 0; $i < strlen($string); ++$i) {
            $char = $string[$i];
            $ord = ord($char);
            if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126) {
                $return .= $char;
            } else {
                $return .= '\\x' . dechex($ord);
            }
        }
        return $return;
    }

    public static function html_escape($html_escape) {
        $html_escape = htmlspecialchars($html_escape, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return $html_escape;
    }

}

abstract class Dates {

    const MONTH = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

    public static function genDate($start, $end) {
        if (($start < 1 || $start > 31) || ($end < 1 || $end > 31)) {
            return false;
        }
        $set = array();
        for ($k = $start; $k <= $end; $k++) {
            array_push($set, $k);
        }
        return $set;
    }

    public static function genYear($start, $end) {
        $set = array();
        for ($k = $start; $k <= $end; $k++) {
            array_push($set, $k);
        }
        return $set;
    }

    public static function isLeapYear($year) {
        if (($year % 400 == 0) || (($year % 4 == 0) && ($year % 100 != 0))) {
            return true;
        } else {
            return false;
        }
    }

    public static function getDays($month) {
        $days = array();
        $today = new \DateTime();

        if (Dates::isLeapYear($today->format('Y'))) {
            $days = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        } else {
            $days = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        }
        return $days[$month - 1];
    }

}

abstract class Debug {

    public static function testPrint($text) {

        $display = dirname(__FILE__, 1) . DIRECTORY_SEPARATOR . "troubleshooting.md";
        if (file_exists($display) && is_writable($display)) {
            $handle = fopen($display, 'w');
            fwrite($handle, $text);
            fclose($handle);
        } else {
            return array("Could not write file $display");
        }
    }

    /**
     * Writes the log and returns the exception
     * @param  string $message
     * @param  string $sql
     * @return string
     */
    public static function ExceptionLog($message, $sql = "") {
        $log = new epiqworx\Log();
        $exception = 'Unhandled Exception. <br />';
        $exception .= $message;
        $exception .= "<br /> You can find the error back in the log.";
        if (!empty($sql)) {
            $message .= "\r\nRaw SQL : " . $sql; # Add the Raw SQL to the Log
        }try {
            # Write into log
            if (!$log->write($message)) {
                throw new Exception($message);
            }
        } catch (Exception $ex) {
            return array("could not write log file");
        }
        return $exception;
    }

}

abstract class File {
    
    public static function dumpToken($userdir, $token) {
        if (!is_dir($userdir) && !mkdir($userdir, 0777, true)) {
            return false;
        }
        if (!($handle = fopen("$userdir/token.tmp", "w"))) {
            return false;
        }
        fwrite($handle, $token);
        fclose($handle);
        return true;
    }

    public static function dumpKey($userdir, $bytes) {
        if (!is_dir($userdir) && !mkdir($userdir, 0777, true)) {
            return false;
        }
        if (!($handle = fopen("$userdir/key", "w"))) {
            return false;
        }
        fwrite($handle, base64_encode(openssl_random_pseudo_bytes($bytes)));
        fclose($handle);
        return true;
    }

    public static function readToken($file) {
        if (file_exists($file) && ($handle = fopen($file, "r"))) {
            $token = fread($handle, filesize($file));
            fclose($handle);
        } else {
            return 'error';
        }
        return $token;
    }
    
    public static function recurseRmdir($dir){
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file){
            (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    
    public static function uploadFile($fileinput, $upload_dir, array $valid_extensions, $filename = null, $maxsize = 5000000) {
        try {
            $imgFile = $_FILES["$fileinput"]['name'];
            $tmp_dir = $_FILES["$fileinput"]['tmp_name'];
            $imgSize = $_FILES["$fileinput"]['size'];
            if (!file_exists("$upload_dir")) {
                if (!mkdir($upload_dir, 0777, true)) {
                    return array("Directory $upload_dir could not be created");
                }
            }
            if ($imgFile) {
                $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension
                if ($filename === null) {
                    $filename = rand(1000, 1000000) . "." . $imgExt;
                    while (file_exists($upload_dir . $filename)) {
                        $filename = rand(1000, 1000000) . "." . $imgExt;
                    }
                } else {
                    $filename = $filename . '.' . $imgExt;
                }
                if (in_array($imgExt, $valid_extensions)) {
                    if ($imgSize < $maxsize) {
                        move_uploaded_file($tmp_dir, $upload_dir . $filename);
                    } else {
                        return array("ile Size Exceeds Maximum upload size");
                    }
                } else {
                    $extError = implode(',', $valid_extensions);
                    return array("Only $extError files are allowed");
                }
                return $filename;
            }
        } catch (RuntimeException $ex) {
            return array($ex->getMessage());
        }
    }

    public static function uploadIMG($fileinput, $path, $file, $square, $sizelimit = null) {
        try {
            if (File::isPostSizeExceeded()) {
                throw new RuntimeException('Exceeded filesize limit$$upload_max_filesize:' . File::iniGetBytes('upload_max_filesize') . " bytes;post_max_size:" . File::iniGetBytes('post_max_size') . " bytes;current content:<b>" . $_SERVER['CONTENT_LENGTH'] . " bytes</b>");
            }
            //  Undefined | Multiple Files | $_FILES Corruption Attack
            //  If this request falls under any of them, threat it invalid.
            if (!isset($_FILES[$fileinput]['error']) || is_array($_FILES[$fileinput]['error'])) {
                throw new RuntimeException('Invalid parameters.');
            }
            // Check  $_FILES['imgPath']['error'] value.
            switch ($_FILES[$fileinput]['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                    break;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit$$upload_max_filesize:' . ini_get('upload_max_filesize') . ";post_max_size:" . ini_get('post_max_size'));
                    break;
                default :
                    throw new RuntimeException('Invalid parameters.');
                    break;
            }
            // test filesize
            if (isset($sizelimit)) {
                if ($_FILES['imgPath']['size'] > $sizelimit) {
                    throw new RuntimeException('Exceeded filesize limit.');
                }
            }
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search($finfo->file($_FILES['imgPath']['tmp_name']), array('jpg' => 'image/jpeg', 'png' => 'image/png', 'bmp' => 'image/bmp', 'gif' => 'image/gif'), true)) {
                throw new RuntimeException('Invalid Image Format.');
            }

//            if(!move_uploaded_file($_FILES[$fileinput]['tmp_name'],sprintf("$path/%s.%s",sha1_file($_FILES[$fileinput]['tmp_name']),$ext))){                throw new RuntimeException('Failed to move uploaded file.');}
            if (!move_uploaded_file($_FILES[$fileinput]['tmp_name'], sprintf("%s/%s.%s", $path, $file, $ext))) {
                throw new RuntimeException('Failed to move uploaded file.');
            }

            if ($square) {
                File::scaleIMG($path, "$file.$ext");
            }
            return "$file.$ext";
        } catch (RuntimeException $ex) {
            return array($ex->getMessage());
        }
    }

    public static function scaleIMG($path, $file, $dim = NULL) {
        $img = explode('.', $file);
        if (strtolower($img[1]) == 'svg') {
            return false;
        }
        switch (strtolower($img[1])) {
            case 'gif':
                $im = imagecreatefromgif("$path" . DIRECTORY_SEPARATOR . "$file");
                break;
            case 'jpg':
            case 'jpeg':
                $im = imagecreatefromjpeg("$path" . DIRECTORY_SEPARATOR . "$file");
                break;
            case 'png':
                $im = imagecreatefrompng("$path" . DIRECTORY_SEPARATOR . "$file");
                break;
        }

        if (isset($dim)) {
            if (is_array($dim)) {
                $im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => $dim['x'], 'height' => $dim['y']]);
            } else {
                $im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => $dim, 'height' => $dim]);
            }
        } else {
            $size = min(imagesx($im), imagesy($im));
            $im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => $size, 'height' => $size]);
        }

        if ($im2 !== FALSE) {
            switch (strtolower($img[1])) {
                case 'gif':
                    imagegif($im2, "$path" . DIRECTORY_SEPARATOR . "$file");
                    break;
                case 'jpg':
                    imagejpeg($im2, "$path" . DIRECTORY_SEPARATOR . "$file");
                    break;
                case 'png':
                    imagepng($im2, "$path" . DIRECTORY_SEPARATOR . "$file");
                    break;
            }
        }
    }

    private static function isPostSizeExceeded() {
        $maxPostSize = File::iniGetBytes('post_max_size');
        if ($_SERVER['CONTENT_LENGTH'] > $maxPostSize) {
            return true;
        }
        return false;
    }

    private static function iniGetBytes($val) {
        $val = trim(ini_get($val));
        if ($val != '') {
            $last = strtolower($val{strlen($val) - 1});
        } else {
            $last = '';
        }
        switch ($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }

}

abstract class WebTools {

    /**
     * 1. Get Platform (OSX, GNU/Linux, MS)
     * 2. Get Browser
     * 3. Get Browser Version
     * @return array
     */
    public static function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown'; // Browser name
        $platform = 'Unknown';
        $version = "";

        // First get platform
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Get the name of the user agent seperately for a good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Exporer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // Get the correct version numbers
        $known = array('Version', $ub, 'Other');
        $pattern = '#(?<browser>)' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

        /* if (!preg_match_all($pattern, $u_agent, $matches)) {
          // We have no matching number just continue
          } */

        if (!empty($matches)) {
            // See how many we remove
            $i = count($matches['browser']);

            if ($i != 1) {
                // We will have two since we are not using 'other' argument yet
                // See if version is before or after the name
                if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                    $version = $matches['version'][0];
                } else {
                    $version = $matches['version'][1];
                }
            } else {
                $version = $matches['version'][0];
            }
        }
        // Check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }
        return array('userAgent' => $u_agent, 'name' => $bname, 'version' => $version, 'platform' => $platform, 'pattern' => $pattern);
    }

}
