$(document).ready(function(e) {
    $('.ajaxAction[data-trigger="click"]').on('click', function(e) {
        ajaxActionClick($(this), e);
    })

    addOpenMonsterModal();

});

// Gère les data-action des .ajaxAction[data-trigger="click"]
function ajaxActionClick(obj, e) {
    const actions = obj.data('action').split(',');

    for (const action of actions) {
        dispatchAjaxAction(action, obj, e);
    }

    return false;
}

function dispatchAjaxAction(action, obj, e) {
    const handlers = {
        loadMoreSpells: () => handleLoadMoreSpells('append', e),
        loadMoreMonsters: () => handleLoadMoreMonsters('append', e),
        toggleCheckbox: () => handleToggleCheckbox(obj),
        collapse: () => handleCollapse(obj),
        openModal: () => handleOpenModal(obj, e),
        openConfirm: () => handleOpenConfirm(obj, e),
        loadOrigin: () => handleLoadOrigin(obj),
        confirmCharacterDeletion: () => handleCharacterDeletion(obj, e),
        getAddTokenModal: () => handleGetAddTokenModal(e),

        activateMap: () => handleMapAction('activateMap', obj, e),
        duplicateMap: () => handleMapAction('duplicateMap', obj, e),
        deleteMap: () => handleMapAction('deleteMap', obj, e),
        lockMap: () => handleMapAction('lockMap', obj, e),
        unlockMap: () => handleMapAction('unlockMap', obj, e),
        resetMapFog: () => handleMapAction('resetMapFog', obj, e),

        deleteMapToken: () => handleMapTokenAction('deleteMapToken', obj, e),
        addMapToken: () => handleAddMapToken(e),
        toggleMapToken: () => handleMapTokenAction('toggleMapToken', obj, e),
        addToken: () => handleAddToken(e),
    };

    const handler = handlers[action];

    if (handler) {
        handler();
    } else {
        console.log(action + ' not implemented');
    }
}

function handleMapAction(action, obj, e) {
    e.preventDefault();

    sendAjaxAction(
        action,
        {
            mapId: obj.data('map-id')
        },
        function() {
            window.location.reload();
        }
    );
}
function handleMapTokenAction(action, obj, e) {
    e.preventDefault();

    sendAjaxAction(
        action,
        {
            tokenId: obj.data('map-token-id')
        },
        function() {
            refreshMapTokens();
        }
    );
}
function handleAddMapToken(e) {
    e.preventDefault();

    sendAjaxAction(
        'addMapToken',
        {
            mapId: MAP_CONFIG.mapId,
            tokenId: $('#confirmModal [name="tokenId"]').val(),
            column: $('#confirmModal [name="column"]').val(),
            row: $('#confirmModal [name="row"]').val()
        },
        function() {
            closeModal('confirmModal');
            refreshMapTokens();
        }
    );
}
function handleAddToken(e) {
    e.preventDefault();

    sendAjaxAction(
        'addToken',
        {
            tokenName: $('#confirmModal [name="name"]').val(),
            tokenImage: $('#confirmModal [name="image"]').val(),
            tokenType: $('#confirmModal [name="type"]').val(),
            tokenEntityId: $('#confirmModal [name="monsterId"]').val(),
            tokenSize: $('#confirmModal [name="size"]').val(),
        },
        function() {
            window.location.reload();
        }
    );
}

function handleOpenModal(obj, e) {
    e.preventDefault();
    const target = obj.data('target');
    openModal(target);
    $('#'+target+' button.btn-primary').unbind().on('click', function() {
        if (target=='spellFilter') {
            loadMoreSpells('replace');
        }
        closeModal(target);
    });
}

function handleOpenConfirm(obj, e) {
    e.preventDefault();
    const target = 'confirmModal';
    $('#' + target + ' h5').html(obj.data('title'));
    $('#' + target + ' .modal-body').html(obj.data('description'));
    openModal(target);
    $('#' + target + ' button.btn-primary').unbind().on('click', function() {
        window.location.href = obj.attr('href');
    });
}

function handleLoadOrigin(obj, e) {
    loadCreationStepSide('origin', obj.val());
}

function handleCharacterDeletion(obj, e) {
    e.preventDefault();
    const target = 'confirmModal';
    $('#' + target + ' h5').html('Confirmer la suppression');
    $('#' + target + ' .modal-body').html('Êtes-vous sûr de vouloir supprimer ce personnage ? Cette action est irréversible.');
    openModal(target);
    $('#' + target + ' button.btn-primary').unbind().on('click', function() {
        window.location.href = obj.attr('href');
    });
}

function handleGetAddTokenModal(e) {
    e.preventDefault();

    $.post(
        globalThis.location.origin + '/wp-admin/admin-ajax.php',
        {
            action: 'dealWithAjax',
            ajaxAction: 'getAddTokenModal'
        },
        function (response) {
            try {
                const obj = JSON.parse(response.data);

                if (obj.status !== 'success') {
                    console.error('Erreur getAddTokenModal:', obj);
                    return;
                }

                const modal = obj.data.data;

                $('#confirmModalLabel').text(modal.title);
                $('#confirmModalBody').html(modal.content);
                $('#confirmModalButton').text(modal.action.label);

                $('#confirmModalButton').off('click')
                .data(
                    'action',
                    modal.action.ajaxAction
                ).addClass(
                    'ajaxAction'
                ).on(
                    'click',
                    function(e) {
                        ajaxActionClick($(this), e);
                    }
                );

                openModal('confirmModal');

            } catch (e) {
                console.error('Erreur getAddTokenModal:', e);
                console.error(response);
            }
        }
    );    
}

