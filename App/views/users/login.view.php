<?php loadPartial('head') ?>

<?php loadPartial('navbar') ?>

<div class="flex items-center min-h-screen bg-green-100">
  <div class="container mx-auto">
    <div class="max-w-md mx-auto my-10 bg-white p-5 rounded-md shadow-sm">
      <div class="text-center">
        <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">Login</h1>
        <p class="text-gray-400 dark:text-gray-400">Fill up the form below.</p>
      </div>
      <div class="m-7">
        <form action="">
          <div class="mb-6">
            <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Email Address</label>
            <input type="email" name="email" id="email" placeholder="you@company.com" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-green-100 focus:border-green-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-green-900 dark:focus:border-green-500" />
          </div>
          <div class="mb-6">
            <label for="password" class="text-sm text-gray-600 dark:text-gray-400">Password</label>
            <input type="password" name="password" id="password" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-green-100 focus:border-green-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-green-900 dark:focus:border-green-500" />
          </div>
          <div class="mb-6">
            <button type="submit" class="w-full px-3 py-4 text-white bg-green-500 rounded-md focus:bg-green-600 focus:outline-none">Login</button>
          </div>
          <p class="text-sm text-center text-gray-400">Don't have an account? <a href="/auth/register" class="text-green-400 focus:outline-none focus:underline focus:text-green-500 dark:focus:border-green-800">Sign up</a>.</p>
        </form>
      </div>
    </div>
  </div>
</div>

<?php loadPartial('footer') ?>
