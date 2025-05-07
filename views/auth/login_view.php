<div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="card-body pt-0">
                            <h3 class="text-center mt-5 mb-4">
                                <a href="" class="d-block auth-logo">
                                   
                                </a>
                            </h3>
                            <?php if ($this->session->flashdata('message') !== null) {?>
                            <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close">×</button>
                                <?php print_r($this->session->flashdata('message')['1']);?>
                            </div>
                            <?php }?>
                            <div class="p-3">
                                <!-- <p class="text-muted text-center">Login in to Hey Logistic.</p> -->
                                       <form action ="<?= base_url('login/getlogin');?>" method="post">
                                        <div class="mb-3">
                                        <label for="Name">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="userpassword">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="text-center">
                                            <button class="btn btn-primary w-md waves-effect waves-light"
                                                type="" id="linkedin-login">Login with linkedin</button>
                                        </div>
                                    </div>
                                    
                            </form>          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
