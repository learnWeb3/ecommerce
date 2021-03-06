class Admin {
    static getProductDetails(sort_by = "book_updated_at", order = "DESC") {

        var self = Admin;

        $('#search_input').keyup(function () {

            let form = $(this).parents('form');

            $.get('/ecommerce/index.php?controller=admin&method=index', form.serialize() + "&sort_by=" + sort_by + "&order=" + order + '&remote=true', function (results) {
                let products = JSON.parse(results);
                let parameters = products.parameters;
                let categories = products.categories;
                let books = products.books;
                let tvaOptions = products.tvaOptions;

                $('.pagination').find('form#form-page-next').html(getPaginationTemplate(parameters, "next", "chevron_right_white"))

                $('.pagination').find('form#form-page-previous').html(getPaginationTemplate(parameters, "previous", "chevron_left_white"))


                $('#admin-table tbody').children().remove();

                books.map(function (product) {
                    let template = self.getTemplate(product, categories);
                    $('#admin-table').append(template);
                    let categoryId = product.book.category_id;
                    let tvaOptionId = product.book.tva_id;

                    $('#admin-table tbody tr:last-child').find('select.select_book_category').append(getBookCategoryOptions(categoryId, categories));
                    $('#admin-table tbody tr:last-child').find('select.select_book_tva').append(getBookTvaOptions(tvaOptionId, tvaOptions));
                    self.updateProduct();
                    self.destroyProduct();
                });
            });

        });
    }


    static updateProduct() {

        var self = Admin;

        $("#admin-table td input").blur(function () {

            let tr = $(this).parents('tr');
            let form = $(this).closest('form');


            update(form).then(function (product) {

                let categories = product.categories;
                let books = product.books;
                let tvaOptions = product.tvaOptions;
                let template = self.getTemplate(books[0]);
                let bookId = books[0].book.id;
                let categoryId = books[0].book.category_id;
                let tvaOptionId = books[0].book.tva_id;

                tr.replaceWith(template);

                $(`tr#book-${bookId} select.select_book_category`).append(getBookCategoryOptions(categoryId, categories));
                $(`tr#book-${bookId} select.select_book_tva`).append(getBookTvaOptions(tvaOptionId, tvaOptions));
                self.updateProduct();
                self.destroyProduct();

            }).catch(function (error) { console.error(error) });


        });





        $("#admin-table td select").blur(function () {


            let tr = $(this).parents('tr');
            let form = $(this).closest('form');

            update(form).then(function (product) {

                let categories = product.categories;
                let books = product.books;
                let tvaOptions = product.tvaOptions;
                let template = self.getTemplate(books[0]);
                let bookId = books[0].book.id;
                let categoryId = books[0].book.category_id;
                let tvaOptionId = books[0].book.tva_id;

                tr.replaceWith(template);
                $(`tr#book-${bookId} select.select_book_category`).append(getBookCategoryOptions(categoryId, categories));
                $(`tr#book-${bookId} select.select_book_tva`).append(getBookTvaOptions(tvaOptionId, tvaOptions));
                self.updateProduct();
                self.destroyProduct();

            }).catch(function (error) { console.error(error) });

        });
    }


    static sortResults() {

        var self = Admin;


        $(".sort-arrow").click(function () {

            let form = $('#search_input').parents("form");
            let sort_by = $(this).parents('th').attr('id');
            let order = $(this).attr("data");

            resetSort(".sort-arrow");
            getOppositeSort($(this));


            $.get('/ecommerce/index.php?controller=admin&method=index', form.serialize() + "&sort_by=" + sort_by + "&order=" + order + '&remote=true', function (results) {

                let products = JSON.parse(results);
                let categories = products.categories;
                let books = products.books;
                let tvaOptions = products.tvaOptions;
                let parameters = products.parameters;

                $('.pagination').find('form#form-page-next').html(getPaginationTemplate(parameters, "next", "chevron_right_white"))

                $('.pagination').find('form#form-page-previous').html(getPaginationTemplate(parameters, "previous", "chevron_left_white"))


                $('#admin-table tbody').children().remove();

                books.map(function (product) {
                    let template = self.getTemplate(product, categories);
                    $('#admin-table').append(template);
                    let categoryId = product.book.category_id;
                    let tvaOptionId = product.book.tva_id;

                    $('#admin-table tbody tr:last-child').find('select.select_book_category').append(getBookCategoryOptions(categoryId, categories));
                    $('#admin-table tbody tr:last-child').find('select.select_book_tva').append(getBookTvaOptions(tvaOptionId, tvaOptions));
                    self.updateProduct();
                    self.destroyProduct();
                });
            });

        })

    }




    static destroyProduct() {
        $('#admin-table form.delete').submit(function (event) {

            event.stopPropagation();
            event.preventDefault();

            let userConfirm = confirm("Voulez vous r??ellement supprim?? ce produit ?");

            if (userConfirm) {
                let form = $(this);
                destroy(form).then(function (results) {

                    console.log(results);
                    $(`#book-${results.book_id}`).remove();

                }).catch(function (error) {
                    console.error(error);
                });
            }
        })

    }


    // button debug  <button type='submit'>valider</button>
    static getTemplate(product) {
        return (`<tr id='book-${product.book.id}'>
        <td>
            <img src='${product.book.image_path}' alt='${product.book.title} poster' style='height:8rem;width:5rem;'>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <select name='book_category_id' class='select_book_category form-control'>
                </select>
                
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST' >
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <select name='book_tva_id' class='select_book_tva form-control'>
                </select>
                
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_image_path' value='${product.book.image_path}' class='form-control'>
                
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_title' value='${product.book.title}' class='form-control'>
                
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_author' value='${product.book.author}' class='form-control'>
                
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_collection' value='${product.book.collection}' class='form-control'>
                
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_description' value='${product.book.description}' class='form-control'>
                
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_price' value='${product.book.price}' class='form-control'>
                
            </form>
        </td>

        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_stock' value='${product.stock}' class='form-control'>
                
            </form>
        </td>
        <td>
            <img src='/ecommerce/app/assets/icons/action/attach_file_24px_rounded.svg'  alt='atach file icon' class='attach-file'>
        </td>
        <td>
            <form action='index.php?controller=admin&method=destroy' method='POST' class='delete'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <button type='submit'style='background-color:unset;border:none;'><img src='/ecommerce/app/assets/icons/action/Bucket_24px.svg' alt='delete product icon'></button>
                
            </form>
        </td>
        <td>
            <p>${product.book.created_at}</p>
        </td>
        <td>
            <p>${product.book.updated_at}</p>
        </td>
    </tr>`).trim()
    }


    static getCategoriesRepartition() {

        // Create the chart


        const options = {
            chart: {
                type: 'pie',
                renderTo: 'highchart-container-product'
            },
            title: {
                text: 'Repartitions des produits par cat??gorie'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                },
                point: {
                    valueSuffix: '%'
                }
            },

            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },

            series: [{
                name: "Categories",
                colorByPoint: true,
                data: []
            }]
        }



        $.get("index.php?controller=admin&method=index&remote=true&highchart_product=true", function (datas) {
            JSON.parse(datas).map((e) => {
                let {
                    name,
                    y,
                    drilldown
                } = e
                options.series[0].data.push({
                    name: name,
                    y: parseInt(y),
                    drilldown: drilldown
                });
            });
            let chart = new Highcharts.Chart(options);
        });
    }


    static getUserAcquisitionGraph() {

        // Create the chart


        const options = {
            chart: {
                type: 'area',
                backgroundColor: null,
                renderTo: 'highchart-container-user'
            },
            title: {
                text: 'Evolution du nombre de compte utilisateur'
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                title: {
                    text: 'Nombre de compte'
                }
            },
            series: [{
                name: 'Nombre de compte par date',
                data: []
            }]

        };

        const url = "index.php?controller=admin&method=index&remote=true&highchart_user=true";
        $.get(url, function (datas) {

            datas = JSON.parse(datas);
            datas.map((e)=>{
                options.xAxis.categories.push(e.full_creation_date);
                options.series[0].data.push(parseInt(e.user_account_creation_number));

            });
            
            let chart = new Highcharts.Chart(options);
        });
    }

}



