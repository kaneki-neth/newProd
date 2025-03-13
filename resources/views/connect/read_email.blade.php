<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" value="{{ $read->name }}" class="form-control form-control-sm" disabled>
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" value="{{ $read->email }}" class="form-control form-control-sm" disabled>
    </div>
    <div class="col-md-6">
        <label class="form-label">Purpose</label>
        <input type="text" value="{{ $read->purpose }}" class="text-uppercase form-control form-control-sm" disabled>
    </div>
    <div class="col-md-6">
        <label class="form-label">Date & Time</label>
        <input type="datetime-local" value="{{ $read->created_at }}" class="form-control form-control-sm" disabled>
    </div>
    <div class="col-12">
        <label class="form-label">Message</label>
        <textarea rows="10" style="width: 100%; background: #e9ecef;" disabled> {{$read->message}}</textarea>
    </div>
</div>