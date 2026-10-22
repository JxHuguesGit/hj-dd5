<link rel="stylesheet" media="all" href="https://dd5.jhugues.fr/wp-content/plugins/hj-dd5/assets/styles/draft.css?v=20261022142852">
<div id="main-content" role="main" tabindex="-1" class="playerView combatStarted">
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
                <span class="value">1</span>
            </div>

            <div class="clock">
                <span>%3$s</span>
            </div>
            <div>
                <button id="hamburger-tracker-btn" aria-label="Ouvrir le menu">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </header>
    <section id="waiting-panel" class="waiting-panel-container d-none">
        <div class="idle-glow" aria-hidden="true"></div>
        <i class="fa-solid fa-khanda swords icon" aria-hidden="true"></i>
        <div class="waiting-panel-text">
            <p title="Combat en préparation" data-clip-auto="">Combat en préparation</p>
        </div>
    </section>
    <section id="fighting-panel" class="fighting-panel-container">
        <main class="ennemy">
            <div class="title-container">
                <div class="title-line title-line--left"></div>
                <span class="section-title">ENEMY</span>
                <div class="title-line title-line--right"></div>
            </div>
            <div class="visual-container">
                <button title="View Zombie 1's image" class="character-portrait">
                    <img src="https://media-waterdeep.cursecdn.com/avatars/thumbnails/0/71/1000/1000/636252733510786769.jpeg" alt="Zombie 1">
                </button>
            </div>
            <h1 class="character-name" title="Zombie 1" data-clip-auto="">Zombie 1</h1>
            <div class="initiative-container">
                <div class="text-center">
                    <div class="stat-label">Initiative</div>
                    <div class="stat-value">18</div>
                </div>
            </div>
        </main>
        <main class="player d-none">
            <div class="title-container">
                <div class="title-line title-line--left"></div>
                <span class="section-title">Personnage</span>
                <div class="title-line title-line--right"></div>
            </div>
            <div class="visual-container"></div>
            <h1 class="character-name" title="Zombie 1" data-clip-auto="">Tintin</h1>
            <div class="initiative-container">
                <div class="text-center">
                    <div class="stat-label">Initiative</div>
                    <div class="stat-value">18</div>
                </div>
                <div class="separator-vertical"></div>
                <div class="text-center">
                    <div class="stat-label">Classe d'armure</div>
                    <div class="stat-value text-white">12</div>
                </div>
            </div>
        </main>
        <footer class="initiative-footer">
            <div class="footer-content">
                <div class="footer-lead-item">
                    <span class="footer-label">À venir</span>
                    <i class="fa-solid fa-arrow-right-from-bracket footer-icon" aria-hidden="true"></i>
                </div>
                <div class="footer-main">
                    <div class="footer-panel npc">
                        <button title="View Zombie 2's image" class="icon-button">
                            <img class="button-image" alt="Zombie 2"
                                src="https://media-waterdeep.cursecdn.com/avatars/thumbnails/0/71/1000/1000/636252733510786769.jpeg">
                        </button>
                        <div class="text-content">
                            <div class="inner-container">
                                <span class="badge" title="PNJ — Personnage Non-Joueur" data-abbr-auto="">PNJ</span>
                                <span class="character-name">Zombie 2</span>
                                <span class="character-initiative">16</span>
                            </div>
                        </div>
                    </div>

                    <div class="footer-panel pc">
                        <div class="shield-container">
                            <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                        </div>
                        <div class="text-content">
                            <div class="inner-container">
                                <span class="badge badge-pj" title="PJ — Personnage Joueur" data-abbr-auto="">PJ</span>
                                <span class="character-name">Tintin</span>
                                <span class="character-initiative">12</span>
                            </div>
                        </div>
                    </div>

                    <div class="footer-panel npc">
                        <button title="View Zombie 4's image" class="icon-button">
                            <img class="button-image" alt="Zombie 4"
                                src="https://media-waterdeep.cursecdn.com/avatars/thumbnails/0/71/1000/1000/636252733510786769.jpeg">
                        </button>
                        <div class="text-content">
                            <div class="inner-container">
                                <span class="badge" title="PNJ — Personnage Non-Joueur" data-abbr-auto="">PNJ</span>
                                <span class="character-name">Zombie 4</span>
                                <span class="character-initiative">2</span>
                            </div>
                        </div>
                    </div>

                    <div class="round-change">
                        <div class="separator-vertical"></div>
                        <span class="round-text">Nouveau round</span>
                        <div class="separator-vertical"></div>
                    </div>

                    <div class="footer-panel npc">
                        <button title="View Zombie 3's image" class="icon-button">
                            <img class="button-image" alt="Zombie 3"
                                src="https://media-waterdeep.cursecdn.com/avatars/thumbnails/0/71/1000/1000/636252733510786769.jpeg">
                        </button>
                        <div class="text-content">
                            <div class="inner-container">
                                <span class="badge" title="PNJ — Personnage Non-Joueur" data-abbr-auto="">PNJ</span>
                                <span class="character-name">Zombie 3</span>
                                <span class="character-initiative">1</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </footer>
    </section>

</div>
