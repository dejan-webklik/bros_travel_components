<?php
defined('_JEXEC') or die;

$items = $this->items;
if (!$items) {
    echo "<p>No properties found.</p>";
    return;
}
?>
<form method="get" action="">
    <input type="hidden" name="option" value="com_brostravel" />
    <input type="hidden" name="view" value="hotels" />
    <label for="locationid">Filtriraj po lokaciji:</label>
    <select name="locationid" id="locationid">
        <option value="">-- Sve lokacije --</option>
        <?php foreach ($this->locations as $loc): ?>
            <option value="<?php echo $loc['locationid']; ?>" <?php echo ($loc['locationid'] == $this->selectedLocation) ? 'selected' : ''; ?>>
                <?php echo $loc['name'] . ' (' . $loc['region'] . ')'; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filtriraj</button>
</form>
<br>

<div class="row row-cols-1 row-cols-md-3 g-4">
<?php foreach ($items as $property): ?>
    <div class="col">
        <div class="card h-100">
            <a href="index.php?option=com_brostravel&view=hotel&propertyid=<?php echo $property['propertyid']; ?>">
                <img src="https://testservices.bros-travel.com/images/properties/<?php echo $property['propertyid']; ?>/<?php echo $property['image']; ?>" class="card-img-top" alt="">
            </a>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="index.php?option=com_brostravel&view=hotel&propertyid=<?php echo $property['propertyid']; ?>">
                        <?php echo htmlspecialchars($property['name']); ?>
                    </a>
                </h5>
                <p class="card-text">
                    <?php echo $property['type']; ?> — <?php echo $property['rating']; ?>★<br>
                    <?php echo $property['description']; ?>
                </p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>
