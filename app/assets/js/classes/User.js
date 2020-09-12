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
                        if (results.hasOwnProperty("type") && results.type == "danger")
                        {
                            $("#sign-container").append("<div id='alert' class='"+results.type+"'><img src='app/assets/icons/navigation/close.svg' alt='' id='close'></div>");
                            
                            results.message.foreach(function(e){
                                $("#alert").append("<p>"+e+"</p>")
                            });

                           
                
                        }
                    },
                    error: function (XhrObject, error, status) {

                        console.log(error);
                    }
                });
            })

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