<script>
    $(function() {
        $('#kt_pegawai').dataTable({
            "bDestroy": true,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": BASE_URL + "Pegawai/read",
            },
        });
    })

    function onSave() {
        var cookie_element = document.cookie.split("=");
        var crsf_token_name = "<?php echo $this->security->get_csrf_token_name(); ?>";
        $("#" + crsf_token_name).val(cookie_element[1]);


        Swal.fire({
            text: "Apakah anda akan menyimpan data ini ?",
            icon: "question",
            buttonsStyling: !1,
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-secondary",
            },
        }, function(isConfirm) {
            if (isConfirm) {
                var id = $("#pegawai_id").val();
                var kode = $("#pegawai_kode").val();
                var nama = $("#pegawai_nama").val();
                if (id == "") {
                    if (kode == "" || nama == "") {
                        swal("Pemberitahuan", "Lengkapi Data Dahulu !", "info");
                    } else {
                        var data = $('#form_pegawai').serializeObject();
                        data.csrf_test_name = cookie_element[1];
                        $.ajax({
                            url: BASE_URL + 'pegawai/pegawai/simpanpegawai',
                            type: "POST",
                            data: data,
                            datatype: "json",
                            success: function(response) {
                                var responsex = $.parseJSON(response);
                                swal("Pemberitahuan", responsex.Message, "success");
                                onBatal();
                            }
                        });
                    }
                } else {
                    var data = $('#form_pegawai').serializeObject();
                    data.csrf_test_name = cookie_element[1];
                    $.ajax({
                        url: BASE_URL + 'pegawai/pegawai/ubahpegawai',
                        type: "POST",
                        data: data,
                        success: function(response) {
                            var responsex = $.parseJSON(response);
                            swal("Pemberitahuan", responsex.Message, "success");
                            onBatal();
                        }
                    });
                }
            } else {
                swal("Pemberitahuan", "Dibatalkan", "error");
            }
        });
    }
</script>