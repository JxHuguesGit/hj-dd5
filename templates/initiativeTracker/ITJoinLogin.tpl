<style>
.container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    min-height: 677.6px;
    padding: 40px 16px;
    background: oklch(0.13 0.028 261.692);
    color: #fff;
    box-sizing: border-box;
    font-family: ui-sans-serif, system-ui, sans-serif;
    line-height: 24px;
    scrollbar-width: thin;
    scrollbar-color: rgb(30, 58, 95) rgb(17, 24, 39);
}
</style>
<div id="main-content" role="main" tabindex="-1" class="container">
    <div class="bloc-login">
        <div class="mb-8 text-center">
            <i class="fa-solid fa-dice logo-dice" aria-hidden="true"></i>
            <h1 class="titre">Initiative Tracker</h1>
        </div>
        <div class="card">
            <p class="sous-titre">Saisir l'ID de session fourni par le MJ.</p>
            <form method="post">
                <label for="sessionId">ID de Session</label>
                <input id="sessionId" name="sessionId" type="text" maxlength="6" autocomplete="off" spellcheck="false"
                    placeholder="AB3X9K">
                <button type="submit">Valider</button>
            </form>
        </div>
    </div>
</div>
