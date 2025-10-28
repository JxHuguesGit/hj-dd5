$(document).ready(function(e) {
    $('[data-modal="feat"]').on('click', function(e) {
        e.preventDefault();
        const postId = $(this).data('postid');
        const data = {'action': 'dealWithAjax', 'ajaxAction': 'modalFeatCard', 'postId': postId};
        const baseUrl = globalThis.location.origin + globalThis.location.pathname;
        const ajaxUrl = baseUrl.substr(0, baseUrl.length-4) + '-ajax.php';
        
        $.post({
            url: ajaxUrl,
            data: data,
            success: function (response) {
                const parsedData = JSON.parse(response.data);
                $('.modal-header').hide()
                $('.modal-footer').hide()
                $('#modalBody').html(parsedData.modalFeatCard);
                $('#infoModal').modal('show');
            },
            error: function () {
            }
        });
        return false;
    });
    
    $('[data-modal="monster"]').on('click', function(e) {
        e.preventDefault();
        const uktag = $(this).data('uktag');
        const data = {'action': 'dealWithAjax', 'ajaxAction': 'modalMonsterCard', 'uktag': uktag};
        const baseUrl = globalThis.location.origin + globalThis.location.pathname;
        const ajaxUrl = baseUrl.substr(0, baseUrl.length-4) + '-ajax.php';
        
        $.post({
            url: ajaxUrl,
            data: data,
            success: function (response) {
                const parsedData = JSON.parse(response.data);
                $('.modal-header').hide()
                $('.modal-footer').hide()
                $('#modalBody').html(parsedData.modalMonsterCard);
                $('#infoModal').modal('show');
            },
            error: function () {
            }
        });
        return false;
    });
    
    $('[data-modal="spell"]').on('click', function(e) {
        e.preventDefault();
        const id = $(this).data('uktag');
        const data = {'action': 'dealWithAjax', 'ajaxAction': 'modalSpellCard', 'id': id};
        const baseUrl = globalThis.location.origin + globalThis.location.pathname;
        const ajaxUrl = baseUrl.substr(0, baseUrl.length-4) + '-ajax.php';
        
        $.post({
            url: ajaxUrl,
            data: data,
            success: function (response) {
                const parsedData = JSON.parse(response.data);
                $('.modal-header').hide()
                $('.modal-footer').hide()
                $('#modalBody').html(parsedData.modalSpellCard);
                $('#infoModal').modal('show');
            },
            error: function () {
            }
        });
        return false;
    });
    
    $('i[data-source="aidedd"]').on('click', function(e) {
        e.preventDefault();
        const source = $(this).data('source');
        const uktag = $(this).data('uktag');
        const data = {'action': 'dealWithAjax', 'ajaxAction': 'downloadFile', 'source': source, 'uktag': uktag}
        const filePath = globalThis.location.origin + '/wp-content/plugins/hj-dd5/assets/aidedd/'+uktag+'.html';
        const baseUrl = globalThis.location.origin + globalThis.location.pathname;
        const ajaxUrl = baseUrl.substr(0, baseUrl.length-4) + '-ajax.php';

        $.post({
            url: ajaxUrl,
            data: data,
            success: function (response) {
                $.get(filePath, function(html) {
                    const $div = $('<div>').html(html); // on parse la chaîne HTML
                    const $content = $div.find('div.col'); // on cible le contenu voulu

                    $('#modalBody').html($content);
                    $('#infoModal').modal('show');
                });
            },
            error: function () {
                $('#infoModal .modal-body').html('<p class="text-danger">Erreur lors du chargement.</p>');
                const modal = new bootstrap.Modal(document.getElementById('infoModal'));
                modal.show();
            }
        });
        return false;
    });

    $('i.fa-square-plus').on('click', function(e) {
        let target = $(this).data('target');

        if ($(this).hasClass('fa-square-minus')) {
            $('tr[data-parent="'+target+'"]').addClass('d-none');
        } else {
            $('tr[data-parent]').addClass('d-none');
            $('tr[data-parent="'+target+'"]').removeClass('d-none');
            $('i.fa-square-minus').addClass('fa-square-plus').removeClass('fa-square-minus');
        }

        $(this).toggleClass('fa-square-plus fa-square-minus');
    });
    
    $('th[data-sortable]').on('click', function(){
        let ordre = 'asc';
        if ($(this).hasClass('dt-ordering-asc')) {
            ordre = 'desc';
        }
        // Nouveaux paramètres à ajouter
        let newParams = {
          tri: $(this).data('sortable'),
          ordre: ordre
        };

        // Récupère l'URL actuelle sans les paramètres
        let baseUrl = globalThis.location.origin + globalThis.location.pathname;

        // Récupère les paramètres existants
        let searchParams = new URLSearchParams(globalThis.location.search);
        searchParams.set('_', Date.now());

        // Ajoute / remplace les nouveaux paramètres
        for (let key in newParams) {
          searchParams.set(key, newParams[key]);
        }

        // Recharge la page avec les nouveaux paramètres
        globalThis.location.href = baseUrl + '?' + searchParams.toString();
    });

    $('.ajaxAction[data-trigger="change"]').on('change', function(e) {
        ajaxActionChange($(this), e);
    });

    $('*[data-action="RmbFocus"]').on('blur', function(e) {
    	focusRemembered = $(this).attr('id');
    });

    $('button[data-action="fdmTool"]').on('click', function(e) {
    	fdmToolsManagment($(this));
    });
});

let focusRemembered = '';

function ajaxActionChange(obj, e) {
    e.preventDefault();
    let actions = obj.data('action').split(',');
    for (let oneAction of actions) {
        if (oneAction=='loadMonsterPage') {
            loadMonsterPage(obj.val());
        }
    }
    return false;
}

function loadMonsterPage(newNbPerPage) {
    const newParams = {
        nbPerPage: newNbPerPage,
        refElementId: $('#refElementId').val()
    };
    const url = new URL(globalThis.location.href);  
    for (const key in newParams) {
        url.searchParams.set(key, newParams[key]);
    }
    globalThis.location.href = url.toString();
}

function fdmToolsManagment(obj) {
	let val = obj.data('val');
    let id = focusRemembered.split('-')[2];
    
    if (val==undefined) {
        let ref = obj.data('ref');

        if ($('#'+ref+'Name').length>0) {
            $('#mab-name-'+id).val($('#'+ref+'Name').val());
        }
        if ($('#'+ref+'Description').length>0) {
            $('#mab-description-'+id).val($('#mab-description-'+id).val()+$('#'+ref+'Description').val());
        }
    } else {
        $('#mab-description-'+id).val($('#mab-description-'+id).val()+val);
    }
    
}
