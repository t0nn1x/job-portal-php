<div class="container">
  <h2>Create Job Listing</h2>
  <form action="PATH_TO_SUBMISSION_SCRIPT" method="POST">
    <h3>Job Info:</h3>
    <div class="form-group">
      <label for="jobTitle">Job Title</label>
      <input type="text" class="form-control" id="jobTitle" name="jobTitle" required>
    </div>
    <div class="form-group">
      <label for="jobCategory">Job Category</label>
      <input type="text" class="form-control" id="jobCategory" name="jobCategory" required>
    </div>
    <div class="form-group">
      <label for="description">Job Description</label>
      <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
    </div>
    <div class="form-group">
      <label for="annualSalary">Annual Salary</label>
      <input type="text" class="form-control" id="annualSalary" name="annualSalary" required>
    </div>
    <div class="form-group">
      <label for="requirements">Requirements</label>
      <textarea class="form-control" id="requirements" name="requirements" rows="5" required></textarea>
    </div>
    <div class="form-group">
      <label for="benefits">Benefits</label>
      <textarea class="form-control" id="benefits" name="benefits" rows="5" required></textarea>
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
      <label for="state">State</label>
      <input type="text" class="form-control" id="state" name="state" required>
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
</div>