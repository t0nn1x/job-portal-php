<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use PDO;

class HomeController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Show the latest lisings
     *
     * @return void
     */
    public function index()
    {
        $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC LIMIT 5')->fetchAll();

        $userId = Session::get('user')['id'] ?? null;
        $userFavourites = [];
        if ($userId) {
            $userFavourites = $this->db->query('SELECT listing_id FROM user_favourites WHERE user_id = :user_id', ['user_id' => $userId])->fetchAll(PDO::FETCH_COLUMN);
        }

        loadView('home', [
            'listings' => $listings,
            'userFavourites' => $userFavourites,
        ]);
    }

    public function about()
    {
        loadView('about');
    }
}
