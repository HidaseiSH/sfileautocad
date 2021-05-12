var months = ['En','Feb','Mzo','Abr','My','Jun','Jul','Ag','Sept','Oct','Nov','Dic'];
var ctx = document.getElementById("myBarChart");
myBarChart = new Chart(ctx,null );
Livewire.on('get_data_file', (data,description,info) => {
    let data_set_error = [];
    let data_set_success = [];
    let data_days_or_month = [];
    data.map(function(num){
        let day_or_month = (info['type'] == 'day') ? 'Dia '+num['day'] : months[num['month'] - 1];
        data_days_or_month.push(day_or_month);
        data_set_error.push(num['count_error']);
        data_set_success.push(num['count_success']);
    });
    show_bar(data_days_or_month, data_set_error, data_set_success, description);
});

function show_bar(labels, error, success, description){
    myBarChart.destroy();
    let data = {
        labels: labels,
        datasets: [{
            label: "Error",
            data: error,
            boderColor: 'rgb(228, 88, 103)',
            backgroundColor:  'rgba(228, 88, 103, 0.3)',
        }, {
            label: "Exitoso",
            data: success,
            borderColor: 'rgb(119, 227, 13)',
            backgroundColor: 'rgba(119, 227, 13, 0.3)',
        }]
    };
    
    myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Archivo: '+description,
                    padding: {
                        top: 10,
                        bottom: 30
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(val, index){
                            if (Math.floor(val) === val) {
                                return val;
                            }
                        }
                    },
                    beginAtZero: true
                }
            },
            elements: {
                bar: {
                    borderWidth: 1,
                }
            },
            barValueSpacing: 10,
        }
    });    
}
           