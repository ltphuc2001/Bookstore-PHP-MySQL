<!-- ERROR-->

<?php echo @$this->errors; ?>
<div class="card card-outline card-primary" >
    <div class="card-header text-center">
        <a class="h1 text-dark"><b>ADMIN</b></a>
    </div>
    
    <div class="card-body">
        <p class="login-box-msg text-dark">Vui lòng đăng nhập vào hệ thống</p>
        
        <form action="" method="post" id="form-login">
            <div class="input-group mb-3">
                <input type="text" id="username" name="form[username]" class="form-control" placeholder="Username" >
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" id="password" name="form[password]" class="form-control" placeholder="Password" >
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="hidden" name="form[token]" value="<?php echo time(); ?>" class="form-control" >
                
            </div>

            <div class="row">
                <div class="col-12 float-right">
                    <button type ="submit" class="btn btn-primary btn-block" >Đăng nhập</button>
                </div>
            </div>
           
        </form>

    </div>

</div>