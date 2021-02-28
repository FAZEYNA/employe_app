<?php
    require_once "functions/function.php";
    require_once "database/connection.php";
    // $employes = get_employes();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/COURS/PHP_L2/TD3/assets/css/bootstrap.min.css" >
    <title>Service Employe</title>
</head>

<body>
    <?php
        // On détermine sur quelle page on se trouve
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $pageCourante = (int) strip_tags($_GET['page']);
        }else{
            $pageCourante = 1;
        }
        $pas = 5; //5 employes par page
        $nbEmployes = get_numberOfEmployees(); //nbr total d'employes 
        $nbPages = ceil($nbEmployes / $pas); //nombre total de pages
        $premier = ($pageCourante * $pas) - $pas;
        $employes = get_employeParPage($premier,$pas);
    ?>

    <div class="container">
    <p class="display-4 text-center mb-5 mt-3" style="font-family: 'Times New Roman'">Liste des employés</p>
        <table class="table table-bordered table-striped table-light">
            <thead>
            <tr class="table-primary text-center">
                <th scope="col">#</th>
                <th scope="col">Matricule</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Classe</th>
                <th scope="col" colspan="2">Action</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($employes as $Emp){ ?>
                    <tr>
                        <td><?=$Emp['idEmp']?></td>
                        <td><?=$Emp['numeroEmp']?></td>
                        <td><?=ucfirst($Emp['nomEmp'])?></td>
                        <td><?=ucfirst($Emp['prenomEmp'])?></td>
                        <td><?=$Emp['nomService']?></td>
                        <form method="POST" action="/COURS/PHP_L2/TD3/editionEmp.php">
                            <td><button class="btn btn-block btn-outline-warning">Modifier</button></td>
                            <input hidden type="text" name="idEmp" value="<?=$Emp['idEmp']?>">
                        </form>
                        <td><button type="button" class="btn btn-block btn-outline-danger" data-toggle="modal" data-target="#exampleModal-<?=$Emp['idEmp']?>">Supprimer</button></td>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal-<?=$Emp['idEmp']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-<?=$Emp['idEmp']?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel-<?=$Emp['idEmp']?>">Suppression</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                               <p>Voulez-vous vraiment supprimer l'employé <?= $Emp['prenomEmp']." ".$Emp['nomEmp']?> ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <form method="POST" action="controller/controller.php">
                                   <button type="submit" class="btn btn-danger" name="supprimer">Supprimer</button>
                                    <input hidden type="text" name="idEmp2" value="<?=$Emp['idEmp']?>">
                                </form>
                            </div>
                            </div>
                        </div>
                        </div>
                    </tr>
                <?php }?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                <li class="page-item <?= ($pageCourante == 1) ? "disabled" : "" ?>">
                    <a href="./?page=<?= $pageCourante - 1 ?>" class="page-link">Précédente</a>
                </li>
                <?php for($page = 1; $page <= $nbPages; $page++): ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                    <li class="page-item <?= ($pageCourante == $page) ? "active" : "" ?>">
                        <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                    </li>
                <?php endfor ?>
                    <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                    <li class="page-item <?= ($pageCourante == $nbPages) ? "disabled" : "" ?>">
                    <a href="./?page=<?= $pageCourante + 1 ?>" class="page-link">Suivante</a>
                </li>
            </ul>
        </nav>
        <a href="ajoutEmploye.php" class="shadow-none w-25 btn btn-outline-primary mt-3 float-right">Ajout d'employé<a>
    </div>

    <script src="/COURS/PHP_L2/TD3/assets/js/jquery-3.3.1.js"></script> <!--this always before -->
    <script src="/COURS/PHP_L2/TD3/assets/js/bootstrap.min.js"></script>
</body>
</html>