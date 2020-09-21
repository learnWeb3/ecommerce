class Basket {


    static updateTotals(ajaxResult) {
        $("#basket-total-TTC").html("Sous-total (HT): " + ajaxResult.basket_total_TTC + " &euro;");
        $("#basket-total-HT").html("Total (TVA incluse):: " + ajaxResult.basket_total_HT + " &euro;");
        $("#basket-total-TTC-checkout").html("Sous-total (HT): " + ajaxResult.basket_total_TTC + " &euro;");
        $("#basket-total-HT-checkout").html("Total (TVA incluse):: " + ajaxResult.basket_total_HT + " &euro;");
    }
    

}