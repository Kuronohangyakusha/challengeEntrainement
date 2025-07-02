<?php
require_once '../vendor/autoload.php';
require_once '../src/database.php';

use App\Entity\Service;
use App\Entity\Manager;
use App\Entity\TypeEnum;
use App\Entity\SpecialiteEnum;
use App\Repository\ServiceRepository;
use App\Repository\EmployeeRepository;

$serviceRepo = new ServiceRepository($pdo);
$employeeRepo = new EmployeeRepository($pdo);

// Traitement des formulaires
if ($_POST) {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_service':
                if (!empty($_POST['nom_service'])) {
                    $service = new Service(0, $_POST['nom_service']);
                    if ($serviceRepo->insert($service)) {
                        $message = "Service ajouté avec succès!";
                    } else {
                        $error = "Erreur lors de l'ajout du service.";
                    }
                }
                break;
                
            case 'add_manager':
                if (!empty($_POST['nom']) && !empty($_POST['tel']) && !empty($_POST['prime'])) {
                    $manager = new Manager(0, $_POST['nom'], $_POST['tel'], (float)$_POST['prime']);
                    if ($employeeRepo->insertManager($manager)) {
                        $message = "Manager ajouté avec succès!";
                    } else {
                        $error = "Erreur lors de l'ajout du manager.";
                    }
                }
                break;
                
            case 'assign_manager':
                if (!empty($_POST['service_id']) && !empty($_POST['manager_id'])) {
                    if ($serviceRepo->updateManager((int)$_POST['service_id'], (int)$_POST['manager_id'])) {
                        $message = "Manager assigné avec succès!";
                    } else {
                        $error = "Erreur lors de l'assignation.";
                    }
                }
                break;
        }
    }
}

// Récupération des données
$services = $serviceRepo->all();
$managers = $employeeRepo->getManagers();
$managersLibres = $employeeRepo->getManagersWithoutService();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Employés</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; }
        .card { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .success { color: green; padding: 10px; background: #d4edda; border-radius: 4px; margin: 10px 0; }
        .error { color: red; padding: 10px; background: #f8d7da; border-radius: 4px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f8f9fa; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 768px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestion des Employés</h1>
        
        <?php if (isset($message)): ?>
            <div class="success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="grid">
            <!-- Ajouter Service -->
            <div class="card">
                <h2>Ajouter un Service</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="add_service">
                    <div class="form-group">
                        <label for="nom_service">Nom du service:</label>
                        <input type="text" id="nom_service" name="nom_service" required>
                    </div>
                    <button type="submit">Ajouter Service</button>
                </form>
            </div>

            <!-- Ajouter Manager -->
            <div class="card">
                <h2>Ajouter un Manager</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="add_manager">
                    <div class="form-group">
                        <label for="nom">Nom:</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="tel">Téléphone:</label>
                        <input type="text" id="tel" name="tel" required>
                    </div>
                    <div class="form-group">
                        <label for="prime">Prime:</label>
                        <input type="number" step="0.01" id="prime" name="prime" required>
                    </div>
                    <button type="submit">Ajouter Manager</button>
                </form>
            </div>
        </div>

        <!-- Assigner Manager -->
        <?php if (!empty($managersLibres)): ?>
        <div class="card">
            <h2>Assigner un Manager à un Service</h2>
            <form method="POST">
                <input type="hidden" name="action" value="assign_manager">
                <div class="grid">
                    <div class="form-group">
                        <label for="service_id">Service:</label>
                        <select id="service_id" name="service_id" required>
                            <option value="">Sélectionner un service</option>
                            <?php foreach ($services as $service): ?>
                                <?php if (!$service->getManager()): ?>
                                    <option value="<?= $service->getId() ?>"><?= htmlspecialchars($service->getNom()) ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="manager_id">Manager:</label>
                        <select id="manager_id" name="manager_id" required>
                            <option value="">Sélectionner un manager</option>
                            <?php foreach ($managersLibres as $manager): ?>
                                <option value="<?= $manager->getId() ?>"><?= htmlspecialchars($manager->getNom()) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit">Assigner</button>
            </form>
        </div>
        <?php endif; ?>

        <!-- Liste des Services -->
        <div class="card">
            <h2>Liste des Services</h2>
            <?php if (!empty($services)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du Service</th>
                            <th>Manager</th>
                            <th>Téléphone Manager</th>
                            <th>Prime</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td><?= $service->getId() ?></td>
                                <td><?= htmlspecialchars($service->getNom()) ?></td>
                                <td><?= $service->getManager() ? htmlspecialchars($service->getManager()->getNom()) : 'Aucun' ?></td>
                                <td><?= $service->getManager() ? htmlspecialchars($service->getManager()->getTel()) : '-' ?></td>
                                <td><?= $service->getManager() ? number_format($service->getManager()->getPrime(), 2) . ' €' : '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun service trouvé.</p>
            <?php endif; ?>
        </div>

        <!-- Liste des Managers -->
        <div class="card">
            <h2>Liste des Managers</h2>
            <?php if (!empty($managers)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Téléphone</th>
                            <th>Prime</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($managers as $manager): ?>
                            <tr>
                                <td><?= $manager->getId() ?></td>
                                <td><?= htmlspecialchars($manager->getNom()) ?></td>
                                <td><?= htmlspecialchars($manager->getTel()) ?></td>
                                <td><?= number_format($manager->getPrime(), 2) ?> €</td>
                                <td>
                                    <?php
                                    $isAssigned = false;
                                    foreach ($services as $service) {
                                        if ($service->getManager() && $service->getManager()->getId() === $manager->getId()) {
                                            echo "Assigné à " . htmlspecialchars($service->getNom());
                                            $isAssigned = true;
                                            break;
                                        }
                                    }
                                    if (!$isAssigned) echo "Libre";
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun manager trouvé.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>