function sendAjaxAction(ajaxAction, data, onSuccess) {
    $.post(
        globalThis.location.origin + '/wp-admin/admin-ajax.php',
        {
            action: 'dealWithAjax',
            ajaxAction: ajaxAction,
            ...data
        },
        function(response) {
            try {
                const result = JSON.parse(response.data);

                if (result.status !== 'success') {
                    console.error(
                        'Erreur ' + ajaxAction + ':',
                        result
                    );
                    return;
                }

                onSuccess(result.data);
            } catch (error) {
                console.error(
                    'Erreur ' + ajaxAction + ':',
                    error
                );
                console.error(response);
            }
        }
    );
}

// Ouvre la modale dont on passe l'identifiant
function openModal(id) {
    if ($('#'+id).length==0) {
        console.log('Error: no modal with id '+id);
        return false;
    }
    $('.modal').show();
    $('#'+id).addClass('show').css('display', 'block');
    $('#'+id+' + .modal-backdrop').addClass('show').removeClass('d-none');
    $('button[data-bs-dismiss="modal"]').on('click', function() {
        closeModal(id);
    });
}

// Ferme la modale dont on passe l'identifiant
function closeModal(id) {
    $('.modal').hide();
    $('#'+id).removeClass('show').css('display', 'none');
    $('#'+id+' + .modal-backdrop').removeClass('show').addClass('d-none');
}

// Coche et décoche une case à cocher
function handleToggleCheckbox(obj) {
    const id = obj.data('target');
    $('#'+id).prop('checked', !$('#'+id).prop('checked'));
}

// Plie et déplie un fieldset
function handleCollapse(obj) {
    if (obj[0].localName!='legend' || !obj.parent().hasClass('collapsible')) {
        return false;
    }
    obj.parent().toggleClass('collapsed');
}

// Lance le script Ajax pour afficher plus de sorts dans la liste de présentation des sorts.
// Présent côté admin et public.
function handleLoadMoreSpells(type, e) {
    const page = $('.spell-grid .spell-card').length / 12 + (type == 'append' ? 1 : 0);
    const data = {
        'action': 'dealWithAjax',
        'ajaxAction': 'loadMoreSpells',
        'type': type,
        'page': page,
        'spellFilter': $('#formSpellFilter').serialize()
    };
    const baseUrl = globalThis.location.origin;
    const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';

    $.post(
        ajaxUrl,
        data,
        function(response) {
            try {
                let obj = JSON.parse(response.data);
                const parser = new DOMParser();
                const doc = parser.parseFromString(obj.data.html, "text/html");
                const gridContent = doc.querySelector(".spell-grid").innerHTML;

                if (type=='append') {
                    $('.spell-grid').append(gridContent);
                } else {
                    $('.spell-grid').html(gridContent);
                }

                const hasMore = obj.data.hasMore;
                if (hasMore) {
                    $('.spell-load-more').show();
                } else {
                    $('.spell-load-more').hide();
                }

            } catch (e) {
                console.log("error: "+e);
                console.log(response);
            }
        }
    ).done(function(response) {
    });
}

// Lance le script Ajax pour afficher plus de sorts dans la liste de présentation des monstres
function handleLoadMoreMonsters(type, e) {
    const page = $('#spellMonster tbody tr').length/10 + 1;
    const data = {
        'action': 'dealWithAjax',
        'ajaxAction': 'loadMoreMonsters',
        'type': type,
        'page': page,
        //'spellFilter': $('#formSpellFilter').serialize()
    };
    const baseUrl = globalThis.location.origin;
    const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';

    $.post(
        ajaxUrl,
        data,
        function(response) {
            try {
                let obj = JSON.parse(response.data);
                const parser = new DOMParser();
                const doc = parser.parseFromString(obj.data.html, "text/html");
                const tbodyContent = doc.querySelector("tbody").innerHTML;
                if (type=='append') {
                    $('#spellMonster tbody').append(tbodyContent);
                } else {
                    $('#spellMonster tbody').html(tbodyContent);
                }

                const hasMore = obj.data.hasMore;
                if (hasMore) {
                    $('div[data-action="loadMoreMonsters"] i').show();
                } else {
                    $('div[data-action="loadMoreMonsters"] i').hide();
                }

            } catch (e) {
                console.log("error: "+e);
                console.log(response);
            }
        }
    ).done(function(response) {
        addOpenMonsterModal();
    });
}

function loadCreationStepSide(type, id) {
    const data = {'action': 'dealWithAjax', 'ajaxAction': 'loadCreationStepSide', 'type' : type, 'id': id};
    const baseUrl = globalThis.location.origin + globalThis.location.pathname;
    const ajaxUrl = baseUrl.slice(0, -4) + '-ajax.php';

    $.post({
        url: ajaxUrl,
        data: data,
        success: function (response) {
            const parsedData = JSON.parse(response.data);
            $('#creationStepSideBody').html(parsedData.data.html);
        },
        error: function () {
        }
    });
}


function addOpenMonsterModal() {
    $('[data-modal="monster"]').unbind().on('click', function(e) {
        e.preventDefault();
        const uktag = $(this).data('uktag');
        const data = {'action': 'dealWithAjax', 'ajaxAction': 'modalMonsterCard', 'uktag': uktag};
        const baseUrl = globalThis.location.origin + globalThis.location.pathname;
        const ajaxUrl = baseUrl.slice(0, -4) + '-ajax.php';

        $.post({
            url: ajaxUrl,
            data: data,
            success: function (response) {
                try {
                    let obj = JSON.parse(response.data);
                    $('.modal-header').hide()
                    $('.modal-footer').hide()
                    $('#modalBody').html(obj.data.html);
                    $('#infoModal').modal('show');
                } catch (e) {
                console.log("error: "+e);
                console.log(response);
            }
        },
            error: function () {
            }
        });
        return false;
    });
}
