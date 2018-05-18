<?php

function pp_proyects_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/translate-arrays/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Proyects Lsit</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=add_proyect'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "_pp_proyect";
        $rows = $wpdb->get_results("SELECT * from $table_name WHERE status = 1 order by `id` desc");
        $table_name_updates = $wpdb->prefix . "_pp_proyect_updates";
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr style="background-color:#d5d5d5">
                <th class="manage-column ss-list-width">Proyect Name</th>
                <th class="manage-column ss-list-width">Start Date</th>
                <th class="manage-column ss-list-width">End Date</th>
                <th class="manage-column ss-list-width">City</th>
                <th class="manage-column ss-list-width">Country</th>
                <th class="manage-column ss-list-width">Progress</th>
                <th style="width: 40px;">&nbsp;</th>
                <th style="width: 40px;">&nbsp;</th>
                <th style="width: 40px;">&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { 
                $progress = $wpdb->get_results("SELECT * from $table_name_updates WHERE id_proyect = $row->id order by `id` asc");
                $progress_last = $wpdb->get_results("SELECT * from $table_name_updates WHERE id_proyect = $row->id order by `id` desc limit 1");
                ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->name; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->date_start; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->date_end; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->city; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->country; ?></td>
                    <td class="manage-column ss-list-width" style="background-color: #e3e3e3;">
                        <div class="w3-light-grey to_show_progress" onclick="show_hide_('progress_id_<?=$row->id?>')" data-toshow="progress_id_<?=$row->id?>">
                            <div style="width:<?php echo isset($progress_last[0]->progress)?$progress_last[0]->progress+20:'20'; ?>%;
                                        color: #fff !important;
                                        height: 25px;
                                        cursor:pointer;
                                        text-align: center !important;
                                        background-color: #00acee !important;">
                                <?php echo isset($progress_last[0]->progress)?$progress_last[0]->progress:'0'; ?>%</div>
                        </div><br>
                    </td>
                    <td>
                        <form method="post" action="<?php echo admin_url('admin.php?page=add_progress'); ?>">
                            <input type="hidden" name="id" value="<?=$row->id?>" />
                            <button  type='submit' name="delete" class='button' 
                                    style="height: 25px;">
                                <div class="dashicons-before dashicons-plus"><br></div>
                            </button >
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?php echo admin_url('admin.php?page=add_proyect'); ?>">
                            <input type="hidden" name="id" value="<?=$row->id?>" />
                            <button  type='submit' name="edit" class='button' 
                                style="height: 25px;">
                                <div class="dashicons-before dashicons-edit"><br></div>
                            </button >
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?php echo admin_url('admin.php?page=add_proyect'); ?>">
                            <input type="hidden" name="id" value="<?=$row->id?>" />
                            <button  type='submit' name="delete" class='button' 
                                style="height: 25px;"
                                onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
                                <div class="dashicons-before dashicons-trash"><br></div>
                            </button >
                        </form>
                    </td>
                </tr>
                
                <?php foreach ($progress as $row2) { ?>
                    <tr class="progress_id_<?=$row->id?>" style="display:none;">
                        <td class="manage-column ss-list-width"></td>
                        <td colspan="4" class="manage-column ss-list-width" style="background-color: #00ff9c99">
                            <?php echo $row2->note; ?>
                        </td>
                        <td class="manage-column ss-list-width" style="background-color: #00ff9c99;width:120%">
                            <div class="w3-light-grey">
                                <div style="width:<?php echo $row2->progress+20; ?>%;
                                            color: #fff !important;
                                            height: 25px;
                                            text-align: center !important;
                                            background-color: #eec100  !important;">
                                    <?php echo $row2->progress; ?>%</div>
                            </div><br>
                        </td>
                    </tr>
                <? }?>
                <script>
                    function show_hide_(classi) {
                        var x = document.getElementsByClassName(classi);
                        var i;
                        if (x[0].style.display === "none") {
                            for (i = 0; i < x.length; i++) { 
                                x[i].style.display = "table-row";
                            }
                        } else {
                            for (i = 0; i < x.length; i++) {
                                x[i].style.display = "none";
                            }
                        }
                    }
                </script>
            <?php } ?>

        </table>
    </div>
    <style>
    </style>
    <?php
}