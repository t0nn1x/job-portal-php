<?php loadPartial('head') ?>

<?php loadPartial('navbar') ?>

<!-- Error Start -->
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <i class="bi bi-exclamation-triangle display-1 text-primary"></i>
                <h1 class="display-1"><?= $status ?></h1>
                <h1 class="mb-4"><?= $message ?></h1>
                <p class="mb-4"></p>
                <a class="btn btn-primary py-3 px-5" href="/">Go Back To Home</a>
            </div>
        </div>
    </div>
</div>
<!-- Error End -->


<?php loadPartial('footer') ?>
