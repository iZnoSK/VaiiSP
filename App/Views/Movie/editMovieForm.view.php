<?php /**@var Array $data */ ?>
<div class="container-md">
    <div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 col-xl-8 offset-xl-2 mt-3">
            <!-- formulár na pridanie filmu -->
            <form method="post" enctype="multipart/form-data" action="?c=movie&a=editMovie">
                <div class="form-control bg-light mb-3">
                    <!-- Nadpis -->
                    <div class="mb-4">
                        <h5><strong>Úprava filmu: <?= $data['movie']->getTitle() ?> (<?= $data['movie']->getRelease() ?>)</strong></h5>
                    </div>
                    <!-- časti formuláru -->
                    <div class="row">
                        <!-- error hláška, ak sme zadali zlý login alebo heslo -->
                        <?php if($data['error'] != "") { ?>
                            <div class="offset-1 col-10 offset-lg-3 col-lg-6  alert alert-danger alert-dismissible text-center">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <?= $data['error'] ?>
                            </div>
                        <?php } ?>
                        <!-- id upravovaného filmu -->
                        <input type="hidden" name="id" value="<?= $data['movie']->getId() ?>">
                        <input type="hidden" name="titleOfMovie" value="<?= $data['movie']->getTitle() ?>">
                        <input type="hidden" name="releaseOfMovie" value="<?= $data['movie']->getRelease() ?>">
                        <!-- Krajina pôvodu -->
                        <div class="col-12 col-sm-6 col-lg-8 mb-3">
                            <label for="origin" class="form-label">Krajina pôvodu</label>
                            <input id="origin" class="form-control" name="originOfMovie" type="text" value="<?= $data['movie']->getOrigin() ?>" required>
                        </div>
                        <!-- dĺžka filmu -->
                        <div class="col-12 col-sm-6 col-lg-4 mb-3">
                            <label for="length" class="form-label">Dĺžka filmu</label>
                            <input id="length" class="form-control" name="lengthOfMovie" type="number" min="1" max="900" value="<?= $data['movie']->getLength() ?>" required>
                        </div>
                        <!-- režisér -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="director" class="form-label">Režisér</label>
                            <select id="director" class="form-select" name="directorOfMovie" required>
                                <?php foreach ($data['directors'] as $director) { ?>
                                    <option value="<?= $director->getId() ?>"<?php if($director->getId() == $data['PreviousDirectorId']) { ?> selected<?php } ?>><?= $director->getFullName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- scenárista -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="screenwriter" class="form-label">Scenárista</label>
                            <select id="screenwriter" class="form-select" name="screenwriterOfMovie" required>
                                <?php foreach ($data['screenwriters'] as $screenwriter) { ?>
                                    <option value="<?= $screenwriter->getId() ?>"<?php if($screenwriter->getId() == $data['PreviousScreenwriterId']) { ?> selected<?php } ?>><?= $screenwriter->getFullName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- kameraman -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="cameraman" class="form-label">Kameraman</label>
                            <select id="cameraman" class="form-select" name="cameramanOfMovie" required>
                                <?php foreach ($data['cameramen'] as $cameraman) { ?>
                                    <option value="<?= $cameraman->getId() ?>"<?php if($cameraman->getId() == $data['PreviousCameramanId']) { ?> selected<?php } ?>><?= $cameraman->getFullName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- skladateľ -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="composer" class="form-label">Skladateľ</label>
                            <select id="composer" class="form-select" name="composerOfMovie" required>
                                <?php foreach ($data['composers'] as $composer) { ?>
                                    <option value="<?= $composer->getId() ?>"<?php if($composer->getId() == $data['PreviousComposerId']) { ?> selected<?php } ?>><?= $composer->getFullName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- žáner -->
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="genres" class="form-label">Žánre</label>
                            <select id="genres" class="form-select" name="genresOfMovie[]" multiple required>
                                <?php $i = 0; foreach ($data['genres'] as $genre) { ?>
                                    <option value="<?= $genre->getId() ?>"<?php if(in_array($genre->getId(), $data['genresIds'])) { ?> selected<?php } ?>>
                                        <?= $genre->getName() ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- herci -->
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="actors" class="form-label">Herci</label>
                            <select id="actors" class="form-select" name="actorsOfMovie[]" multiple required>
                                <?php foreach ($data['actors'] as $actor) { ?>
                                    <option value="<?= $actor->getId() ?>"<?php if(in_array($actor->getId(), $data['PreviousActorsIds'])) { ?> selected<?php } ?>><?= $actor->getFullName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- popis filmu -->
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Popis filmu</label>
                            <textarea id="description" class="form-control" name="descriptionOfMovie" rows="7" required><?= $data['movie']->getDescription() ?></textarea>
                        </div>
                        <!-- tlačítko -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Odoslať</button>
                        </div>
                        <!-- -->
                    </div>
                    <!-- -->
                </div>
            </form>
            <!--  -->
        </div>
    </div>
</div>
