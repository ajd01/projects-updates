<?php

function client_list() {
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/translate-arrays/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Client Lsit</h2>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo admin_url('admin.php?page=add_client'); ?>">Add New</a>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "_pp_clients";
        $rows = $wpdb->get_results("SELECT * from $table_name WHERE status = 1 order by `id` desc");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr style="background-color:#d5d5d5">
                <th class="manage-column ss-list-width">Name</th>
                <th class="manage-column ss-list-width">Mail</th>
                <th class="manage-column ss-list-width">Address</th>
                <th class="manage-column ss-list-width">User</th>
                <th class="manage-column ss-list-width">Status</th>
                <th style="width: 40px;">&nbsp;</th>
                <th style="width: 40px;">&nbsp;</th>
                <th style="width: 40px;">&nbsp;</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->name; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->mail; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->address; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->user; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->status=='1'?'Active':'Inactive'; ?></td>

                    <td>
                        <form method="post" action="<?php echo admin_url('admin.php?page=add_client'); ?>">
                            <input type="hidden" name="id" value="<?=$row->id?>" />
                            <button  type='submit' name="edit" class='button' title="Edit  User"
                                style="height: 25px;">
                                <div class="dashicons-before dashicons-edit"><br></div>
                            </button >
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?php echo admin_url('admin.php?page=change_client_password'); ?>">
                            <input type="hidden" name="id" value="<?=$row->id?>" />
                            <button  type='submit' name="edit" class='button' title="Change Password"
                                style="height: 25px;">
                                <div class="dashicons-before dashicons-admin-network"><br></div>
                            </button >
                        </form>
                    </td>
                    <td>
                        <form method="post" action="<?php echo admin_url('admin.php?page=add_client'); ?>">
                            <input type="hidden" name="id" value="<?=$row->id?>" />
                            <button  type='submit' name="delete" class='button' title="Delete User"
                                style="height: 25px;"
                                onclick="return confirm('&iquest;Est&aacute;s seguro de borrar este elemento?')">
                                <div class="dashicons-before dashicons-trash"><br></div>
                            </button >
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <style>
    </style>
    <?php
}