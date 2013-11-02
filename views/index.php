<!-- main column -->
<?php //dump($entries);?>
    <div class="content">
        <h1>Form Pemesanan</h1>
    </div>
    <div class="content"> 
        <form action="<?php echo site_url('order/selesai'); ?>" method="post" id="wizard" style="padding: 0 20px 20px;">
            <div class="stepy-error"></div>
            <fieldset title="Pilih Produk">
                <legend>Pilih Produk</legend>
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
                                    $tglPromo = date('Y-m-d', $item['promo_deadline']);
                                    $harga = 0; ?>
                                <td>
                                    <?php //kalo masih tanggal promo, harga promo
                                    if($tglSekarang <= $tglPromo ){
                                        $harga = $item['promo_price'];
                                        echo "<abbr title='Promo sampai tanggal ".date("d F Y", $item['promo_deadline'])."'><s>Rp ".
                                        number_format($item['price'], 2,",","."). "</s></abbr> ";
                                    } else {
                                        $harga = $item['price'];
                                    }
                                    echo "<strong>Rp " .number_format($harga, 2,",","."). "</strong>";
                                    ?>
                                    
                                    <small>
                                    <?php // kalo luar jabodetabek
                                    if($item['product_type']['key'] == "fisik"){ 
                                        $hargakirim = $harga + 10000;
                                        echo "<br />(Luar Jabodetabek: <strong>Rp ". number_format($hargakirim, 2,",","."). "</strong>)"; 
                                    }?>

                                    <br>(Pembelian > 5 item: <?php echo "<strong>Rp ". number_format($item['collective_price'], 2,",","."). "</strong>"; ?>)
                                    </small>
                                </td>
                                <td>
                                <input type="text" name="qty[<?php echo $item['id']; ?>]" class="input-mini products qty qty-<?php echo $item['product_type']['key']; ?>" 
                                    data-product-id="<?php echo $item['id']; ?>" data-product-name="<?php echo $item['product_code']; ?>" 
                                    data-product-harga="<?php echo $harga ?>" data-product-kolektif="<?php echo $item['collective_price']; ?>" data-product-type="<?php echo $item['product_type']['key']; ?>" value="0" required>
                                </td>
                            </tr>
                            <?php $i++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>

            <fieldset title="Data Diri">
                <legend>Data Diri</legend>
                <p>Masukkan data diri Anda disini. Pastikan alamat surat / email yang Anda masukkan valid agar produk yang kami kirimkan tidak salah alamat. Alamat email yang diisikan di form ini adalah alamat email yang akan kami kirimi konfirmasi pemesanan dan produk digital (apabila Anda memesan).</p>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Nama Depan</td>
                            <td><input type="text" class="span5 nama-depan" name="nama_depan" required></td>
                        </tr>
                        <tr>
                            <td>Nama Belakang</td>
                            <td><input type="text" class="span5 nama-belakang" name="nama_belakang" required></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><input type="email" class="span5 email-primer" name="email" required></td>
                        </tr>
                        <tr>
                            <td>No. Telepon/HP</td>
                            <td><input type="telepon" class="span5 telepon" name="telepon" required></td>
                        </tr>
                        <tr>
                            <td>Alamat Kirim</td>
                            <td><textarea class="span5 alamat" name="alamat" class="input-large" rows="3" required></textarea></td>
                        </tr>
                        <tr>
                            <!-- <?php dump($wilayah); ?> -->
                            <td>Wilayah Pengiriman</td>
                            <td>
                                <?php echo form_dropdown('wilayah', $wilayah, 'all', 'class="wilayah" required'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Sekolah</td>
                            <td><input type="text" class="span5 sekolah" name="sekolah" required></td>
                        </tr>
                        <tr>
                            <td>Provinsi Sekolah</td>
                            <td>
                                <select class="span5 provinsi" name="provinsi" id="provinsi" required>
                                    <option value="jabar">Jawa Barat</option>
                                    <option value="jateng">Jawa Tengah</option>
                                    <option value="jatim">Jawa Timur</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Alamat Lengkap Sekolah</td>
                            <td><textarea class="span5 alamat-sekolah" name="alamat_sekolah" class="input-large" rows="3"></textarea></td>
                        </tr>
                    </tbody>
                </table>

                <div id="email-list" style="display:none">                    
                    <p>Bila Anda memesan paket Tryout, Anda harus mendaftarkan email sebanyak tryout yang Anda pesan untuk nanti kami kirimi kode aktivasi try out online ke masing-masing alamat email. Satu email untuk satu pengguna try out. Pastikan email yang Anda masukkan valid.</p>
                    <p>Apabila tidak, Anda dapat melangkah ke step berikutnya.</p>
                    <table class="table table-bordered table-condensed" id="emaillist">
                        <tbody></tbody>
                    </table>
                </div>
            </fieldset>

            <fieldset title="Konfirmasi">
                <legend>Konfirmasi</legend>
                <p>Berikut resume pemesanan beserta data pengiriman Anda. Silakan diperbaiki apabila ada kesalahan. Bila data sudah benar, silakan klik tombol Selesai untuk konfirmasi pemesanan. Setelah data pemesanan kami terima, kami akan mengirimkan invoice pemesanan ke alamat email Anda.</p>

                <div><h3> Data Produk</h3></div>
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
                            <tbody id="biaya-kirim">
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
                            <td>No. Telepon/HP</td>
                            <td class="telepon-hp"></td>
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
            </fieldset>

            <input type="submit" value="Selesai" class="button" />
        </form>
    </div>

    <script>
    $(function(){

        // set validasi
        var validator = $('#wizard').validate({
            errorPlacement: function(error, element) {
                $('#wizard div.stepy-error').append(error);
            },
            rules: {
                nama_depan: 'required',
                nama_belakang: 'required',
                email: {
                    required: true,
                    email: true
                },
                alamat: 'required',
                telepon: {
                    required: true,
                    number: true
                },
                sekolah: 'required',
                wilayah: 'required',
                provinsi: 'required'
            },
            messages: {
                nama_depan: "Nama depan harus diisi",
                nama_belakang: "Nama belakang harus diisi",
                email: {
                    required: "Email harus diisi",
                    email: "Isikan alamat email yang valid",
                },
                alamat: "Alamat harus diisi, terutama bila Anda memesan produk fisik",
                telepon: {
                    required: "Nomor telepon harus diisi untuk media konfirmasi pemesanan",
                    number: "Isikan nomor telepon yang valid (masukan angka saja)"
                },
                sekolah: "Nama sekolah harus diisi",
                wilayah: "Wilayah harus diisi",
                provinsi: "Provinsi harus diisi",
            }
        });

        // buat validasi untuk qty produk
        $('input.qty').each(function() {
            $(this).rules('add', {
                required: true,
                number: true,
                min: 0,
                messages: {
                    required: "isikan 0 untuk produk yang tidak dipesan",
                    number: "masukkan angka sebanyak produk yang akan dipesan",
                    min: "isikan minimal 1 untuk memesan, 0 untuk tidak memesan"
                }
            });
        });

        $tryout_qty = 0;
        $digital_qty = 0;
        $fisik_qty = 0;
        var prevIndex = 1;

        $tryout_each = new Array();

        $('#wizard').stepy({

            // dijalankan sebelum melangkah ke step sebelumnya
            back: function(index) {
                console.log("mundur ke " +index);
            },

            // dijalankan sebelum melangkah ke step selanjutnya
            next: function(index) {
                // cek validasi form
                if(! $('#wizard').valid()){
                    return false;
                }

                // sebelum melangkah ke step 2
                if(index == 2){

                    // hitung banyak pesanan
                    $tryout_qty = 0;
                    $('.qty-tryout').each(function(i, v){
                        $tryout_qty += parseInt($(v).val());
                        $tryout_each[i] = {product_id: $(v).data('product-id'), qty: parseInt($(v).val()), name: $(v).data('product-name')};
                    });
                    $digital_qty = 0;
                    $('.qty-digital').each(function(i, v){
                        $digital_qty += parseInt($(v).val());
                    });
                    $fisik_qty = 0;
                    $('.qty-fisik').each(function(i, v){
                        $fisik_qty += parseInt($(v).val());
                    });

                    // kasih peringatan kalo user belum pilih produk apapun
                    if($tryout_qty <= 0 && $digital_qty <= 0 && $fisik_qty <= 0){
                        alert('Pilih dahulu produk yang akan dipesan dengan mengisi kuantitas pada satu atau beberapa produk.');
                        return false;
                    }
                    
                    // ambil data pesanan
                    var pdata = new Array();
                    var i=0;
                        $('input.products').each(function(i, v){
                            pdata[i] = { product_id: $(v).attr('data-product-id'),
                                        product_name: $(v).attr('data-product-name'),
                                        product_harga: $(v).attr('data-product-harga'),
                                        product_type: $(v).attr('data-product-type'),
                                        product_hargaKolektif: $(v).attr('data-product-kolektif'),
                                        product_qty: $(v).val() };
                            i++;
                        });

                    $.cookie('products', JSON.stringify(pdata));
                    console.log(JSON.stringify(pdata));

                    // bila tryout dipesan
                    if($tryout_qty > 0){
                        // pasang form email tryout
                        $('#emaillist tbody').empty();
                        $form_email = "";
                        for(var e=0; e<$tryout_each.length; e++){
                            $form_email += '<tr><th colspan="2">'+$tryout_each[e].name+'</th></tr>';
                            for(var i=1; i<=$tryout_each[e].qty; i++){
                                $form_email += '<tr><td>Email '+i+'</td><td><input type="text" class="span5 input-large email" rel="'+$tryout_each[e].name+'" id="'+$tryout_each[e].product_id+'" name="email['+i+']"></td></tr>';
                            }
                        }
                        $('#emaillist tbody').append($form_email);
                        $('#email-list').show();

                        // buat validasi untuk qty produk
                        $(document).on('input.email', 'each', function() {
                            $(this).rules('add', {
                                required: true,
                                email: true,
                                messages: {
                                    required: "Email akun tryout harus diisi, karena akun tryout akan kami kirimkan ke email tersebut",
                                    email: "masukkan alamat email yang valid"
                                }
                            });
                        });
                    }
                }

                // sebelum melangkah ke step 3
                if(index == 3){

                    // get data email-list buat tryout
                    var edata = new Array(); 
                    var i = 0;
                    $('.email').each(function(i, v){
                        edata[i] = {type: $(v).attr('id'), email: $(v).val(), tryout: $(v).attr('rel')};
                        i++;
                    });
                    $.cookie('email', JSON.stringify(edata));

                    // menyimpan field nama depan ke cookie
                    var ddata = {
                        namaDepan: $('.nama-depan').val(),
                        namaBelakang: $('.nama-belakang').val(),
                        emailPrimer: $('.email-primer').val(),
                        alamat: $('.alamat').val(),
                        telepon: $('.telepon').val(),
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

            // dijalankan setelah melangkah ke step
            select: function(index) {

                // step konfirmasi
                if (index == 3){
                    /* menampilkan data diri yang disimpan di cookie */
                    var dataDiri = JSON.parse($.cookie('ddata'));
                    console.log(dataDiri);

                        $('.nama-depan').empty().append(dataDiri.namaDepan);
                        $('.nama-belakang').empty().append(dataDiri.namaBelakang);
                        $('.email-primer').empty().append(dataDiri.emailPrimer);
                        $('.alamat-kirim').empty().append(dataDiri.alamat);
                        $('.telepon-hp').empty().append(dataDiri.telepon);
                        $('.wilayah-kirim').empty().append(dataDiri.wil);
                        $('.nama-sekolah').empty().append(dataDiri.sekolah);
                        $('.provinsi-sekolah').empty().append(dataDiri.provinsi);
                        $('.alamat-sekolah').empty().append(dataDiri.alamatSekolah);

                        /* akhir dari menampilkan data diri */ 

                    // menampilkan data produk yang disimpan di cookie
                    var order = JSON.parse($.cookie('products'));
                    console.log(order);
                    var hargaTotal = 0;
                    var biayaKirim = 0;
                    $('#data-produk').empty();
                    for(var i=0; i < order.length; i++){
                        if(order[i].product_qty > 0){
                            if(order[i].product_type == 'fisik'){
                                hargaProduk = parseInt(order[i].product_harga) +  parseInt(dataDiri.wilayah);
                            } else {
                                hargaProduk = order[i].product_harga;
                            }

                            if(order[i].product_qty >= 5){
                                hargaProduk = parseInt(order[i].product_hargaKolektif);
                            }

                            var totalbiaya = (hargaProduk * order[i].product_qty);
                            hargaTotal += totalbiaya;

                            $('#data-produk').append('<tr><td>' + order[i].product_name + '</td><td>' + hargaProduk + '</td><td>' + order[i].product_qty + '</td><td>' + totalbiaya + '</td></tr>');
                        }
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
                                $('#data-email').append('<tr><td> Email '+ i +' untuk '+ emaillist[j].tryout +'</td><td>' + emaillist[j].email + '</td></tr>');
                            }
                    }

                }
            },

            finish: function(index) {
                $.ajax({
                    url: "<?php echo site_url('order/simpanPesan'); ?>",
                    type: 'POST',
                    data: {ddata: $.cookie('ddata'), pdata: $.cookie('products'), edata: $.cookie('email')}
                }).done(function(msg) {
                    console.log("selesai " +index);
                    return true;
                });
            },

            backLabel: "&laquo; Sebelumnya",
            nextLabel: "Selanjutnya &raquo;",
            description: false,
            validate: true,
            errorImage: false

        });

    })
    </script>
    <style>
        td {vertical-align: middle !important;}
    </style>