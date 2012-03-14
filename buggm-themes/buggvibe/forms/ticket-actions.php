<fieldset class="ticket_action">
    <legend><?php _e('Action','buggm');?></legend>
     
    <p>
          <input type="radio" checked="checked" value="leave" name="buggm_action" id="action_leave" />
          <label for="action_leave"><?php _e('leave','buggm');?></label>
          <?php _e('as');?> <?php echo buggm_get_ticket_status(false,false);?>
          <span class="hint"></span>
     </p>
     
    <?php if(buggm_get_ticket_status(false,false)=='closed'):?>
         <p>
             <input type="radio"  value="reopen" name="buggm_action" id="action_reopen" />
             <label for="action_reopen"><?php _e('Reopen','buggm');?></label>
             <span class="hint"> <?php _e('Ticket will be reopened.','buggm');?></span>
         </p>

    <?php else : ?>

       <p>
          <input type="radio" value="resolve" name="buggm_action" id="action_resolve" />
          <label for="action_resolve"><?php _e('resolve','buggm');?></label>
          <?php _e('as','buggm');?>
          <?php buggm_list_ticket_resolution_dd(buggm_get_the_ticket_post_id());?>
          <span class="hint"><?php _e("The resolution will be set. Next status will be 'closed'",'buggm');?></span>
       </p>
       <p>
          <input type="radio" value="reassign" name="buggm_action" id="action_reassign">
          <label for="action_reassign"><?php _e('reassign to','buggm');?></label>
          <?php $owners=buggm_get_ticket_owners(buggm_get_the_ticket_post_id());
          
          ?>
          <input type="text" id="buggm_assign_to" name="buggm_assign_to"  value="<?php echo $owners;?>" />
          <span class="hint">
          <?php if(!empty($owners))
              printf(__("The owner will be changed from %s."),$owners);?>
          <?php _e("Next status will be 'assigned'",'buggm'  );?></span>
      </p>
      <p>
          <input type="radio" value="accept" name="buggm_action" id="action_accept" />
          <label for="action_accept"><?php _e('accept','buggm');?></label>
          <span class="hint"><?php _e("Next status will be 'accepted'",'buggm');?></span>
      </p>
      <?php endif;?>
</fieldset>