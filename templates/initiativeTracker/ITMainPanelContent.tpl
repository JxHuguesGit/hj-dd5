<div id="combatant-%1$s" class="combatant %2$s">
    <div class="bordure"></div>
    <div class="name-actions">
        <div class="initiative-order d-none">
            <button title="Move up" class="inactive">▲</button>
            <button title="Move down">▼</button>
        </div>
        <span title="Player Character" class="emblem">
            <i aria-hidden="true" class="fa-solid fa-shield-halved"></i>
            <i aria-hidden="true" class="fa-solid fa-sword"></i>
        </span>
        <span class="combatant-name">%3$s</span>
    <!--
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
    -->
        <button class="bench" title="Remove from combat (keeps in party)">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </div>
    <div class="hit-points">
        <div class="initiative">
            <span class="title">Init</span>
            <input type="number" data-init-input="" placeholder="%6$s" value="%7$s">
        </div>
        <div class="hit-points-bar">
            <div class="hit-points-controls">
                <span class="current-hp">%8$s</span>
                <span class="hp-separator">/</span>
                <span class="max-hp">%4$s</span>
                <button title="Edit max HP" class="edit-button">
                    <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                </button>
                <span class="temporary-hp d-none">+5 THP
                    <button class="temporary-hp-remove" title="Clear temp HP">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </span>
            </div>
            <div class="hit-points-bar-visual">
                <div class="hit-points-current" style="width: 743px;"></div>
                <div class="hit-points-temporary d-none" style="left: 743px; width: 128px;"></div>
            </div>
        </div>
        <div class="armor-class">
            <svg viewBox="0 0 48 54" fill="none" xmlns="http://www.w3.org/2000/svg" class="absolute inset-0 h-full w-full svelte-1j4i4ba"><path d="M24 2 L44 10 L44 28 C44 40 34 50 24 52 C14 50 4 40 4 28 L4 10 Z" fill="#1e293b" stroke="#475569" stroke-width="2" class="svelte-1j4i4ba"></path></svg>
            <div class="armor-class-content">
                <span class="armor-class-label">CA</span>
                <span class="armor-class-value">%5$s</span>
            </div>
        </div>
    </div>
    <div class="hit-points-edit">
        <input type="number" placeholder="mtt" min="1">
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
    <!--
        <div class="state advfor">
            <button class="state-label" title="Remove Advantage For">Advantage For <span>(3)</span></button>
            <button class="state-info" title="What is Advantage For?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button>
        </div>
        <div class="state advagainst"><button class="state-label" title="Remove Advantage Against">Advantage Against <span>(1)</span></button> <button class="state-info" title="What is Advantage Against?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state disadvfor"><button class="state-label" title="Remove Disadvantage For">Disadvantage For <span>(1)</span></button> <button class="state-info" title="What is Disadvantage For?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state disadvagainst"><button class="state-label" title="Remove Disadvantage Against">Disadvantage Against <span>(1)</span></button> <button class="state-info" title="What is Disadvantage Against?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state blinded"><button class="state-label" title="Remove Blinded">Blinded <span>(1)</span></button> <button class="state-info" title="What is Blinded?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state concentrating"><button class="state-label" title="Remove Concentrating">Concentrating <span>(1)</span></button> <button class="state-info" title="What is Concentrating?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state grappled"><button class="state-label" title="Remove Grappled">Grappled <span>(1)</span></button> <button class="state-info" title="What is Grappled?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state nonvisible"><button class="state-label" title="Remove Invisible">Invisible <span>(1)</span></button> <button class="state-info" title="What is Invisible?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state charmed"><button class="state-label" title="Remove Charmed">Charmed <span>(1)</span></button> <button class="state-info" title="What is Charmed?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state deafened"><button class="state-label" title="Remove Deafened">Deafened <span>(1)</span></button> <button class="state-info" title="What is Deafened?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state frightened"><button class="state-label" title="Remove Frightened">Frightened <span>(1)</span></button> <button class="state-info" title="What is Frightened?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state incapacitated"><button class="state-label" title="Remove Incapacitated">Incapacitated <span>(1)</span></button> <button class="state-info" title="What is Incapacitated?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state paralyzed"><button class="state-label" title="Remove Paralyzed">Paralyzed <span>(1)</span></button> <button class="state-info" title="What is Paralyzed?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state petrified"><button class="state-label" title="Remove Petrified">Petrified <span>(1)</span></button> <button class="state-info" title="What is Petrified?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state poisoned"><button class="state-label" title="Remove Poisoned">Poisoned <span>(1)</span></button> <button class="state-info" title="What is Poisoned?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state prone"><button class="state-label" title="Remove Prone">Prone <span>(1)</span></button> <button class="state-info" title="What is Prone?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state restrained"><button class="state-label" title="Remove Restrained">Restrained <span>(1)</span></button> <button class="state-info" title="What is Restrained?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state stunned"><button class="state-label" title="Remove Stunned">Stunned <span>(1)</span></button> <button class="state-info" title="What is Stunned?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state default"><button class="state-label" title="Remove Aid">Aid <span>(1)</span></button> <button class="state-info" title="What is Aid?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state default"><button class="state-label" title="Remove Bane">Bane <span>(1)</span></button> <button class="state-info" title="What is Bane?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state default"><button class="state-label" title="Remove Barkskin">Barkskin <span>(1)</span></button> <button class="state-info" title="What is Barkskin?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state default"><button class="state-label" title="Remove Bestow Curse">Bestow Curse <span>(1)</span></button> <button class="state-info" title="What is Bestow Curse?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
        <div class="state default"><button class="state-label" title="Remove Test">Test <span>(1)</span></button> <button class="state-info" title="What is Test?"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></button></div>
    -->
        <button class="add-state d-none"><i class="fa-solid fa-plus" aria-hidden="true"></i> Etat / Effet d'un sort</button>
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
    <div class="exhaustion d-none">
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
