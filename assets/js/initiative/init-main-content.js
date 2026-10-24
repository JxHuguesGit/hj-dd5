export function initMainContent() {
    const baseUrl = globalThis.location.origin;
    const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';
    const initTrackerId = 'JPC4ZR';

    $(document).on("change", "[data-init-input]", function () {
        const $input = $(this);
        const initiative = $input.val();
        const $combatant = $input.closest(".combatant");
        const characterId = $combatant.attr("id").replace("combatant-", "");

        $.ajax({
            url: ajaxUrl,
            method: "POST",
            dataType: "json",
            data: {
                action: "dealWithAjax",
                ajaxAction: 'setInitChar',
                characterId: characterId,
                initiative: initiative,
            },
            success: function (response) {
                if (!response || response.success !== true) {
                    console.error("Échec de la mise à jour de l'initiative :", response);
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
                $('.initiative-main-content .combatant').remove();
                $('.initiative-main-content').append(data.panel);
            },
            error: function (xhr, status, error) {
                console.error("Erreur Ajax :", status, error);
            },
        });
    });

    $(".next-turn").on("click", function () {
        $.ajax({
            url: ajaxUrl,
            method: "POST",
            dataType: "json",
            data: {
                action: "dealWithAjax",
                ajaxAction: 'nextCombatChar',
                itCode: initTrackerId,
            },
            success: function (response) {
                if (!response || response.success !== true) {
                    console.error("Échec de la mise à jour de l'initiative :", response);
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
                $('.initiative-main-content .combatant').remove();
                $('.initiative-main-content').append(data.panel);
            },
            error: function (xhr, status, error) {
                console.error("Erreur Ajax :", status, error);
            },
        });
    });    
}
