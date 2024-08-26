<?php

namespace Common;

class Render
{
    /**
     * @param $row
     * @return void
     */
    public function render_search_result($row): void
    {
        echo "<div>";
        echo "<p>" . htmlspecialchars($row['result']) . "</p>";
        echo "</div>";
    }
}
