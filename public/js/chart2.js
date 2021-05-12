var months = ['En','Feb','Mzo','Abr','My','Jun','Jul','Ag','Sept','Oct','Nov','Dic'];
var ctx = document.getElementById("myChart");
myChart = new Chart(ctx,null );
Livewire.on('get_data_file_two', (data) => {
    let data_set_upload = [];
    let data_set_download = [];
    let data_month = [];
    data.map(function(num){
        let month = months[num['month'] - 1];
        data_month.push(month);
        data_set_upload.push(num['upload']);
        data_set_download.push(num['download']);
    });
    show_bar_two(data_month, data_set_upload, data_set_download);
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