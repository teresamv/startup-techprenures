<style type="text/css">
    .content-div {
    display: none;
}

</style>
<script type="text/javascript">

function showContent(id) {
    $('#typeof_doc').val(id);
    $("input[type='file']").attr("id", id);
    $("input[type='file']").attr('name', id);
    $('#type_doc_lbl').text("Select "+id);
    $('#doc_upload').attr("onClick", "add_startup_docs('"+id+"')");

}
</script>  
<div class="startup breadcrumbs_text">
    <div class="container">
        <ul class="breadcrumbs">
        </ul>
    </div>
</div>

<section class="section-box">
    <div class="box-head-single box-head-single-candidate">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-12 col-sm-12 col-12"></div>
                <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                    <div class="heading-image-rd cus-header-img">
                        <?php if ($startup_details->logo_src) { ?>
                            <div class="img-band-sequre"><img alt="startup" src="<?= base_url($startup_details->logo_src) ?>" /></div>
                        <?php } else { ?>
                            <div class="img-band-sequre"><img alt="startup" src="<?= base_url('assets/frontend_assets/imgs/avatar/no_profile.png') ?>" /></div>
                        <?php } ?>
                    </div>
                    <div class="heading-main-info">
                        <div class="top-details-cus-band">
                            <div class="left-band">
                                <span class="text-small mr-20"></i> <?= $startup_details->stage ?></span>
                                <h4><?= $startup_details->name ?></h4>
                            </div>

                            <div class="right-band">
                                <div class="col-lg mt-15 btn-cus-group d-flex justify-content-end align-items-center">
                                    <?php
                          
                                    $show_buttons = false;
                                    if (isset($attende_details)&& is_array($attende_details)) {
                                      
                                         foreach ($attende_details as $attendee) {
                                            if (($startup_details->id == $attendee->startup_id)&&($attendee->login_id != 0)) {
                                                $show_buttons = true;
                                                break;
                                            }
                                        }
                                       }
                                      if ($show_buttons) { ?>
                                       <a style="cursor:pointer" class="edit-profile-link" href="<?= base_url('startups/edit_startup/' . $startup_details->id); ?>">
                                        <img alt="startup" src="<?= base_url('assets/frontend_assets/imgs/avatar/edit-line.svg') ?>" />
                                      </a>


                                        <!-- <a href="" class="delete-btn">
                                            <img alt="startup" src="<?= base_url('assets/frontend_assets/imgs/avatar/trash.svg') ?>" />
                                        </a> -->
                                    <?php } ?>
                                   <?php if ($social_details) { ?>
                                        <?php foreach ($social_details as $key => $value) { ?>
                                            <?php if ($value->link === "Pitch deck") { ?>
                                                <a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_pitch" class="btn btn-default ml-2" download>Download Pitch Deck</a>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                    <a href="#editModel" value="" id="add_startup" class="btn btn-default ml-2" data-bs-toggle="modal" data-bs-target="#editModel" data-section="experience" >Add Startup</a>
                                </div>
                            </div>
                        </div>


                        <p class="mt-0 mb-20"><?= $startup_details->description ?></p>
                        <div class="head-info-profile mb-10" id="country_div">
                            <span class="text-small mr-5"> <i class="fi-rr-flag text-mutted"></i> <?= $startup_details->country ?></span>
                        </div>
                        <div class="head-info-profile mb-10" id="sector_div">
                            <span class="text-small mr-5"><i class="fi-rr-briefcase text-mutted"></i> <?= $startup_details->sector ?></span>
                        </div>
                        <div class="head-info-profile mb-10">
                            <span class="text-small mr-5"><i class="fi-rr-marker text-mutted"></i> <?= $startup_details->booth ?></span>
                        </div>
                    </div>
                    <div class="align-items-end">
                    <div class="col-lg social-band-cus">
                <?php if (isset($social_details) && $social_details) {
                    foreach ($social_details as $detail) {
                        $icon_url = '';
                    if ($detail->icon_id != 0 && isset($icon_details)) {
                            foreach ($icon_details as $icon) {
                                if ($detail->icon_id == $icon->id) {
                                    $icon_url = base_url($icon->icon);
                                    break; 
                                }
                            }
                        }

                if ($detail->icon_id == 0 && !empty($detail->icon_image)) {
                    $icon_url = base_url($detail->icon_image);
                }
                if (!empty($icon_url) && !empty($detail->link_href)) {
                     ?>
                    <a href="<?= htmlspecialchars($detail->link_href) ?>" target="_blank" class="btn btn-tags-sm mb-10 mr-5">
                        <img src="<?= htmlspecialchars($icon_url) ?>" alt="<?= htmlspecialchars($detail->link) ?>" style="width: 30px; height: 30px;">
                        <span style="vertical-align: middle;"></span>
                    </a>
                    <?php
                       }
                        }
                    } ?>
            </div>
            </div>
            </div>
                <div class="col-lg-2 col-md-12 col-sm-12 col-12"></div>
            </div>
        </div>
    </div>
</section>

<section class="section-box mt-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-12 col-sm-12 col-12"></div>
            <div class="col-lg-8 col-md-12 col-sm-12 col-12 row">
                   <?php if ($attende_details) {
                    foreach ($attende_details as $key => $details) { ?>
                        <div class="col-lg-4 col-md-6">
                            <a href="<?= base_url('techpreneurs/details/' . $details->id . '-' . url_title($details->name, '-', TRUE)); ?>">
                                <div class="card-grid-2 hover-up">
                                    <div class="text-center card-grid-2-image-rd">
                                        <?php if ($details->profile_image_download_path) { ?>
                                            <figure><img alt="startup" src="<?= base_url($details->profile_image_download_path) ?>" /></figure>
                                        <?php } else { ?>
                                            <figure><img alt="startup" src="<?= base_url('assets/frontend_assets/imgs/avatar/no_profile.png') ?>" /></figure>
                                        <?php } ?>
                                    </div>
                                    <div class="card-block-info">
                                        <div class="card-profile">
                                            <strong><?= $details->name ?></strong>
                                            <span class="text-sm"><?= $details->position ?></span>
                                        </div>
                                        <div class="employers-info d-flex align-items-center justify-content-center mt-15">
                                            <span class="d-flex align-items-center"><i class="fi-rr-marker mr-5 ml-0"></i> <?= $details->country ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                <?php }
                } ?>
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12 col-12">

            </div>
        </div>
    </div>
</section>
    <?php   $financial_statement    =   0;
            $tax_return             =   0;
            $revenue_expense        =   0;
            $funding_history        =   0;
            $cash_flow_statement    =   0;

            $corporate  =   0;
            $intellectual_property =0;
            $compliance = 0;
            $legal_contracts = 0;

            $business_model = 0;
            $cac_and_cltv = 0;
            $unit_economics = 0;
            $key_performance_indicators = 0;

            $team_members = 0;
            $organizational_structure = 0;
            $equity_structure = 0;
            ?>
                        
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="job-overview">
                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <div class="sidebar-icon-item"><i class="fi-rr-briefcase"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Financial Data </span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "financial_statement_doc") { ?>
                                                    
                                                    <strong class="small-heading" class="btn btn-default ml-2" ><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_financial" download>Financial Statements</a></strong>
                                                <?php $financial_statement++; 
                                            }
                                            else{

                                            } ?>
                                            <?php } ?>
                                        <?php } if($financial_statement == 0){ ?>
                                            
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('financial_statement_doc')">Financial Statements</strong>
                                        <?php }?>

                                        
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><i class="fi-rr-marker"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Financial Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "tax_return_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2" ><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_tax_returns" download>Tax Returns</a></strong>
                                                <?php $tax_return++;
                                            }else{

                                            } ?>
                                            <?php } ?>
                                        
                                        <?php } 
                                        if($tax_return == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('tax_return_doc')">Tax Returns</strong>
                                        <?php }?>

                                    </div>
                                </div>
                                <div class="col-md-4 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><i class="fi-rr-dollar"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Financial Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "revenue_expense_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_revenue_expense" download>Revenue and Expense Forecasts</a></strong>
                                                <?php $revenue_expense++; 
                                                } else {
                                                 ?>
                                            
                                        <?php } ?>
                                            <?php } ?>
                                        <?php }

                                        if($revenue_expense == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('revenue_expense_doc')">Revenue and Expense Forecasts</strong>
                                        <?php }?>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-30">
                                <div class="col-md-4 d-flex">
                                    <div class="sidebar-icon-item"><i class="fi-rr-clock"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Financial Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "funding_history_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_funding_history" download>Funding History</a></strong>

                                                <?php $funding_history++; 
                                                }
                                                else { 
                                            
                                                } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if($funding_history ==0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('funding_history_doc')">Funding History</strong>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><i class="fi-rr-time-fast"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Financial Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "cash_flow_statement_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_cash_flow_statement" download>Cash Flow Statement</a></strong>
                                                <?php $cash_flow_statement++; 
                                            } else {
                                                 ?>
                                            
                                        <?php } ?>
                                            <?php } ?>
                                        <?php }
                                        if($cash_flow_statement ==0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('cash_flow_statement_doc')">Cash Flow Statement</strong>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-10 mx-auto">
                        <div class="job-overview">
                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <div class="sidebar-icon-item"><i class="fi-rr-briefcase"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Legal and Regulatory Data </span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "corporate_doc") { ?>
                                                    
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_corporate_doc" download>Corporate Documents</a></strong>
                                                <?php $corporate++; 
                                            }
                                            else{

                                            } ?>
                                            <?php } ?>
                                        <?php } if($corporate == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('corporate_doc')">Corporate Documents</strong>
                                        <?php }?>

                                        
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><i class="fi-rr-marker"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Legal and Regulatory Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "intellectual_property_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_intellectual_property_doc"download>Intellectual Property</a></strong>
                                                <?php $intellectual_property++;
                                            }else{

                                            } ?>
                                            <?php } ?>
                                        
                                        <?php } 
                                        if($intellectual_property == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('intellectual_property_doc')">Intellectual Property</strong>
                                        <?php }?>

                                    </div>
                                </div>
                                <div class="col-md-4 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><i class="fi-rr-dollar"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Legal and Regulatory Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "legal_contracts_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_legal_contracts" cdownload>Legal Contracts</a></strong>
                                                <?php $legal_contracts++; 
                                                } else {
                                                 ?>
                                            
                                        <?php } ?>
                                            <?php } ?>
                                        <?php }

                                        if($legal_contracts == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('legal_contracts_doc')">Legal Contracts</strong>
                                        <?php }?>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-30">
                                <div class="col-md-4 d-flex">
                                    <div class="sidebar-icon-item"><i class="fi-rr-clock"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Legal and Regulatory Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "compliance_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_compliance_doc" download>Compliance</a></strong>
                                                <?php $compliance++; 
                                                }
                                                else { 
                                            
                                                } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if($compliance ==0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('compliance_doc')">Compliance</strong>
                                        <?php }?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-10 mx-auto">
                        <div class="job-overview">
                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <div class="sidebar-icon-item"><i class="fi-rr-briefcase"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Operational Data </span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "business_model_doc") { ?>
                                                    
                                                    <strong class="small-heading" class="btn btn-default ml-2" ><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_business_model" download>Business Model</a></strong>
                                                <?php $business_model++; 
                                            }
                                            else{

                                            } ?>
                                            <?php } ?>
                                        <?php } if($business_model == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('business_model_doc')">Business Model</strong>
                                        <?php }?>

                                        
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><i class="fi-rr-marker"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Operational Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "cac_and_cltv_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_cac_and_cltv_doc" download>Customer Acquisition Cost (CAC) and Customer Lifetime Value (CLTV)</a></strong>
                                                <?php $cac_and_cltv++;
                                            }else{

                                            } ?>
                                            <?php } ?>
                                        
                                        <?php } 
                                        if($cac_and_cltv == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('cac_and_cltv_doc')">Customer Acquisition Cost (CAC) and Customer Lifetime Value (CLTV)</strong>
                                        <?php }?>

                                    </div>
                                </div>
                                <div class="col-md-4 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><i class="fi-rr-dollar"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Operational Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "unit_economics_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_unit_economics" download>Unit Economics</a></strong>
                                                <?php $unit_economics++; 
                                                } else {
                                                 ?>
                                            
                                        <?php } ?>
                                            <?php } ?>
                                        <?php }

                                        if($unit_economics == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('unit_economics_doc')">Unit Economics</strong>
                                        <?php }?>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-30">
                                <div class="col-md-4 d-flex">
                                    <div class="sidebar-icon-item"><i class="fi-rr-clock"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Operational Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "key_performance_indicators_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_key_performance_indicators" download>Key Performance Indicators (KPIs)</a></strong>
                                                <?php $key_performance_indicators++; 
                                                }
                                                else { 
                                            
                                                } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if($key_performance_indicators ==0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('key_performance_indicators_doc')">Key Performance Indicators (KPIs)</strong>
                                        <?php }?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-10 mx-auto">
                        <div class="job-overview">
                            <div class="row">
                                <div class="col-md-4 d-flex">
                                    <div class="sidebar-icon-item"><i class="fi-rr-briefcase"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Team and Management Data </span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "team_members_doc") { ?>
                                                    
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_team_members" download>Team Members</a></strong>
                                                <?php $team_members++; 
                                            }
                                            else{

                                            } ?>
                                            <?php } ?>
                                        <?php } if($team_members == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('team_members_doc')">Team Members</strong>
                                        <?php }?>

                                        
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><i class="fi-rr-marker"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Team and Management Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "organizational_structure_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2"><a href="<?= base_url($value->file)?>" target="_blank" value="<?= $startup_details->id ?>" id="download_organizational_structure" download>Organizational Structure</a></strong>
                                                <?php $organizational_structure++;
                                            }else{

                                            } ?>
                                            <?php } ?>
                                        
                                        <?php } 
                                        if($organizational_structure == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('organizational_structure_doc')">Organizational Structure</strong>
                                        <?php }?>

                                    </div>
                                </div>
                                <div class="col-md-4 d-flex mt-sm-15">
                                    <div class="sidebar-icon-item"><i class="fi-rr-dollar"></i></div>
                                    <div class="sidebar-text-info ml-10">
                                        <span class="text-description mb-10">Team and Management Data</span>
                                        <?php if ($social_details) { ?>
                                            <?php foreach ($social_details as $key => $value) { ?>
                                                <?php if ($value->link === "equity_structure_doc") { ?>
                                                    <strong class="small-heading" class="btn btn-default ml-2" ><a href="<?= base_url($value->file) ?>" target="_blank" value="<?= $startup_details->id ?>" id="download_equity_structure" download>Equity Structure</a></strong>
                                                <?php $equity_structure++; 
                                                } else {
                                                 ?>
                                            
                                        <?php } ?>
                                            <?php } ?>
                                        <?php }

                                        if($equity_structure == 0){ ?>
                                            <strong class="btn btn-small background-6 disc-btn" href="#UploadModal" value="" id="add_startup" data-bs-toggle="modal" data-bs-target="#UploadModal" data-section="experience"onclick="showContent('equity_structure_doc')">Equity Structure</strong>
                                        <?php }?>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
                            
    </div>
