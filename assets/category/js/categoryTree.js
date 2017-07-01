function addChild(span) {
    var categ = window.prompt('Введите новую категорию');
    if (categ === null) {
        return;
    }
    $.ajax({
        url: 'http://homefinance.local/category/add',
        method: 'post',
        data: {
            id: span.getAttribute('id'),
            category: categ
        }
    })
        .done(function () {
            window.location.reload(true);
        });
}

function deletion(li) {
    if (window.confirm('Вы действительно хотите удалить категорию?')) {
        $.ajax({
            url: 'http://homefinance.local/category/delete',
            method: 'post',
            data: {id: li.getAttribute('id')}
        });
        window.location.reload(true);
    }
}
