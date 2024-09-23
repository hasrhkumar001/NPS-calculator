
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
                                        <option value="{{ $group->name }}">{{ $group->name }}</option>
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
        <div style="padding:0px 100px;margin:150px 0px ">
            <div class="row mb-4 d-flex " style="">
                <div class="col-md-4">
                    <div class="">
                        <div class="text-center">
                            <h2 class="mb-0" id="totalSurveys" >{{ $totalSurveys }}</h2>
                            <p class="text-muted">Total Survey</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="">
                        <div class=" text-center">
                            <h2 class="mb-0" id="overallNPS" class="overallpercentage">{{ $nps }}%</h2>
                            <p class="text-muted">Overall NPS</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                @if($nps > 60)
                    <div class="">
                        <div class="">
                            <h1 class="text-white">😃</h1>
                        </div>
                    </div>
                @elseif($nps > 30 && $nps <= 60)
                    <div class="">
                        <div class="text-center">
                            <h1 class="text-white">😐</h1>
                        </div>
                    </div>
                @else
                    <div class="">
                        <div class="text-center d-flex align-items-center justify-content-center ">
                            <h1 class="text-white fs-1">🙁</h1>
                        </div>
                    </div>
                @endif
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
                                <p class="px-2 border"><strong>10:</strong> {{ $responseCounts[10] ?? 0 }}</p>
                                <p class="px-2 border"><strong>9:</strong> {{ $responseCounts[9] ?? 0 }}</p>
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
                            <p  class="px-2 border"><strong>8:</strong> {{ $responseCounts[8] ?? 0 }}</p>
                            <p class="px-2 border"><strong>7:</strong> {{ $responseCounts[7] ?? 0 }}</p>
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
                                <p class="px-2 border">
                                    <strong>{{ $i }}:</strong> {{ $responseCounts[$i] ?? 0 }}</p>
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
                        <h5 class="text-success mb-0">{{  $promoterPercentage }}%</h5>
                        <p class="text-muted">of total responses</p>
                    </div>
                    <div class="card-footer bg-light">
                        <h5 class="text-center mb-0">Promoters Percentage</h5>
                </div>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="card border-danger">
                    <div class="card-body text-center">
                        <h5 class="text-danger mb-0">{{ $detractorPercentage }}%</h5>
                        <p class="text-muted">of total responses</p>
                    </div>
                    <div class="card-footer bg-light">
                        <h5 class="text-center mb-0">Detractors Percentage</h5>
                </div>
                </div>
               
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="mb-0" class="overallpercentage">{{ $nps }}%</h5>
                        <p class="text-muted">This is your NPS</p>
                    </div>
                    <div class="card-footer bg-light">
                        <h5 class="text-center mb-0">Overall NPS Percentage</h5>
                </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- <div class="d-flex justify-content-end mb-3">
        <button wire:click="downloadCSV" class="btn btn-success">Download as CSV</button>
    </div> -->

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


