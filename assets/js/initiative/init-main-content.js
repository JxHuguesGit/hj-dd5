export function initMainContent() {
    const baseUrl = globalThis.location.origin;
    const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';
    const initTrackerId = $('.session .value').html();

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
        if ($('.initiative-main-content .combatant').length==0) {
            return false;
        }
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
        let ajaxAction = '';

        if ($(this).hasClass("damage")) {
            ajaxAction = "dealDamage";
        } else if ($(this).hasClass("heal")) {
            ajaxAction = "heal";
        } else {
            ajaxAction = "setTempHP";
        }

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

    // Toggle reaction
    $(document).on('click', '.combatant .reaction', function () {
        const $button = $(this);
        const $combatant = $button.closest('.combatant');
        const combatantId = $combatant.attr('id').replace('combatant-', '');
        const isDisabled = $button.hasClass('disabled');

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'dealWithAjax',
                ajaxAction: 'toggleReaction',
                character: {
                    id: combatantId,
                    reactionAvailable: isDisabled ? 1 : 0
                }
            },
            success: function (response) {
                if (!response.success) {
                    console.error('Impossible de modifier la réaction.', response);
                    return;
                }

                $button.toggleClass('active, disabled');
            },
            error: function (xhr, status, error) {
                console.error('Erreur Ajax lors de la modification de la réaction :', error);
            }
        });
    });

    // Toggle ready
    $(document).on('click', '.combatant .ready', function () {
        const $button = $(this);
        const $combatant = $button.closest('.combatant');
        const combatantId = $combatant.attr('id').replace('combatant-', '');
        const isDisabled = $button.hasClass('disabled');

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'dealWithAjax',
                ajaxAction: 'toggleReady',
                character: {
                    id: combatantId,
                    readyActive: isDisabled ? 1 : 0
                }
            },
            success: function (response) {
                if (!response.success) {
                    console.error('Impossible de modifier l\'intention.', response);
                    return;
                }

                $button.toggleClass('active, disabled');
            },
            error: function (xhr, status, error) {
                console.error('Erreur Ajax lors de la modification de la réaction :', error);
            }
        });
    });

    // Retirer un combattant du combat
    $(document).on('click', '.combatant .bench', function () {
        const $combatant = $(this).closest('.combatant');
        const combatantId = $combatant.attr('id').replace('combatant-', '');

        $.ajax({
            url: ajaxUrl,
            method: "POST",
            dataType: "json",
            data: {
                action: "dealWithAjax",
                ajaxAction: 'rmvInitCharToCombat',
                combatantId: combatantId,
            },
            success: function (response) {
                if (!response || response.success !== true) {
                    console.error(
                        "Échec de la mise à jour du combattant :",
                        response
                    );
                    return;
                }
                $(".initiative-main-content .combatant").remove();
                $(".initiative-main-content").append(response.data.panel);
                if (response.data.aside !== null) {
                    $(".character-list > #character-"+combatantId).remove();
                    $('.character-list > .edit-section').before(response.data.aside);
                }
            },
            error: function (xhr, status, error) {
                console.error("Erreur Ajax :", status, error);
            },
        });
    });

    // Editer le nombre maximal de points de vie d'un monstre.

    // Ouverture de la modale
    $(document).on('click', '.combatant .edit-button', function () {
        const $combatant = $(this).closest('.combatant');
        const combatantId = $combatant.attr('id').replace('combatant-', '');
        const maxHp = $combatant.find('.max-hp').text().trim();

        const $modal = $('[data-target="edit-maxHp-monster"]');

        $modal.find('.input-field').val(maxHp);
        $modal.data('combatant-id', combatantId);

        $modal.removeClass('d-none').trigger('focus');
    });

    // Fermeture par clic sur l'overlay
    $(document).on('click', '[data-target="edit-maxHp-monster"]', function (event) {
        if (event.target === this) {
            $(this).addClass('d-none');
        }
    });

    // Fermeture par bouton Close
    $(document).on('click', '[data-target="edit-maxHp-monster"] .panel-header > button', function () {
        $(this).closest('[data-target="edit-maxHp-monster"]').addClass('d-none');
    });

    // Validation
    $(document).on('click', '[data-target="edit-maxHp-monster"] .confirm-button', function () {
        const $modal = $(this).closest('[data-target="edit-maxHp-monster"]');
        const combatantId = $modal.data('combatant-id');
        const maxHp = Number($modal.find('.input-field').val());

        if (!Number.isInteger(maxHp) || maxHp < 1) {
            $modal.find('.input-field').trigger('focus');
            return;
        }

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'dealWithAjax',
                ajaxAction: 'updateInitChar',
                character: {
                    id: combatantId,
                    maxHp: maxHp
                }
            },
            success: function (response) {
                if (!response.success) {
                    console.error('Unable to update max HP.', response);
                    return;
                }

                $(".initiative-main-content .combatant").remove();
                $(".initiative-main-content").append(response.data.panel);

                $modal.addClass('d-none');
            },
            error: function (xhr, status, error) {
                console.error('AJAX error while updating max HP:', error);
            }
        });
    });    
}
