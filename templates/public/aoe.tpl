<style>
.aoe-header {
    display: flex;
    align-items: center;
}
.aoe-help {
    margin-left: auto;
}
.aoe-help-button {
    width: 32px;
    height: 32px;
    border: 1px solid #999;
    border-radius: 999px;
    cursor: pointer;
    font-weight: bold;
}
.aoe-help-panel {
    position: fixed;
    top: 0;
    right: -520px;

    width: 500px;
    height: 100vh;

    background: #fff;

    border-left: 1px solid #ccc;
    box-shadow: -4px 0 10px rgba(0, 0, 0, 0.15);

    transition: right 0.2s ease;

    z-index: 1000;
}
.aoe-help-panel.open {
    right: 0;
}
.aoe-help-panel-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 1rem;

    border-bottom: 1px solid #ddd;
}
.aoe-help-content {
    padding: 1rem;
    overflow-y: auto;
}

.cell.aoe.aoe-cover-none {
    background-color: #14532d;
    border-color: #374151;
}

.cell.aoe.aoe-cover-half {
    background-color: #713f12;
    border-color: #374151;
}

.cell.aoe.aoe-cover-three-quarters {
    background-color: #7c2d12;
    border-color: #374151;
}

.cell.aoe.aoe-cover-total {
    background-color: #7f1d1d;
    border-color: #374151;
}
</style>
<header class="aoe-header">

    <h1>Zones d'effet</h1>

    <form id="aoe-form">

        <select id="mode" name="mode">
            <option value="distance">Distance</option>
            <option value="aoe">Zone d'effet</option>
            <option value="cover">Abri</option>
        </select>

        <select id="shape" name="shape">
            <option value="sphere">Sphère</option>
            <option value="emanation">Émanation</option>
            <option value="line">Ligne</option>
            <option value="cone">Cône</option>
            <option value="column">Colonne</option>
            <option value="cube">Cube</option>
        </select>

        <div class="aoe-field">
            <label for="x">X</label>
            <input
                type="number"
                id="x"
                name="x"
                value="0"
                min="-24"
                max="24"
            >
        </div>

        <div class="aoe-field">
            <label for="y">Y</label>
            <input
                type="number"
                id="y"
                name="y"
                value="0"
                min="-24"
                max="24"
            >
        </div>

        <div class="aoe-field aoe-field-size">
            <label for="size">Rayon / Largeur</label>
            <input
                type="number"
                id="size"
                name="size"
                value="1.5"
                min="1.5"
                step="1.5"
            >
        </div>

        <select id="creature-size" name="creature-size">
            <option value="1">Moyenne / Petite</option>
            <option value="2">Grande</option>
            <option value="3">Très grande</option>
            <option value="4">Gigantesque</option>
        </select>

        <div class="aoe-header-info">
            <div id="distance-info" class="distance-info">Distance : 0 m</div>
            <div id="cover-result" class="cover-result"></div>
        </div>

        <div class="aoe-help">
            <button
                id="help-toggle"
                class="aoe-help-button"
                type="button"
                aria-label="Aide"
            >
                ?
            </button>
        </div>

    </form>

</header>
<main class="aoe-main">
<div class="grid-container">
    %2$s
    <svg
        id="overlay"
        viewBox="0 0 49 49"
        preserveAspectRatio="none"
    ></svg>

</div>

</main>
<aside id="help-panel" class="aoe-help-panel">

    <div class="aoe-help-panel-header">
        <h2>Aide</h2>
        <button
            id="help-close"
            class="aoe-help-close"
            type="button"
        >
            ×
        </button>
    </div>

    <div class="aoe-help-content">
        <h3>Distance</h3>
        <p>En survol de la grille, s'affiche la distance avec le point central</p>

        <h3>Zone d'effet</h3>
        <dl>
            <dt>Type</dt><dl>La liste déroulante permet de choisir le type de la zone d'effet.</dl>
            <dt>Coordonnées</dt><dl>Permet de définir la zone ciblée. Peut se faire en cliquant la grille.</dl>
            <dt>Rayon/Largeur</dt><dl>Permet de définir la largeur de la Ligne ou du côté du Cube ou le rayon de la Sphère, de l'Emanation ou de la Colonne. Le Cône n'utilise pas cette information, il est défini à partir de la zone ciblée.</dl>
        </dl>

        <h3>Abri</h3>
        <p>Un clic gauche permet de placer ou enlever une Cible. Le menu Taille permet de définir la taille de la Cible.<br>
        Un shift + clic gauche permet de placer ou enlever des obstacles.<br>
        <br>
        L'interface calcule l'importance de l'abri, de la façon suivante :<br>
        Pour chaque angle de la zone d'origine, on trace un trait vers chaque angle de chaque zone occupée par la Cible.<br>
        On compte le nombre de traits qui sont coupés par des obstacles et on prend le plus petit possible :
        <dl>
            <dt>Tous les traits sont bloqués</dt><dd> 100 pour cent - Abri total</dd>
            <dt>Un trait peut être tracé entre deux angles</dt><dd>75 pour cent - Abri important</dd>
            <dt>Deux traits peuvent être tracés entre deux angles</dt><dd>50 pour cent - Abri partiel</dd>
            <dt>Au moins trois traits peuvent être tracés entre deux angles</dt><dd>0 pour cent - Aucun abri</dd>
        </dl>
        Il est possible de déplacer le point d'origine grâce aux touches du pavé numérique. Le point d'origine demeure cependant le centre de la grille.
        </p>
    </div>

</aside>
<footer class="aoe-footer">DD5 — Zones d'effet</footer>
