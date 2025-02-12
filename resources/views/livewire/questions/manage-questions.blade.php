<div class="container mt-4">
    @if(session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if(!empty($remainingQuestions))
        <div class="card shadow-sm p-4">
            <h2 class="text-center text-primary">Add Remaining Questions</h2>
            <form wire:submit.prevent="addQuestions">
                <div class="row">
                    @foreach($remainingQuestions as $index)
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Question {{ $index }}</label>
                            <input type="text" class="form-control" wire:model="questions.{{ $index }}" placeholder="Enter question">
                        </div>
                    @endforeach
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Add Questions</button>
                </div>
            </form>
        </div>
    @endif

    <div class="card shadow-sm mt-4 p-4">
        <h2 class="text-center text-success">Questions List</h2>
        @if(!$questionList)
            <p class="text-center text-danger">No questions found.</p>
        @else
            <ul class="list-group">
                @foreach(range(1, 9) as $q)
                    @if(!empty($questionList['Q' . $q]))
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Q{{ $q }}:</strong> {{ $questionList['Q' . $q] }}</span>
                            <div>
                               
                                <button class="btn btn-sm btn-danger" wire:click="deleteQuestion({{ $questionList->id }}, {{ $q }})">Delete</button>
                            </div>
                        </li>
                        
                    @endif
                @endforeach
                
            </ul>
        @endif
    </div>

   

   
</div>
