<!-- Search Start -->
<div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
    <div class="container">
        <form action="/listings/search" method="GET">
            <div class="row g-2">
                <div class="col-md-10">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="keyword" class="form-control border-0" placeholder="Keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>" />
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="category" class="form-control border-0" placeholder="Category" value="<?= isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '' ?>" />
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="location" class="form-control border-0" placeholder="Location" value="<?= isset($_GET['location']) ? htmlspecialchars($_GET['location']) : '' ?>" />
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-dark border-0 w-100">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Search End -->