<?php /** @var Array $data */ ?>
<div class="container-xl">
    <div class="row">
        <!-- Pravá strana -->
        <div class="col-12 col-xl-9 mt-2 mb-2 hlavnyObsahFilmu">
            <!-- Atribúty filmu -->
            <div class="row">
                <input id="idOfMovie" type="hidden" value="<?= $data['movie']->getId()?>">
                <!-- Názov filmu -->
                <header class="col-12 hlavickaFilmu pt-1">
                    <h3><strong><?= $data['movie']->getTitle()?></strong></h3>
                </header>
                <!-- Poster filmu-->
                <div class="col-3 bg-light obrazokFilmu pt-1 pb-1">
                    <img class="img-thumbnail" src="public/files/movieImages/<?= $data['movie']->getImg()?>" alt="Poster">
                </div>
                <!-- atribúty filmu -->
                <div class="col-9 bg-light atributyFilmu pt-2 pb-1">
                    <p>
                        <strong>Rok vydania: </strong><?= $data['movie']->getRelease()?><br>
                        <strong>Krajina pôvodu: </strong><?= $data['movie']->getOrigin()?><br>
                        <strong>Dĺžka trvania: </strong><?= $data['movie']->getLength()?> minút<br>
                        <strong>Žánre: </strong><?= $data['movie']->getGenresString() ?><br>
                        <strong>Réžia: </strong><a href="?c=creator&a=getProfile&id=<?= $data['director']->getId() ?>"><?= $data['director']->getFullname() ?></a><br>
                        <strong>Scenár: </strong><a href="?c=creator&a=getProfile&id=<?= $data['screenwriter']->getId() ?>"><?= $data['screenwriter']->getFullname() ?></a><br>
                        <strong>Kamera: </strong><a href="?c=creator&a=getProfile&id=<?= $data['cameraman']->getId() ?>"><?= $data['cameraman']->getFullname() ?></a><br>
                        <strong>Hudba: </strong><a href="?c=creator&a=getProfile&id=<?= $data['composer']->getId() ?>"><?= $data['composer']->getFullname() ?></a><br>
                        <strong>Hrajú: </strong>
                        <?php foreach ($data['actors'] as $actor) { ?>
                            <a href="?c=creator&a=getProfile&id=<?= $actor->getId() ?>"><?= $actor->getFullname() ?></a>
                        <?php } ?>
                        <br>
                    </p>
                </div>
                <!-- -->
            </div>
            <!-- Obsah filmu -->
            <div class="row mt-1">
                <!-- obsah -->
                <div class="col-12 obsahFilmu">
                    <!-- hlavička -->
                    <header class="hlavickaObsahuFilmu">
                        <h4><strong>Obsah</strong></h4>
                        <hr>
                    </header>
                    <!-- telo -->
                    <div class="teloObsahuFilmu">
                        <p><?= $data['movie']->getDescription()?></p>
                    </div>
                    <!-- -->
                </div>
            </div>
            <!-- Recenzie filmu -->
            <div class="row mt-1">
                <!-- recenzie -->
                <div class="col-12 recenzieFilmu bg-light">
                    <!-- hlavička -->
                    <header class="hlavickaRecenzieFilmu">
                        <h4><strong>Recenzie</strong></h4>
                    </header>
                    <hr>
                    <?php if(\App\Auth::isLogged() && !$data['hasReview']) { ?>
                    <!-- formulár na novú recenziu -->
                        <div id="reviewForm">
                            <!-- text recenzie -->
                            <div class="col-12 mb-3">
                                <label for="review" class="form-label"><strong>Pridať recenziu</strong></label>
                                <textarea id="review" class="form-control" name="reviewOfMovie" rows="4" required></textarea>
                            </div>
                            <!-- tlačítko -->
                            <div class="mb-3">
                                <button id="sendReview" class="btn btn-primary">Pridať</button>
                            </div>
                            <hr>
                            <!--  -->
                        </div>
                    <!--  -->
                    <?php } ?>
                    <!-- všetky recenzie -->
                    <div id="reviews">

                    </div>
                    <!-- -->
                </div>
                <!-- -->
            </div>
            <!-- -->
        </div>
        <!-- Ľavá strana -->
        <div class="col-6 offset-3 col-md-4 offset-md-4 col-xl-2 offset-xl-0 mt-2 mb-2 hodnotenieFilmu">
            <div class="row">
                <!-- Priemerné hodnotenie -->
                <header class="col-12 hlavickaHodnoteniaFilmu pt-1">
                    <h3><strong><?= $data['movie']->getFinalRating()?>%</strong></h3>
                </header>
                <?php if(\App\Auth::isLogged() && !$data['hasRating']) { ?>
                <!-- Formulár na ohodnotenie filmu -->
                <div class="bg-light pt-2" id="ratingForm">
                    <!-- text recenzie -->
                    <div class="col-12 mb-3">
                        <label for="rating" class="form-label"><strong>Pridať hodnotenie</strong></label>
                        <input id="rating" class="form-control" name="ratingOfMovie" type="number" min="1" max="100" required>
                    </div>
                    <!-- tlačítko -->
                    <div class="mb-3">
                        <button id="sendRating" class="btn btn-primary">Pridať</button>
                    </div>
                    <hr>
                    <!--  -->
                </div>
                <?php } ?>
                <!-- ostatne hodnotenia -->
                <div class="col-12 ostatneHodnotenia bg-light">
                    <!-- Tabuľka -->
                    <table class="table table-striped table-sm table-bordered mt-2 text-center">
                        <!-- Hlavička tabuľky -->
                        <thead>
                        <tr>
                            <th class="prvyStlpecHodnotenia">
                                Užívateľ
                            </th>
                            <th class="druhyStlpecHodnotenia">
                                %
                            </th>
                        </tr>
                        </thead>
                        <!-- Telo tabuľky -->
                        <tbody id="ratings">

                        </tbody>
                        <!-- -->
                    </table>
                    <!-- -->
                </div>
                <!-- -->
            </div>
        </div>
        <!-- -->
    </div>
</div>
