export function initAsideMonsters() {
    const baseUrl = globalThis.location.origin;
    const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';
    const initTrackerId = $('.session .value').text().trim();

    $(document).on('input', '.panel-filters input', function () {
        const search = $(this).val().trim().toLocaleLowerCase();

        $('.monster-list > .monster').each(function () {
            const name = $(this).find('.monster-name').text().trim().toLocaleLowerCase();

            $(this).toggle(name.includes(search));
        });
    });

    // Ouvrir le panneau d'ajout en cliquant sur un monstre
    $(document).on('click', '.monster-list > .monster > .details', function () {
        const $monster = $(this).closest('.monster');
        const monsterId = $monster.attr('id').replace('monster-', '');
        const monsterName = $monster.find('.monster-name span').text().trim();

        const $panel = $('.panel-add-monsters');

        $panel.data('monster-id', monsterId);
        $panel.find('.panel-header .title').text(monsterName);
        $panel.find('.panel-body input').val(1);

        $panel.removeClass('d-none');
    });

    // Fermer le panneau
    $(document).on('click', '.panel-add-monsters .panel-header button', function () {
        $(this).closest('.panel-add-monsters').addClass('d-none');
    });

    // Diminuer la quantité
    $(document).on('click', '.panel-add-monsters .panel-body button[aria-label="Decrease quantity"]', function () {
        const $input = $(this).siblings('input');
        const quantity = Number($input.val()) || 1;

        $input.val(Math.max(1, quantity - 1));
    });

    // Augmenter la quantité
    $(document).on('click', '.panel-add-monsters .panel-body button[aria-label="Increase quantity"]', function () {
        const $input = $(this).siblings('input');
        const quantity = Number($input.val()) || 1;

        $input.val(Math.min(20, quantity + 1));
    });

    // Ajouter au combat
    $(document).on('click', '.panel-add-monsters .submit-button', function () {
        const $panel = $(this).closest('.panel-add-monsters');
        const monsterId = $panel.data('monster-id');
        const $input = $panel.find('.panel-body input');
        const quantity = Number($input.val());

        if (!monsterId || !Number.isInteger(quantity) || quantity < 1 || quantity > 20) {
            $input.trigger('focus');
            return;
        }

        const $button = $(this);
        $button.prop('disabled', true);

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'dealWithAjax',
                ajaxAction: 'addMonsterToCombat',
                monsterId: monsterId,
                quantity: quantity,
                initiativeTrackerId: initTrackerId
            },
            success: function (response) {
                if (!response.success) {
                    console.error('Impossible d’ajouter le monstre au combat.', response);
                    return;
                }

                $(".initiative-main-content .combatant").remove();
                $(".initiative-main-content").append(response.data.panel);

                // Réinitialiser la quantité sans fermer le panneau
                $input.val(1);
            },
            error: function (xhr, status, error) {
                console.error('Erreur Ajax lors de l’ajout du monstre :', error);
            },
            complete: function () {
                $button.prop('disabled', false);
            }
        });
    });

}
