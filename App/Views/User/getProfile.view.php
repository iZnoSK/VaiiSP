<?php /**@var Array $data */ ?>
<?php
$title = $data['user']->getLogin()." | ";
?>

<?php /**@var Array $data */ ?>
<div class="container-lg">
    <div class="row">
        <!-- Pravá strana -->
        <div class="col-10 offset-1 col-md-6 offset-md-0 mt-2 hlavnyObsahUzivatela">
            <!-- Základné info o používateľovi -->
            <div class="row">
                <!-- Poster užívateľa -->
                <div class="col-2 pt-1 pb-1 bg-light obrazokUzivatela">
                    <img class="img-thumbnail" src="public/files/userImages/<?= $data['user']->getImg() ?>"
                         alt="Poster">
                </div>
                <!-- atribúty užívateľa -->
                <div class="col-10 pt-2 pb-1 bg-light atributyUzivatela">
                    <!-- Login -->
                    <div class="justify-content-end text-start">
                        <h4><strong><?= $data['user']->getLogin() ?></strong></h4>
                    </div>
                    <!-- E-mail -->
                    <hr>
                    <p>
                        <strong>E-mail: </strong><?= $data['user']->getEmail() ?>
                    </p>
                    <!-- tlačítka -->
                    <!-- zobrazenie tlačidiel na úpravu, ak som prihlásený -->
                    <?php if ((\App\Auth::isLogged()) && (\App\Auth::getId() == $data['user']->getId())) { ?>
                        <!-- tlačidlo na vymazanie filmu -->
                        <div class="text-end">
                            <a href="?c=user&a=removeUser&id=<?= $data['user']->getId() ?>" class="btn btn-danger">
                                <i class="bi bi-trash"></i>
                            </a>
                            <!-- tlačidlo na úpravu filmu -->
                            <a href="?c=user&a=editUserForm&id=<?= $data['user']->getId() ?>" class="btn btn-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <!-- -->
            </div>
            <!-- Recenzie používateľa -->
            <div class="row mt-1 mb-2">
                <!-- recenzie -->
                <div class="col-12 bg-light pt-2 pb-1 recenzieUzivatela">
                    <!-- nadpis -->
                    <header>
                        <h4><strong>Recenzie užívateľa</strong></h4>
                    </header>
                    <hr>
                    <!-- všetky recenzie -->
                    <?php $i = 0;
                    foreach ($data['user']->getReviews() as $review) { ?>
                        <h6><strong><?php echo $data['moviesReview'][$i]->getTitle() ?>
                                (<?php echo $data['moviesReview'][$i]->getRelease() ?>)</strong></h6>
                        <p>
                            <?php echo $review->getText(); ?>
                        </p>
                        <hr>
                        <?php $i++;
                    } ?>
                    <!-- -->
                </div>
                <!-- -->
            </div>
            <!-- -->
        </div>
        <!-- Ľavá strana -->
        <div class="col-8 offset-2 col-md-5 offset-md-0 mt-2 mb-2 bg-light hodnoteniaUzivatela">
            <!-- Nadpis -->
            <header class="pt-1 text-center">
                <h3><strong>Hodnotenia užívateľa</strong></h3>
            </header>
            <hr>
            <!-- Tabuľka -->
            <table class="table table-striped table-bordered tabulkaFilmovUzivatela">
                <!-- Hlavička tabuľky -->
                <thead>
                <tr>
                    <th class="prvyStlpecUzivatel">
                        Hodnotenie
                    </th>
                    <th class="druhyStlpecUzivatel">
                        Názov filmu
                    </th>
                </tr>
                </thead>
                <!-- Telo tabuľky -->
                <tbody>
                <?php $i = 0;
                foreach ($data['user']->getRatings() as $rating) { ?>
                    <tr>
                        <td class="prvyStlpecUzivatel">
                            <?php echo $rating->getPercentage() ?>%
                        </td>
                        <td class="druhyStlpecUzivatel">
                            <?php echo $data['moviesRating'][$i]->getTitle() ?>
                            (<?php echo $data['moviesRating'][$i]->getRelease() ?>)
                        </td>
                    </tr>
                    <?php $i++;
                } ?>
                </tbody>
            </table>
            <!-- -->
        </div>
        <!-- -->
    </div>
</div>
