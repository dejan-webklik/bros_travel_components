<?php
defined('_JEXEC') or die;

$item = $this->item;

if (!$item) {
    echo "<p>Hotel details not available.</p>";
    return;
}
?>

<div class="container mt-4">
    <h2><?php echo htmlspecialchars($item['name']); ?></h2>
    <p><strong>Rating:</strong> <?php echo $item['rating']; ?>★</p>
    <p><strong>Address:</strong> <?php echo $item['address']; ?></p>
    <p><?php echo $item['description']; ?></p>

    <?php if (!empty($item['images'])): ?>
        <div class="row">
            <?php foreach ($item['images'] as $img): ?>
                <div class="col-md-3 mb-3">
                    <img src="https://testservices.bros-travel.com/images/properties/<?php echo $item['propertyid']; ?>/<?php echo $img['thumb_filename']; ?>" class="img-fluid" alt="">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
