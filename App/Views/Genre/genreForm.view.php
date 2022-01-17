<?php /**@var Array $data */ ?>
<div class="container">
    <div class="row">
        <div class="col-10 offset-1 col-md-8 offset-md-2  col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mt-3">
            <!-- Formulár na prihlásenie sa -->
            <form method="post" action="?c=genre&a=addGenre">
                <div class="form-control bg-light mb-3">
                    <!-- Nadpis -->
                    <div class="mb-4">
                        <h5><strong>Pridať žáner</strong></h5>
                    </div>
                    <!-- časti formuláru -->
                    <div>
                        <!-- error hláška -->
                        <?php if($data['error'] != "") { ?>
                            <div class="alert alert-danger alert-dismissible text-center">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <?= $data['error'] ?>
                            </div>
                        <?php } ?>
                        <!-- názov žánru -->
                        <div class="form-control mb-3">
                            <label for="genre" class="form-label"><strong>Názov žánru</strong></label>
                            <input id="genre" class="form-control" name="genreName" type="text" maxlength="30" required>
                        </div>
                        <!-- tlačítko -->
                        <div class="mb-3">
                            <button id="submit" class="btn btn-primary" type="submit">Odoslať</button>
                        </div>
                        <!--  -->
                    </div>
                    <!--  -->
                </div>
            </form>
            <!--  -->
        </div>
    </div>
</div>

