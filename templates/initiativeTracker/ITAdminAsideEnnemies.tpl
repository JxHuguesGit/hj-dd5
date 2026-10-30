<div class="resize-handle" role="separator" aria-label="Drag to resize panel"
    style="touch-action: none; -webkit-touch-callout: none; user-select: none">
    <div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<div class="aside-content">
    <div class="panel-header">
        <h2>Ennemis / PNJs</h2>
        <div>
            <button title="Manage custom monsters" class="flex items-center gap-1 rounded border border-gray-700 bg-gray-800 px-2 py-1 text-xs text-gray-400 transition hover:border-amber-600 hover:text-amber-300"><i class="fa-solid fa-plus text-sm" aria-hidden="true"></i> Custom</button>
        </div>
    </div>
    <div class="panel-filters">
        <input placeholder="Chercher un monstre...">
        <!--
        <div class="flex gap-2">
            <select class="flex-1 rounded border border-gray-600 bg-gray-900 px-2 py-1 text-sm text-white focus:border-red-500 focus:outline-none"><option value="All" selected="">All</option><option value="Aberration">Aberration</option><option value="Aberration (Beholder)">Aberration (Beholder)</option><option value="Aberration (Gith)">Aberration (Gith)</option><option value="Beast">Beast</option><option value="Beast (Dinosaur)">Beast (Dinosaur)</option><option value="Celestial">Celestial</option><option value="Celestial (Angel)">Celestial (Angel)</option><option value="Celestial or Fiend (Titan)">Celestial or Fiend (Titan)</option><option value="Construct">Construct</option><option value="Construct (Titan)">Construct (Titan)</option><option value="Dragon">Dragon</option><option value="Dragon (Chromatic)">Dragon (Chromatic)</option><option value="Dragon (Metallic)">Dragon (Metallic)</option><option value="Elemental">Elemental</option><option value="Elemental (Genie)">Elemental (Genie)</option><option value="Elemental (Titan)">Elemental (Titan)</option><option value="Fey">Fey</option><option value="Fey (Goblinoid)">Fey (Goblinoid)</option><option value="Fiend">Fiend</option><option value="Fiend (Demon)">Fiend (Demon)</option><option value="Fiend (Devil)">Fiend (Devil)</option><option value="Fiend (Yugoloth)">Fiend (Yugoloth)</option><option value="Giant">Giant</option><option value="Monstrosity">Monstrosity</option><option value="Monstrosity (Titan)">Monstrosity (Titan)</option><option value="Ooze">Ooze</option><option value="Ooze (Titan)">Ooze (Titan)</option><option value="Plant">Plant</option><option value="Swarm of Tiny Beasts">Swarm of Tiny Beasts</option><option value="Swarm of Tiny Undead">Swarm of Tiny Undead</option><option value="Undead">Undead</option><option value="Undead (Beholder)">Undead (Beholder)</option><option value="Undead (Wizard)">Undead (Wizard)</option><option value="or Gargantuan Undead">or Gargantuan Undead</option><option value="or Small Humanoid">or Small Humanoid</option><option value="or Small Humanoid (Cleric)">or Small Humanoid (Cleric)</option><option value="or Small Humanoid (Wizard)">or Small Humanoid (Wizard)</option><option value="or Small Monstrosity (Lycanthrope)">or Small Monstrosity (Lycanthrope)</option><option value="or Small Plant">or Small Plant</option><option value="or Small Undead">or Small Undead</option><option value="or Small Undead (Cleric)">or Small Undead (Cleric)</option><option value="swarm of Medium Fiends">swarm of Medium Fiends</option><option value="swarm of Medium Fiends (Devil)">swarm of Medium Fiends (Devil)</option><option value="swarm of Small Fiends (Demon)">swarm of Small Fiends (Demon)</option><option value="swarm of Tiny Monstrosities">swarm of Tiny Monstrosities</option></select>
            <select class="rounded border border-gray-600 bg-gray-900 px-2 py-1 text-sm text-white focus:border-red-500 focus:outline-none"><option value="name" selected="">A–Z</option><option value="type">By Type</option></select>
        </div>
        -->
    </div>
    <div class="monster-list">%1$s</div>

    <div class="panel-add-monsters d-none">
        <div class="panel-header">
            <span class="title"></span>
            <button aria-label="Annuler">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </div>
        <div class="panel-body">
            <span class="label">Quantité</span>
            <button aria-label="Diminuer le nombre">
                <i class="fa-solid fa-minus" aria-hidden="true"></i>
            </button>
            <input aria-label="Quantité" type="number" min="1" max="20">
            <button aria-label="Augmenter le nombre">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
            </button>
        </div>
        <button class="submit-button">Ajouter au combat</button>
    </div>

    <div role="dialog" aria-modal="true" aria-label="Fiche de monstre" class="panel-show-monster overlay d-none" tabindex="-1">
        <div class="monster-content"></div>
    </div>

</div>

