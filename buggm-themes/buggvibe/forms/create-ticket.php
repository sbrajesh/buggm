<?php
/**
 * Buggm Ticket Creation form
 * I planned to use BP Simple Front End post editor but later included it here instead
 * 
 */
?>
<?php 
/**
 * Normally all the logged in users have the buggm_create_ticket cap
 */

if (current_user_can('buggm_create_ticket') ) : ?>

<div id="ticket-create-form-wrap">

	<form action="" method="post" class="standard-form buggm_form" name="ticket_create_form" enctype="multipart/form-data" id="ticket_create_form">
	
		<?php do_action( 'buggm_ticket_form_before' ); ?>
		
	
		<fieldset>
                        <legend>
                            <?php _e( 'Properties', 'buggm' ); ?>
			</legend>
		
			<p>
                            <label for="ticket_title"><?php _e( 'Summary:', 'buggm' ); ?></label>
                            <input type="text" name="ticket_title" value="" size="64" maxlength="128" />
			</p>
						
			<p>
                            <label for="ticket_description"><?php _e( 'Description:', 'buggm' ); ?></label>
                            <textarea name="ticket_description" id="ticket_description" cols="68" rows="10"></textarea>
			</p>
			<!-- use table for the props -->
                        <table class="buggm-props-table">
                            <tr>
                                <th><?php _e('Type:','buggm');?></th><td><?php buggm_list_ticket_type_dd();?></td>
                                <th><?php _e('Priority:','buggm');?></th><td><?php buggm_list_ticket_priority_dd();?></td>
                                
                            </tr>
                            <tr>
                                <th> <?php _e('Milestone:','buggm');?></th><td><?php buggm_list_ticket_milestone_dd();?></td>
                                <th> <?php _e('Component:','buggm');?></th><td><?php buggm_list_ticket_component_dd();?></td>
                                
                            </tr>
                            <tr>
                                <th> <?php _e('Version:','buggm');?></th><td><?php buggm_list_ticket_version_dd();?></td>
                                <th> <?php _e('Severity:','buggm');?></th><td><?php buggm_list_ticket_severity_dd();?></td>
                                
                            </tr>
                            <tr>
                                 <th> <?php _e('Owner:','buggm');?></th><td><input type='text' name='ticket_owner' /></td>
                                 <th> <?php _e('Cc:','buggm');?></th><td><input type='text' name='ticket_cc' /></td>
                                
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
		
            <p class="ticket-submit">
		<input type="submit" name="submit" id="create-ticket" value="<?php _e( 'Create Ticket', 'buggm' ); ?>" />
		<input type="hidden" name="action" id="buggm_new_ticket" value='buggm_new_ticket' />
		<?php wp_nonce_field( 'buggm_new_ticket' ); ?>
		
            </p>
		
	<?php do_action( 'buggm_ticket_form_after' ); ?>
	
	</form>

</div>

<?php endif; ?>