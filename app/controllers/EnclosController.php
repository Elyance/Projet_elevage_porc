<?php

namespace app\controllers;

use app\models\EnclosModel;
use app\models\EnclosTypeModel;

class EnclosController
{
    public function __construct()
    {
    }

    public function delete($id)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $enclos = EnclosModel::findById($id);
        if ($enclos) {
            EnclosModel::delete($id);
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Enclos supprimé avec succès',
            ];
        } else {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Enclos non trouvé',
            ];
        }
        \Flight::redirect('/enclos');
    }

    public function deplacer()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (\Flight::request()->method == 'POST') {
            $id_enclos_source = \Flight::request()->data->enclos_source;
            $quantite = \Flight::request()->data->quantite;
            $id_enclos_destination = \Flight::request()->data->enclos_destination;

            if (empty($id_enclos_source) || empty($quantite) || empty($id_enclos_destination)) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Veuillez remplir tous les champs',
                ];
                \Flight::redirect('/enclos/deplacer');
            } else {
                $EnclosSource = EnclosModel::findById($id_enclos_source);
                $EnclosDestination = EnclosModel::findById($id_enclos_destination);

                // Mise à jour du stockage dans l'enclos source
                $new_stockage_source = $EnclosSource['stockage'] - $quantite;

                if ($new_stockage_source <= 0) {
                    $_SESSION['flash'] = [
                        'type' => 'error',
                        'message' => 'Stockage insuffisant dans l\'enclos source',
                    ];
                    \Flight::redirect('/enclos/deplacer');
                } else {
                    EnclosModel::update($id_enclos_source, $EnclosSource['enclos_type'], $new_stockage_source);
                    // Mise à jour du stockage dans l'enclos destination
                    $new_stockage_destination = $EnclosDestination['stockage'] + $quantite;
                    EnclosModel::update($id_enclos_destination, $EnclosDestination['enclos_type'], $new_stockage_destination);
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'source : Deplacement effectué avec succès',
                    ];
                    \Flight::redirect('/enclos/deplacer');
                }
            }
        } else {
            $data = ['page' => 'enclos/deplacer', 'enclos' => EnclosModel::getAll()];
            \Flight::render('template', $data);
        }
    }

    public function show($id)
    {
        $enclos = EnclosModel::findByIdJoined($id);
        $data = ['page' => 'enclos/show', 'enclos' => $enclos];
        \Flight::render('template', data: $data);
    }

    public static function index()
    {
        $enclos = EnclosModel::getAll();

        $data = ['page' => 'enclos/index', 'enclos' => $enclos];
        \Flight::render('template', $data);
    }

    public function create()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (\Flight::request()->method == 'POST') {
            $error = [];
            $type_enclos = \Flight::request()->data->type_enclos;

            if (empty($type_enclos)) {
                $error['type_enclos'] = 'Le type d enclos est obligatoire';
            }

            $stockage = \Flight::request()->data->stockage;
            if (empty($stockage)) {
                $error['stockage'] = 'Le stockage est obligatoire';
            } elseif ($stockage < 1) {
                $error['stockage'] = 'Le doit etre superieur ou égal à 1';
            }

            if (empty($error)) {
                EnclosModel::create($type_enclos, $stockage);

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Enclos créée avec succès',
                ];

                \Flight::redirect('/enclos');
            } else {
                $data = ['page' => 'enclos/form', 'enclos_type' => EnclosTypeModel::getAll()];
                $data['error'] = $error;
                \Flight::render('template', $data);
            }
        } else {
            $data = ['page' => 'enclos/form', 'enclos_type' => EnclosTypeModel::getAll()];
            \Flight::render('template', $data);
        }
    }
}
