$(document).ready(function(e) {
    $('i[data-modal="monster"]').on('click', function(e) {
        e.preventDefault();
        const uktag = $(this).data('uktag');
		const data = {'action': 'dealWithAjax', 'ajaxAction': 'modalMonsterCard', 'uktag': uktag};
        
        $.post({
        	url: 'http://localhost/wp-admin/admin-ajax.php',
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

    $('i[data-source="aidedd"]').on('click', function(e) {
        e.preventDefault();
        const source = $(this).data('source');
        const uktag = $(this).data('uktag');
        const data = {'action': 'dealWithAjax', 'ajaxAction': 'downloadFile', 'source': source, 'uktag': uktag}
        const filePath = 'http://localhost/wp-content/plugins/hj-dd5/assets/aidedd/'+uktag+'.html';

        $.post({
            url: 'http://localhost/wp-admin/admin-ajax.php',
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
        let baseUrl = window.location.origin + window.location.pathname;

        // Récupère les paramètres existants
        let searchParams = new URLSearchParams(window.location.search);
        searchParams.set('_', Date.now());

        // Ajoute / remplace les nouveaux paramètres
        for (let key in newParams) {
          searchParams.set(key, newParams[key]);
        }

        // Recharge la page avec les nouveaux paramètres
        window.location.href = baseUrl + '?' + searchParams.toString();
    });
});