   <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

          <li class=" navigation-header"><span>GENERAL</span><i class="ft-droplet ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="UI"></i>
          </li>          
      
              <li>
                <a class="menu-item" href="<?=domain;?>/user/dashboard"><i class="ft-home"></i> Dashboard</a>
              </li>

            <!--   <li>
              <a class="menu-item" href="<?=domain;?>/user/company"><i class="fa fa-building-o"></i> My Company</a>
            </li> -->

              <li>
                <a class="menu-item" href="<?=domain;?>/user/profile"><i class="ft-user"></i> My Profile
                  <?=$auth->DisplayCompleteProfileStatus;?>
                </a>

              </li>

              <li class=" nav-item"><a href="#"><i class="fa fa-briefcase"></i><span class="menu-title" data-i18n="">Subscriptions</span></a>
              <ul class="menu-content">
                  <li><a class="menu-item" href="<?=domain;?>/user/package"> Packages</a>
            
                  <li><a class="menu-item" href="<?=domain;?>/user/package-orders">Orders</a>
                  </li>
                </ul>
             </li> 



              <li class=" nav-item"><a href="#"><i class="fa fa-sitemap"></i><span class="menu-title" data-i18n="">My Team</span></a>
              <ul class="menu-content">
                  <li><a class="menu-item" href="<?=domain;?>/genealogy/placement_list"> List</a>
            
                  <li><a class="menu-item" href="<?=domain;?>/genealogy/placement">Tree</a>
                  </li>
                </ul>
             </li> 


              <li>
                <a class="menu-item" href="<?=domain;?>/user/earnings"><i class="icon-wallet"></i> Wallet</a>
              </li>


              <li>
                <a class="menu-item" href="<?=domain;?>/user/documents"><i class="fa fa-folder"></i> Documents</a>
              </li>

             <!--  <li>
                <a class="menu-item" href="<?=domain;?>/user/withdrawals"><i class="fa fa-credit-card"></i> Withdrawals</a>
              </li>
 -->


          <li class=" navigation-header"><span>COMMUNICATION</span><i class="ft-droplet ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="UI"></i>
          </li>
              



            <li class=" nav-item"><a href="#">                
              <i class="icon-question"></i>
             <span class="menu-title" data-i18n="">Support</span></a>
             <ul class="menu-content">
               <li><a class="menu-item" href="<?=domain;?>/user/support"> Support Tickets</a>
                 <li><a class="menu-item" href="<?=domain;?>/user/contact-us"> Contact us</a>                   
                 </ul> 
               </li>



            <li><a class="menu-item" href="<?=domain;?>/user/broadcast"> <i class="fa fa-file-text-o"></i> News</a></li>

            <!-- <li><a class="menu-item" href="<?=domain;?>/user/testimony"><i class="fa fa-certificate"></i>Testimonials</a></li> -->

<!-- 
          <li class=" nav-item"><a href="#"><i class="fa fa-certificate"></i><span class="menu-title" data-i18n="">Testimonial</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="content-typography.html">View Testimonials</a>
        
              <li><a class="menu-item" href="content-helper-classes.html">Helper classes</a>
              </li>
            </ul>
          </li> -->
     
        </ul>
      </div>
    </div>
    <!-- END: Main Menu-->
