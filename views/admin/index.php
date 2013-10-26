<section class="title">
    <h4><?php echo lang('simple_order:order'); ?></h4>
</section>

<section class="item">
    <div class="content">
        <fieldset id="filters">
            <legend>Filters</legend>
            <ul>
                <li class="">
                    <label for="f_status">Filter By: </label>
                    <select name="status" id="status">
                        <option value="Pending">Belum Bayar</option>
                        <option value="paid">Sudah Bayar</option>
                        <option value="sent">Terkirim</option>
                        <option value="cancel">Batal</option>
                    </select> 

                </li>
            </ul>
        </fieldset>

    <div id="stream-table" class="streams">
        <?php echo $dataorder; ?>
    </div>

    <script>
        $('#status').change(function(){
            var status = $(this).val();
            var oldstatus = $('#stream-table').attr('class');
            if(oldstatus != status){
                $('#stream-table').css('opacity', '.5');
                $.ajax({
                    url: BASE_URL + 'admin/so/order/' + $(this).val(),
                    type: 'POST',
                    data: {status: $('#status').val()}
                }).done(function(res){
                    $('#stream-table').empty()
                    .html(res)
                    .css('opacity', '1')
                    .removeClass(oldstatus)
                    .addClass(status);
                });
            }
            return false;
        });
    </script>
    <style>.button{display:inline-block !important;}</style>

</div>
</section>