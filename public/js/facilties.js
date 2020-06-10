$(function () {
    $('.nav-facilities').addClass('active');
    $('#saveDocsForm').validate();
    $('#submitLicenceDate').validate();

    $('.closeForm').on('click', function () {
        $('#saveForm')[0].reset();
    });


    $('#addButton').on('click', function () {
        $('#addModal').modal();
        $('#id').val(0);
        // $('#submitForm')[0].reset(); //resetting form
        $('#license_status').prop('disabled', false);
    });

    $('#province_id').on('change', function () {
        loadDistricts($(this).val(), 0);
    });

    $('#district_id').on('change', function () {
        loadSector($(this).val(), 0);
    });

    $('.js-docs').on('click', function () {
        $('#saveDocsForm').attr('action', $(this).attr('data-submit'));
        var url = $(this).attr('data-url');
        $('#addDocsModal').modal();
        showLoader();
        $.getJSON(url)
            .done(function (data) {
                hideLoader();
                $('#names').val(data.name);
                $('#emailId').val(data.email);
                $('#phoneNumberId').val(data.phone);
                $('#idNumber').val(data.nationalId);
            });
    });

    $('.js-licence').on('click', function () {
        var url = $(this).attr('data-url');
        $('#licenceModal').modal('show');
        $('#submitLicenceDateForm').attr('action', $(this).attr('data-submit'));
        showLoader();
        $.getJSON(url)
            .done(function (data) {
                hideLoader();
                $('#license_issued_at').val(data.license_issued_at);
                $('#license_expires_at').val(data.license_expires_at);
            });
    });


    $('.js-renew').on('click', function (e) {
        e.preventDefault();
        var url = $(this).attr('data-url');
        console.log(url);
        var modal = $('#renewModal');
        modal.modal();
        var form = $('#renewForm');
        form.validate();

        form.on('submit', function (event) {
            event.preventDefault();
            var form = $(this);
            var btn = $('#saveRenewBtn');
            if (!form.valid()) return false;
            var formData = new FormData(this);
            btn.button('loading');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (data) {
                    location.reload();
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail(function () {
                btn.button('reset');
            });

        });
    });

    $('#applicationType').on('change', function () {
        if (!$(this).val()) return;
        $.ajax({
            'url': '/app-types/documents/' + $(this).val(),
            'method': 'get',
            'type': 'text/html'
        }).done(function (data) {
            $('#sales-chart').html(data);
            $('a[href="#sales-chart"]').tab('show') // Select tab by name
        });
    });


    $('.js-edit').on('click', function () {
        var url = $(this).attr('data-url');
        $('#addModal').modal();
        showLoader();
        $.getJSON(url)
            .done(function (data) {
                hideLoader();
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#category_id').val(data.category_id);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#ref_number').val(data.ref_number);
                $('#service_id').val(data.service_id);
                $('#manager_name').val(data.manager_name);
                $('#province_id').val(data.data.province_id);
                $('#nationalId').val(data.nationalId);
                $('#other_service').val(data.other_service);
                $('#position').val(data.position);

                var licensed = $('#license_status');
                licensed.val(data.license_status);
                licensed.prop('disabled', 'disabled');
                // licensed.trigger('change');

                loadDistricts(data.data.province_id, data.data.id);
                loadSector(data.data.id, data.sector_id);

                let lengthStatus = $('input[name="license_status"]');
                $.each(lengthStatus, function (index, element) {
                    var value = $(element).val();
                    if (value === data.license_status) {
                        $(element).prop("checked", true);
                    }

                });

                // TODO control services
                let services = $('input[name="service_id[]"]');

                $.each(services, function (index, element) {
                    var value = $(element).val();
                    // console.log(value);
                    let facilityServices = data.facility_services;
                    let length = facilityServices.length;
                    for (let i = 0; i < length; i++) {
                        let service = facilityServices[i];
                        if (value === service.service_id) {
                            $(element).prop("checked", true);
                            break;
                        }
                    }
                });
            });
    });


    $('.license_status').on('change', function () {
        var value = $(this).val();
        changeLicenseStatus(value);
    });


    $('#saveForm').on('submit', function (e) {
        e.preventDefault();
        if (!$(this).valid()) return false;

        $('#createBtn').button('loading');
        e.target.submit();
    });


});


var loadDistricts = function (provinceId, selectedValue) {
    $.getJSON('/districtsByProvince/' + provinceId, function (data) {
        var district = $('#district_id');
        district.empty();
        district.append('<option></option>');
        $.each(data, function (index, value) {
            district.append('<option value="' + value.id + '">' + value.name + '</option>');
        });
        district.val(selectedValue);
    });
};
var loadSector = function (districtId, selectedValue) {
    $.getJSON('/sectorsByDistrict/' + districtId, function (data) {
        var element = $('#sector_id');
        element.empty();
        element.append('<option></option>');
        $.each(data, function (index, value) {
            element.append('<option value="' + value.id + '">' + value.name + '</option>');
        });

        element.val(selectedValue);
    });
};
var changeLicenseStatus = function (value) {
    if (value === 'licensed') {
        $('#license_expires_at_group').removeClass('div-hide');
        $('#license_issued_at_group').removeClass('div-hide');
    } else {
        $('#license_expires_at_group').addClass('div-hide');
        $('#license_issued_at_group').addClass('div-hide');
    }
    if (value === 'renew') {
        $('#district_report_form').removeClass('div-hide');
        $('#app_letter_form').removeClass('div-hide');
    } else {
        $('#district_report_form').addClass('div-hide');
        $('#app_letter_form').addClass('div-hide');
    }
};
