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
    
}
