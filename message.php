<?php
if (isset($_SESSION['message'])):
?>
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <strong>Info!</strong> <?= $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    unset($_SESSION['message']);
endif;
?>
