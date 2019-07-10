

        <!-- Start Footer bottom Area -->
        <footer class="footer-3">
            <div class="footer-area" style="background: #071333;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="footer-content">
                                <div class="footer-head">
                                    <div class="footer-logo">
                                    	<a href="#"><img src="<?=$logo;?>" style="height: 150px;" alt=""></a>
                                    </div>
                                    <p>
                                        Are you looking for professional advice? Then, you are the right place.
                                    </p>
                                    
                                </div>
                            </div>
                        </div>
                        <!-- end single footer -->
                        <div class="col-md-4">
                            <div class="footer-content">
                                <div class="footer-head">
                                    <h4>Services Link</h4>
                                    <ul class="footer-list">
                                          <?php foreach ($menu as $item):?>
                                            <li><a  href="<?=$item['link'];?>"><?=$item['menu'];?></a></li>
                                         <?php endforeach;?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- end single footer -->
                      <!--   <div class="col-md-2 hidden-sm col-xs-12">
                            <div class="footer-content">
                                <div class="footer-head">
                                    <h4>Tags</h4>
                                    <ul class="footer-tags">
                                        <li><a href="#">Industry </a></li>
                                        <li><a href="#">Tax</a></li>
                                        <li><a href="#">Planning</a></li>
                                        <li><a href="#">Online</a></li>
                                        <li><a href="#">Consulting</a></li>
                                        <li><a href="#">Maketing</a></li>
                                        <li><a href="#">Expert</a></li>
                                        <li><a href="#">Consulting</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> -->
                        <!-- end single footer -->
                 

<style>
    .socials > a{

    font-size: 20px;
    border: 1px solid white;
    padding: 10px 18px;
    margin: 5px;
    display: inline;
    color: #5cb85c;
    }
</style>
                        <div class="col-md-4">
                            <div class="footer-content last-content">
                                <div class="footer-head socials">
                                    <h4>Services link</h4>
                                    <ul class="footer-list">
                                                           
                                        <li><a href="<?=domain;?>/login">Sign in</a></li>
                                        <li><a href="<?=domain;?>/register">Sign up</a></li>
                                    </ul>


                                    <div class="subs-feilds">
                                        <div class="suscribe-input">
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-area-bottom" style="background: #071333;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright text-center">
                                <p>
                                    Copyright © <?=date("Y");?>
                                    <a href="<?=domain;?>"><?=project_name;?></a> All Rights Reserved.
                                   <small class="pull-">Developed By <a target="_blank" href="http://gitstardigital.com" >Gitstar Digital</a> </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
		
		<!-- all js here -->

		<!-- jquery latest version -->
		<script src="<?=$this_folder;?>/js/vendor/jquery-1.12.4.min.js"></script>
		<!-- bootstrap js -->
		<script src="<?=$this_folder;?>/js/bootstrap.min.js"></script>
		<!-- owl.carousel js -->
		<script src="<?=$this_folder;?>/js/owl.carousel.min.js"></script>
		<!-- Counter js -->
		<script src="<?=$this_folder;?>/js/jquery.counterup.min.js"></script>
		<!-- waypoint js -->
		<script src="<?=$this_folder;?>/js/waypoints.js"></script>
        <!-- stellar js -->
        <script src="<?=$this_folder;?>/js/jquery.stellar.min.js"></script>
        <!-- Chart JS -->
        <script src="<?=$this_folder;?>/js/Chart.bundle.min.js"></script>
        <script src="<?=$this_folder;?>/js/Chart.js"></script>
		<!-- magnific js -->
        <script src="<?=$this_folder;?>/js/magnific.min.js"></script>
		<!-- venobox js -->
		<script src="<?=$this_folder;?>/js/venobox.min.js"></script>
        <!-- meanmenu js -->
        <script src="<?=$this_folder;?>/js/jquery.meanmenu.js"></script>
		<!-- Form validator js -->
		<script src="<?=$this_folder;?>/js/form-validator.min.js"></script>
		<!-- plugins js -->
		<script src="<?=$this_folder;?>/js/plugins.js"></script>
		<!-- main js -->
		<script src="<?=$this_folder;?>/js/main.js"></script>
	</body>

</html>