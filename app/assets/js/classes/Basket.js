class Basket {


    static updateTotals(ajaxResult) {
        $("#basket-total-TTC").html("Sous-total (HT): " + ajaxResult.basket_total_TTC + " &euro;");
        $("#basket-total-HT").html("Total (TVA incluse):: " + ajaxResult.basket_total_HT + " &euro;");
    }

}