// const { data } = require("jquery");

document.addEventListener('DOMContentLoaded', (event) => {

	var start = moment().subtract(29, 'days');
	var end = moment();

	function cb(start, end) {
		$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D,              YYYY'));
	}

	$('#reportrange').daterangepicker({
		startDate: start,
		endDate: end,
		ranges: {
			//'Today': [moment(), moment()],
			// 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		}
	}, cb);

	cb(start, end);

	let startDate = moment(start).format('YYYY-MM-DD');
	let endDate = moment(end).format('YYYY-MM-DD');
	makeChart(startDate, endDate);

	$('#reportrange').on('apply.daterangepicker', function (ev, picker) {
		reInitChart();
		startDate = picker.startDate.format('YYYY-MM-DD');
		endDate = picker.endDate.format('YYYY-MM-DD');
		makeChart(startDate, endDate);
	});

	$('#chart_type').change(function () {
		reInitChart();
		makeChart(startDate, endDate);
	});
});

//get chart data with ajax and make chart
async function makeChart(startDate, endDate) {
	let chart;
	try {
		const url = '/admin/dashboard/chart';
		const response = await axios.get(url, {
			params: {
				start_date: startDate,
				end_date: endDate
			}
		});

		let bookingChart = document.querySelector('#booking_chart').getContext('2d');

		chart = new Chart(bookingChart, {
			type: $('#chart_type').val(),
			// The data for our dataset
			data: {
				labels: response.data.dates,
				datasets: [{
					label: "Bookings",
					backgroundColor: [
						'rgba(77,208,225 ,1)',
						'rgba(77,208,225 ,1)',
						'rgba(77,208,225 ,1)'
					],
					borderColor: 'rgba(0,188,212 ,1)',
					data: response.data.booking_counts,
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							min: 0,
							max: response.data.max
						}
					}]
				}
			}
		});
	} catch (err) {
		// Handle Error Here
		console.error(err);
	}
}

/**
 * this function will renintialize the chart
 * @return void
 */
function reInitChart() {
	let parentNode = $('#booking_chart').parent();
	$('#booking_chart').remove();
	parentNode.append(
		'<canvas id="booking_chart" width="100%" height="30"></canvas>'
	);
}