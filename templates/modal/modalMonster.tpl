<div class="monster-modal" style="max-height: calc(100vh - 4rem);">
    <div class="modal-header">
        <div>
            <div class="modal-title-group">
                <h3 class="modal-title">%1$s</h3>
                <span class="d-none rounded bg-blue-500/20 px-1.5 py-0.5 text-[10px] font-bold tracking-wider text-blue-300 uppercase ring-1 ring-blue-500/30">2024</span>
            </div>
            <p class="modal-subtitle">%2$s</p>
        </div>
        <button class="close-modal" aria-label="Close">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </div>
    <div role="presentation" class="modal-body">
        <div class="monster-overview">
            <div class="monster-text">
                <span class="stat-label" title="AC — Armor Class" data-abbr-auto="">AC</span>
                <span class="stat-value">22</span>
            </div>
            <div class="monster-text">
                <span class="stat-label" title="HP — Hit Points" data-abbr-auto="">HP</span>
                <span class="stat-value">546 (<button class="roll-link" data-dice="28d20+252">28d20 + 252</button>)</span>
            </div>
            <div class="monster-text">
                <span class="stat-label">Speed</span>
                <span class="stat-value" title="40 ft., Fly 80 ft., Swim 40 ft." data-clip-auto="">40 ft., Fly 80 ft., Swim 40 ft.</span>
            </div>
            <div class="monster-text">
                <span class="stat-label" title="CR — Challenge Rating" data-abbr-auto="">CR</span>
                <span class="stat-value">24</span>
                <span class="stat-label" title="XP — Experience Points" data-abbr-auto="">(62 000 XP)</span>
            </div>
            <div class="monster-text">
                <span class="stat-label">Initiative</span>
                <span class="stat-value">+16 (26)</span>
            </div>
        </div>
        <div class="monster-section">
            <div class="ability-scores">
                <button class="ability-score" data-dice="1d20+10" title="Roll STR saving throw (+10)">
                    <div class="ability-label">STR</div>
                    <div class="ability-value">30</div>
                    <div class="ability-modifier">+10</div>
                    <div class="ability-extra">Save +10</div>
                </button>
                <button class="ability-score" data-dice="1d20+9" title="Roll DEX saving throw (+9)">
                    <div class="ability-label">DEX</div>
                    <div class="ability-value">14</div>
                    <div class="ability-modifier">+2</div>
                    <div class="ability-extra">Save +9</div>
                </button>
                <button class="ability-score" data-dice="1d20+9" title="Roll CON saving throw (+9)">
                    <div class="ability-label">CON</div>
                    <div class="ability-value">29</div>
                    <div class="ability-modifier">+9</div>
                    <div class="ability-extra">Save +9</div>
                </button>
                <button class="ability-score" data-dice="1d20+4" title="Roll INT saving throw (+4)">
                    <div class="ability-label">INT</div>
                    <div class="ability-value">18</div>
                    <div class="ability-modifier">+4</div>
                    <div class="ability-extra">Save +4</div>
                </button>
                <button class="ability-score" data-dice="1d20+10" title="Roll WIS saving throw (+10)">
                    <div class="ability-label">WIS</div>
                    <div class="ability-value">17</div>
                    <div class="ability-modifier">+3</div>
                    <div class="ability-extra">Save +10</div>
                </button>
                <button class="ability-score" data-dice="1d20+9" title="Roll CHA saving throw (+9)">
                    <div class="ability-label">CHA</div>
                    <div class="ability-value">28</div>
                    <div class="ability-modifier">+9</div>
                    <div class="ability-extra">Save +9</div>
                </button>
            </div>
        </div>
        <div class="monster-section-content">
            <div class="monster-ability">
                <span class="monster-text-muted">Skills</span>
                <span class="monster-text">Insight +10, Perception +17, Persuasion +16, Stealth +9</span>
            </div>
            <div class="monster-ability">
                <span class="monster-text-muted">Immunities</span>
                <span class="monster-text">Fire</span>
            </div>
            <div class="monster-ability">
                <span class="monster-text-muted" title="Resistances" data-clip-auto="">Resistances</span>
                <span class="monster-text">Bludgeoning, Lightning, Piercing, Slashing</span>
            </div>
            <div class="monster-ability">
                <span class="monster-text-muted" title="Vulnerabilities" data-clip-auto="">Vulnerabilities</span>
                <span class="monster-text" title="Bludgeoning" data-clip-auto="">Bludgeoning</span>
            </div>
            <div class="monster-ability">
                <span class="monster-text-muted">Senses</span>
                <span class="monster-text" title="Blindsight 60 ft., Darkvision 120 ft., Passive Perception 27" data-clip-auto="">Blindsight 60 ft., Darkvision 120 ft., Passive Perception 27</span>
            </div>
            <div class="monster-ability">
                <span class="monster-text-muted">Languages</span>
                <span class="monster-text">Common, Draconic</span>
            </div>
            <div class="monster-ability">
                <span class="monster-text-muted">Proficiency Bonus</span>
                <span class="monster-text">+7</span>
            </div>
        </div>
        <div class="monster-section">
            <div class="section-content">
                <p><strong>Amphibious.</strong> The dragon can breathe air and water.</p>
                <p><strong>Legendary Resistance (4/Day, or 5/Day in Lair).</strong> If the dragon fails a saving throw, it can choose to suc ceed instead.</p>
            </div>
        </div>
        <div class="monster-section">
            <h4>Actions</h4>
            <div class="section-content">
                <p><strong>Multiattack.</strong> The dragon makes three Rend attacks. It can replace one attack with a use of (A) Spellcasting to cast Guiding Bolt (level 4 version) or (B) Weakening Breath.</p>
                <p><strong>Rend.</strong> Melee Attack Roll: <button class="roll-link roll-atk" data-attack="+17">+17</button> to hit, reach 15 ft. Hit: 19 (<button class="roll-link" data-dice="2d8+10">2d8+ 10</button>) Slashing damage plus 9 (<button class="roll-link" data-dice="2d8">2d8</button>) Fire damage.</p>
                <p><strong>Fire Breath (Recharge 5-6).</strong> Dexterity Saving Throw: DC 24, each creature in a 90-foot Cone. Failure: 71 (<button class="roll-link" data-dice="13d10">13d10</button>) Fire damage. Success: Half damage.</p>
                <p><strong>Spellcasting.</strong> The dragon casts one of the following spells, requiring no Material components and using Charisma as the spellcasting ability (spell save DC 24):</p>
                <p><strong>Weakening Breath.</strong> Strength Saving Throw: DC 24, each creature that isn't currently affected by this breath in a 90-foot Cone. Failure: The target has Disadvantage on Strength-based D20 Tests and subtracts 5 (<button class="roll-link" data-dice="1d10">1d10</button>) from its damage rolls. It repeats the save at the end of each of its turns, ending the effect on itself on a success. After 1 minute, it succeeds automatically.</p>
            </div>
        </div>
        <div class="monster-section">
            <h4>Reactions</h4>
            <div class="section-content">
                <p><strong>Feather Fall (1/Day).</strong> The aarakocra casts Feather Fall in response to that spell's trigger, using the same spellcasting ability as Spellcasting.</p>
            </div>
        </div>
        <div class="monster-block">
            <h4>Legendary Actions</h4>
            <p class="section-subtitle">Legendary Action Uses: 3 (4 in Lair). Immediately after another creature's turn, the dragon can expend a use to take one of the following actions. The dragon regains all expended uses at the start of each of its turns.</p>
            <div class="section-content">
                <p><strong>Banish.</strong> Charisma Saving Throw: DC 24, one creature the dragon can see within 120 feet. Failure: 24 (<button class="roll-link" data-dice="7d6">7d6</button>) Force damage, and the target has the Incapacitated condition and is transported to a harmless demiplane until the start of the dragon's next turn, at which point it reappears in an unoccupied space of the dragon's choice within 120 feet of the dragon. Failure or Success: The dragon can't take this action again until the start of its next turn.</p>
                <p><strong>Guiding Light.</strong> The dragon uses Spellcasting to cast Guiding Bolt (level 4 version).</p>
                <p><strong>Pounce.</strong> The dragon moves up to half its Speed, and it makes one Rend attack.</p>
            </div>
        </div>
    </div>
</div>
