<link rel="stylesheet" crossorigin="" href="https://dd5.jhugues.fr/wp-content/plugins/hj-dd5/assets/styles/index-tracker.css">
<link rel="stylesheet" crossorigin="" href="https://dd5.jhugues.fr/wp-content/plugins/hj-dd5/assets/styles/tracker.css">

<main class="dm-main dm-main--3col" style="grid-template-columns: 260px 6px 1fr 6px 340px">
	<section class="dm-col dm-col--left">
    
<div class="left-panel">
    <div class="left-panel__tabs">
        <button class="left-panel__tab">Creatures</button>
        <button class="left-panel__tab">Spells</button>
        <button class="left-panel__tab left-panel__tab--active">Characters</button>
        <button class="left-panel__tab">Saved Encounters</button>
    </div>
    <div class="left-panel__content">
        <div class="free-party">
            <div class="panel" id="panel-add">
                <h2 class="panel__title">Add to Encounter</h2>
                <form autocomplete="off">
                    <div class="form-row">
                        <div class="form-group form-group--grow">
                            <label for="input-name">Name</label>
                            <input id="input-name" placeholder="Aria the Bold" required="" maxlength="40" type="text" value="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group form-group--narrow">
                            <label for="input-hp">Max HP</label>
                            <input id="input-hp" placeholder="30" min="1" max="9999" required="" type="number" value="">
                        </div>
                        <div class="form-group form-group--xnarrow">
                            <label for="input-ac">AC</label>
                            <input id="input-ac" placeholder="10" min="1" max="30" type="number" value="16">
                        </div>
                        <div class="form-group form-group--xnarrow">
                            <label for="input-init-mod">Init ±</label>
                            <input id="input-init-mod" placeholder="0" min="-10" max="10" type="number" value="-2">
                        </div>
                        <div class="form-group form-group--grow">
                            <label for="input-type">Type</label>
                            <select id="input-type">
                                <option value="player">Player</option>
                                <option value="npc">NPC</option>
                            </select>
                        </div>
                        <div class="form-group form-group--auto">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn--primary btn--full">+ Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="left-panel__content">
        <div class="system-toggle">
            <button class="system-toggle__btn system-toggle__btn--active" aria-pressed="true">5E</button>
            <button class="system-toggle__btn" aria-pressed="false">PF2E</button>
        </div>
        <div class="monster-db">
            <div class="monster-db__filters">
                <input class="monster-db__search" placeholder="Search by name..." type="text" value="">
                <div class="monster-db__filter-row">
                    <select class="monster-db__select">
                        <option value="">All Sources</option>
                        <option value="5.1_srd">5.1 SRD (2015 MM) (322)</option>
                    </select>
                    <select class="monster-db__select">
                        <option value="">All CRs</option>
                        <option value="0">CR 0</option>
                        <option value="1/8">CR 1/8</option>
                        <option value="1/4">CR 1/4</option>
                        <option value="1/2">CR 1/2</option>
                        <option value="1">CR 1</option>
                        <option value="2">CR 2</option>
                        <option value="3">CR 3</option>
                        <option value="4">CR 4</option>
                        <option value="5">CR 5</option>
                        <option value="6">CR 6</option>
                        <option value="7">CR 7</option>
                        <option value="8">CR 8</option>
                        <option value="9">CR 9</option>
                        <option value="10">CR 10</option>
                        <option value="11">CR 11</option>
                        <option value="12">CR 12</option>
                        <option value="13">CR 13</option>
                        <option value="14">CR 14</option>
                        <option value="15">CR 15</option>
                        <option value="16">CR 16</option>
                        <option value="17">CR 17</option>
                        <option value="18">CR 18</option>
                        <option value="19">CR 19</option>
                        <option value="20">CR 20</option>
                        <option value="21">CR 21</option>
                        <option value="22">CR 22</option>
                        <option value="23">CR 23</option>
                        <option value="24">CR 24</option>
                        <option value="25">CR 25</option>
                        <option value="26">CR 26</option>
                        <option value="27">CR 27</option>
                        <option value="28">CR 28</option>
                        <option value="29">CR 29</option>
                        <option value="30">CR 30</option>
                    </select>
                </div>
            </div>
            <div class="monster-db__count">Showing demo monsters — subscribe for 5,700+</div>
            <div class="monster-db__list">
                <div class="monster-db__empty">No monsters match your filters.</div>
            </div>
        </div>
    </div>
