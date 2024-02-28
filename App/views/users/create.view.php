<?php loadPartial('head') ?>

<?php loadPartial('navbar') ?>

<div class="flex items-center min-h-screen bg-green-100">
  <div class="container mx-auto">
    <div class="max-w-md mx-auto my-10 bg-white p-5 rounded-md shadow-sm">
      <div class="text-center">
        <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">Register</h1>
        <?= loadPartial('errors', [
          'errors' => $errors ?? []
        ]) ?>
        <p class="text-gray-400 dark:text-gray-400">Fill up the form below.</p>
      </div>
      <div class="m-7">
        <form method="POST" action="/auth/register">
          <div class="mb-6">
            <label for="name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400"">Full Name</label>
            <input type=" text" name="name" id="name" placeholder=" John Doe" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-green-100 focus:border-green-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-green-900 dark:focus:border-green-500" />
          </div>
          <div class="mb-6">
            <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Email Address</label>
            <input type="email" name="email" id="email" placeholder="you@company.com" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-green-100 focus:border-green-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-green-900 dark:focus:border-green-500" />
          </div>
          <div class="mb-6">
            <label for="city " class="block mb-2 text-sm text-gray-600 dark:text-gray-400">City</label>
            <input type="text" name="city" id="city" placeholder="Your City" value="<?= isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '' ?>" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-green-100 focus:border-green-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-green-900 dark:focus:border-green-500" />
          </div>
          <div class="mb-6">
            <label for="country" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Country</label>
            <input type="text" name="country" id="state" placeholder="Your Country" value="<?= isset($_POST['country']) ? htmlspecialchars($_POST['country']) : '' ?>" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-green-100 focus:border-green-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-green-900 dark:focus:border-green-500" />
          </div>
          <div class="mb-6">
            <label for="password" class="text-sm text-gray-600 dark:text-gray-400">Password</label>
            <input type="password" name="password" id="password" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-green-100 focus:border-green-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-green-900 dark:focus:border-green-500" />
          </div>
          <div class="mb-6">
            <label for="password_confirmation" class="text-sm text-gray-600 dark:text-gray-400">Confirm Password</label>
            <input type="password" name="password_confirmation" id="confirm_password" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-green-100 focus:border-green-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-green-900 dark:focus:border-green-500" />
          </div>
          <div class="mb-6">
            <button type="submit" class="w-full px-3 py-4 text-white bg-green-500 rounded-md focus:bg-green-600 focus:outline-none">Sign Up</button>
          </div>
          <p class="text-sm text-center text-gray-400">Already have an account? <a href="/auth/login" class="text-green-400 focus:outline-none focus:underline focus:text-green-500 dark:focus:border-green-800">Sign in</a>.</p>
        </form>
      </div>
    </div>
  </div>
</div>

<?php loadPartial('footer') ?>
