<div class="modal fade congratulations-modal" id="congratulationsModal" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header-custom">
                <button type="button" class="close-btn-custom" data-bs-dismiss="modal" aria-label="Close">
                    ×
                </button>

                <div class="ksu-logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" class="logo">
                    <p class="ksu-logo-text">كليات العناية الطبية</p>
                    <p class="ksu-logo-text">Inaya Medical Colleges</p>
                </div>

                <div class="congratulations-icon">
                    <p class="congratulations-text">🎊 تهنئة 🎊</p>
                </div>
            </div>

            <div class="modal-body-custom">
                <p class="announcement-title">
                  يسر إدارة كليات العناية الطبية تهنئة كلاً من
                </p>

                <p class="doctor-name">
                     سعادة الدكتورة / عبير فرحان رشيد العنزي
                </p>
                <p class="doctor-name">
                    و سعادة الدكتورة / نسرين علي محمد شاوش
                </p>

                <p class="promotion-text">
                    بمناسبة تعيينهن على درجة أستاذ مساعد
                </p>

                <p class="wishes-text">
                    سائلين الله لهن دوام التوفيق والنجاح في مسيرتهم العلمية والمهنية
                </p>

                <p class="wishes-text">
                    مع اطيب التمنيات بمزيد من الانجازات والنجاحات
                </p>

                <div class="department-info">
                    <p class="department-name">
                        كليات العناية الطبية
                    </p>
                    <p class="department-english">
                        Inaya Medical Colleges.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    img {
        display: block;
        max-width: 500px;
        max-height: 750px;
        width: auto;
        height: auto;
    }

    #container {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

    .modal-backdrop.show {
        opacity: 0.8;
    }

    .congratulations-modal .modal-content {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #4a90e2 0%, #5ba3f5 50%, #a8d5ff 100%);
        padding: 40px 30px;
        position: relative;
        border: none;
    }

    .modal-header-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(120deg, transparent 48%, rgba(255, 255, 255, 0.1) 50%, transparent 52%),
            linear-gradient(240deg, transparent 48%, rgba(255, 255, 255, 0.05) 50%, transparent 52%);
    }

    .ksu-logo {
        position: absolute;
        top: 20px;
        left: 20px;
        background: white;
        padding: 10px 15px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }

    .ksu-logo-text {
        color: #0066cc;
        font-weight: 700;
        text-align: center;
        font-size: 14px;
        margin: 0;
        line-height: 1.2;
    }

    .ksu-logo-subtext {
        color: #666;
        font-size: 11px;
        margin: 0;
    }

    .congratulations-icon {
        text-align: center;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .logo {
        max-width: 100px;
        max-height: 100px;
        margin-right: auto;
        margin-left: auto;
        position: relative;
        z-index: 100;
        /* left: 45%; */
    }

    .congratulations-text {
        font-size: 48px;
        font-weight: 700;
        color: #0066cc;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        margin: 0;
        font-family: 'Cairo', sans-serif;
    }

    .modal-body-custom {
        padding: 40px;
        background: white;
        text-align: center;
    }

    .announcement-title {
        font-size: 22px;
        font-weight: 600;
        color: #0066cc;
        margin-bottom: 15px;
        line-height: 1.8;
        font-family: 'Cairo', sans-serif;
    }

    .doctor-name {
        font-size: 26px;
        font-weight: 700;
        color: #2c5aa0;
        margin: 20px 0;
        font-family: 'Cairo', sans-serif;
    }

    .promotion-text {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin-bottom: 30px;
        font-family: 'Cairo', sans-serif;
    }

    .wishes-text {
        font-size: 18px;
        color: #555;
        margin: 25px 0;
        font-weight: 500;
        font-family: 'Cairo', sans-serif;
    }

    .department-info {
        margin-top: 35px;
        padding-top: 25px;
        border-top: 2px solid #e0e0e0;
    }

    .department-name {
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }

    .department-english {
        font-size: 13px;
        color: #888;
        font-style: italic;
    }

    .close-btn-custom {
        position: absolute;
        top: 15px;
        right: 15px;
        background: white;
        border: none;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        font-size: 20px;
        color: #666;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: all 0.3s;
    }

    .close-btn-custom:hover {
        background: #f0f0f0;
        transform: rotate(90deg);
    }
</style>
</style>
