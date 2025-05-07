
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
                                
                                   <input type="text" id="country" name="country" value="<?= $startup_details->country;  ?>">
                               
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
                    <div class="buttons-filter startup-border-btn mt-15">
                     <button type="button"  class="btn btn-default float-right" id="update_startup">Update</button>                
                  </div>
                    </form>
                </div>