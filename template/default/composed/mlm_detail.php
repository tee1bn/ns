<?php
$pack = $user->subscription;
$sponsor = User::where('mlm_id' , $user->referred_by)->first();

$membership_status = $user->MembershipStatusDisplay['display'];
;?>


<a class="dropdown-item text-sm" href="#" style="padding: 0px;">
  <table class="mlm_detail table table-borderless " style="border: none;margin: 5px;margin-bottom: 3px;">
    <tr>
      <td colspan ="2" style="text-align: center; color:#073f2dc7; border-bottom: 1px solid #073f2dc7;"> <b><?=$user->fullname;?> (<?=$user->username;?>) </b></td>
    </tr>

    <tr>
      <td>
        <small class="label">ID</small><br>
        <em class="label-value">- <?=$user->id;?></em>

      </td>
      <td>

        <small class="label">Sponsor</small><br>
        <em class="label-value">- <?=$sponsor->username ?? 'Nil';?></em>
      </td>
    </tr>



    <tr>
      <td>
        <small class="label">Membership</small> <br>
        <em class="label-value">- <b><?=$membership_status;?></b></em>
      </td>

      <td>

       <em>
        <small class="label">Package</small><br>
        <em class="label-value">- <?=$pack->payment_plan->package_type;?>
      </em>
    </em>
  </td>
</tr>




</table>


</a>