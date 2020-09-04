class Product {


    constructor(book_id, book_title, book_image_path, book_price, book_quantity) {
        this.book_id = book_id
        this.book_title = book_title;
        this.book_image_path = book_image_path;
        this.book_price = book_price;
        this.book_quantity = book_quantity;
        this.card = this.setTemplate()
    }


    setTemplate() {
        return "<div class='card-product' id=" + this.book_id + ">" +
            "<div class='col'>" +
            "<img src='" + this.book_image_path + "' alt='' class='product-presentation'>" +
            " </div>" +
            "<div class='col'>" +

            "<h4 class='product-title'> <a href='" + "index.php?controller=book&method=show&id=" + this.book_id + "'>" + this.book_title + "</a> </h4>" +
            "<h5 class='product-price'>" + this.book_price + "</h5>" +

            "<hr class='light my-2'>" +

            "<form action='index.php?controller=basketitem&method=update' method='post'>" +

            "<input type='hidden' name='book_id' value='" + this.book_id + "'>" +

            "<div class='form-group'>" +

            "<label for='book_quantity_" + this.book_id + "'>Quantitée :</label>" +

            "<input type='number' class='book_quantity' name='book_quantity' id='book_quantity_'" + this.book_id + "' value='" + this.book_quantity + "' min='1' required>" +
            " </div>" +

            "</form>" +
            "</div>" +

            "<form action='index.php?controller=basketitem&method=destroy' method='POST' class='delete-product'>" +

            "<input type='hidden' name='book_id' value='" + this.book_id + "'>" +
            "<button type='submit'> <img src='http://localhost/ecommerce/app/assets/icons/navigation/close.svg' alt='remove product icon'></button>" +

            "</form>" +

            "</div>"
    }


    getTemplate() {
        return this.card
    }


    appendTemplate() {
        $('#shopping-cart-menu').removeClass('closed').addClass('opened');
        setTimeout(() => {
            var emptyBasketImage = $('#empty-basket')
            var basketProductContainer = $('#shopping-cart-menu .container .container-block');
            if (emptyBasketImage.length > 0) {
                $("#see-product").remove();
                $('#empty-basket').remove();
            };

            basketProductContainer.append(this.getTemplate());

            Product.delete();
            Product.update();
            Product.setBasketNumber()

        }, 750);

    }


    static delete() {

        $('.delete-product').click(function(event) {

            event.preventDefault();

            $.ajax({
                url: "/ecommerce/index.php",
                method: "POST",
                data: "controller=basketitem&method=destroy&" + $(this).serialize() + "&remote=true",
                dataType: "JSON",
                success: function(result, status) {
                    $("#" + result.book_id).remove();
                    Product.setBasketNumber();
                    Basket.updateTotals(result);
                },
                error: function(result, error, status) {
                    console.log(status);
                }
            })
        })
    }


    static update() {
        $('.book_quantity').keyup(function() {

            var form = $(this).closest('form');

            var quantityInput = form.find('.book_quantity')

            var quantityInputVal = quantityInput.val();

            if (quantityInputVal != "" && typeof(quantityInputVal) == "string") {
                $.ajax({
                    url: "/ecommerce/index.php",
                    method: "POST",
                    data: "controller=basketitem&method=update&" + form.serialize() + "&remote=true",
                    dataType: "JSON",
                    success: function(result, status) {
                        quantityInput.val(result.quantity);
                        $('#shopping-cart-menu h2.article-number').text(result.message);
                        Basket.updateTotals(result);
                    },
                    error: function(result, error, status) {
                        console.log(status);
                    }
                });
            }

        });

    }


    static create() {

        $('.card-product .form-buy').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "/ecommerce/index.php",
                method: "POST",
                data: "controller=basketitem&method=create&" + $(this).serialize() + "&remote=true",
                dataType: "JSON",
                success: function(result, status) {
                    const product = new Product(result.book_id, result.book_title, result.book_image_path, result.book_price, result.book_quantity);
                    product.appendTemplate();
                    Basket.updateTotals(result);
                },
                error: function(result, error, status) {
                    console.log(error)
                },
            })
        });



    }


    static setBasketNumber() {
        var numberOfItemInBasket = $("#shopping-cart-menu .card-product").length;
        $("#shopping-cart-menu h2.article-number").text("Mon panier (" + numberOfItemInBasket + " articles)");
        if (numberOfItemInBasket == 0) {
            $("#shopping-cart-menu .container").append(
                "<img src='app/assets/icons/illustration/empty-basket.svg' alt='empty basket illustration' id='empty-basket'>" +
                "<a href='' class='btn btn-lg btn-success my-2' id='see-product'>Les produits</a>");
        };
    }
}


$(document).ready(function() {
    Product.create();
    Product.delete();
    Product.update();
});