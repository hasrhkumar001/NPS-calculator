
    <div class="container-fluid my-4">
        <div class="container-fluid bg-light shadow topsection">
            <!-- Existing form for filters (IDS Group, CSAT, Date range) -->
            <form  wire:submit.prevent="filter">
                        <div class="row px-5 py-">
                            <!-- Group Selection -->
                            <div class="col-lg-3 mb-1">
                                <label for="idsGroup" class="form-label">IDS Group</label>
                                <select wire:model="idsGroup" id="idsGroup" wire:change="updateListBasedOnFilters" class="form-select" >
                                    <option value="">All Groups</option>
                                    @foreach($idsGroups as $group)
                                        <option value="{{ $group }}">{{ $group }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- CSAT Selection -->
                            <div class="col-md-3 mb-1">
                                <label for="csat" class="form-label">CSAT</label>
                                <select id="csat" class="form-select" wire:change="updateListBasedOnFilters" wire:model="csat">
                                    <option  value="">All</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Quarterly">Quarterly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="dateFrom" class="form-label">Date From</label>
                                <input type="date" id="dateFrom" wire:model="dateFrom" class="form-control" wire:change="updateListBasedOnFilters" placeholder="Select Date" >
                            </div>
                            <div class="col-md-3 mb-1">
                                <label for="dateTo" class="form-label ">Date To</label>
                                <input type="date" id="dateTo" wire:model="dateTo" wire:change="updateListBasedOnFilters" class="form-control" placeholder="Select Date" >
                            </div>
                            <!-- <div class="col-md-4 mb-1 d-flex justify-content-end align-items-center applynow">
                                <button type="submit" class="btn btn-primary fs-5"><i class="fas fa-filter mx-2"></i>Apply Filter</button>
                            </div>   -->
                        </div>

                        <!-- Date Range Inputs -->
                        <div class="row px-5 py-1">
                           
                        </div>
                            
                    </div>

                    
            </form>

        <!-- NPS and Total Survey Info -->
        <div class="container-fluid shadow p-3" style="margin: 30px auto; padding: 0 20px;">
        
            <!-- Summary Row for Total Surveys and Overall NPS -->
            <div class="row mb-4 d-flex align-items-center p-2">
                <div class="col-md-6 ">
                    <div class="text-center border">
                        <h2 class="mb-0" id="totalSurveys" style="font-size: 2.5rem;">{{ $totalSurveys }}</h2>
                        <p class="text-muted">Total Surveys</p>
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class="text-center border">
                        <h2 class="mb-0" id="overallNPS" class="overallpercentage" style="font-size: 2.5rem;">{{ $nps }}%</h2>
                        <p class="text-muted">Overall NPS</p>
                    </div>
                </div>
                
            </div>

            <!-- Pie Chart for Promoters, Neutrals, Detractors -->
            <div class="row mt-4">
                <!-- Bar Chart for Ratings and Votes -->
            
                <div class="col-lg-6">
                    <div class="    ">
                        
                        <div  style="display: flex; justify-content: center;">
                            <canvas id="ratingsBarChart" ></canvas>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div style="display: flex; justify-content: center;">
                        
                        <div>
                            <canvas id="npsPieChart" ></canvas>
                            
                        </div>
                    </div>
                </div>
            </div>
    
   
</div>


    <div class="d-flex justify-content-end mb-3">
        <button wire:click="downloadCSV" class="btn btn-success downloadbtn">Download as CSV</button>
    </div>

      <!-- Table Rendering the Responses -->
      @if(count($userSubmissions) > 0)
      <div class="table-responsive tablecontainer my-4 table-wrapper">
      <table class="table table-bordered fixed-table">
            <thead>
                <tr>
                    <th style="white-space: nowrap;" class="fixed-column">Question #</th>
                    @foreach($userSubmissions as $submission)
                        <th style="white-space: nowrap;">{{ $submission->clientContactName }} ({{  $submission->updated_at->format('Y-m-d') }})</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach(range(1, 9) as $index)
                    <tr>
                        <th style="white-space: nowrap;" class="fixed-column">Q {{ $index }}</th>
                        
                        @foreach($userSubmissions as $submission)
                            <td style="white-space: nowrap;">
                                @isset($responses[$submission->id])
                                    {{ $responses[$submission->id]->{"Q{$index}"} ?? 'NA' }}
                                @else
                                    Nope
                                @endisset
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th style="white-space: nowrap;" class="fixed-column">NPS</th> 
                    @foreach($userSubmissions as $submission)
                        <td style="white-space: nowrap;">
                            {{ $responses[$submission->id]->Nps_percentage?? 'NA' }}%
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        
    </div>
    @else
    <p class="text-center">No submissions available.</p>
    @endif
    
</div>

<script>

let npsPieChart, ratingsBarChart;

document.addEventListener('updateCharts', initCharts);
document.addEventListener('livewire:navigated', initCharts);

function initCharts() {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded');
        return;
    }

    // createCharts();
    
}
function destroyCharts() {
    if (npsPieChart) {
        npsPieChart.destroy();
        npsPieChart = null;
    }
    if (ratingsBarChart) {
        ratingsBarChart.destroy();
        ratingsBarChart = null;
    }
}

