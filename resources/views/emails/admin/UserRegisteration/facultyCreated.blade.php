Name: {{ $user->getFullEnglishNameAttribute }}
National ID: {{ $user->iqama($user->id) }}
Email: {{ $user->email }}
Mobile: {{ $user->mobile($user->id) }}