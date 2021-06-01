
var ctx = document.getElementById("myChart");
myChart = new Chart(ctx,null );
Livewire.on('get_data_file_two', (data) => {
    let data_month_day = [];
    let data_set_upload = [];
    let data_set_download = [];
    //console.log(data)
    data.map(function(num){
      data_set_upload.push(num['upload']);
      data_set_download.push(num['download']);
      data_month_day.push(num['month_or_day']);
    });
    show_bar_two(data_month_day, data_set_upload, data_set_download);
});

function show_bar_two(labels, upload, download){
    myChart.destroy();
    let data = {
        labels: labels,
        datasets: [
          {
            label: 'Subida',
            data: upload,
            boderColor: 'rgb(120, 178, 216)',
            backgroundColor:  'rgba(120, 178, 216, 0.3)',
          },
          {
            label: 'Descarga',
            data: download,
            borderColor: 'rgb(152, 216, 120)',
            backgroundColor: 'rgba(152, 216, 120, 0.3)',
          }
        ]
    };
    myChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
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
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Descarga y Subida de archivos por Mes.'
              }
            }
        },
    });    
}