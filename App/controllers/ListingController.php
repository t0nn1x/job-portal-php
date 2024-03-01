<?php

namespace App\Controllers;

use Framework\Authorization;
use Framework\Database;
use Framework\Session;
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
    $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC')->fetchAll();

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
      // $_SESSION['success_message'] = 'Listing created successfully';
      Session::setFlashMessage('success_message', 'Listing created successfully');
      
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

    $newListingData['user_id'] = Session::get('user')['id'];

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

    $success_message = null;
    if (isset($_SESSION['success_message'])) {
      $success_message = $_SESSION['success_message'];
      unset($_SESSION['success_message']);
    }

    loadView('listings/show', ['listing' => $listing, 'success_message' => $success_message]);
  }

  /**
   * Delete a specific listing
   *
   * @param int $id
   * @return void
   */
  public function destroy($id) {
    $userId = Session::get('user')['id'];

    // Check if the listing exists and belongs to the user
    if (!Authorization::isOwner($userId, $id)) {
      Session::setFlashMessage('error_message', 'You are not authorized to delete this listing or the listing does not exist');
      http_response_code(403); // Forbidden
      exit;
    }
    // Perform the delete operation and set flash message
    $deleted = $this->db->query('DELETE FROM listings WHERE id = :id AND user_id = :user_id', ['id' => $id, 'user_id' => $userId]);

    if ($deleted) {
      Session::setFlashMessage('success_message', 'Listing deleted successfully');
      http_response_code(204); // No Content
      exit;
    } else {

      Session::setFlashMessage('error_message', 'Error during deleting a listing');
      http_response_code(500); // Internal Server Error
      exit;
    }
  }

  /**
   * Show the listing edit form
   *
   * @param int $id
   * @return void
   */
  public function edit($id) {
    $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', ['id' => $id])->fetch();

    if (!$listing) {
      ErrorController::notFound('Listing not found.');
      return;
    }

    loadView('listings/edit', ['listing' => $listing]);
  }

  /**
   * Update a specific listing
   *
   * @param int $id
   * @return void
   */
  public function update($id) {
    $listingData = $this->getNewListingData();

    $errors = $this->validateListingData($listingData);

    if (!empty($errors)) {
      $this->showEditViewWithErrors($errors, $listingData, $id);
    } else {
      $this->updateListingData($listingData, $id);
      Session::setFlashMessage('success_message', 'Listing updated successfully');
      redirect('/listings/' . $id);
    }
  }

  /**
   * Show the edit view with errors
   *
   * @param array $errors
   * @param array $listingData
   * @param int $id
   * @return void
   */
  private function showEditViewWithErrors($errors, $listingData, $id) {
    $listingData['id'] = $id;
    loadView('listings/edit', [
      'errors' => $errors,
      'listing' => (object) $listingData
    ]);
  }

  /**
   * Update the listing data in the database
   *
   * @param array $listingData
   * @param int $id
   * @return void
   */
  private function updateListingData($listingData, $id) {
    $sql = 'UPDATE listings SET
    title = :title, description = :description, salary = :salary, tags = :tags,
    company = :company, address = :address, city = :city, country = :country, phone = :phone, email = :email,
    requirements = :requirements, benefits = :benefits, employment_type = :employment_type
    WHERE id = :id';

    $bindings = [
      'id' => $id,
      'title' => $listingData['jobTitle'],
      'description' => $listingData['description'],
      'salary' => $listingData['annualSalary'],
      'tags' => $listingData['tags'],
      'company' => $listingData['companyName'],
      'address' => $listingData['address'],
      'city' => $listingData['city'],
      'country' => $listingData['country'],
      'phone' => $listingData['phone'],
      'email' => $listingData['email'],
      'requirements' => $listingData['requirements'],
      'benefits' => $listingData['benefits'],
      'employment_type' => $listingData['employmentType']
    ];

    $this->db->query($sql, $bindings);
  }
}
