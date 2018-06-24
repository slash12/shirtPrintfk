//datatable for view tshirt
$(document).ready(function () {
    $('#mtstbl').DataTable({
        "pageLength": 4,
        "autoWidth": false,
        "scrollX": true
    });
});

//datatable for brand
$(document).ready(function () {
    $('#mbrdtbl').DataTable({
        "pageLength": 6,
        "autoWidth": false,
        "bLengthChange": false,
    });
});

//js for toggle side menu admin
$(document).ready(function () {
    $("#sidebar").mCustomScrollbar({
        theme: "minimal",
    });

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    });
});

//init the dropdown of add tshirt form
$(document).ready(function () {
    $('.selectpicker').selectpicker();
});

//refresh script
function clrfrm() {
    location.reload();
}

//popover init
$(document).ready(function () {
    $('[data-toggle="popover"]').popover({
        // trigger: 'hover',
        delay: { "show": 100, "hide": 500 },
        placement: 'left',
        html: true
    });
});

//JS uniqueness AJAX function
function uniqueval(button_id, textbox_id, url, span_id, msg_err_unique, msg_err_empty) {
    $(document).ready(function () {
        document.getElementById(button_id).disabled = true;
        $(textbox_id).blur(function () {
            var value = $(this).val();
            $.ajax({
                url: url,
                method: "POST",
                data: { add_value: value },
                success: function (html) {
                    if (html == "true") {
                        $(span_id).html('<span class="text-danger">' + msg_err_unique + '</span>');
                        document.getElementById(button_id).disabled = true;
                    }

                    if (html == "false") {
                        if (value == "") {
                            $(span_id).html('<span class="text-danger">' + msg_err_empty + '</span>');
                            document.getElementById(button_id).disabled = true;
                        }
                        else {
                            $(span_id).html('<span></span>');
                            document.getElementById(button_id).disabled = false;
                        }
                    }
                }
            });
        });
    });
}
//JS uniqueness AJAX function//