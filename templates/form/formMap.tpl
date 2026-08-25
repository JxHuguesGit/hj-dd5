<form action="%2$s" method="post" style="display: flex;" id="formFilter">
<div class="card map-edit-card">
    <div class="card-header">
        <h2>%1$s</h2>
    </div>

    <div class="card-body">
        <div class="form-group">
            <label for="map-name">Nom</label>
            <input
                type="text"
                id="map-name"
                name="name"
                class="form-control"
                value="%4$s"
                required
            >
        </div>

        <div class="form-group">
            <label for="map-image">Image</label>
            <input
                type="text"
                id="map-image"
                name="image"
                class="form-control"
                value="%5$s"
                required
            >
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="map-columns">Nombre de colonnes</label>
                    <input
                        type="number"
                        id="map-columns"
                        name="mapColumns"
                        class="form-control"
                        value="%6$s"
                        min="1"
                        required
                    >
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="map-rows">Nombre de lignes</label>
                    <input
                        type="number"
                        id="map-rows"
                        name="mapRows"
                        class="form-control"
                        value="%7$s"
                        min="1"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="map-cell-size">Taille des cellules (px)</label>
                    <input
                        type="number"
                        id="map-cell-size"
                        name="cellSize"
                        class="form-control"
                        value="%8$s"
                        min="1"
                        required
                    >
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="map-vision-range">Portée de vision</label>
                    <input
                        type="number"
                        id="map-vision-range"
                        name="visionRange"
                        class="form-control"
                        value="%9$s"
                        min="0"
                        required
                    >
                </div>
            </div>
        </div>

        <div class="map-edit-actions">
            <a
                href="%10$s"
                class="btn btn-default"
            >
                Annuler
            </a>
            <input type="hidden" name="mapId" value="%3$s"/>
            <button
                type="submit"
                class="btn btn-primary"
            >
                Enregistrer
            </button>
        </div>
    </div>
</div>
</form>