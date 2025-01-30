<form class="filterForm mb-4 p-3 border rounded shadow-sm" method="GET" action="<?= route('events') ?>">
    <div class="row g-3">
        <!-- Title -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Title</label>
            <input type="text" class="form-control" name="title" value="<?= $title ?>" placeholder="Search By Title">
        </div>

        <!-- Location -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Location</label>
            <select class="form-select" name="location">
                <option value="">Select Location</option>
                <?php foreach ($locations as $location) : ?>
                    <option <?= $location['id'] == $location_id ? 'selected' : '' ?> value="<?= $location['id'] ?>"><?= $location['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Date From -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Date From</label>
            <input type="date" class="form-control" name="date_from" value="<?= $date_from ?>" name="date_from">
        </div>

        <!-- Date To -->
        <div class="col-md-3">
            <label class="form-label fw-semibold">Date To</label>
            <input type="date" class="form-control" name="date_to" value="<?= $date_to ?>" name="date_to">
        </div>

        <!-- Submit Button -->
        <div class="col-12 d-flex gap-2 text-end">
            <a href="<?= route('events') ?>" class="btn btn-secondary btn-lg w-100" id="resetFilter">Reset</a>
            <button type="submit" class="btn btn-primary btn-lg w-100">Filter</button>
        </div>
    </div>
</form>