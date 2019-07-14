<?php
$page_title = "Edit Products";
 include 'includes/header.php';?>


                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor mb-0 mt-0">Edit Products</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Edit Products</li>
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

                 <form method="post" enctype="multipart/form-data" class="col-md-12 ajax_form " 
                  id="item_form"
                  action="<?=domain;?>/admin-products/update_item">
                  <?=$this->inputErrors();?>


                  <div class="col-md-5 float-right" >
                    <div class="property-image">
                      <img src="<?=$item->mainimage;?>" style="width: 100%;    border: 1px solid beige; height: 210px; 
                      object-fit: contain;">
                      <div class="property-image-content">
                        <i class="fa fa-times-circle delete-image" onclick="select_this_for_delete(this)"></i>
                        <input type="checkbox" name="images_to_be_deleted[]" value="<?=$key;?>" style="display: none;" >
                      </div>
                    </div>


                    <hr />
                    <div class="dropdown">
                        <a class="btn btn-primary" 
                        href="<?=domain;?>/admin/download_request/<?=$item->id;?>"> 
                        File Download link
                         </a>
                    
                    </div>


                  </div>
      



                  <div class="form-group col-md-6">
                    <?=$this->csrf_field('update_products');?>
                    Name
                   <input type="" name="name" class="form-control" required="required" value="<?=$item->name;?>" placeholder="Item name" >
                  </div>

                   <input type="hidden" name="item_id" value="<?=$item->id;?>" >

                <div class="form-group col-md-6">
                  Price:
                   <input type="" name="price" class="form-control" required="required" value="<?=$item->price;?>" placeholder="Item price">
                 </div>
<!-- 
                <div class="form-group">
                 Regular Price:
                   <input type="" name="old_price" class="form-control"  value="<?=$item->old_price;?>" placeholder="Item old/regular price">
                 </div> -->

              <!--   <div class="form-group">
                  Category:
                  <select name="category" class="form-control" required="required">
                    <option value="">select category</option>
                    <?php foreach (ProductsCategory::all() as $category):?>
                      <option value="<?=$category->id;?>"  <?=($item->category->id == $category->id)?'selected':'';?>>
                        <?=$category->category;?></option>
                    <?php endforeach ;?>
                  </select> -->


                <div class="form-group col-md-6">
                  Scheme:
                  <select name="scheme" class="form-control" required="required">
                    <option value="">Select Scheme</option>
                    <?php foreach (SubscriptionPlan::all() as $scheme):?>
                      <option value="<?=$scheme->id;?>"  <?=($item->scheme == $scheme->id)?'selected':'';?>>
                        <?=$scheme->package_type;?></option>
                    <?php endforeach ;?>
                  </select>




                 </div>

                <div class="form-group col-md-6">
                  Cover Image:
                   <input type="file" multiple="" name="front_image[]" class="form-control"  placeholder="Item price">
                  </div>

                <div class="form-group col-md-6">
                  Downloadable File: <small class="text-danger float-right">* Preferebly .Zip</small>
                   <input type="file"  name="downloadable_files" class="form-control"  placeholder="Item price">
                  </div>





          <small  style="margin-left: 15px;color: red;"> 
            Mark pictures and click Update to delete marked images
          </small>
                    <br>
                    <br>

          <style type="text/css">
              .delete-image:hover{
              color: red;
              cursor: pointer;
              }
              .delete-image{
                  position: absolute;
                  top: 3px;
                  right: 18px;
                  font-size: 20px;
                } 
          </style>


          <script>
            select_this_for_delete= function ($element) {
                $checkbox = $element.nextSibling.nextSibling;

              if ($checkbox.checked == false) {
                $checkbox.checked = true;
                $element.style.color = 'red';
              }else{
                $checkbox.checked = false;
                $element.style.color = 'black';

              }

            }
          </script>


                     <div class="form-group">
                      Description
                       <textarea id="editor1" class="form-control" name="description" rows="6" required="required"  placeholder="Item description"><?=$item->description;?></textarea>
                      </div>

                  <div class="form-group">
                   <button type="submit" class="form-control btn-primary">
                     Update Item
                   </button> 
                  </div>


                 </form>


 <script>
      CKEDITOR.replace( 'editor1' );
</script>


                             

                        </div>
                    </div>
                </div>

<?php include 'includes/footer.php';?>
<script>
    $(function() {
        $('#myTable').DataTable();
    });
</script>
