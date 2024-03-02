<div class="container-xxl bg-white p-0">
  <!-- Spinner Start -->
  <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <!-- Spinner End -->

  <?php

  use Framework\Session; ?>

  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="/" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
      <h1 class="m-0 text-primary">JobEntry</h1>
    </a>
    <?php if (Session::has('user')) : ?>
      <div class="nav-item nav-item nav-link active">
        <span style="font-family: 'Pacifico', cursive; font-size: 1.2rem;">
          Welcome, <?= Session::get('user')['name'] ?>
        </span>
      </div>
    <?php endif; ?>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav ms-auto p-4 p-lg-0">
        <a href="/" class="nav-item nav-link">Home</a>
        <a href="/about" class="nav-item nav-link">About</a>
        <a href="/listings" class="nav-item nav-link">Jobs</a>

        <?php if (Session::has('user')) : ?>
          <form action="/auth/logout" method="POST">
            <button type="submit" class="nav-item nav-link active" style="color: red; font-weight: bold;">Logout</button>
          </form>
        <?php else : ?>
          <a href="/auth/login" class="nav-item nav-link">Login</a>
          <a href="/auth/register" class="nav-item nav-link">Register</a>
        <?php endif; ?>
      </div>
      <?php if (Session::has('user')) : ?>
        <a href="/listings/create" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">Post A Job<i class="fa fa-arrow-right ms-3"></i></a>
      <?php endif; ?>
    </div>
  </nav>
  <!-- Navbar End -->
