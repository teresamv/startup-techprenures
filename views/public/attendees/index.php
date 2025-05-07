<section class="section-box-2">
    <div class="box-head-single cus-top-box none-bg">
        <div class="container">
            <h4>There are <?= $total_attendes ?> techpreneurs here for you!</h4>
            <div class="row mt-15">
                <div class="col-lg-7 col-md-9">

                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-box mt-60">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9 col-md-12 col-sm-12 col-12 float-right">
                <div class="content-page">
                    <div class="box-filters-job mt-0 mb-10">
                        <div class="row">
                            <div class="col-lg-7">
                                <span class="text-small">
                                    Showing <strong>
                                        <?php
                                        $current_page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
                                        $per_page = 12;
                                        $start_index = ($current_page - 1) * $per_page + 1;
                                        $end_index = min($current_page * $per_page, $total_attendes);
                                        echo $start_index . '-' . $end_index;
                                        ?>
                                    </strong>
                                    of <strong><?= $total_attendes ?></strong> techpreneurs
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if ($attendes) {
                            foreach ($attendes as $key => $value) { ?>
                                <div class="col-lg-4 col-md-6">
                                    <a href="<?= base_url('techpreneurs/details/' . $value->id . '-' . url_title($value->name, '-', TRUE)); ?>">
                                        <div class="card-grid-2 hover-up">
                                            <div class="text-center card-grid-2-image-rd">
                                                <?php if ($value->profile_image_download_path) { ?>
                                                    <div class="img-band-round"><img alt="attendes" src="<?= base_url($value->profile_image_download_path). '?v=' . time(); ?>" /></div>
                                                <?php } else { ?>
                                                    <div class="img-band-round"><img alt="attendes" src="<?= base_url('assets/frontend_assets/imgs/avatar/no_profile.png') ?>" /></div>
                                                <?php } ?>
                                            </div>
                                            <div class="card-block-info">
                                                <div class="card-profile">
                                                    <strong><?= $value->name ?></strong>
                                                    <span class="text-sm"><?= $value->position ?></span>
                                                </div>
                                                <div class="employers-info d-flex align-items-center justify-content-center mt-15">
                                                    <span class="d-flex align-items-center"><i class="fi-rr-marker mr-5 ml-0"></i> <?= $value->country ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php }
                        } else { ?>
                            <div class="col-md-12">
                                <h5><strong>No attendes found...</strong></h5>
                            </div>
                        <?php } ?>
                        <div class="pagination-links">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php echo $this->pagination->create_links(); ?>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                <form method="get" class="right-form-band" action="<?php echo current_url(); ?>">
                    <div class="sidebar-shadow none-shadow mb-30">
                        <div class="sidebar-filters">
                            <div class="filter-block mb-15">
                                <h5 class="medium-heading mb-15">Search</h5>
                                <div class="form-group">
                                    <div class="box-search-job">
                                        <input type="text" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="input-search-job" placeholder="Search hear..">
                                    </div>
                                </div>
                            </div>
                            <div class="filter-block mb-15">
                                <h5 class="medium-heading mb-15">Type</h5>
                                <div class="form-group">
                                    <select class="form-control form-icons select-active select-file-cus" data-placeholder="Select Type" name="type[]" multiple>
                                        <?php if ($types) {
                                            foreach ($types as $key => $type) {
                                                $selected = in_array($type, $_GET['type'] ? $_GET['type'] : []) ? 'selected' : '';
                                        ?>
                                                <option value="<?= $type ?>" <?= $selected ?>><?= $type ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter-block mb-15">
                                <h5 class="medium-heading mb-15">Country</h5>
                                <div class="form-group">
                                    <select class="form-control form-icons select-active select-file-cus" data-placeholder="Select Country" name="country[]" multiple>
                                        <option value="">Select Country</option>
                                        <?php if ($countries) {
                                            foreach ($countries as $key => $country) {
                                                $selected = in_array($country, $_GET['country'] ? $_GET['country'] : []) ? 'selected' : '';
                                        ?>
                                                <option value="<?= $country ?>" <?= $selected ?>><?= $country ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter-block mb-15">
                                <h5 class="medium-heading mb-15">Sector</h5>
                                <div class="form-group">
                                    <select class="form-control form-icons select-active select-file-cus" data-placeholder="Select Sector" name="sector[]" multiple>
                                        <option value="">Select Sector</option>
                                        <?php if ($sectors) {
                                            foreach ($sectors as $key => $sector) {
                                                $selected = in_array($sector, $_GET['sector'] ? $_GET['sector'] : []) ? 'selected' : ''; ?>
                                                <option value="<?= $sector ?>" <?= $selected ?>><?= $sector ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="buttons-filter">
                                <button class="btn btn-default" type="submit">Apply filter</button>
                                <?php if (!empty($_GET['search']) || !empty($_GET['country']) || !empty($_GET['type']) || !empty($_GET['sector'])) { ?>
                                    <a href="<?php echo base_url('attendees'); ?>" class="btn btn-secondary">Clear Filter</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>