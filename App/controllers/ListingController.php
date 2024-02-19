<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

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

  /**
   * Store data in db
   *
   * @return void
   */
  public function store() {
    $allowedFields = [
      'jobTitle', 'employmentType',
      'jobCategory', 'description', 'annualSalary',
      'requirements', 'benefits', 'companyName', 'address',
      'city', 'country', 'phone', 'email'
    ];

    $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

    $newListingData['user_id'] = 1;

    $newListingData = array_map('sanitize', $newListingData);

    inspectValueAndDie($newListingData);
  }
}
