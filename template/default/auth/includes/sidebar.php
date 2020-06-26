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

    <?php


    $main_menu =  [

      [
        'menu' => '<i class="ft-home"></i> Dashboard',
        'link' =>  "$domain/user/dashboard",
        'show'=> true,
        'index'=> 1,
      ],

      [
        'menu' => "<i class='ft-users'></i>My Profile $auth->DisplayCompleteProfileStatus",
        'link' =>  "$domain/user/profile",
        'show'=> true,
        'index'=> 2,
      ],





      [
        'menu' => '<i class="fa fa-list"></i> Transactions',
        'link' =>  '#',
        'show'=> true,
        'index'=> 3,
        'submenu' => [

          [
            'menu'       => 'Make Withdrawals',
            'link'       => "$domain/user/make-withdrawal",
            'show'=>true,
            'index'=>4,
          ],


          [
            'menu'       => 'Withdrawals',
            'link'       => "$domain/user/withdrawals",
            'show'=>true,
            'index'=>5,
          ],


        ]

      ],


      [
        'menu' => '<i class="fa fa-briefcase"></i> Packages',
        'link' =>  '#',
        'show'=> true,
        'index'=> 6,
        'submenu' => [
          [
            'menu'       => 'All Packages',
            'link'       => "$domain/user/package",
            'show'=>true,
            'index'=>7,
          ],

          [
            'menu'       => 'Merchant Packages',
            'link'       => "$domain/user/merchant-packages",
            'show'=>true,
            'index'=>8,
          ],

          [
            'menu'       => 'Partner Packages',
            'link'       => "$domain/user/partner-packages",
            'show'=>true,
            'index'=>9,
          ],

          [
            'menu'       => 'My Invoices',
            'link'       => "$domain/user/my-invoices",
            'show'=>true,
            'index'=>10,
          ],



        ]                                                    
      ],  




      [
        'menu' => '<i class="ft-users"></i>My Team</span>',
        'link' =>  '#',
        'show'=> true,
        'index'=> 11,
        'submenu' => [
          [
            'menu'       => 'Team Overview',
            'link'       => "$domain/genealogy/team",
            'show'=>true,
            'index'=>12,
          ],

          [
            'menu'       => 'Team Tree',
            'link'       => "$domain/genealogy/team_tree",
            'show'=>true,
            'index'=>13,
          ],





        ]                                                    
      ],  



      [
        'menu' => "<i class='ft-align-justify'></i>Commissions",
        'link' =>  "$domain/user/commissions",
        'show'=> true,
        'index'=> 14,
      ],

      [
        'menu' => "<i class='ft-star'></i>InvitePro",
        'link' =>  "$domain/user/invite-pro",
        'show'=> true,
        'index'=> 15,
      ],

      [
        'menu' => "<i class='ft-airplay'></i>Events & Webinar",
        'link' =>  "$domain/user/events-and-webinar",
        'show'=> true,
        'index'=> 16,
      ],


      [
        'menu' => "<i class='ft-airplay'></i>Events & Webinar",
        'link' =>  "$domain/user/events-and-webinar",
        'show'=> true,
        'index'=> 17,
      ],


      [
        'menu' => "<i class='fa fa-film'></i>Media Center",
        'link' =>  "$domain/user/media",
        'show'=> true,
        'index'=> 18,
      ],


      [
        'menu' => "<i class='ft-shopping-cart'></i>Online Shop",
        'link' =>  "$domain/user/online-shop",
        'show'=> true,
        'index'=> 19,
      ],




      [
       'menu' => '<i class="ft-shopping-cart"></i>Shop</span>',
       'link' =>  '#',
       'show'=> false,
       'index'=> 20,
       'submenu' => [
         [
           'menu'       => 'Online Shop',
           'link'       => "$domain/user/online-shop",
           'show'=>true,
           'index'=>21,
         ],

         [
           'menu'       => 'Orders',
           'link'       => "$domain/user/products-orders",
           'show'=>true,
           'index'=>22,
         ],                                                    

       ]                                                    
     ],  



     [
       'menu' => '<i class="fa fa-question-circle-o"></i>Support</span>',
       'link' =>  '#',
       'show'=> true,
       'index'=> 23,
       'submenu' => [
         [
           'menu'       => 'Support Tickets',
           'link'       => "$domain/user/support",
           'show'=>true,
           'index'=>24,
         ],

         [
           'menu'       => 'Contact us',
           'link'       => "$domain/user/contact-us",
           'show'=>true,
           'index'=>25,
         ],                                                    

       ]                                                    
     ],  


     [
       'menu' => "<i class='fa fa-folder-o'></i>Downloads",
       'link' =>  "$domain/user/downloads",
       'show'=> true,
       'index'=> 26,
     ],


     [
       'menu' => "<i class='fa fa-file-text-o'></i>News",
       'link' =>  "$domain/user/broadcast",
       'show'=> true,
       'index'=> 27,
     ],


     [
       'menu' => "<i class='ft-power'></i>Log Out",
       'link' =>  "$domain/login/logout",
       'show'=> true,
       'index'=> 28,
     ],

   ];   


   ;?>

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


        <?php foreach ($main_menu as  $menu):
          if ($menu['show'] == false) {
            continue;
          }
          ?>
          <?php if (is_array(@$menu['submenu'])):?>


            <li><a  href="#"><?=$menu['menu'];?></a>
              <ul class="sub-menu">

                <?php foreach ($menu['submenu'] as  $submenu):

                  ?>



                  <?php if (is_array(@$submenu['submenu'])):?>


                    <li><a  href="#"><?=$submenu['menu'];?></a>
                      <ul class="sub-menu">

                        <?php foreach ($submenu['submenu'] as  $submenu):

                          ?>
                          <li>
                            <a <?=$submenu['target']??'';?> 
                            href="<?=$submenu['link'];?>">
                            <?=$submenu['menu'];?>
                          </a>




                        </li>


                      <?php endforeach;?>
                    </ul>
                  </li>

                  <?php else:?>



                    <li>
                      <a <?=$submenu['target']??'';?> 
                      href="<?=$submenu['link'];?>">
                      <?=$submenu['menu'];?>
                    </a>
                  </li>

                <?php endif;?>


              <?php endforeach;?>
            </ul>
          </li>

          <?php else:?>

            <li>
              <a <?=$menu['target']??'';?> href="<?=$menu['link'];?>">
                <?=$menu['menu'];?>
              </a>

            </li>

          <?php endif;?>
        <?php endforeach ;?>


       </ul>
     </div>
   </div>
   <!-- END: Main Menu-->
