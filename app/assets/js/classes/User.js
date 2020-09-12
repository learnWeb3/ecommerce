class User
{
    constructor(email,password)
    {
        this.email = email;
        this.password=password;
    }

    create(){
        $.ajax({
            url:"/ecommerce/index.php",
            method:"POST",
            data:"controller=user&method=create&" + $(this).serialize() + "&remote=true",
            dataType:"JSON",
            success:function(results,status){

            },
            error:function(XhrObject,error,status)
            {
                
            }
        });
    }

    destroy(){
        $.ajax({
            url:"/ecommerce/index.php",
            method:"POST",
            data:"controller=user&method=destroy&" + $(this).serialize() + "&remote=true",
            dataType:"JSON",
            success:function(results,status){

            },
            error:function(XhrObject,error,status)
            {
                
            }
        });
    }
}