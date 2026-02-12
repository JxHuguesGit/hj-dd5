$(document).ready(function(e) {
    $('.ajaxAction[data-trigger="click"]').on('click', function(e) {
        ajaxActionClick($(this), e);
    })
});

// Gère les data-action des .ajaxAction[data-trigger="click"]
// Pour l'heure, ça inclut :
// liadMoreSpells, openModal
function ajaxActionClick(obj, e) {
    e.preventDefault();
    let actions = obj.data('action').split(',');
    for (let oneAction of actions) {
        if (oneAction=='loadMoreSpells') {
            loadMoreSpells('append');
        } else if (oneAction=='loadMoreMonsters') {
            loadMoreMonsters('append');
        } else if (oneAction=='openModal') {
            const target = obj.data('target');
            openModal(target);
            $('#'+target+' button.btn-primary').unbind().on('click', function() {
                if (target=='spellFilter') {
                    loadMoreSpells('replace');
                }
                closeModal(target);
            });
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
    });    
}