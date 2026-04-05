<x-front-layout title="{{ __('Contact Us') }}">
    @push('styles')
        <style>
            .contact-shell {
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 24%, #f8fafc 100%);
            }

            .contact-hero {
                padding: 24px 0 14px;
            }

            .contact-hero p {
                color: #667085;
                max-width: 720px;
                margin-bottom: 0;
            }

            .contact-card,
            .single-info-head {
                background: #fff;
                border: 1px solid #e8eef7;
                border-radius: 24px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
            }

            .single-info-head,
            .contact-form-head {
                padding: 24px;
            }

            .single-info {
                padding: 0;
                border: 0;
                margin-bottom: 22px;
            }

            .single-info:last-child {
                margin-bottom: 0;
            }

            .contact-form-head {
                background: #fff;
                border: 1px solid #e8eef7;
                border-radius: 24px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
            }

            .contact-form-head .form-group input,
            .contact-form-head .form-group textarea {
                border: 1px solid #d6e3f2;
                border-radius: 14px;
                box-shadow: none;
            }

            .contact-form-head .form-group input {
                height: 50px;
            }

            .contact-form-head .form-group textarea {
                min-height: 160px;
            }

            .contact-form-head .btn {
                border-radius: 999px;
                min-width: 190px;
            }
        </style>
    @endpush

    <section id="contact-us" class="contact-us section contact-shell">
        <div class="container">
            <div class="contact-hero">
                <h1>{{ __('Contact Us') }}</h1>
                <p>{{ __('Reach out for product questions, order help, or general support. We keep communication clear, fast, and customer-focused.') }}</p>
            </div>

            <div class="contact-head">
                <div class="row">
                    <x-alert type="success" />
                </div>
                <div class="contact-info">
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-12 col-12">
                            <div class="single-info-head">
                                <div class="single-info">
                                    <i class="lni lni-map"></i>
                                    <h3>{{ __('Address') }}</h3>
                                    <ul>
                                        <li>{{ __('1201 Digital Avenue, Washington, DC 20001') }}<br>{{ __('United States') }}</li>
                                    </ul>
                                </div>
                                <div class="single-info">
                                    <i class="lni lni-phone"></i>
                                    <h3>{{ __('Call us') }}</h3>
                                    <ul>
                                        <li><a href="tel:{{ $settings->phone }}">{{ $settings->phone }} ({{ __('Toll free') }})</a>
                                        </li>
                                        <li><a href="tel:+12025550199">+1 202 555 0199</a></li>
                                    </ul>
                                </div>
                                <div class="single-info">
                                    <i class="lni lni-envelope"></i>
                                    <h3>{{ __('Email communication') }}</h3>
                                    <ul>
                                        <li><a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
                                        </li>
                                        <li><a href="mailto:support@digital-hub.test">support@digital-hub.test</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-12 col-12">
                            <div class="contact-form-head">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <h3>An error occurred.</h3>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-main">
                                    <form class="form" method="POST" action="{{ route('contact.send') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <input name="name" type="text"
                                                        placeholder="{{ __('Your Name') }}" required="required">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <input name="subject" type="text"
                                                        placeholder="{{ __('Your Subject') }}" required="required">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <input name="email" type="email"
                                                        placeholder="{{ __('Your Email') }}" required="required">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <input name="phone" type="text"
                                                        placeholder="{{ __('Your Phone') }}" required="required">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group message">
                                                    <textarea name="message" placeholder="{{ __('Your Message') }}"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group button">
                                                    <button type="submit"
                                                        class="btn">{{ __('Submit Message') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Contact Area -->

</x-front-layout>

