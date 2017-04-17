<?php

class Tuoteluokka extends BaseModel {

    public $id, $nimi;

    public function __construct($attributes = null) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare("SELECT * FROM Tuoteluokka ORDER BY nimi ASC");
        $query->execute();
        $rows = $query->fetchAll();
        $tuoteluokat = array();

        foreach ($rows as $row) {
            $tuoteluokat[] = new Tuoteluokka(array('id' => $row['id'], 'nimi' => $row['nimi']));
        }

        return $tuoteluokat;
    }

    public static function hae($id) {
        $query = DB::connection()->prepare("SELECT * FROM Tuoteluokka WHERE id = :id LIMIT 1");
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            return new Tuoteluokka(array('id' => $row['id'], 'nimi' => $row['nimi']));
        }

        return null;
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Tuoteluokka WHERE id = :id');
        $query->execute(array('id' => $this->id));
    }
    
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tuoteluokka(nimi) VALUES (:name) RETURNING ID');
        $query->execute(array('name' => $this->nimi));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
