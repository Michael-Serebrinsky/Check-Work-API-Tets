$( document ).ready(function() {
    
    $(document).on("submit", "#buy-now-form", function (e) {
       
        let product     = $("input[name=product-name]").val(),
            currency    = $("select[name=product-currency]").val(),
            price       = $("input[name=product-price]").val();
        if(!product.length || !currency.length || !price.length ){
            alert('All Fields is required');
            return false;
        }
        
        $.ajax({
            url         : "/api/createProduct",
            type        : "POST",
            contentType : "application/json; charset=utf-8",
            data        : JSON.stringify({
                "product-name"      : product,
                "product-price"     : price,
                "product-currency"  : currency
            }),
            success     : function(response){              
              if(response.status == "success"){
                let iframeData = response.data;
                if(iframeData.status_code === 0){
                    let sale_url = iframeData.sale_url;
                    $('#iframe-payme').attr('src',sale_url);
                    $('#mymodal').modal('toggle');     
                    $('#btn-back-to-form').show();
                    $('#buy-now-form button').hide();
                }else{
                    alert(iframeData.status_error_details);
                }
              }else{
                alert(response.message)
              }
            },
            error: function(error) {               
                alert(error.responseJSON.message);
            }
           });
           e.preventDefault();
    }).on('click','#btn-back-to-form',function(){
        $('#mymodal').modal('toggle');  
    });
});