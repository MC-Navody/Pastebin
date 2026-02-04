<!DOCTYPE html>
<html lang="cs">
    <head>
        <?php include __DIR__ . '/parts/head.php'; ?>
        <title>404 - Stránka nenalezena</title>
    </head>
    <body>
    <?php include __DIR__ . '/parts/header.php'; ?>
            <main>
                <div class="error-page">
                    <div class="error-code">404</div>
                    <div class="error-message">Stránka nenalezena</div>
                    <p class="error-description">Log, který hledáš, neexistuje nebo jeho platnost vypršela.</p>
                    <a href="/" class="btn btn-blue">
                        <i class="fa-solid fa-home"></i>
                        Zpět na úvod
                    </a>
                </div>
            </main>
        <?php include __DIR__ . '/parts/footer.php'; ?>
    </body>
</html>
