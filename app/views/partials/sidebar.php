<?php $links = [
    'Reproduction' => Flight::get('flight.base_url').'/reproduction',
    'Alimentation' => Flight::get('flight.base_url').'/aliments',
    'Enclos' => Flight::get('flight.base_url').'/enclos',
    'Employés' => Flight::get('flight.base_url').'/employe',
    'Simulation' => Flight::get('flight.base_url').'/simulation',
    'Statistique' => Flight::get('flight.base_url').'/statistique',
    'Sante' => Flight::get('flight.base_url').'/sante'
];
?>
<aside id="sidebar" class="sidebar fixed top-16 left-0 w-64 h-[calc(100%-4rem)] transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out bg-primary border-r border-gray-700 z-40 shadow-lg">
    <nav class="mt-10">
        <ul class="space-y-4 px-4">
            <?php foreach ($links as $title => $url): ?>
                <li>
                    <a href="<?= $url ?>" class="block py-2 px-4 rounded hover:bg-secondary hover:text-dark transition-colors duration-200"><?= $title ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</aside>