
    <!-- Content -->
    <main class="main">
        <section class="section-box">
            <div class="box-head-single">
                <div class="container">
                    <h3><?=$attendee_details->name;?></h3>
                    <ul class="breadcrumbs">
                        <li><a href="<?php echo current_url(); ?>">Home</a></li>
                        <li>Buyers listing</li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="section-box mt-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="single-image-feature">
                            <figure><img alt="jobhub" src="assets/imgs/page/job-single/img-job-feature.png" class="img-rd-15" />
                            </figure>
                        </div>
                        <div class="content-single">
                            <h5><?=$attendee_details->position;?></h5>
                            <p>
                                
                            </p>
                            <p><?=$buyers_details->cProfileBio;?>
                            </p>
                            <h5>How We Buy</h5>
                            <ul>
                                <li><?=$buyers_details->cHowwebuy;?>
                                </li>
                                
                            </ul>
                            <h5>Seeking</h5>
                            <ul>
                                <li><?=$buyers_details->cSeeking;?>
                                </li>
                            </ul>
                            <h5>Timeline</h5>
                            <p><?=$buyers_details->cTimeline;?></p>
                            
                            <h5>How to Reach</h5>
                            <p> <?=$buyers_details->cHowtoReach;?>
                            </p>
                            <h5>Support</h5>
                            <p>
                                <?=$buyers_details->cHowtoReach;?>
                            </p>
                            
                        </div>
                        <!-- <div class="author-single">
                            <span>AliThemes</span>
                        </div> -->
                        <div class="single-apply-jobs">
                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <a href="#" class="btn btn-default mr-15">Request Info</a>
                                    <a href="#" class="btn btn-border">Save job</a>
                                </div>
                                <div class="col-md-7 text-lg-end social-share">
                                    
                                </div>
                            </div>
                        </div>
                        <?php if ($related_buyers) { ?>
                        <div class="single-recent-jobs">
                            <h4 class="heading-border"><span>Related Buyers</span></h4>
                            <div class="list-recent-jobs">
                                <?php foreach ($related_buyers as $key => $value) { ?>
                            <div class="card-job hover-up wow animate__animated animate__fadeInUp">

                                <div class="card-job-top">
                                        <div class="card-job-top--image">
                                            <figure>
                                                <?php if (!empty($value->profile_img)): ?>
                                                    <?php
                                                        
                                                        if (filter_var($profile_img, FILTER_VALIDATE_URL)) {
                                                            $image_src = $value->profile_img;
                                                        } else {
                                                            $image_src = base_url($value->profile_img); 
                                                        }
                                                    ?>
                                                    <img src="<?= $image_src . '?v=' . time(); ?>">
                                               
                                                <?php else: ?>
                                                    <img src="<?= base_url('assets/frontend_assets/imgs/avatar/no_profile.png'); ?>">
                                                <?php endif; ?></figure>
                                            </div>
                                             <div class="card-job-top--info">
                                            <h6 class="card-job-top--info-heading"><a href="<?=base_url('buyers/details/' . $value->id. '-' . url_title($value->name, '-', TRUE));?>"><?=$value->name;?>
                                        </a></h6>
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <a><span class="card-job-top--company"><?=$value->position;?></span></a>
                                                    <span class="card-job-top--location text-sm"><i class="fi-rr-marker"></i>
                                                        <?=$value->country?></span>
                                                    <span class="card-job-top--type-job text-sm"><i class="fi-rr-briefcase"></i>
                                                        <?=$value->industry;?></span>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="card-job-description mt-20">
                                        <?php if(strlen($value->buyer_details->cProfileBio)> 220){
                                                echo substr($value->buyer_details->cProfileBio, 0, 220).'...';
                                            }
                                            else{
                                                echo $value->buyer_details->cProfileBio;
                                            }
                                            ?>
                                    </div>
                                    <div class="card-job-bottom mt-25">
                                        <div class="row">
                                             <?php
                                        if (isset($value->expertise_tag)) { ?>
                                            <div class="col-lg-9 col-sm-8 col-12">
                                                <?php  foreach ($value->expertise_tag as $expertise) {
                                                // Use htmlspecialchars to avoid XSS attacks
                                                $expertiseName = htmlspecialchars($expertise->expertise);?>
                                                <a href="job-grid.html" class="btn btn-small background-urgent btn-pink mr-5">
                                                <?php echo $expertiseName;?></a>
                                                <?php }
                                            }?>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    </div>

                            </div>
                                <?php }
                            ?>
                                <div class="mb-20">
                                    <a href="<?php echo base_url();?>buyers" class="btn btn-default">Explore more</a>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12 pl-40 pl-lg-15 mt-lg-30">
                        <div class="sidebar-shadow">
                            
                            <div class="text-description mt-15">
                                We're looking to add more product designers to our growing teams.
                            </div>
                            <div class="text-start mt-20">
                                <a href="#" class="btn btn-default mr-10">Request Info</a>
                                <a href="#" class="btn btn-border">Save job</a>
                            </div>
                            
                            
                            <div class="sidebar-team-member pt-40">
                                <h6 class="small-heading">Contact Info</h6>
                                <div class="info-address">
                                    <span><i class="fi-rr-marker"></i> <span>Campbell Ave undefined Kent, Utah 53127
                                            United
                                            States</span></span>
                                    <span><i class="fi-rr-headset"></i> <span>(+91) - 540-025-124553 </span></span>
                                    <span><i class="fi-rr-paper-plane"></i> <span><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="54373b3a20353720143a312720393526207a373b39">[email&#160;protected]</a></span></span>
                                    <span><i class="fi-rr-time-fast"></i> <span>10:00 - 18:00, Mon - Sat </span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End Content -->