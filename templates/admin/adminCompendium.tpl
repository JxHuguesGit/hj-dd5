    <style>
        #wpbody-content {padding-bottom: 0;}
        .table td {line-height: 15px; font-size: 14px;}
    </style>
  	<main id="compendium-app">
		<div style="position:relative;" class="container">
			<div class="container-fluid" name="compendium-app">

                <div class="table-responsive" style="%2$s">
                    %1$s
                </div>

			</div>
		</div>
  	</main>

    <!-- Modale -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- En-tête (facultatif) -->
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Titre de la modale</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <!-- Corps de la modale -->
                <div id="modalBody" class="modal-body">
                    Voici l'information que vous souhaitez afficher.
                </div>

                <!-- Pied de la modale -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>