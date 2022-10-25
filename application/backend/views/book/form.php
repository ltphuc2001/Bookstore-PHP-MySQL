<?php
$params = $this->arrParams;
$data = @$params['form'];



$valuesStatus = ['default' => ' - Select Status - ', 'active' => 'Active', 'inactive' => 'Inactive'];
$valueCategory = $this->categoryName;
$valueSpecial = ['default' => ' - Select Special - ', 'yes' => 'Yes', 'no' => 'No'];

//Picture
$picture ='';
// if(isset($data['id'])){
//     $src       = 'public' . DS . 'file' . DS . 'book' . DS . $data['picture'];
// }


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
        'label' => FormBackend::label('form[description]', 'Description'),
        'input' => FormBackend::textArea('form[description]',10, @$data['description']),
        'type'  => 'input'
    ],

    [
        'label' => FormBackend::label('form[price]', 'Price'),
        'input' => FormBackend::inputText('form[price]', @$data['price']),
        'type'  => 'number'
    ],

    [
        'label' => FormBackend::label('form[sale_off]', 'Sale Off'),
        'input' => FormBackend::inputText('form[sale_off]', @$data['sale_off'] ),
        'type'  => 'number'
    ],
   
    [
        'label' => FormBackend::label("form[category_id]","Category"),
        'input' => FormBackend::select('form[category_id]', $valueCategory, @$data['category_id']),
        'type'  => 'input'
    ],

    [
        'label' => FormBackend::label("form[status]","Status"),
        'input' => FormBackend::select('form[status]', $valuesStatus, @$data['status'] ),
        'type'  => 'input'
    ],

    [
        'label' => FormBackend::label("form[special]","Special"),
        'input' => FormBackend::select('form[special]', $valueSpecial, @$data['special']),
        'type'  => 'input'
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
<form accept-charset="utf-8" action="" method="POST" enctype="multipart/form-data">
    <div class="card card-outline card-info">
        <div class="card-body">
            <?= $xhtmlForm ?>
        </div>
        <div class="card-footer">
            <?= $btnSave . $btnCancel ?>
        </div>
    </div>
</form>