 <table id="ticket-list">
       <thead>
         <tr>
             <th>No. </th><th>Title</th><th>Status</th><th>Type</th><th>Component</th><th>Milestone</th><th>Version</th><th>Priority</th><th>Severity</th><th>Reporter</th>
                </tr>
                </thead>
                <tbody>
            <?php while(have_posts()):the_post();
            $i++;
            if($i%2==0)
                $class='ticket-even';
            else
                $class='ticket-odd';
            ?>
                <tr <?php post_class($class);?> id="ticket-<?php the_ID() ;?>">

                    <td>
                        <a rel="permalink" title="Permalink to <?php  the_title_attribute();?>" href="<?php the_permalink();?> ">#<?php the_ID();?></a>
                    </td> 
                    <td>
                        <a rel="permalink" title="Permalink to <?php  the_title_attribute();?>" href="<?php the_permalink();?> "><?php the_title();?></a>
                    </td>
                    <td><?php echo buggm_ticket_status();?></td>
                    <td><?php echo buggm_get_ticket_type();?></td>
                    <td><?php echo buggm_get_ticket_component();?></td>
                    <td><?php echo buggm_get_ticket_milestone();?></td>
                    <td><?php echo buggm_get_ticket_version();?></td>
                    <td><?php echo buggm_get_ticket_priority();?></td>
                    <td><?php echo buggm_get_ticket_severity();?></td>
                    <td><?php echo buggm_get_the_reporter_name();?></td>
                </tr>  
                 
                
            <?php endwhile;?>
                </tbody>
            </table>    