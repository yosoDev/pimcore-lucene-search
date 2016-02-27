<?php

namespace LuceneSearch\Plugin;

use LuceneSearch\Model\Configuration;

class Install {

    private $configFile = NULL;

    public function __construct() {

        $this->configFile = LUCENESEARCH_CONFIGURATION_FILE;

    }

    public function installConfigFile() {

        Configuration::set("frontend.index", 'website/var/search/frontend/index/');
        Configuration::set("frontend.ignoreLanguage", TRUE);
        Configuration::set("frontend.fuzzySearch", TRUE);
        Configuration::set("frontend.enabled", FALSE);
        Configuration::set("frontend.urls", '');
        Configuration::set("frontend.validLinkRegexes", '');
        Configuration::set("frontend.invalidLinkRegexesEditable", '');
        Configuration::set("frontend.invalidLinkRegexes", '@.*\.(js|JS|gif|GIF|jpg|JPG|png|PNG|ico|ICO|eps|jpeg|JPEG|bmp|BMP|css|CSS|sit|wmf|zip|ppt|mpg|xls|gz|rpm|tgz|mov|MOV|exe|mp3|MP3|kmz|gpx|kml|swf|SWF)$@');
        Configuration::set("frontend.categories", array());
        Configuration::set("frontend.ownHostOnly", FALSE);
        Configuration::set("frontend.crawler.maxThreads", 20);
        Configuration::set("frontend.crawler.maxLinkDepth", 15);
        Configuration::set("frontend.crawler.contentStartIndicator", FALSE);
        Configuration::set("frontend.crawler.contentEndIndicator", FALSE);
        Configuration::set("frontend.crawler.forceStart", FALSE);
        Configuration::set("frontend.crawler.running", FALSE);
        Configuration::set("frontend.crawler.started", FALSE);
        Configuration::set("frontend.crawler.finished", FALSE);
        Configuration::set("frontend.crawler.forceStop", FALSE);
        Configuration::set("frontend.crawler.forceStopInitiated", FALSE);

        return TRUE;
    }

    public function createDirectories() {

        //create folder for search in website
        if( !is_dir( (PIMCORE_WEBSITE_PATH . "/var/search" ) ) )
        {
            mkdir(PIMCORE_WEBSITE_PATH . "/var/search", 0755, true);
        }

        $index = PIMCORE_DOCUMENT_ROOT . "/" . Configuration::get("frontend.index");

        if (!empty($index) and !is_dir($index))
        {
            mkdir($index, 0755, true);
            chmod($index, 0755);
        }

        return TRUE;

    }

    public function createRedirect() {

        //add redirect for sitemap.xml
        $redirect = new \Pimcore\Model\Redirect();
        $redirect->setValues(array("source" => "/\/sitemap.xml/", "target" => "/plugin/LuceneSearch/frontend/sitemap", "statusCode" => 301, "priority" => 10));
        $redirect->save();

        return TRUE;
    }

    /**
     * Remove CoreShop Config
     */
    public function removeConfig()
    {
        $configFile = \Pimcore\Config::locateConfigFile('lucenesearch_configurations');

        if (is_file($configFile  . '.php')) {
            rename($configFile  . '.php', $configFile  . '.BACKUP');
        }
    }

}