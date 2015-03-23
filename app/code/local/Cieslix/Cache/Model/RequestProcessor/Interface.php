<?php

/**
 * Interface Cieslix_Cache_Model_RequestProcessor_Interface
 */
interface Cieslix_Cache_Model_RequestProcessor_Interface
{
    /**
     * request processor main method, if it returns not empty string there will be no more requests
     *
     * @see Mage_Core_Model_App::run
     * if ($this->_cache->processRequest()) {
     *     $this->getResponse()->sendResponse();
     * }
     * @see Mage_Core_Model_Cache::processRequest
     *
     * @param string $content
     * @return string
     */
    public function extractContent($content);
}
