<?php

class TuoteluokkaController extends BaseController {

    public static function index() {
        self::check_admin();
        $tuoteluokat = Tuoteluokka::all();
        View::make('suunnitelmat/admin_page.html', array('tuoteluokat' => $tuoteluokat));
    }

    public static function destroy() {
        self::check_admin();
        $params = $_POST;
        $id = $params['id'];
        $tuoteluokka = new Tuoteluokka(array('id' => $id));
        $tuoteluokka->destroy();
        Redirect::to('/tuoteluokat', array('message' => 'Tuoteluokka on poistettu onnistuneesti!'));
    }

    public static function store() {
        self::check_admin();
        $params = $_POST;
        $tuoteluokka = new Tuoteluokka(array('nimi' => $params['name']));
        $tuoteluokka->save();
        Redirect::to('/tuoteluokat', array('message' => 'Tuoteluokka on lisätty onnistuneesti!'));
    }

}
