<?php
function buggm_load_message_template($ticket_id,$comment=false){?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;UTF-8" />
</head>
<body>
<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#F4F4F4" style="border:solid 1px #f4f4f4;border-radius:7px">
<tbody>
   <tr>
       <td colspan="3">
            <div style="min-height:5px;font-size:5px;line-height:5px">&nbsp;</div>
       </td>
    </tr>
    <tr>
	<td width="5%">
           <div style="min-height:0px;font-size:0px;line-height:0px">&nbsp;</div>
        </td>
        <td width="90%" style="font-family:Arial">
	


            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#F4F4F4">
                <tbody><tr>
                        <td align="left" valign="middle" style="font-family:Arial;color:#333333">
                                <div style="font-size:12px;color:#666666"><?php bloginfo('name');?></div>
                                <div style="font-size:20px">
                                    #<?php echo $ticket_id;?>: <?php echo get_the_title($ticket_id);?>
                                </div>
                        </td>
                        <td><table width="20" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><div style="min-height:0px;font-size:0px;line-height:0px">&nbsp;</div></td></tr></tbody></table></td>

                        <td align="right" valign="middle"><?php bloginfo('name');?></td>
                    </tr>
                     <tr>
                        <td colspan="3"><div style="min-height:15px;font-size:15px;line-height:15px">&nbsp;</div></td> 
                    </tr>
                </tbody>
            </table>

		
		
        <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#FFFFFF" style="color:#333333;border:solid 1px #dddddd;border-radius:5px">
            <tbody>
                <tr><td colspan="3"><div style="min-height:7px;font-size:7px;line-height:7px">&nbsp;</div></td></tr>
                <tr>
                     <td><div style="width:16px;">&nbsp;</div></td><!-- padding -->
                      <td><!-- main column -->
						
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                                <!-- main col row 1-->
                                <tr>
                                    <td valign="middle" style="font-size:14px">[<?php if(empty($comment)) _e('New Ticket','buggm'); else _e('Ticket Update','buggm');?>]</td>
                                    <!--right button:view ticket -->
                                    <td align="right" valign="middle">

                                        <!-- view ticket button top right -->
                                        <table  cellspacing="1" cellpadding="6" border="0">
                                                <tbody>
                                                        <tr>
                                                            <td align="center" valign="middle" bgcolor="#FFE86C" style="background-color:#ffe86c;border:1px solid #e8b463;border-radius:4px;">
                                                                    <div style="padding-right:10px;padding-left:10px">
                                                                        <a target="_blank" style="text-decoration:none" href="<?php echo get_permalink($ticket_id);?>"><span style="font-size:12px;font-family:Arial;font-weight:bold;color:#333333;white-space:nowrap;display:block"><?php _e('View Ticket','buggm');?></span></a>
                                                                    </div>
                                                            </td>
                                                        </tr>
                                                </tbody>
                                        </table>
		
                                </td>
                        </tr>
                        </tbody>
                        </table>
				
			<table width="1" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div style="min-height:7px;font-size:7px;line-height:7px">&nbsp;</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
			
                        <div style="min-height:1px;font-size:1px;line-height:1px;border-top:1px solid #dddddd">&nbsp;</div>
			<table width="1" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <div style="min-height:9px;font-size:9px;line-height:9px">&nbsp;</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

<?php if(!empty($comment)):?>
        <div style="font-family:Arial;font-weight:bold;font-size:11px">

               <?php 
               
               
               printf(__('Changes (by %s)','buggm'),  buggm_get_user_name($comment->user_id));?>
        </div>
<?php endif;?>
        <table width="1" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td>
                        <div style="min-height:10px;font-size:10px;line-height:10px">&nbsp;</div>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- current ticket properties, applies to new ticket as well as for comments -->
        <?php $post=get_post($ticket_id);
        $reporter_id=$post->post_author;
        ?>
        <table  style="color:#222;font-family:Arial;font-size:13px;width:100%;">
                        <tbody>
                            <tr>
                                  <th>Reported by:</th>
                                  <td>
                                      <a href="<?php echo buggm_get_user_url($reporter_id);?>" style='text-decoration: none;color:#006699;' ><?php echo buggm_get_avatar($reporter_id, 24);?></a>
                                      <a href="<?php echo buggm_get_user_url($reporter_id);?>" style='text-decoration: none;color:#006699;' ><?php echo buggm_get_user_name($reporter_id);?></a>                          
                                  </td>

                                  <th>Owned by:</th>
                                  <td><?php buggm_list_ticket_owners($ticket_id,true);?> </td>                       
                            </tr>
                           <tr>
                            <th>Priority:</th>
                            <td>
                                  <?php echo buggm_get_ticket_priority($ticket_id);?>
                            </td>
                            <th>Milestone:</th>
                            <td>
                                 <?php echo buggm_get_ticket_milestone($ticket_id);?>
                            </td>
                        </tr>
                        <tr>
                            <th>Component:</th>
                            <td>
                            <?php echo buggm_get_ticket_component($ticket_id);?>
                            </td>
                            <th>Version:</th>
                            <td>
                                <?php echo buggm_get_ticket_version($ticket_id);?>
                            </td>
                        </tr>
                        <tr>
                            <th>Severity:</th>
                            <td>
                                <?php echo buggm_get_ticket_severity($ticket_id);?>
                             </td>
                            <th> Keywords:</th>
                            <td class="searchable" headers="h_keywords">
                                <?php echo buggm_get_ticket_keywords($ticket_id);?>
                            </td>
                        </tr>
                        <tr>
                           <th>
                              Cc:
                            </th>
                            <td colspan="3"><?php buggm_list_cced($ticket_id);?></td>
                         </tr>
              </tbody>
           </table><!--end of current ticket props -->

							
       <table width="1" cellspacing="0" cellpadding="0" border="0">
           <tbody>
               <tr>
                   <td>
                       <div style="min-height:24px;font-size:24px;line-height:24px">&nbsp;</div>
                   </td>
               </tr>
           </tbody>
       </table>

           <?php
           $comment_text='';
           if(empty($comment)){
               $commenter_id=$reporter_id;
               $comment_text= $post->post_content;
           }
           else{
               $commenter_id=$comment->user_id;
               $comment_text=get_comment_text($comment->comment_ID);
              
               
           }
               
                
           ?>

        <div style="font-family:Arial;font-weight:bold;font-size:11px">

                Comment:
        </div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="font-family:Arial;font-size:13px">
        <tbody>
            <tr>
                <td width="40" valign="top">
                   <?php echo buggm_get_avatar($commenter_id,32,true);?><!-- commenter avatar -->
                </td>
                <td>
                    <table width="10" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><div style="min-height:0px;font-size:0px;line-height:0px">&nbsp;</div></td></tr></tbody>
                    </table>
                </td>
                <td width="99%" valign="top">
                    <a target="_blank" style="color:#069;font-family:Arial;font-size:13px;font-weight:bold;text-decoration:none" href="<?php echo buggm_get_user_url($commenter_id);?>"><?php echo buggm_get_user_name($commenter_id);?></a>:
                        <?php echo $comment_text;?>
                        <?php 
                        $updates=false;
                        if(!empty($comment))
                         $updates=buggm_get_ticket_changes($comment->comment_ID);
                        if( $updates ) : ?>
					
					<ul class="update-list">
						<?php foreach( $updates as $update ) : ?>
							<li><?php echo $update; ?></li>
						<?php endforeach; ?>
					</ul>
					
				<?php endif; ?>
                        <table width="1" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><div style="min-height:7px;font-size:7px;line-height:7px">&nbsp;</div></td></tr></tbody></table>


          

                 </td>
                </tr>
           </tbody>
        </table>

                                     
        <table width="1" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <tr>
                        <td>
                            <div style="min-height:9px;font-size:9px;line-height:9px">&nbsp;</div>
                        </td>
                    </tr>
                </tbody>
        </table>

	<div style="min-height:1px;font-size:1px;line-height:1px;border-top:1px solid #dddddd">&nbsp;</div>
	
        <table width="1" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td>
                        <div style="min-height:10px;font-size:10px;line-height:10px">&nbsp;</div>
                    </td>
                </tr>
            </tbody>
        </table>
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td align="center">
                        <table align="" cellspacing="1" cellpadding="6" border="0">
                            <tbody>
                                <tr>
                                    <td align="center" valign="middle" bgcolor="#FFE86C" style="background-color:#ffe86c;border:1px solid #e8b463;border-radius:4px;">
                                        <div style="padding-right:10px;padding-left:10px">
                                            <a target="_blank" style="text-decoration:none" href="<?php echo get_permalink($ticket_id);?>">
                                                <span style="font-size:12px;font-family:Arial;font-weight:bold;color:#333333;white-space:nowrap;display:block"><?php _e('View Ticket','buggm');?></span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
      		</td>
    		</tr>
            </tbody>
        </table>
      </td>
      <td>
          <table width="16" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                  <tr>
                      <td>
                          <div style="min-height:0px;font-size:0px;line-height:0px">&nbsp;</div>
                      </td>
                  </tr>
              </tbody>
          </table>
      </td>
    </tr>
    <tr>
        <td colspan="3">
            <table width="1" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <tr>
                        <td>
                            <div style="min-height:10px;font-size:10px;line-height:10px">&nbsp;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
  </tbody>
</table>
		
</td>
  <!-- main col right -->
<td width="5%">
    <table width="10" cellspacing="0" cellpadding="0" border="0">
        <tbody>
            <tr>
                <td>
                    <div style="min-height:0px;font-size:0px;line-height:0px">&nbsp;</div>
                </td>
            </tr>
        </tbody>
    </table>
</td>
</tr>
    
    <!--foooter -->
<tr>
    <td></td>
    <td>
        <table width="1" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td>
                        <div style="min-height:10px;font-size:10px;line-height:10px">&nbsp;</div>
                    </td>
                </tr>
            </tbody>
        </table>
	<div style="font-size:11px;font-family:Arial,sans-serif;color:#999999">
			<?php _e("Don't want to receive email notifications?",'buggm');?> <a target="_blank" style="color:#006699;font-size:11px" href="<?php echo get_permalink($ticket_id);?>"><?php _e('Remove yourself from the CC','buggm');?></a>
            <table width="1" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <tr>
                        <td>
                            <div style="min-height:5px;font-size:5px;line-height:5px">&nbsp;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
                   &copy; <?php echo date('Y');?>, <?php bloginfo('name');?>
        </div>
	<table width="1" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td>
                        <div style="min-height:15px;font-size:15px;line-height:15px">&nbsp;</div>
                    </td>
                </tr>
            </tbody>
        </table>
       </td>
       <td></td>
  </tr><!--end of footer row -->
 </tbody>
</table>
</body>
</html>
<?php }