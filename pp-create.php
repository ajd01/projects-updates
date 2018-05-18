<?php

function add_client() {
    global $wpdb;
    $table_name = $wpdb->prefix . "_pp_clients";
    if (isset($_POST['delete'])) {
        $id = $_POST["id"];
        deletePP($table_name,$id);?>
        <div class="updated"><p>Client deleted</p></div>
        <a href="<?php echo admin_url('admin.php?page=client_list') ?>">&laquo; Back to list</a>, in 3 sec.
        <?php echo progrees_bar();?>
        <script>setTimeout(function(){window.location.href='admin.php?page=client_list'},3000);</script>
        <?return null;
    }
    if (isset($_POST['insert'])) {
        $wpdb->insert(
                $table_name, //table
                array('name'=>$_POST['name'],
                'mail'=>$_POST['mail'],
                'address'=>$_POST['address'],
                'user'=>$_POST['user'],
                'password'=>MD5($_POST['password']),
                ), //data
                array('%s', '%s', '%s', '%s', '%s') //data format			
        );
        $message.="Added, Back to list in 3 sec.";?>
        <?php echo progrees_bar();?>
        <script>setTimeout(function(){window.location.href='admin.php?page=client_list'},3000);</script><?
    }
    if (isset($_POST['edit']) || isset($_POST['save_edit'])) {
        $id = $_POST["id"];
        $Client_edit = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE id=".$id);
        if (isset($_POST['save_edit'])) {
            $wpdb->query($wpdb->prepare("UPDATE $table_name SET 
                name='".$_POST['name']."',  
                `mail`='".$_POST['mail']."',  
                `address`='".$_POST['address']."',  
                user='".$_POST['user']."'  
            WHERE id = %s", $id));?>
            <div class="updated"><p>Client Updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=client_list') ?>">&laquo; Back to list</a>, in 3 sec.
            <?php echo progrees_bar();?>
            <script>setTimeout(function(){window.location.href='admin.php?page=client_list'},3000);</script>
            <?return null;
        }
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/proyect-reports/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Add New Client</h2>
        <?php if (isset($message)): ?>
            <div class="updated"><p><?php echo $message; ?></p></div>
            <a href="<?php echo admin_url('admin.php?page=client_list') ?>">&laquo; Back to list</a>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <p>Add new entry</p>
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th width="20%"><a href="<?php echo admin_url('admin.php?page=client_list') ?>">&laquo; Back to list</a></th>
                    <th width="80%"></th>
                </tr>
                <tr>
                    <th class="ss-th-width">Client Name</th>
                    <td><input type="text" name="name" value="<?=$Client_edit[0]->name;?>" class="ss-field-width" required></input></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Mail</th>
                    <td><input type="text" name="mail" value="<?=$Client_edit[0]->mail;?>" class="ss-field-width" ></input></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Address</th>
                    <td><input type="text" name="address" value="<?=$Client_edit[0]->address;?>" class="ss-field-width" ></input></td>
                </tr>
                <tr>
                    <th class="ss-th-width">User</th>
                    <td><input type="text" name="user" value="<?=$Client_edit[0]->user;?>" class="ss-field-width" required></input></td>
                </tr>
                <?if (isset($_POST['edit'])) {?>
                <?} else {?>
                <tr>
                    <th class="ss-th-width">Password</th>
                    <td><input id="password" name="password" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;"  required></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Confirm Password</th>
                    <td><input id="password_two" name="password_two" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');"  required></td>
                </tr>
                <?}?>
                <tr>
                    <th width="20%"></th>
                    <?if (isset($_POST['edit'])) {?>
                        <input type="hidden" name="id" value="<?=$Client_edit[0]->id?>" />
                        <th width="80%"><input type='submit' name="save_edit" value='Save' class='button'></th>
                    <?} else {?>
                        <th width="80%"><input type='submit' name="insert" value='Save' class='button'></th>
                    <?} ?>
                </tr>
            </table>
        </form>
    </div>
    <?php
}
function change_client_password() {
    global $wpdb;
    $table_name = $wpdb->prefix . "_pp_clients";
    if (isset($_POST['insert'])) {
        $id = $_POST["id"];
        global $wpdb;
        $wpdb->query($wpdb->prepare("UPDATE $table_name SET password=%s WHERE id = %s",array(MD5($_POST["password"]),$id)));?>
        <div class="updated"><p>Password Updated</p></div>
        <a href="<?php echo admin_url('admin.php?page=client_list') ?>">&laquo; Back to list</a>, in 3 sec.
        <?php echo progrees_bar();?>
        <script>setTimeout(function(){window.location.href='admin.php?page=client_list'},3000);</script>
        <?return null;
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/proyect-reports/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Client</h2>
        <?php if (isset($message)): ?>
            <div class="updated"><p><?php echo $message; ?></p></div>
            <a href="<?php echo admin_url('admin.php?page=client_list') ?>">&laquo; Back to list</a>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <p>Edit Password</p>
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th class="ss-th-width">Password</th>
                    <td><input id="password" name="password" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.password_two.pattern = this.value;"  required></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Confirm Password</th>
                    <td><input id="password_two" name="password_two" type="password" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');"  required></td>
                </tr>
                <tr>
                    <th width="20%"></th>
                    <th width="80%">
                    <input type="hidden" name="id" value="<?=$_POST['id']?>" />
                    <input type='submit' name="insert" value='Save' class='button'></th>
                </tr>
            </table>
        </form>
    </div>
    <?php
}
function add_proyect() {
    global $wpdb;
    $table_name = $wpdb->prefix . "_pp_proyect";
    $table_clients = $wpdb->prefix . "_pp_clients";
    //clients ids
    $id_clients = $wpdb->get_results("SELECT id,name FROM $table_clients WHERE status = 1");
    if (isset($_POST['insert'])) {
        $wpdb->insert(
                $table_name, //table
                array('name'=>$_POST['name'],
                'date_start'=>$_POST['date_start'],
                'date_end'=>$_POST['date_end'],
                'city'=>$_POST['city'],
                'client_id'=>$_POST['id_client'],
                'country'=>$_POST['country']), //data
                array('%s', '%s', '%s', '%s', '%s') //data format			
        );
        $message.="Added Back to list in 3 sec.";?>
        <?php echo progrees_bar();?>
        <script>setTimeout(function(){window.location.href='admin.php?page=proyects_progress'},3000);</script><?
    }
    if (isset($_POST['delete'])) {
        $id = $_POST["id"];
        deletePP($table_name,$id);?>
        <div class="updated"><p>Proyect deleted</p></div>
        <a href="<?php echo admin_url('admin.php?page=proyects_progress') ?>">&laquo; Back to list</a>
        <?php echo progrees_bar();?>
        <script>setTimeout(function(){window.location.href='admin.php?page=proyects_progress'},3000);</script>
        <?return null;
    }
    if (isset($_POST['edit']) || isset($_POST['save_edit'])) {
        $id = $_POST["id"];
        $wpdb->show_errors = true;
        $proyects = $wpdb->get_results("SELECT id, name, city, country, 
            DATE_FORMAT(date_start, '%Y-%m-%d') as date_start, 
            DATE_FORMAT(date_end, '%Y-%m-%d') as date_end,
            client_id
             FROM ".$table_name." WHERE id=".$id);

        if (isset($_POST['save_edit'])) {
            $wpdb->query($wpdb->prepare("UPDATE $table_name SET 
                name = '".$_POST['name']."',
                date_start = '".$_POST['date_start']."',
                date_end = '".$_POST['date_end']."',
                city = '".$_POST['city']."',
                country = '".$_POST['country']."',
                client_id = '".$_POST['id_client']."'
                WHERE id = %s", $id));?>
            <div class="updated"><p>Proyect Updated</p></div>
            <a href="<?php echo admin_url('admin.php?page=proyects_progress') ?>">&laquo; Back to list</a>
            <?php echo progrees_bar();?>
            <script>setTimeout(function(){window.location.href='admin.php?page=proyects_progress'},3000);</script>
            <?return null;
        }
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/proyect-reports/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Add New Proyect</h2>
        <?php if (isset($message)): ?>
            <div class="updated"><p><?php echo $message; ?></p></div>
            <a href="<?php echo admin_url('admin.php?page=proyects_progress') ?>">&laquo; Back to list</a>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <p>Add new entry</p>
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th width="20%"><a href="<?php echo admin_url('admin.php?page=proyects_progress') ?>">&laquo; Back to list</a></th>
                    <th width="80%"></th>
                </tr>
                <tr>
                    <th class="ss-th-width">Proyect Name</th>
                    <td><input type="text" name="name" value="<?=$proyects[0]->name; ?>" class="ss-field-width" required></input></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Proyect Client</th>
                    <td>
                        <select type="text" name="id_client" class="ss-field-width" style="width:25%" required>
                            <option value="">Select...</option>
                            <?php foreach ($id_clients as $key => $value) { ?>
                                <option value="<?=$value->id;?>"
                                    <?=($proyects[0]->client_id==$value->id)?'selected':''?>>
                                        <?=$value->name;?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th class="ss-th-width">Start Date</th>
                    <td><input type="date" name="date_start" value="<?=$proyects[0]->date_start; ?>" class="ss-field-width" style="width:25%" ></input></td>
                </tr>
                <tr>
                    <th class="ss-th-width">End Date</th>
                    <td><input type="date" name="date_end" value="<?=$proyects[0]->date_end; ?>" class="ss-field-width" style="width:25%" ></input></td>
                </tr>
                <tr>
                    <th class="ss-th-width">City</th>
                    <td><input type="text" name="city" value="<?=$proyects[0]->city; ?>" class="ss-field-width" ></input></td>
                </tr>
                <tr>
                    <th class="ss-th-width">Country</th>
                    <td><input type="text" name="country" value="<?=$proyects[0]->country; ?>" class="ss-field-width" ></input></td>
                </tr>
                <tr>
                    <th width="20%"></th>
                    <?if (isset($_POST['edit'])) {?>
                        <input type="hidden" name="id" value="<?=$proyects[0]->id?>" />
                        <th width="80%"><input type='submit' name="save_edit" value='Save' class='button'></th>
                    <?} else {?>
                    <th width="80%"><input type='submit' name="insert" value='Save' class='button'></th>
                    <?} ?>
                </tr>
            </table>
        </form>
    </div>
    <?php
}


function add_progress() {
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "_pp_proyect_updates";
        $wpdb->insert(
                $table_name, //table
                array('note'=>$_POST['note'],
                'progress'=>$_POST['progress'],
                'id_proyect'=>$_POST['id_proyect'],
                ), //data
                array('%s', '%s') //data format			
        );
        $message.="Added";
        ?><script>setTimeout(function(){window.location.href='admin.php?page=proyects_progress'},3000);</script><?
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/proyect-reports/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Add New Proyect</h2>
        <?php if (isset($message)): ?>
            <div class="updated"><p><?php echo $message; ?></p></div>
            <a href="<?php echo admin_url('admin.php?page=proyects_progress') ?>">&laquo; Back to list</a>
            <?=progrees_bar()?>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <p>Add new entry</p>
            <table class='wp-list-table widefat fixed'>
                <tr>
                    <th width="20%"><a href="<?php echo admin_url('admin.php?page=proyects_progress') ?>">&laquo; Back to list</a></th>
                    <th width="80%"></th>
                </tr>
                <tr>
                    <th class="ss-th-width">Notes</th>
                    <td><textarea type="text" name="note" value="<?php echo $note; ?>" class="ss-field-width" rows="4" cols="70"></textarea></td>
                </tr>
                <tr>
                    <th class="ss-th-width">New Proyect Progress</th>
                    <td>
                        <input type="range" name="progress" id="progress"
                            min="0" 
                            max="100" 
                            step="1" 
                            onChenge=""
                            value="20"/>
                        <span id="valueP"></span>
                        <script>
                            var el = document.getElementById("progress");
                            el.addEventListener("change", function() {
                                document.getElementById("valueP").innerHTML=el.value+" %";
                            }, false);
                        </script>
                    </td>
                </tr>
                <tr>
                    <th width="20%"></th>
                    <input type='hidden' name="id_proyect" value='<?=$_POST['id']?>'>
                    <th width="80%"><input type='submit' name="insert" value='Save' class='button'></th>
                </tr>
            </table>
        </form>
    </div>
    <?php
}


function deletePP($table,$id) {
    global $wpdb;
    $wpdb->query($wpdb->prepare("UPDATE $table SET STATUS=0 WHERE id = %s", $id));
}

function progrees_bar() {?>
    <div class="" style="width:100%">
        <div id="myBar" style="height:4px;width:1%;background-color: #f00;"></div>
    </div>
    <script>
        var elem = document.getElementById("myBar");
        var width = 1;
        var id = setInterval(frame, 20);
        function frame() {
            if (width >= 100) {
                clearInterval(id);
            } else {
                width++;
                elem.style.width = width + '%';
            }
        }
    </script> 
<?}

