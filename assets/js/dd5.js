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
	    switch (oneAction) {
            case 'loadCasteDetail' :
                let key = obj.data('key');
                let lang = obj.data('lang');
                loadCasteDetail(oneAction, key, lang);
            break;
		}
	}
    return false;
}

function loadCasteDetail(ajaxAction, key, lang) {
    let data = {'action': 'dealWithAjax', 'ajaxAction': ajaxAction, 'key': key, 'lang': lang}
    $.post(
        ajaxurl,
        data,
        function(response) {
            try {
                obj = JSON.parse(response.data);
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