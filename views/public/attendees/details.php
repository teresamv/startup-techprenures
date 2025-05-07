
<?php

function calculateDuration($start_date, $end_date)
{
$start = new DateTime($start_date);
$end = $end_date ? new DateTime($end_date) : new DateTime();
$diff = $start->diff($end);
return [
'years' => $diff->y,
'months' => $diff->m,
];
}

function formatDuration($duration)
{
return $duration['years'] . ' years ' . $duration['months'] . ' months';
}
function isValidUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
}
?>
<style>
section.cover-img-band {
  background: #eee;
  height: 180px;
  position: relative;
  background-image: url('<?php echo !empty($attendee) ? base_url($attendee->background_image). '?v=' . time() : '../imgs/theme/bg-cover.png'; ?>');
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  position: relative;
}
</style>
<main class="main emp-profile-full-section pt-0">
    

<section class="cover-img-band" 
    <?php if (!empty($user) && $user == $name) { 
        echo 'id="profile-picture_cover" data-bs-toggle="modal" data-bs-target="#exampleModal" data-section="media"';  
    } ?>>           
        </section>
        <div class="container">
        <div class="heading-image-rd" <?php if (!empty($user) && $user == $name) { echo 'id="profile-picture"'; } ?>>
            <a href="javascript:void(0)">
            <figure>
                <img class="profile-pic" alt="jobhub" data-profile-url="<?php echo base_url('assets/images/profile.png'); ?>"
                src="<?php echo isset($attendee) && is_object($attendee) && $attendee->profile_image_download_path 
                            ? base_url($attendee->profile_image_download_path) . '?v=' . time() 
                            : base_url('assets/frontend_assets/imgs/avatar/no_profile.png')  ?>">
            </figure>
            </a>
            </div>
            
         <div class="top-btn-group"> 
        <?php if ($name == $user && $attendee->claim_profile == 0) : ?>
            <button class="btn-primary" id="clam_profile" data-id="<?php echo $attendee->id; ?>" type="button">Claim Profile</button>
        <?php endif; ?>
      
        <?php if ($attendee->claim_profile == 1 && $name !== $user) : ?>
           <button class="btn-danger" data-id="<?php echo $attendee->id; ?>" id="clam_report" type="button" data-bs-toggle="modal" data-bs-target="#reportModal">Report</button>
         <?php endif; ?>
         </div>
        <div class="cus-btn-group-band" style="margin-left:35%;">
         <?php
            if (!empty($user) && $user == $name) {
                if(!empty($attendee) &&($expertise_tag)&&($learn_about_tag)&&($education)&&($experience)&&($investment_details)&&($social_info)){
                echo '<div class="buttons-filter"><a href="" class="btn btn-default"  data-bs-toggle="modal" data-bs-target="#exampleModal">Edit profile</a>
                </div>';  
              }else{
                echo '<div class="buttons-filter"><a href="" class="btn btn-default"  data-bs-toggle="modal" data-bs-target="#exampleModal">Complete profile</a>
                </div>';             
             }
            }
            ?>
                <?php if (!empty($attendee->startup_id) && (!empty($attendee))): ?>
                  <div class="buttons-filter startup-border-btn">
                     <a href= "<?= base_url('startups/details/' . $attendee->startup_id); ?>" class="btn btn-default" >Startup profile</a>
                 </div>
                <?php endif; ?>
         </div>
        </div>
        <div class="container">
            <div class="profile-top-band">
            <div class="heading-main-info">
        <h4> <?php 
    if (!empty($attendee)) {
        echo $attendee->name;
    } else {
        echo $profile_details->name;
    }
    ?></h4>
        <p class="describe-yourself"><?= isset($attendee) ?  $attendee->position : '' ?></p>
            <div class="head-info-profile mb-50">
            <span class="text-small mr-20" id="attendee_country"><i class="fi-rr-marker text-mutted"></i> <?php if(!empty($attendee)) { 
              echo $attendee->country; 
            } ?></span>
            <?php if (!empty($attendee->industry)) : ?>
            <span class="text-small mb-10 mr-20" id="attendee_industry"><i class="fi-rr-briefcase text-mutted"></i> <?= $attendee->industry ?></span>
        <?php endif; ?>
        <?php if(!empty($user) && $user == $name) : ?>
        <div class="row mt-15">
                <!-- <div class="col-3">
                <a href="" class=""  data-bs-toggle="modal" data-bs-target="#exampleModal">Personal profile</a>
                <div class="buttons-filter">
                     <a class="btn btn-default" data-bs-toggle="modal" data-bs-target="#exampleModal">Personal profile</a>
                 </div>
                </div> -->
                <div class="cus-btn-group-band">
               
               </div>
   </div>
   <?php endif; ?>
   </div>
    <div class="align-items-end">
    <div class="col-lg social-band-cus">
        <?php if (!empty($social_info)): ?>
            <?php foreach ($social_info as $item): ?>
                <?php if (!empty($item->link_href) && isValidUrl($item->link_href)): ?>
                    <a class="hmm" href="<?php echo htmlspecialchars($item->link_href); ?>" target="_blank">
                        <img alt="<?php echo htmlspecialchars($item->link); ?>" src="<?php echo htmlspecialchars($item->icon_image); ?>" style="width: 30px; height: 30px;">
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
   </div>
        </div>
        <div class="divider"></div>

        <section class="section-box mt-5">
            <div class="">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="content-single">
                            <h5 class="mt-0">About</h5>
                            <p>
                            <?= isset($attendee) ?  $attendee->about : '' ?>
                            </p>
                            
                            <div class="divider"></div>
                            <?php  if(!empty($expertise_tag)):  ?>
                            <div class="expertise_div">
                            <div class="col-10 mt-15">
                <!-- <div class="sidebar-shadow"> -->
                                    <h5 class="font-bold mb-10">Expertise </h5>
                                  <div class="block-tags" style="cursor:pointer;">
                                    <?php
                                        if (isset($expertise_tag)) {
                                            foreach ($expertise_tag as $expertise) {
                                                // Use htmlspecialchars to avoid XSS attacks
                                                $expertiseName = htmlspecialchars($expertise->expertise);
                                                echo "<span class=\"btn btn-tags-sm mb-5 mr-5 expertise\">$expertiseName</span>";
                                            }
                                        }
                                        ?>
                                    </div>
                                 </div>
                                <div class="divider"></div>
                                </div>
                                <?php endif; ?>

                <?php if (!empty($learn_about_tag)) : ?>
                <div class="learnabout_div">
                <div class="col-10">
                <!-- <div class="sidebar-shadow"> -->
                                <h5 class="font-bold mb-10">Learn about </h5>
                                 <div class="block-tags" style="cursor:pointer;">
                                        <?php if (isset($learn_about_tag)): ?>
                                            <?php foreach ($learn_about_tag as $t): ?>
                                                <span class="btn btn-tags-sm mb-5 mr-5 learnabout"><?= htmlspecialchars($t->tag, ENT_QUOTES, 'UTF-8') ?></span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                 </div>
                                </div>
                            </div>
                <?php endif; ?>
                <?php if ($startup) { ?>
                    <div class="divider"></div>
                         <div class="single-recent-jobs">
                            <div class="list-recent-jobs" >
                                <a href="<?=base_url('startups/details/' . $startup->id. '-' . url_title($startup->name, '-', TRUE));?>">
                                    <div class="card-job hover-up wow animate__animated animate__fadeInUp" style="background-color:#eeeeee08; border:1px solid #eee;">
                                        <div class="card-job-top">
                                            <div class="card-job-top--image">
                                                <?php if ($startup->logo_src) { ?>
                                                    <div class="img-sm-band"><img alt="startup" src="<?= base_url($startup->logo_src). '?v=' . time(); ?>" /></div>
                                                <?php } else { ?>
                                                    <div class="img-sm-band"><img alt="attendes" src="<?= base_url('assets/frontend_assets/imgs/avatar/no_profile.png') ?>" /></div>
                                                <?php } ?>
                                            </div>
                                            <div class="card-job-top--info cus-info-card-new-band">
                                                <h6 class="card-job-top--info-heading"><?= $startup->name ?></h6>
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <span class="card-job-top--company"><?= $startup->sector ?></span>
                                                    </div>
                                                    <span class="card-job-top--type-job text-sm"><i class="fi-rr-marker mr-5"></i> <?= $startup->country ?></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="divider"></div>

                    <?php } ?>
                <?php if (!empty($experience)) : ?>
                    <div class="exp_div">
                    <h5 class="mb-20 mt-25">Experience
                      <a id="editImageLink" href="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-section="experience">
                         <?php if (!empty($experience) && (!empty($user) && $user == $attendee->name)) : ?>
                         <img alt="startup" style="cursor:pointer;" src="<?= base_url('assets/frontend_assets/imgs/avatar/edit-line.svg') ?>" />
                        <?php endif; ?>
                     </a>
                  </h5>
              
                            <div class="row">
                            <div id="" class="mt-3">
                            <?php if (!empty($experience)) : ?>
                                <?php foreach ($experience as $exp) : ?>
                                    <?php
                                        $exp_id = $exp->id;
                                        $duration = calculateDuration($exp->start_date, $exp->end_date);
                                        $durationText = formatDuration($duration);
                                        $endDateText = $exp->end_date ? date('M Y', strtotime($exp->end_date)) : 'Present';
                                        $startDate = new DateTime($exp->start_date);
                                        $startMonth = $startDate->format('M');
                                        $startYear = $startDate->format('Y');
                                    ?>
                                    <div class="added-experience added-card-band mt-3" data-id="<?php echo htmlspecialchars($exp_id, ENT_QUOTES, 'UTF-8'); ?>">
                                        <div class="left-cus-band">
                                        <div class="bg-icon-band">
                                        <?php if (!empty($exp->company_image)): ?>
                                            <img src="<?php echo base_url($exp->company_image); ?>" alt="Company Image" class="exp-image-src">
                                        <?php else: ?>
                                            <img src="<?php echo base_url('assets/frontend_assets/imgs/theme/experience-icon.png'); ?>" alt="Default Image">
                                        <?php endif; ?>
                                    </div>
                                            <div class="text-band-1">
                                                <input type="hidden" class="id" value="<?php echo htmlspecialchars($exp_id, ENT_QUOTES, 'UTF-8'); ?>">
                                                <h6>
                                                    <?php echo htmlspecialchars($exp->title, ENT_QUOTES, 'UTF-8'); ?> 
                                                    <span class="new_role"><?php echo htmlspecialchars($exp->role, ENT_QUOTES, 'UTF-8'); ?></span> 
                                                    at <span class="new_exp"><?php echo htmlspecialchars($exp->company_name, ENT_QUOTES, 'UTF-8'); ?></span>
                                                </h6>
                                                <p>
                                                    <?php echo htmlspecialchars($startMonth, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($startYear, ENT_QUOTES, 'UTF-8') . ' - ' . htmlspecialchars($endDateText, ENT_QUOTES, 'UTF-8') . ' (' . htmlspecialchars($durationText, ENT_QUOTES, 'UTF-8') . ')'; ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-menu-band">
                                            <!-- Additional content or functionality here -->
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                        <div class="added-experience added-card-band mt-3" style="justify-content: center;">
                            <div class="text-band-1">
                             <p>
                               <a href="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-section="experience">Add Experience details</a>
                            </p>                           
                         </div>
                        </div>
                    <?php endif; ?>
                    </div>
                    </div>
                  <div class="divider"></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($education)) : ?>
                             <div class="edu_div">
                            <h5 class="mt-30 mb-30">Education
                            <a href="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-section="education">
                                <?php if (!empty($education) && (!empty($user) && $user == $attendee->name)) : ?>
                                    <img alt="startup" style="cursor:pointer;" src="<?= base_url('assets/frontend_assets/imgs/avatar/edit-line.svg') ?>" />
                                <?php endif; ?>
                            </a>
                        </h5>

                           <div id="" class="mt-3">
                            <?php if (!empty($education)) : ?>
                                <?php foreach ($education as $edu) : ?>
                                    <?php
                                $startDate = new DateTime($edu->start_date);
                                $endDate = new DateTime($edu->end_date);
                                $startMonth = $startDate->format('M');
                                $startYear = $startDate->format('Y');
                                $endMonth = $endDate->format('M');
                                $endYear = $endDate->format('Y');
                            ?>

                            <div class="added-education added-card-band" data-id="<?php echo htmlspecialchars($edu->id, ENT_QUOTES, 'UTF-8'); ?>">
                                <div class="left-cus-band">
                                    <div class="bg-icon-band">
                                          <img src="http://localhost/startup_listing/assets/frontend_assets/imgs/theme/experience-icon.png" alt="Investment Icon">
                                     </div>
                                    <div class="text-band-1">
                                        <input type="hidden" class="id_edu" value="<?php echo htmlspecialchars($edu->id, ENT_QUOTES, 'UTF-8'); ?>">
                                        <h6>
                                            <?php echo htmlspecialchars($edu->degree, ENT_QUOTES, 'UTF-8'); ?> in 
                                            <span class="new_subject"><?php echo htmlspecialchars($edu->subject, ENT_QUOTES, 'UTF-8'); ?></span> 
                                            from <span class="new_uni"><?php echo htmlspecialchars($edu->University_name, ENT_QUOTES, 'UTF-8'); ?></span>
                                        </h6>
                                        <p><?php echo htmlspecialchars($startMonth, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($startYear, ENT_QUOTES, 'UTF-8') . ' - ' . htmlspecialchars($endMonth, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($endYear, ENT_QUOTES, 'UTF-8'); ?></p>
                                    </div>
                                </div>
                                <div class="card-menu-band">
                                    <!-- Additional content or functionality here -->
                                </div>
                            </div>
                                   <?php endforeach; ?>
                                    <?php else: ?>
                        <div class="added-education added-card-band" style="justify-content: center;">
                            <div class="text-band-1">
                            <p>
                                <?php
                                if (!empty($user) && $user == $attendee->name) {
                                    echo '<a href="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-section="education">Add Education details</a>';
                                }
                                ?>
                            </p>
                            </div>
                        </div>
                        <?php endif; ?>
                        </div>
                        <div class="divider"></div>
                        </div>
                        <?php endif; ?>
                         <?php if (!empty($investment_details)) : ?>
                             <div class="invest_div">
                            <h5 class="mt-30 mb-30">Investments
                            <a id="" href="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-section="investment">
                            <?php if (!empty($investment_details) && (!empty($user) && $user == $attendee->name)) : ?>
                            <img alt="startup" style="cursor:pointer;" src="<?= base_url('assets/frontend_assets/imgs/avatar/edit-line.svg') ?>" />
                        <?php endif; ?>                           
                            </a>                            
                         </h5>
                            <div class="row">
                            <div id="" class="mt-3">
                            <?php if (!empty($investment_details)) : ?>
                                <?php foreach ($investment_details as $investment) : ?>
                                    <div class="added-experience added-card-band">
                                        <div class="left-cus-band">
                                            <div class="bg-icon-band">
                                            <?php if (!empty($investment->comapny_image)): ?>
                                            <img src="<?php echo base_url($investment->comapny_image); ?>" alt="Company Image" class="exp-image-src">
                                        <?php else: ?>
                                            <img src="<?php echo base_url('assets/frontend_assets/imgs/theme/experience-icon.png'); ?>" alt="Default Image">
                                        <?php endif; ?>
                                            </div>
                                            <div class="text-band-1">
                                                <input type="hidden" class="id" value="<?php echo $investment->id; ?>">
                                                <h6><?php echo htmlspecialchars($investment->company_name, ENT_QUOTES, 'UTF-8'); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div id="" class="mt-3">
                                    <div class="added-experience added-card-band" style="justify-content: center;">
                                        <div class="text-band-1">
                                        <p>
                                    <?php
                                    if (!empty($user) && $user == $attendee->name) {
                                        echo '<a href="#exampleModal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-section="investment">Add Investment details</a>';
                                    }
                                    ?>
                                 </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            </div>
                        </div>
                            <div class="divider"></div>
                            </div>
                            <?php endif; ?>
                           <!-- recomdation -->
                       </div>
                    </div>
                </div>
            </div>
        </section>
   </main>
   
   <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Write your conversation here</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <form id="reportForm">
                    <div class="form-group">
                        <textarea class="form-control" id="issue" style="height: 150px;" name="issue" placeholder="Type here..." rows="4"></textarea>
                    </div>
                    <button type="submit" href="" class="btn btn-primary float-right">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal scrollspy-model fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
<div class="modal-header">
<h5 class="modal-title text-center" id="exampleModalLabel">Get to full strength </h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
  <div class="modal-body">


<div id="list-example" class="scrollactive-nav edit-nav-menu">
    <a class="list-group-item 
    list-group-item-action active" href="#overview">
        Overview
    </a>
    <a class="list-group-item 
    list-group-item-action" href="#experience">
        Experience
    </a>
    <a class="list-group-item 
    list-group-item-action" href="#education">
        Education
    </a>
    <a class="list-group-item list-group-item-action" href="#media">
        Media
    </a>
    <a class="list-group-item list-group-item-action" href="#investment">
        Investment
    </a>
    <a class="list-group-item list-group-item-action" href="#profile_info">
        Profile Info
    </a>
    <a class="list-group-item list-group-item-action" href="#Recommendations">
        Recommendations
    </a>
    <a class="list-group-item list-group-item-action" href="#Advance">
        Advanced
    </a>
</div>

<div class="profile-edit-content" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-offset="40" class="scrollspy-example" tabindex="0">
        <article id="overview">
            <div class="col-md-6">
            <!-- <form id="profile-form" action="" method="POST" enctype="multipart/form-data"> -->
            <div class="Upload-logo-band">
                    <div class="circle">
                    <?php if (isset($attendee) && is_object($attendee)): ?>
                        <img class="profile-pic" 
                            src="<?php echo !$attendee->profile_image_download_path 
                                        ? $demo_photo 
                                        : base_url($attendee->profile_image_download_path) . '?v=' . time(); ?>">
                    <?php else: ?>
                        <img class="profile-pic" src="<?php echo $demo_photo; ?>">
                    <?php endif; ?>
                </div>

                <div class="p-image">
                    <a href="javascript:void(0)" class="upload-btn upload-button">Update Profile</a>
                    <input class="file-upload" type="file" id="profile-image" name="profile_image" accept="image/*" />
                    <span id="file-error-msg" style="color:red; display:none;"></span>

                </div>
            </div>
        <!-- </form> -->
            </div>
            <article id="profile_info">
        <span>Profile Info</span>
        <div class="row mt-3">
            <?php
           $first_name = '';
            $last_name = '';
        if (isset($attendee) && !empty($attendee->name)) {
                $name_parts = explode(' ', $attendee->name);
                $first_name = $name_parts[0];
                $last_name = isset($name_parts[1]) ? $name_parts[1] : '';
            } else if (isset($profile_details) && !empty($profile_details->name)) {
                $name_parts = explode(' ', $profile_details->name);
                $first_name = $name_parts[0];
                $last_name = isset($name_parts[1]) ? $name_parts[1] : '';
            }
            ?>
            <div class="col-md-6">
                <label for="firstname" class="form-label">First name</label>
                <input type="text" class="form-control" id="firstname" value="<?php echo htmlspecialchars($first_name); ?>">
            </div>
            <div class="col-md-6">
                <label for="lastname" class="form-label">Last name</label>
                <input type="text" class="form-control" id="lastname" value="<?php echo htmlspecialchars($last_name); ?>">
            </div>
                 </div>
                <div class="form-group-band" style="margin-top:17px;">
                    <label for="country">Country</label>
                    <input type="text" class="form-control" id="country" name="country" value="<?php echo isset($attendee->country) ? $attendee->country : ''; ?>">
               </div>
     </article>
            <div class="form-group-band mt-15">
                <label for="name">Your skills and interests</label>
                <select class="form-control select2-multiple" id="skills" name="skills[]" multiple="multiple">
          <?php foreach ($expertise_names as $name): ?>
          <option value="<?= htmlspecialchars($name->expertise); ?>"
            <?php 
            if (!empty($expertise_tag)) {
                echo in_array($name->expertise, array_map(function($tag) { return $tag->expertise; }, $expertise_tag)) ? 'selected' : '';
            }
            ?>>
            <?= htmlspecialchars($name->expertise); ?>
                    </option>
                <?php endforeach; ?>
            </select>
           </div>
           
          
            <div id="emailHelp" class="form-text">Add 5 or more and be specific.<br>
              </div>
                <div class="form-group-band mt-15">
                <?php 
                $learn_about_tag = isset($learn_about_tag) ? $learn_about_tag : [];
                ?>
                        <label for="learn_about_tag">Learn About</label>
                        <select class="form-control select2-multiple" id="learn_about_tag" name="learn_about_tag[]" multiple="multiple">
                            <?php foreach ($learnabout_names as $name) : ?>
                                <option value="<?= htmlspecialchars($name->tag); ?>" 
                                <?php echo in_array($name->tag, array_map(function ($tag) {
                                        return $tag->tag;
                                    }, $learn_about_tag)) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($name->tag); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                 </div>
            <div class="form-text">Add 5 or more and be specific.<br>
                </div>
            <div class="col-12 mt-3">
                <label for="describe" class="form-label">Describe yourself briefly </label>
                <input type="text" class="form-control" id="describe" value="<?= isset($attendee) ? $attendee->descrption : '' ?>">
                <div id="emailHelp" class="form-text">Talk about what you do now, your past experiences and your goals and your passions.</div>
            </div>
            <div class="col-12 mt-3">
                <label for="about">About you </label>
                <textarea class="form-control" id="about" name="about" rows="3"><?= isset($attendee) ? $attendee->about : '' ?></textarea>
            </div>
            <div class="col-12 add-links-band" style="margin-top:30px">
                <span>Links</span>
                <div class="social_details" id="social_details">
                    <?php if (!empty($social_info)): ?>
                        <?php foreach ($social_info as $social): 
                            $icon_name = basename($social->icon_image, ".png");
                        ?>
                    <div class="social-link">
                        <img src="<?= $social->icon_image; ?>" alt="<?= $social->link; ?>">
                        <input type="text" class="form-control" placeholder="<?= ucfirst($social->link); ?>" value="<?= isValidUrl($social->link_href) ? $social->link_href : ''; ?>" id="<?= $icon_name; ?>">
                        <input type="hidden" id="social_id" name="social_id[]" value="<?= $social->id ?>">
                        <div class="error-message" style="color:red;" id="<?= $icon_name . '-error'; ?>"></div>
                        <button type="button" id="remove_social" value="<?= $social->id ?>" class="btn-close close-icon-band" aria-label="Close"></button>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="social-link">
                        <img src="<?= base_url('uploads/social_icon/linkedin.png'); ?>" alt="LinkedIn">
                        <input type="text" class="form-control" placeholder="LinkedIn" id="linkedin">
                        <div class="error-message" style="color:red;" id="linkedin-error"></div>
                    </div>
                    <div class="social-link">
                        <img src="<?= base_url('uploads/social_icon/twitter.png'); ?>" alt="Twitter">
                        <input type="text" class="form-control" placeholder="Twitter" id="twitter">
                        <div class="error-message" style="color:red;" id="twitter-error"></div>
                    </div>
                    <div class="social-link">
                        <img src="<?= base_url('uploads/social_icon/github.png'); ?>" alt="GitHub">
                        <input type="text" class="form-control" placeholder="GitHub" id="github">
                        <div class="error-message" style="color:red;" id="github-error"></div>
                    </div>
                <?php endif; ?>
            </div>
                <a type="button" class="btn btn-primary" id="addsocial">Add more</a>
                <input type="hidden" class="form-control" id="email" name="email" value="<?php echo $profile_details->email; ?>">
                <input type="hidden" class="form-control" id="name" name="name" value="<?php echo $profile_details->name;  ?>">
            </div>
        </article>
        <article id="experience">
            <div class="profile-titile-band">
                <h5>Experience</h5>
            </div>

            <form id="workExperienceForm" method="post">
                <div class="col-12 mt-3">
                    <label for="about">Add work experience </label>
                    <input  type="text" class="form-control" id="experience_work" name="experience">
                    <img src="" alt="" style="width: 63px;" id="exp_image">
                   <div id="addedDetails" class="mt-3">
                        <?php if (!empty($experience)) : ?>
                            <?php foreach ($experience as $exp) : ?>
                                <?php
                                    $exp_id =  $exp->id;
                                    $duration = calculateDuration($exp->start_date, $exp->end_date);
                                    $durationText = formatDuration($duration);
                                    $endDateText = $exp->end_date ? date('M Y', strtotime($exp->end_date)) : 'Present';
                                    $startDate = new DateTime($exp->start_date);
                                    $startMonth = $startDate->format('M');
                                    $startYear = $startDate->format('Y');
                                    ?>
                                <div class="added-experience added-card-band" data-id="<?php echo $exp->id; ?>">
                                    <div class="left-cus-band">
                                    <div class="bg-icon-band">
                                        <?php if (!empty($exp->company_image)): ?>
                                            <img src="<?php echo base_url($exp->company_image); ?>" alt="Company Image" class="exp-image-src">
                                        <?php else: ?>
                                            <img src="<?php echo base_url('assets/frontend_assets/imgs/theme/experience-icon.png'); ?>" alt="Default Image">
                                        <?php endif; ?>
                                    </div>
                                        <div class="text-band-1">
                                            <input type="hidden" class="id" value="<?= $exp_id?>">
                                            <h6><?php echo $exp->title; ?> <span class="new_role"><?php echo $exp->role; ?></span> at <span class="new_exp"><?php echo $exp->company_name; ?></span></h6>
                                            <p><?php echo $startMonth . ' ' . $startYear . ' - ' . $endDateText . ' (' . $durationText . ')'; ?></p>
                                        </div>
                                    </div>
                                    <div class="card-menu-band">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="<?php echo base_url('assets/frontend_assets/imgs/theme/menu-dot.png'); ?>">
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="margin: 0px;">
                                                <li><a class="dropdown-item" href="#" data-id="<?php echo $exp->id; ?>">Edit</a></li>
                                                <li><a class="dropdown-item" href="#" data-id="<?php echo $exp->id; ?>">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </div>
                </div>
                <div class="details-exp mt-3" style="display:none;">
                    <div class="row">
                        <div class="col-6">
                            <label for="title">title</label>
                            <input type="text" class="form-control" id="title" placeholder="ex Front end devloper">
                        </div>
                        <div class="col-6">
                            <label for="role">Role</label>
                            <select id="role" class="form-control" id="role">
                               <option value="">select role</option>
                                <option>Employee</option>
                                <option>Manager</option>
                                <option>Director</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            <label for="startMonth">Start date</label>
                            <select id="startMonth" class="form-control">
                                <option value="">Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="Apr">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="Aug">August</option>
                                <option value="Sep">September</option>
                                <option value="Oct">October</option>
                                <option value="Nov">November</option>
                                <option value="Dec">December</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label>&nbsp;</label>
                             <input type="text" id="startYear" class="form-control" placeholder="Select Year">
                         </div>

                        <div class="col-3 end-date-fields d-none">
                            <label for="endMonth">End date</label>
                            <select id="endMonth" class="form-control">
                                <option value="">Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="Apr">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="Aug">August</option>
                                <option value="Sep">September</option>
                                <option value="Oct">October</option>
                                <option value="Nov">November</option>
                                <option value="Dec">December</option>
                            </select>
                        </div>
                        <div class="col-3 end-date-fields d-none">
                            <label>&nbsp;</label>
                            <input type="text" id="endYear" class="form-control" placeholder="Select Year">
                         </div>
                    </div>
                    <div class="check-mark-cus-band">
                        <input type="checkbox" class="form-check-input mt-3" id="workHereNow" checked>
                        <label class="form-check-label mt-3" for="workHereNow">I work here now</label>
                    </div>

                    <div class="row mt-3">
                        <div class="col-3">
                            <button type="button" class="btn btn-primary" id="addExperienceButton">Add</button>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-link cancel-btn">Cancel</button>
                        </div>
                    </div>
                </div>
             </form>
                <div class="details_exp_update mt-3" style="display:none;">
                <input  type="text" class="form-control" id="update_experience_work" name="experience">
                <img src="" alt="" style="width: 63px;" id="update_exp_image">
                
                    <div class="row">
                        <div class="col-6">
                            <label for="title">title</label>
                            <input type="text" class="form-control" id="update_title" placeholder="ex Front end devloper">
                        </div>
                        <div class="col-6">
                            <label for="role">Role</label>
                            <select class="form-control" id="update_role">
                               <option value="">select role</option>
                                <option>Employee</option>
                                <option>Manager</option>
                                <option>Director</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-3">
                            <label for="startMonth">Start date</label>
                            <select id="update_startMonth" class="form-control">
                                <option value="">Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="Apr">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="Aug">August</option>
                                <option value="Sep">September</option>
                                <option value="Oct">October</option>
                                <option value="Nov">November</option>
                                <option value="Dec">December</option>
                        </select>
                        </div>
                        <div class="col-3">
                            <label>&nbsp;</label>
                           <input type="text" id="update_startYear" class="form-control" placeholder="Select Year">
                        </div>

                        <div class="col-3 end-date-fields d-none">
                            <label for="endMonth">End date</label>
                            <select id="update_endMonth" class="form-control">
                                <option value="">Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="Apr">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="Aug">August</option>
                                <option value="Sep">September</option>
                                <option value="Oct">October</option>
                                <option value="Nov">November</option>
                                <option value="Dec">December</option>
                            </select>
                        </div>
                        <div class="col-3 end-date-fields d-none">
                            <label>&nbsp;</label>
                           <input type="text" id="update_endYear" class="form-control" placeholder="Select Year">
                        </div>
                    </div>
                    <div class="check-mark-cus-band">
                        <input type="checkbox" class="form-check-input mt-3" id="update_workHereNow" checked>
                        <label class="form-check-label mt-3" for="workHereNow">I work here now</label>
                    </div>

                    <div class="row mt-3">
                        <div class="col-3">
                            <button type="button" class="btn btn-primary" id="updateExperienceButton">update</button>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-link cancel-btn">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </article>
        <article id="education">
            <div class="profile-titile-band">
                <h5>Education</h5>
            </div>
            <div class="col-12 mt-3">
                <input type="text" class="form-control" id="eduction_inn" placeholder="School name">
                <div id="addedEducationDetails" class="mt-3" style="margin-top: 15px;">
                <?php if (!empty($education)) : ?>
                        <?php foreach ($education as $edu) : ?>
                            <?php
                                $startDate = new DateTime($edu->start_date);
                                $endDate = new DateTime($edu->end_date);
                                $startMonth = $startDate->format('M');
                                $startYear = $startDate->format('Y');
                                $endMonth = $endDate->format('M');
                                $endYear = $endDate->format('Y');
                                ?>
                            <div class="added-education added-card-band" data-id="<?php echo $edu->id; ?>">
                                <div class="left-cus-band">
                                    <div class="bg-icon-band">
                                        <img src="">
                                    </div>
                                    <div class="text-band-1">
                                        <input type="hidden" class="id_edu" value="<?php echo $edu->id;   ?>">
                                        <h6><?php echo $edu->degree; ?> in <span class="new_subject"><?php echo $edu->subject; ?></span> from <span class="new_uni"><?php echo $edu->University_name; ?></span></h6>
                                        <p><?php echo $startMonth . ' ' . $startYear . ' - ' . $endMonth . ' ' . $endYear; ?></p>
                                    </div>
                                </div>
                                <div class="card-menu-band">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <img src="<?php echo base_url('assets/frontend_assets/imgs/theme/menu-dot.png'); ?>">
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" data-id="<?php echo $edu->id; ?>" style="margin: 0px;">
                                            <li><a class="dropdown-item" data-id="<?php echo $edu->id; ?>">Edit</a></li>
                                            <li><a class="dropdown-item" data-id="<?php echo $edu->id; ?>" href="#">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
               
              </div>
            <div class="details-edu mt-3" style="display:none;">

                <div class="row">
                    <div class="col-6">
                        <label for="degree">Degree or program </label>
                        <input type="text" class="form-control" id="degree" name="degree" placeholder="ex Bachelor of Engineering">
                    </div>
                    <div class="col-6">
                        <label for="role">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="ex Physics">

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-3">
                        <label for="startMonth">Start date</label>
                        <select id="startMonth_edu" class="form-control">
                            <option value="">Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="Apr">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="Aug">August</option>
                            <option value="Sep">September</option>
                            <option value="Oct">October</option>
                            <option value="Nov">November</option>
                            <option value="Dec">December</option>
                            
                        </select>
                    </div>
                    <div class="col-3">
                        <label>&nbsp;</label>
                        <input type="text" id="startYear_edu" class="form-control" placeholder="Select Year">
                   </div>

                    <div class="col-3">
                        <label for="endMonth">End date</label>
                        <select id="endMonth_edu" class="form-control">
                            <option value="">Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="Apr">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="Aug">August</option>
                            <option value="Sep">September</option>
                            <option value="Oct">October</option>
                            <option value="Nov">November</option>
                            <option value="Dec">December</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label>&nbsp;</label>
                        <select id="endYear_edu" class="form-control">
                            <option value="">Year</option>
                           
                        </select>
                    </div>
                </div>
                    <div class="row mt-3">
                    <div class="col-3">
                        <button type="button" class="btn btn-primary btn-cus-add" id="addEducationButton">Add</button>
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-link cancel-btn">Cancel</button>
                                </div>
                            </div>
                        </div>
                   </form>
                <div class="details_edu_update mt-3" style="display:none;">
                <input type="text" class="form-control" id="update_eduction_inn" placeholder="School name">
                  <div class="row">
                    <div class="col-6">
                        <label for="degree">Degree or program </label>
                        <input type="text" class="form-control" id="update_degree" name="degree" placeholder="ex Bachelor of Engineering">
                    </div>
                    <div class="col-6">
                        <label for="role">Subject</label>
                        <input type="text" class="form-control" id="update_subject" name="subject" placeholder="ex Physics">

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-3">
                        <label for="startMonth">Start date</label>
                        <select id="update_startMonth_edu" class="form-control">
                            <option value="">Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="Apr">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="Aug">August</option>
                            <option value="Sep">September</option>
                            <option value="Oct">October</option>
                            <option value="Nov">November</option>
                            <option value="Dec">December</option>
                            
                        </select>
                    </div>
                    <div class="col-3">
                        <label>&nbsp;</label>
                        <input type="text" id="update_startYear_edu" class="form-control" placeholder="Select Year">
                   </div>

                    <div class="col-3">
                        <label for="endMonth">End date</label>
                        <select id="update_endMonth_edu" class="form-control">
                            <option value="">Month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="Apr">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="Aug">August</option>
                            <option value="Sep">September</option>
                            <option value="Oct">October</option>
                            <option value="Nov">November</option>
                            <option value="Dec">December</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label>&nbsp;</label>
                        <input type="text" id="update_endYear_edu" class="form-control" placeholder="Select Year">

                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-3">
                        <button type="button" class="btn btn-primary btn-cus-add" id="updateEducationButton">Update</button>
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-link cancel-btn">Cancel</button>
                    </div>
                </div>
            </div>
    </article>

    <article id="media" class="mt-3">
        <div class="profile-titile-band">
            <h5>Media</h5>
        </div>
        <div class="col-12 mt-3">
            <span>Cover photo</span>
              <div class="image-upload-container">
                <div class="image-preview" >
                <?php if (isset($attendee) && $attendee->background_image): ?>
        <img class="uploaded-image"  src="<?php echo base_url($attendee->background_image). '?v=' . time(); ?>" alt="Background Image">
        <!-- <button type="button" class="btn-close close-icon-band" id="closeimg" style="position: relative;right: 26px; width: 25px; height: 25px;bottom: 6px; display:none;" aria-label="Close"></button> -->

    <?php else: ?>
        <!-- <img src="path/to/default-image.jpg" alt="Default Image"> -->
    <?php endif; ?>
                </div>
                <div class="upload-cover-band">
                    <form id="upload-form">
                        <button type="button" id="upload-btn">Upload or drop file here</button>
                    </form>
                    <label class="upload-more">
                        <input type="file" id="image-upload" name="images" multiple accept="image/*">
                        <span style="cursor:pointer;"> JPG, PNG or jpeg </span>
                    </label>
                    <div id="cover-error-msg" style="display:none; color:red;"></div>

                </div>
            </div>
        </div>
    </article>
    <article id="investment">
        <span>Investment</span>
        <div class="col-12 mt-3">
            <label for="investment">Add companies where you've invested or have equity</label>
            <input  type="text" class="form-control" id="store" name="store">
            <img src="" alt="" style="width: 63px;" id="invest_image" class="invest_image">
         </div>
       
        <div id="investment-details">
    <?php if (!empty($investment_details)) : ?>
        <?php foreach ($investment_details as $entry) : ?>
            <div class="row investment-entry">
            <?php if (isset($entry->comapny_image)): ?>
                    <img src="<?= base_url($entry->comapny_image); ?>" class="invest_image" alt="<?= htmlspecialchars($entry->company_name, ENT_QUOTES, 'UTF-8'); ?>" style="width: 63px;">
                <?php endif; ?>
              <span id="selectedValue"><?= htmlspecialchars($entry->company_name, ENT_QUOTES, 'UTF-8'); ?></span>
              <input type="hidden" id="in_id" value="<?php echo htmlspecialchars($entry->id, ENT_QUOTES, 'UTF-8'); ?>">
              <div class="col-3">
                    <select id="currency" class="form-control">
                        <option value="">$Us Dollar</option>
                        <option value="€ Euro" <?= ($entry->currency == '€ Euro') ? 'selected' : ''; ?>>€ Euro</option>
                        <option value="£ U.K. Pound" <?= ($entry->currency == '£ U.K. Pound') ? 'selected' : ''; ?>>£ U.K. Pound</option>
                        <option value="C$ Canadian Dollar" <?= ($entry->currency == 'C$ Canadian Dollar') ? 'selected' : ''; ?>>C$ Canadian Dollar</option>
                        <option value="₹ Indian Rupee" <?= ($entry->currency == '₹ Indian Rupee') ? 'selected' : ''; ?>>₹ Indian Rupee</option>
                    </select>
                    <input type="text" id="amount" placeholder="amount" value="<?= htmlspecialchars($entry->amount, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" id="invest_id" placeholder="" value="<?= htmlspecialchars($entry->id, ENT_QUOTES, 'UTF-8'); ?>">

                </div>
                <div class="col-3">
                    <select id="round" class="form-control">
                        <option value="Round" <?= ($entry->round == 'Round') ? 'selected' : ''; ?>>Round</option>
                        <option value="Founders Capital" <?= ($entry->round == 'Founders Capital') ? 'selected' : ''; ?>>Founders Capital</option>
                        <option value="Angel" <?= ($entry->round == 'Angel') ? 'selected' : ''; ?>>Angel</option>
                        <option value="Pre-seed" <?= ($entry->round == 'Pre-seed') ? 'selected' : ''; ?>>Pre-seed</option>
                        <option value="Seed" <?= ($entry->round == 'Seed') ? 'selected' : ''; ?>>Seed</option>
                        <option value="Series A" <?= ($entry->round == 'Series A') ? 'selected' : ''; ?>>Series A</option>
                    </select>
                </div>
                <div class="col-3">
                    <select id="equity" class="form-control">
                        <option value="" <?= ($entry->equity == '') ? 'selected' : ''; ?>>Equity</option>
                        <option value="Debt" <?= ($entry->equity == 'Debt') ? 'selected' : ''; ?>>Debt</option>
                        <option value="Grant" <?= ($entry->equity == 'Grant') ? 'selected' : ''; ?>>Grant</option>
                        <option value="Prize" <?= ($entry->equity == 'Prize') ? 'selected' : ''; ?>>Prize</option>
                        <option value="Pilot" <?= ($entry->equity == 'Pilot') ? 'selected' : ''; ?>>Pilot</option>
                        <option value="Public" <?= ($entry->equity == 'Public') ? 'selected' : ''; ?>>Public</option>
                    </select>
                </div>
                <button type="button" id="invest_close" class="btn-close close-icon-band mt-15" aria-label="Close"></button>

            </div>
        <?php endforeach; ?>
   
    <?php endif; ?>
</div>
    </article>
    
    <article id="Recommendations" style="margin-top:25px;">
        <span>Recommendations </span>
        <div class="row mt-3">
            <div class="col-md-12">
                <label for="describe" class="form-label"> Ask for reviews</label>
                <div class="row reviews-band">
                    <div class="col-md-9">
                        <select id="review" class="form-control" style="width: 100%;">
                            <option></option> <!-- For placeholder -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="" class="btn btn-outline-primary disabled">send</button>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <article id="Advance">

    </article>
    </form>