<?php /** @var Array $data */ ?>
<div class="container-xl">
    <div class="row">
        <!-- Pravá strana -->
        <div class="col-12 col-xl-9 mt-2 mb-2 hlavnyObsahFilmu">
            <!-- Atribúty filmu -->
            <div class="row">
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
                        <strong>Dĺžka trvania: </strong><?= $data['movie']->getLength()?><br>
                        <strong>Žánre: </strong><?= $data['movie']->getGenresString() ?><br>
                        <strong>Réžia: </strong> Denis Villeneuve<br>
                        <strong>Scenár: </strong> Eric Roth, Denis Villeneuve, Jon Spaihts<br>
                        <strong>Kamera: </strong> Greig Fraser<br>
                        <strong>Hudba: </strong> Hans Zimmer<br>
                        <strong>Hrajú: </strong> Timothée Chalamet, Rebecca Ferguson, Oscar Isaac, Jason Momoa,...<br>
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
                    <form method="post" action="?c=movie&a=addReview&movieId=<?= $data['movie']->getId() ?>">
                        <div class="form-control bg-light mb-3">
                            <div>
                                <!-- text recenzie -->
                                <div class="col-12 mb-3">
                                    <label for="review" class="form-label"><strong>Pridať recenziu</strong></label>
                                    <textarea id="review" class="form-control" name="reviewOfMovie" rows="4" required></textarea>
                                </div>
                                <!-- tlačítko -->
                                <div class="mb-3">
                                    <button id="submitReview" class="btn btn-primary" type="submit">Pridať</button>
                                </div>
                                <!--  -->
                            </div>
                        </div>
                    </form>
                    <hr>
                    <?php } ?>
                    <!-- všetky recenzie -->
                    <?php $i = 0; foreach ($data['movie']->getReviews() as $review) { ?>
                        <h6><strong><?php echo $data['reviewUsers'][$i]->getLogin() ?></strong></h6>
                        <p>
                            <?php echo $review->getText(); ?>
                        </p>
                        <hr>
                        <?php $i++;} ?>
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
                <!-- Formulár na ohodnotenie filnu -->
                <form method="post" action="?c=movie&a=addRating&movieId=<?= $data['movie']->getId() ?>" class="bg-light">
                    <div class="form-control bg-light mb-2 mt-2">
                        <div>
                            <!-- dĺžka filmu -->
                            <div class="col-12 mb-3">
                                <label for="rating" class="form-label"><strong>Pridať</strong></label>
                                <input id="rating" class="form-control" name="ratingOfMovie" type="number" min="1" max="100" required>
                            </div>
                            <!-- tlačítko -->
                            <div class="mb-3">
                                <button id="submitRating" class="btn btn-primary" type="submit">Pridať hodnotenie</button>
                            </div>
                            <!--  -->
                        </div>
                    </div>
                <?php } ?>
                </form>
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
                        <tbody>
                        <?php $i = 0; foreach ($data['movie']->getRatings() as $rating) { ?>
                        <tr>
                            <td class="prvyStlpecHodnotenia">
                                <?php echo $data['ratingUsers'][$i]->getLogin() ?>
                            </td>
                            <td class="druhyStlpecHodnotenia">
                                <?php echo $rating->getPercentage(); ?>%
                            </td>
                        </tr>
                        <?php $i++;} ?>
                        </tbody>
                    </table>
                    <!-- -->
                </div>
                <!-- -->
            </div>
        </div>
        <!-- -->
    </div>
</div>