function getBookTvaOptions(tvaId, tvaOptions) {
    let optionGroup = '';
    tvaOptions.forEach(element => {
        if (parseInt(element.id) == parseInt(tvaId)) {
            optionGroup = optionGroup + `<option value='${element.id}' selected>${element.code}</option>`;
        } else {
            optionGroup = optionGroup + `<option value='${element.id}'>${element.code}</option>`;
        }
    });
    return optionGroup;
}

function getBookCategoryOptions(categoryId, categories) {
    let optionGroup = '';
    categories.forEach(element => {
        if (parseInt(element.id) == parseInt(categoryId)) {
            optionGroup = optionGroup + `<option value='${element.id}' selected>${element.name}</option>`;
        } else {
            optionGroup = optionGroup + `<option value='${element.id}'>${element.name}</option>`;
        }
    });
    return optionGroup
}


async function update(form) {
    let response = await $.post('/ecommerce/index.php?controller=admin&method=update', form.serialize() + '&remote=true', function (results) {
    });

    console.log(response);

    return JSON.parse(response);
}

async function destroy(form) {
    let response = await $.post('/ecommerce/index.php?controller=admin&method=destroy', form.serialize() + '&remote=true', function (results) {
    });

    return JSON.parse(response);
}

function getOppositeSort(element) {
    if (element.attr('data') == "desc") {
        var dataAttr = "asc";
        var imageSrc = "/ecommerce/app/assets/icons/action/sort_up.svg";
    } else {

        var dataAttr = "desc";
        var imageSrc = "/ecommerce/app/assets/icons/action/sort_down.svg";
    }

    element.attr('src', imageSrc);
    element.attr('data', dataAttr)

}

function resetSort(element) {
    $(element).each(function (index) {
        let dataAttr = "desc";
        let imageSrc = "/ecommerce/app/assets/icons/action/sort_down.svg";
        $(this).attr('src', imageSrc);
        $(this).attr('data', dataAttr);
    })
}

function getPaginationTemplate(parameters, type, imageName) {
    let inputs = '';

    for (const key in parameters) {
        if (key != 'remote') { inputs += `<input type="hidden" name='${key}' value='${parameters[key]}'></input>`; }
    }

    if (type == 'next') {
        inputs += `<input type="hidden" name='start' value='25'></input>`;
    } else {
        inputs += `<input type="hidden" name='start' value='0'></input>`;
    }

    inputs += `<button type='submit' class='btn btn-lg btn-primary' id='${type}'><img src='/ecommerce/app/assets/icons/action/${imageName}.svg' alt='icon right page'></button>`;

    return inputs;
}
