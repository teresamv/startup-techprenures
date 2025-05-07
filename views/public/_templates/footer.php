</main>
    <!-- End Content --><footer class="footer mt-50">
        <div class="container">
            <div class="footer-bottom mt-50">
                <div class="row">
                    <div class="col-md-6">
                        Copyright ©2024 <a href="#"></a>All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>
 <script src="<?= base_url('assets/frontend_assets/js/vendor/jquery-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend_assets/js/vendor/jquery-migrate-3.3.0.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend_assets/js/vendor/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend_assets/js/vendor/modernizr-3.6.0.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend_assets/js/plugins/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend_assets/js/plugins/select2.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend_assets/js/plugins/scrollup.js') ?>"></script>
<script src="<?= base_url('assets/frontend_assets/js/main.js?v=1.0') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


<script>
  var site_url = '<?= base_url(); ?>';
  var startup_names = <?= json_encode(($startups_names));?>;
</script>
<script src="<?= base_url('assets/frontend_assets/js/custom.js?v=' . filemtime(FCPATH . 'assets/frontend_assets/js/custom.js')) ?>"></script>

</body>
</html>