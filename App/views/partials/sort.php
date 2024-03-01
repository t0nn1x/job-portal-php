<ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
    <li class="nav-item">
        <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 <?= ($_GET['sort'] ?? 'Featured') === 'Featured' ? 'active' : '' ?>" href="/listings?sort=Featured">
            <h6 class="mt-n1 mb-0">Featured</h6>
        </a>
    </li>
    <li class="nav-item">
        <a class="d-flex align-items-center text-start mx-3 pb-3 <?= ($_GET['sort'] ?? 'Featured') === 'Full Time' ? 'active' : '' ?>" href="/listings?sort=Full Time">
            <h6 class="mt-n1 mb-0">Full Time</h6>
        </a>
    </li>
    <li class="nav-item">
        <a class="d-flex align-items-center text-start mx-3 pb-3 <?= ($_GET['sort'] ?? 'Featured') === 'Part Time' ? 'active' : '' ?>" href="/listings?sort=Part Time">
            <h6 class="mt-n1 mb-0">Part Time</h6>
        </a>
    </li>
    <li class="nav-item">
        <a class="d-flex align-items-center text-start mx-3 me-0 pb-3 <?= ($_GET['sort'] ?? 'Featured') === 'Remote' ? 'active' : '' ?>" href="/listings?sort=Remote">
            <h6 class="mt-n1 mb-0">Remote</h6>
        </a>
    </li>
</ul>