function createCharts(data = null) {
    createNPSPieChart(data);
    createRatingsBarChart(data);
}

window.addEventListener('updateCharts', function handleUpdate(event) {
    
    const data = event.detail[0];
  
    if (data && typeof data === 'object') {
        destroyCharts();
        createCharts(data);
    } else {
        console.error('Invalid data received for chart update');
    }
});

function createNPSPieChart() {
    const ctxPie = document.getElementById('npsPieChart');
    if (!ctxPie) return;

    
    
    npsPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Promoters', 'Neutrals', 'Detractors'],
            datasets: [{
                label: 'NPS',
                data: [1, 1, 1], // Initial placeholder data
                backgroundColor: ['#4CAF50', '#FFC107', '#F44336'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            hover: {
                mode: null,  // Disable hover effects entirely
            },
            animation: {
                duration: 0,  // Disable animation effects, or set it to a lower value like 200 for subtle animations
            }
        }
    });
}

function createNPSPieChart(data = null) {
    const ctxPie = document.getElementById('npsPieChart');
    if (!ctxPie) return;

   

    const chartData = data ? ([
        data.promoterPercentage ?? 0,
        data.neutralPercentage ?? 0,
        data.detractorPercentage ?? 0
      ].every(value => value === 0) ? [1, 1, 1] : [
        data.promoterPercentage ?? 0,
        data.neutralPercentage ?? 0,
        data.detractorPercentage ?? 0
      ]) : [1, 1, 1]; // Default data if no data is provided

    console.log(chartData);
    npsPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Promoters', 'Neutrals', 'Detractors'],
            datasets: [{
                label: 'NPS',
                data: chartData,
                backgroundColor: ['#4CAF50', '#FFC107', '#F44336'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            plugins: {
                legend: {
                    labels: {
                        // Configure label styles
                        color: '#333333', // Change label color
                        font: {
                            size: 14, // Change font size
                            weight: 'bold' // Make labels bold
                        },
                        padding: 20, // Add padding between labels
                         // Use circular point style
                        boxWidth: 10 // Change the width of the color box
                    },
                    position: 'bottom'
                }
            },
            hover: {
                mode: null,  // Disable hover effects entirely
            },
            animation: {
                duration: 0,  // Disable animation effects, or set it to a lower value like 200 for subtle animations
            }
        }
    });
}

function createRatingsBarChart(data) {
    const ctxBar = document.getElementById('ratingsBarChart');
    if (!ctxBar) return;

    // console.log(data.detractorPercentage== 0 ? 1 : data.promoterPercentage);
    const ratingLabels = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
    const barColors = ratingLabels.map(rating => {
        const value = parseInt(rating);
        if (value >= 0 && value <= 6) return '#dc3545';
        if (value >= 7 && value <= 8) return '#ffc107';
        if (value >= 9 && value <= 10) return '#28a745';
        return '#007bff';
    });

    const chartData = data && data.responseCounts
        ? ratingLabels.map(rating => data.responseCounts[rating] || 0)
        : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]; // Default data if no data is provided

    ratingsBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ratingLabels,
            datasets: [{
                label: 'Responses',
                data: chartData,
                backgroundColor: barColors,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 1,
            hover: {
                mode: null,  // Disable hover effects entirely
            },
            animation: {
                duration: 0,  // Disable animation effects, or set it to a lower value like 200 for subtle animations
            },
            plugins: {
                legend: {
                    display: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                    },
                    title: {
                        display: true,
                        text: 'Votes'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Ratings'
                    }
                }
            }
        }
    });
}
</script>

