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
    mainContent: "#main-content",
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
        updateCombatAudio();
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

const $menuButton = $("#hamburger-tracker-btn");
const $menuIcon = $menuButton.find("i");
const $menu = $(".initiative-tracker-menu");

function closeMenu() {
    $menu.addClass("hidden");

    $menuIcon
        .removeClass("fa-xmark")
        .addClass("fa-bars");

    $menuButton.attr("aria-label", "Open menu");
}
$menuButton.on("click", function (event) {
    event.stopPropagation();

    if (!$menu.hasClass("hidden")) {
        closeMenu();
        return;
    }

    $menu.removeClass("hidden");

    $menuIcon
        .removeClass("fa-bars")
        .addClass("fa-xmark");

    $menuButton.attr("aria-label", "Close menu");
});
$(document).on("click", function (event) {
    if ($menu.hasClass("hidden")) {
        return;
    }

    if (!$(event.target).closest(".initiative-tracker-menu").length) {
        closeMenu();
    }
});

let soundEnabled = false;
function getCombatAudio() {
    return $("#combat-audio").get(0);
}
$(document).on("click", ".sound-on", function () {
    const audio = getCombatAudio();

    if (!audio) {
        console.error("Élément audio #combat-audio introuvable.");
        return;
    }

    soundEnabled = true;

    // Le clic utilisateur autorise la tentative de lecture.
    audio.play()
        .then(() => {
            updateCombatAudio();
        })
        .catch((error) => {
            soundEnabled = false;
            console.warn("Impossible de démarrer le son :", error);
        });
});
$(document).on("click", ".sound-off", function () {
    soundEnabled = false;

    const audio = getCombatAudio();

    if (audio) {
        audio.pause();
        audio.currentTime = 0;
    }
});
function updateCombatAudio() {
    const audio = getCombatAudio();

    if (!audio || !soundEnabled) {
        return;
    }

    const combatStarted = $("#main-content").hasClass("combatStarted");

    if (combatStarted) {
        if (audio.paused) {
            audio.play().catch((error) => {
                console.warn("Lecture audio impossible :", error);
            });
        }
    } else {
        audio.pause();
        audio.currentTime = 0;
    }
}

$(function () {
    initHeader();
    startPlayerRefresh();
});
