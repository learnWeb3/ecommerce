class Admin {
    static getProductDetails() {
        $('#search_input').keyup(function () {
            let inputValue = $(this).val();
            let form = $(this).parents('form');
            if (inputValue.length >= 2) {
                $.post('index.php?controller=search&method=new', form.serialize() + '&remote=true', function (results) {
                    const dbCall = JSON.parse(results);
                    const categories = dbCall.categories;
                    const books = dbCall.books;
                    const tvaOptions = dbCall.tvaOptions;

                    console.log(tvaOptions);

                    $('#admin-table tbody').children().remove();

                    books.map(function (product) {
                        let template = Admin.getTemplate(product, categories);
                        $('#admin-table').append(template);
                        let id = product.book.id;

                        $('#admin-table tbody tr:last-child').find('select.select_book_category').append(getBookCategoryOptions(id, categories));
                        $('#admin-table tbody tr:last-child').find('select.select_book_tva').append(getBookTvaOptions(id, tvaOptions));
                    });
                });
            }
        });
    }


    static getTemplate(product) {
        return (`<tr>
        <td>
            <img src='${product.book.image_path}' alt='${product.book.title} poster' style='height:8rem;width:5rem;'>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <select name='book_category_id' class='select_book_category' class='form-control'>
                </select>
                <button type='submit'>valider</button>
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST' >
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <select name='book_tva_id' class='select_book_tva' class='form-control'>
                </select>
                <button type='submit'>valider</button>
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_image_path' id='book_image_path' value='${product.book.image_path}' class='form-control'>
                <button type='submit'>valider</button>
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_title' id='book_title' value='${product.book.title}' class='form-control'>
                <button type='submit'>valider</button>
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_author' id='book_author' value='${product.book.author}' class='form-control'>
                <button type='submit'>valider</button>
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_collection' id='book_collection' value='${product.book.collection}' class='form-control'>
                <button type='submit'>valider</button>
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_description' id='book_description' value='${product.book.description}' class='form-control'>
                <button type='submit'>valider</button>
            </form>
        </td>
        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_price' id='book_price' value='${product.book.price}' class='form-control'>
                <button type='submit'>valider</button>
            </form>
        </td>

        <td>
            <form action='index.php?controller=admin&method=update' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <input type='text' name='book_stock' id='book_stock' value='${product.stock}' class='form-control'>
                <button type='submit'>valider</button>
            </form>
        </td>
        <td>
            <img src='http://localhost/ecommerce/app/assets/icons/action/attach_file_24px_rounded.svg'  alt='atach file icon' class='attach-file'>
        </td>
        <td>
            <form action='index.php?controller=admin&method=destroy' method='POST'>
                <input type='hidden' name='book_id' value='${product.book.id}'>
                <button type='submit'><img src='http://localhost/ecommerce/app/assets/icons/action/Bucket_24px.svg' alt='delete product icon'></button>
                <button type='submit'>valider</button>
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


function getBookTvaOptions(id, tvaOptions) {
    let optionGroup = '';
    tvaOptions.forEach(element => {
        if (element.id == id) {
            optionGroup = optionGroup + `<option value='${element.id}' selected>${element.code}</option>`;
        } else {
            optionGroup = optionGroup + `<option value='${element.id}'>${element.code}</option>`;
        }
    });
    return optionGroup;
}

function getBookCategoryOptions(id, categories) {
    let optionGroup = '';
    categories.forEach(element => {
        if (element.id == id) {
            optionGroup = optionGroup + `<option value='${element.id}' selected>${element.name}</option>`;
        } else {
            optionGroup = optionGroup + `<option value='${element.id}'>${element.name}</option>`;
        }
    });
    return optionGroup
}