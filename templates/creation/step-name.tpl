<div class="container-fluid py-4">
    <div class="row">
    %1$s
        <!-- Zone principale -->

        <div class="col-md-9">
            <form method="post" action="https://dd5.jhugues.fr/wp-admin/admin.php?page=hj-dd5/admin_manage.php&onglet=character">
                <div class="card bg-light shadow-sm p-0">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Création du personnage – Choix du nom</h5>
                    </div>

                    <div class="card-body">
                        <!-- Nom du personnage -->
                        <div class="mb-3">
                        <label for="characterName" class="form-label"><strong>Nom du personnage</strong></label>
                        <input type="text" class="form-control" id="characterName" name="characterName" placeholder="Entrez le nom du personnage" required="required" value="%3$s">
                        </div>

                        <!-- Notes / détails -->
                        <div class="mb-3">
                        <label for="characterNotes" class="form-label"><strong>Notes complémentaires</strong></label>
                        <textarea class="form-control" id="characterNotes" name="characterNotes" rows="4" placeholder="Informations supplémentaires, historique, intentions...">%4$s</textarea>
                        </div>

                        <!-- Bouton -->
                        <div class="text-end">
                            <input type="hidden" id="characterId" name="characterId" value="%2$s"/>
                            <input type="hidden" id="herosForm" name="herosForm" value="name"/>
                            <button class="btn btn-sm btn-dark" id="createProcess">Continuer</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>