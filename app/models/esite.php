<?php

class Esite extends BaseModel {

    public $id, $nimi, $kuva, $aloitushinta, $avattu, $sulkeutuu, $kuvaus;

    public function __construct($attributes = null) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_description', 'validate_aloitushinta', 'validate_sulkeutuu');
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
    
    public static function all_ids() {
        $query = DB::connection()->prepare('SELECT * FROM Esite');
        $query->execute();
        $rows = $query->fetchAll();
        $esitteet = array();
        
        foreach ($rows as $row) {
            $esitteet[] = $row['id'];
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

    public function update($id) {
        $query = DB::connection()->prepare('UPDATE Esite SET nimi = :name, kuva = :picture, aloitusHinta = :startPrice, sulkeutuu = :ends, kuvaus = :description WHERE id = :id');
        $query->execute(array('name' => $this->nimi, 'picture' => $this->kuva, 'startPrice' => $this->aloitushinta, 'ends' => $this->sulkeutuu, 'description' => $this->kuvaus, 'id' => $id));
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Esite WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }

    public function __toString() {
        return $this->nimi;
    }
    
    public function showImage() {
        echo $this->kuva;
    }
    
    public function getHighestBid() {
        $bid = Tarjous::suurin($this->id);
        if ($bid->summa == 0) {
            return $this->aloitushinta;
        }
        return $bid->summa;
    }

}
