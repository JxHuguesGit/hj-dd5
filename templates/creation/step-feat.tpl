<div class="container-fluid py-4">
    <div class="row">
        %1$s
        <!-- Zone principale -->
        <div class="col-md-9">
            <div class="card bg-light shadow-sm p-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Choisir le don d'origine</h5>
                </div>
                <div class="card-body">

                <!-- Sélection avec radio boutons -->
                    <form method="post" action="/wp-admin/admin.php?page=hj-dd5/admin_manage.php&onglet=character">
                        <div class="mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px 20px;">
                            <div id="feats-list" class="feats-column">
                                <strong>Don d'origine</strong>
                                %3$s
                            </div>
                            <div id="extrafeat-list" class="feats-column%4$s">
                                <strong>Deuxième don d'origine</strong>
                                %5$s
                            </div>
                        </div>
                        <div class="mb-3" style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px 20px;">
                            <div id="feats-list" class="feats-column">
                                <div class="%6$s">
                                <strong>Classe associée</strong>
                                %7$s
                                </div>
                            </div>
                            <div id="extrafeat-list" class="feats-column%8$s">
                                <strong>Classe associée</strong>
                                %9$s
                            </div>
                        </div>

                        <div class="text-end">
                            <input type="hidden" id="characterId" name="characterId" value="%2$s"/>
                            <input type="hidden" id="herosForm" name="herosForm" value="selectFeats"/>
                            <button class="btn btn-sm btn-dark" id="createProcess">Continuer</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
