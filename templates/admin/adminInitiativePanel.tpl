<!-- Font Awesome Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" crossorigin="" href="%1$sassets/styles/initiative.css?v=%2$s">
<link rel="stylesheet" crossorigin="" href="%1$sassets/styles/draft.css?v=%2$s">
    <!--
    -->
%3$s
<div class="initiative-menu initiative-tracker-menu hidden">
<!--
    <button title="Expand or collapse this section" class="flex w-full items-center justify-between px-4 pt-2.5 pb-1 text-left text-[10px] font-bold tracking-wider text-gray-500 uppercase transition hover:text-gray-300 svelte-x1i5gj">
        Session Tools <i aria-hidden="true" class="fa-solid fa-chevron-down shrink-0 text-xs transition-transform -rotate-90 svelte-x1i5gj"></i>
    </button>
    <button title="Expand or collapse this section" class="flex w-full items-center justify-between border-t border-gray-700 px-4 pt-2.5 pb-1 text-left text-[10px] font-bold tracking-wider text-gray-500 uppercase transition hover:text-gray-300 svelte-x1i5gj">
        Campaign <i aria-hidden="true" class="fa-solid fa-chevron-down shrink-0 text-xs transition-transform -rotate-90 svelte-x1i5gj"></i>
    </button>
    <button title="Expand or collapse this section" class="flex w-full items-center justify-between border-t border-gray-700 px-4 pt-2.5 pb-1 text-left text-[10px] font-bold tracking-wider text-gray-500 uppercase transition hover:text-gray-300 svelte-x1i5gj">
        Account <i aria-hidden="true" class="fa-solid fa-chevron-down shrink-0 text-xs transition-transform -rotate-90 svelte-x1i5gj"></i>
    </button>
    <button title="Expand or collapse this section" class="flex w-full items-center justify-between border-t border-gray-700 px-4 pt-2.5 pb-1 text-left text-[10px] font-bold tracking-wider text-gray-500 uppercase transition hover:text-gray-300 svelte-x1i5gj">
        Display <i aria-hidden="true" class="fa-solid fa-chevron-down shrink-0 text-xs transition-transform -rotate-90 svelte-x1i5gj"></i>
    </button>
-->
    <a href="https://dd5.jhugues.fr/wp-admin/admin.php?page=hj-dd5/admin_manage.php" rel="noopener noreferrer" title="Retour à l'admin">Retour à l'admin</a>
</div>

<div class="initiative-body">
    <aside class="party" aria-label="">%4$s</aside>
    <main class="initiative-main">
        <div class="active-combatants %6$s">
            <div class="panel-header %9$s">%7$s</div>

            <div class="initiative-main-content">
                %8$s
                <p>Add players and enemies, then enter initiative rolls to begin.</p>

                <div role="dialog" aria-modal="true" aria-label="Edit max HP"
                    class="d-none overlay" tabindex="-1" data-target="edit-maxHp-monster">
                    <div class="edit-maxHp-monster">
                        <div class="panel-header">
                            <div>
                                <h3 title="Max HP — Maximum Hit Points" data-abbr-auto="">Edit Max HP</h3>
                                <p>Zombie 1</p>
                            </div>
                            <button aria-label="Close" class="close-button">
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="panel-body">
                            <label for="edit-max-hp" title="Maximum de Points de Vie" data-abbr-auto="">PV max</label>
                            <input id="edit-max-hp" type="number" min="1" class="input-field">
                        </div>
                        <div class="panel-footer">
                            <button class="confirm-button">Save</button>
                        </div>
                    </div>
                </div>

                <div role="presentation" class="d-none overlay" data-target="edit-conditions">
                    <div class="edit-condition">
                        <div class="edit-condition-header">
                            <i class="fa-solid fa-stopwatch" aria-hidden="true"></i>
                            <span class="edit-condition-header-title">Ajouter un Etat</span>
                        </div>
                        <div class="edit-condition-body">
                            <p class="edit-condition-description">Ajouter <span class="condition-name" id="condition-label">Grappled</span> à <span class="target-name" title="Animated Armor 1" data-clip-auto="" id="target-label">Animated Armor 1</span></p>
                            <p class="edit-condition-help">Combien de temps cet état doit-il durer ?</p>
                            <div class="duration-container">
                                <label for="condition-rounds-input" class="duration-label">Rounds</label>
                                <input id="condition-rounds-input" type="number" min="1" max="99" class="condition-rounds-input">
                            </div>
                        </div>
                        <div class="edit-condition-footer">
                            <button id="condition-submit" class="condition-btn-add">Ajouter (<span id="condition-duration">1 round</span>)</button>
                            <button id="condition-no-limit" class="condition-btn-unlimited">Aucune limite</button>
                            <button aria-label="Annuler" class="close-condition-modal">
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="dialog" aria-modal="true" aria-label="Fiche de monstre" class="panel-show-monster overlay d-none" tabindex="-1">
        </div>
    </main>
    <aside class="ennemies" aria-label="">%5$s</aside>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
    integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="module" src="%1$sassets/js/initiative/init-main.js?v=%2$s"></script>
<!--
<script src="%1$sassets/js/initiative.js?v=%2$s"></script>
<script src="%1$sassets/js/combat.js?v=%2$s"></script>
<script src="%1$sassets/js/draft.js?v=%2$s"></script>
-->
