<?php
$page_title = "My Team/Tree";
include 'includes/header.php';

$user = $auth;
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">My Team/Tree</h3>
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
  <?php require_once 'template/default/auth/includes/team_page.php';?>

  <div class="row">



    <style>

      td{
        padding-right: 1px !important;
        padding-left: 1px !important;
        text-align: center;
    }
</style>

<div class="col-md-12">
    <div class="card" >
        <div class="card-header" >


          professsional etc
      </div>

      <div class="card-content">
        <div class="card-body">

          TREE here


      </div>
  </div>

</div>

</div>




<div class="col-md-12">
   <div class="card" >
       <div class="card-content">
           <div class="card-body ">
            <div class="table-responsive">
                <table class="table table-sm">
                   <tr>
                     <td>Sales agent ID: <?=$user->id;?></td>
                     <?php foreach ($dates as $key => $date):?>
                         <td><?=date("F Y", strtotime($date));?> </td>
                     <?php endforeach ;?>
                 </tr>
                 <tbody>
                     <tr>
                         <td>Direct sales agent newly</td>
                       <?php foreach ($dates as $key => $date):?>
                           <td><?=$direct_sales_agent[$date]['total'] ?? 0;?> </td>
                       <?php endforeach ;?>

                       

                     </tr>
                     <tr>
                         <td>sales agent total</td>
                           <?php foreach ($dates as $key => $date):?>
                               <td><?=$sales_agent[$date]['total'] ?? 0;?> </td>
                           <?php endforeach ;?>
                     </tr>
                 </tbody>

             </table>
         </div>
     </div>
 </div>

</div>

</div>




<div class=" col-md-6">
   <div class="card" style="">
       <div class="card-content">
           <div class="card-body">
            <h4 class="card-tile border-0">SALES AGENT ID .: <?=$user->id;?> </h4>
               <hr>
               <div class="row">

                   <div class="col-md-12">


                       <ul class="list-group list-group-flush">
                           <li class="list-group-item small-padding">

                               <div class="row">

                                   <span class="col-6">
                                      Number NSW Silver-Coins Incenvite: 
                                  </span>
                                  <span class="col-6">
                                   02/4  Right renumeration
                               </span>
                           </div>


                       </li>

                       <li class="list-group-item small-padding">

                           <div class="row">

                               <span class="col-6">
                                  Number NSW Silver -Coins: 
                              </span>
                              <span class="col-6">
                               02/4  Right renumeration
                           </span>
                       </div>


                   </li>
                   <li class="list-group-item small-padding">

                       <div class="row">

                           <span class="col-6">
                              Number NSW Gold-Coins: 
                          </span>
                          <span class="col-6">
                           02/4  Right renumeration
                       </span>
                   </div>


               </li>


           </ul>

       </div>


   </div>

</div>
</div>
</div>
</div>



<div class=" col-md-6">
   <div class="card" style="">
       <div class="card-content">
           <div class="card-body">
               <h4 class="card-tile border-0"><?=$user->fullname;?>, <?=$user->id;?></h4>
               <hr>
               <div class="row">

                   <div class="col-md-12">


                       <ul class="list-group list-group-flush">
                           <li class="list-group-item small-padding">

                               <div class="row">

                                   <span class="col-6">
                                      First name: <?=$user->firstname;?>
                                  </span>
                                  <span class="col-6">
                                   E-mail: <?=$user->email;?>
                               </span>
                           </div>


                       </li>

                       <li class="list-group-item small-padding">

                           <div class="row">

                               <span class="col-6">
                                  Surname: <?=$user->lastname;?>
                              </span>
                              <span class="col-6">
                               02/4  Right renumeration
                           </span>
                       </div>


                   </li>
                   <li class="list-group-item small-padding">

                       <div class="row">

                           <span class="col-6">
                              Number NSW Gold-Coins: 
                          </span>
                          <span class="col-6">
                            Phone: <?=$user->phone;?>
                        </span>
                    </div>


                </li>


            </ul>

        </div>


    </div>

</div>
</div>
</div>
</div>




<div class="col-md-12">

    <small class="text-muted">* * * Due to data protection regulations only contacts data or names can be viewed by direct distributors. Exception: distributors have released what their contact details for the upline.</small>

</div>


</div>




</div>
</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
