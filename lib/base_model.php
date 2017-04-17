<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
            $msg = $this->{$validator}();
            if (strlen($msg) > 0) {
                $errors[] = $msg;
            }
        }

        return $errors;
    }

    public function validate_name() {
        if ($this->nimi == '' || $this->nimi == null) {
            return 'Nimi ei saa olla tyhjä!';
        }
        if (strlen($this->nimi) < 3) {
            return 'Nimen pituuden tulee olla vähintään kolme merkkiä!';
        }
    }

    public function validate_description() {
        if ($this->kuvaus == '' || $this->kuvaus == null) {
            return 'Kuvaus ei saa olla tyhjä!';
        }
        if (strlen($this->kuvaus) < 3) {
            return 'Kuvauksen pituuden tulee olla vähintään kolme merkkiä!';
        }
    }

    public function validate_aloitushinta() {
        if (!is_numeric($this->aloitushinta)) {
            return 'Aloitushinnan tulee olla numero!';
        }
    }

    public function validate_sulkeutuu() {

        try {
            new DateTime('@' . $this->sulkeutuu);
        } catch (Exception $e) {
            return 'Sulkeutumisajan tulee olla päivämäärä!';
        }
    }
    
    public function validate_summa() {
        if (!is_numeric($this->summa)) {
            return 'Summan tulee olla numero!';
        } else if ($this->summa < 0) {
            return 'Summan tulee olla positiivinen!';
        }
    }

}
