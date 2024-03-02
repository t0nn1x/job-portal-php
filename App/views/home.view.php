<?php loadPartial('head') ?>

<?php loadPartial('navbar') ?>

<?php loadPartial('carousel') ?>

<?php loadPartial('search') ?>

<?php loadPartial('about') ?>

<!-- Jobs Start -->
<div class="container-xxl py-5">
  <div class="container">
    <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Job Listing</h1>
    <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
      <div class="tab-content">
        <div id="tab-1" class="tab-pane fade show p-0 active">
          <?php foreach ($listings as $listing) : ?>
            <div class="job-item p-4 mb-4">
              <div class="row g-4">
                <div class="col-sm-12 col-md-8 d-flex align-items-center">
                  <img class="flex-shrink-0 img-fluid border rounded" src="<?= $listing->image ?>" alt="" style="width: 80px; height: 80px;">
                  <div class="text-start ps-4">
                    <h5 class="mb-3"><?= $listing->title ?></h5>
                    <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i><?= $listing->city . ', ' . $listing->country ?></span>
                    <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?= $listing->employment_type ?></span>
                    <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i><?= formatSalary($listing->salary) ?></span>
                  </div>
                </div>
                <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center">
                  <div class="d-flex mb-3">
                    <form action="/favourites/add" method="POST" style="display: inline;">
                      <input type="hidden" name="listing_id" value="<?= $listing->id ?>">
                      <button type="submit" class="btn btn-light btn-square me-3"><i class="far fa-heart text-primary"></i></button>
                    </form>
                    <a class="btn btn-primary" href="/listings/<?= $listing->id ?>">Apply Now</a>
                  </div>
                  <small class="text-truncate"><i class="far fa-calendar-alt text-primary me-2"></i>Posted: <?= $listing->created_at ?></small>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <a class="btn btn-primary py-3 px-5" href="/listings">Browse More Jobs</a>
      </div>
    </div>
  </div>
</div>
<!-- Jobs End -->

<?php loadPartial('testimonial') ?>

<?php loadPartial('footer') ?>
