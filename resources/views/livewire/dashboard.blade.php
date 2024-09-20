<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container my-4">
        <div class="container my-4 bg-light shadow">
            <!-- Existing form for filters (IDS Group, CSAT, Date range) -->
            <form  wire:submit.prevent="filter">
                        <div class="row px-5 py-3">
                            <!-- Group Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="idsGroup" class="form-label">IDS Group</label>
                                <select wire:model="idsGroup" id="idsGroup" class="form-select" >
                                    <option value="">Select IDS Group</option>
                                    @foreach($idsGroups as $group)
                                        <option value="{{ $group->name }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- CSAT Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="csat" class="form-label">CSAT</label>
                                <select id="csat" class="form-select">
                                    <option selected disabled>Select CSAT</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>
                        </div>

                        <!-- Date Range Inputs -->
                        <div class="row px-5 py-3">
                            <div class="col-md-6 mb-3">
                                <label for="dateFrom" class="form-label">Date From</label>
                                <input type="date" id="dateFrom" class="form-control" placeholder="Select Date" >
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dateTo" class="form-label">Date To</label>
                                <input type="date" id="dateTo" class="form-control" placeholder="Select Date" >
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                    
            </form>

        <!-- NPS and Total Survey Info -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="mb-0" id="totalSurveys" >{{ $totalSurveys }}</h2>
                        <p class="text-muted">Total Survey</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h2 class="mb-0" id="overallNPS" class="overallpercentage">{{ $nps }}%</h2>
                        <p class="text-muted">Overall NPS</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success">
                    <div class="card-body text-center">
                        <h1 class="text-white">😃</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white text-center">
                            <h5 class="mb-0">😃</h5>
                        </div>
                        <div class="card-body">
                        <div class="d-flex justify-content-around">
                            <p>10: {{ $responseCounts[10] ?? 0 }}</p>
                            <p>9: {{ $responseCounts[9] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <h5 class="text-center mb-0">Promoter: {{ $promoters }}</h5>
                    </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-header bg-warning text-white text-center">
                    <h5 class="mb-0">😐</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <p>8: {{ $responseCounts[8] ?? 0 }}</p>
                        <p>7: {{ $responseCounts[7] ?? 0 }}</p>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <h5 class="text-center mb-0">Neutral: {{ $neutrals }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white text-center">
                    <h5 class="mb-0">😞</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around flex-wrap">
                        @for ($i = 6; $i >= 0; $i--)
                            <p class="px-2">{{ $i }}: {{ $responseCounts[$i] ?? 0 }}</p>
                        @endfor
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <h5 class="text-center mb-0">Detractor: {{ $detractors }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body text-center">
                    <h5 class="text-success mb-0">{{ round(($promoters / $total) * 100, 2) }}%</h5>
                    <p class="text-muted">of total responses</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <h5 class="text-danger mb-0">{{ round(($detractors / $total) * 100, 2) }}%</h5>
                    <p class="text-muted">of total responses</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="mb-0" class="overallpercentage">{{ $nps }}%</h5>
                    <p class="text-muted">This is your NPS</p>
                </div>
            </div>
        </div>
    </div>
      <!-- Table Rendering the Responses -->
      <div class="table-responsive my-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Question #</th>
                    @foreach($userSubmissions as $submission)
                        <th><strong data-group="{{$submission->idsGroup}}">{{ $submission->clientContactName }} ({{  $submission->updated_at->format('Y-m-d') }})</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach(range(1, 9) as $index)
                    <tr>
                        <th>Q {{ $index }}</th>
                        @foreach($userSubmissions as $submission)
                            <td>
                                @isset($responses[$submission->id][$index - 1])
                                    {{ $responses[$submission->id][$index - 1]->response ?? 'NA' }}
                                @else
                                    NA
                                @endisset
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    
</div>

<script>
function filterDashboard() {
    var selectedIdsGroup = $('#idsGroup').val();
    var selectedCSAT = $('#csat').val();
    var dateFrom = $('#dateFrom').val();
    var dateTo = $('#dateTo').val();
    // AJAX call to fetch updated data
   
    // Reset counts
    let totalSurveys = 0;
    let promoters = 0;
    let neutrals = 0;
    let detractors = 0;

    

    // Update totals
    $('#totalSurveys').text(totalSurveys);
    $('#promoters').text(promoters);
    $('#neutrals').text(neutrals);
    $('#detractors').text(detractors);

    // Calculate and display NPS
    var nps = promoters - detractors;
    $('#overallNPS').text(nps + '%');
}
</script>
</body>
</html>