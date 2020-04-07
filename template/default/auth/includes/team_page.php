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
              </div>