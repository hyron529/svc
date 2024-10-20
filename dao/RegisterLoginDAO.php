<?php
class DAORegisterLogin extends DB {
    //Array donde almacenamos los intentos de logueo
    public $logins = array();

    //Constructor con el que inicializamos la BBDD
    public function __construct($base)
    {
        $this->dbname = $base;
    }

    /*
        Método para obtener los 7 intentos de login
        Reralizamos la conslta para obtener los intentos realizados
        Definimos los parámetros de la consulta, la ejecutamos y devolvemos las fias obtenidas
    */
    public function getAttemps($user) { 
        $consulta = "SELECT access FROM registerlogin  WHERE user=:user ORDER BY user DESC LIMIT 7";

        $param = array();

        $param[':user'] = $user;

        $this->ConsultaDatos($consulta, $param);

        return $this->filas;
    }

    /*
        Método para bloquear a un usuario si supera los 7 intentos
        Contador para controlar los fallos
        Verificamos si se tuvieron 7 fallos exactamente y sumamos 1 por cada fallo
        Bloqueamos al usuario si ha fallado los 7 intentos
    */
    public function blockuser($rows) {
        $cont = 0;

        if(count($rows) == 7) {
            foreach($rows as $row) {
                if ($row['access'] === 'F') {
                    $cont++;
                }
            }
        }

        return ($cont == 7) ?? false;
    }

    /*
        Método para insertar un intento de logueo
        Realizamos la sentencia para poder insertar dicho intento
        Defnimos los parámetros de la consulta y la ejecutamos
    */
    public function loginAttempt($user, $password, $access) {
        $consulta = "INSERT INTO registerlogin VALUE(:user, :password, :access)";

        $param = array();

        $param[':user'] = $user;
        $param[':password'] = $password;
        $param[':access'] = $access;

        $this->ConsultaSimple($consulta, $param);
    }
}
?>