<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Registration Form') }}</title>

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body{
            background-color: #004274;
        }
    </style>

</head>

<body>

<form action="{{ route('registrations.store') }}" method="POST">
    @csrf

    <div class="grid place-items-center min-h-screen">

        @if (Session::get('error'))
            <div class="bg-rose-200 w-full p-4 m-4 text-rose-600">
                <strong class="text-rose-800">Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    <p>{{ Session::get('error') }}</p>
                </ul>
            </div>
        @endif

        @if ($message = Session::get('success'))
            <div class="bg-green-200 w-full p-4 m-4 text-green-600">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="block justify-center items-center bg-white shadow-lg rounded-lg
                w-10/12 mx-w-5xl grid lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1 m-8 gap-2">

                <div class="py-10 px-10">
                    <h1 class="text-4xl uppercase mb-4">Personal Details</h1>
                    <p class="text-sm">Student Name <span class="text-red-900 text-2xl">*</span></p>
                    <input type="text" placeholder="Student Name" required name="student_name"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg">

                    <p class="text-sm">Gender <span class="text-red-900 text-2xl">*</span></p>
                    <div class="flex">
                        <input type="radio" required name="gender" value="male"
                               class="w-full p-4 mt-2">
                        <span>Male</span>
                        <input type="radio" required name="gender" value="female"
                               class="w-full p-4 mt-2">
                        <span>Female</span>
                    </div>

                    <p class="text-sm">Date of birth <span class="text-red-900 text-2xl">*</span></p>
                    <input type="date" placeholder="Date of birth" required name="dob"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Religion <span class="text-red-900 text-2xl">*</span></p>
                    <input type="text" placeholder="Religion" required name="religion"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Cast <span class="text-red-900 text-2xl">*</span></p>
                    <input type="text" placeholder="Cast" required name="cast"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Blood Group </p>
                    <input type="text" placeholder="Blood Group" name="blood_group"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Phone <span class="text-red-900 text-2xl">*</span></p>
                    <input type="text" placeholder="Phone" required name="phone"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Email <span class="text-red-900 text-2xl">*</span></p>
                    <input type="email" placeholder="Email" required name="email"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Address <span class="text-red-900 text-2xl">*</span></p>
                    <input type="text" placeholder="Address" required name="address"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">City <span class="text-red-900 text-2xl">*</span></p>
                    <input type="text" placeholder="City" required name="city"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">State / Province <span class="text-red-900 text-2xl">*</span></p>
                    <input type="text" placeholder="State / Province" required name="state"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Country <span class="text-red-900 text-2xl">*</span></p>
                    <input type="text" placeholder="Country" required name="country"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Extra Note / Detail</p>
                    <textarea name="extra_note" id="" cols="30" rows="10"
                              class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2"></textarea>
                </div>

                <div class="bg-lime-200 h-full p-10">
                    <h1 class="text-3xl uppercase mb-4">Parents Details</h1>

                    <p class="text-sm">Father Name <span class="text-red-900 text-2xl">*</span></p>
                    <input type="text" placeholder="Father Name" required name="father_name"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Father Phone </p>
                    <input type="text" placeholder="Father Phone" name="father_phone"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Father Occupation </p>
                    <input type="text" placeholder="Father Occupation" name="father_occ"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Mother Name <span class="text-red-900 text-2xl">*</span></p>
                    <input type="text" placeholder="Mother Name" required name="mother_name"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Mother Phone</p>
                    <input type="text" placeholder="Mother Phone" name="mother_phone"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <p class="text-sm">Mother Occupation</p>
                    <input type="text" placeholder="Mother Occupation" name="mother_occ"
                           class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">

                    <h1 class="text-3xl uppercase mb-4 mt-4">Admission Details</h1>
                    <p class="text-sm">Select Class <span class="text-red-900 text-2xl">*</span></p>
                    <select name="class_name" required
                            class="w-full p-4 mt-2 border border-gray-300 rounded-lg focus:shadow-lg mb-2">
                        <option value="">Select Class</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                        @endforeach
                    </select>

                    <div class="flex justify-end mt-8">
                        <button type="submit" class="bg-blue-900 p-4 text-white
                        rounded-lg shadow-lg text-xl tracking-widest hover:bg-blue-800">SUBMIT</button>
                    </div>
                </div>

        </div>
    </div>
</form>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    const colors = require('tailwindcss/colors')
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    blue: colors.blue,
                    rose: colors.rose,
                    red: colors.red,
                    yellow: colors.yellow,
                    teal:colors.teal,
                    amber:colors.amber,
                    green:colors.green,
                    lime:colors.lime,
                    gray:colors.gray,
                    emerald:colors.emerald,
                }
            }
        }
    }
</script>
</body>
</html>
