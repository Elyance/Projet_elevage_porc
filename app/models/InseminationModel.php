<?php
namespace app\models;

use PDO;

class InseminationModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $sql = 'SELECT i.*, t.poids AS truie_poids FROM bao_insemination i JOIN bao_truie t ON i.id_truie = t.id_truie';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($truie_id, $date, $resultat)
    {
        $sql = 'INSERT INTO bao_insemination (id_truie, date_insemination, resultat) VALUES (:truie_id, :date, :resultat)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':truie_id' => $truie_id, ':date' => $date, ':resultat' => $resultat]);
    }
}