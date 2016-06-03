<?php
/**
 * HtmlRenderer
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html;

use Xpressengine\Http\Request;
use Xpressengine\Presenter\RendererInterface;
use Xpressengine\Presenter\Presenter;
use Xpressengine\Presenter\Exceptions\NotFoundSkinException;
use Xpressengine\Seo\SeoHandler;
use Xpressengine\Theme\ThemeEntityInterface;
use Xpressengine\Widget\WidgetParser;

/**
 * HtmlRenderer
 *
 * * html 으로 출력될 경우 사용
 * * Skin, Theme 를 출력할 수 있도록 지원
 *
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 */
class HtmlRenderer implements RendererInterface
{
    /**
     * 일반 출력할 때 사용할 wrapper
     *
     * @var string
     */
    static protected $commonHtmlWrapper = '';

    /**
     * 팝업 형식으로 출력할 때 사용할 wrapper
     *
     * @var string
     */
    static protected $popupHtmlWrapper = '';

    /**
     * @var Presenter
     */
    protected $presenter;

    /**
     * @var SeoHandler
     */
    protected $seo;

    /**
     * @var WidgetParser
     */
    protected $parser;

    /**
     * skin class name
     *
     * @var string
     */
    protected $skinName;

    /**
     * skin output id
     *
     * @var string
     */
    protected $id;

    /**
     * The array of view data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $type = Presenter::RENDER_ALL;

    /**
     * Create a new Renderer instance.
     *
     * @param Presenter    $presenter presenter
     * @param SeoHandler   $seo       seo handler
     * @param WidgetParser $parser    widget parser
     */
    public function __construct(Presenter $presenter, SeoHandler $seo, WidgetParser $parser)
    {
        $this->presenter = $presenter;
        $this->seo = $seo;
        $this->parser = $parser;
    }

    /**
     * set common html wrapper
     *
     * @param string $viewName view name
     * @return void
     */
    public static function setCommonHtmlWrapper($viewName)
    {
        self::$commonHtmlWrapper = $viewName;
    }

    /**
     * set popup html wrapper
     *
     * @param string $viewName view name
     * @return void
     */
    public static function setPopupHtmlWrapper($viewName)
    {
        self::$popupHtmlWrapper = $viewName;
    }

    /**
     * Illuminate\Http\Request::initializeFormats() 에서 정의된 formats 에서 하나의 format
     *
     * @return string
     */
    public static function format()
    {
        return 'html';
    }

    /**
     * get presenter
     *
     * @return Presenter
     */
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * set presenter data to html renderer
     *
     * @return $this
     */
    public function setData()
    {
        $this->data = $this->presenter->getData();
        return $this;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $this->setData();

        $this->seo->import($this->data);

        $viewFactory = $this->presenter->getViewFactory();

        $skinView = $this->renderSkin();

        // return only content(Skin)
        if ($this->presenter->getRenderType() == Presenter::RENDER_CONTENT) {
            return $skinView;
        }

        // return popup type
        if ($this->presenter->getRenderType() == Presenter::RENDER_POPUP) {
            $baseTheme = $viewFactory->make(self::$popupHtmlWrapper);
            $baseTheme->content = $skinView;

            return $baseTheme->render();
        }

        $baseTheme = $viewFactory->make(self::$commonHtmlWrapper);
        $viewContent = $this->parser->parseXml($this->renderTheme($skinView)->render());
        $baseTheme->content = $viewContent;

        return $baseTheme->render();
    }

    /**
     * render skin
     *
     * @return \Illuminate\View\View
     */
    public function renderSkin()
    {
        $request = $this->presenter->getRequest();
        if ($request instanceof Request) {
            $isMobile = $request->isMobile();
        } else {
            $isMobile = false;
        }
        $instanceConfig = $this->presenter->getInstanceConfig();
        $skinHandler = $this->presenter->getSkinHandler();
        $viewFactory = $this->presenter->getViewFactory();

        $instanceId = $instanceConfig->getInstanceId();

        $skinTargetId = $this->presenter->getSkinTargetId();
        $id = $this->presenter->getId();

        $skinView = null;

        if ($skinTargetId != null && is_string($skinTargetId)) {
            if ($this->presenter->getIsSettings() && $skinTargetId !== 'error') {
                $skin = $skinHandler->getAssignedSettings($skinTargetId);
            } else {
                $skin = $skinHandler->getAssigned([$skinTargetId, $instanceId], $isMobile ? 'mobile' : 'desktop');
            }
            if ($skin === null) {
                throw new NotFoundSkinException(['name' => $skinTargetId]);
            }
            $skinView = $skin->setView($id)->setData($this->data)->render();
        } else {
            $skinView = $viewFactory->make($id, $this->data);
        }

        return $skinView;
    }

    /**
     * render theme
     *
     * @param \Illuminate\View\View $skinView skin view
     * @return \Illuminate\View\View
     */
    public function renderTheme($skinView)
    {
        $themeView = $skinView;

        $themeHandler = $this->presenter->getThemeHandler();

        // get instance theme
        /** @var ThemeEntityInterface $theme */
        $theme = $themeHandler->getSelectedTheme();

        // get site default theme
        if ($theme === null) {
            $themeHandler->selectSiteTheme();
            $theme = $themeHandler->getSelectedTheme();
        }

        if ($theme !== null) {
            // apply theme
            $themeView = $theme->render();
            $themeView->content = $skinView;
        }

        return $themeView;
    }
}
