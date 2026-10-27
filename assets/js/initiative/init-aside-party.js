export function initAsideParty() {
    const baseUrl = globalThis.location.origin;
    const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';
    const $overlayAddModal = $('.overlay[data-target="add-modal"]');
    const $overlayLvlUpModal = $('.overlay[data-target="lvlUp-modal"]');

    //////////////////////////////////////////////
    // Action sur le bouton ajouter un personnage
    //////////////////////////////////////////////
    // On affiche la modale
    $('.primary[data-action="show-add-modal"]').on('click', function () {
        $overlayAddModal.removeClass('d-none');
        // Focus sur le premier champ
        $overlayAddModal.find('.input').trigger('focus');
    });
    // Fermer via le bouton X
    $('[data-target="add-modal"] .modal-close').on('click', function () {
        $overlayAddModal.addClass('d-none');
    });
    // Fermer en cliquant sur l'overlay
    $overlayAddModal.on('click', function (event) {
        if ($(event.target).is($overlayAddModal)) {
            $overlayAddModal.addClass('d-none');
        }
    });
    // Fermer avec Échap
    $(document).on('keydown', function (event) {
        if (event.key === 'Escape') {
            $overlayAddModal.addClass('d-none');
        }
    });
    // On soumet la modale
    $(document).on("submit", "#add-character", function (e) {
        e.preventDefault();

        const baseUrl = globalThis.location.origin;
        const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';
        const $form = $(this);
        const data = {
            name: $form.find('[name="itCharName"]').val().trim(),
            level: Number($form.find('[name="itCharLevel"]').val()),
            ac: Number($form.find('[name="itCharCA"]').val()),
            maxHp: Number($form.find('[name="itCharMaxPV"]').val()),
            modDex: Number($form.find('[name="itCharModDex"]').val()),
            percPassive: Number($form.find('[name="itCharPassive"]').val()),
            initiativeTrackerId: $('.session .value').html()
        };

        $.ajax({
            url: ajaxUrl,
            method: "POST",
            dataType: "json",
            data: {
                action: "dealWithAjax",
                ajaxAction: 'addInitChar',
                character: data
            },
            success: function (response) {
                if (!response.success) {
                    console.error(response.data);
                    return;
                }
                const data = JSON.parse(response.data);
                const panel = data.addInitChar.panel;

                $('.character-list > .edit-section').before(panel);
            },
            error: function (xhr, status, error) {
                console.error("Erreur Ajax :", error);
            }
        });
    });
    //////////////////////////////////////////////

    //////////////////////////////////////////////
    // Action sur le bouton monter de niveau
    //////////////////////////////////////////////
    // On affiche la modale
    $('.secondary[data-action="show-lvlup-modal"]').on('click', function () {
        $overlayLvlUpModal.removeClass('d-none');
        // Focus sur le premier champ
        $overlayLvlUpModal.find('.input').trigger('focus');
    });
    // Fermer via le bouton X
    $('[data-target="lvlUp-modal"] .modal-close').on('click', function () {
        $overlayLvlUpModal.addClass('d-none');
    });
    // Fermer en cliquant sur l'overlay
    $overlayLvlUpModal.on('click', function (event) {
        if ($(event.target).is($overlayLvlUpModal)) {
            $overlayLvlUpModal.addClass('d-none');
        }
    });
    // Fermer avec Échap
    $(document).on('keydown', function (event) {
        if (event.key === 'Escape') {
            $overlayLvlUpModal.addClass('d-none');
        }
    });
    //////////////////////////////////////////////

    //////////////////////////////////////////////
    // Action sur le bouton ajouter d'un personnage
    //////////////////////////////////////////////
    $(document).on("click", ".character .btn-add", function () {
        $(this).closest(".character").removeClass("benched");

        const $character = $(this).closest(".character");
        // Récupération de l'identifiant du personnage
        const characterId = $character.attr("id").replace("character-", "");

        $.ajax({
            url: ajaxUrl,
            type: "POST",
            data: {
                action: "dealWithAjax",
                ajaxAction: 'addInitCharToCombat',
                character_id: characterId,
                initiativeTrackerId: $('.session .value').html()
            },
            success: function (response) {
                if (response.success) {
                    // TODO : on va devoir afficher dans la partie centrale la card du personnage.
                } else {
                    console.error(
                        "Impossible d'ajouter le personnage au combat :",
                        response.data
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error("Erreur Ajax :", error);
            }
        });
    });

    //////////////////////////////////////////////
    // Action sur le bouton éditer d'un personnage
    //////////////////////////////////////////////
    // On cache le bloc character correspondant,
    // on repositionne le bloc edition
    // on le renseigne avec les données de character
    $(document).on("click", ".character .btn-edit", function () {
        const $character = $(this).closest(".character");
        const $editSection = $(".edit-section");
        $editSection.data("character", $character);
        $editSection.data("characterId", $character.attr("id").replace("character-", ""));

        // Récupération des données
        const name = $character.find(".character-name-text").text().trim();
        const stats = $character.find(".character-stats").text();
        const ca = stats.match(/CA (\d+)/)?.[1] ?? "";
        const pvIndex = stats.indexOf(" PV");
        const pv = pvIndex === -1
            ? ""
            : stats.slice(0, pvIndex).match(/\d+$/)?.[0] ?? "";        
        const dex = stats.match(/DEX ([+-]?\d+)/)?.[1] ?? "";
        const passive = stats.match(/Passive (\d+)/)?.[1] ?? "";

        // Remplissage du formulaire
        $editSection.find("input").eq(0).val(name);
        $editSection.find(".field-input").eq(0).val(ca);
        $editSection.find(".field-input").eq(1).val(pv);
        $editSection.find(".field-input").eq(2).val(dex);
        $editSection.find(".field-input").eq(3).val(passive);

        // Déplacement du formulaire juste après le personnage
        $editSection.insertAfter($character);

        // Affichage / masquage
        $character.addClass("d-none");
        $editSection.removeClass("d-none");

        // Mémorisation pour le bouton Annuler / Save
        $editSection.data("character", $character);
    });
    // Quand on annule, on cache edition et on affiche character
    $(".edit-section .button-cancel").on("click", function () {
        const $editSection = $(".edit-section");
        const $character = $editSection.data("character");

        $character.removeClass("d-none");
        $editSection.addClass("d-none");
    });
    // Quand on sauvegarde, on envoie les données par Ajax
    // Puis on cache le bloc édition et on affiche le bloc initial modifié
    $(".edit-section .button.primary").on("click", function () {
        const $editSection = $(".edit-section");
        $editSection.addClass("d-none");

        const data = {
            id: $editSection.data("characterId"),
            name: $editSection.find(".input").val().trim(),
            ac: Number($editSection.find(".field-input").eq(0).val()),
            maxHp: Number($editSection.find(".field-input").eq(1).val()),
            modDex: Number($editSection.find(".field-input").eq(2).val()),
            percPassive: Number($editSection.find(".field-input").eq(3).val())
        };

        $.ajax({
            url: ajaxUrl,
            type: "POST",
            data: {
                action: "dealWithAjax",
                ajaxAction: "updateInitChar",
                character: data
            },
            success: function (response) {
                if (response.success) {
                    const characterId = $(".edit-section").data("characterId");

                    const result = JSON.parse(response.data);
                    $("#character-" + characterId)
                        .replaceWith(result.data.asideCard);
                } else {
                    console.error(
                        "Impossible de modifier le personnage :",
                        response.data
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error("Erreur Ajax :", error);
            },
            done: function() {
                const $editSection = $(".edit-section");
                $editSection.addClass("d-none");
            }
        });
    });
    //////////////////////////////////////////////

    //////////////////////////////////////////////
    // Action sur le bouton supprimer d'un personnage
    //////////////////////////////////////////////
    // On cache le bouton supprimer et on affiche les boutons Oui et Non
    $(document).on("click", ".character .btn-delete", function () {
        $(this).closest(".confirm-delete").addClass("ask");
    });
    // Bouton Non, on cache Oui et non et on afffiche supprimer
    $(document).on("click", ".character .status-cancel", function () {
        $(this).closest(".confirm-delete").removeClass("ask");
    });
    // On confirme suppression
    $(document).on("click", ".character .status-yes", function () {
        const $character = $(this).closest(".character");
        // Récupération de l'identifiant du personnage
        const characterId = $character.attr("id").replace("character-", "");

        $.ajax({
            url: ajaxUrl,
            type: "POST",
            data: {
                action: "dealWithAjax",
                ajaxAction: 'delInitChar',
                character_id: characterId
            },
            success: function (response) {
                if (response.success) {
                    $character.remove();
                } else {
                    console.error(
                        "Impossible de supprimer le personnage :",
                        response.data
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error("Erreur Ajax :", error);
            }
        });
    });
    //////////////////////////////////////////////
}
