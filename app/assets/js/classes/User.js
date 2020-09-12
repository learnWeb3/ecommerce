class User
{
    constructor(email,password)
    {
        this.email = email;
        this.password=password;
    }

    static create(targetedSelector){
        $(targetedSelector).click(function () {

            $(targetedSelector).parent("form").submit(function (event) {

                event.preventDefault();

                $.ajax({
                    url: "/ecommerce/index.php",
                    method: "POST",
                    data: "controller=user&method=create&" + $(this).serialize() + "&remote=true",
                    dataType: "JSON",
                    success: function (results, status) {
                        console.log(results);
                    },
                    error: function (XhrObject, error, status) {

                        console.log(error);
                    }
                });
            }).submit()

        });

    }

    static destroy(){
        $.ajax({
            url:"/ecommerce/index.php",
            method:"POST",
            data:"controller=user&method=destroy&" + $(this).serialize() + "&remote=true",
            dataType:"JSON",
            success:function(results,status){
                console.log(results);
            },
            error:function(XhrObject,error,status)
            {
                console.log(error);
            }
        });
    }
}