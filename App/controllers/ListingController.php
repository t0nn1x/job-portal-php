<?php

namespace App\Controllers;

use Framework\Database;

class ListingController {
  protected $db;

  public function __construct() {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }

  /**
   * Show all listings
   *
   * @return void
   */
  public function index() {
    $listings = $this->db->query('SELECT * FROM listings')->fetchAll();

    loadView('listings/index', [
      'listings' => $listings
    ]);
  }

  /**
   * Create a new listing
   *
   * @return void
   */
  public function create() {
    loadView('listings/create');
  }

  /**
   * Store a new listing
   *
   * @return void
   */
  public function show($id = null) {

    $params = ['id' => $id];

    $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

    if (!$listing) {
      ErrorController::notFound('Listing not found.');
      return;
    }

    loadView('listings/show', ['listing' => $listing]);
  }
}
