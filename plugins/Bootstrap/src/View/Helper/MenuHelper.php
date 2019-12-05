<?php
/**
 * Menu helper
 */
namespace Bootstrap\View\Helper;
use Cake\View\Helper;
use Cake\View\View;
use Cake\View\Helper\UrlHelper;
/**
 * mantém o Menu
 */
class MenuHelper extends Helper {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Construct the widgets and binds the default context providers.
     *
     * @param \Cake\View\View $View The View this helper is being attached to.
     * @param array $config Configuration settings for the helper.
     */
    public function __construct(View $View, array $config = [])
    {
    	parent::__construct($View, $config);
    	$this->Url = new UrlHelper($View);
    }

    /**
     * Retorn os sub-menus de um menu.
	 *
	 * <a class="dropdown-item" href="<?= $this->Url->build('/auditorias'); ?>">Auditorias</a>
	 *
     * @param 	string 	$menuPai 	Nome do menu pai.
     * @param  	array 	$urls 		Opcoes para o submenu.
     */
    public function getSubMenus($menuPai='', $urls=[])
    {
    	$html = '<div class="dropdown-menu"><!-- menu '.$menuPai.' -->';

    	foreach($urls as $_url => $_arrProp)
    	{
    		if ($_arrProp['menu'] === $menuPai)
    		{
    			$html .= "<a class='dropdown-item' href='". $this->Url->build($_arrProp['url'], true)."'>".$_arrProp['titulo']."</a>";
    		}
    	}
    	$html .= "</div><!-- fim menu $menuPai -->";

    	return $html;
    }
}
