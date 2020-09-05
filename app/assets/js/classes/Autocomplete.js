    class Autocomplete {


        static search() {
            $('nav #product-search-terms').keyup(function() {
                Autocomplete.clean();
                if ($(this).val().length > 1) {
                    var formSearch = $(this).parent("#product-search");
                    event.preventDefault();
                    $.ajax({
                        url: '/ecommerce/index.php?controller=search&method=new',
                        method: "POST",
                        data: formSearch.serialize() + "&remote=true",
                        dataType: "JSON",
                        success: function(results, status) {
                            Autocomplete.appendProductTemplate(results);
                        },
                        error: function(result, status, error) {
                            console.log(error)
                        },
                    })
                }
            })
        };


        static activateNavigation() {

            $(".autocomplete-zone .up").click(function() {
                var autocompleteZone = $(this).siblings(".block");
                var scrollPos = autocompleteZone.scrollTop();
                autocompleteZone.scrollTop(scrollPos - 50);
            });

            $(".autocomplete-zone .down").click(function() {
                var autocompleteZone = $(this).siblings(".block");
                var scrollPos = autocompleteZone.scrollTop();
                autocompleteZone.scrollTop(scrollPos + 50);
            });

        }


        static appendProductTemplate(results) {
            results.forEach(result => {

                $('.autocomplete-zone').css({
                    'display': 'block'
                });
                $('.autocomplete-zone .block').append("<div class=\"card-autocomplete\">" +
                    "<div class=\"poster-container\">" +
                    "<img src=\"" + result.book.image_path + "\" alt=\"poster\">" +
                    "</div>" +
                    "<div class=\"description-container\">" +
                    "<h2>" + result.book.title + "</h2>" +

                    "<p class=\"description\">" + result.book.description + "</p>" +

                    "<hr class=\"light my-2\">" +

                    "<ul class=\"other-details my-2\">" +
                    "<li>" + result.category.name + "</li>" +
                    "<li>" + result.book.price + " &euro; </li>" +
                    "</ul>" +

                    "</div>" +
                    "</div>")


            });

        }

        static clean() {
            if ($('.card-autocomplete').length > 0) {
                $('.autocomplete-zone').css({
                    'display': 'none'
                });
                $('.card-autocomplete').remove();
            };
        }
    }