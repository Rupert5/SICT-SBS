<?php
require_once dirname(__FILE__,2).'/Log.php';
// Class providing generic data access functionality for PDO methods
abstract class dbHandler {

    // hold an instance of the PDO class
    private static $conn;
    private static $cs_file = "connection.ini";
    private static $cs_path = "root/config/";
    private static function get_connection() {

        $conexion = parse_ini_file(self::connection_str()); //------------------retrieve connection string from INI file
        
        if ($_SERVER['HTTP_HOST'] == 'sict-iis.nmmu.ac.za') {
            $DB_HOST = 'sict-mysql';
        } else {
            $DB_HOST = $_SERVER['HTTP_HOST'];
        }

        if (!empty($conexion['host'])) {
            $DB_HOST = $conexion['host'];
        }

        $DB_USER = $conexion['user'];
        $DB_PASS = $conexion['password'];
        $DB_NAME = $conexion['dbname'];

        // create database connection only if one does not already exists
        if (!isset(self::$conn)) {
            try {
                self::$conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set the PDO error mode to exception
            } catch (PDOException $ex) {
                self::db_error($ex->getMessage(),'connect','connection error');
            }
        }
        return self::$conn;
    }

    // method to cose database conection
    public static function Close() {
        self::$conn = null;
    }

    /*  execute()
     *  Metod to when perfoming DML
     *  This method is a wrapper for the PDOStatement::execute() method
     */

    public static function execute($sql, $params = null, $ajax = false) {
        try {
            $pdo_conn = self::get_connection();  //------------------------------ get connection to local instance
            self::Close();  //-------------------------------------------------- free memory
            $statement = $pdo_conn->prepare($sql);  //-------------------------- prepare query for execution
            $statement->execute($params);   //---------------------------------- execute query
        } catch (PDOException $ex) {
            if ($ajax) {
                Debug::ExceptionLog($ex->getMessage());
                return $ex->getMessage();
            } else {
                self::db_error($ex->getMessage(), 'DML', 'script error');
            }
        }
    }

    /* The dql() method is a wrapper for for the PDOStatement::fetchall() + PDOStatement::fetch()
     * This method will be used querying the database
     */

    public static function dql($sql, $params = null,$ajax = false, $fetchStyle = PDO::FETCH_ASSOC) {
        try {
            $pdo_conn = self::get_connection();  //------------------------------ get connection to local instance
            self::Close();  //-------------------------------------------------- free memory
            $statement = $pdo_conn->prepare($sql);  //-------------------------- prepare query for execution
            $statement->execute($params);   //---------------------------------- execute query
            if ($statement->rowCount() === 1) {
                $query = $statement->fetch($fetchStyle);
            } else {
                $query = $statement->fetchAll($fetchStyle);
            }
        } catch (PDOException $ex) {
            if ($ajax) {
                Debug::ExceptionLog($ex->getMessage());
                return $ex->getMessage();
            } else {
                self::db_error($ex->getMessage());
            }
        }
        return $query;
    }

    private static function db_error($error_message,$case='',$title='DB Error') {
        self::Close();
        $error = Debug::ExceptionLog($error_message);
        if(is_array($error)){
        require_once dirname(__FILE__, 3) . '/view/error/generic.php';
        }else{
        require_once dirname(__FILE__, 3) . '/view/error/db.php';
        }

        echo "<script> document.title = '$title'; </script>";
        exit();
    }
    
    /* This function creates connection string file, if it doesn't exist
     * The file is in .ini format
     * Newly created file will have empty fields
     */
    private static function connection_str(){
        $cs_path = dirname(__FILE__, 4). '/'.self::$cs_path;
        $cs_file = $cs_path.self::$cs_file;
        $cs_string = "[SQL]\r\nhost =\r\nuser = sanhedrin \r\npassword = bitbank\r\ndbname = testbank";
        
        if (is_dir($cs_path)) {
            if (!file_exists($cs_file)) {
                file_put_contents($cs_file, $cs_string);
            }
            if (!file_exists($cs_file)) {
                $err = "FILE <b>connection string</b> file not found on the <em>'".self::$cs_path."'</em> directory";
                self::db_error(str_pad($err, 23 + strlen($err), ' ', STR_PAD_LEFT), 'connect', 'DB connection');
            }
        } else {
                if (mkdir($cs_path, 0777) === true) {
                    file_put_contents($cs_file, $cs_string);
                } else {
                    $err = "couldn't create configuration directory, after failing to find connection string file.";
                    self::db_error(str_pad($err, 23 + strlen($err), ' ', STR_PAD_LEFT), 'connect', 'DB connection');
                }
            }
            return $cs_file;
    }

}
