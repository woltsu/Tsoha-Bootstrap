<?php

class Tarjous extends BaseModel {

    public $id, $asiakas_id, $esite_id, $summa, $pvm, $asiakas;

    public function __construct($attributes = null) {
        parent::__construct($attributes);
        $this->validators = array('validate_summa');
    }

    public static function all($esite) {
        $query = DB::connection()->prepare('SELECT * FROM Tarjous WHERE esite_id = :esite_id ORDER BY summa DESC');
        $query->execute(array('esite_id' => $esite));
        $rows = $query->fetchAll();
        $tarjoukset = array();

        foreach ($rows as $row) {
            $t = new Tarjous(array('id' => $row['id'], 'asiakas_id' => $row['asiakas_id'], 'esite_id' => $row['esite_id'],
                'summa' => $row['summa'], 'pvm' => $row['pvm']));
            $t->asiakas = Asiakas::find($row['asiakas_id']);
            $tarjoukset[] = $t;
        }

        return $tarjoukset;
    }

    public static function suurin($esite) {
        $tarjoukset = self::all($esite);
        if (!$tarjoukset) {
            return new Tarjous(array('summa' => 0));
        }
        return $tarjoukset[0];
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tarjous(asiakas_id, esite_id, summa, pvm) VALUES (:asiakas_id, :esite_id, :summa, current_timestamp) RETURNING ID');
        $query->execute(array('asiakas_id' => $this->asiakas_id, 'esite_id' => $this->esite_id, 'summa' => $this->summa));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function getPvm() {
        return Esite::getCorrectDateFormat($this->pvm);
    }
    
}
