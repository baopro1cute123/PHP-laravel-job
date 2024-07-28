@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">EditJob</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">JOBS/EDIT</h3>
                            </div>
                            <div style="margin-top: -10px;"></div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" id="editJobForm" name="editJobForm">
                    @csrf
                    @method('PUT')
                    @include('front.message')
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">EDIT JOBS</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="title" class="mb-2">Title<span class="req">*</span></label>
                                    <input value="{{ $job->title }}" type="text" placeholder="Job Title" id="title" name="title" class="form-control">
                                    <p></p>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="category" class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Choose Category</option>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option {{ $job->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="jobType" class="mb-2">Job Nature<span class="req">*</span></label>
                                    <select name="jobType" id="jobType" class="form-select">
                                        <option value="">Choose Job</option>
                                        @if ($jobTypes->isNotEmpty())
                                            @foreach ($jobTypes as $jobType)
                                                <option {{ $job->job_type_id == $jobType->id ? 'selected' : '' }} value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="vacancy" class="mb-2">Vacancy<span class="req">*</span></label>
                                    <input value="{{ $job->vacancy }}" type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="salary" class="mb-2">Salary</label>
                                    <input value="{{ $job->salary }}" type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label for="location" class="mb-2">Location<span class="req">*</span></label>
                                    <input value="{{ $job->location }}" type="text" placeholder="Location" id="location" name="location" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <div class="mb-4 form-check">
                                        <input {{ ($job->isFeatured == 1) ? 'checked' : '' }} class="form-check-input" type="checkbox" value="1" id="isFeatured" name="isFeatured">
                                        <label for="isFeatured" class="form-check-label">Featured</label>
                                        <p></p>
                                    </div>
                                    
                                </div>
                                <div class="mb-4 col-md-6">
                                    <div class="mb-4 form-check-inline">
                                        <input {{ ($job->status == 1) ? 'checked' : '' }} class="form-check-input" type="radio" value="1" id="status-active" name="status">
                                        <label for="status" class="form-check-label">Active</label>
                                    </div>
                                    <div class="mb-4 form-check-inline">
                                        <input {{ ($job->status == 0) ? 'checked' : '' }} class="form-check-input" type="radio" value="0" id="status-block" name="status">
                                        <label for="status" class="form-check-label">Block</label>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="mb-4">
                                <label for="description" class="mb-2">Description<span class="req">*</span></label>
                                <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ $job->description }}</textarea>
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="benefits" class="mb-2">Benefits</label>
                                <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="responsibility" class="mb-2">Responsibility</label>
                                <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="qualifications" class="mb-2">Qualifications</label>
                                <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ $job->qualification }}</textarea>
                            </div>
                            <div class="mb-4">
                                <label for="experience" class="mb-2">Experience<span class="req">*</span></label>
                                <select name="experience" id="experience" class="form-control">
                                    <option value="1" {{ $job->experience == 1 ? 'selected' : '' }}>1 Year</option>
                                    <option value="2" {{ $job->experience == 2 ? 'selected' : '' }}>2 Years</option>
                                    <option value="3" {{ $job->experience == 3 ? 'selected' : '' }}>3 Years</option>
                                    <option value="4" {{ $job->experience == 4 ? 'selected' : '' }}>4 Years</option>
                                    <option value="5" {{ $job->experience == 5 ? 'selected' : '' }}>5 Years</option>
                                    <option value="6" {{ $job->experience == 6 ? 'selected' : '' }}>6 Years</option>
                                    <option value="7" {{ $job->experience == 7 ? 'selected' : '' }}>7 Years</option>
                                    <option value="8" {{ $job->experience == 8 ? 'selected' : '' }}>8 Years</option>
                                    <option value="9" {{ $job->experience == 9 ? 'selected' : '' }}>9 Years</option>
                                    <option value="10" {{ $job->experience == 10 ? 'selected' : '' }}>10 Years</option>
                                    <option value="10+" {{ $job->experience == '10+' ? 'selected' : '' }}>10+ Years</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="keywords" class="mb-2">Keywords</label>
                                <input value="{{ $job->keyword }}" type="text" placeholder="Keywords" id="keywords" name="keywords" class="form-control">
                            </div>
                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="company_name" class="mb-2">Name<span class="req">*</span></label>
                                    <input value="{{ $job->company_name }}" type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label for="company_location" class="mb-2">Location</label>
                                    <input value="{{ $job->company_location }}" type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="company_website" class="mb-2">Website</label>
                                <input value="{{ $job->company_website }}" type="text" placeholder="Website" id="company_website" name="company_website" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Update Job</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script type="text/javascript">
    function deleteUser(id) {
        if (confirm("Are you sure you want to delete?")) {
            $.ajax({
                url: '{{ route("admin.users.destroy") }}',
                type: 'DELETE',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        window.location.href = "{{ route('admin.jobs') }}";
                    } else {
                        alert('Error deleting user: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
    }

    $("#editJobForm").submit(function(e){
        e.preventDefault();
        $("button[type='submit']").prop('disabled', true);
        $.ajax({
            url: '{{ route('admin.jobs.update', $job->id) }}',
            type: 'PUT',
            dataType: 'json',
            data: $('#editJobForm').serialize(),
            success: function(response){
                $("button[type='submit']").prop('disabled', false);
                if(response.status) {
                    window.location.href = "{{ route('admin.jobs') }}";
                } else {
                    var errors = response.errors;
                    handleErrors(errors, 'title');
                    handleErrors(errors, 'vacancy');
                    handleErrors(errors, 'company_name');
                    handleErrors(errors, 'description');
                    handleErrors(errors, 'location');
                    handleErrors(errors, 'category');
                    handleErrors(errors, 'jobType');
                }
            }
        });
    });

    function handleErrors(errors, field) {
        if (errors[field]) {
            $("#" + field).addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors[field]);
        } else {
            $("#" + field).removeClass('is-invalid')
                .siblings('p')
                .removeClass('invalid-feedback')
                .html('');
        }
    }
</script>
@endsection
