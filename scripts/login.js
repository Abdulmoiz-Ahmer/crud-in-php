$(
    function(){
      $("form[name='login']").validate({
          rules:{
            username:{
                required:true
            },
            password:{
                required:true
            }
          },
          messages:{

          },
          submitHandler: function(form){
              form.submit();
          }
      })  
    }
);
