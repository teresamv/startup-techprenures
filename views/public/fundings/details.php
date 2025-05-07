<section class="section-box">
    <div class="box-head-single box-head-single-candidate funding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                    <div class="heading-main-info">
                        <div class="top-details-cus-band">
                            <div class="left-band">
                                <span class="text-small mr-20"> <?= $fundings_details->stage ?></span>
                                <h4><?= $fundings_details->name ?></h4>
                            </div>
                        </div>
                        <?php if ($fundings_details->details) { ?>
                            <p class="mt-0 mb-20"><?= $fundings_details->details ?></p>
                        <?php } ?>
                        <?php if ($fundings_details->investor_name) { ?>
                            <div class="head-info-profile mb-10">
                                <span class="text-small mr-5"> <i class="fi-rr-user text-mutted"></i> <?= $fundings_details->investor_name ?></span>
                            </div>
                        <?php } ?>
                        <?php if ($fundings_details->investment_focus_category) { ?>
                            <div class="head-info-profile mb-10" id="sector_div_fund">
                                <span class="text-small mr-5"><i class="fi-rr-briefcase text-mutted"></i> <?= $fundings_details->investment_focus_category ?></span>
                            </div>
                        <?php } ?>
                        <?php if ($fundings_details->lead) { ?>
                            <div class="head-info-profile mb-10">
                                <span class="text-small mr-5"><i class="fi-rr-arrow-right text-mutted"></i> <?= $fundings_details->lead ?></span>
                            </div>
                        <?php } ?>
                        <?php if ($fundings_details->event_at) { ?>
                            <div class="head-info-profile mb-10">
                                <span class="text-small mr-5"><i class="fi-rr-calendar text-mutted"></i> <?= $fundings_details->event_at ?></span>
                            </div>
                        <?php } ?>
                        <?php if ($fundings_details->location) { ?>
                            <div class="head-info-profile mb-10" id="country_div_fund">
                                <span class="text-small mr-5"> <i class="fi-rr-marker text-mutted"></i> <?= $fundings_details->location ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="align-items-end fund">
                        <div class="col-lg social-band-cus">
                            <?php if (($fundings_details->linkedin_link && $fundings_details->linkedin_link != '-')) { ?>
                                <a href="<?= $fundings_details->linkedin_link ;?>" target="_blank" class="btn btn-tags-sm mb-10 mr-5">
                                    <img src="<?= base_url('uploads/social_icon/linkedin.png') ?>" alt="" style="width: 30px; height: 30px;">
                                    <span style="vertical-align: middle;"></span>
                                </a>
                            <?php } ?>
                            <?php if (($fundings_details->website_link && $fundings_details->website_link != '-')) { ?>
                                <a href="<?= $fundings_details->website_link ;?>" target="_blank" class="btn btn-tags-sm mb-10 mr-5">
                                    <img src="<?= base_url('uploads/social_icon/web.png') ?>" alt="" style="width: 30px; height: 30px;">
                                    <span style="vertical-align: middle;"></span>
                                </a>
                            <?php } ?>
                            <?php if (($fundings_details->contact_us_email && $fundings_details->contact_us_email != '-')) { ?>
                                <a href="mailto:<?= $fundings_details->contact_us_email; ?>" class="btn btn-tags-sm mb-10 mr-5">
                                    <img src="<?= base_url('uploads/social_icon/email.png') ?>" alt="Email" style="width: 30px; height: 30px;">
                                    <span style="vertical-align: middle;"></span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-12"></div>
            </div>
        </div>
    </div>
</section>