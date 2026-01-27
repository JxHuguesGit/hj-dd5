$(document).ready(function() {
    $('.ajaxAction[data-trigger="click"]').on('click', function(e) {
        ajaxActionClick($(this), e);
    })

    $('button[data-activable="true"]').on('click', function(e) {
        e.preventDefault();
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    $('button[type="submit"]').on('click', function(e) {
        e.preventDefault();
        let formName = $(this).siblings('input').val();
        if (verifierFormulaire(formName)) {
            $(this).closest('form').submit();
        }
    });


});

function ajaxActionClick(obj, e) {
    e.preventDefault();
    let actions = obj.data('action').split(',');
    for (let oneAction of actions) {
        if (oneAction=='loadCasteDetail') {
            loadCasteDetail(oneAction, obj.data('key'), obj.data('lang'));
        } else if (oneAction=='loadMoreSpells') {
            loadMoreSpells(oneAction);
        } else if (oneAction=='openModal') {
            openModal(obj.data('target'));
            $('#spellFilter button.btn-primary').on('click', function() {
                loadMoreSpells('loadMoreSpells');
                closeModal('spellFilter');
            });
        }
    }
    return false;
}

function openModal(id) {
    $('#'+id).addClass('show').css('display', 'block');
    $('#'+id+' + .modal-backdrop').addClass('show').removeClass('d-none');

    $('button[data-bs-dismiss="modal"]').on('click', function() {
        closeModal(id);
    });
}

function closeModal(id) {
    $('#'+id).removeClass('show').css('display', 'none');
    $('#'+id+' + .modal-backdrop').removeClass('show').addClass('d-none');
}

function loadMoreSpells(ajaxAction) {
    const page = $('#spellTable tbody tr').length/10 + 1;
    const data = {'action': 'dealWithAjax', 'ajaxAction': 'loadMoreSpells', 'page': page};
    const baseUrl = globalThis.location.origin;
    const ajaxUrl = baseUrl + '/wp-admin/admin-ajax.php';
    $.post(
        ajaxUrl,
        data,
        function(response) {
            try {
                let obj = JSON.parse(response.data);
                const parser = new DOMParser();
                const doc = parser.parseFromString(obj.data, "text/html");
                const tbodyContent = doc.querySelector("tbody").innerHTML;
                $('#spellTable tbody').append(tbodyContent);
            } catch (e) {
                console.log("error: "+e);
                console.log(response);
            }
        }
    ).done(function(response) {
    });    
}

function loadCasteDetail(ajaxAction, key, lang) {
    let data = {'action': 'dealWithAjax', 'ajaxAction': ajaxAction, 'key': key, 'lang': lang}
    $.post(
        ajaxurl,
        data,
        function(response) {
            try {
                let obj = JSON.parse(response.data);
                console.log(obj);
                console.log(obj[ajaxAction]);
                $('#'+ajaxAction).html(obj[ajaxAction]);
            } catch (e) {
                console.log("error: "+e);
                console.log(response);
            }
        }
    ).done(function(response) {
    });    
}

function verifierFormulaire(formName) {
    let validFormulaire = true;

    if (formName=='casteSelection') {
        // On doit avoir sélectionner une caste.
        if ($('input[name="classSelectionValue"]:checked').val()==undefined) {
            validFormulaire = false;
        }
    }

    return validFormulaire;
}