<?php


    $user   =  User::find($user_id);
    $upline = $user->referred_members_uplines(1)[1];

$page_title = "Team Tree";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Team Tree</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Team Tree</li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                   <div class="row">
                        <div class="referral col-md-6" align="center">
                            <a href="<?=domain;?>/genealogy/placement/<?=$upline['username'];?>">
                                <img src="<?=domain;?>/<?=$user->profilepic;?>" style="border-radius: 70%;height: 50px;"
                                 data-toggle="tooltip" title="Upline: <?=ucfirst($upline['lastname']);?> <?=ucfirst($upline['firstname']);?>">
                                <?php if($user_id == $this->auth()->id):?>
                                    <h4>Me</h4>
                                <?php else:?>
                                <h4><?=$user->lastname;?> <?=$user->firstname;?><br>
                                 Level: <?=$user->rank;?></h4>
                                <?php endif;?>
                          </a>
                      </div>

                    </div>

<style>
    .tree-img{
        
    height: 50px;
    border-radius: 100%;
    width: 50px;
    }
</style>
<?php

$downlines = $user->referred_members_downlines(3);

$ordinal = [
              1=> 'First Level - Direct Referrals',
              2=> 'Second Level - Referrals of Direct Referrals',
              3=> 'Third Level - Referrals of Second Level Referrals',
              4=> 'Fourth Level - Referrals of Third Level Referrals',
              5=> 'Fifth Level - Referrals of Fourth Level Referrals',
              6=> 'Sixth Level - Referrals of Fifth Level Referrals',
            ];

for ($level=1; $level <=3 ; $level++) :

      $count = count($downlines[$level]);
  if ( $count == 0) {
    $message = '<div class="" align="center">
                <b>No records found</b>
              </div>';
      }

      $heading ="Level #$level";
      if($level ==1){
        $heading = 'Direct referral (Level #'.$level.')';
      }


  ?>

      <div class="card-group" >
        <div class="card card-default">
          <div class="card-header">
            <h4>
              <a data-toggle="collapse" href="#collapse<?=$level;?>">
                <?=$ordinal[$level];?> </a>
            <span class="badge badge-danger pull-right"> <?=$count;?></span>
            </h4>
          </div>
          <div id="collapse<?=$level;?>" class="card-collapse collapse show <?=($level==1)?'':'';?>">
            <div class="card-body">
             
              <div class="row">


   <?php

        echo $message;
         foreach ($downlines[$level] as $user){
          echo  $this->showThisDownine($user['id'], 'referred_by');
        }
        ;?>


              </div>



            </div>
          </div>
        </div>

     
      </div> 

<?php endfor ;?>

              
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
          

<?php include 'includes/footer.php';?>
