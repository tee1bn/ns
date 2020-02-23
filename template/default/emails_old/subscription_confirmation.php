<?php include 'includes/header.php';?>


      <span style="text-transform: uppercase; color: #203864">
         Dear Mr./Mrs. <?=$data['name'];?> Confirmation</span></td></tr></tbody></table>


    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
      <b style="color: #777777; text-transform: lowercase;"></b>
        <?=$subscription->confirmation_message;?>
      <br>

       <br>
        Regards,
       <br>
        Team <span style="text-transform: uppercase;"><?=project_name;?></span>
       <br>
    </div>

  </td></tr></tbody></table>
</td></tr></tbody></table>
    






<?php include 'includes/footer.php';?>