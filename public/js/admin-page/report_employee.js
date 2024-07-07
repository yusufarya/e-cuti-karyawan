$(document).ready(function () {
    let startYear = 2010;
    let endYear = new Date().getFullYear();
    for (var listYear = startYear; listYear <= endYear; listYear++) {
        $("#year").append($("<option />").val(listYear).html(listYear));
    }
    $("#year").val(endYear).change();
    
    $("#submitRpt").on("click", function () {
        var fullname = $("#fullname").val();
        var gender = $("#gender").val();
        var sub_district = $("#sub_district").val();
        var village = $("#village").val();
        var year = $("#year").val();
    
        $.ajax({
            type: "GET",
            url: "/submission-rpt",
            dataType: "JSON",
            data: {
                fullname: fullname,
                gender: gender,
                sub_district: sub_district,
                village: village,
                year: year,
            },
            success: function (data) {
                openRpt();
            },
        });
    });
    
});

function openRpt() {
    window.popup = window.open(
        "/open-submission-rpt",
        "rpt",
        "width=1550, height=600, top=10, left=10, toolbar=1"
    );
}
