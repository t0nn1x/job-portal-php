<div class="container">
  <h2>Create Job Listing</h2>
  <form action="/listings" method="POST">
    <h3>Job Info:</h3>
    <?php if (isset($errors)) : ?>
      <?php foreach ($errors as $error) : ?>
        <div class="message bg-red-100 my-3"><?= $error ?></div>
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
      <label for="jobCategory">Job Category</label>
      <input type="text" class="form-control" id="jobCategory" name="jobCategory" required>
    </div>
    <div class="form-group">
      <label for="description">Job Description</label>
      <div id="description" class="form-control" style="height: 150px;"></div>
      <input type="hidden" name="description" id="hiddenDescription">
    </div>
    <div class="form-group">
      <label for="annualSalary">Annual Salary</label>
      <input type="text" class="form-control" id="annualSalary" name="annualSalary" required>
    </div>
    <div class="form-group">
      <label for="requirements">Requirements</label>
      <div id="requirements" class="form-control" style="height: 150px;"></div>
      <input type="hidden" name="requirements" id="hiddenRequirements">
    </div>
    <div class="form-group">
      <label for="benefits">Benefits</label>
      <div id="benefits" class="form-control" style="height: 150px;"></div>
      <input type="hidden" name="benefits" id="hiddenBenefits">
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

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
  <script>
    var quillDescription = new Quill('#description', {
      theme: 'snow'
    });

    var quillRequirements = new Quill('#requirements', {
      theme: 'snow'
    });

    var quillBenefits = new Quill('#benefits', {
      theme: 'snow'
    });

    document.querySelector('form').onsubmit = function() {
      document.getElementById('hiddenDescription').value = quillDescription.root.innerHTML;
      document.getElementById('hiddenRequirements').value = quillRequirements.root.innerHTML;
      document.getElementById('hiddenBenefits').value = quillBenefits.root.innerHTML;
    };
  </script>
</div>
