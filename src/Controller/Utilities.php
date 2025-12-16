<?php
namespace src\Controller;

use src\Exception\TemplateInvalid;
use src\Constant\Template;

class Utilities
{
    protected array $arrParams=[];
    protected string $title;

    public function __construct(array $arrUri=[])
    {
        if (isset($arrUri[2]) && !empty($arrUri[2])) {
            if (strpos($arrUri[2], '?')!==false) {
                $params = substr($arrUri[2], strpos($arrUri[2], '?')+1);
            } else {
                $params = $arrUri[2];
            }
            if (isset($arrUri[3]) && substr($arrUri[3], 0, 12)=='admin_manage') {
                $params .= '/'.$arrUri[3];
            }
            $arrParams = explode('&', $params);
            while (!empty($arrParams)) {
                $param = array_shift($arrParams);
                list($key, $value) = explode('=', $param);
                $this->arrParams[str_replace('amp;', '', $key)] = $value;
            }
        }
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentFooter()
    {
        return $this->getRender(Template::FOOTER, [admin_url('admin-ajax.php')]);
    }

    public function getContentHeader()
    {
        return '';
    }

    public function getContentPage(): string
    {
        return '';
    }
    
    public function getRender(string $urlTemplate, array $args=[]): string
    {
        if (file_exists(PLUGIN_PATH.$urlTemplate)) {
            return vsprintf(file_get_contents(PLUGIN_PATH.$urlTemplate), $args);
        } else {
            throw new TemplateInvalid($urlTemplate);
        }
    }

    public function setField(string $field, $value): void
    {
        if (property_exists($this, $field)) {
            // Logique de validation de la valeur si nécessaire
            $this->{$field} = $value === null ? ' ' : $value;
        } else {
            throw new \InvalidArgumentException("Le champ '$field' n'existe pas.");
        }
    }

    public function getArrParams(string $key): mixed
    {
        return $this->arrParams[$key] ?? '';
    }
}
