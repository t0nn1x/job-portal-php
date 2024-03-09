<?php loadPartial('head') ?>

<?php loadPartial('navbar') ?>

<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-green-600">Create Job Listing</h2>
    </div>
    <form action="/listings" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <h3 class="block text-green-500 text-lg font-semibold mb-2">Job Info:</h3>
            <?= loadPartial('errors', ['errors' => $errors ?? []]) ?>
            <div class="mb-4">
                <label for="jobTitle" class="block text-gray-700 text-sm font-bold mb-2">Job Title</label>
                <input type="text" id="jobTitle" name="jobTitle" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
            </div>
            <div class="mb-4">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Listing Image</label>
                <input type="file" id="image" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
            </div>
            <div class="mb-4">
                <label for="employmentType" class="block text-gray-700 text-sm font-bold mb-2">Employment Type</label>
                <select id="employmentType" name="employmentType" required class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
                    <option value="Remote">Remote</option>
                    <option value="Full time">Full Time</option>
                    <option value="Part time">Part Time</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Tags</label>
                <input type="text" id="tags" name="tags" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Job Description</label>
                <textarea id="description" name="description" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500" style="height: 150px;"></textarea>
            </div>
            <div class="mb-4">
                <label for="annualSalary" class="block text-gray-700 text-sm font-bold mb-2">Annual Salary</label>
                <input type="text" id="annualSalary" name="annualSalary" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
            </div>
            <div class="mb-4">
                <label for="requirements" class="block text-gray-700 text-sm font-bold mb-2">Requirements</label>
                <textarea id="requirements" name="requirements" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500" style="height: 150px;"></textarea>
            </div>
            <div class="mb-4">
                <label for="benefits" class="block text-gray-700 text-sm font-bold mb-2">Benefits</label>
                <textarea id="benefits" name="benefits" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500" style="height: 150px;"></textarea>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="block text-green-500 text-lg font-semibold mb-2">Company Info & Location:</h3>
            <div class="mb-4">
                <label for="companyName" class="block text-gray-700 text-sm font-bold mb-2">Company Name</label>
                <input type="text" id="companyName" name="companyName" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
            </div>
            <div class="mb-4">
                <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                <input type="text" id="address" name="address" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
            </div>
            <div class="mb-4">
                <label for="city" class="block text-gray-700 text-sm font-bold mb-2">City</label>
                <input type="text" id="city" name="city" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
            </div>
            <div class="mb-4">
                <label for="country" class="block text-gray-700 text-sm font-bold mb-2">Country</label>
                <input type="text" id="country" name="country" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone</label>
                <input type="tel" id="phone" name="phone" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-green-500">
            </div>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Submit
            </button>
            <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="window.history.back();">
                Cancel
            </button>
        </div>
    </form>
</div>

<?php loadPartial('footer') ?>