</div>

    </section>
	<div class="resize-handle resize-handle--left" role="separator" aria-orientation="vertical" aria-label="Resize left panel"></div>    
	<section class="dm-col dm-col--center">

<div class="panel" id="panel-turns"><button class="btn btn--combat-start btn--full"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-swords" aria-hidden="true"><polyline points="14.5 17.5 3 6 3 3 6 3 17.5 14.5"></polyline><line x1="13" x2="19" y1="19" y2="13"></line><line x1="16" x2="20" y1="16" y2="20"></line><line x1="19" x2="21" y1="21" y2="19"></line><polyline points="14.5 6.5 18 3 21 3 21 6 17.5 9.5"></polyline><line x1="5" x2="9" y1="14" y2="18"></line><line x1="7" x2="4" y1="17" y2="20"></line><line x1="3" x2="5" y1="19" y2="21"></line></svg> Start Combat</button></div>

<div class="panel" id="panel-turns"><div class="turn-controls"><button class="btn btn--nav" disabled=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left" aria-hidden="true"><path d="m15 18-6-6 6-6"></path></svg> Prev</button><div class="turn-info"><div class="turn-info__round">Round <span>1</span></div><div class="turn-info__name">Tim</div></div><button class="btn btn--nav" title="Spacebar">Next <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg><kbd class="kbd-hint">Space</kbd></button></div><button class="btn btn--danger btn--full" style="margin-top: 8px;">End Combat</button></div>

<div class="panel panel--grow" id="panel-initiative"><h2 class="panel__title">Initiative Order</h2><div id="combatant-list"><div class="combatant-card" data-id="combatant_1788264910493_odzqq" draggable="true"><div class="combatant-card__row"><span class="drag-handle" title="Drag to reorder" role="img" aria-label="Drag to reorder"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-grip-vertical" aria-hidden="true"><circle cx="9" cy="12" r="1"></circle><circle cx="9" cy="5" r="1"></circle><circle cx="9" cy="19" r="1"></circle><circle cx="15" cy="12" r="1"></circle><circle cx="15" cy="5" r="1"></circle><circle cx="15" cy="19" r="1"></circle></svg></span><span class="combatant-card__initiative combatant-card__initiative--dim">—</span><span class="combatant-card__name">Tim</span><span class="type-icon type-icon--npc" title="NPC"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span><span class="ac-badge" title="Armor Class">AC 16</span><div class="combatant-card__right"><span class="hp-text hp-text--high">20/20</span><input class="hp-input" placeholder="10" min="1" max="9999" title="Enter amount, then press Enter or click Dmg/Heal. Shift+Enter for opposite action." type="number" value=""><button class="btn btn--dmg">Dmg</button><button class="btn btn--heal">Heal</button><button class="btn btn--remove" title="Remove Tim" aria-label="Remove Tim"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button></div></div></div><div class="combatant-card" data-id="combatant_1788264833037_jhwkj" draggable="true"><div class="combatant-card__row"><span class="drag-handle" title="Drag to reorder" role="img" aria-label="Drag to reorder"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-grip-vertical" aria-hidden="true"><circle cx="9" cy="12" r="1"></circle><circle cx="9" cy="5" r="1"></circle><circle cx="9" cy="19" r="1"></circle><circle cx="15" cy="12" r="1"></circle><circle cx="15" cy="5" r="1"></circle><circle cx="15" cy="19" r="1"></circle></svg></span><span class="combatant-card__initiative combatant-card__initiative--dim">—</span><span class="combatant-card__name">Aria</span><span class="type-icon type-icon--player" title="Player"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg></span><span class="ac-badge" title="Armor Class">AC 10</span><div class="combatant-card__right"><span class="hp-text hp-text--high">27/30</span><input class="hp-input" placeholder="10" min="1" max="9999" title="Enter amount, then press Enter or click Dmg/Heal. Shift+Enter for opposite action." type="number" value=""><button class="btn btn--dmg">Dmg</button><button class="btn btn--heal">Heal</button><button class="btn btn--remove" title="Remove Aria" aria-label="Remove Aria"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button></div></div></div><div class="combatant-card" data-id="combatant_1788264880534_1nlsu" draggable="true"><div class="combatant-card__row"><span class="drag-handle" title="Drag to reorder" role="img" aria-label="Drag to reorder"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-grip-vertical" aria-hidden="true"><circle cx="9" cy="12" r="1"></circle><circle cx="9" cy="5" r="1"></circle><circle cx="9" cy="19" r="1"></circle><circle cx="15" cy="12" r="1"></circle><circle cx="15" cy="5" r="1"></circle><circle cx="15" cy="19" r="1"></circle></svg></span><span class="combatant-card__initiative combatant-card__initiative--dim">—</span><span class="combatant-card__name">Bob</span><span class="type-icon type-icon--player" title="Player"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg></span><span class="ac-badge" title="Armor Class">AC 12</span><div class="combatant-card__right"><span class="hp-text hp-text--high">25/25</span><input class="hp-input" placeholder="10" min="1" max="9999" title="Enter amount, then press Enter or click Dmg/Heal. Shift+Enter for opposite action." type="number" value=""><button class="btn btn--dmg">Dmg</button><button class="btn btn--heal">Heal</button><button class="btn btn--remove" title="Remove Bob" aria-label="Remove Bob"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button></div></div></div></div></div>

