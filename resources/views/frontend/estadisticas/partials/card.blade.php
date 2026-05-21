<div class="card stats-card p-4 h-100 border-0 shadow-sm">
    <div class="d-flex justify-content-between align-items-center">
        <div class="flex-grow-1 me-3">
            <div class="stats-title mb-1 text-uppercase text-muted fw-bold tracking-wider" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                {{ $title }}
            </div>
            <div class="stats-value text-dark fw-bold mb-0" style="font-size: 1.85rem; letter-spacing: -0.03em;">
                {{ $value }}
            </div>
        </div>
        
        <div class="bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center p-3" 
             style="width: 56px; height: 56px; min-width: 56px;">
            <i class="{{ $icon }} fs-3"></i>
        </div>
    </div>
</div>