<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-name" content="quixlab" />

    <title>E-Porc</title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= STATIC_URL ?>/assets/images/favicon.png">
    <link href="<?= STATIC_URL ?>/assets/plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= STATIC_URL ?>/assets/plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="<?= STATIC_URL ?>/assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <link href="<?= STATIC_URL ?>/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>


    <div id="main-wrapper">
        <!--**********************************
            Header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="<?= BASE_URL ?>/">
                    <b class="logo-abbr"><img src="<?= STATIC_URL ?>/assets/images/logo.png" alt="" style="display: block; margin: 0 auto;"></b>
                    <span class="logo-compact"><img src="<?= STATIC_URL ?>/assets/images/logo-compact.png" alt="" style="display: block; margin: 0 auto;"></span>
                    <span class="brand-title">
                        <img src="<?= STATIC_URL ?>/assets/images/logo-text.png" alt="" style="display: block; margin: 0 auto;">
                    </span>
                </a>
            </div>
        </div>

        <div class="header">
            <div class="header-content clearfix">
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <span class="activity active"></span>
                                <?php
                                $imagePath = '';
                                if (isset($_SESSION['user_role_id']) && $_SESSION['user_role_id'] == 1) {
                                    $imagePath = STATIC_URL . '/assets/images/Henloalt.png';
                                } else {
                                    $imagePath = STATIC_URL . '/assets/images/Henlo.png';
                                }
                                ?>
                                <img src="<?= $imagePath ?>" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <i class="icon-user"></i> <span><?= $_SESSION['user'] ?></span>
                                        </li>
                                        <hr class="my-2">
                                        <li><a href="<?= BASE_URL ?>/logout"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <!-- <li class="nav-label">Modules</li> -->
                    <li>
                        <a href="<?= BASE_URL ?>/simulation/benefice" aria-expanded="false">
                            <i class="icon-chart menu-icon"></i><span class="nav-text">Simulation</span>
                        </a>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-basket menu-icon"></i><span class="nav-text">Alimentation</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= BASE_URL ?>/aliments">Consulter les stocks</a></li>
                            <li><a href="<?= BASE_URL ?>/aliments/reappro">Faire des provisions</a></li>
                            <li><a href="<?= BASE_URL ?>/aliments">Consulter l'historique de circulation</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-home menu-icon"></i><span class="nav-text">Enclos</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= BASE_URL ?>/enclos">Infos Enclos</a></li>
                            <li><a href="<?= BASE_URL ?>/histo_peser">Historique pesée</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-people menu-icon"></i><span class="nav-text">Outils de gestions</span>
                        </a>
                        <ul aria-expanded="false">
                            <!-- Employee Management -->
                            <li class="mega-menu-title pl-3">G.Employés</li>
                            <li><a href="<?= BASE_URL ?>/employe">Liste des Employés</a></li>
                            <li><a href="<?= BASE_URL ?>/add_employe">Ajouter un Employé</a></li>
                            
                            <!-- Salary Section -->
                            <li class="mega-menu-title pl-3">G.Salaires</li>
                            <li><a href="<?= BASE_URL ?>/salaire">Salaires</a></li>
                            <li><a href="<?= BASE_URL ?>/salaire/historique_paie">Historique des Paiements</a></li>
                            
                            <!-- Attendance Section -->
                            <li class="mega-menu-title pl-3">G.Présences</li>
                            <li><a href="<?= BASE_URL ?>/presence">Feuille de Présence</a></li>
                            <li><a href="<?= BASE_URL ?>/presence/add_presence">Enregistrer Présence</a></li>
                            
                            <!-- Tasks Section -->
                            <li class="mega-menu-title pl-3">G.Tâches</li>
                            <li><a href="<?= BASE_URL ?>/tache">Liste des Tâches</a></li>
                            <li><a href="<?= BASE_URL ?>/tache/create">Créer une Tâche</a></li>
                            <li><a href="<?= BASE_URL ?>/tache/assign">Assigner des Tâches</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-graph menu-icon"></i><span class="nav-text">Statistique</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= BASE_URL ?>/statistiques/aliments">Statistiques Aliments</a></li>
                            <li><a href="<?= BASE_URL ?>/statistiques/ventes">Statistiques Ventes</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-heart menu-icon"></i><span class="nav-text">Reproduction</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= BASE_URL ?>/reproduction">Historique des Inséminations</a></li>
                            <li><a href="<?= BASE_URL ?>/reproduction/inseminate">Ajouter Insémination</a></li>
                            <li><a href="<?= BASE_URL ?>/cycle">Cycles en Cours</a></li>
                            <li><a href="<?= BASE_URL ?>/cycle/add">Ajouter un Cycle</a></li>
                            <li><a href="<?= BASE_URL ?>/naissance/add">Enregistrer une Naissance</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-plus menu-icon"></i><span class="nav-text">Santé</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= BASE_URL ?>/sante">Calendrier</a></li>
                            <li><a href="<?= BASE_URL ?>/sante/listDiagnostic">Diagnostics</a></li>
                            <li><a href="<?= BASE_URL ?>/sante/listSignale">Cas Signalés</a></li>
                            <li><a href="<?= BASE_URL ?>/sante/listQuarantine">Cas en Quarantaine</a></li>
                            <li><a href="<?= BASE_URL ?>/sante/listTreatment">Cas en Traitement</a></li>
                            <li><a href="<?= BASE_URL ?>/maladie">Maladies</a></li>
                            <li><a href="<?= BASE_URL ?>/deces">Décès</a></li>
                            <li><a href="<?= BASE_URL ?>/typeevenement">Liste Type Événements</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-basket menu-icon"></i><span class="nav-text">Commandes</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= BASE_URL ?>/commande/add">Inserer une commande</a></li>
                            <li><a href="<?= BASE_URL ?>/commande/list">Liste des commandes</a></li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-wallet menu-icon"></i><span class="nav-text">Budget</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= BASE_URL ?>/budget/index ">Voir Budget</a></li>
                            <li><a href="<?= BASE_URL ?>/commande/recette">Recettes</a></li>
                            <li><a href="<?= BASE_URL ?>/depense/list">Depenses</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <?= $content ?>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


    </div>
    <!--**********************************
        Footer start
    ***********************************-->
    <div class="footer">
        <div class="copyright">
            <p>&copy; 2025 E-Porc</p>
        </div>
    </div>
    <!--**********************************
        Footer end
    ***********************************-->

    <script src="<?= STATIC_URL ?>/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= STATIC_URL ?>/assets/plugins/common/common.min.js"></script>
    <script src="<?= STATIC_URL ?>/assets/js/custom.min.js"></script>
    <script src="<?= STATIC_URL ?>/assets/js/settings.js"></script>
    <script src="<?= STATIC_URL ?>/assets/js/gleek.js"></script>
    <script src="<?= STATIC_URL ?>/assets/js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="<?= STATIC_URL ?>/assets/plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="<?= STATIC_URL ?>/assets/plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="<?= STATIC_URL ?>/assets/plugins/d3v3/index.js"></script>
    <script src="<?= STATIC_URL ?>/assets/plugins/topojson/topojson.min.js"></script>
    <script src="<?= STATIC_URL ?>/assets/plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="<?= STATIC_URL ?>/assets/plugins/raphael/raphael.min.js"></script>
    <script src="<?= STATIC_URL ?>/assets/plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="<?= STATIC_URL ?>/assets/plugins/moment/moment.min.js"></script>
    <script src="<?= STATIC_URL ?>/assets/plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="<?= STATIC_URL ?>/assets/plugins/chartist/js/chartist.min.js"></script>
    <script src="<?= STATIC_URL ?>/assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>

    <script src="<?= STATIC_URL ?>/assets/js/dashboard/dashboard-1.js"></script>
</body>

</html>
<?php ?>