<div class="panel panel--grow" id="panel-initiative"><h2 class="panel__title">Initiative Order</h2><div id="combatant-list"><div class="combatant-card combatant-card--active" data-id="combatant_1788264880534_1nlsu" draggable="true"><div class="combatant-card__row"><span class="drag-handle" title="Drag to reorder" role="img" aria-label="Drag to reorder"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-grip-vertical" aria-hidden="true"><circle cx="9" cy="12" r="1"></circle><circle cx="9" cy="5" r="1"></circle><circle cx="9" cy="19" r="1"></circle><circle cx="15" cy="12" r="1"></circle><circle cx="15" cy="5" r="1"></circle><circle cx="15" cy="19" r="1"></circle></svg></span><span class="combatant-card__initiative combatant-card__initiative--editable" title="Edit initiative to reorder" role="button" tabindex="0" aria-label="Initiative 5 for Bob. Edit to reorder.">5</span><span class="combatant-card__active-arrow" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right" aria-hidden="true"><path d="m9 18 6-6-6-6"></path></svg></span><span class="combatant-card__name">Bob</span><span class="type-icon type-icon--player" title="Player"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg></span><span class="ac-badge" title="Armor Class">AC 12</span><div class="combatant-card__right"><span class="hp-text hp-text--high">25/25</span><input class="hp-input" placeholder="10" min="1" max="9999" title="Enter amount, then press Enter or click Dmg/Heal. Shift+Enter for opposite action." type="number" value=""><button class="btn btn--dmg">Dmg</button><button class="btn btn--heal">Heal</button><button class="btn btn--remove" title="Remove Bob" aria-label="Remove Bob"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button></div></div></div><div class="combatant-card" data-id="combatant_1788264833037_jhwkj" draggable="true"><div class="combatant-card__row"><span class="drag-handle" title="Drag to reorder" role="img" aria-label="Drag to reorder"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-grip-vertical" aria-hidden="true"><circle cx="9" cy="12" r="1"></circle><circle cx="9" cy="5" r="1"></circle><circle cx="9" cy="19" r="1"></circle><circle cx="15" cy="12" r="1"></circle><circle cx="15" cy="5" r="1"></circle><circle cx="15" cy="19" r="1"></circle></svg></span><span class="combatant-card__initiative combatant-card__initiative--editable" title="Edit initiative to reorder" role="button" tabindex="0" aria-label="Initiative 4 for Aria. Edit to reorder.">4</span><span class="combatant-card__name">Aria</span><span class="type-icon type-icon--player" title="Player"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg></span><span class="ac-badge" title="Armor Class">AC 10</span><div class="combatant-card__right"><span class="hp-text hp-text--high">27/30</span><input class="hp-input" placeholder="10" min="1" max="9999" title="Enter amount, then press Enter or click Dmg/Heal. Shift+Enter for opposite action." type="number" value=""><button class="btn btn--dmg">Dmg</button><button class="btn btn--heal">Heal</button><button class="btn btn--remove" title="Remove Aria" aria-label="Remove Aria"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button></div></div></div><div class="combatant-card" data-id="combatant_1788264910493_odzqq" draggable="true"><div class="combatant-card__row"><span class="drag-handle" title="Drag to reorder" role="img" aria-label="Drag to reorder"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-grip-vertical" aria-hidden="true"><circle cx="9" cy="12" r="1"></circle><circle cx="9" cy="5" r="1"></circle><circle cx="9" cy="19" r="1"></circle><circle cx="15" cy="12" r="1"></circle><circle cx="15" cy="5" r="1"></circle><circle cx="15" cy="19" r="1"></circle></svg></span><span class="combatant-card__initiative combatant-card__initiative--editable" title="Edit initiative to reorder" role="button" tabindex="0" aria-label="Initiative 3 for Tim. Edit to reorder.">3</span><span class="combatant-card__name">Tim</span><span class="type-icon type-icon--npc" title="NPC"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user" aria-hidden="true"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span><span class="ac-badge" title="Armor Class">AC 16</span><div class="combatant-card__right"><span class="hp-text hp-text--high">20/20</span><input class="hp-input" placeholder="10" min="1" max="9999" title="Enter amount, then press Enter or click Dmg/Heal. Shift+Enter for opposite action." type="number" value=""><button class="btn btn--dmg">Dmg</button><button class="btn btn--heal">Heal</button><button class="btn btn--remove" title="Remove Tim" aria-label="Remove Tim"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button></div></div></div></div></div>

    </section>
	<div class="resize-handle resize-handle--right" role="separator" aria-orientation="vertical" aria-label="Resize right panel"></div>    
	<section class="dm-col dm-col--right">
    
