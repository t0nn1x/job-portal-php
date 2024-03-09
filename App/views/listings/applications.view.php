<?php loadPartial('head') ?>
<?php loadPartial('navbar') ?>

<div class="container-xxl py-5">
    <div class="container">
        <h2 class="mb-4">All Applications</h2>
        <?php foreach ($applications as $application) : ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($application->name) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($application->email) ?></h6>
                    <p><strong>Applied to:</strong> <?= htmlspecialchars($application->listing_title) ?></p>
                    <p>Portfolio: <a href="<?= htmlspecialchars($application->portfolio_website) ?>" target="_blank"><?= htmlspecialchars($application->portfolio_website) ?></a></p>
                    <p>Resume: <a href="<?= htmlspecialchars($application->resume) ?>" target="_blank">View Resume</a></p>
                    <p class="card-text">Cover Letter: <?= nl2br(htmlspecialchars($application->cover_letter)) ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="pagination flex items-center justify-center mt-8">
            <?php if ($currentPage > 1) : ?>
                <a href="/listings/applications?page=<?= $currentPage - 1 ?>" class="text-gray-500 hover:text-gray-700 mr-2">&laquo; Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="/listings/applications?page=<?= $i ?>" class="<?= $i == $currentPage ? 'bg-green-500 text-white' : 'text-gray-500 hover:text-gray-700' ?> px-4 py-2 mx-1 rounded"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages) : ?>
                <a href="/listings/applications?page=<?= $currentPage + 1 ?>" class="text-gray-500 hover:text-gray-700 ml-2">Next &raquo;</a>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php loadPartial('footer') ?>
