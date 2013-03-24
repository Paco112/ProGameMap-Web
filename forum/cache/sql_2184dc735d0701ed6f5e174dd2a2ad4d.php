<?php
if (!defined('IN_PHPBB')) exit;

/* SELECT m.*, u.user_colour, g.group_colour, g.group_type FROM (phpbb_moderator_cache m) LEFT JOIN phpbb_users u ON (m.user_id = u.user_id) LEFT JOIN phpbb_groups g ON (m.group_id = g.group_id) WHERE m.display_on_index = 1 AND m.forum_id IN (3, 4) */

$expired = (time() > 1261312111) ? true : false;
if ($expired) { return; }

$this->sql_rowset[$query_id] = array();

?>