<?php
$title = "Pridanie filmu | ";
?>

<?php /**@var Array $data */ ?>
<div class="container-md">
    <div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 col-xl-8 offset-xl-2 mt-3">
            <!-- formulár na pridanie filmu -->
            <form method="post" enctype="multipart/form-data" action="?c=movie&a=upload">
                <div class="form-control bg-light mb-3">
                    <!-- Nadpis -->
                    <div class="mb-4">
                        <h5><strong>Pridanie filmu</strong></h5>
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
                        <!-- názov -->
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="title" class="form-label">Názov</label>
                            <input id="title" class="form-control" name="titleOfMovie" type="text" required>
                        </div>
                        <!-- rok vydania -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="release" class="form-label">Rok vydania</label>
                            <input id="release" class="form-control" name="releaseOfMovie" type="number" placeholder="YYYY" min="1900" max="2030" required>
                        </div>
                        <!-- dĺžka filmu -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="length" class="form-label">Dĺžka filmu</label>
                            <input id="length" class="form-control" name="lengthOfMovie" type="number" min="1" max="900" required>
                        </div>
                        <!-- obrázok -->
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="formFile" class="form-label">Plagát</label>
                            <input id="formFile" class="form-control" name="fileOfMovie" type="file">
                        </div>
                        <!-- Krajina pôvodu -->
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="origin" class="form-label">Krajina pôvodu</label>
                            <input id="origin" class="form-control" name="originOfMovie" type="text" required>
                        </div>
                        <!-- režisér -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="director" class="form-label">Režisér</label>
                            <select id="director" class="form-select" name="directorOfMovie" required>
                                <option value="">Vyber režiséra</option>
                                <?php foreach ($data['directors'] as $director) { ?>
                                    <option value="<?= $director->getId() ?>"><?= $director->getFullName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- scenárista -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="screenwriter" class="form-label">Scenárista</label>
                            <select id="screenwriter" class="form-select" name="screenwriterOfMovie" required>
                                <option value="">Vyber scenáristu</option>
                                <?php foreach ($data['screenwriters'] as $screenwriter) { ?>
                                    <option value="<?= $screenwriter->getId() ?>"><?= $screenwriter->getFullName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- kameraman -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="cameraman" class="form-label">Kameraman</label>
                            <select id="cameraman" class="form-select" name="cameramanOfMovie" required>
                                <option value="">Vyber kameramana</option>
                                <?php foreach ($data['cameramen'] as $cameraman) { ?>
                                    <option value="<?= $cameraman->getId() ?>"><?= $cameraman->getFullName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- skladateľ -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="composer" class="form-label">Skladateľ</label>
                            <select id="composer" class="form-select" name="composerOfMovie" required>
                                <option value="">Vyber skladateľa</option>
                                <?php foreach ($data['composers'] as $composer) { ?>
                                    <option value="<?= $composer->getId() ?>"><?= $composer->getFullName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- žáner -->
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="genres" class="form-label">Žánre</label>
                            <select id="genres" class="form-select" name="genresOfMovie[]" multiple required>
                                <?php foreach ($data['genres'] as $genre) { ?>
                                    <option value="<?= $genre->getId() ?>"><?= $genre->getName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- herci -->
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="actors" class="form-label">Herci</label>
                            <select id="actors" class="form-select" name="actorsOfMovie[]" multiple required>
                                <?php foreach ($data['actors'] as $actor) { ?>
                                    <option value="<?= $actor->getId() ?>"><?= $actor->getFullName() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- popis filmu -->
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Popis filmu</label>
                            <textarea id="description" class="form-control" name="descriptionOfMovie" rows="7" required></textarea>
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
