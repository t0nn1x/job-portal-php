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
      'tags', 'description', 'annualSalary',
      'requirements', 'benefits', 'companyName', 'address',
      'city', 'country', 'phone', 'email'
    ];

    $newListingData = array_intersect_key($_POST, array_flip($allowedFields));

    $newListingData['user_id'] = 1;

    $newListingData = array_map('sanitize', $newListingData);

    $requiredFields = [
      'jobTitle', 'description', 'email', 'country', 'city', 'salary'
    ];

    $errors = [];

    foreach ($requiredFields as $field) {
      if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
        $errors[$field] = ucfirst($field) . ' is required';
      };
    }

    if (!empty($errors)) {
      // Reload view with errors 
      loadView('listings/create', [
        'errors' => $errors,
        'listing' => $newListingData
      ]);
    } else {
      // Prepare the insert query with placeholders for the actual values
      $sql = 'INSERT INTO listings (
      user_id, title, description, salary, tags,
      company, address, city, country, phone, email,
      requirements, benefits, employment_type
    ) VALUES (
      :user_id, :title, :description, :salary, :tags,
      :company, :address, :city, :country, :phone, :email,
      :requirements, :benefits, :employment_type
    )';

      // Prepare an array to bind the actual values to the placeholders
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

      // Execute the query with the bindings
      $this->db->query($sql, $bindings);

      redirect('/listings');
    }
  }
}
