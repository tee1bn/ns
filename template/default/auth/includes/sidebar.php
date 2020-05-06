  <style>
    .side-avatar{

      height: 60px;
      border-radius: 35px;
      width: 62px;
      object-fit: cover;
    }
    .side-user{

      text-transform: capitalize;
      padding-left: 30px;
      padding-top: 20px;
      font-size: 10px;
    }

    
    .small-padding{
      padding: 10px !important;
    }

    .bordered{
      
    border: 1px solid #00000047;
    }

     .d-box{
    background: #bcd4ff8a;
    color: #0c111c;
    font-size: 20px;
    min-width: 70px;
    padding: 5px;
    padding-top: 10px;
    padding-bottom: 10px;
    display: block;
    text-align: center;
    border-radius: 5px;
    box-shadow: 0 4px 4px 0 rgba(62, 57, 107, 0.48), 0 2px 9px 0 rgba(62,57,107,.06);}
      .b-box{
          margin-top: 5px;
          margin-bottom: 10px;
      }
     
  </style>

   <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

          <li class=" navigation-header">
            <div class="row">
              <div class="col-3">
                  <img class="side-avatar img-round" src="<?=domain;?>/<?=$auth->profilepic;?>" alt=""  >
              </div>
              <div class="col-9 side-user">
                <span><?=$auth->username;?></span>
                <br>
                <br>
                <span><?=$auth->fullname;?> | ID:<?=$auth->id;?></span>
              </div>
            </div>
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

              <li class=" nav-item"><a href="#"><i class="fa fa-briefcase"></i><span class="menu-title" data-i18n="">Packages</span></a>
              <ul class="menu-content">
                  <li><a class="menu-item" href="<?=domain;?>/user/package">All Packages</a>
                  <li><a class="menu-item" href="<?=domain;?>/user/merchant-packages">Merchant Packages</a>
            
                  <li><a class="menu-item" href="<?=domain;?>/user/partner-packages">Partner Packages</a>
                  <li><a class="menu-item" href="<?=domain;?>/user/vp-packages">VP Packages</a>
                  <li><a class="menu-item" href="<?=domain;?>/user/package-orders">Orders</a>
                  </li>
                </ul>
             </li> 



              <li class=" nav-item"><a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n="">My Team</span></a>
              <ul class="menu-content">
                  <li><a class="menu-item" href="<?=domain;?>/genealogy/team">Team</a>
                  <!-- <li><a class="menu-item" href="<?=domain;?>/genealogy/placement_list"> List</a> -->
            
                  <li><a class="menu-item" href="<?=domain;?>/genealogy/team_tree">Team Tree</a>

                  <!-- <li><a class="menu-item" href="<?=domain;?>/genealogy/placement">Tree</a> -->
                  </li>
                </ul>
             </li> 


              <li>
                <a class="menu-item" href="<?=domain;?>/user/vp-remuneration"><i class="ft-align-justify"></i>VP Remuneration</a>
              </li>
<!-- 
              <li>
                <a class="menu-item" href="<?=domain;?>/user/earnings"><i class="ft-star"></i> InvitePro</a>
              </li> -->

              <li>
                <a class="menu-item" href="<?=domain;?>/user/events-and-webinar"><i class="ft-airplay"></i> Events & Webinar</a>
              </li>

              <li>
                <a class="menu-item" href="<?=domain;?>/user/media"><i class="fa fa-film"></i> Media Center</a>
              </li>


              <li>
                <a class="menu-item" href="<?=domain;?>/user/online_shop"><i class="ft-shopping-cart"></i> Online Shop</a>
              </li>

<!-- 
              <li>
                <a class="menu-item" href="<?=domain;?>/user/resources"><i class="fa fa-folder"></i> Documents</a>
              </li> -->

             <!--  <li>
                <a class="menu-item" href="<?=domain;?>/user/withdrawals"><i class="fa fa-credit-card"></i> Withdrawals</a>
              </li>
 -->


            <hr>

            <li class=" nav-item"><a href="#">                
              <i class="fa fa-question-circle-o"></i>
             <span class="menu-title" data-i18n="">Support</span></a>
             <ul class="menu-content">
               <li><a class="menu-item" href="<?=domain;?>/user/support"> Support Tickets</a>
                 <li><a class="menu-item" href="<?=domain;?>/user/contact-us"> Contact us</a>                   
                 </ul> 
               </li>



            <li><a class="menu-item" href="<?=domain;?>/user/broadcast"> <i class="fa fa-file-text-o"></i> News</a></li>
            <hr>

            <li><a class="menu-item" href="<?=domain;?>/login/logout"> <i class="ft-power"></i> Log Out</a></li>

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
