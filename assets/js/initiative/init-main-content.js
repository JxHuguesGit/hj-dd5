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
                $(".initiative-main-content .combatant").remove();
                $(".initiative-main-content").append(response.data.panel);
                onSuccess(response.data);
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

    // Changement de l'initiative
    $(".initiative-main").on(
        "change",
        ".combatant .initiative > input",
        function () {
            const $combatant = $(this).closest(".combatant");
            const combatantId = $combatant.attr("id").replace("combatant-", "");
            const initiative = Number($(this).val());

            if ($(this).val() === "" || !Number.isFinite(initiative)) {
                return;
            }

            $.ajax({
                url: ajaxUrl,
                method: "POST",
                dataType: "json",
                data: {
                    action: "dealWithAjax",
                    ajaxAction: "updateInitChar",
                    character: {
                        id: combatantId,
                        initiative: initiative
                    }
                },
                success: function (response) {
                    if (!response || response.success !== true) {
                        console.error(
                            "Échec de la mise à jour de l'initiative :",
                            response
                        );
                        return;
                    }

                    $(".initiative-main-content .combatant").remove();
                    $(".initiative-main-content").append(response.data.panel);
                },
                error: function (xhr, status, error) {
                    console.error("Erreur Ajax :", status, error);
                },
            });
        }
    );

    // Ajout, suppression points de vie (temporaires)
    $(".initiative-main-content").on("click", ".combatant .damage, .combatant .heal, .combatant .thp", function () {
        const $combatant = $(this).closest(".combatant");
        const combatantId = $combatant.attr("id").replace("combatant-", "");
        const number = $combatant.find(".hit-points-edit input[type='number']").val();

        const ajaxAction = $(this).hasClass("damage")
            ? "dealDamage"
            : $(this).hasClass("heal")
                ? "heal"
                : "setTempHP";

        if (number === "" || !Number.isFinite(Number(number)) || Number(number) < 1) {
            return;
        }

        $.ajax({
            url: ajaxUrl,
            method: "POST",
            dataType: "json",
            data: {
                action: "dealWithAjax",
                ajaxAction: ajaxAction,
                combatantId: combatantId,
                amount: Number(number),
            },
            success: function (response) {
                if (!response || response.success !== true) {
                    console.error(
                        "Échec de la mise à jour du combattant :",
                        response
                    );
                    return;
                }
                $("#combatant-"+combatantId).replaceWith(response.data.panel);
            },
            error: function (xhr, status, error) {
                console.error("Erreur Ajax :", status, error);
            },
        });
    });
}
