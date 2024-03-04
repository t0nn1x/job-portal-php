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
        var response = JSON.parse(this.responseText);
        var btn = document.getElementById('favourite-btn-' + listingId);
        if (response.favourited) {
          btn.innerHTML = '<i class="fas fa-heart text-primary"></i>';
          btn.setAttribute('data-favourited', 'true');
        } else {
          btn.innerHTML = '<i class="far fa-heart text-primary"></i>';
          btn.setAttribute('data-favourited', 'false');
        }
      } else {
        console.log('Error toggling favourite');
      }
    };
    xhr.send('listing_id=' + listingId);
  }
</script>
