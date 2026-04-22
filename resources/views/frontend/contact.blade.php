@extends('frontend.layout.app')

@section('title', 'Contact Us')

@section('styles')
<style>
    .contact-hero { background: #F8F6F2; padding: 4rem 2rem; text-align: center; border-bottom: 1px solid #eee; }
    .contact-hero h1 { font-size: 36px; font-weight: 700; margin-bottom: .5rem; }
    .contact-hero p { font-size: 14px; color: #888; }

    .page-body { max-width: 1000px; margin: 0 auto; padding: 3rem 2rem; }
    .contact-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 3rem; }

    /* Info */
    .info-card {background: #2D6A4F; border-radius: 20px; padding: 2.5rem; color: #fff; border-radius: 20px;}
    .info-title { font-size: 20px; font-weight: 700; margin-bottom: .5rem; }
    .info-sub { font-size: 13px; color: rgba(255,255,255,.6); margin-bottom: 2rem; line-height: 1.6; }
    .info-item { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.5rem; }
    .info-icon { width: 40px; height: 40px;  background: rgba(255,255,255,.15); color: #fff;border-radius: 10px; display: flex; align-items: center; justify-content: center;  flex-shrink: 0; }
    .info-label { font-size: 11px; color: rgba(255,255,255,.5); margin-bottom: 3px; }
    .info-value { font-size: 14px; font-weight: 500; }

    /* Form */
    .form-card { background: #fff; border: 1px solid #eee; border-radius: 20px; padding: 2.5rem; }
    .form-title { font-size: 20px; font-weight: 700; margin-bottom: 1.5rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #555; margin-bottom: 6px; }
    .form-control { width: 100%; padding: 10px 14px; border: 1px solid #eee; border-radius: 10px; font-size: 14px; outline: none; font-family: inherit; }
    .form-control:focus { border-color: #2D6A4F; }
    textarea.form-control { resize: vertical; min-height: 120px; }
    .btn-send { width: 100%; background: #2D6A4F; color: #fff; border: none; padding: 14px; border-radius: 50px; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: .5rem; }
    .btn-send:hover { background: #245c43; }
</style>
@endsection

@section('content')

<div class="contact-hero">
    <h1>Get in Touch</h1>
    <p>We'd love to hear from you. Send us a message and we'll get back to you shortly.</p>
</div>

<div class="page-body">
    <div class="contact-grid">

        {{-- Info --}}
        <div class="info-card">
            <div class="info-title">Contact Information</div>
            <div class="info-sub">Fill out the form and our team will get back to you within 24 hours.</div>

            <div class="info-item">
                <div class="info-icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <div class="info-label">Email</div>
                    <div class="info-value">hello@artisanhub.com</div>
                </div>
            </div>
            <div class="info-item">
                <div class="info-icon"><i class="fas fa-phone"></i></div>
                <div>
                    <div class="info-label">Phone</div>
                    <div class="info-value">+970 59 000 0000</div>
                </div>
            </div>
            <div class="info-item">
                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <div class="info-label">Location</div>
                    <div class="info-value">Palestine</div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="form-card">
            <div class="form-title">Send us a Message</div>
            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" placeholder="John">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" placeholder="Doe">
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="john@example.com">
            </div>
            <div class="form-group">
                <label>Subject</label>
                <input type="text" class="form-control" placeholder="How can we help?">
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea class="form-control" placeholder="Write your message here..."></textarea>
            </div>
            <button class="btn-send">
                <i class="fas fa-paper-plane"></i> Send Message
            </button>
        </div>

    </div>
</div>

@endsection
