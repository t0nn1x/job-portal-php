<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;

class ApplicationController {
  protected $db;

  public function __construct() {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }

  public function store() {
    // Extract and sanitize input
    $listingId = $_POST['listing_id'];
    $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8');
    $portfolioWebsite = htmlspecialchars($_POST['portfolio_website'] ?? '', ENT_QUOTES, 'UTF-8');
    $coverLetter = htmlspecialchars($_POST['coverletter'] ?? '', ENT_QUOTES, 'UTF-8');

    // Check if the resume is uploaded
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
      $resume = $this->uploadResume($_FILES['resume']);
    } else {
      $resume = ''; // Handle the case where no resume is uploaded
    }

    $sql = "INSERT INTO applications (listing_id, name, email, portfolio_website, resume, cover_letter) VALUES (:listing_id, :name, :email, :portfolio_website, :resume, :cover_letter)";
    $params = [
      'listing_id' => $listingId,
      'name' => $name,
      'email' => $email,
      'portfolio_website' => $portfolioWebsite,
      'resume' => $resume,
      'cover_letter' => $coverLetter
    ];

    error_log(print_r($params, true));

    $this->db->query($sql, $params);

    // Redirect or display a success message
    Session::setFlashMessage('application_success', 'Application submitted successfully.');
    redirect('/listings/' . $listingId);
  }


  private function uploadResume($file) {
    if ($file['error'] === UPLOAD_ERR_OK) {
      $uploadPath = basePath('public/uploads/resumes/');
      if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
      }
      $fileName = uniqid() . '-' . basename($file['name']);
      $destination = $uploadPath . $fileName;

      if (move_uploaded_file($file['tmp_name'], $destination)) {
        return 'uploads/resumes/' . $fileName;
      }
    }
    return ''; // Return an empty string or handle the error accordingly
  }

}
