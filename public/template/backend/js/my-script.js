

$(document).ready(function(){


  function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
    return result;
  }


    //JQUERY DELETE
  $(".btn-delete").click(function(e){
      e.preventDefault();
      let url = $(this).attr("href");
      console.log(url);
     showConfirm('Bạn có muốn xoá không').then((result) => {
        if (result.isConfirmed) {
         $("#form-table").attr("action", url);
         $('#form-table').submit();
        }       
      });
      
  });

    

   
   
  //JQUERY GENERATE PASSWORD
  $('.btn-generate').click(function(){
      let pass = makeid(12);
      $("input[name='form[password]']").attr("value", pass);
      
  });
  
  // JQUERY CHANGE STATUS
    $('.btn-status').click(function(){
      let element = $(this);
      let url     =element.data("url");
      console.log(url);
      $.ajax({
        url,
        success: function (res) {
          element.data("url", res.link);
          element.removeClass(res.removeClass).addClass(res.addClass);
          element.find("i").removeClass(res.removeIcon).addClass(res.addIcon);
          element.notify("Cập nhật thành công", {
            className: "success",
            position: "top center",
          });
          
        },
        dataType: "json",
      });
    });

    $('.btn-showHome').click(function(){
      let element = $(this);
      let url     =element.data("url");
      console.log(url);
      $.ajax({
        url,
        success: function (res) {
          element.data("url", res.link);
          element.removeClass(res.removeClass).addClass(res.addClass);
          element.find("i").removeClass(res.removeIcon).addClass(res.addIcon);
          element.notify("Cập nhật thành công", {
            className: "success",
            position: "top center",
          });
          
        },
        dataType: "json",
      });
    });

    $('.btn-group-acp').click(function(){
      let element = $(this);
      let url  =element.data("url");
      console.log(url);
      $.ajax({
        url,
        success: function (res) {
          console.log(res)
          element.data("url", res.link);
          element.removeClass(res.removeClass).addClass(res.addClass);
          element.find("i").removeClass(res.removeIcon).addClass(res.addIcon);
          element.notify("Cập nhật thành công", {
            className: "success",
            position: "top center",
          });
          
        },
        dataType: "json",
      });
    });

    //JQUERY CHANGE ORDERING
    $('.chkOrdering').on('change', function () {
      let element   = $(this);
      let url       = element.data("url");
      let value     = element.val();
      url = url.replace("value_new", value);
      console.log(url);
      $('#form-table').attr("action", url);
      $('#form-table').submit();
      
    });

    

    $("#bulk-apply").click(function(){
      let url = $(this).data("url");
      let slbValue = $("#bulk-action").val();
      let checkboxes = $('input[name = "cid[]"]:checked').length;
      console.log(url);
      if(slbValue != ''){
          if(checkboxes > 0 ){
            url = url.replace("value_new", slbValue);
            $('#form-table').attr("action", url);
            $('#form-table').submit();
          }else{  
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Vui lòng chọn ít nhất 1 dòng dữ liệu',
            })
            
          }
          
      }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Vui lòng chọn Action',
          })
      }

    });

    $('.slb-change-attr').on('change', function () {
      let value = $(this).val();
      let url = $(this).data('url');
      console.log(url);
      url = url.replace("value_new", value);
      $('#form-table').attr("action", url);
      $('#form-table').submit();
    });


    


    $('#check-all-cid').change(function () {
      let checked = $(this).is(':checked');
      $('input[name="cid[]').prop('checked', checked);
    });
  
    $('#filter_group_acp').change(function(e) {
      $('#form-filter').submit();
    });

    $('#filter_group_id').change(function(e) {
      $('#form-filter').submit();
    });
    
    $('#filter_category').change(function(e) {
      $('#form-filter').submit();
    });

    $('#filter_special').change(function(e) {
      $('#form-filter').submit();
    });
    
    
  
  
   

    //SWEETALERT
    
    function showToast(title, icon = 'warning') {
      Toast.fire({
          icon,
          title,
      });
    }

  function showConfirm(title, text = '', icon = 'warning') {
      return Swal.fire({
          title,
          text,
          icon,
          position: 'top',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Đồng ý',
          cancelButtonText: 'Hủy',
      });
    }

    
});
  
  
  
  
  
  