<?php
$pack = v2\Models\InvestmentPackage::for($user->id)->latest()->first();
$sponsor = User::where('mlm_id' , $user->referred_by)->first();
$today = date("Y-m-d");

$week = MIS::date_range($today, 'week', true);

$weekly_right = $user->total_volumes(1 , 'binary', $week);
$weekly_left = $user->total_volumes(0 , 'binary', $week);


$total_volume_left = $user->total_volumes(0 , 'binary');
$total_volume_right = $user->total_volumes(1 , 'binary');

$membership_status = $user->MembershipStatusDisplay;
$binary_status = $user->BinaryStatusDisplay;
;?>


<a class="dropdown-item text-sm" href="#" style="padding: 0px;">
  <table class="mlm_detail table table-borderless " style="border: none;margin: 0px;margin-bottom: 3px;">
    <tr>
      <td colspan ="2" style="text-align: center; color:#073f2dc7; border-bottom: 1px solid #073f2dc7;"> <b><?=$user->fullname;?> </b></td>
    </tr>

    <tr>
      <td>
        <small class="label">User</small><br>
        <em class="label-value">- <?=$user->username;?></em>

      </td>
      <td>

        <small class="label">Sponsor</small><br>
        <em class="label-value">- <?=$sponsor->username;?></em>
      </td>
    </tr>



    <tr>
      <td>
        <small class="label">Membership</small> <br>
        <em class="label-value">- <b><?=$membership_status;?></b></em>
      </td>


      <td>
        <small class="label">Pack</small><br>
        <em class="label-value">- <?=$pack->ExtraDetailArray['investment']['name'];?></em></td>
      </tr>

      <tr>
        <td>
          <small class="label">Binary</small><br>
          <em class="label-value">- <b><?=$binary_status;?></b></em>

        </td>

        <td>

         <em>
          <small class="label">Rank</small><br>
          <em class="label-value">- <?=$user->subscription->payment_plan->name;?>
        </em>
      </em>
    </td>
  </tr>
  


</table>


<table class="mlm_detail table table-borderless " style="border: none;margin: 0px;margin-bottom: 3px; margin-top: 7px;margin-bottom: 10px;">
    <tr>
      <td colspan ="2" style="text-align: center; color:#073f2dc7;"> <b>VOLUMES </b></td>
    </tr>


  <tr>
    <td>
      <small class="label">
        Left Points
      </small> <br> <em class="badge badge-sm bg-secondary">
        <?=MIS::money_format($weekly_left);?>
      </em>
    </td>

    <td>
      <small class="label">
       Right Points 

     </small><br>
     <em class="badge badge-sm bg-secondary">
      <?=MIS::money_format($weekly_right);?>
    </em>
  </td>
</tr>
<tr>
  <td>
    <small class="label">Total Left</small><br>
    <em class="badge badge-sm bg-secondary"><?=MIS::money_format($total_volume_left);?></em>
  </td>
  <td>
    <small class="label">Total Right</small><br> 
    <em class="badge badge-sm bg-secondary"><?=MIS::money_format($total_volume_right);?></em>
  </td>
</tr>

</table>
</a>