<?php loadPartial('head') ?>

<?php loadPartial('navbar') ?>

<div class="container">
    <div style="text-align: center;">
        <p>
        <h2>Update Job Listing</h2>
        </p>
    </div>
    <?php if (isset($_SESSION['success_message'])) : ?>
        <div class="message bg-green-100 my-3"
             style="color: green; background-color: #d4edda; border-color: #c3e6cb; padding: 10px; border: 1px solid transparent; border-radius: 0.25rem;">
            <?= $_SESSION['success_message'] ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <form action="/listings/<?= $listing->id ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
        <h3>Job Info:</h3>
        <?php if (isset($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
                <div class="message bg-red-100 my-3"
                     style="color: red; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border: 1px solid transparent; border-radius: 0.25rem;">
                    <?= $error ?>
                </div>
            <?php endforeach ?>
        <?php endif; ?>
        <div class="form-group">
            <label for="jobTitle">Job Title</label>
            <input type="text" value="<?= $listing->title ?>" class="form-control" id="jobTitle" name="jobTitle"
                   required>
        </div>
        <div class="form-group">
            <label for="image">Listing Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="employmentType">Employment Type</label>
            <select class="form-control" id="employmentType" name="employmentType" required>
                <option value="remote" <?= $listing->employment_type == 'remote' ? 'selected' : '' ?>>Remote</option>
                <option value="full-time" <?= $listing->employment_type == 'full-time' ? 'selected' : '' ?>>Full Time
                </option>
                <option value="part-time" <?= $listing->employment_type == 'part-time' ? 'selected' : '' ?>>Part Time
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for="jobCategory">Tags</label>
            <input type="text" value="<?= $listing->tags ?>" class="form-control" id="tags" name="tags" required>
        </div>
        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea class="form-control" id="description" name="description" required
                      style="height: 150px;"><?= htmlspecialchars($listing->description) ?></textarea>
        </div>
        <div class="form-group">
            <label for="annualSalary">Annual Salary</label>
            <input value="<?= $listing->salary ?>" type="text" class="form-control" id="annualSalary"
                   name="annualSalary" required>
        </div>
        <div class="form-group">
            <label for="requirements">Requirements</label>
            <textarea class="form-control" id="requirements" name="requirements" required
                      style="height: 150px;"><?= htmlspecialchars($listing->description) ?></textarea>
        </div>
        <div class="form-group">
            <label for="benefits">Benefits</label>
            <textarea class="form-control" id="benefits" name="benefits" required
                      style="height: 150px;"><?= htmlspecialchars($listing->benefits) ?></textarea>
        </div>

        <h3>Company Info & Location:</h3>
        <div class="form-group">
            <label for="companyName">Company Name</label>
            <input type="text" value="<?= $listing->company ?>" class="form-control" id="companyName" name="companyName"
                   required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" value="<?= $listing->address ?>" class="form-control" id="address" name="address"
                   required>
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" value="<?= $listing->city ?>" class="form-control" id="city" name="city" required>
        </div>
        <div class="form-group">
            <label for="state">Country</label>
            <input type="text" value="<?= $listing->country ?>" class="form-control" id="country" name="country"
                   required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" value="<?= $listing->phone ?>" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" value="<?= $listing->email ?>" class="form-control" id="email" name="email" required>
        </div>
        <p></p>

        <button type="submit" class="btn btn-primary">Submit</button>
        <!-- button for cancel -->
        <a href="/listings/<?= $listing->id ?>" class="btn btn-danger">Cancel</a>

    </form>
</div>


<?php loadPartial('footer') ?>
