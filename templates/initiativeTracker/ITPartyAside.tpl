<!-- Bordure droite qui sert de resize -->
<div class="resize-handle" role="separator" aria-label="Drag to resize panel"
    style="touch-action: none; -webkit-touch-callout: none; user-select: none">
    <div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- /-->

<!-- Listing des membres du groupe -->
<div class="aside-content">
    <h2>Personnages</h2>
    <button type="button" class="primary" data-action="show-add-modal">Ajouter un Personnage</button>
    <button type="button" class="secondary %1$s">Monter de niveau</button>
    <div class="character-list">
        <div class="empty %2$s">Aucun personnage pour le moment</div>
        %3$s
        <!--
        <div class="character benched">
            <div class="emblem-container">
                <button title="Upload avatar">
                    <i class="fa-solid fa-shield-halved" aria-hidden="true"></i><!---->
                </button> <!---->
            </div>
            <div class="character-details">
                <div class="character-name">
                    <span class="character-name-text">Aaron</span>
                    <span class="isBenched">benched</span>
                    <button title="Grant Inspiration">
                        <i aria-hidden="true" class="fa-regular fa-star"></i>
                    </button>
                </div>
                <div class="character-stats">Level 5 • AC 15 • 34 HP • DEX +6 • Passive 15</div>
            </div>
            <div class="buttons">
                <button title="Add to Combat" class="btn-add">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                </button>

                <button title="Edit" class="btn-edit">
                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                </button>
                <button title="Delete" class="btn-delete">
                    <i class="fa-solid fa-trash-alt" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        -->
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
<!-- /-->

<!-- Popup d'ajout d'un personnage -->
<div role="dialog" aria-modal="true" aria-label="Ajouter un Personnage"
    class="overlay d-none" tabindex="-1" data-target="add-modal">
    <div class="modal-box">
        <div class="modal-header">
            <h3 class="modal-title"><i class="fa-solid fa-plus" aria-hidden="true"></i> Ajouter un Personnage</h3>
            <button class="modal-close" aria-label="Close"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
        </div>
        <div class="modal-body">
            <form class="modal-section">
                <input aria-label="Player name" placeholder="Nom du personnage" class="input">
                <div class="fields-container">
                    <label class="field">
                        <span class="field-label" title="Le niveau de départ du personnage">Niveau</span>
                        <input type="number" min="1" max="20" class="field-input">
                    </label>
                </div>
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
                <button type="submit" class="button action">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    Ajouter un Personnage
                </button>
            </form>
        </div>
    </div>
</div>
<!-- /-->
