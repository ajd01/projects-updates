<?php
session_start();

function pp_login($user,$pass) {
    global $wpdb;
    $table_name_clients = $wpdb->prefix . "_pp_clients";
    $login_result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name_clients WHERE user = '%s' and password = '%s' ",array($user, $pass)));
    if ($login_result) {
        $_SESSION['pp_user'] = $login_result[0]->user;
        $_SESSION['pp_mail'] = $login_result[0]->mail;
        $_SESSION['pp_name'] = $login_result[0]->name;
        $_SESSION['pp_id'] = $login_result[0]->id;
        return true;
    } else {
        return false;
    }
}

function pp_logout() {
    unset($_SESSION['pp_user']);
    unset($_SESSION['pp_mail']);
    unset($_SESSION['pp_name']);
    unset($_SESSION['pp_id']);
    header($_SERVER['REQUEST_URI']);
    ?>
    <script>
        location.href='?'
    </script>
    <?
}

function pp_render_proyects_table() {
    global $wpdb;
    $table_name_clients = $wpdb->prefix . "_pp_proyect";
    $rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM 
            $table_name_clients WHERE 
            client_id = '%s' ", $_SESSION['pp_id']));
            
    $table_name_updates = $wpdb->prefix . "_pp_proyect_updates";
    ?>
    <table class='wp-list-table widefat fixed striped posts table'>
        <tr style="background-color:#d5d5d5">
            <th class="manage-column ss-list-width">Proyect Name</th>
            <th class="manage-column ss-list-width">Start Date</th>
            <th class="manage-column ss-list-width">End Date</th>
            <th class="manage-column ss-list-width">City</th>
            <th class="manage-column ss-list-width">Country</th>
            <th class="manage-column ss-list-width">Progress</th>
        </tr>
        <?php foreach ($rows as $row) { 
            $progress = $wpdb->get_results("SELECT * from $table_name_updates WHERE id_proyect = $row->id order by `id` asc");
            $progress_last = $wpdb->get_results("SELECT * from $table_name_updates WHERE id_proyect = $row->id order by `id` desc limit 1");
            ?>
            <tr>
                <td class="manage-column" style="width:20%"><?php echo $row->name; ?></td>
                <td class="manage-column" style="width:10%"><?php echo date("d-m-Y",strtotime($row->date_start)); ?></td>
                <td class="manage-column" style="width:10%"><?php echo date("d-m-Y",strtotime($row->date_end)); ?></td>
                <td class="manage-column" style="width:10%"><?php echo $row->city; ?></td>
                <td class="manage-column" style="width:10%"><?php echo $row->country; ?></td>
                <td class="manage-column" style="width:20%" style="background-color: #e3e3e3;">
                <div class="w3-light-grey to_show_progress" onclick="show_hide_('progress_id_<?=$row->id?>')" data-toshow="progress_id_<?=$row->id?>">
                        <div style="width:<?php echo isset($progress_last[0]->progress)?$progress_last[0]->progress:'20'; ?>%;
                                    color: <?php echo isset($progress_last[0]->progress)?'#fff':'#000'; ?> !important;
                                    height: 25px;
                                    cursor:pointer;
                                    text-align: center !important;
                                    background-color: #00acee !important;">
                            <?php echo isset($progress_last[0]->progress)?$progress_last[0]->progress:'0'; ?>%</div>
                    </div><br>
                </td>
            </tr>
        <?php foreach ($progress as $row2) { ?>
                <tr class="progress_id_<?=$row->id?>" style="display:table-row;">
                    <td class="manage-column ss-list-width" style="background-color: #00acee;color:#fff"></td>
                    <td colspan="3" class="manage-column ss-list-width" style="background-color: #00acee;color:#fff">
                        <?php echo $row2->note; ?>
                    </td>
                    <td class="manage-column" style="background-color: #00acee;color:#fff">
                        <?php echo date("d-m-Y",strtotime($row2->date)); ?>
                    </td>
                    <td class="manage-column ss-list-width" style="background-color: #00acee;color:#fff;width:120%">
                        <div class="w3-light-grey">
                            <div style="width:<?php echo $row2->progress; ?>%;
                                        color: <?=$row2->progress<10?'#fff':'#747474 '?> !important;
                                        height: 25px;
                                        text-align: center !important;
                                        background-color: #d5d5d5  !important;">
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
        <?} ?>
    </table><?
    
}


function pp_render_login($login) {?>
    <style>
    @import url(https://fonts.googleapis.com/css?family=Roboto:300);.login-page{width:360px;padding:8% 0 0;margin:auto}.form{position:relative;z-index:1;background:#FFF;max-width:360px;margin:0 auto 100px;padding:45px;text-align:center;box-shadow:0 0 20px 0 rgba(0,0,0,.2),0 5px 5px 0 rgba(0,0,0,.24)}.form button,.form input{font-family:Roboto,sans-serif;outline:0;width:100%;border:0;padding:15px;font-size:14px}.form input{background:#ececee;margin:0 0 15px;box-sizing:border-box}.form button{text-transform:uppercase;background:#00acee;color:#FFF;-webkit-transition:all .3 ease;transition:all .3 ease;cursor:pointer}.form button:active,.form button:focus,.form button:hover{background:#00ace1}.form .message{margin:15px 0 0;color:#b3b3b3;font-size:12px}.form .message a{color:#4CAF50;text-decoration:none}.form .register-form{display:none}
    </style>
    <div class="login-page">
      <div class="form">
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="login-form">
            <p>Know your proyects updates:</p>
          <input type="text" placeholder="Username" name="username"/>
          <input type="password" placeholder="Password" name="password"/>
          <button>Iniciar</button>
          <p style="color: red;"><?=($login=="")?'':$login?></p>
        </form>
      </div>
    </div>  
<?php
}

function pp_render_proyects() {?>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);.form,.topnav{box-shadow:0 0 20px 0 rgba(0,0,0,.2),0 5px 5px 0 rgba(0,0,0,.24)}.form,.topnav a{text-align:center}.login-page{width:100%;padding:8% 0 0;margin:auto}.form{position:relative;z-index:1;background:#FFF;max-width:100%;margin:0 auto 100px;padding:45px}.form button,.form input{font-family:Roboto,sans-serif;outline:0;width:100%;border:0;padding:15px;font-size:14px}.form input{background:#f2f2f2;margin:0 0 15px;box-sizing:border-box}.form button{text-transform:uppercase;background:#4CAF50;color:#FFF;-webkit-transition:all .3 ease;transition:all .3 ease;cursor:pointer}.form button:active,.form button:focus,.form button:hover{background:#43A047}.topnav,.topnav a:hover{background-color:#00acee}.form .message{margin:15px 0 0;color:#b3b3b3;font-size:12px}.form .message a{color:#4CAF50;text-decoration:none}.form .register-form{display:none}.topnav{overflow:hidden}.topnav a{float:left;color:#fff!important;padding:14px 16px;text-decoration:none;font-size:17px}.topnav a:hover{color:#000}.topnav a.active{background-color:#10acee;color:#fff}
    </style>
    <div class="login-page">
        <div class="topnav">
            <a >Your proyects: </a>
            <a ><?=$_SESSION['pp_name']?></a>
            <a href="?logout=1" style="float:right">Logout</a>
        </div> 
      <div class="form">
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="login-form">
            <?=pp_render_proyects_table();?>    
        </form>
      </div>
    </div>  
<?php
}

function pp_login_form(){
    //echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
    if (isset($_GET['logout'])) {
        pp_logout();
        return null;
    }
    if (isset($_SESSION['pp_id'])) {
        pp_render_proyects();
        return null;
    }
    if (isset($_POST['username'])) {
        $login = pp_login($_POST['username'],MD5($_POST['password']));
        if ($login) {
            pp_render_proyects();
        } else {
            pp_render_login($error_);
        }
    } else {
        pp_render_login($login);
    }
}
add_shortcode('proyects_login', 'pp_login_form');