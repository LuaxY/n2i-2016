<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <title>ImHuman - WeeCop</title>
    <link rel="stylesheet" href="/assets2/css/style.css">
    <link rel="stylesheet" href="/assets2/css/sortable.css">
    <link rel="stylesheet" href="/assets2/css/ply.css">

    <script src="/assets2/js/jquery-3.1.1.slim.min.js"></script>
    <script src="/assets2/js/init.js"></script>
    <script src="/assets2/js/Ply.min.js"></script>
    <script src="/assets2/js/Sortable.min.js"></script>
</head>
<body>
    <!-- Connected lists -->
    <div class="layout remboursement">
        <header>
            <img src="/assets2/img/logo.png" alt="logo" style="height : 102px;margin-top:-15px;float:left;">
            <h1>Application de remboursement</h1>
        </header>
        <div class="container vertical">
            <div id="filter">
                <div class="block__list block__list_words">
                    <ul id="trip" class="full.alt">
                        <li>Londres</li>
                        <li>Milan</li>
                        <li>Paris</li>
                    </ul>
                    <button id="addTrip">+</button>
                </div>
            </div>
        </div>
        <section class="left">
            <h3>Les bénévoles</h3>
            <div class="container">
                <div id="filter">
                    <div class="block__list block__list_words">
                        <ul id="users" class="full">
                        </ul>
                        <button class="round" id="addUser">+</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="right">
            <h3>Les Dépenses</h3>
            <div class="container">
                <div id="filter">
                    <div class="block__list block__list_words">
                        <ul id="editable" class="full">
                        </ul>
                        <button class="round" id="addDep">+</button>
                        <button id="checkDep">Calculer</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
