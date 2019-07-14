<?php
$page_title = "Manual Matching";
 include 'includes/header.php';?>


    
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Manual Matching</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Manual Matching</li>
                        </ol>
                    </div>
                  
                </div>
             



                <form method="post" action="<?=domain;?>/admin/create_matches">
                 <div class="row">
                    <div class="col-6">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">PH Lists</a>
                                <span class="badge badge-secondary"><?=count($valid_unfufilled_phs);?></span>
                            </div>
                            <div class="card-body collapse show" id="demo" >
                                <select name="phs[]" multiple="" style="width: 100%;" class="form-control select2 select2-multiple">

                                    <?php foreach ($valid_unfufilled_phs as $ph):
                                        $ph_er = $ph->user;
                                        ?>
                                        <option value="<?=$ph['id'];?>">
                                             #<?=$ph['id'];?><br>
                                             --
                                              <?=$currency;?> 
                                             <?=$this->money_format($ph['payout_left']);?>
                                             --
                                             <?=$ph_er->fullname;?> (<?=$ph_er->username;?>)<br>
                                        </option>
                                    <?php endforeach ;?>
                                </select>
                                
                             </div>
                        </div>
                    </div>


                  
                    <div class="col-6">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">GH Lists</a>
                                <span class="badge badge-secondary"><?=count($valid_unfufilled_ghs);?></span>
                            </div>
                            <div class="card-body collapse show" id="demo" >
                                <select name="ghs[]" multiple="" style="width: 100%;" class="form-control select2 select2-multiple">

                                    <?php foreach ($valid_unfufilled_ghs as $gh):
                                        $gh_er = $gh->user;
                                        ?>
                                        <option value="<?=$gh['id'];?>">
                                             #<?=$gh['id'];?><br>
                                             --
                                              <?=$currency;?> 
                                             <?=$this->money_format($gh['payin_left']);?>
                                             --
                                             <?=$gh_er->fullname;?> (<?=$gh_er->username;?>)<br>
                                        </option>
                                    <?php endforeach ;?>
                                </select>
                                
                             </div>
                        </div>
                    </div>
                  
                    <div class="text-center col-12">
                        <button class="btn btn-success">Create Match <i class="fa fa-link"></i></button>
                    </div>
                </div>
            </form>

<?php include 'includes/footer.php';?>
<script>
    $(function() {
        $('#myTable').DataTable();

        // For select 2
        $(".select2").select2();
    });
</script>
