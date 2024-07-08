<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8" />
    <title>Data Products</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
        .card-content:hover {
            box-shadow: 1px 1px 1px grey;
            transform: translate(-5px, -5px);
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Data Product</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="form-group row">
                            <label for="search" class="col-form-label col-md-3">Cari Produk</label>
                            <div class="col-md-5">
                                <input type="text" name="search" id="search" class="form-control" placeholder="Cari Produk....">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content"></div>

                <nav aria-label="Page navigation example" class="mt-4 text-center">
                    <ul class="pagination text-center">
                        <li class="page-item" id="prev-page-item"><a class="page-link" id="prev-page-link" href="#">Previous</a></li>
                        <li class="page-item pages"><a class="page-link" href="#">1</a></li>
                        <li class="page-item pages"><a class="page-link" href="#">2</a></li>
                        <li class="page-item pages"><a class="page-link" href="#">3</a></li>
                        <li class="page-item" id="next-page-item"><a class="page-link" id="next-page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var api_key = '123456';
        var data_product = [];

        var loadData = function(url = 'http://127.0.0.1:8000/api/product/get-data', with_loading = true) {
            //Load data Product
            if (with_loading == true) {
                Swal.fire({
                    title: 'Loading... ',
                    html: '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'api-key': api_key
                },
                dataType: 'json',
                success: function(res) {
                    data_product = res.data.data;

                    col = 1;
                    max_col = 4;
                    html = '';
                    for (let i = 0; i < res.data.data.length; i++) {
                        product = res.data.data[i];

                        if (col == 1) {
                            html += '<div class="row mt-3">';
                        }

                        //row
                        html += '<div class="col-md-3">\
                            <div class="card card-content" data-id="' + product.id + '">\
                                <div class="card-header bg-white">\
                                    <h5>' + product.brand + '</h5>\
                                </div>\
                                <div class="card-body">\
                                    <p>' + product.brand + ' ' + product.model + '</p>\
                                    <h5>' + product.price + '</h5>\
                                </div>\
                            </div>\
                        </div>';

                        if (col == max_col) {
                            html += '</div>';
                            col = 1;
                        } else {
                            col++;
                        }
                    }

                    $('.content').html(html);

                    //cek data
                    if (res.data.data.length < 1) {
                        $('.content').html('<p>Data Product not found.</p>');
                    }

                    //Load pagination
                    html = '';
                    for (let i = 0; i < res.data.links.length; i++) {
                        link = res.data.links[i];

                        page_class = ''
                        if (link.url == null) {
                            page_class += 'disabled';
                        }

                        if (link.active == true) {
                            page_class = 'active';
                        }

                        //row
                        html += '<li class="page-item pages ' + page_class + '"><a class="page-link" href="' + link.url + '">' + link.label + '</a></li>';
                    }

                    $('.pagination').html(html);

                    Swal.close();
                },
                error: function(xhr) {
                    Swal.close();
                    alert('Error get data product');
                }
            });
        }

        $(function() {
            loadData();

            $('#search').on('keyup', function(e) {
                key = $(this).val();
                url = 'http://127.0.0.1:8000/api/product/get-data?key_search=' + key;

                loadData(url, false);
            });

            $('body').on('click', '.page-link', function(e) {
                e.preventDefault();
                $('#search').val('');
                url = $(this).attr('href');
                loadData(url);
            });

            $('body').on('click', '.card-content', function(e) {
                e.preventDefault();
                id = $(this).data('id');
                index = data_product.findIndex(val => val.id == id);
                console.log(index);
                if (index >= 0) {
                    data = data_product[index];
                    html = '<h5>' + data.brand + ' ' + data.model + '</h5>\
                        <p>CPU : '+ data.cpu +'</p>\
                        <p>RAM : '+ data.ram +'</p>\
                        <p>Hardisk : '+ data.hardisk +'</p>\
                        <p>Screen Size : '+ data.screen_size +'</p>\
                        <p>Color : '+ data.color +'</p>\
                        <p>OS : '+ data.os +'</p>\
                        <p>Grapich : '+ data.graphics +'</p>\
                        <p>Grapich Coprocessor : '+ data.graphics_coprocessor +'</p>\
                        <p>CPU Speed : '+ data.cpu_speed +'</p>\
                        <p>Rating : '+ data.Rating +'</p>\
                        <h5>Price : '+ data.price +'</h5>';

                    $('.modal-body').html(html);

                    $('#detailModal').modal('show');
                }
            })
        });
    </script>
</body>

</html>