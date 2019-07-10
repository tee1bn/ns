<?php


$upline = User::where('mlm_id',$user->referred_by)->first();
$page_title = "Team List";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Team List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Team List</li>
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
                            <a href="<?=domain;?>/genealogy/placement_list/<?=$upline['username'];?>">
                                <img src="<?=domain;?>/<?=$user->profilepic;?>" style="border-radius: 70%;height: 50px;"
                                 data-toggle="tooltip" title="Upline: <?=ucfirst($upline['lastname']);?> <?=ucfirst($upline['firstname']);?>">
                                <?php if($user->id == $this->auth()->id):?>
                                    <h4>Me</h4>
                                <?php else:?>
                                <h4><?=$user->lastname;?> <?=$user->firstname;?>
                                 </h4>
                                <?php endif;?>
                          </a>
                            <?=$ref_link =$this->auth()->referral_link();?>
                            <button onclick="copy_text('<?=$ref_link;?>');" class="btn btn-success">Copy Link</button>

                     <!--  
                      <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"> 
                          Downline Level <span class="badge badge-danger"> <?=$level_of_referral;?> </span>
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                         <?php// for ($i=1; $i <=3 ; $i++):?>
                              <li>
                                <a class="dropdown-item" href="<?=domain;?>/genealogy/placement_list/<?=$user->username;?>/<?=$i;?>">
                                Level <?=$i;?>
                                </a>
                              </li>
                         <?php// endfor;?>
                        </ul>
                      </div> -->
                      </div>

                    </div>


                    <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                              <div class="table-responsive">
                                     <table id="myTable" class="table table-hover">
                                  <thead>
                                    <th>Full Name (username)</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Joined</th>
                                    <th>Status</th>
                                  </thead>
                                  <tbody>
                                    <?php foreach ($list['list'] as $key => $downline):?>
                                    <tr>
                                      <td><a href="<?=domain;?>/genealogy/placement_list/<?=$downline->username;?>">
                                       <?=$downline->fullname;?> (<?=$downline->username;?>) </a></td>
                                      <td><?=$downline->email;?></td>
                                      <td><?=$downline->phone;?></td>
                                      <td><?=$downline->created_at->toFormattedDateString();?></td>
                                      <td><?=$downline->activeStatus;?></td>
                                    </tr>
                                  <?php endforeach;?>
                                  </tbody>
                                </table>
                              </div>




                            </div>
                        </div>
                    </div>
                </div>
                <!--   <ul class="pagination">
                      <?=$this->pagination_links($list['total'] , $per_page) ;?>
                  </ul>   -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
          

<?php include 'includes/footer.php';?>
<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>