<div class="right-panel"><div class="right-panel__content"><div class="content-viewer content-viewer--empty"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-open content-viewer__empty-icon" aria-hidden="true"><path d="M12 5v16"></path><path d="M20.001 19A2 2 0 0022 17V5a2 2 0 00-1.999-2L16 3.002A5 5 0 0012 5a5 5 0 00-4-2H4a2 2 0 00-2 2v12a2 2 0 001.999 2H8a5 5 0 014 2 5 5 0 014-2z"></path></svg><p class="content-viewer__empty-text">Select a creature or spell to view details</p></div></div></div>

    </section>
</main>

<div class="modal-backdrop d-none" role="dialog" aria-modal="true"><div class="modal-dialog"><div class="modal-header"><h2><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-swords" aria-hidden="true"><polyline points="14.5 17.5 3 6 3 3 6 3 17.5 14.5"></polyline><line x1="13" x2="19" y1="19" y2="13"></line><line x1="16" x2="20" y1="16" y2="20"></line><line x1="19" x2="21" y1="21" y2="19"></line><polyline points="14.5 6.5 18 3 21 3 21 6 17.5 9.5"></polyline><line x1="5" x2="9" y1="14" y2="18"></line><line x1="7" x2="4" y1="17" y2="20"></line><line x1="3" x2="5" y1="19" y2="21"></line></svg> Start Combat</h2><button class="btn btn--remove modal-close" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button></div><div class="modal-body"><p class="modal-instructions">Enter initiative scores for <strong>player characters</strong>. Monster and NPC initiatives have been auto-rolled (1d20 + modifier) — use <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw" aria-hidden="true"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg> to reroll any result.</p><div class="start-combat-rows"><div class="start-combat-row"><span class="start-combat-row__name">Tim</span><span class="type-badge npc">NPC</span><span class="start-combat-row__roll">9<span class="start-combat-roll-breakdown">(11-2)</span></span><button class="btn btn--reroll" title="Re-roll initiative" aria-label="Re-roll initiative for Tim"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw" aria-hidden="true"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg></button></div><div class="start-combat-row"><span class="start-combat-row__name">Aria</span><span class="type-badge player">PC</span><input class="start-combat-initiative-input" placeholder="Initiative" min="-5" max="30" type="number" value=""></div><div class="start-combat-row"><span class="start-combat-row__name">Bob</span><span class="type-badge player">PC</span><input class="start-combat-initiative-input" placeholder="Initiative" min="-5" max="30" type="number" value=""></div></div><div class="modal-footer"><button class="btn btn--secondary">Cancel</button><button class="btn btn--primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play" aria-hidden="true"><path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path></svg> Begin Combat!</button></div></div></div></div>