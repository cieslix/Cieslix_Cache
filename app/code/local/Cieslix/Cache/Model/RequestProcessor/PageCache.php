<?php

/**
 * Class Cieslix_Cache_Model_RequestProcessor_PageCache
 */
class Cieslix_Cache_Model_RequestProcessor_PageCache implements Cieslix_Cache_Model_RequestProcessor_Interface
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
}
