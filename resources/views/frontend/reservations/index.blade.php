<x-frontend-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-white font-serif">Reserve a Table</h1>
                <p class="mt-4 text-lg text-gray-400">Book your dining experience at Wok Republic</p>
            </div>

            <div class="lg:flex lg:gap-12">
                <!-- Left: Atmosphere -->
                <div class="lg:w-1/2 mb-8 lg:mb-0">
                    <div class="relative rounded-lg overflow-hidden mb-8">
                        <img src="https://via.placeholder.com/800x500/1f2937/6b7280?text=Restaurant+Interior" alt="Restaurant Interior" class="w-full h-80 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                        <div class="absolute bottom-6 left-6">
                            <h2 class="text-2xl font-bold text-white font-serif">An Unforgettable Experience</h2>
                            <p class="text-gray-300 mt-2">Join us for an evening of authentic Asian flavors in our warm and inviting atmosphere.</p>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-white font-serif mb-4">Opening Hours</h3>
                        <ul class="space-y-3 text-gray-400">
                            <li class="flex justify-between"><span>Monday - Thursday</span><span class="text-white">11:00 AM - 10:00 PM</span></li>
                            <li class="flex justify-between"><span>Friday - Saturday</span><span class="text-white">11:00 AM - 11:00 PM</span></li>
                            <li class="flex justify-between"><span>Sunday</span><span class="text-white">12:00 PM - 9:00 PM</span></li>
                        </ul>
                        <p class="mt-4 text-sm text-gray-500">For parties larger than 20, please call us directly at (555) 123-4567.</p>
                    </div>
                </div>

                <!-- Right: Reservation Form -->
                <div class="lg:w-1/2">
                    <div class="bg-gray-800 rounded-lg p-8">
                        <h2 class="text-2xl font-bold text-white font-serif mb-6">Book Your Table</h2>
                        <form action="{{ route('reservations.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label class="form-label-dark">Full Name *</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required class="form-input-dark">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="form-label-dark">Email *</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="form-input-dark">
                                </div>
                                <div>
                                    <label class="form-label-dark">Phone *</label>
                                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required class="form-input-dark">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="form-label-dark">Date & Time *</label>
                                    <input type="datetime-local" name="reservation_date" value="{{ old('reservation_date') }}" required class="form-input-dark">
                                </div>
                                <div>
                                    <label class="form-label-dark">Number of Guests *</label>
                                    <select name="number_of_guests" required class="form-input-dark">
                                        @for($i = 1; $i <= 20; $i++)
                                            <option value="{{ $i }}" {{ old('number_of_guests') == $i ? 'selected' : '' }}>
                                                {{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="form-label-dark">Special Requests</label>
                                <textarea name="notes" rows="3" class="form-input-dark" placeholder="Any dietary requirements, allergies, or special occasions?">{{ old('notes') }}</textarea>
                            </div>
                            <button type="submit" class="btn-primary w-full text-center">Submit Reservation</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
