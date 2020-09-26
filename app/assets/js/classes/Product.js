class Product {


    constructor(book_id, book_title, book_image_path, book_price_ht, book_price_ttc, book_quantity) {
        this.book_id = book_id
        this.book_title = book_title;
        this.book_image_path = book_image_path;
        this.book_price_ht = book_price_ht;
        this.book_price_ttc = book_price_ttc;
        this.book_quantity = book_quantity;
        this.card = this.setTemplate()
    }


    setTemplate() {
        return (`
                <div class='card-product' id=${this.book_id}>
                    <div class='col'>
                        <img src='${this.book_image_path}' alt='' class='product-presentation'>
                    </div>
                <div class='col'>
                    <h4 class='product-title'>
                        <a href='index.php?controller=book&method=show&id=${this.book_id}'>${this.book_title}</a>
                    </h4>
                    <h5>${this.book_price_ht} &euro; HT</h5>
                    <h5 class="product-price">${this.book_price_ttc} &euro; TTC</h5>
                    <hr class='light my-2'>
                    <form action='index.php?controller=basketitem&method=update' method='post'>
                        <input type='hidden' name='book_id' value='${this.book_id}'>
                            <div class='form-group'>
                                <label for='book_quantity_${this.book_id}'>Quantitée :</label>
                            <div class="number">
                                <input type='number' class='book_quantity' name='book_quantity' id='book_quantity_'${this.book_id}' value='${this.book_quantity}' min='1' required></div></div></form></div><form action='index.php?controller=basketitem&method=destroy' method='POST' class='delete-product'><input type='hidden' name='book_id' value='${this.book_id}'>
                        <button type='submit'>
                            <img src='http://localhost/ecommerce/app/assets/icons/navigation/close.svg' alt='remove product icon'>
                        </button>
                    </form>
                </div>`).trim();
    }


    getTemplate() {
        return this.card
    }


    basketItemExists() {
        return $('#shopping-cart-menu .card-product#' + this.book_id).length > 0
    }


    appendTemplate() {

        if (this.basketItemExists()) {
            $('#shopping-cart-menu .card-product#' + this.book_id).remove();
        }
        $('#shopping-cart-menu').removeClass('closed').addClass('opened');
        setTimeout(() => {
            var emptyBasketImage = $('#empty-basket')
            var basketProductContainer = $('#shopping-cart-menu .container .container-block');
            if (emptyBasketImage.length > 0) {
                $("#see-product").remove();
                $('#empty-basket').remove();
            };

            basketProductContainer.append(this.getTemplate());
            appendArrowInputNumber();
            Product.delete();
            Product.update();
            Product.setBasketNumber()


        }, 750);

    }


    static delete() {

        $('.delete-product').click(function (event) {

            event.preventDefault();

            $.ajax({
                url: "index.php",
                method: "POST",
                data: "controller=basketitem&method=destroy&" + $(this).serialize() + "&remote=true",
                dataType: "JSON",
                success: function (result, status) {
                    $('#shopping-cart-menu').find("#" + result.book_id).remove();
                    if ($("#checkout-confirmation").length > 0) { $('#checkout-confirmation').find("#" + result.book_id).remove(); }
                    Product.setBasketNumber();
                    Basket.updateTotals(result);
                    Product.setCheckoutConfImage();
                },
                error: function (result, error, status) {
                    console.log(status);
                }
            })
        })
    }



    static update() {
        $('.book_quantity').keyup(updateQuantity);
        $('.book_quantity').change(updateQuantity);

    }


    static create(targeted_forms) {
        targeted_forms.forEach(targeted_form => {

            $(targeted_form).submit(function (event) {
                event.preventDefault();
                $.ajax({
                    url: "index.php",
                    method: "POST",
                    data: "controller=basketitem&method=create&" + $(this).serialize() + "&remote=true",
                    dataType: "JSON",
                    success: function (result, status) {
                        if ("book_not_available" in result) {
                            alert(result.book_not_available);
                        } else {
                            const product = new Product(result.book_id, result.book_title, result.book_image_path, result.book_price_ht, result.book_price_ttc, result.book_quantity);
                            product.appendTemplate();
                            Basket.updateTotals(result);
                        }
                    },
                    error: function (result, error, status) {
                        console.log(error)
                    },
                })
            });

        });

    }


    static setCheckoutConfImage() {
        var numberOfItemInBasket = $("#checkout-confirmation .card-product").length;
        if (numberOfItemInBasket == 0) {
            const emptyBasketImage = "<img src='app/assets/icons/illustration/empty-basket.svg' alt='empty basket illustration' id='empty-basket'>";
            $("#checkout-confirmation").append(emptyBasketImage);
            $("#checkout-confirmation").removeClass("container-block").addClass("flex justify-content-center align-items-center")
        };
    }

    static setBasketNumber() {
        var numberOfItemInBasket = $("#shopping-cart-menu .card-product").length;
        $("#shopping-cart-menu h2.article-number").text("Mon panier (" + numberOfItemInBasket + " articles)");
        if (numberOfItemInBasket == 0 && $('img#empty-basket').length == 0) {


            const newLocal = (`
                <img src='app/assets/icons/illustration/empty-basket.svg' alt='empty basket illustration' id='empty-basket'>
                <a href='index.php?controller=book&method=index' class='btn btn-lg btn-success my-2' id='see-product'>Les produits</a>`
            ).trim();


            $("#shopping-cart-menu .container").append(
                newLocal);
        };
        if ($("#basket-price-zone").css('display') == "none" && numberOfItemInBasket > 0) {
            $("#basket-price-zone").css({
                'display': 'block'
            })
        } else if ($("#basket-price-zone").css('display') == "block" && numberOfItemInBasket == 0) {
            $("#basket-price-zone").css({
                'display': 'none'
            });
        }
    }
}


function updateQuantity() {

    var form = $(this).closest('form');

    var quantityInput = form.find('.book_quantity')

    var quantityInputVal = quantityInput.val();

    if (quantityInputVal != "" && typeof (quantityInputVal) == "string") {
        $.ajax({
            url: "/ecommerce/index.php",
            method: "POST",
            data: "controller=basketitem&method=update&" + form.serialize() + "&remote=true",
            dataType: "JSON",
            success: function (result, status) {
                if ("book_not_available" in result) {
                    alert(result.book_not_available);
                } else {
                    quantityInput.val(result.quantity);
                    $('#shopping-cart-menu h2.article-number').text(result.message);
                    Basket.updateTotals(result);
                }

            },
            error: function (result, error, status) {
                console.log(status);
            }
        });
    }

}


$(document).ready(function () {
    Product.create(['.card-product .form-buy', '#show-product-container #form-buy']);
    Product.delete();
    Product.update();
});