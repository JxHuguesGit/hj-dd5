<!-- Font Awesome Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" crossorigin="" href="%1$sassets/styles/initiative-v0.1.css?v=%2$s">

<header class="initiative-header">
    <i class="fa-solid fa-swords" aria-hidden="true"></i>
    <h1>Initiative Tracker</h1>
    <div class="session">
        <span class="label">Session</span>
        <span class="name">Default Session</span>
        <span class="value">JPC4ZR</span>
        <button class="copy-button" title="Copy session ID">
            <i class="fa-solid fa-copy" aria-hidden="true"></i>
        </button>
    </div>
    <div class="header-actions">
        <div class="clock">
            <span>22:30</span> 
        </div>
        <div>
            <button id="hamburger-tracker-btn" aria-label="Open menu">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </button> 
        </div>
    </div>
</header>

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
    <aside class="party">
        <div class="resize-handle" role="separator" aria-label="Drag to resize panel" style="touch-action: none; -webkit-touch-callout: none; user-select: none">
            <div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="aside-content">
            <h2>Personnages</h2>
            <button type="button" class="primary">Ajouter un Personnage</button>
            <button type="button" class="secondary" disabled="">Monter de niveau</button>
            <div class="character-list">
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
            <!--
                <div class="empty">Aucun personnage pour le moment</div>
            -->
            </div>
        </div>
    </aside>
    <main class="initiative-main">
        <div class="active-combatants">
            <div class="panel-header has-combatants">
                <h2>Ordre du tour d'Initiative</h2>
                <span class="round">Round 1</span>
                <div>
                    <button title="Previous Turn" class="previous-turn">
                        <i aria-hidden="true" class="fa-solid fa-arrow-left"></i> Précédent
                    </button>
                    <button title="Next Turn" class="next-turn">
                        <i aria-hidden="true" class="fa-solid fa-arrow-right"></i> Suivant
                    </button>
                    <button title="Stop Combat" class="end-combat">
                        <i aria-hidden="true" class="fa-solid fa-stop"></i> Arrêter
                    </button>
                    <button title="Start Combat" class="start-combat">
                        <i aria-hidden="true" class="fa-solid fa-play"></i>
                        Débuter le Combat
                    </button>

                    <div class="separator"></div>
                    <div class="initiative-menu-container">
                        <button id="hamburger-order-btn" aria-label="Open menu">
                            <i class="fa-solid fa-bars" aria-hidden="true"></i>
                        </button>
                        <div class="initiative-menu initiative-order-menu hidden">
                            <button class="disabled"><i aria-hidden="true" class="fa-solid fa-arrow-rotate-left"></i> Undo</button>
                            <!---->
                            <button><i aria-hidden="true" class="fa-solid fa-swords"></i> Area of Effect</button>
                            <!---->
                            <button><i aria-hidden="true" class="fa-solid fa-scroll"></i> Log</button>
                            <!---->
                            <button><i aria-hidden="true" class="fa-solid fa-hourglass-half"></i> Timer</button>
                            <!----> <!---->
                            <div class="separator"></div>
                            <button><i aria-hidden="true" class="fa-solid fa-arrows-rotate"></i> Reset Init</button>
                            <!---->
                            <button><i aria-hidden="true" class="fa-solid fa-heart"></i> Reset Players</button>
                            <!---->
                            <button><i aria-hidden="true" class="fa-solid fa-trash"></i> Clear Enemies</button>
                            <!---->
                        </div>                        
                    </div>
                </div>
            </div>

            <div class="initiative-main-content">
                <div id="combatant-24081421-9545-4fdb-aeec-18dff933cb1d" class="combatant character">
                    <div class="bordure"></div>
                    <div class="name-actions">
                        <div class="initiative-order">
                            <button title="Move up" class="inactive">▲</button>
                            <button title="Move down">▼</button>
                        </div>
                        <span title="Player Character" class="emblem">
                            <i aria-hidden="true" class="fa-solid fa-shield-halved"></i>
                            <i aria-hidden="true" class="fa-solid fa-sword"></i>
                        </span>
                        <span class="combatant-name">Aaron</span>
                        <button title="Add Lair Actions to initiative" class="lair">
                            <i class="fa-solid fa-building" aria-hidden="true"></i>
                        </button>
                        <button title="Transform (Wild Shape, Polymorph, etc.)" class="polymorph">
                            <i class="fa-solid fa-paw" aria-hidden="true"></i>
                            <i class="fa-solid fa-arrow-rotate-left" aria-hidden="true"></i>
                        </button>
                        <button title="Reaction available — click to mark used" class="reaction">
                            <i aria-hidden="true" class="fa-solid fa-bolt"></i>
                        </button>
                        <button title="Mark as holding a readied action" class="ready">
                            <i aria-hidden="true" class="fa-solid fa-stopwatch"></i>
                        </button>
                        <button title="Mark as surprised" class="surprise">
                            <i aria-hidden="true" class="fa-solid fa-triangle-exclamation"></i>
                        </button>
                        <button title="Grant Inspiration" class="inspiration">
                            <i aria-hidden="true" class="fa-regular fa-star"></i>
                        </button>
                        <button title="Notes" class="notes">
                            <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                        </button>
                        <button class="bench" title="Remove from combat (keeps in party)">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="hit-points">
                        <div class="initiative">
                            <span class="title">Init</span>
                            <input type="number" data-init-input="" placeholder="—">
                        </div>
                        <div class="hit-points-bar">
                            <div class="hit-points-controls">
                                <span class="current-hp">34</span>
                                <span class="hp-separator">/</span>
                                <span class="max-hp">34</span>
                                <button title="Edit max HP" class="edit-button">
                                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                </button>
                                <span class="temporary-hp">+5 THP
                                    <button class="temporary-hp-remove" title="Clear temp HP">
                                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="hit-points-bar-visual">
                                <div class="hit-points-current" style="width: 743px;"></div>
                                <div class="hit-points-temporary" style="left: 743px; width: 128px;"></div>
                            </div>
                        </div>
                        <div class="armor-class"">
                            <svg viewBox="0 0 48 54" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 h-full w-full svelte-1j4i4ba"><path d="M24 2 L44 10 L44 28 C44 40 34 50 24 52 C14 50 4 40 4 28 L4 10 Z" fill="#1e293b" stroke="#475569" stroke-width="2" class="svelte-1j4i4ba"></path></svg>
                            <div class="armor-class-content">
                                <span class="armor-class-label">AC</span>
                                <span class="armor-class-value">15</span>
                            </div>
                        </div>
                    </div>
                    <div class="hit-points-edit">
                        <input type="number" placeholder="amt" min="1">
                        <button title="Deal damage" class="damage">
                            <i class="fa-solid fa-minus" aria-hidden="true"></i> Dégâts
                        </button>
                        <button title="Heal" class="heal">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i> Soins
                        </button>
                        <button title="Set temp HP" class="thp">
                            <i class="fa-solid fa-plus" aria-hidden="true"></i> PVT
                        </button>
                    </div>
                    <div class="states">
                        <div class="state advfor">
                            <button class="state-label" title="Remove Advantage For">Advantage For <span>(3)</span></button>
                            <button class="state-info" title="What is Advantage For?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button>
                        </div>
                        <div class="state advagainst"><button class="state-label" title="Remove Advantage Against">Advantage Against <span>(1)</span><!----></button> <button class="state-info" title="What is Advantage Against?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state disadvfor"><button class="state-label" title="Remove Disadvantage For">Disadvantage For <span>(1)</span><!----></button> <button class="state-info" title="What is Disadvantage For?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state disadvagainst"><button class="state-label" title="Remove Disadvantage Against">Disadvantage Against <span>(1)</span><!----></button> <button class="state-info" title="What is Disadvantage Against?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state blinded"><button class="state-label" title="Remove Blinded">Blinded <span>(1)</span><!----></button> <button class="state-info" title="What is Blinded?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state concentrating"><button class="state-label" title="Remove Concentrating">Concentrating <span>(1)</span><!----></button> <button class="state-info" title="What is Concentrating?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state grappled"><button class="state-label" title="Remove Grappled">Grappled <span>(1)</span><!----></button> <button class="state-info" title="What is Grappled?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state nonvisible"><button class="state-label" title="Remove Invisible">Invisible <span>(1)</span><!----></button> <button class="state-info" title="What is Invisible?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state charmed"><button class="state-label" title="Remove Charmed">Charmed <span>(1)</span><!----></button> <button class="state-info" title="What is Charmed?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state deafened"><button class="state-label" title="Remove Deafened">Deafened <span>(1)</span><!----></button> <button class="state-info" title="What is Deafened?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state frightened"><button class="state-label" title="Remove Frightened">Frightened <span>(1)</span><!----></button> <button class="state-info" title="What is Frightened?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state incapacitated"><button class="state-label" title="Remove Incapacitated">Incapacitated <span>(1)</span><!----></button> <button class="state-info" title="What is Incapacitated?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state paralyzed"><button class="state-label" title="Remove Paralyzed">Paralyzed <span>(1)</span><!----></button> <button class="state-info" title="What is Paralyzed?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state petrified"><button class="state-label" title="Remove Petrified">Petrified <span>(1)</span><!----></button> <button class="state-info" title="What is Petrified?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state poisoned"><button class="state-label" title="Remove Poisoned">Poisoned <span>(1)</span><!----></button> <button class="state-info" title="What is Poisoned?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state prone"><button class="state-label" title="Remove Prone">Prone <span>(1)</span><!----></button> <button class="state-info" title="What is Prone?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state restrained"><button class="state-label" title="Remove Restrained">Restrained <span>(1)</span><!----></button> <button class="state-info" title="What is Restrained?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state stunned"><button class="state-label" title="Remove Stunned">Stunned <span>(1)</span><!----></button> <button class="state-info" title="What is Stunned?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state default"><button class="state-label" title="Remove Aid">Aid <span>(1)</span><!----></button> <button class="state-info" title="What is Aid?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state default"><button class="state-label" title="Remove Bane">Bane <span>(1)</span><!----></button> <button class="state-info" title="What is Bane?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state default"><button class="state-label" title="Remove Barkskin">Barkskin <span>(1)</span><!----></button> <button class="state-info" title="What is Barkskin?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state default"><button class="state-label" title="Remove Bestow Curse">Bestow Curse <span>(1)</span><!----></button> <button class="state-info" title="What is Bestow Curse?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <div class="state default"><button class="state-label" title="Remove Test">Test <span>(1)</span><!----></button> <button class="state-info" title="What is Test?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
                        <!---->
                        <button class="add-state"><i class="fa-solid fa-plus" aria-hidden="true"></i> Etat / Effet d'un sort</button>
                        <div class="state-menu d-none">
                            <div class="grid-states">
                                <button class="blinded selected">Blinded</button>
                                <button class="">Charmed</button>
                                <button class="">Concentrating</button>
                                <button class="">Deafened</button>
                                <button class="">Exhausted</button>
                                <button class="">Frightened</button>
                                <button class="">Grappled</button>
                                <button class="incapacitated selected">Incapacitated</button>
                                <button class="">Invisible</button>
                                <button class="">Paralyzed</button>
                                <button class="">Petrified</button>
                                <button class="">Poisoned</button>
                                <button class="">Prone</button>
                                <button class="">Restrained</button>
                                <button class="">Stunned</button>
                            </div>
                            <div class="grid-title">
                                <span class="text-[10px] font-semibold tracking-wider text-gray-600 uppercase svelte-1j4i4ba">Adv / Disadv</span>
                            </div>
                            <div class="grid-states-single">
                                <button class="rounded px-2 py-1 text-left text-xs transition text-gray-400 hover:bg-gray-800 hover:text-white svelte-1j4i4ba">Advantage For</button>
                                <button class="rounded px-2 py-1 text-left text-xs transition text-gray-400 hover:bg-gray-800 hover:text-white svelte-1j4i4ba">Advantage Against</button>
                                <button class="rounded px-2 py-1 text-left text-xs transition text-gray-400 hover:bg-gray-800 hover:text-white svelte-1j4i4ba">Disadvantage For</button>
                                <button class="rounded px-2 py-1 text-left text-xs transition text-gray-400 hover:bg-gray-800 hover:text-white svelte-1j4i4ba">Disadvantage Against</button>
                            </div>
                            <div class="grid-title">
                                <span class="text-[10px] font-semibold tracking-wider text-gray-600 uppercase svelte-1j4i4ba">Spell Effects</span>
                            </div>
                            <div class="grid-states">
                                <button class="">Aid</button>
                                <button class="">Bane</button>
                                <button class="">Barkskin</button>
                                <button class="">Bestow Curse</button>
                                <button class="">Bless</button>
                                <button class="">Blur</button>
                                <button class="">Enlarge</button>
                                <button class="">Faerie Fire</button>
                                <button class="">Fire Shield</button>
                                <button class="">Guidance</button>
                                <button class="">Haste</button>
                                <button class="">Heroism</button>
                                <button class="">Hex</button>
                                <button class="">Hunter's Mark</button>
                                <button class="">Mage Armor</button>
                                <button class="">Mirror Image</button>
                                <button class="">Reduce</button>
                                <button class="">Resistance</button>
                                <button class="">Sanctuary</button>
                                <button class="">Shield of Faith</button>
                                <button class="">Silenced</button>
                                <button class="">Slow</button>
                                <button class="">Stoneskin</button>
                                <button class="">Warding Bond</button>
                            </div>
                            <div class="grid-title">
                                <span class="text-[10px] font-semibold tracking-wider text-gray-600 uppercase svelte-1j4i4ba">Custom</span>
                            </div>
                            <div class="grid-states-single">
                                <input type="text" placeholder="Other spell / effect…" maxlength="50" class="state-input" id="spell-effect-input-fe276f6f-b670-4699-9fee-1c67838f78ee">
                                <button class="state-input-button">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="exhaustion">
                        <span class="exhaustion-label">Exhaustion:</span>
                        <div class="exhaustion-value">
                            <button title="Set exhaustion to level 1" class="exhaustion-level active"></button>
                            <button title="Set exhaustion to level 2" class="exhaustion-level"></button>
                            <button title="Set exhaustion to level 3" class="exhaustion-level"></button>
                            <button title="Set exhaustion to level 4" class="exhaustion-level"></button>
                            <button title="Set exhaustion to level 5" class="exhaustion-level"></button>
                            <button title="Set exhaustion to level 6" class="exhaustion-level"></button>
                        </div>
                        <span class="exhaustion-count">Lvl 1</span>
                        <button title="Clear exhaustion" class="exhaustion-button exhaustion-delete">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                        <button title="What is Exhaustion?" class="exhaustion-button exhaustion-info">
                            <i class="fa-solid  fa-circle-info text-sm" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>            
                <p>Add players and enemies, then enter initiative rolls to begin.</p>
            </div>
        </div>
    </main>
    <aside class="ennemies">
        <div class="resize-handle" role="separator" aria-label="Drag to resize panel" style="touch-action: none; -webkit-touch-callout: none; user-select: none">
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
                <!--
                    <button title="Import monsters from a 5etools bestiary JSON" class="flex items-center gap-1 rounded border border-gray-700 bg-gray-800 px-2 py-1 text-xs text-gray-400 transition hover:border-indigo-600 hover:text-indigo-300"><i class="fa-solid fa-upload text-sm" aria-hidden="true"></i> Import</button>
                    <button title="Manage custom monsters" class="flex items-center gap-1 rounded border border-gray-700 bg-gray-800 px-2 py-1 text-xs text-gray-400 transition hover:border-amber-600 hover:text-amber-300"><i class="fa-solid fa-plus text-sm" aria-hidden="true"></i> Custom</button>
                -->
                </div>
            </div>
            <div class="panel-filters">
                <input placeholder="Search monsters...">
                <!--
                <div class="flex gap-2">
                    <select class="flex-1 rounded border border-gray-600 bg-gray-900 px-2 py-1 text-sm text-white focus:border-red-500 focus:outline-none"><option value="All" selected="">All</option><option value="Aberration">Aberration</option><option value="Aberration (Beholder)">Aberration (Beholder)</option><option value="Aberration (Gith)">Aberration (Gith)</option><option value="Beast">Beast</option><option value="Beast (Dinosaur)">Beast (Dinosaur)</option><option value="Celestial">Celestial</option><option value="Celestial (Angel)">Celestial (Angel)</option><option value="Celestial or Fiend (Titan)">Celestial or Fiend (Titan)</option><option value="Construct">Construct</option><option value="Construct (Titan)">Construct (Titan)</option><option value="Dragon">Dragon</option><option value="Dragon (Chromatic)">Dragon (Chromatic)</option><option value="Dragon (Metallic)">Dragon (Metallic)</option><option value="Elemental">Elemental</option><option value="Elemental (Genie)">Elemental (Genie)</option><option value="Elemental (Titan)">Elemental (Titan)</option><option value="Fey">Fey</option><option value="Fey (Goblinoid)">Fey (Goblinoid)</option><option value="Fiend">Fiend</option><option value="Fiend (Demon)">Fiend (Demon)</option><option value="Fiend (Devil)">Fiend (Devil)</option><option value="Fiend (Yugoloth)">Fiend (Yugoloth)</option><option value="Giant">Giant</option><option value="Monstrosity">Monstrosity</option><option value="Monstrosity (Titan)">Monstrosity (Titan)</option><option value="Ooze">Ooze</option><option value="Ooze (Titan)">Ooze (Titan)</option><option value="Plant">Plant</option><option value="Swarm of Tiny Beasts">Swarm of Tiny Beasts</option><option value="Swarm of Tiny Undead">Swarm of Tiny Undead</option><option value="Undead">Undead</option><option value="Undead (Beholder)">Undead (Beholder)</option><option value="Undead (Wizard)">Undead (Wizard)</option><option value="or Gargantuan Undead">or Gargantuan Undead</option><option value="or Small Humanoid">or Small Humanoid</option><option value="or Small Humanoid (Cleric)">or Small Humanoid (Cleric)</option><option value="or Small Humanoid (Wizard)">or Small Humanoid (Wizard)</option><option value="or Small Monstrosity (Lycanthrope)">or Small Monstrosity (Lycanthrope)</option><option value="or Small Plant">or Small Plant</option><option value="or Small Undead">or Small Undead</option><option value="or Small Undead (Cleric)">or Small Undead (Cleric)</option><option value="swarm of Medium Fiends">swarm of Medium Fiends</option><option value="swarm of Medium Fiends (Devil)">swarm of Medium Fiends (Devil)</option><option value="swarm of Small Fiends (Demon)">swarm of Small Fiends (Demon)</option><option value="swarm of Tiny Monstrosities">swarm of Tiny Monstrosities</option></select>
                    <select class="rounded border border-gray-600 bg-gray-900 px-2 py-1 text-sm text-white focus:border-red-500 focus:outline-none"><option value="name" selected="">A–Z</option><option value="type">By Type</option></select>
                </div>
                -->
            </div>
            <div class="monster-list">
                <div class="monster">
                    <button class="details">
                        <div class="monster-info">
                            <div class="monster-name">
                                <span>Aarakocra Aeromancer</span>
                            </div>
                            <div class="monster-type">Elemental • CR 4</div>
                        </div>
                        <div class="monster-stats">
                            <div>AC 16</div>
                            <div>66 HP</div>
                        </div>
                    </button>
                    <button class="info" title="View Aarakocra Aeromancer stat block"><i class="fa-solid fa-circle-info text-sm" aria-hidden="true"></i></button>
                </div>
                <div class="monster">
                    <button class="details">
                        <div class="monster-info">
                            <div class="monster-name">
                                <span>Aarakocra Aeromancer</span>
                            </div>
                            <div class="monster-type">Elemental • CR 4</div>
                        </div>
                        <div class="monster-stats">
                            <div>AC 16</div>
                            <div>66 HP</div>
                        </div>
                    </button>
                    <button class="info" title="View Aarakocra Aeromancer stat block"><i class="fa-solid fa-circle-info text-sm" aria-hidden="true"></i></button>
                </div>
                <div class="monster">
                    <button class="details">
                        <div class="monster-info">
                            <div class="monster-name">
                                <span>Aarakocra Aeromancer</span>
                            </div>
                            <div class="monster-type">Elemental • CR 4</div>
                        </div>
                        <div class="monster-stats">
                            <div>AC 16</div>
                            <div>66 HP</div>
                        </div>
                    </button>
                    <button class="info" title="View Aarakocra Aeromancer stat block"><i class="fa-solid fa-circle-info text-sm" aria-hidden="true"></i></button>
                </div>
                <div class="monster">
                    <button class="details">
                        <div class="monster-info">
                            <div class="monster-name">
                                <span>Aarakocra Aeromancer</span>
                            </div>
                            <div class="monster-type">Elemental • CR 4</div>
                        </div>
                        <div class="monster-stats">
                            <div>AC 16</div>
                            <div>66 HP</div>
                        </div>
                    </button>
                    <button class="info" title="View Aarakocra Aeromancer stat block"><i class="fa-solid fa-circle-info text-sm" aria-hidden="true"></i></button>
                </div>
                <div class="monster">
                    <button class="details">
                        <div class="monster-info">
                            <div class="monster-name">
                                <span>Aarakocra Aeromancer</span>
                            </div>
                            <div class="monster-type">Elemental • CR 4</div>
                        </div>
                        <div class="monster-stats">
                            <div>AC 16</div>
                            <div>66 HP</div>
                        </div>
                    </button>
                    <button class="info" title="View Aarakocra Aeromancer stat block"><i class="fa-solid fa-circle-info text-sm" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </aside>
</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
    integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="%1$sassets/js/initiative.js?v=%2$s"></script>
<script src="%1$sassets/js/combat.js?v=%2$s"></script>