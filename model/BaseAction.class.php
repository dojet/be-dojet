<?php
/**
 * Action基类
 *
 * @author liyan
 * @version 2012.12.24
 */
abstract class BaseAction {

    protected $tplData;
    private $webService;

    function __construct(WebService $webService) {
        $this->webService = $webService;
        $this->tplData = array();
    }

    protected function webService() {
        return $this->webService;
    }

    /**
     * 为模板变量赋值
     *
     * @param string $key
     * @param mix $value
     */
    public function assign($key, $value) {
        $this->tplData[$key] = $value;
    }

    /**
     * 渲染模板
     *
     * @param string $template
     */
    protected function display($template) {
        if (Dojet::v('is_debug')) {
            return $this->displayDebug();
        }

        $templateFile = $template;
        DAssert::assert(file_exists($templateFile), 'template not exist. '.$template);

        $collision = extract($this->tplData, EXTR_PREFIX_ALL, 'tpl');

        include($templateFile);
    }

    protected function display404() {
        header('HTTP/1.1 404 Not Found', true);
        exit();
    }

    protected function displayDebug() {
        printa($this->tplData);
    }

    protected function templatePrefix($template) {
        return '';
    }

    protected function displayTemplate($template) {
        $prefix = $this->templatePrefix($template);
        $template = $prefix.$template;
        return $this->display($template);
    }

    abstract public function execute();

}
