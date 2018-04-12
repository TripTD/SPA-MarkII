<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="<?php echo asset('css/apaapa.css')?>" type="text/css">
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Custom JS script -->
    <script type="text/javascript">

        var checked;
        function checkLogged() {
            $.ajax({
                url: '/login',
                async: false,
                success: function (response) {
                    checked = response['success'] === true;
                }
            });
        }

        $(document).on('click', '.logout', function () {
            $.ajax({
                url: '/logout',
                success: function (response) {
                    if (response['success'] === false) {
                        window.location.hash = '#index';
                        window.onhashchange();
                    }
                }
            });
        });
        $(document).on('click', '.add-to-cart', function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: '/addToCart/' + id,
                success: function () {
                    window.onhashchange();
                }
            });
        });

        $(document).on('click', '.remove-from-cart', function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: '/removeFromCart/' + id,
                success: function () {
                    window.onhashchange();
                }
            });
        });

        $(document).on('submit', '#login', function (e) {
            e.preventDefault();

            var form = new FormData();
            form.append('username', $('form input[name="username"]').val());
            form.append('password', $('form input[name="password"]').val());
            jQuery.ajax('/postLogin', {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                type: 'POST',
                processData: false,
                contentType: false,
                data: form,
                success: function (data) {
                    if (data['success'] === true) {
                        window.location.hash = '#products';
                        window.onhashchange();
                    } else {
                        alert('Wrong Credentials! Try again!');
                        window.onhashchange();
                    }
                }
            });
        });

        $(document).on('submit', '#SendOrder', function (e) {
            e.preventDefault();

            var form;
            form = new FormData();
            form.append('coustomer_name', $('form input[name="client"]').val());
            form.append('email', $('form input[name="email"]').val());
            form.append('comments', $('form input[name="comments"]').val());
            jQuery.ajax('/sendOrder', {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                type: 'POST',
                processData: false,
                contentType: false,
                data: form,
                success: function () {
                    window.onhashchange();
                },
                error: function () {
                    window.onhashchange();
                    alert('Form data validation failed! Pay more attention!');
                }
            });
        });

        $(document).on('click', '.remove-item', function () {
            var id = $(this).attr('data-id');
            $.ajax({
                url: '/products/' + id,
                success: function () {
                    window.onhashchange();
                }
            });
        });

        $(document).on('submit', '#editInsert', function (e) {
            e.preventDefault();

            var form = new FormData();
            var id = $(this).attr('data-id');
            form.append('id', id);
            form.append('Title', $('form input[name="Title"]').val());
            form.append('Description', $('form input[name="Description"]').val());
            form.append('Price', $('form input[name="Price"]').val());
            form.append('Image', $('input[type=file]')[0].files[0]);
            jQuery.ajax('/product', {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                type: 'POST',
                processData: false,
                contentType: false,
                data: form,
                success: function () {
                    window.location.hash = "products";
                }
            });
        });

        $(document).ready(function () {

            function cartIdentifier() {

                var identifier = window.location.hash;

                if (identifier.match(/#cart[0-9]+/)) {
                    return identifier;
                }
                if (identifier.match(/#cart/)) {
                    return identifier;
                }
            }

            function productIdentifier() {

                var identifier = window.location.hash;

                if (identifier.match(/#product[0-9]+/)) {
                    return identifier;
                }
                if (identifier.match(/#product/)) {
                    return identifier;
                }
            }

            function productsIdentifier() {

                var identifier = window.location.hash;
                if (identifier.match(/#products[0-9]+/)) {
                    return identifier;
                }
                if (identifier.match(/#products/)) {
                    return identifier;
                }
            }

            /**
             * A function that takes a products array and renders it's html
             *
             * The products array must be in the form of
             * [{
            *     "title": "Product 1 title",
            *     "description": "Product 1 desc",
            *     "price": 1
            * },{
            *     "title": "Product 2 title",
            *     "description": "Product 2 desc",
            *     "price": 2
            * }]
             */
            function renderList(products, mode) {
                html = [
                    '<tr>',
                    '<th>{{__('Title')}}</th>',
                    '<th>{{ __('Description') }}</th>',
                    '<th>{{ __('Price') }}</th>',
                    '</tr>'
                ].join('');

                $.each(products, function (key, product) {
                    html += [
                        '<tr>',
                        '<td><img src="/storage/Images/' + product.image + '" class="ap2"></td>',
                        '<td>' + product.title + '</td>',
                        '<td>' + product.description + '</td>',
                        '<td>' + product.price + '</td>'
                    ].join('');

                    if (mode === 'index') {
                        html += [
                            '<td><a data-id="' + product.id + '" class="add-to-cart  button">{{ __('Add to cart') }}</a><td>'
                        ].join('');
                    } else if (mode === 'cart') {
                        html += [
                            '<td><a data-id="' + product.id + '" class="remove-from-cart button">{{ __('Remove from cart') }}</a><td>'
                        ].join('');
                    } else if (mode === 'items') {
                        html += [
                            '<td><a href="#product' + product.id + '" class="edit-item button">{{ __('Edit Item') }}</a><td>',
                            '<td><a data-id="' + product.id + '" class="remove-item button">{{ __('Remove Item') }}</a><td>'
                        ].join('');
                    }
                    html += [
                        '</tr>'
                    ].join('');
                });

                return html;
            }

            function renderLogin() {
                html = [
                    '<form id="login" method="post">',
                    '{{ csrf_field() }}',
                    '<strong>{{__('Username')}}</strong><input type="text" name="username" value =""/><br/>',
                    '<strong>{{__('Password')}}</strong> <input type="password" name="password" value = ""/><br/>',
                    '<input type="submit" name="submit" value="{{__('Submit')}}">',
                    '</form>'
                ].join('');

                return html;
            }

            function renderProduct() {
                html = [
                    '<form id="editInsert" method="post" enctype="multipart/form-data">',
                    '{{ csrf_field() }}',
                    '<strong>{{ __('Title') }}</strong> <input type="text" name="Title" value=""/><br/>',
                    '<strong>{{ __('Description') }}</strong> <input type="text" name="Description" value=""/><br/>',
                    '<strong>{{ __('Price') }}</strong> <input type="number" name="Price" value=""/><br/>',
                    '<strong>{{ __('Image') }}</strong> <input type="file" name="Image">',
                    '<input type="submit" name="submit" value="{{ __('Submit') }}">',
                    '</form>'
                ].join('');

                return html;
            }

            function renderSendOrder() {
                html = [
                    '<form id="SendOrder" method="POST">',
                    '{{ csrf_field() }}',
                    '<strong>{{ __('Name') }}</strong><input type="text" name="client" value=""><br>',
                    '<strong>{{ __('Contact details') }}</strong> <input type="text" name="email" value=""><br>',
                    '<strong>{{ __('Comments') }}</strong><input type="text" name="comments" value=""><br>',
                    '<input type="submit" name="submit" value="{{ __('Check Out!') }}">',
                    '</form>'
                ].join('');

                return html;
            }

            /**
             * URL hash change handler
             */
            window.onhashchange = function () {
                // First hide all the pages
                $('.page').hide();
                console.log(checked);
                switch (window.location.hash) {
                    case cartIdentifier():
                        // Show the cart page
                        $('.cart').show();
                        // Load the cart products from the server
                        $.ajax('/cart', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the cart list
                                $('.cart .list').html(renderList(response, 'cart'));
                                $('.cart .send-order').html(renderSendOrder());
                            }
                        });
                        break;
                    case productsIdentifier():
                        checkLogged();
                        if (checked) {
                            // Show the products page
                            $('.products').show();
                            // Load the  products from the server
                            $.ajax('/products', {
                                dataType: 'json',
                                success: function (response) {
                                    // Render the products in the store list
                                    $('.products .list').html(renderList(response, 'items'));
                                }
                            });
                            break;
                        } else {
                            window.location.hash = "#login";
                            window.onhashchange();
                            break;
                        }
                        break;
                    case productIdentifier() :
                        checkLogged();
                        if (checked) {
                            //Show the product page
                            $('.product').show();
                            //Load the form for product
                            var id = window.location.hash.match(/[0-9]+/);
                            if (id === null) {
                                $.ajax('/product/' + null, {
                                    dataType: 'html',
                                    success: function () {
                                        $('.product .edit-insert').html(renderProduct());
                                    }
                                });
                                break;
                            } else {
                                $.ajax('/product/' + id[0], {
                                    dataType: 'html',
                                    success: function () {
                                        $('.product .edit-insert').html(renderProduct());
                                    }
                                });
                                break;
                            }
                        } else {
                            window.location.hash = "#login";
                            window.onhashchange();
                        }
                        break;
                    case '#login':
                        checkLogged();
                        if (!checked) {
                            //Show the login page
                            $('.login').show();
                            $.ajax('/login', {
                                dataType: 'html',
                                success: function () {
                                    $('.login .credentials').html(renderLogin());
                                }
                            });
                        } else {
                            window.location.hash = "#products";
                            window.onhashchange();
                        }
                        break;
                    default:
                        // If all else fails, always default to index
                        // Show the index page
                        $('.index').show();
                        // Load the index products from the server
                        $.ajax('/', {
                            dataType: 'json',
                            success: function (response) {
                                // Render the products in the index list
                                $('.index .list').html(renderList(response, 'index'));
                            }
                        });
                        break;

                }
            };

            window.onhashchange();
        });
    </script>
</head>
<body>
<!-- The index page -->
<div class="page index">
    <!-- The index element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to go to the cart by changing the hash -->
    <a href="#cart" class="button">Go to cart</a><br>

    <!-- A link to go to the login by changing the hash -->
    <a href="#login" class="button">Log In</a>

</div>

<!-- The cart page -->
<div class="page cart">
    <!-- The cart element where the products list is rendered -->
    <table class="list"></table>

    <!-- The cart element where the order is sent -->
    <div class="send-order"></div>

    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">Go to index</a>

</div>

<!-- The login page -->
<div class="page login">
    <!-- The login form -->
    <div class="credentials"></div>

    <!-- A link to go to the index by changing the hash -->
    <a href="#" class="button">Go to index</a>

</div>

<!-- The products page -->
<div class="page products">
    <!-- The index element where the products list is rendered -->
    <table class="list"></table>

    <!-- A link to add a new product to the store -->
    <a href="#product" class="add-item button">Add item</a><br>

    <!-- A link to log off from the admins pages -->
    <a href="#" class="logout button"> Log Out</a>

</div>

<!-- The product page -->
<div class="page product">
    <!-- The product from -->
    <div class="edit-insert">

    </div>

</div>

</body>
</html>