<?php /**@var Array $data */ ?>
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-10 offset-sm-1 col-lg-8 offset-lg-2 mt-3">
            <!-- formulár na pridanie filmu -->
            <form method="post" enctype="multipart/form-data" action="?c=creator&a=addCreator">
                <div class="form-control bg-light mb-3">
                    <!-- Nadpis -->
                    <div class="mb-3">
                        <h5><strong>Pridanie tvorcu</strong></h5>
                    </div>
                    <!-- časti formuláru -->
                    <div class="row">
                        <!-- error hláška -->
                        <!-- error hláška, ak sme zadali zlý login alebo heslo -->
                        <?php if($data['error'] != "") { ?>
                            <div class="offset-1 col-10 offset-lg-3 col-lg-6  alert alert-danger alert-dismissible text-center">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <?= $data['error'] ?>
                            </div>
                        <?php } ?>
                        <!-- meno -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="name" class="form-label">Meno</label>
                            <input id="name" class="form-control" name="nameOfCreator" type="text" required>
                        </div>
                        <!-- priezvisko -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="surname" class="form-label">Priezvisko</label>
                            <input id="surname" class="form-control" name="surnameOfCreator" type="text" required>
                        </div>
                        <!-- obrázok -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="formFile" class="form-label">Plagát</label>
                            <input id="formFile" class="form-control" name="fileOfCreator" type="file" required>
                        </div>
                        <!-- rola -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="role" class="form-label">Povolanie</label>
                            <select id="role" class="form-select" name="roleOfCreator" required>
                                <option value="">Vyber povolanie</option>
                                <option value="Herec">Herec</option>
                                <option value="Režisér">Režisér</option>
                                <option value="Scenárista">Scenárista</option>
                                <option value="Kameraman">Kameraman</option>
                                <option value="Skladateľ">Skladateľ</option>
                            </select>
                        </div>
                        <!-- datum narodenia -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="dateOfBirth" class="form-label">Dátum narodenia</label>
                            <input id="dateOfBirth" class="form-control" name="dateOfBirthOfCreator" type="date" min="1900-01-01" max="2015-01-01" required>
                        </div>
                        <!-- miesto narodenia -->
                        <div class="col-12 col-md-6 mb-3">
                            <label for="placeOfBirth" class="form-label">Miesto narodenia</label>
                            <input id="placeOfBirth" class="form-control" name="placeOfBirthOfCreator" type="text" placeholder="Londýn, Veľká Británia" required>
                        </div>
                        <!-- biografia -->
                        <div class="col-12 mb-3">
                            <label for="biography" class="form-label">Biografia tvorcu</label>
                            <textarea id="biography" class="form-control" rows="7" name="biographyOfCreator" required></textarea>
                        </div>
                        <!-- tlačítko -->
                        <div class="mb-3">
                            <button id="submit" class="btn btn-primary" type="submit">Odoslať</button>
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


