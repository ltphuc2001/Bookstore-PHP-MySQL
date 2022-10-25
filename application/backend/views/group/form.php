<?php
$params = $this->arrParams;
$data = @$params['form'];

// ID
$inputID = '';
if (@$params['id']) $inputID = FormBackend::inputHidden('hidden', 'form[id]', $data['id']);
$valuesGroupACP = ['default' => ' - Select Group ACP - ', 'yes' => 'Yes', 'no' => 'No'];
$valuesStatus = ['default' => ' - Select Status - ', 'active' => 'Active', 'inactive' => 'Inactive'];

// Name
// $lblName = FormBackend::label('form[name]', 'Name');
// $inputName = FormBackend::inputText('form[name]', @$data['name']);
// $rowName = FormBackend::rowForm($lblName, $inputName);

// // Group ACP
// $lblGroupACP = FormBackend::label('group_acp','Group ACP');
// $valuesGroupACP = ['default' => ' - Select Group ACP - ', 'active' => 'Active', 'inactive' => 'Inactive'];
// $slbGroupACP = FormBackend::select('form[group_acp]', $valuesGroupACP, @$data['group_acp']);
// $rowGroupACP = FormBackend::rowForm($lblGroupACP, $slbGroupACP);

// // Status
// $lblStatus = FormBackend::label('group_status','Status');
// $valuesStatus = ['default' => ' - Select Status - ', 'active' => 'Active', 'inactive' => 'Inactive'];
// $slbStatus = FormBackend::select('form[status]', $valuesStatus, @$data['status']);
// $rowStatus = FormBackend::rowForm($lblStatus, $slbStatus);

// // Token
// $inputToken = FormBackend::inputHidden('form[token]', time());

// Button
$btnSave = HelperBackend::button('submit', 'Save', 'btn-success');
$linkCancel = URL::createLink($params['module'], $params['controller'], 'index');
$btnCancel = HelperBackend::buttonLink($linkCancel, 'Cancel', 'btn-danger');

$arrElements = [
    [
        'label' => FormBackend::label('form[name]', 'Name'),
        'input' => FormBackend::inputText('form[name]', @$data['name']),
        'type'  => 'input'
    ],

    [
        'label' => FormBackend::label("form[group_acp]","Group ACP"),
        'input' => FormBackend::select('form[group_acp]', $valuesGroupACP, @$data['group_acp']),
        'type'  => 'input'
    ],

    [
        'label' => FormBackend::label("form[status]","Status"),
        'input' => FormBackend::select('form[status]', $valuesStatus, @$data['status']),
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