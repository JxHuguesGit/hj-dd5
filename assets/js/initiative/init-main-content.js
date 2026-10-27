export function initMainContent() {
    const baseUrl = globalThis.location.origin;
    const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';
    const initTrackerId = 'JPC4ZR';

    /**
     * Exécute une action de combat et traite sa réponse.
     */
    function executeCombatAction(ajaxAction, onSuccess) {
        $.ajax({
            url: ajaxUrl,
            method: "POST",
            dataType: "json",
            data: {
                action: "dealWithAjax",
                ajaxAction: ajaxAction,
                itCode: initTrackerId,
            },
            success: function (response) {
                if (!response || response.success !== true) {
                    console.error(
                        "Échec de la mise à jour du combat :",
                        response
                    );
                    return;
                }

                const payload = typeof response.data === "string"
                    ? JSON.parse(response.data)
                    : response.data;

                if (!payload || payload.status !== "success") {
                    console.error("Échec du traitement :", payload);
                    return;
                }

                const data = payload.data;

                $(".initiative-main-content .combatant").remove();
                $(".initiative-main-content").append(data.panel);

                onSuccess(data);
            },
            error: function (xhr, status, error) {
                console.error("Erreur Ajax :", status, error);
            },
        });
    }

    // Tour suivant
    $(".next-turn").on("click", function () {
        executeCombatAction("nextCombatChar", function (data) {
            $(".initiative-main .round").text(data.round);
        });
    });

    // Tour précédent
    $(".previous-turn").on("click", function () {
        executeCombatAction("prevCombatChar", function (data) {
            $(".initiative-main .round").text(data.round);
        });
    });

    // Fin du combat
    $(".end-combat").on("click", function () {
        executeCombatAction("endCombat", function () {
            $(".initiative-main .panel-header")
                .removeClass("combat-in-progress");
        });
    });

    // Début du combat
    $(".start-combat").on("click", function () {
        executeCombatAction("startCombat", function () {
            $(".initiative-main .round").text("Round 1");
            $(".initiative-main .panel-header")
                .addClass("combat-in-progress");
        });
    });

}
