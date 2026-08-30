<div class="gigw-accessibility-bar bg-dark text-light py-1 border-bottom border-secondary overflow-hidden" role="region" aria-label="Accessibility Controls">
    <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap gap-1 gap-sm-2 text-xs">
        <!-- Skip to content -->
        <div class="d-flex align-items-center gap-1 gap-sm-2">
            <a href="#main-content" class="skip-to-content text-decoration-none btn btn-sm btn-outline-warning py-1 px-2 fw-semibold" style="font-size: 0.75rem;">
                <i class="bi bi-box-arrow-in-down"></i> <span class="d-none d-sm-inline">Skip to </span>Content
            </a>
            <span class="d-none d-lg-inline text-muted">|</span>
            <span class="d-none d-lg-inline text-light-50 small">
                <i class="bi bi-shield-check text-success"></i> GIGW 3.0 & WCAG 2.1 AA
            </span>
        </div>

        <!-- Accessibility Tools -->
        <div class="d-flex align-items-center gap-1 gap-sm-2 flex-wrap ms-auto">
            <!-- Text Resizer -->
            <div class="btn-group btn-group-sm" role="group" aria-label="Text Size Controls">
                <button type="button" class="btn btn-outline-light py-1 px-2" id="font-decrease" title="Decrease Font Size" aria-label="Decrease text size">A-</button>
                <button type="button" class="btn btn-outline-light py-1 px-2 active" id="font-reset" title="Normal Font Size" aria-label="Reset text size">A</button>
                <button type="button" class="btn btn-outline-light py-1 px-2" id="font-increase" title="Increase Font Size" aria-label="Increase text size">A+</button>
            </div>

            <!-- Theme / Contrast Switcher -->
            <div class="btn-group btn-group-sm" role="group" aria-label="Contrast Themes">
                <button type="button" class="btn btn-outline-light py-1 px-2" id="theme-default" title="Default Theme" aria-label="Standard Light Mode">
                    <i class="bi bi-sun-fill text-warning"></i> <span class="d-none d-md-inline">Light</span>
                </button>
                <button type="button" class="btn btn-outline-light py-1 px-2" id="theme-dark" title="Dark Theme" aria-label="Dark Mode">
                    <i class="bi bi-moon-stars-fill text-info"></i> <span class="d-none d-md-inline">Dark</span>
                </button>
                <button type="button" class="btn btn-outline-warning py-1 px-2" id="theme-high-contrast" title="High Contrast Mode" aria-label="High Contrast Yellow on Black">
                    <i class="bi bi-circle-half"></i> <span class="d-none d-sm-inline">Contrast</span>
                </button>
            </div>

            <!-- Screen Reader Help -->
            <a href="{{ route('page.show', 'accessibility') }}" class="btn btn-sm btn-outline-info py-1 px-2 d-none d-sm-inline-flex align-items-center gap-1" title="Accessibility Statement" aria-label="Read accessibility guidelines">
                <i class="bi bi-universal-access"></i> <span class="d-none d-md-inline">Accessibility</span>
            </a>
        </div>
    </div>
</div>
