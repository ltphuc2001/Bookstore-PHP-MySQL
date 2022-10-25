<?php 
$params = $this->arrParams;
$data = @$params['form'];

// $inputID = '';
// if (@$params['id']) $inputID = FormBackend::inputHidden('form[id]', $data['id']);

$valuesStatus = ['default' => ' - Select Status - ', 'active' => 'Active', 'inactive' => 'Inactive'];
$valuesGroupID = $this->groupName;


// Button
$btnSave = HelperBackend::button('submit', 'Save', 'btn-success');
$linkCancel = URL::createLink($params['module'], $params['controller'], 'index');
$btnCancel = HelperBackend::buttonLink($linkCancel, 'Cancel', 'btn-danger');

$arrElements = [
        [
            'label' => FormBackend::label("form[username]","Username"),
            'input' => FormBackend::inputText('form[username]', @$data['username']),
            'type'  => 'input'
        ],


        [
            'label' => FormBackend::label("form[email]","Email"),
            'input' => FormBackend::inputText('form[email]', @$data['email']),
            'type'  => 'input'
        ],

        [
            'label' => FormBackend::label("form[fullname]","Fullname"),
            'input' => FormBackend::inputText('form[fullname]', @$data['fullname']),
            'type'  => 'input'
        ],

        [
            'label' => FormBackend::label("form[password]","Password"),
            'input' => FormBackend::inputText('form[password]', @$data['password']),
            'type'  => 'password'
        ],

        [
            'label' => FormBackend::label("form[telephone]","Số Điện Thoại"),
            'input' => FormBackend::inputText('form[telephone]', @$data['telephone']),
            'type'  => 'input'
        ],

        [
            'label' => FormBackend::label("form[address]","Địa chỉ"),
            'input' => FormBackend::inputText('form[address]', @$data['address']),
            'type'  => 'input'
        ],


        [
            'label' => FormBackend::label("form[status]","Status"),
            'input' => FormBackend::select('form[status]', $valuesStatus, @$data['status']),
            'type'  => 'input'
        ],

        [
            'label' => FormBackend::label("form[group_id]","Group"),
            'input' => FormBackend::select('form[group_id]', $valuesGroupID, @$data['group_id']),
            'type'  => 'input'
        ],

        [
            'input' => FormBackend::inputHidden('form[token]', time()),
            'type'  => 'input-hidden'
        ],
];

$xhtmlForm = FormBackend::showForm($arrElements);


?>






<?= @$this->errors; ?>
<form action="" method="POST">
    <div class="card card-outline card-info">
        <div class="card-body">
            <?= $xhtmlForm ?>
        </div>
        <div class="card-footer">
            <?= $btnSave . $btnCancel ?>
        </div>
    </div>
</form>