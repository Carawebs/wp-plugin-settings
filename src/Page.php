<?php
namespace Carawebs\Settings;

/**
* Control the registration of new settings in in the {$wpdb->prefix}_options table.
*/
abstract class Page
{
        // See: https://github.com/NateWr/simple-admin-pages/blob/master/classes/AdminPage.class.php #111
        // ---------------------------------------------------------------------
    public function setPageArgs(array $args)
    {
        $this->config = $args;
        $this->pageArguments = $args['page'];
        $this->optionGroup = $args['setting']['option_group'];
        $this->setTabs();
        return $this;
    }

    public function tabCheck($tab)
    {
        if(isset($_GET['tab']) && $_GET['tab'] === preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($tab))){
            return true;
        } else {
            return false;
        }
    }

    public function setTabs()
    {
        $tabs = [];
        foreach ($this->config['sections'] as $section) {
            $value = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($section['tab']) );
            $tabs[$section['tab']] = $value;
        }
        $this->tabs = array_unique($tabs);
        error_log(__FILE__. ", Line: ". __LINE__ . ":\n" . json_encode($this->tabs));
    }

    public function tabLinks($currentTab)
    {
        ob_start();
        foreach ($this->tabs as $name => $tabQueryString) {
            $link
            ?>
            <a href="?page=<?= $this->pageArguments['unique_page_slug']; ?>&tab=<?= $tabQueryString; ?>" class="nav-tab<?= $this->activeTabClass($tabQueryString, $currentTab); ?>"><?= $name; ?></a>
            <?php
        }

        echo ob_get_clean();
    }

    public function activeTabClass($tabQueryString, $currentTab)
    {
        if( ! isset($currentTab)) return;

        if ($tabQueryString === $currentTab) {
            return ' nav-tab-active';
        } else {
            return;
        }

    }

}
