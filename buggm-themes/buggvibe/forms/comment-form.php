<?php if(current_user_can('buggm_add_comment')):?>
<!-- the comment form-- allows to modify the properties -->
<form action="" method="post" class="standard-form buggm_form" name="ticket_edit_form" enctype="multipart/form-data" id="ticket_edit_form">
    <fieldset class="ticket-properties">
        <legend>
                <?php _e('Modify Properties', 'buggm' ); ?>
        </legend>           
            <?php $ticket_id=buggm_get_the_ticket_post_id(); //get current ticket post id ?>
           
        <p> <label for="ticket_comment"><?php _e( 'Comment:', 'buggm' ); ?></label>               
            <textarea name="comment" id="comment" rows="10" cols="65"></textarea>
        </p>    
        <!-- ticket properties -->
        <table>
            <tr>
                <th><?php _e('Type:','buggm');?></th><td><?php buggm_list_ticket_type_dd($ticket_id);?></td>
                <th><?php _e('Priority:','buggm');?></th><td><?php buggm_list_ticket_priority_dd($ticket_id);?></td>

            </tr>
            <tr>
                <th> <?php _e('Milestone:','buggm');?></th><td><?php buggm_list_ticket_milestone_dd($ticket_id);?></td>
                <th> <?php _e('Component:','buggm');?></th><td><?php buggm_list_ticket_component_dd($ticket_id);?></td>

            </tr>
            <tr>
                <th><?php _e('Version:','buggm');?></th><td><?php buggm_list_ticket_version_dd($ticket_id);?></td>
                <th><?php _e('Severity:','buggm');?></th><td><?php buggm_list_ticket_severity_dd($ticket_id);?></td>

            </tr>
            <tr>
                <?php 
                global $current_user;
                $current_user_name='';
                $is_ccd=false;
                if(is_user_logged_in()&&buggm_is_user_in_cc_list($ticket_id,  buggm_get_current_user_id())){
                  $current_user_name=$current_user->user_login;
                  $is_ccd=true;
                }
                ?>
                <th> <?php _e('Cc:','buggm');?></th><td><input type='text' name="ticket_cc"  value="<?php ?> "/></td>
                <td colspan="2">
               
                    <label for="add_to_cc">
                        <input type="checkbox" id="add_to_cc" name='cc_action' value="add" /> <?php _e('Add to CC','buggm');?>
                 </label>
                  <?php if($is_ccd):?> <label for="remove_from_cc">
                                        <input type="checkbox" id="remove_from_cc" name='remove_from_cc' value="remove" /> <?php _e('Remove me from CC List','buggm');?>
                                     </label>
                <?php endif;?>
               </td>
                    

            </tr>
            <tr>
                 <th> <?php _e('Workflow Keywords:','buggm');?></th><td><?php buggm_list_ticket_keywords_dd();?></td>
                <th> &nbsp;</th><td>&nbsp;</td>

            </tr>
            <tr>
                <td colspan="4">
                    <span class="buggm-keywords-holder"><?php buggm_list_ticket_keywords_editable();?></span>
                </td>
            </tr>
        </table>

</fieldset>
    
<?php locate_template(array('forms/attachment-form.php'),true);?>
    
<?php locate_template(array('forms/ticket-actions.php'),true);?>
    <p class="ticket-comment-submit">
        <?php wp_nonce_field( 'buggm_new_comment' ); ?>
        <input type="hidden" name="action" value='buggm_new_comment' />
        <input type="submit" value="<?php _e('Update','buggm');?>" />
    </p>
</form>	
<?php endif;?>