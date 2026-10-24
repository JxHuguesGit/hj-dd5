<!-- Bordure droite qui sert de resize -->
<div class="resize-handle" role="separator" aria-label="Drag to resize panel"
    style="touch-action: none; -webkit-touch-callout: none; user-select: none">
    <div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- / -->

<!-- Listing des membres du groupe -->
<div class="aside-content">
    <h2>Personnages</h2>
    <button type="button" class="primary" data-action="show-add-modal">Ajouter un Personnage</button>
    <button type="button" class="secondary %1$s" data-action="show-lvlup-modal">Monter de niveau</button>
    <div class="character-list">
        <div class="empty %2$s">Aucun personnage pour le moment</div>
        %3$s
        <div class="edit-section d-none">
            <input class="input">
            <div class="fields-container">
                <label class="field">
                    <span class="field-label" title="CA du Personnage">CA</span>
                    <input type="number" min="1" max="30" class="field-input">
                </label>
                <label class="field">
                    <span class="field-label" title="PV max du Personnage">PV</span>
                    <input type="number" min="1" class="field-input">
                </label>
                <label class="field">
                    <span class="field-label" title="Modificateur de DEX du Personnage">DEX</span>
                    <input type="number" min="-10" max="10" class="field-input">
                </label>
                <label class="field">
                    <span class="field-label" title="Perception Passive du Personnage">Passive</span>
                    <input type="number" min="1" max="30" class="field-input">
                </label>
            </div>
            <div class="buttons-container">
                <button class="button primary">Save</button>
                <button class="button-cancel">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- / -->

<!-- Popup d'ajout d'un personnage -->
<div role="dialog" aria-modal="true" aria-label="Ajouter un Personnage"
    class="overlay d-none" tabindex="-1" data-target="add-modal">
    <div class="modal-box">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fa-solid fa-plus" aria-hidden="true"></i> Ajouter un Personnage</h3>
            <button class="modal-close" aria-label="Close"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
        </div>
        <div class="modal-body">
            <form class="modal-section" id="add-character">
                <input aria-label="Player name" placeholder="Nom du personnage" name="itCharName" class="input">
                <div class="fields-container">
                    <label class="field">
                        <span class="field-label" title="Le niveau de départ du personnage">Niveau</span>
                        <input type="number" min="1" max="20" name="itCharLevel" class="field-input">
                    </label>
                </div>
                <div class="fields-container">
                    <label class="field">
                        <span class="field-label" title="CA du Personnage">CA</span>
                        <input type="number" min="1" max="30" name="itCharCA" class="field-input">
                    </label>
                    <label class="field">
                        <span class="field-label" title="PV max du Personnage">PV</span>
                        <input type="number" min="1" name="itCharMaxPV" class="field-input">
                    </label>
                    <label class="field">
                        <span class="field-label" title="Modificateur de DEX du Personnage">DEX</span>
                        <input type="number" min="-10" max="10" name="itCharModDex" class="field-input">
                    </label>
                    <label class="field">
                        <span class="field-label" title="Perception Passive du Personnage">Passive</span>
                        <input type="number" min="1" max="30" name="itCharPassive" class="field-input">
                    </label>
                </div>
                <button type="submit" class="button action">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    Ajouter un Personnage
                </button>
            </form>
        </div>
    </div>
</div>
<!-- / -->

<!-- Popup montée de niveau du groupe -->
<div role="dialog" aria-modal="true" aria-label="Monter de niveau"
    class="overlay d-none" tabindex="-1" data-target="lvlUp-modal">
    <div class="modal-box violet">
        <div class="modal-header">
            <div>
                <h3 class="modal-title">Monter de niveau</h3>
                <p class="subtitle">Tintin • Personnage 1 sur 2</p>
            </div>
            <button class="modal-close" aria-label="Close"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
        </div>
        <div class="modal-body">
            <div class="panel-info">
                <div class="emblem-container">
                    <button><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></button>
                </div>
                <div class="character-name" style="display:block;">
                    <div class="character-name-text">Tintin</div>
                    <div class="character-stats" title="CA — Classe d'armure PV — Points de vie" data-abbr-auto="">Avant : Niveau 1 • CA 10 • 10 PV</div>
                </div>
            </div>
            <label class="field">
                <span class="field-label">Niveau</span>
                <input type="number" min="1" max="20" class="field-input">
            </label>
            <div class="fields-container grid2">
                <label class="field">
                    <span class="field-label" title="CA — Classe d'armure" data-abbr-auto="">CA</span>
                    <input type="number" min="1" max="30" class="field-input">
                </label>
                <label class="field">
                    <span class="field-label" title="Max PV — Maximum Points de vie" data-abbr-auto="">Max PV</span>
                    <input type="number" min="1" class="field-input">
                </label>
            </div>
            <div class="fields-container grid2">
                <label class="field">
                    <span class="field-label" title="DEX — Dexterité" data-abbr-auto="">DEX</span>
                    <input type="number" min="-10" max="10" class="field-input">
                </label>
                <label class="field">
                    <span class="field-label">Passive</span>
                    <input type="number" min="1" max="30" class="field-input">
                </label>
            </div>
        </div>
        <div class="modal-footer">
            <button class="button-back" disabled="">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Back
            </button>
            <button class="button-next">
                Save &amp; Next <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
<!-- / -->
