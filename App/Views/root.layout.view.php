<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Databáza filmov</title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="public/files/common/favicon.png">
    <!-- viewport pre responzívny dizajn -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- bootstrap ikony -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <!-- link na vlastne css   -->
    <link rel="stylesheet" href="public/css.css">
</head>

<body
<!-- hlavný navbar -->
<!-- TODO responzívne schovať -->
<nav class="navbar bg-dark align-items-center">
    <div class="container-md">
        <!-- záložky na začiatku -->
        <ul class="nav justify-content-start">
            <!-- Záložka filmy -->
            <li class="nav-item">
                <a class="nav-link" href="?c=home">Domov</a>
            </li>
            <!-- zobrazenie záložiek Pridanie filmu a Pridanie tvorcu, ak som prihlásený -->
            <?php if(\App\Auth::isLogged()) { ?>
            <li class="nav-item">
                <a class="nav-link" href="?c=movie&a=movieForm">Pridať film</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Pridať tvorcu</a>
            </li>
            <?php } ?>
        </ul>
        <!-- záložky na konci -->
        <ul class="nav justify-content-end ">
            <!-- zobrazenie záložky logout, ak som prihlásený -->
            <?php if(\App\Auth::isLogged()) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="?c=user"><?php echo \App\Auth::getName() ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?c=auth&a=logout">Odhlásiť sa</a>
                </li>
            <!-- ak nie som prihlásený, zobraz záložku login a sign up-->
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="?c=auth&a=signUpForm">Registrácia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?c=auth&a=loginForm">Prihlásiť sa</a>
                </li>
            <?php } ?>
        </ul>
        <!-- -->
    </div>
</nav>

<!-- obsah -->
<?= $contentHTML ?>

</body>
</html>

