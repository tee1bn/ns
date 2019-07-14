<?php
$page_title = "Products";
 include 'includes/header.php';?>


                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Products</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                        <div class="col-md-6 col-4 align-self-center">
                           <div class="dropdown float-right mr-2 hidden-sm-down">

                           <a href="<?=domain;?>/admin-products/add_product" class="btn btn-secondary " type="a"> 
                                Add Product <i class="fa fa-plus-circle"></i>
                           </a>
                           
                        </div>
                    </div>                </div>
             

                 <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;">Products</a>
                            </div>
                            <div class="card-body row collapse in" id="demo">

                              
<div class="table-responsive">

                    <table id="myTable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
              <th>#sn</th>
                          <th>Item</th>
                          <th>Price(<?=$currency;?>)</th>
                          <th>Scheme</th>
                          <th style="width:40%;">Description</th>
                          <th>Created</th>
                          <th>Action</th>
            </tr>
          </thead>

                      
<?php $i=1; foreach (Products::all() as $item) :

  if ($item->is_on_sale()) {

    $on_sale_status = 'Put off sale';
    $label = 'info';
  }else{

      $on_sale_status = 'Put on sale';
          $label = 'default';

  }

?>


                          <tr>
                          <td><?=$i;?></td>
                          <td style="text-transform: capitalize;"><?=$item->name;?> </td>
                          <td><?=($item->price);?></td>
                          <td><?=($item->scheme_attached->package_type);?></td>
                          <td>
                                     <button class="btn-primary btn" data-toggle="collapse" data-target="#de<?=$item['id'];?>">Description 
                                                        <span class="fa fa-caret"></span>
                                                    </button>

                                                    <div id="de<?=$item['id'];?>" class="collapse"
                                                        style="text-align: justify;">
                                                        <?=($item['description']);?>
                                                    </div>

                          </td>
                          <td>
                            <label type='label' class='label label-primary'>
                            <?=$item->created_at->toFormattedDateString();?>
                              </label>
                          </td>
                          <td>


            <div class="dropdown">
              <!--   <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                    Action
                    <span class="caret"></span>
                </button> -->
              <ul class="dropdon-menu">


                    
                <li>
                             <a href="<?=domain;?>/admin-products/edit_item/<?=$item->id;?>" >
                                Edit                
                            </a>
                </li>
                    
                <li>
                             <a href="javascript:void(0);" onclick="$confirm_dialog = new ConfirmationDialog('<?=$item->deletelink;?>')" >
                                Delete                
                            </a>
                </li>
                <li>
                            <a href="<?=domain;?>/admin-products/pausePlayProduct/<?=$item->id;?>">
                                <span ><?=$on_sale_status;?>
                                </span>
                             </a>
                </li>
              </ul>
            </div>





                            </td>
                          </tr>
           
                     
                     <?php $i++; endforeach;?>
                   
                      </tbody>
                    </table>


                             </div>

                        </div>
                    </div>
                </div>

<?php include 'includes/footer.php';?>
<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>
