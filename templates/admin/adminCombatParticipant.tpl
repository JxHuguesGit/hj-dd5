    <div class="combatant-card" data-id="%1$s" draggable="true">
        <div class="combatant-card__row">
            <span class="drag-handle" title="Drag to reorder" role="img" aria-label="Drag to reorder"><i class="fa-solid fa-grip-vertical"></i></span>
            <span class="combatant-card__initiative combatant-card__initiative--dim">%3$s</span>
            <button class="btn btn--remove" title="Relancer l'initiative" aria-label="Relancer l'initiative"><i class="fa-solid fa-refresh"></i></button>
            <span class="combatant-card__name">%2$s</span>
            <span class="type-icon type-icon--%7$s" title="%8$s"><i class="fa-solid fa-%9$s"></i></span>
            <span class="ac-badge" title="Armor Class">CA %4$s</span>
            <div class="combatant-card__right">
                <span class="hp-text hp-text--high">%5$s/%6$s</span>
                <button class="btn btn--remove" title="Tag" aria-label="Tag"><i class="fa-solid fa-tag"></i></button>
                <button class="btn btn--remove" title="Détail" aria-label="Détail"><i class="fa-solid fa-eye"></i></button>
                <div class="d-none">
                    <input class="hp-input" placeholder="10" min="1" max="9999" title="Enter amount, then press Enter or click Dmg/Heal. Shift+Enter for opposite action." type="number" value="">
                    <button class="btn btn--dmg">Dmg</button>
                    <button class="btn btn--heal">Heal</button>
                </div>
                <button class="btn btn--remove" title="Remove %2$s" aria-label="Remove %2$s"><i class="fa-solid fa-times"></i></button>
            </div>
        </div>
    </div>