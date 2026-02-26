$(document).ready(function(e) {
    $('.ajaxAction[data-trigger="click"]').on('click', function(e) {
        ajaxActionClick($(this), e);
    })

    addOpenMonsterModal();

});

// Gère les data-action des .ajaxAction[data-trigger="click"]
// Pour l'heure, ça inclut :
// liadMoreSpells, openModal
function ajaxActionClick(obj, e) {
    let actions = obj.data('action').split(',');
    for (let oneAction of actions) {
        if (oneAction=='loadMoreSpells') {
            e.preventDefault();
            loadMoreSpells('append');
        } else if (oneAction=='loadMoreMonsters') {
            e.preventDefault();
            loadMoreMonsters('append');
        } else if (oneAction=='toggleCheckbox') {
            e.preventDefault();
            const target = obj.data('target');
            toggleCheckbox(target);
        } else if (oneAction=='collapse') {
            e.preventDefault();
            collapse(obj);
        } else if (oneAction=='openModal') {
            e.preventDefault();
            const target = obj.data('target');
            openModal(target);
            $('#'+target+' button.btn-primary').unbind().on('click', function() {
                if (target=='spellFilter') {
                    loadMoreSpells('replace');
                }
                closeModal(target);
            });
        } else if (oneAction=='loadOrigin') {
            loadCreationStepSide('origin', obj.val())
        }
    }
    return false;
}

// Ouvre la modale dont on passe l'identifiant
function openModal(id) {
    $('#'+id).addClass('show').css('display', 'block');
    $('#'+id+' + .modal-backdrop').addClass('show').removeClass('d-none');

    $('button[data-bs-dismiss="modal"]').on('click', function() {
        closeModal(id);
    });
}

// Ferme la modale dont on passe l'identifiant
function closeModal(id) {
    $('#'+id).removeClass('show').css('display', 'none');
    $('#'+id+' + .modal-backdrop').removeClass('show').addClass('d-none');
}

// Coche et décoche une case à cocher
function toggleCheckbox(id) {
    $('#'+id).prop('checked', !$('#'+id).prop('checked'));
}

// Plie et déplie un fieldset
function collapse(obj) {
    if (obj[0].localName!='legend' || !obj.parent().hasClass('collapsible')) {
        return false;
    }
    obj.parent().toggleClass('collapsed');
}

// Lance le script Ajax pour afficher plus de sorts dans la liste de présentation des sorts.
// Présent côté admin et public.
function loadMoreSpells(type) {
    const page = $('#spellTable tbody tr').length/10 + 1;
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
                const tbodyContent = doc.querySelector("tbody").innerHTML;
                if (type=='append') {
                    $('#spellTable tbody').append(tbodyContent);
                } else {
                    $('#spellTable tbody').html(tbodyContent);
                }

                const hasMore = obj.data.hasMore;
                if (hasMore) {
                    $('div[data-action="loadMoreSpells"] i').show();
                } else {
                    $('div[data-action="loadMoreSpells"] i').hide();
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
function loadMoreMonsters(type) {
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
