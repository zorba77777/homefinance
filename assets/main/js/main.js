function validateForm(form) {
    if ((document.getElementById('radioDeposit').checked == false) &&
        (document.getElementById('radioDebit').checked == false)) {
        document.getElementById('mustSelectType').innerHTML = 'Вы должны выбрать тип операции';
        return false;
    } else {
        $('select').each(function () {
            $(this).attr('disabled', false);
        });
        return true;
    }
}

function check(input) {
    input.value = input.value.replace(/[^\d,]/g, '');
}

$(document).ready(function () {
    $('input[type="radio"]').on('click', function () {
        var urlAddress = 'http://homefinance.local/main/show-categories';
        $.ajax({
            url: urlAddress,
            method: 'post',
            data: {
                login: $('#login').text(),
                type: $(this).val()
            }
        }).done(function (data) {
            $('#categorySelect').html(data);
            $('#mustSelectType').text('');
        });
    });
});

function subcategory(select) {
    if (select.options[select.selectedIndex].getAttribute('data-has-child') == '1') {
        var urlAddress = 'http://homefinance.local/main/show-subcategories';
        $.ajax({
            url: urlAddress,
            method: 'post',
            data: {
                login: $('#login').text(),
                type: select.getAttribute('data-type'),
                parent: select.value
            }
        }).done(function (data) {
            $('#categorySelect').append(data);
        });
        select.disabled = true;
        select.style.color = "gray";
    }
}

$(document).ready(function () {
    $('button[type="button"]').click(function () {
        var urlAddress = 'http://homefinance.local/main/subscribe';
        $.ajax({
            url: urlAddress,
            method: 'post',
            data: {login: $('#login').text()}
        }).done(function (data) {
            $('#message').text(data);
        });
    });
});



