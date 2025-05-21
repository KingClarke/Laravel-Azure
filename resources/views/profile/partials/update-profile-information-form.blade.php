<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <input id="profile_picture" name="profile_picture" type="file" class="mt-1 block w-full text-gray-900 dark:text-white" accept="image/*" />
            @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="mt-2 w-20 h-20 rounded-full object-cover border border-gray-300 dark:border-gray-700">
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div>
            <x-input-label for="pronouns" :value="__('Pronouns')" />
            <x-text-input id="pronouns" name="pronouns" type="text" class="mt-1 block w-full" :value="old('pronouns', $user->pronouns)" autocomplete="pronouns" placeholder="e.g. she/her, he/him, they/them" />
            <x-input-error class="mt-2" :messages="$errors->get('pronouns')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-900 dark:text-white">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="birth_date" :value="__('Birth Date')" />
            @if(!$user->birth_date)
                <div class="flex gap-2">
                    <select id="birth_day" class="block w-1/4" required>
                        <option value="">Day</option>
                        @for($d = 1; $d <= 31; $d++)
                            <option value="{{ $d }}">{{ $d }}</option>
                        @endfor
                    </select>
                    <select id="birth_month" class="block w-1/4" required>
                        <option value="">Month</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                        @endfor
                    </select>
                    <select id="birth_year" class="block w-1/2" required>
                        <option value="">Year</option>
                        @for($y = date('Y')-10; $y >= date('Y')-100; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <input type="hidden" id="birth_date" name="birth_date" />
                <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        function updateBirthDate() {
                            const day = document.getElementById('birth_day').value;
                            const month = document.getElementById('birth_month').value;
                            const year = document.getElementById('birth_year').value;
                            const hidden = document.getElementById('birth_date');
                            if(day && month && year) {
                                hidden.value = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                            } else {
                                hidden.value = '';
                            }
                        }
                        document.getElementById('birth_day').addEventListener('change', updateBirthDate);
                        document.getElementById('birth_month').addEventListener('change', updateBirthDate);
                        document.getElementById('birth_year').addEventListener('change', updateBirthDate);
                    });
                </script>
            @else
                <x-text-input id="birth_date" name="birth_date" type="date" class="mt-1 block w-full" :value="$user->birth_date" disabled />
                <p class="text-xs text-gray-500 mt-1">Birth date can only be set once.</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
