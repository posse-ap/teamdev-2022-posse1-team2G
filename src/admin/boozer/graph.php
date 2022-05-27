<script>
  var ctx = document.getElementById("myBarChart");
  // alert(ctx);
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [, 2, , 4, , 6, , 8, , 10, , 12, , 14, , 16, , 18, , 20, , 22, , 24, , 26, , 28, , 30, ],
      datasets: [{
        label: '勉強時間',
        data: [
          // for文で30日分回すイメージ
          // そのために３月１日を描画させる
          // <?php
              // for ($i = 0; $i < count($sum); $i++) {
              //   echo $sum[$i] . ',';
              // }
              // 
              ?>

          3, 4, 4, 3, 0, 0, 4, 2, 2, 8, 8, 2, 2, 1, 7, 4, 4, 3, 3, 3, 2, 2, 6, 2, 2, 1, 1, 1, 7, 8
        ],
        backgroundColor: "#76cff3"
      }]
    },
    // options: {
    //   legend: {
    //     display: false
    //   },
    //   // title: {
    //   //     display: true,
    //   //     text: '支店別 来客数'
    //   // },
    //   scales: {
    //     xAxes: [{
    //       gridLines: {
    //         display: false
    //       },
    //       ticks: {
    //         maxRotation: 0, // 自動的に回転する角度を固定
    //         minRotation: 0,
    //       }
    //     }],
    //     yAxes: [{
    //       gridLines: {
    //         display: false
    //       },
    //       ticks: {
    //         suggestedMax: 8,
    //         suggestedMin: 0,
    //         stepSize: 2,
    //         // callback: function(value, index, values) {
    //         //   return value + 'h'
    //         // }
    //       }
    //     }]
    //   },
    //   maintainAspectRatio: false,
    // }
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>