<?php
class DAORegisterLogin extends DB {
    public $logins = array();

    public function __construct($base)
    {
        $this->dbname = $base;
    }

    public function getAttemps($user) { 
        $consulta = "SELECT access FROM registerlogin  WHERE user=:user ORDER BY user DESC LIMIT 7";

        $param = array();

        $param[':user'] = $user;

        $this->ConsultaDatos($consulta, $param);

        return $this->filas;
    }

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