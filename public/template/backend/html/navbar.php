<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="index.html" role="button">
                <i class="fas fa-eye"></i> View Site
            </a>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo $this->_dirImg ?>default-user.jpg" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">ADMIN</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-info">
                    <img src="<?php echo $this->_dirImg ?>default-user.jpg" class="img-circle elevation-2" alt="User Image">

                    <p>Lê Tấn Phúc <small>Admin</small></p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                    <a href="index.php?module=backend&controller=account&action=logout" class="btn btn-default btn-flat float-right">Log out</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>