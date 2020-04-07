<?php
$upline = User::where('mlm_id',$user->referred_by)->first();
$page_title = "Overview Team";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Overview Team</h3>
          </div>
          
        </div>

        <style>
          .team-leader{

            height: 100px;
            border-radius: 46px;
            width: 100px;
            object-fit: cover;
          }
        </style>


        <div class="content-body">
           <div class="row match-height">
               <div class="col-md-4">
                     <div class="card" >
                         <div class="card-content">
                             <div class="card-body">

                                 <div class="row">

                                              <div class="col-3">
                                                  <img class="team-leader img-round" src="<?=domain;?>/<?=$auth->profilepic;?>" alt=""  >
                                              </div>
                                              <div class="col-9 side-user">
                                                <h4><b><?=$auth->username;?></b></h4>
                                                <h4><?=$auth->fullname;?> <br> <i>ID:<?=$auth->id;?></i></h4>
                                              </div>

                             </div>
                         </div>
                 </div>
                   
               </div>
               
             </div>




               <div class="col-md-3">
                  <div class="card">
                      <div class="card-content">
                          <div class="media align-items-stretch">
                              <div class="p-1 text-center bg-white bg-darken-2">
                                  <i class="ft-block font-large-2"></i>
                              </div>
                              <div class="p-3 bg-gradient-x-white  media-body">
                                  <h3>Professional</h3>
                                  <h5 class="text-bold-400 mb-0"> Package</h5>
                              </div>
                          </div>
                      </div>
                  </div>
             </div>


               <div class="col-md-5">
                     <div class="card" >
                         <div class="card-content">
                             <div class="card-body">
                              <!-- <p> </p> -->
                                 <div class="row">
                                  <div class="col-md-3 " >
                                    
                                    <div class="b-box" onclick="copy_text('<?=$auth->referral_link();?>')">  
                                        <span class="d-box">
                                            <i class="fa fa-link fa-2x"></i>
                                        </span>
                                    </div>    

                                 </div>
                                  <div class="col-md-9 " >
                                    <p></p>
                                    <span>Share the registration link with other</span>
                                    <small><i>Registration link just share with potential partners</i></small>

                                 </div>

                             </div>
                         </div>
                 </div>
                   
               </div>
               
             </div>


               <div class="col-md-4">

                <div class="dropdown">
                  <button class="btn btn-dark btn-block  dropdown-toggle" type="button" data-toggle="dropdown"> 
                    Lifeline Level <span class="badge badge-secondary"> <?=$level_of_referral;?> </span>
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                   <?php for ($i=1; $i <=3 ; $i++):?>
                        <li>
                          <a class="dropdown-item" href="<?=domain;?>/genealogy/placement_list/<?=$user->username;?>/<?=$i;?>">
                          Level <?=$i;?>
                          </a>
                        </li>
                   <?php endfor;?>
                  </ul>
                </div>

               
             </div>

               <div class="col-md-8">
                     <div class="card" >
                         <div class="card-content">
                             <div class="card-body" style="
    padding: 7px !important;
    padding-bottom: 5px!important;
    padding-top: 10px!important;">
                                  <label>
                                    
                                    <input type="checkbox" name="" style="
    height: 20px;
    width: 20px;
    position: absolute;
    top: 11px;">
                                     <span style="margin-left: 20px;">share my personal information (name, email, phone) for the entire Upline</span>
                                  </label>
                                
                         </div>
                 </div>
                   
               </div>
               
             </div>
               <div class="col-md-12">
                   <div class="form-group col-md-3">
                     <input type="" class="form-control" placeholder="Search for sales partner ID" name="">
                   </div>
               
             </div>


<style>
  
  td{
    padding-right: 1px !important;
    padding-left: 1px !important;
    text-align: center;
  }
</style>
               <div class="col-md-12">
                     <div class="card" >
                         <div class="card-content">
                             <div class="card-body table-responsive">
                                <table class="table">
                                                 <tr>
                                                   <td style="width: 5%;">Sn</td>
                                                   <td>Partner ID</td>
                                                   <td>Surname</td>
                                                   <td>Level</td>
                                                   <td>E-mail</td>
                                                   <td>Phone</td>
                                                   <td>Registered</td>
                                                   <td>Direct <br>sales partner</td>
                                                   <td>Own <br>Merchants</td>
                                                   <td>Status</td>
                                                 </tr>
                                                 <tbody>
                                                   <tr>
                                                     <td>1</td>
                                                     <td>12</td>
                                                     <td>opeifa</td>
                                                     <td>3</td>
                                                     <td>32@gmail.com</td>
                                                     <td>08323323232</td>
                                                     <td>4/12/3233</td>
                                                     <td>3</td>
                                                     <td>32</td>
                                                     <td>active</td>
                                                   </tr>
                                                   <tr>
                                                     <td>1</td>
                                                     <td colspan="6"><b>Total</b></td>
                                                     <td>3</td>
                                                     <td>32</td>
                                                     <td>active</td>
                                                   </tr>
                                                 </tbody>
                                                   
                                                </table>
                         </div>
                 </div>
                   
               </div>
               
             </div>

               <div class="col-md-12">
                
                <small class="text-muted">* * * Due to data protection regulations only contacts data may be viewed by direct distributors. Ausnamhe: Distributors have shared that their contact information for the upline</small>
               
             </div>
             

           </div>




        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
