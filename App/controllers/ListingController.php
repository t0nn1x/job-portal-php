<?php

namespace App\Controllers;

use Framework\Authorization;
use Framework\Database;
use Framework\Session;
use Framework\Validation;
use PDO;

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
    $perPage = 10;
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $currentPage = max($currentPage, 1);
    $offset = ($currentPage - 1) * $perPage;

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'Featured';
    $bindings = ['perPage' => $perPage, 'offset' => $offset];

    switch ($sort) {
      case 'Full Time':
      case 'Part Time':
      case 'Remote':
        $totalCount = $this->db->query('SELECT COUNT(*) FROM listings WHERE employment_type = :sort', ['sort' => $sort])->fetchColumn();
        $listings = $this->db->query("SELECT * FROM listings WHERE employment_type = :sort ORDER BY created_at DESC LIMIT $perPage OFFSET $offset", ['sort' => $sort])->fetchAll();
        break;
      case 'Featured':
      default:
        $totalCount = $this->db->query('SELECT COUNT(*) FROM listings')->fetchColumn();
        $listings = $this->db->query("SELECT * FROM listings ORDER BY created_at DESC LIMIT $perPage OFFSET $offset")->fetchAll();
        break;
    }

    $totalPages = ceil($totalCount / $perPage);

    $userId = Session::get('user')['id'] ?? null;
    $userFavourites = [];
    if ($userId) {
      $userFavourites = $this->db->query('SELECT listing_id FROM user_favourites WHERE user_id = :user_id', ['user_id' => $userId])->fetchAll(PDO::FETCH_COLUMN);
    }

    loadView('listings/index', [
      'listings' => $listings,
      'currentPage' => $currentPage,
      'totalPages' => $totalPages,
      'userFavourites' => $userFavourites,
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
    $newListingData = []; // Initialize the variable

    try {
      $newListingData = $this->getNewListingData();

      $errors = $this->validateListingData($newListingData);

      if (!empty($errors)) {
        $this->showCreateViewWithErrors($errors, $newListingData);
      } else {
        $this->insertListingData($newListingData);
        Session::setFlashMessage('success_message', 'Listing created successfully');
        redirect('/listings');
      }
    } catch (\Exception $e) {
      $errors['image'] = $e->getMessage();
      $this->showCreateViewWithErrors($errors, $newListingData);
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

    // Handle image upload and compression
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
      $newListingData['image'] = $this->uploadAndCompressImage($_FILES['image']);
    } else {
      $newListingData['image'] = 'uploads/images/default.jpg'; // Set default image path
    }

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
      requirements, benefits, employment_type, image
    ) VALUES (
      :user_id, :title, :description, :salary, :tags,
      :company, :address, :city, :country, :phone, :email,
      :requirements, :benefits, :employment_type, :image
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
      'employment_type' => $newListingData['employmentType'],
      'image' => $newListingData['image'] // Add this line
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
    $userId = Session::get('user')['id'];

    $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', ['id' => $id])->fetch();

    if (!$listing) {
      ErrorController::notFound('Listing not found.');
      return;
    }

    if (!Authorization::isOwner($userId, $id)) {
      Session::setFlashMessage('error_message', 'You are not authorized to update this listing or the listing does not exist');
      return redirect('/listings/' . $id);
      exit;
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
    $userId = Session::get('user')['id'];

    // Check if the listing exists and belongs to the user
    if (!Authorization::isOwner($userId, $id)) {
      Session::setFlashMessage('error_message', 'You are not authorized to update this listing or the listing does not exist');
      return redirect('/listings/' . $id);
      exit;
    }

    // Fetch the current listing data
    $listingData = $this->db->query('SELECT * FROM listings WHERE id = :id', ['id' => $id])->fetch();

    try {
      $newListingData = $this->getNewListingData();

      $errors = $this->validateListingData($newListingData);

      if (!empty($errors)) {
        $this->showEditViewWithErrors($errors, $newListingData, $id);
      } else {
        $this->updateListingData($newListingData, $id);
        Session::setFlashMessage('success_message', 'Listing updated successfully');
        redirect('/listings/' . $id);
      }
    } catch (\Exception $e) {
      $errors['image'] = $e->getMessage();
      // Convert the stdClass object to an array
      $listingDataArray = get_object_vars($listingData);
      // Use the current listing data in the catch block
      $this->showEditViewWithErrors($errors, $listingDataArray, $id);
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
    requirements = :requirements, benefits = :benefits, employment_type = :employment_type, image = :image
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
      'employment_type' => $listingData['employmentType'],
      'image' => $listingData['image']
    ];

    $this->db->query($sql, $bindings);
  }

  /** 
   * Search listings by keyword/category/location
   * 
   * @return void
   */
  public function search() {
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';
    $location = isset($_GET['location']) ? trim($_GET['location']) : '';

    $query = "SELECT * FROM listings WHERE (title LIKE :keyword
    OR description LIKE :keyword OR tags LIKE :keyword OR company 
    LIKE :keyword or salary LIKE :keyword) 
    AND (city LIKE :location OR country LIKE :location)
    AND (category LIKE :category)";

    $params = [
      'keyword' => "%{$keyword}%",
      'category' => "%{$category}%",
      'location' => "%{$location}%"
    ];

    $listings = $this->db->query($query, $params)->fetchAll();

    loadView('/listings/index', [
      'listings' => $listings,
      'keyword' => $keyword,
      'location' => $location
    ]);
  }

  /**
   * Compress and upload the listing image
   *
   * @param array $file The uploaded file
   * @return string The path to the saved image
   */
  private function uploadAndCompressImage($file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
      $tmpName = $file['tmp_name'];
      $fileName = uniqid() . '.jpg'; // Generate a unique name for the file
      $destinationPath = basePath('public/uploads/images/') . $fileName;

      // Get the image type
      $imageInfo = getimagesize($tmpName);
      $imageType = $imageInfo[2];

      // Compress and move the image
      switch ($imageType) {
        case IMAGETYPE_JPEG:
          $source = imagecreatefromjpeg($tmpName);
          imagejpeg($source, $destinationPath, 75); // 75 is the quality setting
          break;
        case IMAGETYPE_PNG:
          $source = imagecreatefrompng($tmpName);
          imagesavealpha($source, true); // save alphablending setting (important)
          imagepng($source, $destinationPath, 9); // 9 is the compression level (0 no compression, 9 maximum)
          break;
        case IMAGETYPE_GIF:
          $source = imagecreatefromgif($tmpName);
          imagegif($source, $destinationPath);
          break;
        default:
          throw new \Exception('Invalid image type');
      }

      return 'uploads/images/' . $fileName;
    }

    // Return a default image if upload failed or not provided
    return 'uploads/images/default.jpg';
  }

  public function viewAllApplications() {
    $userId = Session::get('user')['id'];

    // Fetch the listings IDs owned by the user
    $listings = $this->db->query('SELECT id FROM listings WHERE user_id = :user_id', ['user_id' => $userId])->fetchAll(PDO::FETCH_COLUMN);

    if (empty($listings)) {
      Session::setFlashMessage('error_message', 'You do not own any listings.');
      return redirect('/listings');
    }

    $parameters = array_values($listings);
    $placeholders = implode(',', array_fill(0, count($listings), '?'));

    // Determine the number of applications per page
    $perPage = 10;

    // Calculate the total number of pages
    $totalCount = $this->db->query("SELECT COUNT(*) FROM applications WHERE listing_id IN ($placeholders)", $parameters)->fetchColumn();
    $totalPages = ceil($totalCount / $perPage);

    // Get the current page number from the query string
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $currentPage = max($currentPage, 1);

    // Calculate the offset for the SQL query
    $offset = ($currentPage - 1) * $perPage;

    $applications = $this->db->query(
      "SELECT applications.*, listings.title AS listing_title
    FROM applications
    LEFT JOIN listings ON applications.listing_id = listings.id
    WHERE listing_id IN ($placeholders)
    ORDER BY applications.created_at DESC
    LIMIT $perPage OFFSET $offset",
      $parameters
    )->fetchAll();

    // Display the applications to the employer
    loadView('listings/applications', [
      'applications' => $applications,
      'currentPage' => $currentPage,
      'totalPages' => $totalPages,
    ]);
  }

  /**
   * Check if the user has any listings
   *
   * @param int $userId
   * @return bool
   */
  public function userHasListings($userId) {
    $count = $this->db->query("SELECT COUNT(*) FROM listings WHERE user_id = :user_id", ['user_id' => $userId])->fetchColumn();
    return $count > 0;
  }
}
