<?php

class EsitteenTuoteluokka extends BaseModel {

    public $esite_id, $tuoteluokka_id;

    public function __construct($attributes = null) {
        parent::__construct($attributes);
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO EsitteenTuoteluokka VALUES(:esite_id, :tuoteluokka_id)');
        $query->execute(array('esite_id' => $this->esite_id, 'tuoteluokka_id' => $this->tuoteluokka_id));
    }
    
    public static function haeEsitteetTuoteluokanPerusteella($tuoteluokka_id) {
        $query = DB::connection()->prepare('SELECT Esite.id, Esite.nimi, Esite.kuva, Esite.aloitusHinta, Esite.avattu, Esite.sulkeutuu, Esite.kuvaus FROM Esite INNER JOIN EsitteenTuoteluokka ON EsitteenTuoteluokka.esite_id = Esite.id AND EsitteenTuoteluokka.tuoteluokka_id = :id');
        $query->execute(array('id' => $tuoteluokka_id));
        $rows = $query->fetchAll();
        $esitteet = array();
        
        foreach ($rows as $row) {
            $esitteet[] = new Esite(array('id' => $row['id'], 'nimi' => $row['nimi'], 'kuva' => $row['kuva'],
                'aloitushinta' => $row['aloitushinta'], 'avattu' => $row['avattu'],
                'sulkeutuu' => $row['sulkeutuu'], 'kuvaus' => $row['kuvaus']));
        }
        
        return $esitteet;
    }
    
}
