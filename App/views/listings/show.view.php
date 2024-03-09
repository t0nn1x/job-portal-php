<?php loadPartial('head') ?>

<?php loadPartial('navbar') ?>

<?php loadPartial('message') ?>

<!-- Job Detail Start -->
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
  <div class="container">
    <div class="row gy-5 gx-4">
      <div class="col-lg-8">
        <div class="d-flex align-items-center mb-5">
          <img class="flex-shrink-0 img-fluid border rounded" src="<?= $listing->image ?>" alt="" style="width: 80px; height: 80px;">
          <div class="text-start ps-4">
            <h3 class="mb-3"><?= $listing->title ?></h3>
            <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i><?= $listing->city ?>, <?= $listing->country ?></span>
            <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?= $listing->employment_type ?></span>
            <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i><?= formatSalary($listing->salary) ?></span>
          </div>
        </div>

        <div class="mb-5">
          <h4 class="mb-3">Job description</h4>
          <p><?= $listing->description ?></p>
          <h4 class="mb-3">Requirements</h4>
          <p><?= $listing->requirements ?></p>
          <h4 class="mb-3">Benefits</h4>
          <p><?= $listing->benefits ?></p>
        </div>
        <div class="">
          <h4 class="mb-4">Apply For The Job</h4>
          <form action="/apply" method="post" enctype="multipart/form-data">
            <input type="hidden" name="listing_id" value="<?= $listing->id ?>">
            <div class="row g-3">
              <div class="col-12 col-sm-6">
                <input type="text" class="form-control" name="name" placeholder="Your Name">
              </div>
              <div class="col-12 col-sm-6">
                <input type="email" class="form-control" name="email" placeholder="Your Email">
              </div>
              <div class="col-12 col-sm-6">
                <input type="text" class="form-control" name="portfolio_website" placeholder="Portfolio Website">
              </div>
              <div class="col-12 col-sm-6">
                <input type="file" class="form-control bg-white" name="resume">
              </div>
              <div class="col-12">
                <textarea class="form-control" name="coverletter" rows="5" placeholder="Cover Letter"></textarea>
              </div>
              <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">Apply Now</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
          <h4 class="mb-4">Job Summary</h4>
          <?php if (Framework\Authorization::isOwner(Framework\Session::get('user')['id'], $listing->id)) : ?>
            <p>
              <button onclick="deleteListing(<?= $listing->id ?>)" class="btn btn-danger">Delete</button>
              <a href="/listings/<?= $listing->id ?>/edit " class="btn btn-primary">Edit</a>
            </p>
          <?php endif; ?>

          <p><i class="fa fa-angle-right text-primary me-2"></i>Published On: <?= $listing->created_at ?></p>
          <p><i class="fa fa-angle-right text-primary me-2"></i>Vacancy: <?= $listing->id ?> position</p>
          <p><i class="fa fa-angle-right text-primary me-2"></i>Job Nature: <?= $listing->employment_type ?></p>
          <p><i class="fa fa-angle-right text-primary me-2"></i>Salary: <?= formatSalary($listing->salary) ?></p>
          <p><i class="fa fa-angle-right text-primary me-2"></i>Adress: <?= $listing->address ?></p>
        </div>
        <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
          <h4 class="mb-4">Company email:</h4>
          <p><i class="fa fa-angle-right text-primary me-2"></i><?= $listing->email ?></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function deleteListing(listingId) {
    if (confirm('Are you sure you want to delete this listing?')) {
      fetch('/listings/' + listingId, {
        method: 'DELETE'
      }).then(response => {
        if (response.status === 204) { // No Content
          window.location.href = '/listings?status=deleted';
        } else {
          window.location.href = '/listings/' + listingId;
        }
      }).catch(error => {
        console.error('Error:', error);
        window.location.href = '/listings/' + listingId;
      });
    }
  }
</script>

<!-- Job Detail End -->


<?php loadPartial('footer') ?>
