<?php
namespace App\Repository;

use App\Entity\Employee;
use App\Entity\Manager;
use App\Entity\TypeEnum;
use PDO;
use PDOException;

class EmployeeRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function insertManager(Manager $manager): bool {
        try {
            $sql = "INSERT INTO employe (nom, telephone, type, prime) VALUES (:nom, :tel, :type, :prime)";
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute([
                ':nom' => $manager->getNom(),
                ':tel' => $manager->getTel(),
                ':type' => $manager->getType()->value,
                ':prime' => $manager->getPrime()
            ]);
        } catch (PDOException $e) {
            error_log("Erreur insertion manager: " . $e->getMessage());
            return false;
        }
    }

    public function getManagers(): array {
        try {
            $sql = "SELECT id, nom, telephone, prime FROM employe WHERE type = 'Manager' ORDER BY nom";
            $stmt = $this->pdo->query($sql);
            $managers = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $managers[] = new Manager(
                    $row['id'],
                    $row['nom'],
                    $row['telephone'],
                    (float)$row['prime']
                );
            }
            
            return $managers;
        } catch (PDOException $e) {
            error_log("Erreur récupération managers: " . $e->getMessage());
            return [];
        }
    }

    public function getManagersWithoutService(): array {
        try {
            $sql = "SELECT e.id, e.nom, e.telephone, e.prime 
                    FROM employe e 
                    LEFT JOIN service s ON e.id = s.manager_id 
                    WHERE e.type = 'Manager' AND s.manager_id IS NULL 
                    ORDER BY e.nom";
            $stmt = $this->pdo->query($sql);
            $managers = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $managers[] = new Manager(
                    $row['id'],
                    $row['nom'],
                    $row['telephone'],
                    (float)$row['prime']
                );
            }
            
            return $managers;
        } catch (PDOException $e) {
            error_log("Erreur récupération managers sans service: " . $e->getMessage());
            return [];
        }
    }
}