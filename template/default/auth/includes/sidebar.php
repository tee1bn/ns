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


      $main_menu =  Menu::get_menu();   


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


        <?php
          $package_id = $auth->subscription->payment_plan->id;
         foreach ($main_menu as  $menu):
          if (($menu['show'] == false) || (in_array($menu['index'], SubscriptionPlan::$not_accessible_menu[$package_id]))) {
            continue;
          }
          ?>
          <?php if (is_array(@$menu['submenu'])):?>


            <li><a  href="#"><?=$menu['menu'];?></a>
              <ul class="sub-menu">

                <?php foreach ($menu['submenu'] as  $submenu):
                  if (($submenu['show'] == false) || (in_array($submenu['index'], SubscriptionPlan::$not_accessible_menu[$package_id]))) {
                    continue;
                  }

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

                  <?php else:
                    if (($submenu['show'] == false) || (in_array($submenu['index'], SubscriptionPlan::$not_accessible_menu[$package_id]))) {
                      continue ;
                    }



                    ?>



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
