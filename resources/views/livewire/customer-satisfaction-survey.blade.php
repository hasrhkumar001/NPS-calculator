<div class="card">
        <div class="card-header  bg-primary text-white">
            <h2 class="mb-0 container p-5 display-3 text-center">Customer Satisfaction Survey</h2>
        </div>
        <div class="container mt-4">
    
        <div class="card-body">
            <p class="text-center">Welcome {{ auth()->user()->name }}</p>

            <form wire:submit.prevent="submit">
                @csrf
                <div class="row mb-3">
                <div class="col-md-6">
                    <label for="idsGroup" class="form-label">IDS Group</label>
                    <select wire:model="idsGroup" id="idsGroup" class="form-select">
                        <option value="">Select IDS Group</option>
                        @foreach($idsGroups as $group)
                            <option value="{{ $group->name }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" wire:model="date" id="date" class="form-control" disabled>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="projectName" class="form-label">Project Name</label>
                        <input type="text" wire:model="projectName" id="projectName" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="csatOccurrence" class="form-label">CSAT Occurrence</label>
                        <select wire:model="csatOccurrence" id="csatOccurrence" class="form-select">
                            <option value="">Select</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Quaterly">Quaterly</option>
                            <option value="Yearly">Yearly</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="idsLeadManager" class="form-label">IDS Lead/Manager</label>
                        <input type="text" wire:model="idsLeadManager" id="idsLeadManager" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="clientOrganization" class="form-label">Client Organization</label>
                        <input type="text" wire:model="clientOrganization" id="clientOrganization" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="clientContactName" class="form-label">Client Contact Name</label>
                        <input type="text" wire:model="clientContactName" id="clientContactName" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="clientEmailAddress" class="form-label">Client Email Address</label>
                        <input type="email" wire:model="clientEmailAddress" id="clientEmailAddress" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="emailContent" class="form-label">Email Content</label>
                    <textarea wire:model="emailContent" id="emailContent" class="form-control" rows="4" disabled></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>