<aside id="sidebar" class="sidebar w-64 h-full fixed md:relative transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out bg-dark border-r border-gray-700 z-40">
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