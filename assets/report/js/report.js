function deletion(button) {
    if (window.confirm('Вы дейсвительно хотите удалить операцию?')) {
        $.ajax({
            url: 'http://homefinance.local/report/delete',
            method: 'post',
            data: {id: button.getAttribute('id')}
        });
        window.location.reload(true);
    }
}
