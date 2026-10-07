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

    </form>

</header>
<main class="aoe-main">
<div class="grid-container">
    %2$s
    <svg
        id="cover-overlay"
        viewBox="0 0 49 49"
        preserveAspectRatio="none"
    ></svg>

</div>

</main>
<footer class="aoe-footer">DD5 — Zones d'effet</footer>
