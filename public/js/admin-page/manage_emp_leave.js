function approve(id, nomor, name, total, used) {
    $("#modal-edit").modal("show");
    $(".modal-title").text("Update Cuti "+name);
    $("#modal-edit form").attr("action", "/update-manage-leave/" + nomor);
    
    $('#total').val(total)
    $('#used').val(used)
    $('#over').val(total-used)
    
    $('#used').change(function() {
        let thisVal = $(this).val()
        $('#over').val(total-thisVal)
    });
    
}