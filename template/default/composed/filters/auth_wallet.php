       <div class="dropdown">
                          <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-filter"></i>
                          </button>
                          <div class="dropdown-menu" style="padding: 20px; top: 40px !important;">
                            <form action="<?=@$action;?>" method="get" id="filter_form">
                                                            <!-- 

                                <div class="row">
                                    <div class=" form-group col-md-6">
                                        <label>*  Amount (From):</label>
                                        <input placeholder="Start" type="number" step="0.0001" 
                                        value="<?=$sieve['amount']['start'];?>" 
                                        class="form-control" name="amount[start]">
                                    </div>


                                    <div class=" form-group col-md-6">
                                        <label>* Amount (To)</label>
                                        <input type="number" step="0.0001" placeholder="End "
                                            value="<?=$sieve['amount']['end'];?>" 
                                         class="form-control" name="amount[end]">
                                    </div>                    
                                </div>

                               -->
                                <div class="row">
                                    <div class=" form-group col-md-6">
                                        <label>*  Date(From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['registration']['start_date'];?>" 
                                        class="form-control" name="registration[start_date]">
                                    </div>


                                    <div class=" form-group col-md-6">
                                        <label>* Date (To)</label>
                                        <input type="date" placeholder="End "
                                            value="<?=$sieve['registration']['end_date'];?>" 
                                         class="form-control" name="registration[end_date]">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button type="Submit" class="btn btn-dark">Submit</button>
                                    <!-- <a  onclick="$('#filter_form').reset()">Reset</a> -->
                                </div>
                            </form>

                          </div>
                        </div>
                        