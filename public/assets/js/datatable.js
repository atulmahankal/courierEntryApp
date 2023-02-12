$(function() {
	datatables.dt_default()
}), datatables = {
	dt_default: function() {
		$.extend(true, $.fn.dataTable.defaults, {
			aLengthMenu: [
				[10, 25, 50, 100, -1],
				[10, 25, 50, 100, "All"]
			],
	language: {
		"emptyTable": "No data currently available.",
    "zeroRecords": "No records to display"
	},
			iDisplayLength: 10,
			fixedHeader: true,
			initComplete: function () {
				var th = $(this).find('thead th');
				if (th.length) {
					$(th).css('background-color', 'gray');
					$(th).css('color', 'white');
				}
						
				var tf = $(this).find('tfoot th');
				if (tf.length) {
					tf.appendTo((this).find('thead'));
				}

				this.api()
					.columns()
					.every(function () {
						var column = this;

						// Apply the input search
						$('input', this.footer()).on('search keyup change clear', function () {
							if (column.search() !== this.value) {
								column.search(this.value).draw();
								// column.search(this.value, true, false, true).draw();
							}
						});

						// Apply select search
						var select = $('select', column.footer())
						// .appendTo($(column.footer()).empty())
						.on('change', function () {
								var val = $.fn.dataTable.util.escapeRegex($(this).val());

								column.search(val ? '^' + val + '$' : '', true, false).draw();
						});
						column
							.data()
							.unique()
							.sort()
							.each(function (d, j) {
								select.append('<option value="' + d + '">' + d + '</option>');
							});
					});
			}
		});
	}
};