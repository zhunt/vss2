<?php
class VssPageMeta extends AppModel {

    var $name = 'VssPageMeta';
    var $validate = array(
            'url' => array('notempty'),
            'page_title' => array('notempty')
    );

    /*
     * Get the meta model for the current page ($this->here from AppController).
     * from: http://jamienay.com/2009/06/cascading-dynamic-meta-tags-and-page-titles-in-cakephp-12/
     */
    function __findCurrentPage($options = array()) {

        if (!isset($options['url'])) {
            return NULL;
        }

        $url = rtrim($options['url'], '/');

        /*
         * First we try to find a complete match for the URL. If we can find it, or if
         * we're at the root of the site, return the results.
         */
        $meta = $this->find('first', array('conditions' => array('url' => $url)));
        if (!empty($meta) || $url == '/') {
            return $meta;
        }

        /*
         * We didn't find a match (or we're not in the root), so now we explode the URL
         * into its parts (separated by /), and look for a match. In other words, we cascade
         * down the URL until the root in order to find a meta entry.
         */
        $urlParts = explode("/", trim($url, "/"));
        krsort($urlParts);

        foreach ((array)$urlParts as $part) {
            $url = str_replace('/'.$part, '', $url);
            if ($url) {
                $meta = $this->find('first', array('conditions' => array('url' => $url)));
                if (!empty($meta)) {
                    return $meta;
                }
            }
        }

        /*
         * Still no matching meta, so now we just return the metas for the root.
         */
        $meta = $this->find('first', array('conditions' => array('url' => '/')));
        return $meta;
    }

}
?>