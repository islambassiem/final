@extends('layout.master')

@section('title')
  {{ __('faq.faq') }}
@endsection

@section('style')
  <style>
    .accordion-body{
      text-align: justify;
      line-height: 1.5;
      font-size: 1rem;
    }
  </style>
@endsection

@section('h1')
  {{ __('faq.faq') }}
@endsection

@section('breadcrumb')
  {{ __('faq.faq') }}
@endsection

@section('content')

  <section class="section">
    <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"> {{ __('faq.FAQ') }} </h5>
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    {{ __('faq.q1') }}
                  </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">{{ session('_lang') == '_en' ? include 'faqs/en/question1.txt' : include 'faqs/ar/question1.txt' }}</div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    {{ __('faq.q2') }}
                  </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">{{ session('_lang') == '_en' ? include 'faqs/en/question2.txt' : include 'faqs/ar/question2.txt' }}</div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    {{ __('faq.q3') }}
                  </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">{{ session('_lang') == '_en' ? include 'faqs/en/question3.txt' : include 'faqs/ar/question3.txt' }}</div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFour">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                    {{ __('faq.q4') }}
                  </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">{{ session('_lang') == '_en' ? include 'faqs/en/question4.txt' : include 'faqs/ar/question4.txt' }}</div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFive">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                    {{ __('faq.q5') }}
                  </button>
                </h2>
                <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">{{ session('_lang') == '_en' ? include 'faqs/en/question5.txt' : include 'faqs/ar/question5.txt' }}</div>
                </div>
              </div>
            <!-- Accordion Ends here -->
          </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@section('script')
@endsection