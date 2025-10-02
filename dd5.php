<?php
use src\Action\Ajax;

define('PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PLUGIN_PACKAGE', 'DD5');
session_start([]);

/**
 * Plugin Name: HJ - DD5
 * Description: DD5
 * @author Hugues
 * @since 1.00.01.01
 */
class DD5
{
    public function __construct()
    {
        add_filter('template_include', array($this,'templateLoader'));
    }

    public function templateLoader()
    {
        wp_enqueue_script('jquery');
        return PLUGIN_PATH.'templates/base.php';
    }
}
$objDD5 = new DD5();

function exceptionHandler($objException)
{
    $strHandler  = '<div class="card border-danger" style="max-width: 100%;margin-right: 15px;">';
    $strHandler .= '  <div class="card-header bg-danger text-white"><strong>';
    $strHandler .= $objException->getMessage().'</strong></div>';
    $strHandler .= '  <div class="card-body text-danger">';
    $strHandler .= '    <p>Une erreur est survenue dans le fichier <strong>'.$objException->getFile();
    $strHandler .= '</strong> à la ligne <strong>'.$objException->getLine().'</strong>.</p>';
    $strHandler .= '    <ul class="list-group">';

    $arrTraces = $objException->getTrace();
    foreach ($arrTraces as $trace) {
        $strHandler .= '<li class="list-group-item">Fichier <strong>'.$trace['file'];
        $strHandler .= '</strong> ligne <em>'.$trace['line'].'</em> :<br>';
        if (isset($trace['args'])) {
            if (!is_array($trace['args'])) {
                $strHandler .= $trace['class'].$trace['type'].$trace['function'];
                $strHandler .= '('.implode(', ', $trace['args']).')</li>';
            }
            $strHandler .= $trace['function'].'()</li>';
        }
    }

    $strHandler .= '    </ul>';
    $strHandler .= '  </div>';
    $strHandler .= '  <div class="card-footer"></div>';
    $strHandler .= '</div>';

    echo $strHandler;
}
set_exception_handler('exceptionHandler');

spl_autoload_register(function ($classname) {
    // Définir le répertoire principal du plugin
    $base_dir = substr(plugin_dir_path(__FILE__), 0, -1) . '\\src\\';

    $nbAntiSlash = substr_count($classname, '\\');
    if ($nbAntiSlash<2) {
        return;
    }

    list(, $directory, $file) = explode ('\\', $classname);
    // Définir un tableau avec les répertoires dans lesquels les classes peuvent se trouver
    $directories = ['Collection', 'Constant', 'Controller', 'Entity', 'Enum', 'Exception', 'Form', 'Repository', 'Utils'];

    $pathFile = $base_dir.$directory.'\\'.$file.'.php';
    $pathFile = str_replace('\\', '/', $pathFile);
    // Vérifier si le fichier existe et inclure le fichier si trouvé
    if (file_exists($pathFile)) {
        require_once $pathFile;
        return;  // Une fois la classe incluse, on arrête la recherche
    }
});

function dd5Menu()
{
    $urlRoot = 'hj-dd5/admin_manage.php';
    if (function_exists('add_menu_page')) {
        $uploadFiles = 'upload_files';
        $pluginName = 'DD5';
        $urlIcon = plugins_url('/hj-dd5/assets/images/favicon-24x24.svg');
        add_menu_page($pluginName, $pluginName, $uploadFiles, $urlRoot, '', $urlIcon);
        if (function_exists('add_submenu_page')) {
            $arrUrlSubMenu = array(
                'home'     => 'Accueil',
            );
            foreach ($arrUrlSubMenu as $key => $value) {
                $urlSubMenu = $urlRoot.'&amp;onglet='.$key;
                add_submenu_page($urlRoot, $value, $value, $uploadFiles, $urlSubMenu, $key);
            }
        }
    }
}
add_action('admin_menu', 'dd5Menu');

function dealWithAjaxCallback()
{
    try {
        $response = Ajax::dealWithAjax();

        // On suppose que dealWithAjax() renvoie un tableau ou un objet
        wp_send_json_success($response);
    } catch (\Throwable $e) {
        // En cas d'erreur, on retourne un message formaté
        wp_send_json_error([
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
    }
}
add_action('wp_ajax_dealWithAjax', 'dealWithAjaxCallback');
add_action('wp_ajax_nopriv_dealWithAjax', 'dealWithAjaxCallback');
/*
function redirect_if_not_logged_in() {
    if (!is_user_logged_in()) {
        // Redirige l'utilisateur vers la page de connexion
        wp_redirect(wp_login_url(get_permalink()));
        exit;
    }
}
add_action('init', 'redirect_if_not_logged_in');
*/
