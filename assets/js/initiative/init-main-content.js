export function initMainContent() {
    const baseUrl = globalThis.location.origin;
    const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';
    const initTrackerId = $('.session .value').html();

    function getCombatantData(element) {
        const $combatant = $(element).closest('.combatant');

        return {
            $combatant,
            id: $combatant.attr('id').replace('combatant-', ''),
            name: $combatant.find('.combatant-name').text().trim()
        };
    }

    function refreshCombatants(panel) {
        $('.initiative-main-content .combatant').remove();
        $('.initiative-main-content').append(panel);
    }

    function ajaxAction(actionName, data = {}, onSuccess = null) {
        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'dealWithAjax',
                ajaxAction: actionName,
                ...data
            },
            success(response) {
                if (!response?.success) {
                    console.error(`Erreur sur ${actionName}`, response);
                    return;
                }

                if (onSuccess) {
                    onSuccess(response);
                }
            },
            error(xhr, status, error) {
                console.error(`AJAX error on ${actionName}:`, error);
            }
        });
    }

    function openModal(target) {
        $(`.overlay[data-target="${target}"]`)
            .removeClass('d-none')
            .trigger('focus');
    }

    function closeModal(target) {
        $(`.overlay[data-target="${target}"]`)
            .addClass('d-none');
    }

    function executeCombatAction(actionName, onSuccess) {
        ajaxAction(
            actionName,
            {
                itCode: initTrackerId
            },
            response => {
                refreshCombatants(response.data.panel);

                if (onSuccess) {
                    onSuccess(response.data);
                }
            }
        );
    }

    function getModal(target) {
        return $(`.overlay[data-target="${target}"]`);
    }

    function openConditionModal(combatant, condition, label) {
        $('#condition-label').text(label);
        $('#target-label').text(combatant.name);

        const $modal = getModal('edit-conditions');

        $modal.data('condition', condition);
        $modal.data('combatant-id', combatant.id);

        $('#condition-rounds-input').val(1);
        $('#condition-duration').text('1 round');

        openModal('edit-conditions');
    }

    function addCondition(rounds = null) {
        const $modal = getModal('edit-conditions');

        ajaxAction(
            'addConditionToCharacter',
            {
                character: {
                    id: $modal.data('combatant-id'),
                    condition: $modal.data('condition'),
                    rounds
                }
            },
            response => {
                refreshCombatants(response.data.panel);
                closeModal('edit-conditions');
            }
        );
    }

    $(document)
        .on('click', '.combatant .reaction', function () {
        // Toggle reaction
            const $button = $(this);
            const combatant = getCombatantData(this);

            ajaxAction(
                'toggleReaction',
                {
                    character: {
                        id: combatant.id,
                        reactionAvailable: $button.hasClass('active') ? 0 : 1
                    }
                },
                () => {
                    $button.toggleClass('active');
                }
            );
        })
        .on('click', '.combatant .surprise', function () {
        // Toggle surprise
            const $button = $(this);
            const combatant = getCombatantData(this);

            ajaxAction(
                'toggleSurprise',
                {
                    character: {
                        id: combatant.id,
                        surprised: $button.hasClass('active') ? 0 : 1
                    }
                },
                () => {
                    $button.toggleClass('active');
                }
            );
        })
        .on('click', '.combatant .inspiration', function () {
        // Toggle Inspiration héroïque
            const $button = $(this);
            const combatant = getCombatantData(this);

            ajaxAction(
                'toggleInspiration',
                {
                    character: {
                        id: combatant.id,
                        heroicInspirationAvailable: $button.hasClass('active') ? 0 : 1
                    }
                },
                () => {
                    $button.toggleClass('active');
                }
            );
        })
        .on('click', '.combatant .ready', function () {
        // Toggle ready
            const $button = $(this);
            const combatant = getCombatantData(this);

            ajaxAction(
                'toggleReady',
                {
                    character: {
                        id: combatant.id,
                        readyActive: $button.hasClass('active') ? 0 : 1
                    }
                },
                () => {
                    $button.toggleClass('active');
                }
            );
        })
        .on('click', '.combatant .bench', function () {
        // Retirer un combattant du combat
            const combatant = getCombatantData(this);

            ajaxAction(
                'rmvInitCharToCombat',
                {
                    combatantId: combatant.id
                },
                response => {
                    refreshCombatants(response.data.panel);

                    if (response.data.aside !== null) {
                        $(`.character-list > #character-${combatant.id}`).remove();
                        $('.character-list > .edit-section')
                            .before(response.data.aside);
                    }
                }
            );
        })
        .on('click', '.combatant .edit-button', function () {
            const combatant = getCombatantData(this);
            const maxHp = combatant.$combatant.find('.max-hp').text().trim();

            const $modal = getModal('edit-maxHp-monster');

            $modal.find('.input-field').val(maxHp);
            $modal.data('combatant-id', combatant.id);

            openModal('edit-maxHp-monster');
        })
        .on('click', '[data-target="edit-maxHp-monster"]', function (event) {
            if (event.target === this) {
                closeModal('edit-maxHp-monster');
            }
        })
        .on('click', '[data-target="edit-maxHp-monster"] .panel-header > button', function () {
            closeModal('edit-maxHp-monster');
        })
        .on('click', '[data-target="edit-maxHp-monster"] .confirm-button', function () {
        // Validation
            const $modal = $(this).closest('[data-target="edit-maxHp-monster"]');
            const maxHp = Number($modal.find('.input-field').val());

            if (!Number.isInteger(maxHp) || maxHp < 1) {
                $modal.find('.input-field').trigger('focus');
                return;
            }

            const combatantId = $modal.data('combatant-id');

            ajaxAction(
                'updateInitChar',
                {
                    character: {
                        id: combatantId,
                        maxHp: maxHp
                    }
                },
                response => {
                    refreshCombatants(response.data.panel);
                    closeModal('edit-maxHp-monster');
                }
            );
        })
        .on('click', '.add-state', function (e) {
        // Gestion des conditions
            e.stopPropagation();
            const $menu = $(this).next('.state-menu');
            // Fermeture des autres menus
            $('.state-menu').not($menu).addClass('d-none');
            // Toggle du menu courant
            $menu.toggleClass('d-none');
        })
        .on('click', '.state-menu', function (e) {
            e.stopPropagation();
        })
        .on('click', '.state-menu button', function () {
            openConditionModal(
                getCombatantData(this),
                $(this).data('condition'),
                $(this).text().trim()
            );
        })
        .on('click', '.close-condition-modal', function () {
            closeModal('edit-conditions');
        })
        .on('click', '.overlay', function () {
            closeModal($(this).data('target'));
        })
        .on('click', '.overlay > *', function (e) {
            e.stopPropagation();
        })
        .on('click', function () {
            $('.state-menu').addClass('d-none');
        })
        .on('click', '#condition-submit', function () {
            addCondition($('#condition-rounds-input').val());
        })
        .on('click', '#condition-no-limit', function () {
            addCondition(null);
        });

    $(document).on('input', '#condition-rounds-input', function () {
        const rounds = parseInt($(this).val(), 10) || 1;

        $('#condition-duration').text(
            rounds === 1
                ? '1 round'
                : `${rounds} rounds`
        );
    });


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
    $(".initiative-main").on("change", ".combatant .initiative > input", function () {
        const combatant = getCombatantData(this);
        const initiative = Number($(this).val());

        if ($(this).val() === "" || !Number.isFinite(initiative)) {
            return;
        }

        ajaxAction(
            'updateInitChar',
            {
                character: {
                    id: combatant.id,
                    initiative
                }
            },
            response => {
                refreshCombatants(response.data.panel);
            }
        );
    });

    // Ajout, suppression points de vie (temporaires)
    $(".initiative-main-content").on("click", ".combatant .damage, .combatant .heal, .combatant .thp", function () {
        const combatant = getCombatantData(this);
        const number = combatant.$combatant
            .find(".hit-points-edit input[type='number']")
            .val();
        let actionName = '';

        if ($(this).hasClass("damage")) {
            actionName = "dealDamage";
        } else if ($(this).hasClass("heal")) {
            actionName = "heal";
        } else {
            actionName = "setTempHP";
        }

        if (number === "" || !Number.isFinite(Number(number)) || Number(number) < 1) {
            return;
        }

        ajaxAction(
            actionName,
            {
                combatantId: combatant.id,
                amount: Number(number)
            },
            response => {
                $(`#combatant-${combatant.id}`)
                    .replaceWith(response.data.panel);
            }
        );
    });



}
