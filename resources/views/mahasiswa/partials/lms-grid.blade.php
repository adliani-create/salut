@if($items->count() > 0)
    <div class="row g-4">
        @foreach($items as $material)
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-up transition-base overflow-hidden rounded-4">
                    <!-- Thumbnail -->
                    <div class="position-relative bg-light" style="height: 160px;">
                        @if($material->thumbnail)
                            <img src="{{ asset('storage/' . $material->thumbnail) }}" class="w-100 h-100 object-fit-cover" alt="{{ $material->title }}">
                        @else
                            <!-- Fallback Icon if no thumbnail -->
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-secondary">
                                <i class="bi {{ $material->type == 'video' ? 'bi-play-circle' : 'bi-file-text' }}" style="font-size: 4rem; opacity: 0.3;"></i>
                            </div>
                        @endif
                        
                        <!-- Duration Badge -->
                        @if($material->duration)
                            <div class="position-absolute bottom-0 end-0 m-2">
                                <span class="badge bg-dark bg-opacity-75 backdrop-blur rounded-pill small">
                                    <i class="bi bi-clock me-1"></i> {{ $material->duration }}
                                </span>
                            </div>
                        @endif

                        <!-- Type Icon Top Left -->
                        <div class="position-absolute top-0 start-0 m-2">
                             @if($material->type == 'video')
                                <span class="badge bg-danger rounded-circle p-2 shadow-sm"><i class="bi bi-play-fill"></i></span>
                            @else
                                <span class="badge bg-primary rounded-circle p-2 shadow-sm"><i class="bi bi-file-earmark-text-fill"></i></span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body p-3 d-flex flex-column">
                        <h6 class="fw-bold mb-2 text-dark line-clamp-2" style="min-height: 40px;">{{ $material->title }}</h6>
                        
                        <!-- Progress Bar -->
                        <div class="mt-auto">
                            @php
                                $isCompleted = $material->completions->isNotEmpty();
                                $progress = $isCompleted ? 100 : 0;
                            @endphp
                            <div class="d-flex justify-content-between align-items-center small text-muted mb-1">
                                <span>Progress</span>
                                <span class="fw-bold {{ $isCompleted ? 'text-success' : 'text-primary' }}">{{ $progress }}%</span>
                            </div>
                            <div class="progress" style="height: 6px; border-radius: 5px;">
                                <div class="progress-bar {{ $isCompleted ? 'bg-success' : 'bg-primary' }}" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            
                            <!-- Link to Tracking Route -->
                            <a href="{{ route('student.lms.view', $material->id) }}" target="_blank" class="btn btn-sm {{ $isCompleted ? 'btn-outline-success' : 'btn-light' }} w-100 rounded-pill mt-3 fw-bold stretched-link">
                                @if($isCompleted)
                                    <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                @else
                                    {{ $material->type == 'video' ? 'Tonton Sekarang' : 'Baca Materi' }}
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
            <i class="bi bi-inbox fs-1 text-muted"></i>
        </div>
        <h6 class="fw-bold text-muted">Belum ada materi di kategori ini.</h6>
    </div>
@endif
