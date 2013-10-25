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
                                    <td><?php echo "Rp. "; echo number_format($harga, 2,",","."); $hargakirim = $harga + 10000; 
                                                    if($item['type']['key'] == "fisik"){ 
                                                        echo "<br />(Luar Jabodetabek "; 
                                                        echo $hargakirim; 
                                                        echo ")"; 
                                                    }?></td>
                                    <?php else: 
                                                $harga = $item['harga']; ?>
                                    <td><?php echo "Rp. "; echo number_format($harga, 2,",","."); $hargakirim = $harga + 10000; 
                                                    if($item['type']['key'] == "fisik"){ 
                                                        echo "<br />(Luar Jabodetabek "; 
                                                        echo $hargakirim; 
                                                        echo ")"; 
                                                    }?></td>
                                    <?php endif; ?>
                                    <td><input type="text" name="qty[<?php echo $item['id']; ?>]" class="input-mini products qty-<?php echo $item['type']['key']; ?>" 
                                        data-product-id="<?php echo $item['id']; ?>" data-product-name="<?php echo $item['product_code']; ?>" 
                                        data-product-harga="<?php echo $harga ?>" data-product-type="<?php echo $item['type']['key']; ?>" value="0"></td>
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
                                            <?php echo form_dropdown('wilayah', $wilayah, 'all', 'class="wilayah"'); ?>

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
                    
                    <div><b><h3> Data Produk </h3></b></div>
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
                    <div><b><h3> Data Diri </h3></b></div>
                    <table class="table">
                            <tbody>
                                <tr>
                                    <td>Nama Depan</td>
                                    <td class="nama-depan"></td>
                                </tr>
                                <tr>
                                    <td>Nama Belakang</td>
                                    <td class="nama-belakang"></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td class="email-primer"></td>
                                </tr>
                                <tr>
                                    <td>Alamat Kirim</td>
                                    <td class="alamat-kirim"></td>
                                </tr>
                                <tr>
                                    <td>Wilayah Pengiriman</td>
                                    <td class="wilayah-kirim"></td>
                                </tr>
                                <tr>
                                    <td>Nama Sekolah</td>
                                    <td class="nama-sekolah"></td>
                                </tr>
                                <tr>
                                    <td>Provinsi Sekolah</td>
                                    <td class="provinsi-sekolah"></td>
                                </tr>
                                <tr>
                                    <td>Alamat Lengkap Sekolah</td>
                                    <td class="alamat-sekolah"></td>
                                </tr>
                            </tbody>
                    </table>
                    
                    <div><b><h3 id="listemail"></h3></b></div>
                    <table class="table">
                        <tbody id="data-email">
                        </tbody>
                    </table>
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

            // sebelum pindah step
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
                                        product_type: $(v).attr('data-product-type'),
                                        product_qty: $(v).val() };
                            i++;
                        });

                    $.cookie('products', JSON.stringify(pdata));
                    console.log(JSON.stringify(pdata));

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
                // data kan cuma satu, jadi ga perlu di each. buat semua data dalam satu objek
                if(currentIndex === 2){
                    $('#errorMessage').hide();
                    // menyimpan field nama depan ke cookie
                    var ddata = {
                        namaDepan: $('.nama-depan').val(),
                        namaBelakang: $('.nama-belakang').val(),
                        emailPrimer: $('.email-primer').val(),
                        alamat: $('.alamat').val(),
                        wilayah: $('.wilayah').val(),
                        wil: $('.wilayah').children('option:selected').html(),
                        sekolah: $('.sekolah').val(),
                        provinsi: $('.provinsi').val(),
                        alamatSekolah: $('.alamat-sekolah').val(),
                        // dst, dst.
                    }

                    $.cookie('ddata', JSON.stringify(ddata));
                }

                return true;
            },

            // setelah pindah step
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

                    /* menampilkan data diri yang disimpan di cookie */
                    var dataDiri = JSON.parse($.cookie('ddata'));
                    console.log(dataDiri);

                        $('.nama-depan').empty();
                        $('.nama-depan').append(dataDiri.namaDepan);
                        $('.nama-belakang').empty();
                        $('.nama-belakang').append(dataDiri.namaBelakang);
                        $('.email-primer').empty();
                        $('.email-primer').append(dataDiri.emailPrimer);
                        $('.alamat-kirim').empty();
                        $('.alamat-kirim').append(dataDiri.alamat);
                        $('.wilayah-kirim').empty();
                        $('.wilayah-kirim').append(dataDiri.wil);
                        $('.nama-sekolah').empty();
                        $('.nama-sekolah').append(dataDiri.sekolah);
                        $('.provinsi-sekolah').empty();
                        $('.provinsi-sekolah').append(dataDiri.provinsi);
                        $('.alamat-sekolah').empty();
                        $('.alamat-sekolah').append(dataDiri.alamatSekolah);

                        /* akhir dari menampilkan data diri */                    
                    // cek jika produk yg dipesan adalah produk fisik maka + 10000
                    if($fisik_qty >= 1){
                        hargaTotal += parseInt(dataDiri.wilayah) * $fisik_qty;
                    }
                    console.log(hargaTotal);
                    $('#total-harga').empty();
                    $('#total-harga').append('<tr><td colspan="3"><b>Total Bayar</b></td><td>' + hargaTotal + '</td>');
                    
                    // menampilkan data email yang disimpan di cookie
                    if($tryout_qty > 1){
                        $('#listemail').empty();
                        $('#listemail').append('List Email Tryout');
                        var emaillist = JSON.parse($.cookie('email'));
                        console.log(emaillist);
                        $('#data-email').empty();
                            for(var j=0; j < $tryout_qty; j++){
                                var i = 1; i += j;
                                $('#data-email').append('<tr><td> Email '+ i +' </td><td>' + emaillist[j] + '</td></tr>');
                            }
                    }

                }

                $('#wizard .content').height($('.body.current').children('div').height() + 50);
            },

            // ketika akan finishing
            onFinishing: function (event, currentIndex)
            { 
                // 1. cek kelengkapan data


                // 2. kirim data via ajax
                $.ajax({
                    url: "<?php echo site_url('so/simpanPesan'); ?>",
                    type: 'POST',
                    data: {ddata: $.cookie('ddata'), pdata: $.cookie('products'), edata: $.cookie('email')}
                }).done(function(msg) {
                    // script kalo data sudah berhasil disimpan
                    console.log(msg);
                    return true;
                });

            }

        });

        $('.close').click(function(){
            $('.'+$(this).attr('data-target')).hide();
        });

    })
    </script>

    <?php dump($entries); ?>
