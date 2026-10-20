export function initHeader() {
    const $copyButton = $(".copy-button");
    const $copyIcon = $copyButton.find("i");
    const $sessionValue = $(".session .value");

    $copyButton.on("click", async function () {
        await navigator.clipboard.writeText($sessionValue.text().trim());

        $copyButton.addClass("copied");
        $copyIcon
            .removeClass("fa-copy")
            .addClass("fa-check");

        setTimeout(() => {
            $copyButton.removeClass("copied");
            $copyIcon
                .removeClass("fa-check")
                .addClass("fa-copy");
        }, 1500);
    });

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
