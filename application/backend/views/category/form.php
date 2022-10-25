<?php
$params = $this->arrParams;
$data = @$params['form'];

// ID
$inputID = '';
if (@$params['id']){
    $inputID = FormBackend::inputHidden('hidden', 'form[id]', $data['id']);
  
}

$valuesStatus = ['default' => ' - Select Status - ', 'active' => 'Active', 'inactive' => 'Inactive'];

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
        'label' => FormBackend::label("form[status]","Status"),
        'input' => FormBackend::select('form[status]', $valuesStatus, @$data['status']),
        'type'  => 'input'
    ],

    [
        'label' => FormBackend::label('form[ordering]', 'Ordering'),
        'input' => FormBackend::inputOrdering('form[ordering]', @$data['ordering']),
        'type'  => 'number'
    ],

    [
        'label' => FormBackend::label("form[picture]","Picture"),
        'input' => FormBackend::inputImage('picture'),
        'type'  => 'file'
    ],

   
    [
        'input' => FormBackend::inputHidden('form[token]', time()),
        'type'  => 'input-hidden'
    ],
];
$xhtmlForm = FormBackend::showForm($arrElements);




?>

<?= @$this->errors; ?>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="card card-outline card-info">
        <div class="card-body">
            <?= $xhtmlForm ?>
        </div>
        <div class="card-footer">
            <?= $btnSave . $btnCancel ?>
        </div>
    </div>
</form>