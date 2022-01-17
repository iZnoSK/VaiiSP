<?php /** @var Array $data */ ?>
<div class="container-md">
    <div class="row">
        <!-- Zobrazenie postov s komentármi -->
        <!-- justify-content-center -> karty sú zarovnané na stred, flex-wrap -> ked sa dostanem na koniec, choď na ďalší riadok -->
        <div class="d-flex justify-content-center flex-wrap">
            <!-- KARTY -->
            <?php foreach ($data['movies'] as $movie) { ?>
            <div class="card bg-light">                                     <!-- TODO maybe text-center -->
                <!-- header karty - obrázok -->
                <img src="public/files/movieImages/<?= $movie->getImg() ?>" class="card-img-top" alt="poster">
                <!-- telo karty - text -->
                <div class="card-body">
                    <!-- názov filmu -->
                    <h5><?= $movie->getTitle() ?></h5>
                    <hr>
                    <!-- atribúty filmu -->
                    <p>
                        <strong>Hodnotenie: </strong><?= $movie->getFinalRating() ?>%<br>
                        <strong>Rok vydania: </strong><?= $movie->getRelease() ?><br>
                        <strong>Žánre: </strong><?= $movie->getGenresString() ?><br>
                        <strong>Dĺžka filmu: </strong><?= $movie->getLength() ?> minút
                    </p>
                    <hr>
                    <!-- popis filmu -->
                    <p class="card-text">
                        <?= substr($movie->getDescription(), 0, 300) ?>...
                    </p>
                    <span>(<a href="?c=movie&a=getProfile&id=<?= $movie->getId() ?>">Viac informácií o filme</a>)</span>
                    <!-- zobrazenie tlačidiel na úpravu, ak som prihlásený -->
                    <?php if(\App\Auth::isLogged()) { ?>
                        <hr>
                        <!-- tlačidlo na vymazanie filmu -->
                        <a href="?c=movie&a=removeMovie&id=<?= $movie->getId() ?>" class="btn btn-danger">
                            <i class="bi bi-trash"></i>
                        </a>
                        <!-- tlačidlo na úpravu filmu -->
                        <a href="?c=movie&a=editMovieForm&id=<?= $movie->getId() ?>" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            <!-- KARTY -->
        </div>
    </div>
</div>