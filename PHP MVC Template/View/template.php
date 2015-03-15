<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <base href="<?= $webRoot ?>" >
        <link rel="stylesheet" href="Resources/style.css" />
        <title><?= $title ?></title>
    </head>
    
    <body>
        <div id="global">
            <header>
                <a href="Home">
                    <h1 id="title">
                        My website
                    </h1>
                </a>
            </header>
            
            <div id="content">
                <?= $content ?>
            </div>
            
            <footer id="footer">
                FOOTER
            </footer>
        </div>
    </body>
</html>