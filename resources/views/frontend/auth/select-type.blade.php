@extends('frontend.layout.app')

@section('title', 'Select Account Type')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
  تفضل، هذا الكود المطور بالكامل مع الألوان النهائية (البيج والأخضر الصريح) وبدون أي بهتان في الزر عند الاختيار:

CSS
<style>
    /* تطبيق الخط الجديد واللون الأساسي للجسم */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #F8F7F2; /* اللون البيج المتطابق مع الصورة */
        color: #1A1A2E;
        margin: 0;
    }

    .auth-page {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background-color: #F8F7F2; /* تأكيد اللون في منطقة الصفحة */
    }

    .auth-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 16px;
        padding: 3rem 2.5rem;
        width: 100%;
        max-width: 460px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }

    .auth-logo { text-align: center; margin-bottom: 2rem; }
    .auth-logo span { font-size: 28px; font-weight: 700; color: #2D6A4F; }
    .auth-logo span b { color: #1A1A2E; }

    .auth-title { font-size: 24px; font-weight: 700; text-align: center; margin-bottom: 0.75rem; color: #1A1A2E; }
    .auth-subtitle { font-size: 14px; color: #7f8c8d; text-align: center; margin-bottom: 2.5rem; }

    .selection-container { display: flex; flex-direction: column; gap: 16px; }

    .type-option {
        display: flex;
        align-items: center;
        padding: 20px;
        border: 2px solid #eee;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        text-decoration: none;
        color: inherit;
        position: relative;
    }

    .type-option:hover {
        border-color: #a8d5c2;
        background-color: #fcfdfd;
        transform: translateY(-2px);
    }

    .type-icon {
        font-size: 24px;
        margin-right: 20px;
        color: #2D6A4F;
        width: 32px;
        text-align: center;
    }

    .type-info { flex-grow: 1; }
    .type-name { display: block; font-size: 16px; font-weight: 600; color: #1A1A2E; margin-bottom: 2px; }
    .type-desc { display: block; font-size: 13px; color: #888; line-height: 1.4; }

    .check-icon {
        display: none;
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #2D6A4F;
        font-size: 20px;
    }

    .type-option.active {
        border-color: #2D6A4F;
        background-color: #f0fdf4;
        box-shadow: 0 0 10px rgba(45, 106, 79, 0.1);
    }
    .type-option.active .check-icon { display: block; }

    /* تم تعديل الزر ليكون أخضر صريح وواضح 100% */
    .continue-btn {
        width: 100%;
        background: #2D6A4F !important; /* اللون الأخضر الأساسي */
        color: #ffffff !important; /* نص أبيض ناصع */
        border: none;
        padding: 14px;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 2rem;
        text-align: center;
        display: block;
        transition: all 0.3s ease;
        opacity: 0.5; /* سيبقى شفافاً قليلاً حتى تختار النوع (للمنطق البرمجي) */
        pointer-events: none;
    }

    /* هذا الستايل سيتم تفعيله عبر الـ JS بمجرد الضغط على خيار */
    .continue-btn.ready {
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    .continue-btn:hover {
        background: #245c43 !important;
    }

    .auth-footer { text-align: center; margin-top: 1.5rem; font-size: 14px; color: #888; }
    .auth-footer a { color: #2D6A4F; font-weight: 600; text-decoration: none; }
    .auth-footer a:hover { text-decoration: underline; }
</style>
@endsection

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">
            <span>Artisan<b>Hub</b></span>
        </div>

        <h2 class="auth-title">How would you like to join?</h2>
        <p class="auth-subtitle">Select your account type to continue</p>

        <div class="selection-container">
            <div class="type-option" onclick="selectType('artisan', this)">
                <div class="type-icon"><i class="fas fa-tools"></i></div>
                <div class="type-info">
                    <span class="type-name">Artisan</span>
                    <span class="type-desc">Showcase your skills and find rewarding work.</span>
                </div>
                <div class="check-icon"><i class="fas fa-check-circle"></i></div>
            </div>

            <div class="type-option" onclick="selectType('team', this)">
                <div class="type-icon"><i class="fas fa-users"></i></div>
                <div class="type-info">
                    <span class="type-name">Team</span>
                    <span class="type-desc">Manage your projects and collaborate effectively.</span>
                </div>
                <div class="check-icon"><i class="fas fa-check-circle"></i></div>
            </div>

            <div class="type-option" onclick="selectType('customer', this)">
                <div class="type-icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="type-info">
                    <span class="type-name">Customer</span>
                    <span class="type-desc">Find and hire the best experts for your needs.</span>
                </div>
                <div class="check-icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>

        <form id="selectionForm" action="{{ route('front.register') }}" method="GET">
            <input type="hidden" name="user_type" id="userTypeInput">
            <button type="submit" id="continueBtn" class="continue-btn">Continue</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('front.login') }}">Sign in</a>
        </div>
    </div>
</div>

<script>
   function selectType(type, element) {
    document.querySelectorAll('.type-option').forEach(opt => opt.classList.remove('active'));
    element.classList.add('active');

    document.getElementById('userTypeInput').value = type;
    const btn = document.getElementById('continueBtn');

    // إضافة كلاس ready لجعل اللون يظهر بوضوح 100%
    btn.classList.add('ready');
}
</script>
@endsection
