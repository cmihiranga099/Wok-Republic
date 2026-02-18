<x-frontend-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-white font-serif">Contact Us</h1>
                <p class="mt-4 text-lg text-gray-400">We'd love to hear from you. Get in touch with us.</p>
            </div>

            <div class="lg:flex lg:gap-12">
                <!-- Contact Form -->
                <div class="lg:w-1/2 mb-8 lg:mb-0">
                    <div class="bg-gray-800 rounded-lg p-8">
                        <h2 class="text-2xl font-bold text-white font-serif mb-6">Send Us a Message</h2>
                        <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label class="form-label-dark">Your Name *</label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="form-input-dark">
                            </div>
                            <div>
                                <label class="form-label-dark">Email Address *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required class="form-input-dark">
                            </div>
                            <div>
                                <label class="form-label-dark">Subject *</label>
                                <input type="text" name="subject" value="{{ old('subject') }}" required class="form-input-dark">
                            </div>
                            <div>
                                <label class="form-label-dark">Message *</label>
                                <textarea name="message" rows="5" required class="form-input-dark" placeholder="How can we help you?">{{ old('message') }}</textarea>
                            </div>
                            <button type="submit" class="btn-primary w-full text-center">Send Message</button>
                        </form>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="lg:w-1/2 space-y-6">
                    <div class="bg-gray-800 rounded-lg p-6 flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold mb-1">Address</h3>
                            <p class="text-gray-400">123 Wok Street, Chinatown<br>New York, NY 10013</p>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-lg p-6 flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold mb-1">Phone</h3>
                            <p class="text-gray-400">(555) 123-4567</p>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-lg p-6 flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold mb-1">Email</h3>
                            <p class="text-gray-400">info@wokrepublic.com</p>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-lg p-6 flex items-start space-x-4">
                        <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-white font-semibold mb-1">Opening Hours</h3>
                            <p class="text-gray-400">Mon-Thu: 11AM - 10PM<br>Fri-Sat: 11AM - 11PM<br>Sunday: 12PM - 9PM</p>
                        </div>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden h-48 flex items-center justify-center">
                        <div class="text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                            <p class="text-sm">Map integration coming soon</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
