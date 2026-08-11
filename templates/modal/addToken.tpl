<div class="mb-3">
    <label for="tokenName" class="form-label">Nom</label>
    <input type="text" id="tokenName" name="name" class="form-control">
</div>

<div class="mb-3">
    <label for="tokenImage" class="form-label">Image</label>
    <input type="text" id="tokenImage" name="image" class="form-control">
</div>

<div class="mb-3">
    <label for="tokenType" class="form-label">Type</label>
    <select id="tokenType" name="type" class="form-select">
        <option value="monster">Monstre</option>
        <option value="character">Personnage</option>
    </select>
</div>

<div class="mb-3" id="tokenMonsterContainer">
    <label for="tokenMonsterId" class="form-label">Monstre associé</label>
    <select id="tokenMonsterId" name="monsterId" class="form-select">
        %1$s
    </select>
</div>

<div class="row">
    <div class="col-md-6">
        <label for="tokenSize" class="form-label">Taille</label>
        <input type="number" id="tokenSize" name="size" class="form-control" min="1" value="1">
    </div>

    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check mb-2">
            <input
                type="checkbox"
                id="tokenActive"
                name="active"
                class="form-check-input"
                value="1"
                checked
            >
            <label for="tokenActive" class="form-check-label">Actif</label>
        </div>
    </div>
</div>