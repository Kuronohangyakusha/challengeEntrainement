<?php
namespace App\Repository;

use App\Entity\Service;
use App\Entity\Employee;
use PDO;
use PDOException;

class ServiceRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    
    public function insert(Service $service): bool {
        try {
            $sql = "INSERT INTO service (nom) VALUES (:nom)";
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute([
                ':nom' => $service->getNom()
            ]);
        } catch (PDOException $e) {
            error_log("Erreur insertion service: " . $e->getMessage());
            return false;
        }
    }

   
    public function all(): array {
        try {
            $sql = "SELECT s.id, s.nom, s.manager_id, 
                           e.nom as manager_nom, e.telephone as manager_tel
                    FROM service s
                    LEFT JOIN employe e ON s.manager_id = e.id
                    ORDER BY s.nom";
            
            $stmt = $this->pdo->query($sql);
            $services = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $service = new Service($row['id'], $row['nom']);
                
               
                if ($row['manager_id']) {
                    $manager = new Employee(
                        $row['manager_id'], 
                        $row['manager_nom'], 
                        $row['manager_tel']
                    );
                    $service->setManager($manager);
                }
                
                $services[] = $service;
            }
            
            return $services;
        } catch (PDOException $e) {
            error_log("Erreur récupération services: " . $e->getMessage());
            return [];
        }
    }
 
    public function selectNoManager(): array {
        try {
            $sql = "SELECT id, nom FROM service WHERE manager_id IS NULL ORDER BY nom";
            $stmt = $this->pdo->query($sql);
            $services = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $services[] = new Service($row['id'], $row['nom']);
            }
            
            return $services;
        } catch (PDOException $e) {
            error_log("Erreur récupération services sans manager: " . $e->getMessage());
            return [];
        }
    }

    
    public function updateManager(int $serviceId, ?int $managerId): bool {
        try {
            $sql = "UPDATE service SET manager_id = :manager_id WHERE id = :service_id";
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute([
                ':manager_id' => $managerId,
                ':service_id' => $serviceId
            ]);
        } catch (PDOException $e) {
            error_log("Erreur mise à jour manager: " . $e->getMessage());
            return false;
        }
    }

}