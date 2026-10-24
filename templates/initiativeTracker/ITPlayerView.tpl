<div id="main-content" tabindex="-1" class="playerView %1$s">
    <div class="glow-container">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>
    </div>

    <header class="initiative-header">
        <div class="playerView-title">
            <i class="fa-solid fa-khanda swords" aria-hidden="true" style="font-size: 18px;"></i>
            <span class="title">Initiative Tracker</span>
        </div>
        <div class="header-actions">
            <div class="round-container">
                <span class="label">Round</span>
                <span class="value">%3$s</span>
            </div>

            <div class="clock">
                <span>%2$s</span>
            </div>
            <div>
                <button id="hamburger-tracker-btn" aria-label="Ouvrir le menu">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </header>
    <section id="waiting-panel" class="waiting-panel-container">
        <div class="idle-glow" aria-hidden="true"></div>
        <i class="fa-solid fa-khanda swords icon" aria-hidden="true"></i>
        <div class="waiting-panel-text">
            <p title="Combat en préparation" data-clip-auto="">Combat en préparation</p>
        </div>
    </section>
    <section id="fighting-panel" class="fighting-panel-container">
        %4$s
        <footer class="initiative-footer">
            <div class="footer-content">
                <div class="footer-lead-item">
                    <span class="footer-label">À venir</span>
                    <i class="fa-solid fa-arrow-right-from-bracket footer-icon" aria-hidden="true"></i>
                </div>
                <div class="footer-main">%5$s</div>
            </div>
        </footer>
    </section>

</div>
<audio id="combat-audio" loop preload="auto">
    <source src="%6$sassets/audio/warfare.mp3" type="audio/mpeg">
</audio>