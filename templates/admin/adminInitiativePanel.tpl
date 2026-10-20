<!-- Font Awesome Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" crossorigin="" href="%1$sassets/styles/initiative.css?v=%2$s">
<link rel="stylesheet" crossorigin="" href="%1$sassets/styles/draft.css?v=%2$s">

%3$s
<div class="initiative-menu initiative-tracker-menu hidden">
<!--
    <button title="Expand or collapse this section" class="flex w-full items-center justify-between px-4 pt-2.5 pb-1 text-left text-[10px] font-bold tracking-wider text-gray-500 uppercase transition hover:text-gray-300 svelte-x1i5gj">
        Session Tools <i aria-hidden="true" class="fa-solid fa-chevron-down shrink-0 text-xs transition-transform -rotate-90 svelte-x1i5gj"></i>
    </button>
    <button title="Expand or collapse this section" class="flex w-full items-center justify-between border-t border-gray-700 px-4 pt-2.5 pb-1 text-left text-[10px] font-bold tracking-wider text-gray-500 uppercase transition hover:text-gray-300 svelte-x1i5gj">
        Campaign <i aria-hidden="true" class="fa-solid fa-chevron-down shrink-0 text-xs transition-transform -rotate-90 svelte-x1i5gj"></i>
    </button>
    <button title="Expand or collapse this section" class="flex w-full items-center justify-between border-t border-gray-700 px-4 pt-2.5 pb-1 text-left text-[10px] font-bold tracking-wider text-gray-500 uppercase transition hover:text-gray-300 svelte-x1i5gj">
        Account <i aria-hidden="true" class="fa-solid fa-chevron-down shrink-0 text-xs transition-transform -rotate-90 svelte-x1i5gj"></i>
    </button>
    <button title="Expand or collapse this section" class="flex w-full items-center justify-between border-t border-gray-700 px-4 pt-2.5 pb-1 text-left text-[10px] font-bold tracking-wider text-gray-500 uppercase transition hover:text-gray-300 svelte-x1i5gj">
        Display <i aria-hidden="true" class="fa-solid fa-chevron-down shrink-0 text-xs transition-transform -rotate-90 svelte-x1i5gj"></i>
    </button>
-->
    <a href="https://dd5.jhugues.fr/wp-admin/admin.php?page=hj-dd5/admin_manage.php" rel="noopener noreferrer" title="Retour à l'admin">Retour à l'admin</a>
</div>

<div class="initiative-body">
    <aside class="party">%4$s</aside>
    <main class="initiative-main">
        <div class="active-combatants %6$s">
            <div class="panel-header">%7$s</div>

            <div class="initiative-main-content">
                %8$s
                <p>Add players and enemies, then enter initiative rolls to begin.</p>
            </div>
        </div>
    </main>
    <aside class="ennemies">%5$s</aside>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"
    integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="module" src="%1$sassets/js/initiative/init-main.js?v=%2$s"></script>
<script src="%1$sassets/js/initiative.js?v=%2$s"></script>
<!--
<script src="%1$sassets/js/combat.js?v=%2$s"></script>
-->
<script src="%1$sassets/js/draft.js?v=%2$s"></script>
