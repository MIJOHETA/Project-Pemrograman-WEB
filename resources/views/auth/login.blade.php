@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-[80vh]">
    <div class="glass-card p-8 rounded-3xl w-full max-w-md relative">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Login Admin</h2>
            <p class="text-sm text-gray-500">Masuk untuk mengelola laporan masuk.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-4 border border-red-100">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition" required>
            </div>
            <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition">
                Masuk Dashboard
            </button>
        </form>
    </div>
</div>
@endsection