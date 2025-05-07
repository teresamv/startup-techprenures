<header class="header sticky-bar">
    <div class="container">
        <div class="main-header">
            <div class="header-left">
                <div class="header-logo">
                    <a href="<?= base_url('attendees') ?> " class="d-flex">
                        <img alt="jobhub" style="width: 100%;
                            max-width: 200px;"
                            src="<?= base_url('assets/frontend_assets/imgs/theme/techpreneurs.png') ?>" />
                    </a>
                </div>
                <div class="header-nav">
                    <nav class="nav-main-menu d-none d-xl-block">
                        <ul class="main-menu">
                            <li class="has-children">
                                <a class="active" href="<?= base_url('techpreneurs'); ?>">Techpreneurs</a>
                            </li>
                            <li class="has-children">
                                <a class="active" href="<?= base_url('startups'); ?>">Startups</a>
                            </li>
                             <li class="has-children">
                                <a class="active" href="<?= base_url('events'); ?>">Events</a>
                            </li>
                            <li class="has-children">
                                <a class="active" href="<?= base_url('fundings'); ?>">Fundings</a>
                            </li>
                            <li class="has-children">
                                <a class="active" href="<?= base_url('buyers'); ?>">Buyers</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
            </div>
            <?php if (isset($this->session->userdata('session_user_data')['id'])): ?>
                <div class="d-flex">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="rounded-circle header-profile-user-icon">
                        <?php if (!empty($profile_img)): ?>
                            <?php
                                
                                if (filter_var($profile_img, FILTER_VALIDATE_URL)) {
                                    $image_src = $profile_img;
                                } else {
                                    $image_src = base_url($profile_img); 
                                }
                            ?>
                            <img src="<?= $image_src . '?v=' . time(); ?>" alt="Profile Image" class="img-fluid rounded-circle">
                        <?php elseif (!empty($demo_photo)): ?>
                            <img src="<?= $demo_photo  ?>" alt="Profile Image" class="img-fluid rounded-circle">
                        <?php else: ?>
                            <img src="<?= base_url('assets/frontend_assets/imgs/avatar/no_profile.png'); ?>"
                                alt="Default Profile Image" class="img-fluid rounded-circle">
                        <?php endif; ?>
                    </div>


                        </button>
                        <span class="user_title"><?= $this->session->userdata('session_user_data')['name'] ?? ''; ?></span>



                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item -->
                            <?php
                            $profile_details = $this->session->userdata('profile_details');
                           
                            $startup_profile = $this->session->userdata('profile_details_startups');

                            if (!empty($profile_details)) {
                               
                                $profileUrl = base_url('techpreneurs/details/' . $profile_details->id . '-' . url_title($profile_details->name, '-', TRUE));
                            } elseif (!empty($startup_profile)) {
                               
                                $profileUrl = base_url('startups/details/' . $startup_profile->id);
                            } else {
                                $profileUrl = base_url('techpreneurs/create_account/');
                            }
                            ?>
                           
                            <a class="dropdown-item" href="<?= $profileUrl; ?>">
                                <i class="mdi mdi-account-circle font-size-17 text-muted align-middle me-1"></i>Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="<?= base_url('login/logout'); ?>">
                                <i class="mdi mdi-power font-size-17 text-muted align-middle me-1 text-danger"></i>Logout
                            </a>
                        </div>


                    </div>
                </div>
            <?php else: ?>
                <div class="login">
                    <a href="<?=  base_url('login/getlogin');?>" class="">LOGIN</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="user-account">

            </div>
            <div class="burger-icon burger-icon-white">

            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="perfect-scroll">
                <div class="mobile-menu-wrap mobile-header-border">
                    <!-- <mobile menu start -->
                    <nav>
                        <ul class="mobile-menu font-heading">
                            <li class="has-children">
                                <a class="active" href="<?= base_url('techpreneurs'); ?>">Techpreneurs</a>
                            </li>
                            <li class="has-children">
                                <a class="active" href="<?= base_url('startups'); ?>">Startups</a>
                            </li>
                            <li class="has-children">
                                <a class="active" href="<?= base_url('events'); ?>">Events</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End header-->