<?php

class Cieslix_Cache_Model_Observer
{
    /**
     * if page is cached it will be returned, no further request will be processed
     * this is specified via app/etc/local.cache.xml
     *
     * @param string $content
     * @return string
     */
    public function extractContent($content)
    {
        /** @var Mage_Core_Controller_Request_Http $request */
        $request = Mage::app()->getRequest();
        if ($request->isGet()) {
            $uri = $request->getRequestUri();
            $cache = (string)Mage::app()->loadCache(md5($uri));
            $content .= $cache;
        }
        return $content;
    }

    /**
     * save html after page is generated only if request is GET and requested page is in modules Mage_Cms and Mage_Catalog
     *
     * @param Varien_Event_Observer $observer
     */
    public function controllerFrontSendResponseAfter(Varien_Event_Observer $observer)
    {
        /** @var Mage_Core_Controller_Varien_Front $front */
        $front = $observer->getFront();
        /** @var Mage_Core_Controller_Request_Http $request */
        $request = $front->getRequest();

        if ($this->_validate($request)) {
            $uri = $request->getOriginalRequest()->getRequestUri();
            $responseHtml = $front->getResponse()->getBody();
            Mage::app()->saveCache($responseHtml, md5($uri), array(Mage_Core_Model_App::CACHE_TAG));
        }
    }

    /**
     * @param Mage_Core_Controller_Request_Http $request
     * @return boolean
     */
    protected function _validate(Mage_Core_Controller_Request_Http $request)
    {
        $moduleName = $request->getControllerModule();
        return $request->isGet() && ($moduleName === 'Mage_Cms' || $moduleName === 'Mage_Catalog');
    }
}
