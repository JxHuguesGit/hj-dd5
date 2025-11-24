<div class="container-fluid py-4">
    <div class="row">
        %1$s
        <!-- Zone principale -->
        <div class="col-md-6">
            <div class="card bg-light shadow-sm p-0 mw-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Choisir compétences et outils</h5>
                </div>
                <div class="card-body">

                <!-- Sélection avec radio boutons -->
                    <form method="post" action="/wp-admin/admin.php?page=hj-dd5/admin_manage.php&onglet=character">
                    	<h5>Origine</h5>
                        <div class="mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px 20px;">
                            <div id="origin-skills-list" class="origin-skills-column">%3$s</div>
                            <div id="origin-tools-list" class="origin-tools-column">%4$s</div>
                        </div>
                    	<h5>Classe (<span id="nbClasseSkills">%5$s</span>)</h5>
                        <div class="mb-3">
                            <div id="classe-skills-list" class="classe-skills-column" style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px 20px;">%6$s</div>
                        </div>
                        <!--
                    	<h5>Autres</h5>
                        <div class="mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px 20px;">
                            <div id="other-skills-list" class="other-skills-column">%7$s</div>
                            <div id="other-tools-list" class="other-tools-column">%8$s</div>
                        </div>
                        -->

                        <div class="text-end">
                            <input type="hidden" id="characterId" name="characterId" value="%2$s"/>
                            <input type="hidden" id="herosForm" name="herosForm" value="skillTool"/>
                            <button class="btn btn-sm btn-dark" id="createProcess">Continuer</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light shadow-sm p-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Compétence et outil</h5>
                </div>
                <div id="creationStepSideBody" class="card-body">%9$s</div>
            </div>
        </div>
    </div>
</div>