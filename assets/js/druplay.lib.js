function showalert(msg,types,icon) {
    type = ['', 'info', 'danger', 'success', 'warning', 'rose', 'primary'];

    color = Math.floor((Math.random() * 6) + 1);

    $.notify({
        icon: icon,
        message: msg

    }, {
        type: types,
        timer: 4000,
        placement: {
            from: 'top',
            align: 'center'
        }
    });
}