<?php
$params = $this->arrParams;
$data = @$params['form'];

$xhtml = '';

$rowId = FormBackend::rowText('ID', 'form[id]', $data['id']);
$rowUserName = FormBackend::rowText('Username', 'form[username]', $data['username']);
$rowEmail = FormBackend::rowText('Email', 'form[email]', $data['email']);
$rowFullName = FormBackend::rowText('Fullname', 'form[fullname]', $data['fullname']);
$rowToken = FormBackend::inputHidden('form[token]', time());

$xhtml = $rowId . $rowUserName . $rowEmail . $rowFullName . $rowToken;
// Button
$btnSave = HelperBackend::button('submit', 'Save', 'btn-success');
$linkCancel = URL::createLink($params['module'], $params['controller'], 'index');
$btnCancel = HelperBackend::buttonLink($linkCancel, 'Cancel', 'btn-danger');

?>
<?= @$this->errors; ?>
<form action="" method="POST">
    <div class="card card-outline card-info">
        <div class="card-body">
            
             <?= $xhtml; ?>

            <div class="form-group">
                <label>Password </label>

                <div class="d-flex">
                    <button type="button" class="btn btn-info btn-generate-password mr-1 text-nowrap btn-generate"><i class="fas fa-sync"></i> Generate</button>
                    <input type="text" id="form[password]" class="form-control" name="form[password]" value="">
                </div>

            </div>
        </div>
        <div class="card-footer">
            <input type="submit" class="btn btn-success " value="Save">
            <?= $btnCancel ?>
        </div>
    </div>
</form>