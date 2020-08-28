class Product {


    constructor(name, url, description, price, quantity) {
        this.name = name;
        this.url = url;
        this.price = price;
        this.quantity = quantity;
        this.description = description
        this.card = this.setTemplate()
    }


    setTemplate() {
        return "<div class='card-product'>" +

            "<div class='col'>" +
            "<img src='' alt='' class='product-presentation'>" +
            " </div>" +
            "<div class='col'>" +

            "<h2 class='product-title'>" + "<a href='" + this.url + "'>" + this.title + "</a>" + "</h2>" +
            "<h4 class='product-price'>" + this.price + "</h4>" +
            "<p class='product-description'>" + this.description + "</p>" +

            "<hr class='light my-2'>" +

            "<form action='' method='post'>" +

            "<input type='hidden' name='product-id' value='<?php ?>'>" +

            "<div class='form-group'>" +

            " <label for=''>Quantitée :</label>" +

            "<input type='number' name='product_quantity' id='' value='" + this.quantity + "' min='1' required>" +
            "</div>" +

            "</form>" +
            "</div>" +

            "<img src='http://localhost/ecommerce/app/assets/icons/navigation/close.svg' alt='remove product icon' class='delete-product'>" +

            "</div>";
    }


    getTemplate() {
        return this.card
    }


    appendTemplate() {
        $('#shopping-cart-menu').removeClass('closed').addClass('opened');
        setTimeout(() => {
            $('#shopping-cart-menu .container-block').append(this.getTemplate())
        }, 750);
    }







}