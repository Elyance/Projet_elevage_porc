<div class="nav-header">
    <div class="brand-logo">
        <a href="#">
            <b class="logo-abbr"><img src="<?= STATIC_URL ?>/assets/images/logo.png" alt=""> </b>
            <span class="logo-compact"><img src="<?= STATIC_URL ?>/assets/images/logo-compact.png" alt=""></span>
            <span class="brand-title">
                <img src="<?= STATIC_URL ?>/assets/images/logo-text.png" alt="">
            </span>
        </a>
    </div>
</div>

<div class="header">    
    <div class="header-content clearfix">
        <div class="header-right">
            <ul class="clearfix">
                <li class="icons dropdown">
                    <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                        <span class="activity active"></span>
                        <?php 
                            $imagePath = '';
                            if (isset($_SESSION['user_role_id']) && $_SESSION['user_role_id'] == 1) {
                                $imagePath = STATIC_URL.'/assets/images/Henloalt.png';
                            } else {
                                $imagePath = STATIC_URL.'/assets/images/Henlo.png';
                            }
                        ?>
                        <img src="<?= $imagePath ?>" height="40" width="40" alt="">
                    </div>
                    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                        <div class="dropdown-content-body">
                            <ul>
                                <li>
                                    <i class="icon-user"></i> <span><?= $_SESSION['user'] ?></span>
                                </li>
                                <hr class="my-2">
                                <li><a href="<?= BASE_URL ?>/logout"><i class="icon-key"></i> <span>Logout</span></a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>