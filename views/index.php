<!-- main column -->
<?php //dump($entries);?>

    <div class="content">
        <h1>Form Pemesanan</h1>
    </div>
    <div class="content"> 
        <form action="#" method="post" id="pesan">
        <div id="wizard">
            <div class="alert alert-error hide" id="errorMessage"> Silahkan pesan produk terlebih dahulu 
            <button type="button" class="close" data-target="alert">x</button></div>
            <h2>Pilih Produk</h2>
            <section>
                <div>
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($entries as $item ): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $item['product_code']; ?></td>
                                    <?php 
                                            $tglSekarang = date('Y-m-d');
                                            $tglPromo = date('Y-m-d', $item['deadline_promo']);
                                            $harga = 0;
                                            if($tglSekarang <= $tglPromo ):
                                                $harga = $item['harga_promo'];
                                    ?>
                                    <td><?php echo "Rp. "; echo number_format($harga, 2,",","."); ?></td>
                                    <?php else: 
                                                $harga = $item['harga']; ?>
                                    <td><?php echo "Rp. "; echo number_format($harga, 2,",","."); ?></td>
                                    <?php endif; ?>
                                    <td><input type="text" name="qty[<?php echo $item['id']; ?>]" class="input-mini products qty-<?php echo $item['type']['key']; ?>" 
                                        data-product-id="<?php echo $item['id']; ?>" data-product-name="<?php echo $item['product_code']; ?>" 
                                        data-product-harga="<?php echo $harga ?>" value="0"></td>
                                </tr>
                                <?php $i++; endforeach; ?>
                            </tbody>
                        </table>
                </div>
            </section>

            <h2>Email Tryout</h2>
            <section>
                <div>
                    <p>Karena Anda memesan paket tryout online lebih dari satu (kolektif), Anda harus mendaftarkan email sebanyak tryout yang Anda pesan untuk nanti kami kirimi kode aktivasi try out online ke masing-masing alamat email. Satu email untuk satu pengguna try out. Pastikan email yang Anda masukkan valid.</p>
                        <table class="table table-bordered table-condensed" id="emaillist">
                            <tbody>
                                
                            </tbody>
                        </table>
                </div>
            </section>

            <h2>Data Diri</h2>
            <section>
                <div>
                    <p>Masukkan data diri Anda disini. Pastikan alamat surat / email yang Anda masukkan valid agar produk yang kami kirimkan tidak salah alamat. Alamat email yang diisikan di form ini adalah alamat email yang akan kami kirimi konfirmasi pemesanan dan produk digital (apabila Anda memesan).</p>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Nama Depan</td>
                                    <td><input type="text" class="span5 nama-depan" name="nama_depan"></td>
                                </tr>
                                <tr>
                                    <td>Nama Belakang</td>
                                    <td><input type="text" class="span5 nama-belakang" name="nama_belakang"></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><input type="text" class="span5 email-primer" name="email"></td>
                                </tr>
                                <tr>
                                    <td>Alamat Kirim</td>
                                    <td><textarea class="span5 alamat" name="alamat" class="input-large" rows="3"></textarea></td>
                                </tr>
                                <tr>
                                    <!-- <?php dump($wilayah); ?> -->
                                    <td>Wilayah Pengiriman</td>
                                    <td>
                                            <?php echo form_dropdown('wilayah', $wilayah, 'all'); ?>

                                     <!--    <select class="span5" name="wilayah" id="wilayah">
                                            <option value="jabodetabek">Jabodetabek</option>
                                            <option value="liar-jabodetabek">Luar Jabodetabek</option>
                                        </select> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Sekolah</td>
                                    <td><input type="text" class="span5 sekolah" name="sekolah"></td>
                                </tr>
                                <tr>
                                    <td>Provinsi Sekolah</td>
                                    <td>
                                        <select class="span5 provinsi" name="provinsi" id="provinsi">
                                            <option value="jabar">Jawa Barat</option>
                                            <option value="jateng">Jawa Tengah</option>
                                            <option value="jatim">Jawa Timur</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat Lengkap Sekolah</td>
                                    <td><textarea class="span5 alamat-sekolah" name="alamat" class="input-large" rows="3"></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </section>

            <h2>Konfirmasi</h2>
            <section>
                <div>
                    <p>Berikut resume pemesanan beserta data pengiriman Anda. Silakan diperbaiki apabila ada kesalahan. Bila data sudah benar, silakan klik tombol Selesai untuk konfirmasi pemesanan. Setelah data pemesanan kami terima, kami akan mengirimkan invoice pemesanan ke alamat email Anda.</p>
                    

                    <section>
                        <div>
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Kuantitas</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>

                                    <tbody id="data-produk">
                                    </tbody>
                                    <tfoot id="total-harga">

                                    </tfoot>
                                </table>
                        </div>
                    </section>

                        <!-- <div>
                            <table border="1">
                                <thead>
                                    <tr class="title">
                                        <th width="150px">Nama Produk</th>
                                        <th width="150px">Harga</th>
                                        <th width="150px">Jumlah</th>
                                        <th width="150px">Total</th>
                                    </tr>
                                </thead>
                                
                                <tbody id="data-produk">
                                    <tr>
                                        <td></td>
                                        <td></td> 
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                    <tr id="total-harga">

                                    </tr>
                            </table>
                            

                            <br>
                            
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="5" class="title"><em>Order Items</em></th>
                                    </tr>
                                    <tr>
                                        <th>Product Code</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>

                                <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="text-align:right"><strong>Total Bayar</strong></td>
                                            <td><strong></strong></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    <ul id="data-email"></ul>
                    <div id="data-diri"></div>
                </div> -->
            </section>
        </div>
        </form>
    </div>

    <script>
    jQuery(function($){
        function errorPlacement(error, element){
                element.before(error);
            }
        // function isNumber (o) {
        //     return ! isNaN (o-0) && o !== null && o !== "" && o !== false;
        // }

        $('#pesan').validate({
            // errorPlacement: errorPlacement;
        });

        $tryout_qty = 0;
        $digital_qty = 0;
        $fisik_qty = 0;
        
        $("#wizard").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "none",

            onStepChanging: function (event, currentIndex, newIndex) { 
                // cek jika berada pada tab list pesan produk
                if(currentIndex === 0){
                    $tryout_qty = 0;
                    $('.qty-tryout').each(function(i, v){
                        $tryout_qty += parseInt($(v).val());
                    });

                    $digital_qty = 0;
                    $('.qty-digital').each(function(i, v){
                        $digital_qty += parseInt($(v).val());
                    });
                    $fisik_qty = 0;
                    $('.qty-fisik').each(function(i, v){
                        $fisik_qty += parseInt($(v).val());
                    });

                    if($tryout_qty === 0 && $digital_qty === 0 && $fisik_qty === 0){
                        $('#errorMessage').show();
                        return false;
                    }
                    
                    // ambil data pesanan
                    var pdata = new Array();
                    var i=0;
                        $('.products').each(function(i, v){
                            pdata[i] = { product_id: $(v).attr('data-product-id'),
                                        product_name: $(v).attr('data-product-name'),
                                        product_harga: $(v).attr('data-product-harga'),
                                        product_qty: $(v).val() };
                            i++;
                        });

                    $.cookie('products', JSON.stringify(pdata));

                }

                // cek jika berada pada tab list email
                if(currentIndex === 1){
                    $('#errorMessage').hide();
                    var edata = new Array();
                    var i=0;

                    $('.email').each(function(i, v){
                        edata[i] = $(v).val();
                        i++;
                    });

                    $.cookie('email', JSON.stringify(edata));
                }
                // cek jika berada pada tab data diri
                if(currentIndex === 2){
                    $('#errorMessage').hide();
                    // menyimpan field nama depan ke cookie
                    var namaDepan = new Array();
                    var i=0;
                    $('.nama-depan').each(function(i, v){
                        namaDepan[i] = $(v).val();
                        i++;
                    });
                    $.cookie('nama-depan', JSON.stringify(namaDepan));
                    
                    // menyimpan field nama belakang ke cookie
                    var namaBelakang = new Array();
                    var i=0;
                    $('.nama-belakang').each(function(i, v){
                        namaBelakang[i] = $(v).val();
                        i++;
                    });
                    $.cookie('nama-belakang', JSON.stringify(namaBelakang));

                    // menyimpan field email ke cookie
                    var emailPrimer = new Array();
                    var i=0;
                    $('.email-primer').each(function(i, v){
                        emailPrimer[i] = $(v).val();
                        i++;
                    });
                    $.cookie('email-primer', JSON.stringify(emailPrimer));

                    // menyimpan field alamat ke cookie
                    var alamat = new Array();
                    var i=0;
                    $('.alamat').each(function(i, v){
                        alamat[i] = $(v).val();
                        i++;
                    });
                    $.cookie('alamat', JSON.stringify(alamat));
                    // menyimpan field wilayah ke cookie
                    var wilayah = new Array();
                    var i=0;
                    $('#wilayah').each(function(i, v){
                        wilayah[i] = $(v).val();
                        i++;
                    });
                    $.cookie('wilayah', JSON.stringify(wilayah));

                    // menyimpan field sekolah ke cookie
                    var sekolah = new Array();
                    var i=0;
                    $('.sekolah').each(function(i, v){
                        sekolah[i] = $(v).val();
                        i++;
                    });
                    $.cookie('sekolah', JSON.stringify(sekolah));

                    // menyimpan field provinsi ke cookie
                    var provinsi = new Array();
                    var i=0;
                    $('.provinsi').each(function(i, v){
                        provinsi[i] = $(v).val();
                        i++;
                    });
                    $.cookie('provinsi', JSON.stringify(provinsi));

                    // menyimpan field alamat sekolah ke cookie
                    var alamatSekolah = new Array();
                    var i=0;
                    $('.alamat-sekolah').each(function(i, v){
                        alamatSekolah[i] = $(v).val();
                        i++;
                    });
                    $.cookie('alamat-sekolah', JSON.stringify(alamatSekolah));
                }

                return true;
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                if (currentIndex === 1 && priorIndex === 0 && $tryout_qty <= 1){
                    $("#wizard").steps("next");
                }   
                if (currentIndex === 1 && priorIndex === 2 && $tryout_qty <= 1){
                    $("#wizard").steps("previous");
                }

                if (currentIndex === 1 && priorIndex === 0 && $tryout_qty > 1){
                    $('#emaillist tbody').empty();
                    // alert($tryout_qty);                
                    for(var i=1; i<=$tryout_qty; i++ ){
                        $('#emaillist tbody').append('<tr><td>Email '+i+'</td><td><input type="text" class="span5 input-large email" name="email['+i+']"></td></tr>');
                    }
                }

                // step konfirmasi
                if (currentIndex === 3 && priorIndex === 2){
                    // menampilkan data produk yang disimpan di cookie
                    var order = JSON.parse($.cookie('products'));
                    console.log(order);
                    var hargaTotal = 0
                    $('#data-produk').empty();
                    for(var i=0; i < order.length; i++){
                        if(order[i].product_qty > 0){
                            var totalbiaya = order[i].product_harga * order[i].product_qty;
                            hargaTotal += totalbiaya;
                            $('#data-produk').append('<tr><td>' + order[i].product_name + '</td><td>' + order[i].product_harga + '</td><td>' + order[i].product_qty + '</td><td>' + totalbiaya + '</td></tr>');
                        }
                    }
                    console.log(hargaTotal);
                    $('#total-harga').append('<tr><td><b>Total Bayar</b></td><td>' + hargaTotal + '</td>');
                    // menampilkan data email yang disimpan di cookie
                    if($tryout_qty > 1){
                        var emaillist = JSON.parse($.cookie('email'));
                        console.log(emaillist);
                        $('#data-email').empty();
                            for(var j=0; j < $tryout_qty; j++){
                                $('#data-email').append('<li>' + emaillist[j] + '</li>');
                            }
                    }

                    /* menampilkan data diri yang disimpan di cookie */
                    // menampikan data nama depan
                    var namadepan = JSON.parse($.cookie('nama-depan'));
                    console.log(namadepan);
                    $('#data-diri').empty();
                        for(var k=0; k < namadepan.length; k++){
                            $('#data-diri').append('<li>' + namadepan[k] + '</li>');
                        }

                    // menampikan data nama belakang
                    var namabelakang = JSON.parse($.cookie('nama-belakang'));
                    console.log(namabelakang);
                        for(var k=0; k < namabelakang.length; k++){
                            $('#data-diri').append('<li>' + namabelakang[k] + '</li>');
                        }

                    // menampikan data email
                    var dataemail = JSON.parse($.cookie('email-primer'));
                    console.log(dataemail);
                        for(var k=0; k < dataemail.length; k++){
                            $('#data-diri').append('<li>' + dataemail[k] + '</li>');
                        }

                    // menampikan data alamat pribadi
                    var alamat = JSON.parse($.cookie('alamat'));
                    console.log(alamat);
                        for(var k=0; k < alamat.length; k++){
                            $('#data-diri').append('<li>' + alamat[k] + '</li>');
                        }

                    // menampikan data wilayah pengiriman
                    var wilayah = JSON.parse($.cookie('wilayah'));
                    console.log(wilayah);
                        for(var k=0; k < wilayah.length; k++){
                            $('#data-diri').append('<li>' + wilayah[k] + '</li>');
                        }

                    // menampikan data sekolah
                    var sekolah = JSON.parse($.cookie('sekolah'));
                    console.log(sekolah);
                        for(var k=0; k < sekolah.length; k++){
                            $('#data-diri').append('<li>' + sekolah[k] + '</li>');
                        }

                    // menampikan data provinsi
                    var provinsi = JSON.parse($.cookie('provinsi'));
                    console.log(provinsi);
                        for(var k=0; k < provinsi.length; k++){
                            $('#data-diri').append('<li>' + provinsi[k] + '</li>');
                        }

                    // menampikan data alamat sekolah
                    var alamatSekolah = JSON.parse($.cookie('alamat-sekolah'));
                    console.log(alamatSekolah);
                        for(var k=0; k < alamatSekolah.length; k++){
                            $('#data-diri').append('<li>' + alamatSekolah[k] + '</li>');
                        }

                    /* akhir dari menampilkan data diri */
                }

                $('#wizard .content').height($('.body.current').children('div').height() + 50);
            },

        });

        $('.close').click(function(){
            $('.'+$(this).attr('data-target')).hide();
        })

    })
    </script>

    <?php dump($entries); ?>
