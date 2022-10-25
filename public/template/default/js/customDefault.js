
//JS ADD CART
function addCartItem(bookId, price, quantity = null){
  let qty = 1;
  if(quantity != null){
    qty = quantity;
  }else{
    qty = 1;
  }
  $.ajax({
      type: 'post',
      dataType: 'json',
      url: 'http://localhost/Bookstore-PHP-MySQL/project-final/order.html',
      data: {book_id: bookId, price: price, quantity: qty},
      success: function (data) {
        console.log(data);
          $('#quantity-cart').text(data);
          $('#quantity-cart').notify("Đã thêm vào giỏ hàng", {className: 'success', position:"bottom right", autoHideDelay: 2500});
      }
  })
 
}




$(document).ready(function(){

  if($('a.btn-add-item-cart').length){
    let linkItemCart = $('a.btn-add-item-cart').attr('href');
    

    let linkDefault = linkItemCart.replace('quantity', 1);
    $('a.btn-add-item-cart').attr('href', linkDefault);

    $('.btn-qty').click(function(){
        let qty     = $('#quantity-item').val();

        let link    = linkItemCart.replace('quantity', '\''+qty+'\'');
        $('a.btn-add-item-cart').attr('href', link);
       
    })
   
  }

  $('.btn-submit').click(function(e){
    e.preventDefault();
    let element = $(this);
    let url     = element.data("url");
    console.log(url);

    $("#admin-form").attr("action", url);
    $('#admin-form').submit();
   
  });

  $('.my-product-tab').click(function(){
    console.log(123);
   
  });



  //JQUERY BUY
  $('.btn-buy').click(function(e){
    e.preventDefault();
  
    let url = $(this).attr('href');
    let element = $('#cart');
   
    console.log(url);
   
    $.ajax({
      type: "POST",
      url,
      data: $(this).serialize(),
      success: function(res){
       console.log(res);
      },
      dataType: "json"
    });
   
    element.notify("Số lượng đã được cập nhật", {
      className: "success",
      position: "bottom center",
      });
   $('#admin-form').submit();
  
  });

//JQUERY CHANGE QUANTITY
  $('.changeQty').on('change', function () {
    let currentValue = $(this).val();
    let url = $(this).data('url').replace('value_new', currentValue);
    let element = $(this);
    
    console.log(url);
    if(currentValue >= 1 && Number.isInteger(parseFloat(currentValue))){
      $.ajax({
        type: "POST",
        url,
        //data: $(this).serialize(),
        success: function(res){
            
        },
        dataType: "json"
      });
     
      $('#admin-form').submit();
    }else{
      $('.input-number').val(1);
    }
  
  });


});


