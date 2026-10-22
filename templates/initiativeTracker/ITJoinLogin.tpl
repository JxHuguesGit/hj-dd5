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
.bloc-login {
    position: relative;
    width: 384px;
    max-width: 384px;
    z-index: 10;

    color: #fff;
    font-family: ui-sans-serif, system-ui, sans-serif;
    line-height: 24px;
}
.logo-dice {
    display: inline-block;
    position: relative;
    width: 60px;
    font-size: 48px;
    font-style: normal;
    line-height: 48px;
    text-align: center;
}
.titre {
    color: oklch(0.707 0.165 254.624);

    font-size: 24px;
    font-weight: 900;
    letter-spacing: 6px;
    line-height: 32px;

    text-align: center;
    text-transform: uppercase;
}
.card {
    padding: 24px;
    color: #fff;
    background: oklab(0.21 -0.00316128 -0.0338527 / 0.8);
    border: 1px solid oklch(0.278 0.033 256.848);
    border-radius: 12px;
    backdrop-filter: blur(8px);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
.sous-titre {
    color: oklch(0.707 0.022 261.325);
    font-size: 14px;
    line-height: 20px;
    text-align: center;
    margin-bottom: 20px;
}
label {
    display: block;
    color: oklch(0.707 0.022 261.325);
    font-size: 12px;
    font-weight: 700;
    line-height: 16px;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    margin-bottom: 8px;
}
input[type="text"] {
    width: 334.4px;//100_pc_;
    padding: 12px 16px;
    color: #fff;
    background: oklch(0.278 0.033 256.848);
    border: 1px solid rgb(48, 99, 179);
    border-radius: 8px;
    font: 900 24px/32px ui-sans-serif, system-ui, sans-serif;
    letter-spacing: 9.6px;
    text-align: center;
    text-transform: uppercase;
    outline: none;
    transition:
        background-color 0.15s ease,
        border-color 0.15s ease,
        box-shadow 0.15s ease;
}
input[type="text"]:focus {
    border-color: oklch(0.623 0.214 259.815);
}
input[type="text"]::placeholder {
    color: oklch(0.373 .034 259.733);
}
input[type="text"]:focus-visible {
  outline-offset: 2px;
  outline: 2px solid #fbbf24;
}
button {
    width: 334.4px;//100_pc_;
    margin-top: 16px;
    padding: 12px 16px;
    background: oklch(0.546 0.245 262.881);
    color: #fff;
    border: none;
    border-radius: 8px;
    font: 900 14px/20px ui-sans-serif, system-ui, sans-serif;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    cursor: pointer;
    transition:
        background-color .15s ease,
        box-shadow .15s ease,
        transform .15s ease;
}
button:hover {
    background: color(srgb 0.083979 0.364979 0.986497);
}
button:focus {
    outline: none;
    box-shadow: 0 0 0 3px oklch(0.623 0.214 259.815 / 0.25);
}
button:active {
    scale: .98;
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
