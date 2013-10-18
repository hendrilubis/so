<!-- main column -->
<?php //dump($entries);?>

    <div class="content">
        <h1>Form Pemesanan</h1>
    </div>
    <div class="content"> 
        <form action="#" method="post" id="pesan">
        <div id="wizard">
            <div class="alert alert-error hide" id="errorMessage"> kampret 
            <button type="button" class="close" data-target="alert">x</button></div>
            <h2>Pilih Produk</h2>
            <section>
                <div>
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $entries as $item ): ?>
                                <tr>
                                    <td class="check"><input type="checkbox" name="orderit[]"></td>
                                    <td><?php echo $item['product_code']; ?></td>
                                    <?php 
                                            $tglSekarang = date('Y-m-d');
                                            $tglPromo = date('Y-m-d', $item['deadline_promo']);
                                            if($tglSekarang <= $tglPromo ): 
                                    ?>
                                    <td><?php echo "Rp. "; echo number_format($item['harga_promo'], 2,",","."); ?></td>
                                    <?php else: ?>
                                    <td><?php echo "Rp. "; echo number_format($item['harga'], 2,",","."); ?></td>
                                    <?php endif; ?>
                                    <td><input type="text" name="qty[<?php echo $item['id']; ?>]" class="input-mini qty-<?php echo $item['type']['key']; ?>" value="0"></td>
                                </tr>
                                <?php endforeach; ?>
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
                                    <td><input type="text" class="span5" name="nama"></td>
                                </tr>
                                <tr>
                                    <td>Nama Belakang</td>
                                    <td><input type="text" class="span5" name="nama"></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><input type="text" class="span5" name="email"></td>
                                </tr>
                                <tr>
                                    <td>Alamat Kirim</td>
                                    <td><textarea class="span5" name="alamat" class="input-large" rows="3"></textarea></td>
                                </tr>
                                <tr>
                                    <td>Wilayah Pengiriman</td>
                                    <td>
                                        <select class="span5" name="wilayah" id="wilayah">
                                            <option value="jabodetabek">Jabodetabek</option>
                                            <option value="liar-jabodetabek">Luar Jabodetabek</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Sekolah</td>
                                    <td><input type="text" class="span5" name="sekolah"></td>
                                </tr>
                                <tr>
                                    <td>Provinsi Sekolah</td>
                                    <td>
                                        <select class="span5" name="provinsi" id="provinsi">
                                            <option value="jabar">Jawa Barat</option>
                                            <option value="jateng">Jawa Tengah</option>
                                            <option value="jatim">Jawa Timur</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat Lengkap Sekolah</td>
                                    <td><textarea class="span5" name="alamat" class="input-large" rows="3"></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                </div>
            </section>

            <h2>Konfirmasi</h2>
            <section>
                <div>
                    <p>Berikut resume pemesanan beserta data pengiriman Anda. Silakan diperbaiki apabila ada kesalahan. Bila data sudah benar, silakan klik tombol Selesai untuk konfirmasi pemesanan. Setelah data pemesanan kami terima, kami akan mengirimkan invoice pemesanan ke alamat email Anda.</p>
                </div>
            </section>
        </div>
        </form>
    </div>

    <script>
    jQuery(function($){
        function errorPlacement(error, element){
                element.before(error);
            }

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
                }
                if($tryout_qty === 0 && $digital_qty === 0 && $fisik_qty === 0){
                    $('#errorMessage').show();
                    return false;
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
                        $('#emaillist tbody').append('<tr><td>Email '+i+'</td><td><input type="text" class="span5" name="email['+i+']" class="input-large"></td></tr>');
                    }
                }
                // alert(currentIndex + ' ' + priorIndex);

                $('#wizard .content').height($('.body.current').children('div').height() + 50);
            },

        });

        $('.close').click(function(){
            $('.'+$(this).attr('data-target')).hide();
        })

    })
    </script>

    <?php dump($entries); ?>