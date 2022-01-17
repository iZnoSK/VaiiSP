<?php /** @var Array $data */ ?>
<div class="container-fluid">
    <div class="row">
        <!-- herci -->
        <div class="offset-0 col-6 col-md-4 col-lg-3 offset-xl-1 col-xl-2 bg-light">
            <table class="table table-striped table-sm table-bordered mt-2 text-center">
                <!-- Hlavička tabuľky -->
                <thead>
                <tr>
                    <th colspan="2">
                        <h5><strong>Herci</strong></h5>
                    </th>
                </tr>
                </thead>
                <!-- Telo tabuľky -->
                <tbody>
                <?php foreach ($data['actors'] as $actor) { ?>
                <tr>
                    <td class="prvyStlpecTvorcovia">
                        <img src="public/files/creatorImages/<?= $actor->getImg() ?>" class="img-thumbnail obrazokTvorcovia">
                    </td>
                    <td class="druhyStlpecTvorcovia">
                        <p>
                            <br>
                            <a href="?c=creator&a=getProfile&id=<?= $actor->getId() ?>"><?= $actor->getFullName() ?></a>
                            <br>
                            <?= $actor->getDateOfBirth() ?>
                        </p>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
                <!-- -->
            </table>
        </div>
        <!-- režiséri -->
        <div class="col-6 col-md-4 col-lg-3 col-xl-2 bg-light">
            <table class="table table-striped table-sm table-bordered mt-2 text-center">
                <!-- Hlavička tabuľky -->
                <thead>
                <tr>
                    <th colspan="2">
                        <h5><strong>Režiséri</strong></h5>
                    </th>
                </tr>
                </thead>
                <!-- Telo tabuľky -->
                <tbody>
                <?php foreach ($data['directors'] as $director) { ?>
                    <tr>
                        <td class="prvyStlpecTvorcovia">
                            <img src="public/files/creatorImages/<?= $director->getImg() ?>" class="img-thumbnail obrazokTvorcovia"">
                        </td>
                        <td class="druhyStlpecTvorcovia">
                            <p>
                                <br>
                                <a href="?c=creator&a=getProfile&id=<?= $director->getId() ?>"><?= $director->getFullName() ?></a>
                                <br>
                                <?= $director->getDateOfBirth() ?>
                            </p>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <!-- -->
            </table>
        </div>
        <!-- scenáristi -->
        <div class="col-6 col-md-4 col-lg-3 col-xl-2 bg-light">
            <table class="table table-striped table-sm table-bordered mt-2 text-center">
                <!-- Hlavička tabuľky -->
                <thead>
                <tr>
                    <th colspan="2">
                        <h5><strong>Scenáristi</strong></h5>
                    </th>
                </tr>
                </thead>
                <!-- Telo tabuľky -->
                <tbody>
                <?php foreach ($data['screenwriters'] as $screenwriter) { ?>
                    <tr>
                        <td class="prvyStlpecTvorcovia">
                            <img src="public/files/creatorImages/<?= $screenwriter->getImg() ?>" class="img-thumbnail obrazokTvorcovia">
                        </td>
                        <td class="druhyStlpecTvorcovia">
                            <p>
                                <br>
                                <a href="?c=creator&a=getProfile&id=<?= $screenwriter->getId() ?>"><?= $screenwriter->getFullName() ?></a>
                                <br>
                                <?= $screenwriter->getDateOfBirth() ?>
                            </p>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <!-- -->
            </table>
        </div>
        <!-- kameramani -->
        <div class="col-6 col-md-4 col-lg-3 col-xl-2 bg-light">
            <table class="table table-striped table-sm table-bordered mt-2 text-center">
                <!-- Hlavička tabuľky -->
                <thead>
                <tr>
                    <th colspan="2">
                        <h5><strong>Kameramani</strong></h5>
                    </th>
                </tr>
                </thead>
                <!-- Telo tabuľky -->
                <tbody>
                <?php foreach ($data['cameramen'] as $cameraman) { ?>
                    <tr>
                        <td class="prvyStlpecTvorcovia">
                            <img src="public/files/creatorImages/<?= $cameraman->getImg() ?>" class="img-thumbnail obrazokTvorcovia">
                        </td>
                        <td class="druhyStlpecTvorcovia">
                            <p>
                                <br>
                                <a href="?c=creator&a=getProfile&id=<?= $cameraman->getId() ?>"><?= $cameraman->getFullName() ?></a>
                                <br>
                                <?= $cameraman->getDateOfBirth() ?>
                            </p>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <!-- -->
            </table>
        </div>
        <!-- skladatelia -->
        <div class="col-6 col-md-4 col-lg-3 col-xl-2 bg-light">
            <table class="table table-striped table-sm table-bordered mt-2 text-center">
                <!-- Hlavička tabuľky -->
                <thead>
                <tr>
                    <th colspan="2">
                        <h5><strong>Skladatelia</strong></h5>
                    </th>
                </tr>
                </thead>
                <!-- Telo tabuľky -->
                <tbody>
                <?php foreach ($data['composers'] as $composer) { ?>
                    <tr>
                        <td class="prvyStlpecTvorcovia">
                            <img src="public/files/creatorImages/<?= $composer->getImg() ?>" class="img-thumbnail obrazokTvorcovia">
                        </td>
                        <td class="druhyStlpecTvorcovia">
                            <p>
                                <br>
                                <a href="?c=creator&a=getProfile&id=<?= $composer->getId() ?>"><?= $composer->getFullName() ?></a>
                                <br>
                                <?= $composer->getDateOfBirth() ?>
                            </p>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <!-- -->
            </table>
        </div>
        <!-- -->
    </div>
</div>