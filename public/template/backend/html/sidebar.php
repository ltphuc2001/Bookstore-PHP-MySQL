<?php 
  
   
?>
<aside class="main-sidebar sidebar-dark-info elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo $this->_dirImg ?>default-user.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="index.php?module=backend&controller=dashboard&action=index" class="d-block">Lê Tấn Phúc</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="index.php?module=backend&controller=dashboard&action=index" class="nav-link " data-active="dashboard">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link " data-active="group">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Group<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?module=backend&controller=group&action=index" class="nav-link" data-active="index">
                                <i class="nav-icon fas fa-list-ul"></i>
                                <p>List</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="index.php?module=backend&controller=group&action=form" class="nav-link " data-active="form">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>Form</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="user">
                        <i class="nav-icon fas fa-user"></i>
                        <p>User<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?module=backend&controller=user&action=index" class="nav-link" data-active="index">
                                <i class="nav-icon fas fa-list-ul"></i>
                                <p>List</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="index.php?module=backend&controller=user&action=form" class="nav-link" data-active="form">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>Form</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-active="category">
                        <i class="nav-icon fas fa-thumbtack"></i>
                        <p>Category<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?module=backend&controller=category&action=index" class="nav-link" data-active="index">
                                <i class="nav-icon fas fa-list-ul"></i>
                                <p>List</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="index.php?module=backend&controller=category&action=form" class="nav-link" data-active="form">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>Form</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link" data-active="book">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Book<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?module=backend&controller=book&action=index" class="nav-link" data-active="index">
                                <i class="nav-icon fas fa-list-ul"></i>
                                <p>List</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="index.php?module=backend&controller=book&action=form" class="nav-link" data-active="form">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>Form</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="" class="nav-link" data-active="book">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Cart<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?module=backend&controller=cart&action=index" class="nav-link" data-active="index">
                                <i class="nav-icon fas fa-list-ul"></i>
                                <p>List</p>
                            </a>
                        </li>
                    </ul>
                </li>
               

              
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>