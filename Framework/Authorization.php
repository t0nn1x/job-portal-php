<?php

namespace Framework;

use Framework\Database;

class Authorization
{
    public static function isOwner($userId, $listingId)
    {
        $db = new Database(require basePath('config/db.php'));
        $listing = $db->query('SELECT * FROM listings WHERE id = :id AND user_id = :user_id', ['id' => $listingId, 'user_id' => $userId])->fetch();

        return $listing ? true : false;
    }
}
