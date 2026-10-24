function initHeader() {
    const $clock = $(".clock span");
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, "0");
        const minutes = String(now.getMinutes()).padStart(2, "0");
        $clock.text(`${hours}:${minutes}`);
    }
    function scheduleNextUpdate() {
        const now = new Date();
        const delay = (60 - now.getSeconds()) * 1000 - now.getMilliseconds();
        setTimeout(() => {
            updateClock();
            scheduleNextUpdate();
        }, delay);
    }
    updateClock();
    scheduleNextUpdate();
}

const REFRESH_INTERVAL = 2000;
const SELECTORS = {
    round: ".round-container .value",
    main: ".fighting-panel-container main",
    footer: ".initiative-footer .footer-main",
    mainContent: "#main-content"
};

let refreshTimer = null;
let requestInProgress = false;
const initTrackerId = 'JPC4ZR';
const baseUrl = globalThis.location.origin;
const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';

function refreshPlayerView() {
    // Évite de lancer plusieurs requêtes simultanément.
    if (requestInProgress) {
        return;
    }
    requestInProgress = true;

    $.ajax({
        url: ajaxUrl,
        method: "post",
        dataType: "json",
        data: {
            action: "dealWithAjax",
            ajaxAction: 'refreshPlayerView',
            initTrackerId: initTrackerId,
        }
    })
    .done(function (response) {
        if (!response || response.success !== true) {
            console.error("Réponse Ajax invalide :", response);
            return;
        }
        const payload = typeof response.data === "string"
            ? JSON.parse(response.data)
            : response.data;
        if (payload.status !== "success") {
            console.error("Échec du traitement :", payload);
            return;
        }
        const data = payload.data;

        $(SELECTORS.round).text(data.round);
        $(SELECTORS.main).replaceWith(data.mainHtml);
        $(SELECTORS.footer).html(data.footerHtml);
        updateCombatState(data.combatState);
    })
    .fail(function (xhr, status, error) {
        console.log(error);
        console.error(
            "Erreur lors du rafraîchissement de la vue Joueur :",
            status,
            error
        );
        console.error("Réponse du serveur :", xhr.responseText);
    })
    .always(function () {
        requestInProgress = false;
    });
}

function updateCombatState(combatState) {
    $("#main-content").attr(
        "class",
        `playerView ${combatState}`.trim()
    );
}

function startPlayerRefresh() {
    stopPlayerRefresh();
    refreshPlayerView();
    refreshTimer = setInterval(
        refreshPlayerView,
        REFRESH_INTERVAL
    );
}

function stopPlayerRefresh() {
    if (refreshTimer !== null) {
        clearInterval(refreshTimer);
        refreshTimer = null;
    }
}

$(function () {
    initHeader();
    startPlayerRefresh();
});
