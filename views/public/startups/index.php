<section class="section-box-2">
    <div class="box-head-single cus-top-box none-bg">
        <div class="container">
            <h4>There are <?= $total_startup ?> startups here for you! </h4>
           <div class="row mt-15">
                <div class="col-lg-12 col-md-9">
                    <?php //if(($attendee_details) &&($attendee_details->startup_id == 0) ): ?>
                 <span class="btn btn-default" style="float:right; cursor:pointer;"><a data-bs-toggle="modal" data-bs-target="#startupModal">Create Startup</a></span>
                 <?php //endif;  ?>
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
                                        $end_index = min($current_page * $per_page, $total_startup);
                                        echo $start_index . '-' . $end_index;
                                        ?>
                                    </strong>
                                    of <strong><?= $total_startup ?></strong> Startups
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if ($startup) {
                        foreach ($startup as $key => $value) { ?>
                            <div class="col-lg-4 col-md-6">
                                <a href="<?=base_url('startups/details/' . $value->id. '-' . url_title($value->name, '-', TRUE));?>">
                                      <div class="card-grid-2 card-employers hover-up wow animate__animated animate__fadeIn">
                                        <div class="text-center card-grid-2-image-rd">
                                            <?php if ($value->logo_src) { ?>
                                                <div class="img-band-sequre"><img alt="startup" style="height: 110px; width: 110px;" src="<?= base_url($value->logo_src) ?>" /></div>
                                            <?php } else {?>
                                                <div class="img-band-sequre"><img alt="startup" style="height: 110px; width: 110px;" src="<?= base_url('assets/frontend_assets/imgs/avatar/no_profile.png') ?>" /></div>
                                            <?php } ?>
                                        </div>
                                    <div class="card-block-info">
                                        <div class="card-profile">
                                            <h5><strong><?=$value->name?></strong></h5>
                                            <span class="text-sm"><?=$value->sector?></span>
                                        </div>
                                        <div class="mt-15">
                                            <div class="text-center align-items-center">
                                                <i class="fi-rr-marker mr-5"></i> <?=$value->country?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            </div>
                    <?php }} else {?>
                        <div class="col-md-12">
                            <h5><strong>No startups found...</strong></h5>
                        </div>
                    <?php }?>
                    <!-- Pagination links -->
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
                                    <select class="form-control form-icons select-active select-file-cus" data-placeholder="Select Type" name="type[]" multiple >
                                        <?php if ($types) {
                                            foreach ($types as $key => $type) { 
                                                $selected = in_array($type, $_GET['type'] ? $_GET['type'] : []) ? 'selected' : '';
                                                 ?>
                                                <option value="<?= $type ?>" <?= $selected ?>><?= $type ?></option>
                                        <?php } } ?>
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
                                        <?php } } ?>
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
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="buttons-filter">
                                <button class="btn btn-default" type="submit">Apply filter </button>
                                <?php if (!empty($_GET['search']) || !empty($_GET['country']) || !empty($_GET['type']) || !empty($_GET['sector'])) { ?>
                                        <a href="<?php echo base_url('startups'); ?>" class="btn btn-secondary">Clear Filter</a>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<div class="modal scrollspy-model create-event-model fade" style="height:fit-content;" id="startupModal" tabindex="-1"  overflow= "auto" aria-labelledby="startupModal" aria-hidden="true" data-backdrop="true">
<div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="startupModalLabel">Create Startup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  
                </button>
            </div>
            <div class="modal-body">
                <form id="addstartupForm" method="post"  enctype="multipart/form-data">
                <input type="hidden" id="" name="id" value="<?php if(isset($attendee_details)) { echo $attendee_details->id; } ?>">
                <div class="profile-edit-content">
                    <div class="form-group-band">
                        <label for="startupimage">Startup Logo</label>
                        <input type="file" class="form-control" id="startupimage" name="startupimage">
                    </div>
                    <div class="form-group-band">
                        <label for="startupTitle">Startup name</label>
                        <input type="text" class="form-control" id="startupTitle" name="title">
                        <div id="titleError" class="error-message" style="color:red;"></div>

                    </div>
                    <div class="form-group-band">
                        <label for="aboutstartup">About startup</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div class="form-group-band">
                        <label for="stage">Stage</label>
                        <select class="form-control select2" id="stage" name="stage" placeholder="Select stage">
                                 <option value="">Select stage</option> 
                                 <option value="Growth">Growth</option> 
                                 <option value="Expansion">Expansion</option> 
                                 <option value="Early">Early</option>
                                 <option value=" Maturity"> Maturity</option>
                                 <option value="Exit">Exit</option>
                          </select>
                    </div>
                    <div class="form-group-band">
                    <label for="country">Country:</label>
                    <select class="form-control select2" id="create_country" name="country">
                        <option value="" disabled selected>Please select country</option>
                        <?php foreach ($country_names as $country) : ?>
                            <option value="<?= htmlspecialchars($country->country); ?>" <?= (isset($startup_details->country) && $startup_details->country == $country->country) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($country->country); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="country-message" class="country-message" style="color:red;"></div>
                    </div>
                    <div class="form-group-band">
                        <label for="sector"> Sector</label>
                        <select class="form-control select2" id="sector" name="sector">
                            <option value="">select sector</option>
                            <?php foreach ($sector_names as $sector): ?>
                                <option value="<?= htmlspecialchars($sector->sector); ?>" 
                                    <?= (isset($startup_details->sector) && $startup_details->sector == $sector->sector) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($sector->sector); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group-band">
                        <label for="booth">Booth</label>
                        <select class="form-control select2" id="booth" name="booth" placeholder="Select booth">
                                 <option value="">Select booth</option> 
                                 <option value="B2C ">B2C </option> 
                                 <option value="B2B ">B2B </option> 
                                 <option value="Marketplace">Marketplace</option>
                                 <option value=" D2C "> D2C </option>
                         </select>
                    </div>
                    <div class="form-group-band">
                        <label for="pitchdeck">Select Pitchdeck document</label>
                        <input type="file" class="form-control" id="pitchdeck_doc" name="pitchdeck">
                    </div>
                    <div class="col-12 mt-3 add-links-band">
                            <span>Social Links</span>

                            <div class="social-link">
                                <img src="<?= base_url('uploads/social_icon/homepage.png'); ?>" alt="home">
                                <input type="hidden" name="social_links[home][name]" value="home">
                                <input type="hidden" name="social_links[home][icon]" value="<?= base_url('uploads/social_icon/homepage.png'); ?>">
                                <input type="text" class="form-control" placeholder="home" name="social_links[home][url]" id="home">
                                <div class="error-message" style="color:red;" id="home-error"></div>
                            </div>

                            <div class="social-link">
                                <img src="<?= base_url('uploads/social_icon/linkedin.png'); ?>" alt="LinkedIn">
                                <input type="hidden" name="social_links[linkedin][name]" value="linkdedin">
                                <input type="hidden" name="social_links[linkedin][icon]" value="<?= base_url('uploads/social_icon/linkedin.png'); ?>">
                                <input type="text" class="form-control" placeholder="LinkedIn" name="social_links[linkedin][url]" id="linkedin_startup">
                                <div class="error-message" style="color:red;" id="linkedin-error"></div>
                            </div>

                            <div class="social-link">
                                <img src="<?= base_url('uploads/social_icon/instagram.png'); ?>" alt="insta">
                                <input type="hidden" name="social_links[instagram][name]" value="instagram">
                                <input type="hidden" name="social_links[instagram][icon]" value="<?= base_url('uploads/social_icon/instagram.png'); ?>">
                                <input type="text" class="form-control" placeholder="Instagram" name="social_links[instagram][url]" id="instagram_startup">
                                <div class="error-message" style="color:red;" id="insta-error"></div>
                            </div>

                            <div class="social-link">
                                <img src="<?= base_url('uploads/social_icon/facebook.png'); ?>" alt="facebook">
                                <input type="hidden" name="social_links[facebook][name]" value="facebook">
                                <input type="hidden" name="social_links[facebook][icon]" value="<?= base_url('uploads/social_icon/facebook.png'); ?>">
                                <input type="text" class="form-control" placeholder="Facebook" name="social_links[facebook][url]" id="facebook_startup">
                                <div class="error-message" style="color:red;" id="facebook-error"></div>
                            </div>
                            <div class="social-link">
                                <img src="<?= base_url('uploads/social_icon/twitter.png'); ?>" alt="twitter">
                                <input type="hidden" name="social_links[twitter][name]" value="twitter">
                                <input type="hidden" name="social_links[twitter][icon]" value="<?= base_url('uploads/social_icon/twitter.png'); ?>">
                                <input type="text" class="form-control" placeholder="Twitter" name="social_links[twitter][url]" id="twitter_startup">
                                <div class="error-message" style="color:red;" id="twitter-error"></div>
                            </div>
                             <div class="buttons-filter startup-border-btn mt-15">
                                 <button type="button"  class="btn btn-default float-right" id="add_start_up">Create Startup</button>                
                              </div>
                        </div>
                    </div>
                 </form>
            </div>
        </div>
    </div>
</div>