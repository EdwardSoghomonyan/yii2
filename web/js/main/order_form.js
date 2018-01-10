function Orders() {
    this.form = $('.orders-form form');
    this.rowContainer = this.form.find('.main_form')

    this.bind();
}

Orders.prototype.bind = function () {
    $('body')
        .on('click', '.add_row', this.addRow.bind(this))
        .on('click', '.remove_row', this.removeRow.bind(this));
};

Orders.prototype.addRow = function () {
    var last_row = this.rowContainer.find('.order-row:last');
    var index = parseInt(last_row.data('index') == ' ' ? 0 : last_row.data('index')) + 1;
    var new_row = last_row.clone(false, false);

    last_row.find('.add_row').removeClass('add_row').addClass('remove_row').text('-');

    new_row.data('index', index);
    new_row.find('input').data('new', true);
    new_row.find('input[type="text"]').val('');

    var fields = ['price', 'description', 'available', 'order_id'];
    for (var i = 0; i < fields.length; i++) {
        var elem = new_row.find('.' + fields[i]);

        elem.attr('name', 'Orders[' + index + '][' + fields[i] + ']')
            .attr('id', 'orders-' + index + '-' + fields[i])
            .closest('.form-group')
            .removeAttr('class')
            .addClass('form-group required field-orders-' + index + '-' + fields[i]);
        elem.data('base-id', last_row.find('.' + fields[i]).attr('id'));
        elem.closest('.form-group').find('.help-block').empty();

        if(fields[i] == 'available') {
            elem.closest('.form-group').find('input[type="hidden"]').attr('name', 'Orders[' + index + '][' + fields[i] + ']');
        }
    }

    this.rowContainer.append(new_row);
    this._fixFormValidation();
};

Orders.prototype.removeRow = function (event) {
    var elem = $(event.target).closest('.order-row');
    var removed_id = elem.find('.id').val();

    if (removed_id) {
        if ($('.removed_orders').val() == '') {
            $('.removed_orders').val(removed_id);
        } else {
            $('.removed_orders').val($('.removed_orders').val() + ',' + removed_id);
        }
    }

    elem.remove();
};

Orders.prototype._fixFormValidation = function () {
    this.rowContainer.find('input, textarea, select').each(function(index, elem) {
        elem = $(elem);

        if (!elem.hasClass('removed_orders')) {
            var id = elem.attr('id');
            var name = elem.attr('name');
            var baseId = elem.data('base-id');
            var options = this.form.yiiActiveForm('find', baseId ? baseId : id);

            options = options ? Object.assign(options) : options;

            if (id && options) {
                options.id = id;
                options.container = ".field-" + id;
                options.input = "#" + id;
                options.name = name;
                options.value = elem.val();
                options.status = 0;

                if (baseId && this.form.yiiActiveForm('find', id)) {
                    this.form.yiiActiveForm('remove', id);
                }

                this.form.yiiActiveForm('add', options);
            }
        }
    }.bind(this));
};

$(document).ready(function () {
    new Orders();
});
