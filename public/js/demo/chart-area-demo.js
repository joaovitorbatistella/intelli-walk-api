// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

console.log('opa')
let response = fetch('http://127.0.0.1:8000/get-average')
                .then(async response => {
                  if (!response.ok) {
                    throw new Error(`Response status: ${response.status}`);
                  }
                  response.json().then(json => {
                    let data = json.data
                    console.log('data', data)
                    let headers = data.map(el => {
                      return el.date
                    })

                    let avg = data.map(el => {
                      return el.avg
                    })


                    // Area Chart Example
                    var ctx = document.getElementById("myAreaChart");
                    var myLineChart = new Chart(ctx, {
                      type: 'line',
                      data: {
                        labels: headers,
                        datasets: [{
                          label: "kPa",
                          lineTension: 0.3,
                          backgroundColor: "rgba(2,117,216,0.2)",
                          borderColor: "rgba(2,117,216,1)",
                          pointRadius: 5,
                          pointBackgroundColor: "rgba(2,117,216,1)",
                          pointBorderColor: "rgba(255,255,255,0.8)",
                          pointHoverRadius: 5,
                          pointHoverBackgroundColor: "rgba(2,117,216,1)",
                          pointHitRadius: 50,
                          pointBorderWidth: 2,
                          data: avg,
                        }],
                      },
                      options: {
                        scales: {
                          xAxes: [{
                            time: {
                              unit: 'date'
                            },
                            gridLines: {
                              display: false
                            },
                            ticks: {
                              maxTicksLimit: 7
                            }
                          }],
                          yAxes: [{
                            ticks: {
                              min: 0,
                              max: 200,
                              maxTicksLimit: 5
                            },
                            gridLines: {
                              color: "rgba(0, 0, 0, .125)",
                            }
                          }],
                        },
                        legend: {
                          display: false
                        }
                      }
                    });


                  })
                })
