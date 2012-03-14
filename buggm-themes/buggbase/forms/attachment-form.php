<?php if(current_user_can('buggm_upload_file')):?>
    <fieldset class="ticket-attachment-upload">

            <legend>
                    <?php _e( 'Attachment', 'buggm' ); ?>
            </legend>
            <p>
                <input type="file" name="ticket_attachment" id="ticket_attachment"/>
            </p>

    </fieldset>
<?php endif; ?>