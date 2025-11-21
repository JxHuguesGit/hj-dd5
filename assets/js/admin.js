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

    $('#species-list input[name="characterSpeciesId"]').on('change', function () {
        $('.subspecies-group').hide()
            .filter('[data-species="' + this.value + '"]').show();
    });

    if ($('#subspecies-list input:checked').length!=0) {
        $('#subspecies-list input:checked').closest('.subspecies-group').show();
    }

    $('input[name="firstFeatId"').on('click', function() {
        if ($(this).val()==5) {
            $('#subfeats-list div').removeClass('d-none');
        } else {
            $('#subfeats-list div').addClass('d-none');
        }
    });
    $('input[name="secondFeatId"').on('click', function() {
        if ($(this).val()==5) {
            $('#subextrafeat-list div').removeClass('d-none');
        } else {
            $('#subextrafeat-list div').addClass('d-none');
        }
    });

    $('#createProcess').on('click', function(e) {
        e.preventDefault();
        const step = $('#herosForm').val();
        const characterId = $('#characterId').val();
        let blnOk = true;
        let msgError = '';

        if (characterId==0 && step!='name') {
            blnOk = false;
            msgError += "Vous devez forcément commencer par la saisie du nom et le valider.<br>";
        } else {
            switch (step) {
                case 'name' :
                    if ($('#characterName').val()=='') {
                        blnOk = false;
                        msgError += "Vous devez saisir un nom.<br>";
                    }
                break;
                case 'origin' :
                    if ($('input[name="characterOriginId"]:checked').length==0) {
                        blnOk = false;
                        msgError += "Vous devez sélectionner une origine.<br>";
                    }
                break;
                case 'species' :
                    if ($('input[name="characterSpeciesId"]:checked').length==0) {
                        blnOk = false;
                        msgError += "Vous devez sélectionner une espèce.<br>";
                    }
                break;
                case 'originFeat' :
                    if ($('input[name="firstFeatId"]:checked').length==0) {
                        blnOk = false;
                        msgError += "Vous devez sélectionner un don d'origine.<br>";
                    }
                    if ($('input[name="secondFeatId"]').length!=0
                        && $('input[name="secondFeatId"]:checked').length==0) {
                        blnOk = false;
                        msgError += "Vous devez sélectionner un deuxième don d'origine.<br>";
                    }
                    if (blnOk
                        && $('input[name="firstFeatId"]:checked').val()!=5
                        && $('input[name="firstFeatId"]:checked').val()!=8
                        && $('input[name="firstFeatId"]:checked').val()==$('input[name="secondFeatId"]:checked').val()) {
                        blnOk = false;
                        msgError += "Vous ne pouvez pas sélectionner deux fois le même don.<br>";
                    }
                    if ($('input[name="firstFeatId"]:checked').val()==5
                        && $('input[name="extraFirstFeatId"]:checked').length==0
                        || $('input[name="secondFeatId"]:checked').val()==5
                        && $('input[name="extraSecondFeatId"]:checked').length==0) {
                        blnOk = false;
                        msgError += "Vous devez sélectionner une classe pour le don <em>Initié à la Magie</em>.<br>";
                    }
                    if ($('input[name="firstFeatId"]:checked').val()==5
                        && $('input[name="extraFirstFeatId"]:checked').val()==$('input[name="extraSecondFeatId"]:checked').val()) {
                        blnOk = false;
                        msgError += "Vous ne pouvez pas sélectionner deux fois la même classe pour le don <em>Initié à la Magie</em>.<br>";
                    }
                break;
                case 'classe' :
                    if ($('input[name="characterClassId"]:checked').length==0) {
                        blnOk = false;
                        msgError += "Vous devez sélectionner une classe.<br>";
                    }
                break;
                default :
                    // RAS
                break;
            }
        }

        if (!blnOk) {
            showModal('danger', 'Formulaire invalide', '<p class="p-5 m-0 bg-light">'+msgError+'</p>');
        } else {
            $('form').submit();
        }
    });
    
});

let focusRemembered = '';

function showModal(type, title, content) {
    $('.modal-content').addClass('bg-'+type);
    $('#infoModalLabel').html(title);
    $('#modalBody').html(content);
    $('#infoModal').modal('show');
}

function ajaxActionChange(obj, e) {
    e.preventDefault();
    let actions = obj.data('action').split(',');
    for (let oneAction of actions) {
        if (oneAction=='loadMonsterPage') {
            loadMonsterPage(obj.val());
        } else if (oneAction=='loadTablePage') {
            loadTablePage(obj.val());
        }
    }
    return false;
}

function loadMonsterPage(newNbPerPage) {
    const newParams = {
        nbPerPage: newNbPerPage,
        refElementId: $('#firstElementId').val()
    };
    const url = new URL(globalThis.location.href);  
    for (const key in newParams) {
        url.searchParams.set(key, newParams[key]);
    }
    globalThis.location.href = url.toString();
}

function loadTablePage(newNbPerPage) {
	$('#nbPerPage').val(newNbPerPage);
    $('#formFilter').submit();
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