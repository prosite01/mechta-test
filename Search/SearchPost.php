<?php

namespace Search;

use Common\DB;
use Common\Log;
use Common\Render;

class SearchPost implements SearchInterface
{
    const array NOT_ALLOWED_FORUM_IDS = [5];

    /**
     * @return void
     */
    public static function doSearch(): void
    {
        if (array_key_exists('searchid', $_REQUEST)) {
            self::showResults();
        } elseif (!empty($_REQUEST['q'])) {
            self::processResult($_REQUEST['q']);
        } else {
            self::renderSearchForm();
        }
    }

    /**
     * @param string $query
     * @return void
     */
    private static function processResult(string $query): void
    {
        $db = new DB();
        $log = new Log(Log::LOG_TYPE_SEARCH_POST);

        $result = $db->query('SELECT * FROM vb_post WHERE text LIKE ?', ['%' . $query . '%']);
        self::renderSearchResults($result);

        $log->save('Search query: ' . $query);
    }

    /**
     * @return void
     */
    private static function showResults(): void
    {
        $db = new DB();

        $searchId = $_REQUEST['searchid'];
        if (is_numeric($searchId)) {
            $result = $db->query('SELECT * FROM vb_searchresult WHERE searchid = ?', [$searchId]);
            self::renderSearchResults($result);
        }
    }

    /**
     * @param array $result
     * @return void
     */
    public static function renderSearchResults(array $result): void
    {
        $render = new Render();

        foreach($result as $row){
            if (array_key_exists('forumid', $row) && !in_array($row['forumid'], self::NOT_ALLOWED_FORUM_IDS)) {
                $render->render_search_result($row);
            }
        }
    }

    /**
     * @return void
     */
    public static function renderSearchForm(): void
    {
        echo "<h2>Search in forum</h2><form><input name='q'></form>";
    }
}
