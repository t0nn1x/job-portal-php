 <?php if (isset($errors)) : ?>
   <?php foreach ($errors as $error) : ?>
     <div class="message bg-red-100 my-3" style="color: red; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border: 1px solid transparent; border-radius: 0.25rem;">
       <?= $error ?>
     </div>
   <?php endforeach ?>
 <?php endif; ?>
