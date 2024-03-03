<?php 

namespace App\Controllers;

use Framework\Database;
use Framework\Session;

class FavouriteController {
  protected $db;

  public function __construct() {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }

  public function toggle() {
    $userId = Session::get('user')['id'];
    $listingId = $_POST['listing_id'];

    // Check if already favourited
    $exists = $this->db->query('SELECT 1 FROM user_favourites WHERE user_id = :user_id AND listing_id = :listing_id', ['user_id' => $userId, 'listing_id' => $listingId])->fetchColumn();

    if ($exists) {
      // Remove from favourites
      $this->db->query('DELETE FROM user_favourites WHERE user_id = :user_id AND listing_id = :listing_id', ['user_id' => $userId, 'listing_id' => $listingId]);
    } else {
      // Add to favourites
      $this->db->query('INSERT INTO user_favourites (user_id, listing_id) VALUES (:user_id, :listing_id)', ['user_id' => $userId, 'listing_id' => $listingId]);
    }

    // Since this is an AJAX request, you might return a JSON response
    echo json_encode(['success' => true]);
    exit;
  }

  public function add() {
    $userId = Session::get('user')['id'];
    $listingId = $_POST['listing_id'];

    if ($this->addToFavourites($userId, $listingId)) {
      Session::setFlashMessage('success_message', 'Listing added to favourites successfully');
    } else {
      Session::setFlashMessage('error_message', 'Failed to add listing to favourites');
    }

    redirect('/listings');
  }

  private function addToFavourites($userId, $listingId) {
    try {
      $sql = 'INSERT INTO user_favourites (user_id, listing_id) VALUES (:user_id, :listing_id)';
      $this->db->query($sql, ['user_id' => $userId, 'listing_id' => $listingId]);
      return true;
    } catch (\Exception $e) {
      // Log the error or handle it as appropriate
      return false;
    }
  }

  public function remove() {
    $userId = Session::get('user')['id'];
    $listingId = $_POST['listing_id'];

    if ($this->removeFromFavourites($userId, $listingId)) {
      Session::setFlashMessage('success_message', 'Listing removed from favourites successfully');
    } else {
      Session::setFlashMessage('error_message', 'Failed to remove listing from favourites');
    }

    redirect('/listings');
  }

  private function removeFromFavourites($userId, $listingId) {
    try {
      $sql = 'DELETE FROM user_favourites WHERE user_id = :user_id AND listing_id = :listing_id';
      $this->db->query($sql, ['user_id' => $userId, 'listing_id' => $listingId]);
      return true;
    } catch (\Exception $e) {
      // Log the error or handle it as appropriate
      return false;
    }
  }
}
