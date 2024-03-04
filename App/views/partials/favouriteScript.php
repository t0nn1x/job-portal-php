<script>
  function toggleFavourite(listingId) {
    var btn = document.getElementById('favourite-btn-' + listingId);
    var isFavourited = btn.getAttribute('data-favourited') === 'true';

    // Toggle the favourited status visually
    if (isFavourited) {
      btn.innerHTML = '<i class="far fa-heart text-primary"></i>';
    } else {
      btn.innerHTML = '<i class="fas fa-heart text-primary"></i>';
    }
    btn.setAttribute('data-favourited', !isFavourited);

    // Send AJAX request to the server
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/favourites/toggle', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (this.status === 200) {
        // Handle success
        console.log('Favourite toggled successfully');
      } else {
        // Handle error
        console.log('Error toggling favourite');
      }
    };
    xhr.send('listing_id=' + listingId);
  }
</script>
