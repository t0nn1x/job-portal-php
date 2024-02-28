<?php loadPartial('head') ?>

<?php loadPartial('navbar') ?>

<div class="container">
  <div style="text-align: center;">
    <p>
    <h2>Create Job Listing</h2>
    </p>
  </div>
  <form action="/listings" method="POST">
    <h3>Job Info:</h3>
    <?php if (isset($errors)) : ?>
      <?php foreach ($errors as $error) : ?>
        <div class="message bg-red-100 my-3" style="color: red; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border: 1px solid transparent; border-radius: 0.25rem;">
          <?= $error ?>
        </div>
      <?php endforeach ?>
    <?php endif; ?>
    <div class="form-group">
      <label for="jobTitle">Job Title</label>
      <input type="text" class="form-control" id="jobTitle" name="jobTitle" required>
    </div>
    <div class="form-group">
      <label for="employmentType">Employment Type</label>
      <select class="form-control" id="employmentType" name="employmentType" required>
        <option value="remote">Remote</option>
        <option value="full-time">Full Time</option>
        <option value="part-time">Part Time</option>
      </select>
    </div>
    <div class="form-group">
      <label for="jobCategory">Tags</label>
      <input type="text" class="form-control" id="tags" name="tags" required>
    </div>
    <div class="form-group">
      <label for="description">Job Description</label>
      <textarea class="form-control" id="description" name="description" required style="height: 150px;"></textarea>
    </div>
    <div class="form-group">
      <label for="annualSalary">Annual Salary</label>
      <input type="text" class="form-control" id="annualSalary" name="annualSalary" required>
    </div>
    <div class="form-group">
      <label for="requirements">Requirements</label>
      <textarea class="form-control" id="requirements" name="requirements" required style="height: 150px;"></textarea>
    </div>
    <div class="form-group">
      <label for="benefits">Benefits</label>
      <textarea class="form-control" id="benefits" name="benefits" required style="height: 150px;"></textarea>
    </div>

    <h3>Company Info & Location:</h3>
    <div class="form-group">
      <label for="companyName">Company Name</label>
      <input type="text" class="form-control" id="companyName" name="companyName" required>
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="form-group">
      <label for="city">City</label>
      <input type="text" class="form-control" id="city" name="city" required>
    </div>
    <div class="form-group">
      <label for="state">Country</label>
      <input type="text" class="form-control" id="country" name="country" required>
    </div>
    <div class="form-group">
      <label for="phone">Phone</label>
      <input type="tel" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <p></p>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>



<?php loadPartial('footer') ?>
