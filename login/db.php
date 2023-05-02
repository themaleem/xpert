<?php
class DB {

    private static $host = "localhost";
    private static $database = "some";
    private static $username = "root";
    private static $password = "";
    
    public static function getConnection() {
        $connection = new mysqli( DB::$host, DB::$username, DB::$password, DB::$database);
        // Check for errors
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        $connection->set_charset("utf8");
        return $connection;
    }
}