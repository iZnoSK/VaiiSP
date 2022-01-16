<?php /**@var Array $data */ ?>
<div class="container-lg">
    <div class="row">
        <!-- Pravá strana -->
        <div class="col-10 offset-1 col-md-6 offset-md-0 mt-2 hlavnyObsahTvorcu">
            <!-- Základné info o tvorcovi -->
            <div class="row">
                <!-- Poster tvorcu -->
                <div class="col-3 pt-1 pb-1 bg-light obrazokTvorcu">
                    <img class="img-thumbnail" src="public/files/creatorImages/<?= $data['creator']->getImg() ?>" alt="Poster">
                </div>
                <!-- Atribúty tvorcu -->
                <div class="col-9 pt-2 pb-1 bg-light atributyTvorcu">
                    <h4><strong><?= $data['creator']->getName() ?> <?= $data['creator']->getSurname() ?></strong></h4>
                    <hr>
                    <p>
                        <strong>Dátum narodenia: </strong><?= $data['creator']->getDateOfBirth() ?>
                        <br>
                        <strong>Miesto narodenia: </strong><?= $data['creator']->getPlaceOfBirth() ?>
                    </p>
                </div>
                <!-- -->
            </div>
            <!-- Biografia tvorcu -->
            <div class="row mt-1 mb-2">
                <!-- Obsah -->
                <div class="col-12 bg-light pt-2 pb-1 biografiaTvorcu">
                    <!-- Nadpis -->
                    <header>
                        <h4><b>Biografia</b></h4>
                        <hr>
                    </header>
                    <!-- Text -->
                    <p><?= $data['creator']->getBiography() ?>
                    </p>
                    <!-- -->
                </div>
                <!-- -->
            </div>
            <!-- -->
        </div>
        <!-- Ľavá strana -->
        <div class="col-8 offset-2 col-md-5 offset-md-0 mt-2 mb-2 bg-light filmyTvorcu">
            <!-- Nadpis -->
            <header class="pt-1 text-center">
                <h3><strong><?= $data['creator']->getRole() ?></strong></h3>
                <hr>
            </header>
            <!-- Tabuľka -->
            <table class="table table-striped table-bordered tabulkaFilmovTvorcu">
                <!-- Hlavička tabuľky -->
                <thead>
                <tr>
                    <th class="prvyStlpecTvorca">
                        Rok vydania
                    </th>
                    <th class="druhyStlpecTvorca">
                        Názov filmu
                    </th>
                </tr>
                </thead>
                <!-- Telo tabuľky -->
                <tbody>
                <?php foreach ($data['movies'] as $movie) { ?>
                <tr>
                    <td class="prvyStlpecTvorca">
                        <?= $movie->getRelease() ?>
                    </td>
                    <td class="druhyStlpecTvorca">
                        <?= $movie->getTitle() ?>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
            <!-- -->
        </div>
        <!-- -->
    </div>
</div>