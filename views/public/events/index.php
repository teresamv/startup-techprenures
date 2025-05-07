
<div class="container mt-3">
        <?php if ($this->session->flashdata('message') !== null): ?>
            <?php
                $message = $this->session->flashdata('message');
                $alert_class = $message[0] == 1 ? 'alert-success' : 'alert-danger';
            ?>
            <div class="alert <?php echo $alert_class; ?> alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           
                <?php echo $message[1]; ?>
            </div>
        <?php endif; ?>

        <!-- Your form and other content here -->
    </div>

    <section class="section-box-2">
    <div class="box-head-single cus-top-box none-bg">
        <div class="container">
            <div class="cus-top-header-band">
            <h4>Events</h4>
            <div class="right-band">
            <div class="widget_search ">
                    <div class="search-form">
                        <form action="<?php echo current_url(); ?>" method="post" id="location-filter-form">
                            
                            <select id="event-location" name="location" class="form-control" style="width:100%;" onchange="submitLocationForm()">
                               <option value="">Select Location</option>
                               <?php foreach ($locations as $location):?>
                                    <option value="<?= $location ?>" <?= ($selectedLocation === $location) ? 'selected' : '' ?>><?= $location ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button"><i class="fi-rr-search"></i></button>
                        </form>
                       
                    </div>
                </div>
                <div class="post-event-btn">
                         <a href="" type="button" class="view_more" id="add_post" data-bs-toggle="modal" data-bs-target="#postModal">Post your Event</a>
                         </div>
            </div>
            </div>
            
            
        </div>
    </div>
</section>
<?php if(empty($events)): ?>
    <section class="section-box mt-40">
          <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="empty-states-band">
                        <div class="img-band">
                            <img src="<?php echo base_url('assets/images/Event-Empty-States.png'); ?>">
                        </div>
                        <div class="text-band">
                            <h4>No Event Available</h4>
                            <p>There are currently no events scheduled at this time. Please check back later or explore other sections of our site for updates and upcoming events.</p>
                        </div>
                    </div>
                </divZ>
            </div>
          </div>
        </section>
      <?php  endif  ?>

    <div class="post-loop-grid mt-3">
    <div class="container">
        <div class="row">
              <div class="post-listing event-list-band">
                  <div class="row">
                  <?php
                    $displayedTodayLabel = false; 

                    foreach ($events as $event) {
                        
                    ?>
                    <div class="col-md-6">
                         <?php
                         $isToday = ($event->Date === $currentDate);
                         if ($isToday && !$displayedTodayLabel) {
                             
                             echo '<span class="date mt-3">Today ' . $currentDay . '</span>';
                             $displayedTodayLabel = true; 
                         } elseif (!$isToday) {
                             echo '<span class="date mt-3">' . $event->Date . ' ' . $event->Day . '</span>';
                         }
                         ?>
                        <div class="card-blog-1 mb-30 post-list event-card-band  hover-up wow animate__animated animate__fadeIn" data-wow-delay=".0s" >
                            <div class="post-thumb">
                                <a href="<?php echo $event->Link; ?>">
                                    <img alt="event" src="<?php echo $event->Image; ?>" />
                                </a>
                            </div>
                            <div class="card-block-info">
                                <p class="event-time"><?php echo $event->Time; ?></p>
                                <h3 class="post-title event-titile ">
                                    <a href="<?php echo $event->Link; ?>" target="_blank"><?php echo $event->Title; ?></a>
                                </h3>
                                <div class="post-meta event-p-text text-muted d-flex align-items-center">
                                    <div class="author d-flex align-items-center mr-30">
                                        <span><?php echo $event->Organizer; ?></span>
                                    </div>
                                </div>
                                <p class="post-excerpt event-address text-muted d-none d-lg-block event-location-link" data-location="<?php echo $event->Location; ?>"     style="cursor:pointer;">
                                    <?php echo $event->Location; ?>
                                </p>
                                <p class="post-excerpt event-price text-muted d-none d-lg-block">
                                    <?php echo $event->Price; ?>
                                </p>
                             </div>
                            
                        </div>
                   
                    </div>
                    <?php } ?>
                  </div>
                </div>
          
         </div>
    </div>
</div>
<div class="modal scrollspy-model create-event-model fade" id="postModal" tabindex="-1"  overflow= "auto" aria-labelledby="postModalLabel" aria-hidden="true" data-backdrop="true">
<div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postModalLabel">Create Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addForm" method="post" action="<?php echo base_url('events/create_event'); ?>" enctype="multipart/form-data">
                <input type="hidden" id="eventId" name="id">
             <div class="profile-edit-content">
             <div class="form-group-band">
                        <label for="eventTitle">Title</label>
                        <input type="text" class="form-control" id="eventTitle" name="title" required>
                    </div>
                    <!-- Add other fields as needed -->
                    <div class="form-group-band">
                        <label for="eventOrganizer">Organizer</label>
                        <input type="text" class="form-control" id="eventOrganizer" name="organizer">
                    </div>
                    <div class="form-group-band">
                        <label for="eventLocation"> Event Location</label>
                        <input type="text" class="form-control" id="eventLocation" name="location" required>
                    </div>
                    <div class="form-group-band">
                        <label for="eventLink"> EventLink</label>
                        <input type="text" class="form-control" id="eventLink" name="link">
                    </div>
                    <div class="form-group-band">
                        <label for="eventLink">Event Image</label>
                        <input type="file" class="form-control" id="image" name="event_image">
                    </div>
                    <div class="form-group-band">
                        <label for="eventPrice">Price</label>
                        <input type="text" class="form-control" id="eventPrice" name="price">
                    </div>
                    <div class="form-group-band">
                        <label for="eventDay">Day</label>
                        <input type="text" class="form-control" id="eventDay" name="day">
                    </div>
                    <div class="form-group-band">
                        <label for="eventDate">Date</label>
                        <input type="text" class="form-control" id="eventDate" name="date">
                    </div>
                    <div class="form-group-band">
                        <label for="eventTime">Time</label>
                        <input type="text" class="form-control" id="eventTime" name="time">
                    </div>
             </div>
             <div class="fotter-model-band">
                    <button type="submit" id="add_btn" class="create-btn">Create</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
