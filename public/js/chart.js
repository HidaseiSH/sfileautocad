
var ctx = document.getElementById("myBarChart");
var myBarChart = new Chart(ctx,null );
var ctx2 = document.getElementById("myBarChart2");
var myBarChart2 = new Chart(ctx2,null );
var ctx3 = document.getElementById("myBarChart3");
var myBarChart3 = new Chart(ctx3,null );
Livewire.on('get_data_file', (data,description) => {
    let data_month_day = [];
    let data_value = [];
    //console.log(data)
    data.map(function(num){
        data_value.push(num['ind_one']);
        data_month_day.push(num['month_or_day']);
    });
    show_bar(data_month_day, data_value, description);
});
Livewire.on('get_data_file_2', (data,description) => {
    let data_month_day = [];
    let data_value = [];
    data.map(function(num){
        data_value.push(num['ind_one']);
        data_month_day.push(num['month_or_day']);
    });
    show_two(data_month_day, data_value, description);
});
Livewire.on('get_data_file_3', (data,description) => {
    let data_month_day = [];
    let data_value = [];
    data.map(function(num){
        data_value.push(num['ind_one']);
        data_month_day.push(num['month_or_day']);
    });
    show_three(data_month_day, data_value, description);
});

function show_bar(labels, values, description){
    myBarChart.destroy();
    let data = {
        labels: labels,
        datasets: [{
            label: "Result",
            data: values,
            boderColor: 'rgb(228, 88, 103)',
            backgroundColor:  'rgba(228, 88, 103, 0.3)',
            order: 1
        }, {
            label: "Result Line",
            data: values,
            borderColor: 'rgb(119, 227, 13)',
            backgroundColor: 'rgba(119, 227, 13, 0.3)',
            type: 'line',
            order: 0
        }]
    };
    
    myBarChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: description,
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
     
function show_two(labels, values, description){
    myBarChart2.destroy();
    let data = {
        labels: labels,
        datasets: [{
            label: "Result",
            data: values,
            boderColor: 'rgb(228, 88, 103)',
            backgroundColor:  'rgba(228, 88, 103, 0.3)',
            order: 1
        }, {
            label: "Result Line",
            data: values,
            borderColor: 'rgb(119, 227, 13)',
            backgroundColor: 'rgba(119, 227, 13, 0.3)',
            type: 'line',
            order: 0
        }]
    };
    
    myBarChart2 = new Chart(ctx2, {
        type: 'bar',
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: description,
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

function show_three(labels, values, description){
    myBarChart3.destroy();
    let data = {
        labels: labels,
        datasets: [{
            label: "Result",
            data: values,
            boderColor: 'rgb(228, 88, 103)',
            backgroundColor:  'rgba(228, 88, 103, 0.3)',
            order: 1
        }, {
            label: "Result Line",
            data: values,
            borderColor: 'rgb(119, 227, 13)',
            backgroundColor: 'rgba(119, 227, 13, 0.3)',
            type: 'line',
            order: 0
        }]
    };
    
    myBarChart3 = new Chart(ctx3, {
        type: 'bar',
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: description,
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
