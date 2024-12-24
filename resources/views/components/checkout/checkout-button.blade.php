<div class="d-flex flex-row align-items-center justify-content-center gap-3">
    <a href="https://wa.me/6282150709185" target="blank" class="btn btn-light d-inline-flex rounded-pill border border-black shadow">
        <i class="bi bi-whatsapp me-2" style="color: #25D366;"></i>WhatsApp
    </a>
    <button type="submit" class="btn btn-success text-transform-uppercase"
        id="{{ $navigateTo === 'pay_now' ? 'pay-button' : '' }}">
        {{ __('checkout.button.' . $navigateTo) }}
    </button>
</div>