</form> 

<!--Listing corresponding startup category and investment focus category based on fundings-->

    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-10 col-md-12 col-sm-12 col-12 mx-auto">
                <div class="content-page">
                    <div class="row">
                        <?php if ($funding_list) { ?>
                        <div class="col-md-12">
                            <h5><strong>The most related fundings here for you!</strong></h5>
                        </div>
                        
                        <?php foreach ($funding_list as $key => $value) { ?>
                            <div class="col-lg-4 col-md-6">
                                <a href="<?=base_url('fundings/details/' . $value->id. '-' . url_title($value->name, '-', TRUE));?>">
                                    <div class="card-grid-2 card-employers hover-up wow animate__animated animate__fadeIn fundings_band">
                                        <div class="card-block-info">
                                            <div class="card-profile">
                                                <h5><strong><?=$value->name?></strong></h5>
                                                <span class="text-sm"><?=$value->investment_focus_category?></span>
                                            </div>
                                            <div class="mt-15">
                                                <div class="text-center align-items-center">
                                                    <i class="fi-rr-marker mr-5"></i> <?=$value->location?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php }?> 
                    <div class="col-md-12">
                            <h5><a href="<?= base_url('fundings?search=' . $startup_details->sector); ?>"><strong>For more fundings</strong></a></h5>
                    </div><?php 
                }   else {?>
                        <div class="col-md-12">
                            <h5><strong>No fundings found...</strong></h5>
                        </div>
                    <?php }?>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>




