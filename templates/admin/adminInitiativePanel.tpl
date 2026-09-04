<link rel="stylesheet" crossorigin="" href="%1$sassets/styles/initiative.css?v=%2$s">

<main class="dm-main dm-main--3col" style="grid-template-columns: 260px 6px 1fr 6px 340px" data-combat-id="%3$s">
	<section class="dm-col dm-col--left">
        <div class="left-panel">
            <div class="left-panel__tabs">
                <button type="button" class="left-panel__tab left-panel__tab--active" data-tab="creatures">Creatures</button>
                <button type="button" class="left-panel__tab d-none" data-tab="spells" disabled>Spells</button>
                <button type="button" class="left-panel__tab" data-tab="characters" disabled>Characters</button>
                <button type="button" class="left-panel__tab d-none" data-tab="encounters" disabled>Saved Encounters</button>
            </div>

            <div class="left-panel__content">
                <section class="combat-search" data-tab-content="creatures">
                    <div class="combat-search__filters">
                        <div class="form-group combat-search__name">
                            <label for="combat-creature-search" class="d-none">Creature</label>
                            <input id="combat-creature-search" class="combat-search__input" type="search" placeholder="Search by name..." autocomplete="off">
                        </div>
                        <div class="combat-search__filter-row">
                            <div class="form-group">
                                <label for="combat-creature-reference" class="d-none">Source</label>
                                <select id="combat-creature-reference" class="combat-search__select">
                                    <option value="">All Sources</option>
                                    <option value="1">Manuel des Monstres</option>
                                    <option value="2">Manuel des Joueurs</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="combat-creature-cr" class="d-none">Challenge</label>
                                <select id="combat-creature-cr" class="combat-search__select">
                                    <option value="">All CRs</option>
                                    <option value="0">CR 0</option><option value="1/8">CR 1/8</option><option value="1/4">CR 1/4</option><option value="1/2">CR 1/2</option><option value="1">CR 1</option><option value="2">CR 2</option><option value="3">CR 3</option><option value="4">CR 4</option><option value="5">CR 5</option><option value="6">CR 6</option><option value="7">CR 7</option><option value="8">CR 8</option><option value="9">CR 9</option><option value="10">CR 10</option><option value="11">CR 11</option><option value="12">CR 12</option><option value="13">CR 13</option><option value="14">CR 14</option><option value="15">CR 15</option><option value="16">CR 16</option><option value="17">CR 17</option><option value="18">CR 18</option><option value="19">CR 19</option><option value="20">CR 20</option><option value="21">CR 21</option><option value="22">CR 22</option><option value="23">CR 23</option><option value="24">CR 24</option><option value="25">CR 25</option><option value="26">CR 26</option><option value="27">CR 27</option><option value="28">CR 28</option><option value="29">CR 29</option><option value="30">CR 30</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="combat-search__results">
                        <div class="combat-search__list" id="combat-creature-list"></div>

                        <button type="button" class="btn btn--secondary combat-search__more" hidden>Show more</button>
                    </div>
                </section>

                <section class="left-panel__tab-content" data-tab-content="spells" hidden></section>

                <section class="left-panel__tab-content" data-tab-content="characters" hidden></section>

                <section class="left-panel__tab-content" data-tab-content="encounters" hidden></section>
            </div>
        </div>
    </section>

	<div class="resize-handle resize-handle--left" role="separator" aria-orientation="vertical" aria-label="Resize left panel"></div>

	<section class="dm-col dm-col--center">
        <div class="panel" id="panel-turns">%4$s</div>
        <div class="panel panel--grow" id="panel-initiative">
            <h2 class="panel__title">Ordre d'initiative</h2>
            <div id="combatant-list">%5$s</div>
        </div>
    </section>

	<div class="resize-handle resize-handle--right" role="separator" aria-orientation="vertical" aria-label="Resize right panel"></div>    

	<section class="dm-col dm-col--right"></section>
</main>

<div class="modal-backdrop d-none" role="dialog" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-header">
            <h2><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-swords" aria-hidden="true"><polyline points="14.5 17.5 3 6 3 3 6 3 17.5 14.5"></polyline><line x1="13" x2="19" y1="19" y2="13"></line><line x1="16" x2="20" y1="16" y2="20"></line><line x1="19" x2="21" y1="21" y2="19"></line><polyline points="14.5 6.5 18 3 21 3 21 6 17.5 9.5"></polyline><line x1="5" x2="9" y1="14" y2="18"></line><line x1="7" x2="4" y1="17" y2="20"></line><line x1="3" x2="5" y1="19" y2="21"></line></svg> Start Combat</h2>
            <button class="btn btn--remove modal-close" aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>
        </div>
        <div class="modal-body">
            <p class="modal-instructions">Enter initiative scores for <strong>player characters</strong>. Monster and NPC initiatives have been auto-rolled (1d20 + modifier) — use <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw" aria-hidden="true"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg> to reroll any result.</p>
            <div class="start-combat-rows">
                <div class="start-combat-row">
                    <span class="start-combat-row__name">Tim</span>
                    <span class="type-badge npc">NPC</span>
                    <span class="start-combat-row__roll">9<span class="start-combat-roll-breakdown">(11-2)</span></span>
                    <button class="btn btn--reroll" title="Re-roll initiative" aria-label="Re-roll initiative for Tim"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw" aria-hidden="true"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg></button>
                </div>
                <div class="start-combat-row">
                    <span class="start-combat-row__name">Aria</span>
                    <span class="type-badge player">PC</span>
                    <input class="start-combat-initiative-input" placeholder="Initiative" min="-5" max="30" type="number" value="">
                </div>
                <div class="start-combat-row">
                    <span class="start-combat-row__name">Bob</span>
                    <span class="type-badge player">PC</span>
                    <input class="start-combat-initiative-input" placeholder="Initiative" min="-5" max="30" type="number" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn--secondary">Cancel</button>
                <button class="btn btn--primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play" aria-hidden="true"><path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"></path></svg> Begin Combat!</button>
            </div>
        </div>
    </div>
</div>

<script src="%1$sassets/js/combat.js?v=%2$s"></script>