<form action="%5$s" method="post">
	<div class="row">
    	<div class="col-6">
            <div class="card p-0">
                <h5 class="card-header">Informations de base</h5>
                <div class="card-body">

                    <!-- Nom FR -->
                    <div class="mb-3">
                      <label for="name-fr" class="form-label">Nom <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" id="name" name="name" value="%1$s">
                    </div>

                    <!-- Capacités -->
                    %3$s

                </div>
                <div class="card-footer">
                </div>
            </div>
    	</div>
        <div class="col-6">
            <div class="card p-0">
                <div class="card-body">
                	<input type="submit" class="btn btn-primary" value="Soumettre"/>
                    <input type="hidden" name="formAction" value="editConfirm"/>
                    <input type="hidden" name="entityId" value="%4$s"/>
                	<a href="%5$s" class="btn btn-secondary">Annuler</a>
                </div>
            </div>
            <div class="card p-0">
                <h5 class="card-header">Outils</h5>
                <div class="card-body">

					<fieldset>
                    	<legend>Valeurs</legend>
                        <div class="btn-toolbar mb-3" role="toolbar">
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <button type="button" class="btn btn-sm btn-primary" data-val="1" data-action="fdmTool">1</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="2" data-action="fdmTool">2</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="3" data-action="fdmTool">3</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="4" data-action="fdmTool">4</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="5" data-action="fdmTool">5</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="6" data-action="fdmTool">6</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="7" data-action="fdmTool">7</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="8" data-action="fdmTool">8</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="9" data-action="fdmTool">9</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="10" data-action="fdmTool">10</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="11" data-action="fdmTool">11</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="12" data-action="fdmTool">12</button>
                            </div>
                        </div>
                    </fieldset>

					<fieldset>
                    	<legend>Dés</legend>
                        <div class="btn-toolbar mb-3" role="toolbar">
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <button type="button" class="btn btn-sm btn-primary" data-val="d4" data-action="fdmTool">d4</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="d6" data-action="fdmTool">d6</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="d8" data-action="fdmTool">d8</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="d10" data-action="fdmTool">d10</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="d12" data-action="fdmTool">d12</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="d20" data-action="fdmTool">d20</button>
                            </div>
                        </div>
                    </fieldset>
                    
					<fieldset>
                    	<legend>Ponctuation</legend>
                        <div class="btn-toolbar mb-3" role="toolbar">
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <button type="button" class="btn btn-sm btn-primary" data-val=" (" data-action="fdmTool">(</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=" + " data-action="fdmTool">+</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="m" data-action="fdmTool">m</button>
                            </div>
                        </div>
                    </fieldset>

					<fieldset>
                    	<legend>Actions légendaires</legend>
                        <div class="btn-toolbar mb-3" role="toolbar">
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <button type="button" class="btn btn-sm btn-primary" data-ref="ResLeg" data-action="fdmTool">Résistance légendaire</button>
                                <button type="button" class="btn btn-sm btn-primary" data-ref="UtiLeg" data-action="fdmTool">Utilisation légendaire</button>
                            </div>
                        </div>
                    </fieldset>

					<fieldset>
                    	<legend>Combats</legend>
                        <div class="btn-toolbar mb-3" role="toolbar">
                            <div class="btn-group me-2 mb-1" role="group">
                                <button type="button" class="btn btn-sm btn-primary" data-ref="AttCbt" data-action="fdmTool">Attaques multiples</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="[i]Corps à corps[/i] : +" data-action="fdmTool">Corps à corps</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=", allonge : " data-action="fdmTool">Allonge</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val="[i]À distance[/i] : +" data-action="fdmTool">À distance</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=", portée : " data-action="fdmTool">Portée</button>
                            </div>
                            <div class="btn-group me-2" role="group">
	                            <button type="button" class="btn btn-sm btn-primary" data-val=". [i]Touché[/i] : " data-action="fdmTool">Touché</button>
	                            <button type="button" class="btn btn-sm btn-primary" data-val=") dégâts" data-action="fdmTool">Dégâts</button>
                            </div>
                        </div>
                    </fieldset>

					<fieldset>
                    	<legend>Types de dégâts</legend>
                        <div class="btn-toolbar mb-3" role="toolbar">
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <button type="button" class="btn btn-sm btn-primary" data-val=" contondants" data-action="fdmTool">contondants</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=" perforants" data-action="fdmTool">perforants</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=" tranchants" data-action="fdmTool">tranchants</button>
                            </div>
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <button type="button" class="btn btn-sm btn-primary" data-val=" d'acide" data-action="fdmTool">acide</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=" psychique" data-action="fdmTool">psychique</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=" de poison" data-action="fdmTool">poison</button>
                            </div>
                        </div>
                    </fieldset>

					<fieldset>
                    	<legend>Cible</legend>
                        <div class="btn-toolbar mb-3" role="toolbar">
                            <div class="btn-group me-2 mb-1" role="group">
                                <button type="button" class="btn btn-sm btn-primary" data-val=", une créature" data-action="fdmTool">Une créature</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=", chaque créature" data-action="fdmTool">Chaque créature</button>
                            </div>
                        </div>
                    </fieldset>

					<fieldset>
                    	<legend>Zone</legend>
                        <div class="btn-toolbar mb-3" role="toolbar">
                            <div class="btn-group me-2 mb-1" role="group">
                                <button type="button" class="btn btn-sm btn-primary" data-val=", dans une Ligne de <X>m de long et 1.5m de large" data-action="fdmTool">Une ligne</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=", dans un Cône de <X>m" data-action="fdmTool">Un cône</button>
                            </div>
                        </div>
                    </fieldset>
                    
					<fieldset>
                    	<legend>Jets de Sauvegarde</legend>
                        <div class="btn-toolbar mb-3" role="toolbar">
                          <div class="btn-group me-2 mb-1" role="group">
                            <button type="button" class="btn btn-sm btn-primary" data-val="[i]JS Force[/i] : DD " data-action="fdmTool">Force</button>
                            <button type="button" class="btn btn-sm btn-primary" data-val="[i]JS Dextérité[/i] : DD " data-action="fdmTool">Dextérité</button>
                            <button type="button" class="btn btn-sm btn-primary" data-val="[i]JS Constitution[/i] : DD " data-action="fdmTool">Constitution</button>
                            <button type="button" class="btn btn-sm btn-primary" data-val="[i]JS Intelligence[/i] : DD " data-action="fdmTool">Intelligence</button>
                            <button type="button" class="btn btn-sm btn-primary" data-val="[i]JS Sagesse[/i] : DD " data-action="fdmTool">Sagesse</button>
                            <button type="button" class="btn btn-sm btn-primary" data-val="[i]JS Charisme[/i] : DD " data-action="fdmTool">Charisme</button>
                          </div>
                        </div>
                    </fieldset>

					<fieldset>
                    	<legend>Conséquences</legend>
                        <div class="btn-toolbar mb-3" role="toolbar">
                            <div class="btn-group me-2 mb-1" role="group">
                                <button type="button" class="btn btn-sm btn-primary" data-val=". [i]Réussite[/i] : " data-action="fdmTool">Réussite</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=". [i]Échec[/i] : " data-action="fdmTool">Échec</button>
                                <button type="button" class="btn btn-sm btn-primary" data-val=". [i]Échec ou réussite[/i] : " data-action="fdmTool">Échec ou réussite</button>
                            </div>
                            <div class="btn-group me-2" role="group">
	                            <button type="button" class="btn btn-sm btn-primary" data-val="demi-dégâts." data-action="fdmTool">demi-dégâts</button>
                            </div>
                        </div>
                    </fieldset>                
                    
                    <input type="hidden" id="ResLegName" value="Résistance légendaire (3/jour, or 4/jour dans son antre)"/>
                    <input type="hidden" id="ResLegDescription" value="Si <le monstre> rate un jet de sauvegarde, il peut décider de le réussir tout de même."/>
                    <input type="hidden" id="UtiLegDescription" value="[i]Utilisations d'action Légendaire : 3 (4 dans son antre). Aussitôt après le tour d'une autre créature, <le monstre> peut dépenser une utilisation pour entreprendre l'une des actions ci-après. <le monstre> récupère toutes ses utilisations dépensées au début de chacun de ses tours."/>
                    
                    <input type="hidden" id="AttCbtName" value="Attaques multiples"/>
                    <input type="hidden" id="AttCbtDescription" value="<le monstre> effectue deux attaques de <Nom attaque>, réparties à sa guise entre <Attaque 1> et <Attaque 2>."/>
                    <input type="hidden" id="CacCbtDescription" value="<X>, allonge <X>m."/>
                    <input type="hidden" id="AdsCbtDescription" value="<X>, portée <X>/<X>m."/>
                    <input type="hidden" id="DgtCbtDescription" value="<X> (<X>d<X> + <X>) dégâts <X>."/>



                </div>
            </div>
        </div>
    </div>
</form>