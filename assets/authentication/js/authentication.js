window.onload = function () {
    VK.init({
        apiId: 6088937
    });
    VK.Widgets.Auth('vk_auth', {
        onAuth: function (userData) {
            $.ajax({
                url: 'http://homefinance.local/authentication/vkontakte',
                method: 'post',
                data: {userData: userData}
            }).done(function (data) {
                switch (data) {
                    case 'failure':
                        $('#message').text('Авторизация посредством Вконтакте не удалась. Попробуйте другой вариант');
                        break;
                    case 'User didn\'t exist':
                        var queryString = '?vkId=' + userData.uid;
                        queryString = queryString + '&vkName=' + userData.first_name;
                        queryString = queryString + '&vkSurname=' + userData.last_name;
                        location.assign('http://homefinance.local/authentication/reg' + queryString);
                        break;
                    case 'Success':
                        location.assign('http://homefinance.local/main/index');
                        break;
                }
            });
        }
    });
};