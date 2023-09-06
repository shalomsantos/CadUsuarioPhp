<?php
//classe conexão.
class Connection  {
    private static $dbhost = 'localhost';
    private static $dbname = 'basicus';
    private static $user = 'root';
    private static $password = '';
    private static $pdoInstance = null;
    //função q retorna o objeto de conexão com banco.
    public static function getConnection(){
        //se a instancia for vazia; criar nova conexão.
        if (empty(self::$pdoInstance)) {
            try {
                self::$pdoInstance = new PDO("mysql:host=" . self::$dbhost . ";dbname=" . self::$dbname, self::$user, self::$password);
                self::$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$pdoInstance;
    }
}
?>