<!--modal popup for upload document starts here-->
<div class="modal fade user-profile-model" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="UploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UploadModalLabel">Startups Document upload</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container ">
                    <form method="post" id="adddocstartupForm" enctype="multipart/form-data">
                        <div class="form-group-band">
                            <div class="form-group-band">
                                <input type="hidden" id="" name="id" value="<?php //echo "6"; ?>">
                                <input type="hidden" id="typeof_doc" name="typeof_doc" value="">
                                <input type="hidden" id="startup_id" name="startup_id" value="<?php echo $startup_details->id; ?>">
                                <label id="type_doc_lbl"></label>
                                <input type="file" class="form-control" id="" name="">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="doc_upload" onclick='' class="btn btn-default float-right mt-5">Upload Document</button>
            </div>
        </div>
    </div>
</div>
<!--end code added by Sonia-->
             
<div class="modal fade user-profile-model" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModelLabel">Edit Startups</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                  <form method="post" id="editform" enctype="multipart/form-data">
                        <div class="Upload-logo-band">
                            <div class="circle">
                                <img class="profile-pic" name="profile" src="<?= base_url($startup_details->logo_src); ?>">
                            </div>
                            <div class="p-image">
                                <a href="javascript:void(0)" class="upload-btn upload-button">Update Profile</a>
                                <input class="file-upload"  name="profile_image" type="file" accept="image/*" />
                            </div>
                            <input type="hidden" name="id" value="<?php echo $startup_details->id;?>">
                        </div>
                        <div class="form-group-band">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" value="<?= htmlspecialchars($startup_details->name ?? ''); ?>">
                             <div id="nameError" class="error-message" style="color:red;"></div>

                        </div>
                        <div class="form-group-band">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description"><?= htmlspecialchars($startup_details->description ?? ''); ?></textarea>
                        </div>
                        <div class="form-group-band">
                        <div class="form-group">
                        <label for="stage">Stage:</label>
                        <select class="form-control select2" id="stage" name="stage" placeholder="Select stage">
                            <?php 
                            $stage_options = ['Select stage', 'Growth', 'Expansion', 'Early', 'Maturity', 'Exit'];
                            foreach ($stage_options as $option) : ?>
                                <option value="<?= htmlspecialchars($option); ?>" <?= (isset($startup_details->stage) && $startup_details->stage == $option) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($option); ?>
                                </option>
                            <?php endforeach; ?>
                          </select>
                            </div>

                            <div class="form-group mr-cus-0">
                                <label for="country">Country:</label>
                                <select class="form-control select2" id="country" name="country">
                                    <?php foreach ($country_names as $country) : ?>
                                        <option value="<?= htmlspecialchars($country->country); ?>" <?= (isset($startup_details->country) && $startup_details->country == $country->country) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($country->country); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="sector">Sector:</label>
                                <select class="form-control select2" id="sector" name="sector">
                                    <?php foreach ($sector_names as $sector) : ?>
                                        <option value="<?= htmlspecialchars($sector->sector); ?>" <?= (isset($startup_details->sector) && $startup_details->sector == $sector->sector) ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($sector->sector); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                    <div class="form-group mr-cus-0">
                                    <label for="booth">Booth:</label>
                                    <select class="form-control select2" id="booth" name="booth">
                                        <?php 
                                        $booth_options = ['Select booth', 'B2C', 'B2B', 'Marketplace', 'D2C'];
                                        foreach ($booth_options as $option) : ?>
                                            <option value="<?= htmlspecialchars($option); ?>" <?= (isset($startup_details->booth) && $startup_details->booth == $option) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($option); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group-band">
                                <label for="pitchdeck">Select Pitchdeck document</label>
                                <input type="file" class="form-control" id="pitchdeck_doc" name="pitchdeck">
                                </div>
                        </div>

                        <div class="soical-head-band">
                            <h4 class="model-soical-head">Social Details</h4>
                            <button type="button" id="add-new-link" class="icon-btn"> <img src="<?= base_url('assets/frontend_assets/imgs/avatar/add-circle.svg') ?>" /> Add Link</button>
                        </div>
                        <div id="social-links-container" class="social_details">
    
                        <?php foreach ($social_details as $social): ?>
                            <?php if (!empty($social->link_href) && strtolower($social->link) !== 'pitch deck'): ?>
                                <div class="social-link" data-id="<?php echo $social->id; ?>">
                                    <img src="<?= base_url($social->icon_image ?: 'uploads/default_icon.png'); ?>" alt="<?= htmlspecialchars($social->link); ?>">
                                    <input type="hidden" name="" value="">
                                    <input type="hidden" name="" value="">
                                    <input type="text" class="form-control" placeholder="<?= htmlspecialchars($social->link); ?>" name="<?= htmlspecialchars($social->link); ?>" id="<?= htmlspecialchars($social->link); ?>" value="<?= htmlspecialchars($social->link_href); ?>">
                                    <div class="error-message" style="color:red;" id="<?= htmlspecialchars($social->link); ?>-error"></div>
                                    <button type="button" id="remove_social" value="<?php echo $social->id ?>" class="btn-close close-icon-band" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </div>
                        <div id="additional-links-container"></div>
                        <div>
                    </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="update_startup" class="btn btn-default float-right mt-5">Update</button>
            </div>
        </div>
    </div>
</div>