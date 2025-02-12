<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey 2</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
            /* Hide the radio inputs */
            input[type=radio] {
                position: absolute;
                visibility: hidden;
            }

            /* Style the labels */
            .radio-label {
                display: inline-block;
                cursor: pointer;
                padding: 10px 20px;
                color: white;
                font-weight: bold;
                text-align: center;
                transition: background-color 0.3s, color 0.3s;
            }

            /* Style for outer labels (if used for wrapping radio buttons) */
            .outer-label {
                cursor: default;
                padding: 0;
                background-color: transparent;
                border: none;
            }

            /* Colors for the radio labels based on index */
            .radio-label:nth-of-type(1),
            .radio-label:nth-of-type(2),
            .radio-label:nth-of-type(3) {
                background-color: #e40000; /* Red for 0, 1, 2 */
            }

            .radio-label:nth-of-type(4),
            .radio-label:nth-of-type(5),
            .radio-label:nth-of-type(6),
            .radio-label:nth-of-type(7) {
                background-color: #ff7a00; /* Orange for 3, 4, 5 */
            }

            
            .radio-label:nth-of-type(8),
            .radio-label:nth-of-type(9) {
                background-color: #ffd400; /* Yellow for 6, 7, 8 */
            }

            .radio-label:nth-of-type(10),
            .radio-label:nth-of-type(11) {
                background-color: #80b918; /* Green for 9, 10 */
            }

            .radio-label:nth-of-type(12) {
                background-color: #6c757d; /* Gray for NA */
            }

            /* Add a class for the checked label */
            input[type=radio]:checked + label {
                background-color: rgba(3, 2, 0, 0.6);
                color: black;
            }

            /* Add a little border between the labels */
            .radio-label + .radio-label {
                border-left: 1px solid #fff;
            }

            /* Responsive container for radio buttons */
            .radio-group {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }

            /* Labels inside the radio group should be equally distributed */
            .radio-group .radio-label {
                flex: 1;
                text-align: center;
            }

            /* Customize card header */
            .card-header {
                background-color: #007bff;
                color: white;
            }
        </style>
                                                                
</head>
<body>
<div class="card">
        <div class="card-header p-5  ">
            <h2 class="mb-0 container display-3 text-center">Customer Satisfaction Survey</h2>
        </div>
<div class="container mt-4">
    
        <div class="card-body">
            <form wire:submit.prevent="submit" wire:confirm="Are you sure you want to submit this? ">

                <div class="mb-4">
                    <div class="row">

                        <p class="col"><strong>Client Organization:</strong> {{ $submissionDetails->clientOrganization }}</p>
                        <p class="col"><strong>Project Name:</strong> {{ $submissionDetails->projectName }}</p>
                    </div>
                    <div class="row">
                        <p class="col"><strong>Client Contact Name:</strong> {{ $submissionDetails->clientContactName }}</p>
                        <p class="col"><strong>IDS Lead Manager:</strong> {{ $submissionDetails->idsLeadManager }}</p>
                    </div>
                    <p><strong>Date:</strong> {{ $submissionDetails->created_at->format('F j, Y') }}</p>
                </div>
                <hr>

                <h4 >Please rate us on our services/offerings/products such as:</h4>
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @for ($i = 1; $i <= 9; $i++)
                    @if(isset($questions[$i]))
                    <div class="mb-3 mt-5">
                        <label class="form-label outer-label">{{ $questions[$i] }}</label>
                        <div class="radio-group">
                            @for ($j = 0; $j <= 10; $j++)
                                <input type="radio" id="question{{ $i }}_{{ $j }}" wire:model="responses.{{ $i }}" value="{{ $j }}">
                                <label class="radio-label" for="question{{ $i }}_{{ $j }}">{{ $j }}</label>
                            @endfor
                            <input type="radio" id="question{{ $i }}_na" wire:model="responses.{{ $i }}" value="Na">
                            <label class="radio-label" for="question{{ $i }}_na">N/A</label>
                        </div>
                        @error('responses.' . $i) <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    @endif
                @endfor

                
                <div class="mb-3">
                    <label class="form-label outer-label">Additional Comments</label>
                    <div class="">
                        <textarea wire:model="additionalComment" class="w-100"></textarea>
                        
                    </div>
                    
                </div>

                <!-- Submit Button -->
                <button type="submit"  class="btn btn-primary px-3 py-2 ">Submit</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS (Optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // jQuery to handle adding/removing the 'checked' class
    $(document).ready(function() {
        $('input[type=radio]').change(function() {
            // Remove 'checked' class from all labels within the same group
            $(this).closest('.radio-group').find('label').removeClass('checked');
            // Add 'checked' class to the label for the selected radio button
            $(this).next('label').addClass('checked');
        });
    });
</script>

</body>
</html>
