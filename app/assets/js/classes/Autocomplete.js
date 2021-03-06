    class Autocomplete {


        static search() {
            $('nav #product-search-terms').keyup(function() {
                Autocomplete.clean();
                if ($(this).val().length > 1) {
                    var formSearch = $(this).parent("#product-search");
                    event.preventDefault();
                    $.ajax({
                        url: 'index.php',
                        method: "POST",
                        data: formSearch.serialize() + "&controller=search&method=new&remote=true",
                        dataType: "JSON",
                        success: function(results, status) {
                            Autocomplete.appendProductTemplate(results.books);
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
                const productTemplate = (
                    `<div class="card-autocomplete">
                                    <div class="poster-container">
                                        <img src="${result.book.image_path}" alt="poster">
                                    </div>
                        <div class="description-container">
                            <h2><a href ="index.php?controller=book&method=show&id=${result.book.id}">${result.book.title}</a></h2>
                            <p class="description">${result.book.description}</p>
                            <hr class="light my-2">
                            <ul class="other-details my-2">
                                <li>${result.category.name}</li>
                                <li>${result.book.price} &euro; </li>
                            </ul>
                        </div>
                    </div>`).trim();

                $('.autocomplete-zone .block').append(productTemplate)

            });

            $(window).on("mousemove", function(event) {

                if (event.pageX > ($(window).width() * .75)) {

                    Autocomplete.clean();

                }
            })

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