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
        $query = DB::connection()->prepare('SELECT Esite.id FROM Esite INNER JOIN EsitteenTuoteluokka ON EsitteenTuoteluokka.esite_id = Esite.id AND EsitteenTuoteluokka.tuoteluokka_id = :id');
        $query->execute(array('id' => $tuoteluokka_id));
        $rows = $query->fetchAll();
        $esitteet = array();
        
        foreach ($rows as $row) {
            $esitteet[] = $row['id'];
        }
        
        return $esitteet;
    }
    
    public static function haeTuoteluokatEsitteenPerusteella($esite_id) {
        $query = DB::connection()->prepare('SELECT Tuoteluokka.id, Tuoteluokka.nimi FROM Tuoteluokka INNER JOIN EsitteenTuoteluokka ON EsitteenTuoteluokka.tuoteluokka_id = Tuoteluokka.id AND EsitteenTuoteluokka.esite_id = :id');
        $query->execute(array('id' => $esite_id));
        $rows = $query->fetchAll();
        $tuoteluokat = array();
        
        foreach ($rows as $row) {
            $tuoteluokat[] = new Esite(array('id' => $row['id'], 'nimi' => $row['nimi']));
        }
        
        return $tuoteluokat;
    }


    public static function destroy($esite_id) {
        $query = DB::connection()->prepare('DELETE FROM EsitteenTuoteluokka WHERE esite_id = :id');
        $query->execute(array('id' => $esite_id));
    }
    
}
