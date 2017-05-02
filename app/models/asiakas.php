<?php

class Asiakas extends BaseModel {

    public $id, $email, $puh, $etunimi, $sukunimi, $password, $onkoAdmin;

    public function __construct($attributes = null) {
        parent::__construct($attributes);
        $this->validators = array('validate_email', 'validate_puh', 'validate_password', 'validate_etunimi', 'validate_sukunimi');
    }

//    public static function all() {
//        $query = DB::connection()->prepare('SELECT * FROM Asiakas');
//        $query->execute();
//        $rows = $query->fetchAll();
//        $asiakkaat = array();
//
//        foreach ($rows as $row) {
//            $asiakkaat[] = new Asiakas(array('id' => $row['id'], 'email' => $row['email'], 'puh' => $row['puh'],
//                'aloitushinta' => $row['aloitushinta'], 'avattu' => $row['avattu'],
//                'etunimi' => $row['etunimi'], 'sukunimi' => $row['sukunimi'], 'password' => $row['password'],
//                'onkoAdmin' => $row['onkoAdmin']));
//        }
//
//        return $asiakkaat;
//    }

    public static function authenticate($email, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Asiakas WHERE email = :email AND password = :password LIMIT 1');
        $query->execute(array('email' => $email, 'password' => $password));
        $row = $query->fetch();

        if ($row) {
            return new Asiakas(array('id' => $row['id'], 'email' => $row['email'], 'puh' => $row['puh'],
                'etunimi' => $row['etunimi'], 'sukunimi' => $row['sukunimi'], 'password' => $row['password'],
                'onkoAdmin' => $row['onkoadmin']));
        } else {
            return null;
        }
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Asiakas WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            return new Asiakas(array('id' => $row['id'], 'email' => $row['email'], 'puh' => $row['puh'],
                'etunimi' => $row['etunimi'], 'sukunimi' => $row['sukunimi'], 'password' => $row['password'],
                'onkoAdmin' => $row['onkoadmin']));
        }
    }

    public function save() {
        $query = DB::connection()->prepare("INSERT INTO Asiakas(email, puh, etunimi, sukunimi, password, onkoAdmin) VALUES (:email, :puh, :etunimi, :sukunimi, :password, '0') RETURNING ID");
        $query->execute(array('email' => $this->email, 'puh' => $this->puh, 'etunimi' => $this->etunimi, 'sukunimi' => $this->sukunimi, 'password' => $this->password));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
