<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Porc</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/app/views/css/styles.css">
</head>
<body class="bg-dark text-white font-sans">
    <header class="header fixed top-0 w-full flex justify-between items-center p-4 shadow-lg bg-primary z-50 transition-all duration-300 ease-in-out hover:bg-opacity-90">
        <div class="logo text-2xl font-bold text-secondary animate-pulse-slow">GestionPorc</div>
        <button id="menu-toggle" class=" text-white text-2xl focus:outline-none transform hover:scale-110 transition-transform duration-200">
            ☰
        </button>
    </header>
    <div class="flex mt-16">
        <?php require_once __DIR__ . '/sidebar.php'; ?>
        <main class="main-content flex-1 p-6 ml-0 md:ml-64 transition-all duration-300 ease-in-out">