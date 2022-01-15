<?php /**@var Array $data */ ?>
<div class="container-md">
    <div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 col-xl-8 offset-xl-2 mt-3">
            <!-- formulár na pridanie filmu -->
            <form method="post" enctype="multipart/form-data" action="?c=movie&a=editMovie">
                <div class="form-control bg-light mb-3">
                    <!-- Nadpis -->
                    <div class="mb-4">
                        <h5><strong>Úprava filmu</strong></h5>
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
                        <!-- názov -->
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="title" class="form-label">Názov</label>
                            <input id="title" class="form-control" name="titleOfMovie" type="text" value="<?= $data['movie']->getTitle() ?>" required>
                        </div>
                        <!-- rok vydania -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="release" class="form-label">Rok vydania</label>
                            <input id="release" class="form-control" name="releaseOfMovie" type="number" placeholder="YYYY" min="1900" max="2030" value="<?= $data['movie']->getRelease() ?>" required>
                        </div>
                        <!-- dĺžka filmu -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="length" class="form-label">Dĺžka filmu</label>
                            <input id="length" class="form-control" name="lengthOfMovie" type="number" min="1" max="900" value="<?= $data['movie']->getLength() ?>" required>
                        </div>
                        <!-- Krajina pôvodu -->
                        <div class="col-12 mb-3">
                            <label for="origin" class="form-label">Krajina pôvodu</label>
                            <input id="origin" class="form-control" name="originOfMovie" type="text" value="<?= $data['movie']->getOrigin() ?>" required>
                        </div>
                        <!-- režisér -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="director" class="form-label">Režisér</label>
                            <select id="director" class="form-select" name="directorOfMovie" required>
                                <option value="">Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                            </select>
                        </div>
                        <!-- scenárista -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="screenwriter" class="form-label">Scenárista</label>
                            <select id="screenwriter" class="form-select" name="screenwriterOfMovie" required>
                                <option value="">Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                            </select>
                        </div>
                        <!-- kameraman -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="cameraMan" class="form-label">Kameraman</label>
                            <select id="cameraMan" class="form-select" name="cameraManOfMovie" required>
                                <option value="">Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                            </select>
                        </div>
                        <!-- skladateľ -->
                        <div class="col-12 col-sm-6 col-lg-3 mb-3">
                            <label for="musician" class="form-label">Skladateľ</label>
                            <select id="musician" class="form-select" name="musicianOfMovie" required>
                                <option value="">Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                            </select>
                        </div>
                        <!-- žáner -->
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="genres" class="form-label">Žánre</label>
                            <select id="genres" class="form-select" name="genresOfMovie" multiple required>
                                <option>Horor</option>
                                <option>Dráma</option>
                                <option>Akčný</option>
                                <option>Animovaný</option>
                                <option>Komédia</option>
                                <option>Thriller</option>
                            </select>
                        </div>
                        <!-- herci -->
                        <div class="col-12 col-sm-6 mb-3">
                            <label for="actors" class="form-label">Herci</label>
                            <select id="actors" class="form-select" name="actorsOfMovie" multiple required>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
                                <option>Jožko Mrkvička</option>
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
