<section class="title">
    <h4><?php echo lang('simple_order:order'); ?></h4>
</section>
<section class="item">
    <div class="content">
        <fieldset id="filters">
            <legend>Filters</legend>
            <ul>
                <li class="">
                    <label for="f_status">Status: </label>
                    <select name="status" id="status">
                        <option value="Pending">Belum Bayar</option>
                        <option value="paid">Sudah Bayar</option>
                        <option value="sent">Terkirim</option>
                        <option value="cancel">Batal</option>
                    </select> 
                </li>

                <li>
                    <label for="f_status">Provinsi: </label>
                    <select class="span5 provinsi" name="provinsi" id="provinsi" required>
                        <option value="all">Semua</option>
                        <option value="Aceh">Aceh</option>
                        <option value="Bali">Bali</option>
                        <option value="Bangka Belitung">Bangka Belitung</option>
                        <option value="Banten">Banten</option>
                        <option value="Bengkulu">Bengkulu</option>
                        <option value="Gorontalo">Gorontalo</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Jambi">Jambi</option>
                        <option value="Jawa Barat">Jawa Barat</option>
                        <option value="Jawa Tengah">Jawa Tengah</option>
                        <option value="Jawa Timur">Jawa Timur</option>
                        <option value="Kalimantan Barat">Kalimantan Barat</option>
                        <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                        <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                        <option value="Kalimantan Timur">Kalimantan Timur</option>
                        <option value="Kepulauan Riau">Kepulauan Riau</option>
                        <option value="Lampung">Lampung</option>
                        <option value="Maluku">Maluku</option>
                        <option value="Maluku Utara">Maluku Utara</option>
                        <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                        <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                        <option value="Papua">Papua</option>
                        <option value="Papua Barat">Papua Barat</option>
                        <option value="Riau">Riau</option>
                        <option value="Sulawesi Barat">Sulawesi Barat</option>
                        <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                        <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                        <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                        <option value="Sulawesi Utara">Sulawesi Utara</option>
                        <option value="Sumatera Barat">Sumatra Barat</option>
                        <option value="Sumatera Selatan">Sumatra Selatan</option>
                        <option value="Sumatera Utara">Sumatra Utara</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                    </select>
                </li>

                <li>
                    <label for="f_status">Nama: </label>
                    <input type="text" name="nama" id="nama">
                </li>
            </ul>
        </fieldset>

    <div id="stream-table" class="streams">
        <?php echo $dataorder; ?>
    </div>

    <script>
        $('#status, #provinsi').change(function(){
            var status = $('#status').val();
            var provinsi = $('#provinsi').val();
            var nama = $('#nama').val();
            var oldstatus = $('#stream-table').attr('data-status');
            var oldprovinsi = $('#stream-table').attr('data-provinsi');
            var oldnama = $('#stream-table').attr('data-nama');
            if(oldstatus != status || oldprovinsi != provinsi || oldnama != ""){
                $('#stream-table').css('opacity', '.5');
                $.ajax({
                    url: BASE_URL + 'admin/order/order/',
                    type: 'POST',
                    data: {status: status, provinsi: provinsi, nama: nama}
                }).done(function(res){
                    $('#stream-table').empty()
                    .html(res)
                    .css('opacity', '1')
                    .removeAttr(oldstatus).attr('data-status', status)
                    .removeAttr(oldprovinsi).attr('data-provinsi', provinsi)
                    .removeAttr(oldpnama).attr('data-nama', nama);
                });
            }
            return false;
        });
        $('#nama').bind('keypress', function(e){
            var code = e.keyCode || e.which;
            if(code == 13) { //Enter keycode
                $('#status, #provinsi').change();
            }
        })
    </script>
    <style>.button{display:inline-block !important;}</style>

</div>
</section>
<script>
//         $('#status, #paket').change(function(){
//             var status = $('#status').val();
//             var paket = $('#paket').val();
//             var oldstatus = $('#stream-table').attr('data-status');
//             var oldpaket = $('#stream-table').attr('data-paket');
//             if(oldstatus != status || oldpaket != paket){
//                 $('#stream-table').css('opacity', '.5');
//                 $.ajax({
//                     url: BASE_URL + 'admin/tryout/to_user/table/',
//                     type: 'POST',
//                     data: {status: status, paket: paket}
//                 }).done(function(res){
//                     $('#stream-table').empty()
//                     .html(res)
//                     .css('opacity', '1')
//                     .removeAttr(oldstatus).attr('data-status', status)
//                     .removeAttr(oldpaket).attr('data-paket', paket);
//                 });
//             }
//             return false;
//         });
    </script>