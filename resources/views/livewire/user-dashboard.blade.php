
    <div class="container my-4">
        <div class="container my-5 bg-light shadow">
            <!-- Existing form for filters (IDS Group, CSAT, Date range) -->
            <form  wire:submit.prevent="filter">
                        <div class="row px-5 py-3">
                            <!-- Group Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="idsGroup" class="form-label">IDS Group</label>
                                <select wire:model="idsGroup" id="idsGroup" class="form-select" >
                                    <option value="">All Groups</option>
                                    @foreach($idsGroups as $group)
                                        <option value="{{ $group }}">{{ $group }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- CSAT Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="csat" class="form-label">CSAT</label>
                                <select id="csat" class="form-select" wire:model="csat">
                                    <option  value="">All</option>
                                    <option value="Monthly">Monthly</option>
                                    <option value="Quaterly">Quaterly</option>
                                    <option value="Yearly">Yearly</option>
                                </select>
                            </div>
                        </div>

                        <!-- Date Range Inputs -->
                        <div class="row px-5 py-3">
                            <div class="col-md-6 mb-3">
                                <label for="dateFrom" class="form-label">Date From</label>
                                <input type="date" id="dateFrom" wire:model="dateFrom" class="form-control" placeholder="Select Date" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dateTo" class="form-label">Date To</label>
                                <input type="date" id="dateTo" wire:model="dateTo" class="form-control" placeholder="Select Date" >
                            </div>
                        </div>
                        <div class=" px-5 py-3 text-end">
                            <button type="submit" class="btn px-5 py-2 btn-primary fs-5">Filter</button>
                        </div>      
                    </div>

                    
            </form>

        <!-- NPS and Total Survey Info -->
        <div class="container shadow p-3" style="margin: 150px auto; padding: 0 20px;">
        
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
            
                <div class="col-6 d-flex align-items-center justify-content-center">
                    <div class="card p-3 w-100  ">
                        
                        <div class=" text-center">
                            <canvas id="ratingsBarChart" style=" max-height:524px; width:100%  "></canvas>
                            
                        </div>
                    </div>
                </div>
                <div class="col-6 ">
                    <div class="">
                        
                        <div class="  ">
                            <canvas id="npsPieChart" style=" max-height:524px; "></canvas>
                            
                        </div>
                    </div>
                </div>
            </div>

    
   
</div>


    <div class="d-flex justify-content-end mb-3">
        <button wire:click="downloadCSV" class="btn btn-success">Download as CSV</button>
    </div>

      <!-- Table Rendering the Responses -->
      @if(count($userSubmissions) > 0)
      <div class="table-responsive my-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="white-space: nowrap;">Question #</th>
                    @foreach($userSubmissions as $submission)
                        <th style="white-space: nowrap;"><strong data-group="{{$submission->idsGroup}}">{{ $submission->clientContactName }} ({{  $submission->updated_at->format('Y-m-d') }})</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach(range(1, 9) as $index)
                    <tr>
                        <th style="white-space: nowrap;">Q {{ $index }}</th>
                        
                        @foreach($userSubmissions as $submission)
                            <td style="white-space: nowrap;">
                                @isset($responses[$submission->id][$index - 1])
                                    {{ $responses[$submission->id][$index - 1]->response ?? 'NA' }}
                                @else
                                    NA
                                @endisset
                            </td>
                        @endforeach
                    </tr>
                    
                @endforeach
                <tr>
                    
                    <th style="white-space: nowrap;">NPS</th> 
                    @foreach($userSubmissions as $submission)
                    @php
                        // Group responses by promoters, passives, and detractors
                        $responsesForSubmission = collect($responses[$submission->id] ?? [])->filter(fn($response) => $response->response !== 'Na');
                    
                        $promoters = collect($responsesForSubmission)->filter(fn($response) => $response->response >= 9)->count();
                        $passives = collect($responsesForSubmission)->filter(fn($response) => $response->response >= 7 && $response->response < 9)->count();
                        $detractors = collect($responsesForSubmission)->filter(fn($response) =>$response->response >= 0 && $response->response < 7)->count();
                        
                        // Total responses for this submission
                        $totalResponses = count($responsesForSubmission);

                        // Calculate NPS
                        $nps = round($totalResponses > 0
                            ? (($promoters / $totalResponses) * 100) - (($detractors / $totalResponses) * 100)
                            : '0',2);
                            
                    @endphp
                        <td style="white-space: nowrap;">{{ $nps }}%</td>
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

    const chartData = data ? [
        data.detractorPercentage== 0 ? 1 : data.promoterPercentage,
        data.neutralPercentage== 0 ? 1 : data.neutralPercentage,
        data.detractorPercentage == 0 ? 1 : data.detractorPercentage
    ] : [1, 1, 1]; // Default data if no data is provided

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

