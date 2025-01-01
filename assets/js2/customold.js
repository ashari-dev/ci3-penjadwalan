///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////// Ready Function /////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

$(document).ready(function(){
    //File Upload
    $



    $('.btnAddToCart').live('click',function(){
        var productId = $(this).attr('data');
        var url = $('#siteUrl').val()+'/cart/addProduct';
        var data = "productId="+productId;
        $.ajax({
            type:'POST',
            url:url,
            data:data,
            async:false,
            success:function(result){
                data = $.parseJSON(result);
                //alert(data.cartCount);
                $('#cartItemCount').text(data.cartCount);
               // $('#btnAddToCart'+productId).css('disabled','disabled');
               jQuery('#btnAddToCart'+productId).attr('disabled', true);
            }
        });
    });

    //Remove Item from Cart
    $(document).on("click",".delbutton",function(){
        var removeProductId = $(this).attr("data");        
        var url = $('#siteUrl').val()+'/cart/removeProduct';
        var info = "removeProductId="+removeProductId;
        if(confirm("Sure you want to delete this record?"))
        {
          $.ajax({
            type: "POST",
            url: url,
            data: info,
            success: function(result){  
              data = $.parseJSON(result); 
              $('#cartItemCount').text(data.cartCount); 
              $('#totalAmmount').html('<strong>$'+data.totalPrice+'</strong>'); 
              $("a[data='"+removeProductId+"']").closest("tr").fadeOut();
            }
          });
          
        }
        return false;
    });

    //Update Item 
    $(document).on("click",".updatebutton",function(){
        var updateProductId = $(this).attr("data");
        var updatedQuantity = $('#quantity_'+updateProductId).val();
        var url = $('#siteUrl').val()+'/cart/updateProduct';
        var info = "updateProductId="+updateProductId+"&updatedQuantity="+updatedQuantity;
        
        $.ajax({
          type: "POST",
          url: url,
          data: info,
          success: function(result){  
            data = $.parseJSON(result); 
            $('#totalAmmount').html('<strong>$'+data.totalPrice+'</strong>');
          }
        });
          
       
        return false;
    });

});
