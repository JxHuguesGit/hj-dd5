<table class="table table-striped table-hover admin-token-table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Type</th>
            <th>Taille</th>
            <th>Association</th>
            <th>Actif</th>
            <th>
                <button
                    type="button"
                    class="btn btn-sm btn-primary ajaxAction"
                    data-trigger="click"
                    data-action="getAddTokenModal"
                    data-target="confirmModal"
                    id="addTokenButton"
                >
                    <i class="fa-solid fa-plus"></i>
                </button>
            </th>
        </tr>
    </thead>
    <tbody>
        %1$s
    </tbody>
</table>
