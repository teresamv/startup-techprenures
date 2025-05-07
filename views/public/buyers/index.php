<!-- Content -->
<main class="main">
    <section class="section-box-2">
        <div class="box-head-single none-bg">
            <div class="container">
                <h4>There Are <?= $total_buyers ?> international buyers<br />Here For you!</h4>
                <div class="row mt-15 mb-40">
                    <div class="col-lg-7 col-md-9">
                        <span class="text-mutted">Discover your next big customer here.</span>
                    </div>
                    <div class="col-lg-5 col-md-3 text-lg-end text-start">
                        <ul class="breadcrumbs mt-sm-15">
                            <li><a href="#">Home</a></li>
                            <li>Jobs listing</li>
                        </ul>
                    </div>
                </div>
                <div class="box-shadow-bdrd-15 box-filters">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="box-search-job">
                                <form class="form-search-job">
                                    <input type="text" class="input-search-job" placeholder="Buyer Requirement" />
                                </form>
                            </div>
                            <div class="list-tags-job">
                                <a href="#" class="text-normal job-tag">AI Software <span class="remove-tags-job"></span></a>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="d-flex job-fillter">
                                <div class="d-block d-lg-flex">
                                    <div class="dropdown job-type">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownJobType" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" data-bs-display="static"><i class="fi-rr-briefcase"></i>
                                            <span>Full time</span> <i class="fi-rr-angle-small-down"></i></button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownJobType">
                                            <li><a class="dropdown-item active" href="#">Direct Buying</a></li>
                                            <li><a class="dropdown-item" href="#">Tender</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownLocation" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"><i class="fi-rr-marker"></i> <span>New
                                                York, USA</span> <i class="fi-rr-angle-small-down"></i></button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownLocation">
                                            <?php if ($countries) {
                                            foreach ($countries as $key => $country) { 
                                               
                                                 ?>
                                                <li><a class="dropdown-item" href="#"><?= $country ?></a></li>
                                        <?php } } ?>
                                            <!-- <li><a class="dropdown-item active" href="#">USA</a></li>
                                            <li><a class="dropdown-item" href="#">China</a></li>
                                            <li><a class="dropdown-item" href="#">India</a></li> -->
                                        </ul>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownLocation2" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"><i class="fi-rr-dollar"></i> <span>Salary Range</span> <i class="fi-rr-angle-small-down"></i></button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownLocation2">
                                            <li><a class="dropdown-item active" href="#">$100 - $500</a></li>
                                            <li><a class="dropdown-item" href="#">$500 - $1000</a></li>
                                            <li><a class="dropdown-item" href="#">$1000 - $1500</a></li>
                                            <li><a class="dropdown-item" href="#">$1500 - $2000</a></li>
                                            <li><a class="dropdown-item" href="#">Over $2000</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="box-button-find">
                                    <button class="btn btn-default float-right">Find Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
        <section class="section-box mt-80">
            <div class="container">
                <div class="row flex-row-reverse">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-12 float-right">
                        <div class="content-page">
                            <div class="box-filters-job mt-15 mb-10">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <span class="text-small"> Showing <strong>
                                        <?php
                                        $current_page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
                                        $per_page = 10;
                                        $start_index = ($current_page - 1) * $per_page + 1;
                                        $end_index = min($current_page * $per_page, $total_buyers);
                                        echo $start_index . '-' . $end_index;
                                        ?>
                                    of </strong><strong><?= $total_buyers ?> </strong>buyers</span>
                                    </div>
                                    <div class="col-lg-5 text-lg-end mt-sm-15">
                                        <div class="display-flex2">
                                            <span class="text-sortby">Sort by:</span>
                                            <div class="dropdown dropdown-sort">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownSort" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static"><span>Newest Post</span> <i class="fi-rr-angle-small-down"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="dropdownSort">
                                                    <li><a class="dropdown-item active" href="#">Newest Post</a></li>
                                                    <li><a class="dropdown-item" href="#">Oldest Post</a></li>
                                                    <li><a class="dropdown-item" href="#">Rating Post</a></li>
                                                </ul>
                                            </div>
                                            <div class="box-view-type">
                                                <a href="job-grid.html" class="view-type"><img src="assets/imgs/theme/icons/icon-list.svg" alt="jobhub" /></a>
                                                <a href="job-list.html" class="view-type"><img src="assets/imgs/theme/icons/icon-grid.svg" alt="jobhub" /></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="job-list-list mb-15">
                                <div class="list-recent-jobs">
                                   
                                    <?php if ($buyers) {
                        foreach ($buyers as $key => $value) { ?>
                                    <!-- Item job -->
                                    <div class="card-job hover-up wow animate__animated animate__fadeIn">
                                        <div class="card-job-top">
                                            <div class="card-job-top--image">
                                                <figure><img alt="jobhub" src="assets/imgs/page/job/n-digital.png" /></figure>
                                            </div>
                                            <?Php if(!empty($value->attende_details)){?>
                                            <div class="card-job-top--info">
                                                <h6 class="card-job-top--info-heading"><a href="<?=base_url('buyers/details/' . $value->attende_details->id. '-' . url_title($value->attende_details->name, '-', TRUE));?>"><?=$value->attende_details->name;?></a></h6>
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                         <a href="employers-grid.html"><span class="card-job-top--company"><?=$value->attende_details->position;?></span></a>
                                                        <span class="card-job-top--location text-sm"><i class="fi-rr-marker"></i> <?=$value->cCountryName?></span>
                                                        <span class="card-job-top--type-job text-sm"><i class="fi-rr-briefcase"></i> <?=$value->attende_details->industry;?>
                                              </span>
                                                        <!-- <span class="card-job-top--post-time text-sm"><i class="fi-rr-dollar"></i> $500,000 - $1,000,000</span> -->
                                                    </div>
                                                    <div class="col-lg-5 text-lg-end">
                                                        <!-- <span class="card-job-top--price">Corporation</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <?Php }?>
                                        </div>
                                        <div class="card-job-description mt-20">
                                            <?php if(strlen($value->cProfileBio)> 220){
                                                echo substr($value->cProfileBio, 0, 220).'...';
                                            }
                                            else{
                                                echo $value->cProfileBio;
                                            }
                                            ?>
                                        </div>
                                        <div class="card-job-bottom mt-25">
                                            <div class="row">
                                                <?php
                                        if (isset($value->expertise_tag)) {
                                            
                                        
                                        ?>
                                                <div class="col-lg-9 col-sm-8 col-12">
                                                  <?php  foreach ($value->expertise_tag as $expertise) {
                                                // Use htmlspecialchars to avoid XSS attacks
                                                $expertiseName = htmlspecialchars($expertise->expertise);?>
                                            
                                                    <a href="job-grid-2.html" class="btn btn-small background-12 mr-5"><?php echo $expertiseName;?></a>
                                                <?php }?>
                                                    <!-- <a href="job-grid-2.html" class="btn btn-small background-blue-light mr-5">Senior</a>
                                                    <a href="job-grid.html" class="btn btn-small background-6 disc-btn">Full time</a> -->
                                                </div>
                                                <div class="col-lg-3 col-sm-4 col-12 text-lg-end d-lg-block d-none">
                                                    <span><img src="assets/imgs/theme/icons/shield-check.svg" alt="jobhub"></span>
                                                    <span class="ml-5"><img src="assets/imgs/theme/icons/bookmark.svg" alt="jobhub"></span>
                                                </div>
                                                <?Php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            }?>
                                    <!-- End item job -->
                                   
                                </div>
                            </div>
                            <!-- <div class="paginations">
                                <ul class="pager">
                                    <li><a href="#" class="pager-prev"></a></li>
                                    <li><a href="#" class="pager-number">1</a></li>
                                    <li><a href="#" class="pager-number">2</a></li>
                                    <li><a href="#" class="pager-number">3</a></li>
                                    <li><a href="#" class="pager-number">4</a></li>
                                    <li><a href="#" class="pager-number">5</a></li>
                                    <li><a href="#" class="pager-number active">6</a></li>
                                    <li><a href="#" class="pager-number">7</a></li>
                                    <li><a href="#" class="pager-next"></a></li>
                                </ul>
                            </div> -->
                            <!-- div class="pagination-links">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        
                                    </ul>
                                </nav>
                            </div> -->
                            <div class="paginations">
                                <ul class="pager">
                                    <?php echo $this->pagination->create_links(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-12">
                        <div class="sidebar-with-bg">
                            <h5 class="font-semibold mb-10">Set job reminder</h5>
                            <p class="text-body-999">Enter you email address and get job notification.</p>
                            <div class="box-email-reminder">
                                <form>
                                    <div class="form-group mt-15">
                                        <input type="text" class="form-control input-bg-white form-icons" placeholder="Enter email address" />
                                        <i class="fi-rr-envelope"></i>
                                    </div>
                                    <div class="form-group mt-25 mb-5">
                                        <button class="btn btn-default btn-md">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-shadow none-shadow mb-30">
                            <div class="sidebar-filters">
                                <form method="get" class="right-form-band" action="<?php echo current_url(); ?>">
                                <div class="filter-block mb-30">
                                    <h5 class="medium-heading mb-15">Location</h5>
                                    <div class="form-group">
                                        <select class="form-control form-icons select-active select-file-cus" data-placeholder="Location" name="country[]" multiple>
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
                                <div class="filter-block mb-30">
                                    <h5 class="medium-heading mb-15">Industry</h5>
                                    <div class="form-group">
                                        <select class="form-control form-icons select-active select-file-cus" data-placeholder="Industry" name="industry[]" multiple>
                                            <option value="">Select Industry</option>
                                            <?php print_r($industry_names);
                                            foreach ($industry_names as $industry){
                                                $selected = in_array($industry->industry, $_GET['industry'] ? $_GET['industry'] : []) ? 'selected' : ''; ?>
                                            <option value="<?= $industry->industry; ?>" <?= $selected ?>>
                                                <?= $industry->industry; ?>
                                            </option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter-block mb-30">
                                    <h5 class="medium-heading mb-15">Job type</h5>
                                    <div class="form-group">
                                        <ul class="list-checkbox">
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox"> <span class="text-small">Full Time
                                                        Jobs</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">235</span>
                                            </li>
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox" checked="checked"> <span class="text-small">Part Time
                                                        Jobs</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">28</span>
                                            </li>
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox" checked="checked"> <span class="text-small">Remote
                                                        Jobs</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">67</span>
                                            </li>
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox"> <span class="text-small">Freelance</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">92</span>
                                            </li>
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox"> <span class="text-small">Temporary</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">14</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="filter-block mb-30">
                                    <h5 class="medium-heading mb-10">Experience Level</h5>
                                    <div class="form-group">
                                        <ul class="list-checkbox">
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox"> <span class="text-small">Expert</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">76</span>
                                            </li>
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox"> <span class="text-small">Senior</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">89</span>
                                            </li>
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox" checked="checked"> <span class="text-small">Junior</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">54</span>
                                            </li>
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox" checked="checked"> <span class="text-small">Regular</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">23</span>
                                            </li>
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox"> <span class="text-small">Internship</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">22</span>
                                            </li>
                                            <li>
                                                <label class="cb-container">
                                                    <input type="checkbox"> <span class="text-small">Associate</span>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <span class="number-item">14</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- <div class="filter-block mb-40">
                                    <h5 class="medium-heading mb-25">Salary Range</h5>
                                    <div class="">
                                        <div class="row mb-20">
                                            <div class="col-sm-12">
                                                <div id="slider-range"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="lb-slider">From</label>
                                                <div class="form-group minus-input">
                                                    <input type="text" name="min-value-money" class="input-disabled form-control min-value-money" disabled="disabled" value="" />
                                                    <input type="hidden" name="min-value" class="form-control min-value" value="" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="lb-slider">To</label>
                                                <div class="form-group">
                                                    <input type="text" name="max-value-money" class="input-disabled form-control max-value-money" disabled="disabled" value="" />
                                                    <input type="hidden" name="max-value" class="form-control max-value" value="" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="buttons-filter">
                                    <button class="btn btn-default" type="submit">Apply filter</button>
                                    <!-- <button class="btn">Reset filter</button> -->

                                <?php if (!empty($_GET['search']) || !empty($_GET['country']) || !empty($_GET['industry'])) {
                                echo "hi"; ?>
                                        <button class="btn" href="<?php echo base_url('buyers'); ?>">Reset Filter</button>
                                    <?php } ?>
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="sidebar-with-bg background-primary bg-sidebar pb-80">
                            <h5 class="medium-heading text-white mb-20 mt-20">Recruiting?</h5>
                            <p class="text-body-999 text-white mb-30">Advertise your jobs to millions of monthly users
                                and
                                search 16.8 million CVs in our database.</p>
                            <a href="job-grid-2.html" class="btn btn-border icon-chevron-right btn-white-sm">Post a Job</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="section-box">
            <div class="container">
                <ul class="list-partners">
                    <li class="wow animate__animated animate__fadeInUp hover-up" data-wow-delay="0s">
                        <a href="#">
                            <figure><img alt="jobhub" src="assets/imgs/jobs/logos/samsung.svg" /></figure>
                        </a>
                    </li>
                    <li class="wow animate__animated animate__fadeInUp hover-up" data-wow-delay=".1s">
                        <a href="#">
                            <figure><img alt="jobhub" src="assets/imgs/jobs/logos/google.svg" /></figure>
                        </a>
                    </li>
                    <li class="wow animate__animated animate__fadeInUp hover-up" data-wow-delay=".2s">
                        <a href="#">
                            <figure><img alt="jobhub" src="assets/imgs/jobs/logos/facebook.svg" /></figure>
                        </a>
                    </li>
                    <li class="wow animate__animated animate__fadeInUp hover-up" data-wow-delay=".3s">
                        <a href="#">
                            <figure><img alt="jobhub" src="assets/imgs/jobs/logos/pinterest.svg" /></figure>
                        </a>
                    </li>
                    <li class="wow animate__animated animate__fadeInUp hover-up" data-wow-delay=".4s">
                        <a href="#">
                            <figure><img alt="jobhub" src="assets/imgs/jobs/logos/avaya.svg" /></figure>
                        </a>
                    </li>
                    <li class="wow animate__animated animate__fadeInUp hover-up" data-wow-delay=".5s">
                        <a href="#">
                            <figure><img alt="jobhub" src="assets/imgs/jobs/logos/forbes.svg" /></figure>
                        </a>
                    </li>
                    <li class="wow animate__animated animate__fadeInUp hover-up" data-wow-delay=".1s">
                        <a href="#">
                            <figure><img alt="jobhub" src="assets/imgs/jobs/logos/avis.svg" /></figure>
                        </a>
                    </li>
                    <li class="wow animate__animated animate__fadeInUp hover-up" data-wow-delay=".2s">
                        <a href="#">
                            <figure><img alt="jobhub" src="assets/imgs/jobs/logos/nielsen.svg" /></figure>
                        </a>
                    </li>
                    <li class="wow animate__animated animate__fadeInUp hover-up" data-wow-delay=".3s">
                        <a href="#">
                            <figure><img alt="jobhub" src="assets/imgs/jobs/logos/doordash.svg" /></figure>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <section class="section-box mt-50 mb-60">
            <div class="container">
                <div class="box-newsletter">
                    <h5 class="text-md-newsletter">Sign up to get</h5>
                    <h6 class="text-lg-newsletter">the latest jobs</h6>
                    <div class="box-form-newsletter mt-30">
                        <form class="form-newsletter">
                            <input type="text" class="input-newsletter" value="" placeholder="contact.alithemes@gmail.com" />
                            <button class="btn btn-default font-heading icon-send-letter">Subscribe</button>
                        </form>
                    </div>
                </div>
                <div class="box-newsletter-bottom">
                    <div class="newsletter-bottom"></div>
                </div>
            </div>
        </section>
    </main>
    <!-- End Content -->
    