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
  public function store() {
    $newListingData = $this->getNewListingData();

    $errors = $this->validateListingData($newListingData);

    if (!empty($errors)) {
      $this->showCreateViewWithErrors($errors, $newListingData);
    } else {
      $this->insertListingData($newListingData);
      redirect('/listings');
    }
  }

  /**
   * Get the new listing data from the request
   *
   * @return array
   */
  private function getNewListingData() {
    $allowedFields = [
      'jobTitle', 'employmentType',
      'tags', 'description', 'annualSalary',
      'requirements', 'benefits', 'companyName', 'address',
      'city', 'country', 'phone', 'email'
    ];

    $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

    $newListingData['user_id'] = 1;

    $newListingData = array_map('sanitize', $newListingData);

    return $newListingData;
  }

  /**
   * Validate the new listing data
   *
   * @param array $newListingData
   * @return array
   */
  private function validateListingData($newListingData) {
    $requiredFields = [
      'jobTitle', 'description', 'email', 'country', 'city', 'annualSalary'
    ];

    $errors = [];

    foreach ($requiredFields as $field) {
      if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
        $errors[$field] = ucfirst($field) . ' is required';
      };
    }

    return $errors;
  }

  /**
   * Show the create view with errors
   *
   * @param array $errors
   * @param array $listingData
   * @return void
   */
  private function showCreateViewWithErrors($errors, $listingData) {
    loadView('listings/create', [
      'errors' => $errors,
      'listing' => $listingData
    ]);
  }

  /**
   * Insert the new listing data into the database
   *
   * @param array $newListingData
   * @return void
   */
  private function insertListingData($newListingData) {
    $sql = 'INSERT INTO listings (
      user_id, title, description, salary, tags,
      company, address, city, country, phone, email,
      requirements, benefits, employment_type
    ) VALUES (
      :user_id, :title, :description, :salary, :tags,
      :company, :address, :city, :country, :phone, :email,
      :requirements, :benefits, :employment_type
    )';

    $bindings = [
      'user_id' => $newListingData['user_id'],
      'title' => $newListingData['jobTitle'],
      'description' => $newListingData['description'],
      'salary' => $newListingData['annualSalary'],
      'tags' => $newListingData['tags'],
      'company' => $newListingData['companyName'],
      'address' => $newListingData['address'],
      'city' => $newListingData['city'],
      'country' => $newListingData['country'],
      'phone' => $newListingData['phone'],
      'email' => $newListingData['email'],
      'requirements' => $newListingData['requirements'],
      'benefits' => $newListingData['benefits'],
      'employment_type' => $newListingData['employmentType']
    ];

    $this->db->query($sql, $bindings);
  }

  /**
   * Show a specific listing
   *
   * @param int|null $id
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
  