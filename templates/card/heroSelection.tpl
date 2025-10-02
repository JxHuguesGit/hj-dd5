<div class="card col-6 mx-auto my-5">
    <form method="post" action="/">
        <div class="card-header text-center">
            Sélection du personnage
        </div>
        <div class="card-body">
            %1$s
            <div class="input-group">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="radio" name="heroSelection" id="createNewHero" value="-1" checked>
                </div>
                <span class="input-group-text">Créer un nouveau personnage</span>
            </div>
        </div>
        <div class="card-footer text-body-secondary">
            <div class="col-12">
                <input type="hidden" name="formName" value="heroSelection">
                <button type="submit" class="btn btn-primary">Valider la sélection</button>
            </div>
        </div>
    </form>
</div>