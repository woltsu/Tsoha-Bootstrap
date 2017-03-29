<?php

class Esite extends BaseModel {

    public $id, $nimi, $kuva, $aloitushinta, $avattu, $sulkeutuu, $kuvaus;

    public function __construct($attributes = null) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Esite');
        $query->execute();
        $rows = $query->fetchAll();
        $esitteet = array();

        foreach ($rows as $row) {
            $esitteet[] = new Esite(array('id' => $row['id'], 'nimi' => $row['nimi'], 'kuva' => $row['kuva'],
                'aloitushinta' => $row['aloitushinta'], 'avattu' => $row['avattu'],
                'sulkeutuu' => $row['sulkeutuu'], 'kuvaus' => $row['kuvaus']));
        }

        return $esitteet;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Esite WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $esite = new Esite(array(
                'id' => $row['id'], 'nimi' => $row['nimi'], 'kuva' => $row['kuva'],
                'aloitushinta' => $row['aloitushinta'], 'avattu' => $row['avattu'],
                'sulkeutuu' => $row['sulkeutuu'], 'kuvaus' => $row['kuvaus']
            ));
        }

        return $esite;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Esite(nimi, kuva, aloitusHinta, avattu, sulkeutuu, kuvaus) VALUES (:name, :picture, :startPrice, current_timestamp, :ends, :description) RETURNING ID');
        $query->execute(array('name' => $this->nimi, 'picture' => $this->kuva, 'startPrice' => $this->aloitushinta, 'ends' => $this->sulkeutuu, 'description' => $this->kuvaus));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
