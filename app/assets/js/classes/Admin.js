class Admin {
    static getProductDetails() {
        
        var self = Admin;

        $('#search_input').keyup(function () {
            let inputValue = $(this).val();
            let form = $(this).parents('form');
            if (inputValue.length >= 2) {
                $.post('index.php?controller=search&method=new', form.serialize() + '&remote=true', function (results) {
                    let products = JSON.parse(results);
                    let categories = products.categories;
                    let books = products.books;
                    let tvaOptions = products.tvaOptions;

                    $('#admin-table tbody').children().remove();

                    books.map(function (product) {
                        let template = self.getTemplate(product, categories);
                        $('#admin-table').append(template);
                        let categoryId = books[0].book.category_id;
                        let tvaOptionId = books[0].book.tva_id;

                        $('#admin-table tbody tr:last-child').find('select.select_book_category').append(getBookCategoryOptions(categoryId, categories));
                        $('#admin-table tbody tr:last-child').find('select.select_book_tva').append(getBookTvaOptions(tvaId, tvaOptions));
                        self.updateProduct();
                    });
                });
            }
        });
    }


    static updateProduct()
    {

        var self = Admin;

        $("#admin-table td input").blur(function(){

            let tr = $(this).parents('tr');
            let form = $(this).closest('form');


            update(form).then(function(product){

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
              
            }).catch(function(error){console.error(error)});
           
            
        });

        $("#admin-table td select").blur(function(){

            
            let tr = $(this).parents('tr');
            let form = $(this).closest('form');

            update(form).then(function(product){

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
              
            }).catch(function(error){console.error(error)});
            
        });
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
            <img src='http://localhost/ecommerce/app/assets/icons/action/attach_file_24px_rounded.svg'  alt='atach file icon' class='attach-file'>
        </td>
        <td>
            <form action='index.php?controller=admin&method=destroy' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <button type='submit'><img src='http://localhost/ecommerce/app/assets/icons/action/Bucket_24px.svg' alt='delete product icon'></button>
                
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


async function update(form)
{
    let response = await $.post('index.php?controller=admin&method=update', form.serialize() + '&remote=true', function (results) {
    });

    return JSON.parse(response);
}