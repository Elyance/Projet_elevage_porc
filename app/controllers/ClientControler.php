<?php
namespace app\controllers;

use app\models\ClientModel;
use Flight;

class ClientControler {
    private $model;

    
    public function index() {
        $model = new ClientModel(Flight::db());
        $clients = $model->getAll();
       
        $data = [
            'clients' => $clients
        ];
       
        Flight::render('client/list', $data);
    }

    public function createForm() {
        $data = [
            'postes' => 'a'
        ];
       
        Flight::render('client/create', $data);
       
        
    }

    public function store() {
        $model = new ClientModel(Flight::db());
        $d = Flight::request()->data;
        $model->insert($d['nom_client'], $d['type_profil'], $d['adresse'], $d['contact_telephone'], $d['contact_email']);
        Flight::redirect('/clients');
    }

    public function editForm($id) {
        $model = new ClientModel(Flight::db());
        $client = $model->getById($id);
        $data = [
            'client' => $client
        ];
       
        Flight::render('client/edit', $data);
        
    }

    public function update($id) {
        $model = new ClientModel(Flight::db());
        $d = Flight::request()->data;
        $model->update($id, $d['nom_client'], $d['type_profil'], $d['adresse'], $d['contact_telephone'], $d['contact_email']);
        Flight::redirect('/clients');
    }

    public function delete($id) {
        $model = new ClientModel(Flight::db());
        $model->delete($id);
        Flight::redirect('/clients');
    }
}
